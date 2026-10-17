<?php
require_once 'config.php';
header('Content-Type: text/plain; charset=utf-8');

if (!$conn || $conn->connect_error) {
    echo 'Database connection failed: ' . $conn->connect_error . PHP_EOL;
    exit(1);
}

echo "Starting stock sync from order_items...\n";

$sql = 
    'SELECT oi.product_id, COALESCE(SUM(oi.quantity), 0) AS sold_count
     FROM order_items oi
     JOIN orders o ON oi.order_id = o.id
     WHERE o.status <> "cancelled"
     GROUP BY oi.product_id';

$result = $conn->query($sql);
if (!$result) {
    echo 'Query failed: ' . $conn->error . PHP_EOL;
    exit(1);
}

$updateStmt = $conn->prepare('UPDATE products SET stock = GREATEST(stock - ?, 0) WHERE id = ?');
if (!$updateStmt) {
    echo 'Prepare failed: ' . $conn->error . PHP_EOL;
    exit(1);
}

while ($row = $result->fetch_assoc()) {
    $productId = intval($row['product_id']);
    $soldCount = intval($row['sold_count']);
    if ($soldCount <= 0) {
        continue;
    }
    $updateStmt->bind_param('ii', $soldCount, $productId);
    if (!$updateStmt->execute()) {
        echo "Failed to update product {$productId}: " . $updateStmt->error . PHP_EOL;
        continue;
    }
    echo "Updated product {$productId}: reduced stock by {$soldCount}." . PHP_EOL;
}

$updateStmt->close();
$result->close();
$conn->close();

echo "Stock sync complete.\n";
?>