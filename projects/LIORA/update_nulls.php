<?php
require_once 'config.php';

$conn->query('UPDATE cart_items SET options = "" WHERE options IS NULL');
$conn->query('UPDATE cart_items SET product_type = "" WHERE product_type IS NULL');
$conn->query('UPDATE cart_items SET variant = "" WHERE variant IS NULL');

$conn->query('UPDATE order_items SET options = "" WHERE options IS NULL');
$conn->query('UPDATE order_items SET product_type = "" WHERE product_type IS NULL');
$conn->query('UPDATE order_items SET variant = "" WHERE variant IS NULL');

$conn->query('UPDATE wishlist_items SET options = "" WHERE options IS NULL');
$conn->query('UPDATE wishlist_items SET product_type = "" WHERE product_type IS NULL');
$conn->query('UPDATE wishlist_items SET variant = "" WHERE variant IS NULL');

echo 'Updated nulls to empty strings.';
?>