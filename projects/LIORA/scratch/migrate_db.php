<?php
require_once 'config.php';

$sql = "ALTER TABLE password_reset_requests ADD COLUMN IF NOT EXISTS new_password_hash VARCHAR(255) NULL AFTER token";

if ($conn->query($sql)) {
    echo "Column added successfully or already exists.";
} else {
    echo "Error: " . $conn->error;
}
$conn->close();
?>
