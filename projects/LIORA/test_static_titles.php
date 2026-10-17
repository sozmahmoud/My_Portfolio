<?php
require_once 'map_product_id.php';

$testIds = [4, 9, 10, 11, 12, 13, 14, 87, 88];
foreach ($testIds as $id) {
    $static = getStaticProductById($id);
    if ($static) {
        echo "ID $id: title = {$static['title']}, image = {$static['image']}\n";
    } else {
        echo "ID $id: No static product\n";
    }
}
?>
