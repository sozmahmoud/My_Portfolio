<?php
$js_files = glob('assets/js/*.js');
$ignore = ['main.js', 'admin.js', 'cart.js', 'review_helper.js', 'swiper.js', 'wishlist.js', 'search.js', 'bearchocolate.js'];

function parse_prices($content, $object_name) {
    $prices = [];
    $start = strpos($content, $object_name);
    if ($start === false) return $prices;
    $substring = substr($content, $start);
    preg_match_all('/\{([^{}]*?\bid\s*:\s*"([^"]+)"[^{}]*?\bprice\s*:\s*"([^"]+)"[^{}]*?)\}/s', $substring, $matches, PREG_SET_ORDER);
    foreach ($matches as $m) {
        $prices[$m[2]] = $m[3];
    }
    return $prices;
}

foreach ($js_files as $fn) {
    if (in_array(basename($fn), $ignore)) continue;
    $txt = file_get_contents($fn);
    $data = parse_prices($txt, 'const flowerData');
    $allp = parse_prices($txt, 'const allProducts');
    $mismatches = [];
    foreach ($data as $pid => $p) {
        if (isset($allp[$pid])) {
            $expected = str_starts_with($allp[$pid], '$') ? $allp[$pid] : '$' . $allp[$pid];
            if ($p !== $expected) {
                $mismatches[] = [$pid, $p, $allp[$pid]];
            }
        }
    }
    if (!empty($mismatches)) {
        echo $fn . "\n";
        foreach ($mismatches as $m) {
            echo "  {$m[0]} {$m[1]} -> {$m[2]}\n";
        }
    }
}