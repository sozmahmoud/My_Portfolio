<?php
require 'config.php';
$result = $conn->query("SELECT id, name, image_url FROM products");
while($row = $result->fetch_assoc()) {
    $exists = file_exists(__DIR__ . '/' . $row['image_url']) ? '✅' : '❌';
    echo "ID: {$row['id']} | Name: {$row['name']} | Image: {$row['image_url']} | Exists: $exists\n";
}
?>
