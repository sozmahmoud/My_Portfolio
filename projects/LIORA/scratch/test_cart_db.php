<?php
require 'config.php';
$userId = 1;
$productId = 41;
$quantity = 2;

$sql = "INSERT INTO cart_items (user_id, product_id, quantity) VALUES ($userId, $productId, $quantity) ON DUPLICATE KEY UPDATE quantity = quantity + $quantity";
if ($conn->query($sql)) {
    echo "✓ Successfully added to cart in DB!\n";
} else {
    echo "✗ Error: " . $conn->error . "\n";
}

$res = $conn->query("SELECT * FROM cart_items WHERE user_id = $userId");
while($row = $res->fetch_assoc()) {
    print_r($row);
}
?>
