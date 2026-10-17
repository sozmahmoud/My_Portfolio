<?php
require 'config.php';

// Drop existing tables to start fresh
$tables = ['wishlist_items', 'cart_items', 'order_items', 'reward_points', 'orders', 'reviews', 'user_special_dates', 'products', 'users'];
foreach ($tables as $table) {
    $conn->query("DROP TABLE IF EXISTS $table");
}

// Load schema
$sql = file_get_contents('schema.sql');
if ($conn->multi_query($sql)) {
    echo "✓ Schema loaded successfully\n";
    while($conn->next_result());
} else {
    echo "✗ Schema Error: " . $conn->error . "\n";
    exit(1);
}

// Insert sample products (matching the HTML data-product-id attributes)
$products = [
    [1, 'Red Rose Bouquet', 35.99, 29.99, 'Rose', 'assets/img/items/roses/rose_1.jpg'],
    [2, 'Pink Rose Arrangement', 42.99, 35.99, 'Rose', 'assets/img/items/roses/rose_2.jpg'],
    [3, 'White Lily Bundle', 48.99, 39.99, 'Lily', 'assets/img/items/lilys/lily_1.jpg'],
    [4, 'Sunflower Delight', 32.99, 26.99, 'Sunflower', 'assets/img/items/sunflowers/sunflower_1.jpg'],
    [5, 'Tulip Mix', 38.99, 31.99, 'Tulip', 'assets/img/items/tulips/tulip_1.jpg'],
    [40, 'Golden Buttercup', 25.00, 20.00, 'Buttercup', 'assets/img/items/buttercup/buttercup_1.jpg'],
    [41, 'Buttercup Elegance', 28.00, 22.00, 'Buttercup', 'assets/img/items/buttercup/buttercup_2.jpg'],
    [42, 'Premium Buttercup', 38.00, 30.00, 'Buttercup', 'assets/img/items/buttercup/buttercup_3.jpg'],
    [45, 'Daisy Dreams', 34.00, 27.00, 'Daisy', 'assets/img/items/daisies/daisy_1.jpg'],
    [50, 'Mini Rose Pink', 32.00, 25.00, 'Mini Rose', 'assets/img/items/minirose/minirose_1.jpg'],
    [57, 'Daffodil Yellow', 29.00, 23.00, 'Daffodil', 'assets/img/items/daffodils/daffodil_1.jpg'],
    [62, 'Birthday Bouquet', 42.00, 35.00, 'Mixed', 'assets/img/items/popular/birthday_1.jpg'],
];

$stmt = $conn->prepare('INSERT INTO products (id, name, price, sale_price, category, image_url, is_active) VALUES (?, ?, ?, ?, ?, ?, 1)');

foreach ($products as $p) {
    $stmt->bind_param('isddss', $p[0], $p[1], $p[2], $p[3], $p[4], $p[5]);
    $stmt->execute();
}
$stmt->close();

echo "✓ " . count($products) . " sample products inserted\n";

// Verify
$result = $conn->query('SELECT COUNT(*) as count FROM products WHERE is_active = 1');
$row = $result->fetch_assoc();
echo "✓ Total active products: " . $row['count'] . "\n";

echo "\n✅ Database ready for testing!\n";
?>
