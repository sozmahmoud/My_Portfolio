<?php
require 'config.php';

// Comprehensive product list - ALL PRODUCTS (1-101+)
$products = [
    // ROSES (IDs 1-8)
    [1, 'Blue Sapphire Roses', 26.00, 20.00, 'Roses', 'Blue', 'assets/img/items/roses/rose_1.jpg', 'Elegant blue sapphire roses bouquet', 1],
    [2, 'Rainbow Romance Roses', 32.00, 25.00, 'Roses', 'Multi-color', 'assets/img/items/roses/rose_2.jpg', 'Beautiful rainbow colored romance roses', 1],
    [3, 'Golden Sunshine Roses', 24.00, 19.00, 'Roses', 'Yellow', 'assets/img/items/roses/rose_3.jpg', 'Bright golden sunshine rose arrangement', 1],
    [4, 'Ruby Red Romance', 31.00, 24.00, 'Roses', 'Red', 'assets/img/items/roses/rose_5.jpg', 'Deep ruby red romance roses', 1],
    [5, 'Peach Paradise Roses', 26.00, 20.00, 'Roses', 'Peach', 'assets/img/items/roses/rose_6.jpg', 'Soft peach paradise roses collection', 1],
    [6, 'Blush Pink Dream', 27.00, 21.00, 'Roses', 'Pink', 'assets/img/items/roses/rose_7.jpg', 'Romantic blush pink dream roses', 1],
    [7, 'Pure White Elegance', 36.00, 28.00, 'Roses', 'White', 'assets/img/items/roses/rose_9.jpg', 'Pure white elegant rose bouquet', 1],
    [8, 'Soft Pink Ribbon Roses', 26.00, 20.00, 'Roses', 'Pink', 'assets/img/items/roses/rose_10.jpg', 'Soft pink roses with ribbon decoration', 1],
    
    // TULIPS (IDs 9-14)
    [9, 'Rainbow Mixed Tulips', 22.00, 17.00, 'Tulips', 'Multi-color', 'assets/img/items/tulips/tulip_1.jpg', 'Colorful mixed rainbow tulips', 1],
    [10, 'Red & White Romance Tulips', 28.00, 22.00, 'Tulips', 'Red/White', 'assets/img/items/tulips/tulip_2.jpg', 'Striking red and white tulips', 1],
    [11, 'Pure White Elegance Tulips', 24.00, 19.00, 'Tulips', 'White', 'assets/img/items/tulips/tulip_3.jpg', 'Pure white elegant tulip collection', 1],
    [12, 'Lavender Love Tulips', 24.00, 19.00, 'Tulips', 'Purple', 'assets/img/items/tulips/tulip_5.jpg', 'Lovely lavender love tulips', 1],
    [13, 'Ruby Red Tulip Bouquet', 31.00, 24.00, 'Tulips', 'Red', 'assets/img/items/tulips/tulip_6.jpg', 'Deep ruby red tulip arrangement', 1],
    [14, 'Blush Pink Tulip Bouquet', 26.00, 20.00, 'Tulips', 'Pink', 'assets/img/items/tulips/tulip_8.jpg', 'Soft blush pink tulips', 1],
    
    // LILIES (IDs 15-20)
    [15, 'Sunset Orange Tiger Lilies', 32.00, 25.00, 'Lilies', 'Orange', 'assets/img/items/lilys/lily_2.jpg', 'Sunset orange tiger lily bouquet', 1],
    [16, 'Pink Galaxy Stargazer Lilies', 28.00, 22.00, 'Lilies', 'Pink', 'assets/img/items/lilys/lily_4.jpg', 'Pink galaxy stargazer lily collection', 1],
    [17, 'Blush Pink Bouquet Lilies', 35.00, 27.00, 'Lilies', 'Pink', 'assets/img/items/lilys/lily_6.jpg', 'Blush pink lily bouquet', 1],
    [18, 'White Heaven Lilies', 26.00, 20.00, 'Lilies', 'White', 'assets/img/items/lilys/lily_7.jpg', 'Pure white heaven lilies', 1],
    [19, 'Ocean Blue Magic Lilies', 35.00, 27.00, 'Lilies', 'Blue', 'assets/img/items/lilys/lily_9.jpg', 'Ocean blue magical lily arrangement', 1],
    [20, 'Pastel Pink Dream Lilies', 39.00, 30.00, 'Lilies', 'Pink', 'assets/img/items/lilys/lily_10.jpg', 'Pastel pink dream lily collection', 1],
    
    // ORCHIDS (IDs 21-26)
    [21, 'Purple Majesty Orchids', 39.00, 30.00, 'Orchids', 'Purple', 'assets/img/items/orchids/orchid_1.jpg', 'Purple majesty orchid arrangement', 1],
    [22, 'Pink Champagne Orchids', 36.00, 28.00, 'Orchids', 'Pink', 'assets/img/items/orchids/orchid_5.jpg', 'Elegant pink champagne orchids', 1],
    [23, 'Sunset Coral Orchids', 39.00, 30.00, 'Orchids', 'Coral', 'assets/img/items/orchids/orchid_6.jpg', 'Sunset coral orchid collection', 1],
    [24, 'Pink Cascade Orchids', 36.00, 28.00, 'Orchids', 'Pink', 'assets/img/items/orchids/orchid_7.jpg', 'Pink cascade orchid bouquet', 1],
    [25, 'Golden Sunrise Orchids', 28.00, 22.00, 'Orchids', 'Yellow', 'assets/img/items/orchids/orchid_9.jpg', 'Golden sunrise orchid arrangement', 1],
    [26, 'Ocean Breeze Blue Orchids', 45.00, 35.00, 'Orchids', 'Blue', 'assets/img/items/orchids/orchid_10.jpg', 'Ocean breeze blue orchid luxury', 1],
    
    // SUNFLOWERS (IDs 27-31)
    [27, 'Classic Yellow Sunflower Bouquet', 18.00, 14.00, 'Sunflowers', 'Yellow', 'assets/img/items/sunflowers/sunflower_2.jpg', 'Classic yellow sunflower arrangement', 1],
    [28, 'Sunny Day Basket', 22.00, 17.00, 'Sunflowers', 'Yellow', 'assets/img/items/sunflowers/sunflower_3.jpg', 'Sunny day sunflower basket', 1],
    [29, 'Golden Vase Arrangement', 28.00, 22.00, 'Sunflowers', 'Yellow', 'assets/img/items/sunflowers/sunflower_4.jpg', 'Golden vase sunflower arrangement', 1],
    [30, 'Giant Sunflower Heart', 36.00, 28.00, 'Sunflowers', 'Yellow', 'assets/img/items/sunflowers/sunflower_6.jpg', 'Giant sunflower heart shape', 1],
    [31, 'Elegant Wrapped Sunflowers', 26.00, 20.00, 'Sunflowers', 'Yellow', 'assets/img/items/sunflowers/sunflower_10.jpg', 'Elegantly wrapped sunflowers', 1],
    
    // MIXED BOUQUETS (IDs 32-39)
    [32, 'Pink Garden Delight', 28.00, 22.00, 'Mixed', 'Pink', 'assets/img/items/mixed/mixed_1.jpg', 'Pink garden delight mixed bouquet', 1],
    [33, 'Sweet Blossom Dream', 32.00, 25.00, 'Mixed', 'Multi-color', 'assets/img/items/mixed/mixed_2.jpg', 'Sweet blossom dream arrangement', 1],
    [34, 'White Daisy Charm', 36.00, 28.00, 'Mixed', 'White', 'assets/img/items/mixed/mixed_3.jpg', 'White daisy charm mixed bouquet', 1],
    [35, 'Soft Pastel Love', 35.00, 27.00, 'Mixed', 'Pastel', 'assets/img/items/mixed/mixed_6.jpg', 'Soft pastel love mixed arrangement', 1],
    [36, 'Lavender Whisper', 26.00, 20.00, 'Mixed', 'Purple', 'assets/img/items/mixed/mixed_7.jpg', 'Lavender whisper mixed bouquet', 1],
    [37, 'Spring Morning Glow', 35.00, 27.00, 'Mixed', 'Multi-color', 'assets/img/items/mixed/mixed_8.jpg', 'Spring morning glow arrangement', 1],
    [38, 'Blush Blossom Fantasy', 32.00, 25.00, 'Mixed', 'Pink', 'assets/img/items/mixed/mixed_9.jpg', 'Blush blossom fantasy bouquet', 1],
    [39, 'White Elegance Bouquet', 32.00, 25.00, 'Mixed', 'White', 'assets/img/items/mixed/mixed_10.jpg', 'White elegance mixed collection', 1],
    
    // BUTTERCUP (IDs 40-44)
    [40, 'Golden Buttercup Bouquet', 18.00, 14.00, 'Buttercup', 'Yellow', 'assets/img/items/buttercup/buttercup.jpg', 'Golden buttercup flower bouquet', 1],
    [41, 'Cream & Gold Buttercup Wrap', 20.00, 16.00, 'Buttercup', 'Yellow', 'assets/img/items/buttercup/buttercup6.jpg', 'Cream and gold buttercup arrangement', 1],
    [42, 'Modern Buttercup Arrangement', 28.00, 22.00, 'Buttercup', 'Yellow', 'assets/img/items/buttercup/modernbuttercup.jpg', 'Modern buttercup collection', 1],
    [43, 'Sunset Orange Buttercup', 22.00, 17.00, 'Buttercup', 'Orange', 'assets/img/items/buttercup/orangebuttercup.jpg', 'Sunset orange buttercup bouquet', 1],
    [44, 'Rosy Pink Buttercup Bundle', 18.00, 14.00, 'Buttercup', 'Pink', 'assets/img/items/buttercup/pinkbuttercup.jpg', 'Rosy pink buttercup bundle', 1],
    
    // DAISIES (IDs 45-50)
    [45, 'Golden Daisy Sunshine', 22.00, 17.00, 'Daisies', 'Yellow', 'assets/img/items/daisies/beautifuldaisy.jpg', 'Golden daisy sunshine bouquet', 1],
    [46, 'Pure White Daisy Bloom', 26.00, 20.00, 'Daisies', 'White', 'assets/img/items/daisies/daisies.jpg', 'Pure white daisy bloom arrangement', 1],
    [47, 'Soft Daisy Charm', 26.00, 20.00, 'Daisies', 'White/Pink', 'assets/img/items/daisies/daisy.jpg', 'Soft daisy charm collection', 1],
    [48, 'Blue Daisy Magic', 26.00, 26.00, 'Daisies', 'Blue', 'assets/img/items/daisies/prettybluedaisy.jpg', 'Blue daisy magic bouquet', 1],
    [49, 'Rosy Daisy Garden', 26.00, 20.00, 'Daisies', 'Pink', 'assets/img/items/daisies/rosiedaisie.jpg', 'Rosy daisy garden arrangement', 1],
    [50, 'Simple White Daisy Wrap', 22.00, 17.00, 'Daisies', 'White', 'assets/img/items/daisies/whitedaisy.jpg', 'Simple white daisy wrap bouquet', 1],
    
    // MINI ROSES (IDs 51-56)
    [51, 'Crimson Mini Rose Bouquet', 22.00, 17.00, 'Mini Roses', 'Red', 'assets/img/items/minirose/redminirose.jpg', 'Crimson mini rose bouquet', 1],
    [52, 'Pinky Baby Rose Wrap', 18.00, 14.00, 'Mini Roses', 'Pink', 'assets/img/items/minirose/pinkybabyrosie.jpg', 'Pinky baby rose wrap', 1],
    [53, 'Pretty Pink Rosie Bunch', 26.00, 20.00, 'Mini Roses', 'Pink', 'assets/img/items/minirose/prettypinkyrosie.jpg', 'Pretty pink mini rose bunch', 1],
    [54, 'Ocean Peach Rosie Bouquet', 24.00, 19.00, 'Mini Roses', 'Peach', 'assets/img/items/minirose/oceanrosie.jpg', 'Ocean peach mini rose bouquet', 1],
    [55, 'Golden Sunset Rosie', 28.00, 22.00, 'Mini Roses', 'Yellow', 'assets/img/items/minirose/goldenrosie.jpg', 'Golden sunset mini rose collection', 1],
    [56, 'Fairy White Rosie Bouquet', 20.00, 16.00, 'Mini Roses', 'White', 'assets/img/items/minirose/fairywhiterosie.jpg', 'Fairy white mini rose bouquet', 1],
    
    // DAFFODILS (IDs 57-61)
    [57, 'Baby Spring Daffodils', 20.00, 16.00, 'Daffodils', 'Yellow', 'assets/img/items/daffodils/babydaffoldis.jpg', 'Baby spring daffodil collection', 1],
    [58, 'Classic Yellow Daffodils', 18.00, 17.00, 'Daffodils', 'Yellow', 'assets/img/items/daffodils/daffoldilsss.jpg', 'Classic yellow daffodil bouquet', 1],
    [59, 'Golden Spring Elegance', 24.00, 19.00, 'Daffodils', 'Yellow', 'assets/img/items/daffodils/gorgousdaffoldils.jpg', 'Golden spring elegance daffodils', 1],
    [60, 'Lavender Sunshine Mix', 28.00, 22.00, 'Daffodils', 'Purple/Yellow', 'assets/img/items/daffodils/lavenderdaffoldils.jpg', 'Lavender sunshine daffodil mix', 1],
    [61, 'Light Yellow Dream', 22.00, 17.00, 'Daffodils', 'Yellow', 'assets/img/items/daffodils/lightyellowdaffoldils.jpg', 'Light yellow dream daffodils', 1],
    
    // BIRTHDAY COLLECTION (IDs 62-73)
    [62, 'Blue Sapphire Roses Birthday', 26.00, 20.00, 'Roses', 'Blue', 'assets/img/items/roses/rose_1.jpg', 'Premium blue roses for birthday celebration', 1],
    [63, 'Peach Paradise Birthday Roses', 26.00, 20.00, 'Roses', 'Peach', 'assets/img/items/roses/rose_6.jpg', 'Beautiful peach roses for birthday', 1],
    [64, 'Pure White Elegance Birthday Tulips', 24.00, 19.00, 'Tulips', 'White', 'assets/img/items/tulips/tulip_3.jpg', 'White tulips for birthday celebration', 1],
    [65, 'Lavender Love Birthday Tulips', 24.00, 19.00, 'Tulips', 'Lavender', 'assets/img/items/tulips/tulip_5.jpg', 'Lavender tulips for birthday', 1],
    [66, 'Pink Champagne Birthday Orchids', 36.00, 28.00, 'Orchids', 'Pink', 'assets/img/items/orchids/orchid_5.jpg', 'Pink orchids for birthday celebration', 1],
    [67, 'Sunset Coral Birthday Orchids', 39.00, 30.00, 'Orchids', 'Coral', 'assets/img/items/orchids/orchid_6.jpg', 'Coral orchids for birthday', 1],
    [68, 'Sunset Orange Birthday Lilies', 32.00, 25.00, 'Lilies', 'Orange', 'assets/img/items/lilys/lily_2.jpg', 'Orange lilies for birthday celebration', 1],
    [69, 'Ocean Blue Birthday Lilies', 35.00, 27.00, 'Lilies', 'Blue', 'assets/img/items/lilys/lily_9.jpg', 'Blue lilies for birthday', 1],
    [70, 'Blush Blossom Birthday Mix', 32.00, 25.00, 'Mixed', 'Pink', 'assets/img/items/mixed/mixed_9.jpg', 'Mixed flowers for birthday', 1],
    [71, 'Blue Daisy Birthday Magic', 26.00, 26.00, 'Daisies', 'Blue', 'assets/img/items/daisies/prettybluedaisy.jpg', 'Blue daisies for birthday', 1],
    [72, 'Golden Birthday Elegance Daffodils', 24.00, 19.00, 'Daffodils', 'Golden', 'assets/img/items/daffodils/gorgousdaffoldils.jpg', 'Golden daffodils for birthday', 1],
    [73, 'Sunset Birthday Orange Buttercup', 22.00, 17.00, 'Buttercup', 'Orange', 'assets/img/items/buttercup/orangebuttercup.jpg', 'Orange buttercup for birthday', 1],
    
    // VALENTINE & GIFTS (IDs 74-90)
    [74, 'Soft Classic Teddy Bear', 30.00, 22.00, 'Gifts', 'Brown', 'assets/img/items/bear/bear_1.jpg', 'Classic soft teddy bear gift', 0],
    [75, 'Ruby Red Romance Valentine Roses', 31.00, 24.00, 'Roses', 'Red', 'assets/img/items/roses/rose_5.jpg', 'Deep ruby red roses for Valentine', 1],
    [76, 'Premium Chocolate Collection', 39.00, 30.00, 'Chocolates', 'Brown', 'assets/img/items/chocolate/chocolate_4.jpg', 'Premium assortment of fine chocolates', 0],
    [77, 'Elegant Pink Dress Bear', 30.00, 22.00, 'Gifts', 'Pink', 'assets/img/items/bear/bear_2.jpg', 'Adorable bear in pink dress', 0],
    [78, 'Mini Cute Bear', 19.00, 14.00, 'Gifts', 'Brown', 'assets/img/items/bear/bear_3.jpg', 'Tiny cute teddy bear', 0],
    [79, 'Blush Pink Dream Valentine', 27.00, 21.00, 'Roses', 'Pink', 'assets/img/items/roses/rose_7.jpg', 'Blush pink roses for Valentine', 1],
    [80, 'Pink Love Bear', 19.00, 14.00, 'Gifts', 'Pink', 'assets/img/items/bear/bear_6.jpg', 'Sweet pink bear with love', 0],
    [81, 'Classic Brown Bear', 19.00, 14.00, 'Gifts', 'Brown', 'assets/img/items/bear/bear_7.jpg', 'Timeless classic brown teddy bear', 0],
    [82, 'Luxury Chocolate Box', 35.00, 27.00, 'Chocolates', 'Brown', 'assets/img/items/chocolate/chocolate_1.jpg', 'Luxurious premium chocolates', 0],
    [83, 'Heart Chocolate Box', 36.00, 28.00, 'Chocolates', 'Brown', 'assets/img/items/chocolate/chocolate_2.jpg', 'Heart-shaped chocolate box', 0],
    [84, 'Strawberry Chocolate Set', 32.00, 25.00, 'Chocolates', 'Red', 'assets/img/items/chocolate/chocolate_3.jpg', 'Delicious strawberry chocolates', 0],
    [85, 'Luxury Valentine Chocolate', 41.00, 32.00, 'Chocolates', 'Brown', 'assets/img/items/chocolate/chocolate_5.jpg', 'Premium Valentine chocolate collection', 0],
    [86, 'Peach Romance Valentine Roses', 26.00, 20.00, 'Roses', 'Peach', 'assets/img/items/roses/rose_6.jpg', 'Romantic peach roses', 1],
    [87, 'Romantic Rose Mix Valentine', 32.00, 25.00, 'Roses', 'Multi', 'assets/img/items/roses/rose_2.jpg', 'Mixed romantic roses', 1],
    [88, 'Pink Galaxy Valentine Lilies', 28.00, 22.00, 'Lilies', 'Pink', 'assets/img/items/lilys/lily_4.jpg', 'Pink lilies for Valentine', 1],
    [89, 'Ruby Red Valentine Tulips', 31.00, 24.00, 'Tulips', 'Red', 'assets/img/items/tulips/tulip_6.jpg', 'Red tulips for Valentine', 1],
    [90, 'Pretty Pink Valentine Mini Roses', 26.00, 20.00, 'Mini Roses', 'Pink', 'assets/img/items/minirose/prettypinkyrosie.jpg', 'Pink mini roses for Valentine', 1],
    
    // MOTHER'S DAY COLLECTION (IDs 91-100)
    [91, 'Peach Paradise Mother Roses', 26.00, 20.00, 'Roses', 'Peach', 'assets/img/items/roses/rose_6.jpg', 'Peach roses for mother', 1],
    [92, 'Pure White Elegance Mother Tulips', 24.00, 19.00, 'Tulips', 'White', 'assets/img/items/tulips/tulip_3.jpg', 'White tulips for mothers day', 1],
    [93, 'Pink Champagne Mother Orchids', 36.00, 28.00, 'Orchids', 'Pink', 'assets/img/items/orchids/orchid_5.jpg', 'Pink orchids for mother', 1],
    [94, 'Blush Blossom Mother Mix', 32.00, 25.00, 'Mixed', 'Pink', 'assets/img/items/mixed/mixed_9.jpg', 'Mixed flowers for mothers day', 1],
    [95, 'Pink Galaxy Mother Lilies', 28.00, 22.00, 'Lilies', 'Pink', 'assets/img/items/lilys/lily_4.jpg', 'Pink lilies for mother', 1],
    [96, 'Rosy Daisy Mother Garden', 26.00, 20.00, 'Daisies', 'Pink', 'assets/img/items/daisies/rosiedaisie.jpg', 'Pink daisies for mothers day', 1],
    [97, 'Pretty Pink Mother Rosie Bunch', 26.00, 20.00, 'Mini Roses', 'Pink', 'assets/img/items/minirose/prettypinkyrosie.jpg', 'Pink mini roses for mother', 1],
    [98, 'Golden Mother Spring Elegance', 24.00, 19.00, 'Daffodils', 'Golden', 'assets/img/items/daffodils/gorgousdaffoldils.jpg', 'Golden daffodils for mother', 1],
    [99, 'Cream & Gold Mother Buttercup', 20.00, 16.00, 'Buttercup', 'Cream', 'assets/img/items/buttercup/buttercup6.jpg', 'Buttercup for mothers day', 1],
    [100, 'Classic Yellow Mother Sunflower', 18.00, 14.00, 'Sunflowers', 'Yellow', 'assets/img/items/sunflowers/sunflower_2.jpg', 'Yellow sunflowers for mother', 1],
    
    // NEW YEAR & VIP (IDs 101+)
    [101, 'Soft Pink New Year Roses', 26.00, 20.00, 'Roses', 'Pink', 'assets/img/items/roses/rose_10.jpg', 'Pink roses for new year', 1],
];

try {
    // Disable foreign key checks to clear existing products
    $conn->query("SET FOREIGN_KEY_CHECKS = 0");
    
    // Clear existing products to avoid duplicates
    $conn->query("DELETE FROM products");
    echo "✓ Products table cleared\n";
    
    // Re-enable foreign key checks
    $conn->query("SET FOREIGN_KEY_CHECKS = 1");
    
    // Prepare statement
    $stmt = $conn->prepare('INSERT INTO products (id, name, price, sale_price, category, color, image_url, description, is_flower, stock, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 50, 1)');
    
    if (!$stmt) {
        echo "✗ Prepare Error: " . $conn->error . "\n";
        exit(1);
    }
    
    // Bind parameters - 9 parameters: id(i), name(s), price(d), sale_price(d), category(s), color(s), image_url(s), description(s), is_flower(i)
    $stmt->bind_param('isddssssi', $id, $name, $price, $sale_price, $category, $color, $image_url, $description, $is_flower);
    
    // Insert all products
    $count = 0;
    foreach ($products as $p) {
        $id = $p[0];
        $name = $p[1];
        $price = $p[2];
        $sale_price = $p[3];
        $category = $p[4];
        $color = $p[5];
        $image_url = $p[6];
        $description = $p[7];
        $is_flower = $p[8];
        $stock = 50;
        
        if ($stmt->execute()) {
            $count++;
        } else {
            echo "✗ Error inserting product ID {$id}: " . $stmt->error . "\n";
        }
    }
    
    $stmt->close();
    
    echo "\n✅ Successfully inserted $count products!\n";
    
    // Verify
    $result = $conn->query('SELECT COUNT(*) as count FROM products WHERE is_active = 1');
    $row = $result->fetch_assoc();
    echo "✓ Total active products in database: " . $row['count'] . "\n";
    
    // Show sample products
    $result = $conn->query('SELECT id, name, price, sale_price, category FROM products ORDER BY id LIMIT 10');
    echo "\n📋 Sample of inserted products:\n";
    while ($row = $result->fetch_assoc()) {
        echo "   ID {$row['id']}: {$row['name']} - ${$row['price']} → ${$row['sale_price']} ({$row['category']})\n";
    }
    
} catch (Exception $e) {
    echo "✗ Exception: " . $e->getMessage() . "\n";
    exit(1);
}

?>


