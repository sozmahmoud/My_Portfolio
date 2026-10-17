<?php
include 'config.php';

$username = 'testuser_' . time();
$email = 'test_' . time() . '@example.com';
$passwordHash = password_hash('password123', PASSWORD_BCRYPT);
$firstName = 'Test';
$lastName = 'User';

$stmt = $conn->prepare("INSERT INTO users (username, first_name, last_name, email, password_hash, is_active) VALUES (?, ?, ?, ?, ?, 0)");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param('sssss', $username, $firstName, $lastName, $email, $passwordHash);
if ($stmt->execute()) {
    echo "✓ Registration simulated successfully! User: $username\n";
} else {
    echo "✗ Registration failed: " . $stmt->error . "\n";
}
$stmt->close();

$res = $conn->query("SELECT COUNT(*) FROM users");
echo "Current Users Count: " . $res->fetch_row()[0] . "\n";
?>
