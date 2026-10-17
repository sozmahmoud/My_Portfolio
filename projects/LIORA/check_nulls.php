<?php
require_once 'config.php';

$tables = ['cart_items', 'order_items', 'wishlist_items'];
$fields = ['options', 'product_type', 'variant'];

foreach ($tables as $table) {
    foreach ($fields as $field) {
        $result = $conn->query("SELECT COUNT(*) as count FROM $table WHERE $field IS NULL");
        $row = $result->fetch_assoc();
        echo "$table null $field: " . $row['count'] . PHP_EOL;
    }
}
?>