<?php
require_once 'config.php';

$tables = ['cart_items', 'order_items', 'wishlist_items'];
$fields = ['options', 'product_type', 'variant'];

foreach ($tables as $table) {
    foreach ($fields as $field) {
        if ($field === 'options') {
            $sql = "ALTER TABLE $table MODIFY COLUMN $field TEXT NOT NULL DEFAULT ''";
        } else {
            $sql = "ALTER TABLE $table MODIFY COLUMN $field VARCHAR(100) NOT NULL DEFAULT ''";
        }
        $conn->query($sql);
        if ($conn->error) {
            echo "Error altering $table.$field: " . $conn->error . PHP_EOL;
        } else {
            echo "Altered $table.$field successfully." . PHP_EOL;
        }
    }
}
?>