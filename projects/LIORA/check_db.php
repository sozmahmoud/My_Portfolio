<?php
require 'config.php';
$result = $conn->query('SHOW TABLES LIKE "reviews"');
if ($result->num_rows > 0) {
    echo 'Reviews table exists';
} else {
    echo 'Reviews table does not exist';
}
?>
