<?php
/**
 * ===================================
 * AUTHENTICATION PROTECTION
 * Include this in pages that require login
 * ===================================
 */
session_start();

if (empty($_SESSION['user_id'])) {
    // Redirect to login page
    header('Location: login-register.php');
    exit();
}
?>
