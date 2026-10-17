<?php
require 'config.php';
$sql = "CREATE TABLE IF NOT EXISTS chat_history (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    user_id      INT NOT NULL,
    role         ENUM('user', 'model') NOT NULL,
    message      TEXT NOT NULL,
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_chat_history_user (user_id),
    INDEX idx_chat_history_created (created_at)
) ENGINE=InnoDB";

if ($conn->query($sql)) {
    echo "Table chat_history created successfully\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}
?>
