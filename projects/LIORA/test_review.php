<?php
session_start();
$_SESSION['user_id'] = 2; // test user id

// Simulate POST data
$_POST['action'] = 'submit';
$_POST['product_id'] = 1;
$_POST['rating'] = 5;
$_POST['comment'] = 'Test review';

include 'review_handler.php';
?>
