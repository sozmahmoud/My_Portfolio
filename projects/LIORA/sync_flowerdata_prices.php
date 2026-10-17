<?php
$search_txt = file_get_contents('assets/js/search.js');
$search_prices = [];
preg_match_all('/\{[^\}]*?\bid\s*:\s*["\']([^"\']+)["\'][^\}]*?\bprice\s*:\s*["\']([^"\']+)["\']/s', $search_txt, $matches, PREG_SET_ORDER);
foreach ($matches as $m) {
    $search_prices[$m[1]] = $m[2];
}

function format_price($src) {
    if (str_starts_with($src, '$')) return $src;
    if (str_contains($src, '.')) {
        if (str_ends_with($src, '.00')) return '$' . substr($src, 0, -3);
        return '$' . $src;
    }
    return '$' . $src;
}

$exclude = ['main.js', 'admin.js', 'cart.js', 'review_helper.js', 'swiper.js', 'wishlist.js', 'search.js'];
$changed = [];

foreach (glob('assets/js/*.js') as $fn) {
    if (in_array(basename($fn), $exclude)) continue;
    $txt = file_get_contents($fn);
    
    $out = $txt;
    $updates = [];
    
    // flowerData extraction
    if (preg_match('/const flowerData\s*=\s*\{(.*?)\};/s', $txt, $m_flower, PREG_OFFSET_CAPTURE)) {
        $block = $m_flower[1][0];
        $block_start = $m_flower[1][1];
        preg_match_all('/["\']([^"\']+)["\']\s*:\s*\{(.*?)\}/s', $block, $obj_matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE);
        foreach ($obj_matches as $om) {
            $pid = $om[1][0];
            $obj_str = $om[2][0];
            $obj_offset = $om[2][1];
            if (preg_match('/price\s*:\s*"([^"]+)"/', $obj_str, $pm, PREG_OFFSET_CAPTURE)) {
                $price = $pm[1][0];
                $price_offset = $pm[1][1];
                if (isset($search_prices[$pid])) {
                    $source = format_price($search_prices[$pid]);
                    if ($source && $price !== $source) {
                        $updates[] = [$pid, 'flowerData', $price, $source];
                        // Perform replacement in $out via string manipulation if needed
                        // For simplicity in conversion, we just do a simple replacement here.
                        $out = preg_replace('/("' . preg_quote($pid, '/') . '"\s*:\s*\{[^}]*?price\s*:\s*")' . preg_quote($price, '/') . '(")/s', '${1}' . $source . '${2}', $out);
                    }
                }
            }
        }
    }
    
    // allProducts extraction
    if (preg_match('/const allProducts\s*=\s*\[(.*?)\];/s', $out, $m_all)) {
        $block = $m_all[1];
        preg_match_all('/\{(.*?)\}/s', $block, $obj_matches, PREG_SET_ORDER);
        foreach ($obj_matches as $om) {
            $obj = $om[1];
            if (preg_match('/id\s*:\s*["\']([^"\']+)["\']/', $obj, $id_m) && preg_match('/price\s*:\s*["\']([^"\']+)["\']/', $obj, $price_m)) {
                $pid = $id_m[1];
                $price = $price_m[1];
                if (isset($search_prices[$pid])) {
                    $source = format_price($search_prices[$pid]);
                    if ($source && $price !== $source) {
                        $updates[] = [$pid, 'allProducts', $price, $source];
                        // simple replacement
                        $out = preg_replace('/(id\s*:\s*["\']' . preg_quote($pid, '/') . '["\'][^}]*?price\s*:\s*")' . preg_quote($price, '/') . '(")/s', '${1}' . $source . '${2}', $out);
                    }
                }
            }
        }
    }
    
    if (!empty($updates)) {
        file_put_contents($fn, $out);
        $changed[] = [$fn, $updates];
    }
}

echo 'Updated files: ' . count($changed) . "\n";
foreach ($changed as $item) {
    echo $item[0] . "\n";
    foreach ($item[1] as $upd) {
        echo "  {$upd[0]} {$upd[1]} {$upd[2]} -> {$upd[3]}\n";
    }
}