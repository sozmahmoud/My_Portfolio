<?php
require 'config.php';
require_once 'map_product_id.php';

$result = $conn->query("SELECT id, name, image_url FROM products ORDER BY id");
$missingStatic = [];
while ($row = $result->fetch_assoc()) {
    $id = intval($row['id']);
    $static = getStaticProductById($id);
    if (!$static) {
        $missingStatic[] = $id;
    } else {
        // also check if static image usable
        $img = $static['image'] ?? '';
        $path = ltrim(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $img), DIRECTORY_SEPARATOR);
        $full = __DIR__ . DIRECTORY_SEPARATOR . $path;
        if (!is_file($full)) {
            echo "Static image file missing for ID $id: $img\n";
        }
    }
}

if (empty($missingStatic)) {
    echo "All DB products have static product data.\n";
} else {
    echo "Products lacking static product data (ID): " . implode(', ', $missingStatic) . "\n";
}
?>
