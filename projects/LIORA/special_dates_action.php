<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once 'config.php';

if (!$conn || $conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}

$userId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

function sendResponse($data) {
    echo json_encode($data);
    exit;
}

function requireLogin($userId) {
    if ($userId <= 0) {
        sendResponse([
            'success' => false,
            'message' => 'Please log in to save your flower moments.',
            'logged_in' => false
        ]);
    }
}

function isValidDate($date) {
    $parsed = DateTime::createFromFormat('Y-m-d', $date);
    return $parsed && $parsed->format('Y-m-d') === $date;
}

function getSpecialDates($conn, $userId) {
    $stmt = $conn->prepare(
        'SELECT id, event_name, event_date, occasion_type
         FROM user_special_dates
         WHERE user_id = ?
         ORDER BY created_at DESC, id DESC'
    );
    if (!$stmt) {
        return [];
    }

    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $items = [];

    while ($row = $result->fetch_assoc()) {
        $date = DateTime::createFromFormat('Y-m-d', $row['event_date']);
        $items[] = [
            'id' => intval($row['id']),
            'eventName' => $row['event_name'],
            'eventDate' => $row['event_date'],
            'dateString' => $date ? $date->format('F j, Y') : $row['event_date'],
            'month' => $date ? $date->format('F') : '',
            'day' => $date ? intval($date->format('j')) : 0,
            'eventType' => $row['occasion_type'] ?? 'Special Moment'
        ];
    }

    $stmt->close();
    return $items;
}

requireLogin($userId);

if (!$conn->query("CREATE TABLE IF NOT EXISTS user_special_dates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    event_name VARCHAR(100) NOT NULL,
    event_date DATE NOT NULL,
    occasion_type VARCHAR(50) DEFAULT 'Special Moment',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_special_dates_user (user_id),
    INDEX idx_special_dates_date (event_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4")) {
    sendResponse(['success' => false, 'message' => 'Could not prepare special dates storage.']);
}

if ($action === 'get') {
    sendResponse([
        'success' => true,
        'items' => getSpecialDates($conn, $userId),
        'logged_in' => true
    ]);
}

if ($action === 'add') {
    $eventName = trim($_POST['event_name'] ?? ($_POST['title'] ?? ''));
    $eventDate = trim($_POST['event_date'] ?? '');

    if ($eventName === '') {
        $eventName = 'Special Moment';
    }

    if (function_exists('mb_strlen') && function_exists('mb_substr')) {
        if (mb_strlen($eventName) > 100) {
            $eventName = mb_substr($eventName, 0, 100);
        }
    } elseif (strlen($eventName) > 100) {
        $eventName = substr($eventName, 0, 100);
    }

    if (!isValidDate($eventDate)) {
        sendResponse(['success' => false, 'message' => 'Please choose a valid date.']);
    }

    $occasionType = trim($_POST['occasion_type'] ?? 'Special Moment');

    // Check if this date already exists for this user
    $checkStmt = $conn->prepare('SELECT id FROM user_special_dates WHERE user_id = ? AND event_date = ?');
    if ($checkStmt) {
        $checkStmt->bind_param('is', $userId, $eventDate);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        
        if ($checkResult->num_rows > 0) {
            // Date already exists, don't add duplicate
            $checkStmt->close();
            sendResponse([
                'success' => true,
                'items' => getSpecialDates($conn, $userId),
                'logged_in' => true,
                'message' => 'This date is already in your special moments!'
            ]);
        }
        $checkStmt->close();
    }

    $stmt = $conn->prepare(
        'INSERT INTO user_special_dates (user_id, event_name, event_date, occasion_type)
         VALUES (?, ?, ?, ?)'
    );
    if (!$stmt) {
        sendResponse(['success' => false, 'message' => 'Could not save your special date.']);
    }

    $stmt->bind_param('isss', $userId, $eventName, $eventDate, $occasionType);
    $success = $stmt->execute();
    $stmt->close();

    if (!$success) {
        sendResponse(['success' => false, 'message' => 'Could not save your special date.']);
    }

    sendResponse([
        'success' => true,
        'items' => getSpecialDates($conn, $userId),
        'logged_in' => true
    ]);
}

if ($action === 'remove') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if ($id <= 0) {
        sendResponse(['success' => false, 'message' => 'Invalid special date.']);
    }

    $stmt = $conn->prepare('DELETE FROM user_special_dates WHERE id = ? AND user_id = ?');
    if (!$stmt) {
        sendResponse(['success' => false, 'message' => 'Could not remove your special date.']);
    }

    $stmt->bind_param('ii', $id, $userId);
    $stmt->execute();
    $stmt->close();

    sendResponse([
        'success' => true,
        'items' => getSpecialDates($conn, $userId),
        'logged_in' => true
    ]);
}

if ($action === 'clear') {
    $stmt = $conn->prepare('DELETE FROM user_special_dates WHERE user_id = ?');
    if (!$stmt) {
        sendResponse(['success' => false, 'message' => 'Could not clear your special dates.']);
    }

    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $stmt->close();

    sendResponse([
        'success' => true,
        'items' => [],
        'logged_in' => true
    ]);
}

sendResponse(['success' => false, 'message' => 'Invalid action.']);
?>
