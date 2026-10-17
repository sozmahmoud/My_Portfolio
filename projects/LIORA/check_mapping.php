<?php
require_once 'map_product_id.php';

$catalogPath = __DIR__ . '/assets/js/search.js';
$catalog = file_get_contents($catalogPath);
preg_match_all('/\{\s*id:\s*"([^"]+)"\s*,\s*title:\s*"([^"]+)"(?:.*?)category:\s*"([^"]+)"(?:.*?)price:\s*"([^"]+)"(?:.*?)image:\s*"([^"]+)"(?:.*?)link:\s*"([^"]+)"/u', $catalog, $matches, PREG_SET_ORDER);

echo "Checking static catalog ID mapping:\n";
$unmapped = [];
$duplicates = [];
$mappedIds = [];

foreach ($matches as $match) {
    $slug = $match[1];
    $numericId = mapProductId($slug);
    if ($numericId === null) {
        $unmapped[] = $slug;
    } else {
        if (isset($mappedIds[$numericId])) {
            $duplicates[$numericId][] = $slug;
        } else {
            $mappedIds[$numericId] = $slug;
        }
    }
}

if (empty($unmapped)) {
    echo "All slugs are mapped to numeric IDs.\n";
} else {
    echo "UNMAPPED slugs (no numeric ID):\n";
    print_r($unmapped);
}

if (empty($duplicates)) {
    echo "No duplicate numeric IDs.\n";
} else {
    echo "DUPLICATE numeric IDs (multiple slugs map to same ID):\n";
    print_r($duplicates);
}

echo "\nTotal unique numeric IDs covered: " . count($mappedIds) . "\n";
echo "Mapped IDs: " . implode(', ', array_keys($mappedIds)) . "\n";
?>
