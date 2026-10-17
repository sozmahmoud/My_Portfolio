<?php
require 'config.php';
$sql = "SELECT id, name, image_url FROM products 
        WHERE image_url IS NULL 
           OR TRIM(image_url) = '' 
           OR (image_url NOT LIKE 'assets/%' AND image_url NOT LIKE 'http%/%') 
        ORDER BY id";
$result = $conn->query($sql);
echo "Products with problematic image_url:\n";
echo "====================================\n";
$found = false;
while ($row = $result->fetch_assoc()) {
    $found = true;
    printf("%d: %s => '%s'\n", $row['id'], $row['name'], $row['image_url']);
}
if (!$found) {
    echo "None found - all products have valid image URLs.\n";
}
?>
