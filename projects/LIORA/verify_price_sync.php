<?php
$html_data = [];
foreach (glob('*.php') as $fn) {
    if (in_array(basename($fn), ['details.php', 'giftdetail.php', 'header.php', 'footer.php', 'admin.php', 'cart.php', 'checkout.php', 'index.php'])) {
        continue;
    }
    $txt = file_get_contents($fn);
    preg_match_all('/<div[^>]*data-price="([^"]+)"[^>]*>.*?<a[^>]*href="([^"]+)"[^>]*>/s', $txt, $matches, PREG_SET_ORDER);
    foreach ($matches as $m) {
        $price = $m[1];
        $href = $m[2];
        $parts = explode('?id=', $href);
        $product_id = end($parts);
        $html_data[$product_id] = $price;
    }
}

$mismatch = [];
foreach (glob('assets/js/*.js') as $fn) {
    $basename = basename($fn);
    if (in_array($basename, ['main.js', 'admin.js', 'cart.js', 'review_helper.js', 'swiper.js', 'wishlist.js', 'search.js'])) {
        continue;
    }
    $txt = file_get_contents($fn);
    foreach ($html_data as $product_id => $price) {
        $pat = '/"' . preg_quote($product_id, '/') . '"\s*:\s*\{[^}]*?price\s*:\s*"([^"]+)"/s';
        if (preg_match($pat, $txt, $m)) {
            if ($m[1] !== $price && $m[1] !== '$' . $price) {
                $mismatch[] = [$fn, $product_id, $m[1], $price];
            }
        }
    }
}

echo "mismatches " . count($mismatch) . "\n";
foreach (array_slice($mismatch, 0, 100) as $item) {
    print_r($item);
}