<?php
$search_txt = file_get_contents('assets/js/search.js');
$search_prices = [];
preg_match_all('/\{[^\}]*?\bid\s*:\s*["\']([^"\']+)["\'][^\}]*?\bprice\s*:\s*["\']([^"\']+)["\']/s', $search_txt, $matches, PREG_SET_ORDER);
foreach ($matches as $m) {
    $search_prices[$m[1]] = $m[2];
}

function normalize_price($value) {
    if ($value === null) return null;
    $value = trim((string)$value);
    if (str_starts_with($value, '$')) $value = substr($value, 1);
    if (str_ends_with($value, '.00')) $value = substr($value, 0, -3);
    return $value;
}

$mismatches = [];
foreach (glob('assets/js/*.js') as $fn) {
    $basename = basename($fn);
    if (in_array($basename, ['main.js', 'admin.js', 'cart.js', 'review_helper.js', 'swiper.js', 'wishlist.js', 'search.js'])) {
        continue;
    }
    $txt = file_get_contents($fn);
    if (preg_match('/const flowerData\s*=\s*\{(.*?)\};/s', $txt, $m_flower)) {
        $block = $m_flower[1];
        preg_match_all('/["\']([^"\']+)["\']\s*:\s*\{(.*?)\}/s', $block, $obj_matches, PREG_SET_ORDER);
        foreach ($obj_matches as $om) {
            $pid = $om[1];
            if (preg_match('/price\s*:\s*"([^"]+)"/', $om[2], $pm)) {
                $price = $pm[1];
                if (isset($search_prices[$pid])) {
                    $expected = $search_prices[$pid];
                    if (normalize_price($price) !== normalize_price($expected)) {
                        $mismatches[] = [$fn, $pid, 'flowerData', $price, $expected];
                    }
                }
            }
        }
    }
    
    if (preg_match('/const allProducts\s*=\s*\[(.*?)\];/s', $txt, $m_all)) {
        $block = $m_all[1];
        preg_match_all('/\{(.*?)\}/s', $block, $obj_matches, PREG_SET_ORDER);
        foreach ($obj_matches as $om) {
            $obj = $om[1];
            if (preg_match('/id\s*:\s*["\']([^"\']+)["\']/', $obj, $id_m) && preg_match('/price\s*:\s*["\']([^"\']+)["\']/', $obj, $price_m)) {
                $pid = $id_m[1];
                $price = $price_m[1];
                if (isset($search_prices[$pid])) {
                    $expected = $search_prices[$pid];
                    if (normalize_price($price) !== normalize_price($expected)) {
                        $mismatches[] = [$fn, $pid, 'allProducts', $price, $expected];
                    }
                }
            }
        }
    }
}

echo "mismatches " . count($mismatches) . "\n";
foreach ($mismatches as $item) {
    print_r($item);
}