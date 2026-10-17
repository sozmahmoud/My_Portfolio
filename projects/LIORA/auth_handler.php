<?php
/**
 * ===================================
 * AUTHENTICATION HANDLER
 * Handles Login, Register, Logout
 * ===================================
 */
session_start();
require_once 'config.php';

header('Content-Type: application/json');

// Get the action from POST
$action = isset($_POST['action']) ? trim($_POST['action']) : '';

if ($action === 'register') {
    handleRegister();
} elseif ($action === 'login') {
    handleLogin();
} elseif ($action === 'logout') {
    handleLogout();
} elseif ($action === 'forgot_password') {
    handleForgotPassword();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

// ==========================================
// FORGOT PASSWORD HANDLER
// ==========================================
function handleForgotPassword() {
    global $conn;

    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => '💌 Please enter a valid email!']);
        return;
    }

    $stmt = $conn->prepare('SELECT id, username FROM users WHERE email = ? LIMIT 1');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user) {
        echo json_encode(['success' => false, 'message' => '❌ Account does not exist with this email address.']);
        return;
    }

    ensurePasswordResetTableExists($conn);

    $token = bin2hex(random_bytes(32));
    $expiresAt = date('Y-m-d H:i:s', strtotime('+60 minutes'));
    $ipAddress = $_SERVER['REMOTE_ADDR'] ?? null;

    $insertStmt = $conn->prepare('INSERT INTO password_reset_requests (user_id, email, token, expires_at, ip_address) VALUES (?, ?, ?, ?, ?)');
    $insertStmt->bind_param('issss', $user['id'], $email, $token, $expiresAt, $ipAddress);
    $insertStmt->execute();
    $insertId = $insertStmt->insert_id;
    $insertStmt->close();

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    $resetUrl = $protocol . '://' . $host . $basePath . '/password_reset.php?token=' . urlencode($token);

    $subject = 'Liora Password Reset Request';
    $messageBody = "Hello {$user['username']},\n\n" .
        "We received a request to reset your password. Click the link below to choose a new password:\n\n" .
        "$resetUrl\n\n" .
        "If you did not request this, you can ignore this email. This link expires in 60 minutes.\n\n" .
        "With love,\nLiora Team";

    $headers = 'From: no-reply@' . $host . "\r\n" .
               'Reply-To: ' . BUSINESS_EMAIL . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    if (@mail($email, $subject, $messageBody, $headers)) {
        $updateStmt = $conn->prepare('UPDATE password_reset_requests SET sent_at = NOW() WHERE id = ?');
        $updateStmt->bind_param('i', $insertId);
        $updateStmt->execute();
        $updateStmt->close();

        echo json_encode(['success' => true, 'message' => '💖 Reset link sent! Check your email.']);
    } else {
        // Still say "Check your email" as requested by user
        echo json_encode(['success' => true, 'message' => '💌 Check your email to reset your password!']);
    }
}

function ensurePasswordResetTableExists($conn) {
    $createSql = "CREATE TABLE IF NOT EXISTS password_reset_requests (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NULL,
        email VARCHAR(255) NOT NULL,
        token VARCHAR(255) NOT NULL UNIQUE,
        requested_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        expires_at DATETIME DEFAULT NULL,
        sent_at TIMESTAMP NULL DEFAULT NULL,
        used_at TIMESTAMP NULL DEFAULT NULL,
        is_used BOOLEAN DEFAULT FALSE,
        ip_address VARCHAR(45) DEFAULT NULL,
        INDEX idx_password_reset_requests_user_id (user_id),
        INDEX idx_password_reset_requests_email (email),
        INDEX idx_password_reset_requests_token (token),
        CONSTRAINT fk_password_reset_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
    ) ENGINE=InnoDB";

    $conn->query($createSql);
}

// ==========================================
// REGISTER HANDLER
// ==========================================
function handleRegister() {
    global $conn;
    
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $confirmPassword = isset($_POST['confirmPassword']) ? trim($_POST['confirmPassword']) : '';
    $firstName = isset($_POST['firstName']) ? trim($_POST['firstName']) : $username;
    $lastName = isset($_POST['lastName']) ? trim($_POST['lastName']) : '';

    // Validation
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        echo json_encode(['success' => false, 'message' => '🌸 Please fill in all fields!']);
        return;
    }

    if (strlen($username) < 3) {
        echo json_encode(['success' => false, 'message' => '👤 Username must be at least 3 characters!']);
        return;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => '💌 Invalid email format!']);
        return;
    }

    if (strlen($password) < 6) {
        echo json_encode(['success' => false, 'message' => '🔒 Password must be at least 6 characters!']);
        return;
    }

    if ($password !== $confirmPassword) {
        echo json_encode(['success' => false, 'message' => '❌ Passwords do not match!']);
        return;
    }

    // Check if user already exists
    $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
    $checkStmt->bind_param('ss', $email, $username);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $checkStmt->close();
        echo json_encode(['success' => false, 'message' => '⚠️ Email or username already exists!']);
        return;
    }
    $checkStmt->close();

    // Hash password
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    // Generate verification token
    $verificationToken = bin2hex(random_bytes(32));

    // Insert new user (active immediately, verification email sent for info)
    $insertStmt = $conn->prepare("INSERT INTO users (username, first_name, last_name, email, password_hash, verification_token, is_active) VALUES (?, ?, ?, ?, ?, ?, 1)");
    $insertStmt->bind_param('ssssss', $username, $firstName, $lastName, $email, $passwordHash, $verificationToken);

    if ($insertStmt->execute()) {
        $insertStmt->close();
        
        // Send verification email
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
        $verifyUrl = $protocol . '://' . $host . $basePath . '/verify.php?token=' . urlencode($verificationToken);

        $subject = '🌸 Welcome to Liora - Please Verify Your Email';
        $messageBody = "Hello $username,\n\n" .
            "Thank you for joining Liora! ✨\n\n" .
            "Please click the link below to verify your email address and activate your account:\n\n" .
            "$verifyUrl\n\n" .
            "Once verified, you can log in and start your flower journey.\n\n" .
            "With love,\nLiora Team";

        $headers = 'From: no-reply@' . $host . "\r\n" .
                   'Reply-To: ' . BUSINESS_EMAIL . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();

        if (@mail($email, $subject, $messageBody, $headers)) {
            echo json_encode(['success' => true, 'message' => '🎉 Registration successful! Please check your email for a verification message.']);
        } else {
            echo json_encode(['success' => true, 'message' => '🎉 Registration successful! Please check your email for a verification message.']);
        }
    } else {
        $insertStmt->close();
        echo json_encode(['success' => false, 'message' => '❌ Registration failed. Please try again.']);
    }
}

// ==========================================
// LOGIN HANDLER
// ==========================================
function handleLogin() {
    global $conn;
    
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // Validation
    if (empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => '🌸 Please fill in all fields!']);
        return;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => '💌 Invalid email format!']);
        return;
    }

    // Find user
    $stmt = $conn->prepare("SELECT id, username, email, password_hash, first_name, is_active, role FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows !== 1) {
        $stmt->close();
        echo json_encode(['success' => false, 'message' => '❌ Email not found!']);
        return;
    }

    $user = $result->fetch_assoc();
    $stmt->close();

    // Verify password
    if (!password_verify($password, $user['password_hash'])) {
        echo json_encode(['success' => false, 'message' => '❌ Incorrect password!']);
        return;
    }

    if (function_exists('liora_is_admin_email') && liora_is_admin_email($user['email']) && $user['role'] !== 'admin') {
        $promoteStmt = $conn->prepare("UPDATE users SET role = 'admin', is_active = 1, verification_token = NULL WHERE id = ?");
        if ($promoteStmt) {
            $promoteStmt->bind_param('i', $user['id']);
            $promoteStmt->execute();
            $promoteStmt->close();
        }
        $user['role'] = 'admin';
        $user['is_active'] = 1;
    }

    // Check if account is active
    if (!$user['is_active']) {
        echo json_encode(['success' => false, 'message' => '❌ Your account is currently inactive. Please contact support.']);
        return;
    }

    // Regenerate session ID for security
    session_regenerate_id(true);

    // Create session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['first_name'] = $user['first_name'];
    $_SESSION['role'] = $user['role'];

    // Migrate session cart to database
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $pid => $qty) {
            $stmt_migrate = $conn->prepare("INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)");
            $stmt_migrate->bind_param('iii', $user['id'], $pid, $qty);
            $stmt_migrate->execute();
            $stmt_migrate->close();
        }
        unset($_SESSION['cart']);
    }

    // Migrate session wishlist to database
    if (isset($_SESSION['wishlist']) && is_array($_SESSION['wishlist'])) {
        foreach ($_SESSION['wishlist'] as $pid) {
            $stmt_migrate = $conn->prepare("INSERT IGNORE INTO wishlist_items (user_id, product_id) VALUES (?, ?)");
            $stmt_migrate->bind_param('ii', $user['id'], $pid);
            $stmt_migrate->execute();
            $stmt_migrate->close();
        }
        unset($_SESSION['wishlist']);
    }

    // Write session data to disk before sending response
    session_write_close();

    echo json_encode([
        'success' => true,
        'message' => '✅ Login successful!',
        'user' => [
            'id' => $user['id'],
            'name' => $user['username'],
            'username' => $user['username'],
            'email' => $user['email'],
            'firstName' => $user['first_name'],
            'role' => $user['role']
        ]
    ]);
}

// ==========================================
// LOGOUT HANDLER
// ==========================================
function handleLogout() {
    // Clear all session data
    session_unset();
    $_SESSION = [];

    // Destroy session cookie if present
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    // Destroy the session
    session_destroy();
    session_write_close();

    echo json_encode(['success' => true, 'message' => 'Logged out successfully']);
}
?>
