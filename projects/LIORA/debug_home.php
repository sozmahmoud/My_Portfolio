<?php
include 'config.php';
session_start();

echo "<h1>Debug Homepage</h1>";

$sql = "SELECT * FROM products WHERE is_active = 1 LIMIT 6";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>✅ Products Found: " . $result->num_rows . "</h2>";
    while($row = $result->fetch_assoc()) {
        echo "<p><strong>" . $row['name'] . "</strong> - $" . $row['price'] . 
             " | Image: " . $row['image_url'] . "</p>";
    }
} else {
    echo "<h2>❌ No active products found</h2>";
    echo "<p>Try this query instead:</p>";
    echo "<pre>SELECT * FROM products;</pre>";
}
?>
