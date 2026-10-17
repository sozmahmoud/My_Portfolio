<?php
require 'config.php';
try {
    echo "Users: " . $conn->query("SELECT COUNT(*) as c FROM users")->fetch_assoc()['c'] . "\n";
    echo "Products: " . $conn->query("SELECT COUNT(*) as c FROM products")->fetch_assoc()['c'] . "\n";
    echo "Orders: " . $conn->query("SELECT COUNT(*) as c FROM orders")->fetch_assoc()['c'] . "\n";
    echo "Reviews: " . $conn->query("SELECT COUNT(*) as c FROM reviews")->fetch_assoc()['c'] . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
