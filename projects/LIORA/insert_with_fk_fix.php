<?php
require 'config.php';

try {
    // Disable foreign key checks temporarily
    $pdo->query('SET FOREIGN_KEY_CHECKS=0');
    
    // Clear existing products to avoid duplicates
    $pdo->query('TRUNCATE TABLE products');
    echo "✓ Products table cleared\n";
    
    // Re-enable foreign key checks
    $pdo->query('SET FOREIGN_KEY_CHECKS=1');
    
    // Load the insert script to insert products
    require 'insert_all_products.php';
    
} catch (Exception $e) {
    echo "✗ Exception: " . $e->getMessage() . "\n";
    exit(1);
}
?>

