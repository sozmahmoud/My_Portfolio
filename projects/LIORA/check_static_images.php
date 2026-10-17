<?php
require_once 'map_product_id.php';

// Get all static product images from search.js and occasionProducts
$staticImages = [];

// Get from search.js
$catalogPath = __DIR__ . '/assets/js/search.js';
$catalog = file_get_contents($catalogPath);
preg_match_all('/\{\s*id:\s*"([^"]+)"\s*,\s*title:\s*"([^"]+)"(?:.*?)category:\s*"([^"]+)"(?:.*?)price:\s*"([^"]+)"(?:.*?)image:\s*"([^"]+)"(?:.*?)link:\s*"([^"]+)"/u', $catalog, $matches, PREG_SET_ORDER);
foreach ($matches as $match) {
    $slug = $match[1];
    $image = $match[5];
    $id = mapProductId($slug);
    if ($id) {
        $staticImages[$id] = $image;
    }
}

// Get from occasionProducts (inline in map_product_id.php)
// We'll manually list them
$occasionProducts = [
    86 => ['title' => 'Peach Romance Roses', 'image' => 'assets/img/items/roses/rose_6.jpg'],
    62 => ['title' => 'Birthday Bouquet', 'image' => 'assets/img/items/roses/rose_1.jpg'],
    63 => ['title' => 'Birthday Special', 'image' => 'assets/img/items/roses/rose_6.jpg'],
    64 => ['title' => 'Happy Birthday Mix', 'image' => 'assets/img/items/tulips/tulip_3.jpg'],
    65 => ['title' => 'Birthday Joy', 'image' => 'assets/img/items/tulips/tulip_5.jpg'],
    66 => ['title' => 'Celebration Bundle', 'image' => 'assets/img/items/orchids/orchid_5.jpg'],
    67 => ['title' => 'Grand Birthday', 'image' => 'assets/img/items/orchids/orchid_6.jpg'],
    68 => ['title' => 'Birthday Elegance', 'image' => 'assets/img/items/lilys/lily_2.jpg'],
    69 => ['title' => 'Birthday Bliss', 'image' => 'assets/img/items/lilys/lily_9.jpg'],
    70 => ['title' => 'Birthday Premium', 'image' => 'assets/img/items/mixed/mixed_9.jpg'],
    71 => ['title' => 'Birthday Star', 'image' => 'assets/img/items/daisies/prettybluedaisy.jpg'],
    72 => ['title' => 'Birthday Magic', 'image' => 'assets/img/items/daffodils/gorgousdaffoldils.jpg'],
    73 => ['title' => 'Birthday Perfection', 'image' => 'assets/img/items/buttercup/orangebuttercup.jpg'],
    91 => ['title' => 'Peach Paradise Roses', 'image' => 'assets/img/items/roses/rose_6.jpg'],
    92 => ['title' => 'Pure White Elegance Tulips', 'image' => 'assets/img/items/tulips/tulip_3.jpg'],
    93 => ['title' => 'Pink Champagne Orchids', 'image' => 'assets/img/items/orchids/orchid_5.jpg'],
    95 => ['title' => 'Pink Galaxy Stargazer Lilies', 'image' => 'assets/img/items/lilys/lily_4.jpg'],
    97 => ['title' => 'Pretty Pink Rosie Bunch', 'image' => 'assets/img/items/minirose/prettypinkyrosie.jpg'],
    99 => ['title' => 'Cream & Gold Buttercup Wrap', 'image' => 'assets/img/items/buttercup/buttercup6.jpg'],
    101 => ['title' => 'Cute Bear Gift Set', 'image' => 'assets/img/items/other/c6.jpg'],
    102 => ['title' => 'Mini Succulent Tray', 'image' => 'assets/img/items/other/c10.jpg'],
    103 => ['title' => 'Mini Garden Gift', 'image' => 'assets/img/items/other/Mini Garden Gift.jpg'],
    104 => ['title' => 'Romantic Gift Box', 'image' => 'assets/img/items/other/s2.jpg'],
    105 => ['title' => 'Tea Time Basket', 'image' => 'assets/img/items/other/s3.jpg'],
    106 => ['title' => 'Jewelry Gift Box', 'image' => 'assets/img/items/other/s4.jpg'],
    107 => ['title' => 'Mug Gift Set', 'image' => 'assets/img/items/other/s7.jpg'],
];
foreach ($occasionProducts as $id => $p) {
    $staticImages[$id] = $p['image'];
}

// Now check file existence for each static image
$missingFiles = [];
foreach ($staticImages as $id => $image) {
    $path = ltrim(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $image), DIRECTORY_SEPARATOR);
    $full = __DIR__ . DIRECTORY_SEPARATOR . $path;
    if (!is_file($full)) {
        $missingFiles[$id] = $image;
    }
}

if (empty($missingFiles)) {
    echo "All static product images exist on disk.\n";
} else {
    echo "Static product images missing on disk:\n";
    foreach ($missingFiles as $id => $img) {
        echo "  ID $id: $img\n";
    }
}
echo "\nTotal static images checked: " . count($staticImages) . "\n";
?>
