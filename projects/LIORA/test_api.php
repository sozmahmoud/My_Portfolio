<?php
// Test wishlist with flower.php product (buttercup-cream = ID 41)
session_start();
$_SESSION['user_id'] = 1;
$_REQUEST['action'] = 'toggle';
$_REQUEST['product_id'] = '41'; // buttercup-cream from flower.php

header('Content-Type: application/json');
require_once 'wishlist_action.php';
?>
