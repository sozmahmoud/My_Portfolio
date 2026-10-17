<?php
include 'config.php';
$res = $conn->query('SELECT COUNT(*) FROM reviews');
if ($res) {
    echo "Total reviews: " . $res->fetch_row()[0] . "\n";
} else {
    echo "Error: " . $conn->error . "\n";
}
?>
