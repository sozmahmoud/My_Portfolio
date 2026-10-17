<?php
require 'config.php';

// Create a test user
$stmt = $conn->prepare('INSERT INTO users (username, first_name, last_name, email, password_hash) VALUES (?, ?, ?, ?, ?)');
$username = 'testuser';
$firstName = 'Test';
$lastName = 'User';
$email = 'test@example.com';
$passwordHash = password_hash('password123', PASSWORD_BCRYPT);

$stmt->bind_param('sssss', $username, $firstName, $lastName, $email, $passwordHash);
$stmt->execute();
$userId = $conn->insert_id;
$stmt->close();

echo "✓ Test user created with ID: $userId\n";
echo "  Username: $username\n";
echo "  Email: $email\n";
echo "  Password: password123\n";
?>
