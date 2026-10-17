<?php
/**
 * ===================================
 * ACCOUNTS ACTION HANDLER
 * Manages user profile and password updates
 * ===================================
 */
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once 'config.php';
include 'reward_helper.php';

if (!$conn || $conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.'], JSON_UNESCAPED_UNICODE);
    exit;
}

$userId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;

if ($userId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Please log in to update your account.', 'logged_in' => false]);
    exit;
}

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

function sendResponse($data) {
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

// ==================== REWARD REDEMPTION ====================
if ($action === 'redeem_reward') {
    $rewardId = isset($_POST['reward_id']) ? trim($_POST['reward_id']) : '';
    
    if (empty($rewardId)) {
        sendResponse(['success' => false, 'message' => 'Invalid reward ID']);
    }
    
    $result = redeemReward($conn, $userId, $rewardId);
    sendResponse($result);
}

// ==================== PROFILE MANAGEMENT ====================

function prepareStatement($conn, $query) {
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception('Database prepare error: ' . $conn->error);
    }
    return $stmt;
}

function executeStatement($stmt) {
    if (!$stmt->execute()) {
        throw new Exception('Database execute error: ' . $stmt->error);
    }
}

function columnExists($conn, $tableName, $columnName) {
    $stmt = prepareStatement(
        $conn,
        'SELECT 1
         FROM information_schema.COLUMNS
         WHERE TABLE_SCHEMA = DATABASE()
           AND TABLE_NAME = ?
           AND COLUMN_NAME = ?
         LIMIT 1'
    );
    $stmt->bind_param('ss', $tableName, $columnName);
    executeStatement($stmt);
    $result = $stmt->get_result();
    $exists = $result && $result->num_rows > 0;
    $stmt->close();
    return $exists;
}

function getPasswordColumn($conn) {
    if (columnExists($conn, 'users', 'password_hash')) {
        return 'password_hash';
    }
    if (columnExists($conn, 'users', 'password')) {
        return 'password';
    }
    return '';
}

function verifyStoredPassword($plainPassword, $storedPassword) {
    if (password_verify($plainPassword, $storedPassword)) {
        return true;
    }

    $info = password_get_info($storedPassword);
    if (($info['algo'] ?? 0) === 0 && hash_equals((string) $storedPassword, (string) $plainPassword)) {
        return true;
    }

    return false;
}

function isOrderEditableStatus($status) {
    return in_array(strtolower((string) $status), ['pending', 'paid'], true);
}

function getActiveOrderStatuses() {
    return ['pending', 'paid', 'shipped'];
}

function getRewardOrderStatuses() {
    return ['paid', 'shipped', 'delivered', 'completed', 'arrived'];
}

function getStatusSqlList($statuses) {
    return "'" . implode("','", array_map('strtolower', $statuses)) . "'";
}

function calculateAccountOrderPoints($amount) {
    return calculatePointsFromAmount($amount);
}

if ($action === 'update_profile') {
    $firstName = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
    $lastName = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $newPassword = isset($_POST['new_password']) ? $_POST['new_password'] : '';

    // Validation
    if (empty($username)) {
        sendResponse(['success' => false, 'message' => 'Username is required.']);
    }
    if (empty($email)) {
        sendResponse(['success' => false, 'message' => 'Email is required.']);
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        sendResponse(['success' => false, 'message' => 'Invalid email format.']);
    }

    // Check if username already exists (for other users)
    $checkStmt = $conn->prepare('SELECT id FROM users WHERE username = ? AND id != ?');
    $checkStmt->bind_param('si', $username, $userId);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    if ($checkResult->num_rows > 0) {
        $checkStmt->close();
        sendResponse(['success' => false, 'message' => 'Username already exists.']);
    }
    $checkStmt->close();

    // Check if email already exists (for other users)
    $checkStmt = $conn->prepare('SELECT id FROM users WHERE email = ? AND id != ?');
    $checkStmt->bind_param('si', $email, $userId);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    if ($checkResult->num_rows > 0) {
        $checkStmt->close();
        sendResponse(['success' => false, 'message' => 'Email already exists.']);
    }
    $checkStmt->close();

    // Update profile
    $passwordColumn = getPasswordColumn($conn);
    $updateQuery = 'UPDATE users SET first_name = ?, last_name = ?, username = ?, email = ?';
    $params = [$firstName, $lastName, $username, $email];
    $types = 'ssss';

    if (!empty($newPassword)) {
        if (strlen($newPassword) < 6) {
            sendResponse(['success' => false, 'message' => 'New password must be at least 6 characters.']);
        }
        if ($passwordColumn !== '') {
            $updateQuery .= ", {$passwordColumn} = ?";
            $params[] = password_hash($newPassword, PASSWORD_DEFAULT);
            $types .= 's';
        }
    }

    $updateQuery .= ' WHERE id = ?';
    $params[] = $userId;
    $types .= 'i';

    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param($types, ...$params);
    
    if ($stmt->execute()) {
        $stmt->close();
        if (!empty($newPassword)) {
            $logQuery = "INSERT INTO password_reset_requests (user_id, email, token, new_password_hash, requested_at, used_at, is_used, ip_address) VALUES (?, ?, ?, ?, NOW(), NOW(), 1, ?)";
            $logStmt = $conn->prepare($logQuery);
            $tempToken = 'PROFILE_UPDATE_' . bin2hex(random_bytes(8));
            $userIp = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
            $hashedPw = password_hash($newPassword, PASSWORD_DEFAULT);
            $logStmt->bind_param('issss', $userId, $email, $tempToken, $hashedPw, $userIp);
            $logStmt->execute();
            $logStmt->close();
        }
        
        // Update session values
        $_SESSION['username'] = $username;
        $_SESSION['first_name'] = $firstName;
        $_SESSION['last_name'] = $lastName;
        $_SESSION['email'] = $email;
        
        $msg = 'Profile updated successfully!';
        if (!empty($newPassword)) $msg = 'Profile and password updated successfully!';
        
        sendResponse(['success' => true, 'message' => $msg]);
    } else {
        $stmt->close();
        sendResponse(['success' => false, 'message' => 'Failed to update profile.']);
    }
}

if ($action === 'change_password') {
    $newPassword = isset($_POST['new_password']) ? $_POST['new_password'] : '';

    // Validation
    if (empty($newPassword)) {
        sendResponse(['success' => false, 'message' => 'New password is required.']);
    }
    if (strlen($newPassword) < 6) {
        sendResponse(['success' => false, 'message' => 'New password must be at least 6 characters.']);
    }

    $passwordColumn = getPasswordColumn($conn);
    if ($passwordColumn === '') {
        sendResponse(['success' => false, 'message' => 'Password column is missing.']);
    }

    $newHash = password_hash($newPassword, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE users SET {$passwordColumn} = ? WHERE id = ?");
    $stmt->bind_param('si', $newHash, $userId);

    if ($stmt->execute()) {
        $stmt->close();
        sendResponse(['success' => true, 'message' => 'Password updated successfully!']);
    } else {
        $stmt->close();
        sendResponse(['success' => false, 'message' => 'Failed to update password.']);
    }
}

if ($action === 'get_profile') {
    $stmt = $conn->prepare('SELECT id, username, first_name, last_name, email, loyalty_points FROM users WHERE id = ?');
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user) {
        sendResponse([
            'success' => true,
            'user' => [
                'id' => $user['id'],
                'username' => $user['username'],
                'firstName' => $user['first_name'],
                'lastName' => $user['last_name'],
                'email' => $user['email'],
                'loyaltyPoints' => $user['loyalty_points']
            ]
        ]);
    } else {
        sendResponse(['success' => false, 'message' => 'User not found.']);
    }
}

if ($action === 'delete_order') {
    $orderId = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;

    if ($orderId <= 0) {
        sendResponse(['success' => false, 'message' => 'Invalid order.']);
    }

    // Check order status
    $statusStmt = $conn->prepare('SELECT status, order_note FROM orders WHERE id = ? AND user_id = ?');
    $statusStmt->bind_param('ii', $orderId, $userId);
    $statusStmt->execute();
    $statusResult = $statusStmt->get_result();
    $order = $statusResult->fetch_assoc();
    $statusStmt->close();

    if (!$order) {
        sendResponse(['success' => false, 'message' => 'Order not found.']);
    }

    if (!isOrderEditableStatus($order['status'])) {
        sendResponse(['success' => false, 'message' => 'Cannot remove completed orders.']);
    }

    $refundNote = trim(($order['order_note'] ?? '') . ' Refund placeholder: cancellation requested from My Account.');
    $stmt = $conn->prepare("UPDATE orders SET status = 'cancelled', order_note = ? WHERE id = ? AND user_id = ?");
    if (!$stmt) {
        sendResponse(['success' => false, 'message' => 'Could not prepare order cancellation.']);
    }

    $stmt->bind_param('sii', $refundNote, $orderId, $userId);
    $stmt->execute();
    $deleted = $stmt->affected_rows > 0;
    $stmt->close();

    if (!$deleted) {
        sendResponse(['success' => false, 'message' => 'Order not found.']);
    }

    sendResponse(['success' => true, 'message' => 'Order cancelled successfully.']);
}

if ($action === 'get_orders') {
    $activeStatusSql = getStatusSqlList(getActiveOrderStatuses());
    $stmt = $conn->prepare("SELECT id, order_number, status, total, created_at, delivery_date FROM orders WHERE user_id = ? AND LOWER(status) IN ($activeStatusSql) ORDER BY created_at DESC, id DESC");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $orders = [];
    
    while ($row = $result->fetch_assoc()) {
        $orders[] = [
            'id' => intval($row['id']),
            'order_number' => $row['order_number'],
            'status' => $row['status'],
            'total' => floatval($row['total']),
            'created_at' => $row['created_at'],
            'formatted_date' => (new DateTime(!empty($row['delivery_date']) ? $row['delivery_date'] : $row['created_at']))->format('M j, Y'),
            'points_earned' => calculateAccountOrderPoints($row['total']),
            'editable' => isOrderEditableStatus($row['status'])
        ];
    }
    $stmt->close();
    
    sendResponse([
        'success' => true,
        'orders' => $orders
    ]);
}

if ($action === 'get_rewards_summary') {
    $paidStatusSql = getStatusSqlList(getRewardOrderStatuses());
    $stmt = $conn->prepare("SELECT id, order_number, total, created_at, delivery_date FROM orders WHERE user_id = ? AND LOWER(status) IN ($paidStatusSql) ORDER BY created_at DESC, id DESC");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $orders = [];

    while ($row = $result->fetch_assoc()) {
        $pointsEarned = calculateAccountOrderPoints($row['total']);
        $orders[] = [
            'id' => intval($row['id']),
            'order_number' => $row['order_number'],
            'total' => floatval($row['total']),
            'points_earned' => $pointsEarned,
            'formatted_date' => (new DateTime(!empty($row['delivery_date']) ? $row['delivery_date'] : $row['created_at']))->format('M j, Y')
        ];
    }
    $stmt->close();

    sendResponse([
        'success' => true,
        'total_points' => getUserRewardPoints($conn, $userId),
        'orders' => $orders
    ]);
}

sendResponse(['success' => false, 'message' => 'Invalid action.']);
