<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'config.php';
header('Content-Type: application/json; charset=utf-8');

function ensureSupportMessagesTable(mysqli $conn): bool
{
    $sql = "
        CREATE TABLE IF NOT EXISTS support_messages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NULL,
            name VARCHAR(150) NOT NULL,
            email VARCHAR(255) NOT NULL,
            phone VARCHAR(50) DEFAULT NULL,
            topic VARCHAR(80) NOT NULL,
            order_number VARCHAR(50) DEFAULT NULL,
            preferred_contact ENUM('email', 'phone') DEFAULT 'email',
            message TEXT NOT NULL,
            status ENUM('new', 'read', 'replied', 'closed') DEFAULT 'new',
            ip_address VARCHAR(45) DEFAULT NULL,
            user_agent VARCHAR(255) DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_support_messages_user (user_id),
            INDEX idx_support_messages_status (status),
            INDEX idx_support_messages_created (created_at),
            CONSTRAINT fk_support_messages_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ";

    return (bool) $conn->query($sql);
}

function cleanInput(string $value, int $maxLength): string
{
    $value = trim($value);
    $value = preg_replace('/\s+/', ' ', $value);
    return substr($value, 0, $maxLength);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

if (!ensureSupportMessagesTable($conn)) {
    echo json_encode(['success' => false, 'message' => 'Support table could not be prepared.']);
    exit;
}

$name = cleanInput($_POST['name'] ?? '', 150);
$email = cleanInput($_POST['email'] ?? '', 255);
$phone = cleanInput($_POST['phone'] ?? '', 50);
$topic = cleanInput($_POST['topic'] ?? 'General question', 80);
$orderNumber = cleanInput($_POST['order_number'] ?? '', 50);
$preferredContact = $_POST['preferred_contact'] ?? 'email';
$message = trim($_POST['message'] ?? '');
$message = substr($message, 0, 3000);

$allowedTopics = ['Order help', 'Delivery question', 'Product advice', 'Account help', 'Partnership', 'General question'];
$allowedContact = ['email', 'phone'];

if ($name === '' || $email === '' || $message === '') {
    echo json_encode(['success' => false, 'message' => 'Please fill in your name, email, and message.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
    exit;
}

if ($phone !== '' && !preg_match('/^\d{11}$/', $phone)) {
    echo json_encode(['success' => false, 'message' => 'Phone numbers must be exactly 11 digits for Iraq.']);
    exit;
}

if (!in_array($topic, $allowedTopics, true)) {
    $topic = 'General question';
}

if (!in_array($preferredContact, $allowedContact, true)) {
    $preferredContact = 'email';
}

$userId = !empty($_SESSION['user_id']) ? intval($_SESSION['user_id']) : null;
$ipAddress = $_SERVER['REMOTE_ADDR'] ?? null;
$userAgent = substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255);

$stmt = $conn->prepare("
    INSERT INTO support_messages
        (user_id, name, email, phone, topic, order_number, preferred_contact, message, ip_address, user_agent)
    VALUES
        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Could not prepare your message.']);
    exit;
}

$stmt->bind_param(
    'isssssssss',
    $userId,
    $name,
    $email,
    $phone,
    $topic,
    $orderNumber,
    $preferredContact,
    $message,
    $ipAddress,
    $userAgent
);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Thank you. Your support request has been sent.',
        'ticket_id' => $conn->insert_id
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'We could not send your message right now. Please try again.']);
}

$stmt->close();
?>
