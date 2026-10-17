<?php
include 'config.php';
if ($conn->connect_error) {
    echo 'DB Error: ' . $conn->connect_error;
} else {
    echo 'DB Connected';
    $conn->close();
}
?>
