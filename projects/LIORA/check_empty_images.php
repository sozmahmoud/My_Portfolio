<?php
require 'config.php';
$result = $conn->query("SELECT id, name FROM products WHERE image_url IS NULL OR TRIM(image_url) = ''");
$found = false;
while ($row = $result->fetch_assoc()) {
    $found = true;
    echo $row['id'] . ': ' . $row['name'] . "\n";
}
if (!$found) {
    echo "No products with empty image_url.\n";
}
?>
