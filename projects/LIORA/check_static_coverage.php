<?php
require 'config.php';
require_once 'map_product_id.php';

// Get all product IDs from DB
$dbProducts = [];
$result = $conn->query("SELECT id, name, image_url FROM products ORDER BY id");
while ($row = $result->fetch_assoc()) {
    $dbProducts[$row['id']] = $row;
}

// Collect all static IDs from search.js parsing
$staticCoveredIds = [];

// From occasionProducts (defined in map_product_id.php)
$occasionIds = [86,62,63,64,65,66,67,68,69,70,71,72,73,91,92,93,95,97,99,101,102,103,104,105,106,107];
foreach ($occasionIds as $oid) {
    $staticCoveredIds[$oid] = true;
}

// From search.js parsing
$catalogPath = __DIR__ . '/assets/js/search.js';
$catalog = file_get_contents($catalogPath);
preg_match_all('/\{\s*id:\s*"([^"]+)"\s*,\s*title:\s*"([^"]+)"(?:.*?)category:\s*"([^"]+)"(?:.*?)price:\s*"([^"]+)"(?:.*?)image:\s*"([^"]+)"(?:.*?)link:\s*"([^"]+)"/u', $catalog, $matches, PREG_SET_ORDER);
foreach ($matches as $match) {
    $slug = $match[1];
    $mappedId = mapProductId($slug);
    if ($mappedId && $mappedId > 0) {
        $staticCoveredIds[$mappedId] = true;
    }
}

// Legacy mapping also provides coverage
$legacyMap = [2,4,6,13,16,27,38,49,53,59];
foreach ($legacyMap as $lid) {
    $staticCoveredIds[$lid] = true;
}

echo "Static catalog covers " . count($staticCoveredIds) . " product IDs.\n";

// Find DB products not in static catalog
$missing = [];
foreach (array_keys($dbProducts) as $id) {
    if (!isset($staticCoveredIds[$id])) {
        $missing[] = $id;
    }
}

if (empty($missing)) {
    echo "All DB products are covered by static catalog.\n";
} else {
    echo "Products NOT covered by static catalog:\n";
    foreach ($missing as $id) {
        echo "  $id: " . $dbProducts[$id]['name'] . " (img: " . $dbProducts[$id]['image_url'] . ")\n";
    }
}
?>
