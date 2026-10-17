<?php
session_start();
require 'config.php';
require_once 'map_product_id.php';

echo "=== Session Cart ===\n";
print_r($_SESSION['cart'] ?? []);

echo "\n=== Cart Product Snapshots ===\n";
print_r($_SESSION['cart_product_snapshots'] ?? []);

// Also check what getStaticProductById returns for various IDs
$testIds = [8, 41, 48, 58];
foreach ($testIds as $id) {
    $static = getStaticProductById($id);
    echo "\nStatic product $id:\n";
    print_r($static);
}
?>
