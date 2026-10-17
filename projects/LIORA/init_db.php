<?php
/**
 * Database Setup Script
 * Initializes schema and loads all products referenced in the HTML with CORRECT IMAGE PATHS
 */
if (!defined('LIORA_AUTO_BOOTSTRAP')) {
    require 'config.php';
}

echo "🔧 Setting up LIORA database with fixed image paths...\n\n";

// Step 1: Drop and recreate tables
echo "1️⃣  Loading database schema...\n";

// Optional: check if we should skip to avoid wiping data
$checkUsers = $conn->query("SELECT id FROM users LIMIT 1");
if ($checkUsers && $checkUsers->num_rows > 0 && !isset($_GET['force'])) {
    echo "⚠️  Users already exist! Skipping schema reset to protect your data.\n";
    echo "   (Use init_db.php?force=1 to wipe and start fresh)\n";
} else {
    $conn->query('SET FOREIGN_KEY_CHECKS = 0');
    $tables = [
        'password_reset_requests',
        'support_messages',
        'chat_history',
        'order_items',
        'orders',
        'wishlist_items',
        'cart_items',
        'reward_points',
        'reviews',
        'user_special_dates',
        'user_search_history',
        'products',
        'users'
    ];
    foreach ($tables as $table) {
        $conn->query("DROP TABLE IF EXISTS $table");
    }
    $conn->query('SET FOREIGN_KEY_CHECKS = 1');

    $sql = file_get_contents('schema.sql');
    $queries = explode(';', $sql);
    $success = true;
    foreach ($queries as $query) {
        $trimmed = trim($query);
        if (empty($trimmed)) continue;
        if (!$conn->query($trimmed)) {
            echo "   ✗ Error executing: " . substr($trimmed, 0, 50) . "...\n";
            echo "     " . $conn->error . "\n";
            $success = false;
            break;
        }
    }
    if ($success) echo "   ✓ Schema created successfully\n";
}

// Step 2: Insert all products with RICH DETAILS (color, description, type)
echo "\n2️⃣  Loading products with rich details...\n";
$products = [
    // [ID, Name, Price, Sale, Category, Color, Description, is_flower, Image]
    
    // Rose products (1-14)
    [1, 'Classic Red Roses', 25.00, 20.00, 'Roses', 'Red', 'A timeless bouquet of deep red roses, symbolizing love and passion.', 1, 'assets/img/items/roses/rose_1.jpg'],
    [2, 'Pink Rose Delight', 28.00, 22.00, 'Roses', 'Pink', 'Elegant pink roses that convey grace, happiness, and gentleness.', 1, 'assets/img/items/roses/rose_2.jpg'],
    [3, 'White Rose Elegance', 26.00, 19.00, 'Roses', 'White', 'Pure white roses representing innocence, purity, and new beginnings.', 1, 'assets/img/items/roses/rose_3.jpg'],
    [4, 'Red Velvet Roses', 32.00, 25.00, 'Roses', 'Dark Red', 'Luxurious dark red roses with a velvety texture, perfect for deep romance.', 1, 'assets/img/items/roses/rose_1.jpg'],
    [5, 'Coral Sunset Roses', 30.00, 20.00, 'Roses', 'Orange/Coral', 'Vibrant coral roses that capture the warmth and beauty of a summer sunset.', 1, 'assets/img/items/roses/rose_5.jpg'],
    [6, 'Yellow Joy Roses', 24.00, 18.00, 'Roses', 'Yellow', 'Bright yellow roses that radiate friendship, joy, and sunshine.', 1, 'assets/img/items/roses/rose_6.jpg'],
    [7, 'Blush Roses', 27.00, 28.00, 'Roses', 'Light Pink', 'Soft blush-colored roses, perfect for showing subtle affection and kindness.', 1, 'assets/img/items/roses/rose_7.jpg'],
    [8, 'Lavender Dreams', 35.00, 20.00, 'Roses', 'Purple/Lavender', 'Enchanting lavender roses that symbolize wonder, mystery, and love at first sight.', 1, 'assets/img/items/roses/rose_1.jpg'],
    [9, 'Deep Crimson', 34.00, 17.00, 'Roses', 'Crimson', 'A dramatic arrangement of deep crimson roses for a bold statement of love.', 1, 'assets/img/items/roses/rose_9.jpg'],
    [10, 'Peach Perfection', 30.00, 22.00, 'Roses', 'Peach/Orange', 'Sweet peach roses that represent sincerity, gratitude, and modest beauty.', 1, 'assets/img/items/roses/rose_10.jpg'],
    [11, 'Sunshine Roses', 26.00, 19.00, 'Roses', 'Yellow', 'A cheerful bouquet of bright yellow roses to light up any room.', 1, 'assets/img/items/roses/rose_6.jpg'],
    [12, 'Royal Purple', 38.00, 19.00, 'Roses', 'Purple', 'Regal purple roses that signify majesty, elegance, and success.', 1, 'assets/img/items/roses/rose_12.jpg'],
    [13, 'Sweet Sixteen', 32.00, 25.00, 'Roses', 'Pink', 'A youthful and sweet arrangement of pink roses for special celebrations.', 1, 'assets/img/items/roses/rose_2.jpg'],
    [14, 'Forever Love', 42.00, 20.00, 'Roses', 'Red/Pink Mix', 'A premium mix of red and pink roses symbolizing eternal devotion.', 1, 'assets/img/items/roses/rose_5.jpg'],
    
    // Lily products (15-20)
    [15, 'White Lily Paradise', 32.00, 25.00, 'Lilies', 'White', 'Majestic white lilies that bring peace and serenity to any space.', 1, 'assets/img/items/lilys/lily_10.jpg'],
    [16, 'Pink Lily Perfection', 30.00, 24.00, 'Lilies', 'Pink', 'Stunning pink lilies that represent prosperity and abundance.', 1, 'assets/img/items/lilys/lily_2.jpg'],
    [17, 'Oriental Lilies', 38.00, 27.00, 'Lilies', 'White/Pink', 'Fragrant oriental lilies known for their large, showy blooms.', 1, 'assets/img/items/lilys/lily_6.jpg'],
    [18, 'Stargazer Lilies', 28.00, 20.00, 'Lilies', 'Pink/White', 'Famous stargazer lilies with their bold spots and heavenly scent.', 1, 'assets/img/items/lilys/lily_4.jpg'],
    [19, 'Golden Lilies', 34.00, 27.00, 'Lilies', 'Yellow/Orange', 'Bright golden lilies that symbolize energy, warmth, and confidence.', 1, 'assets/img/items/lilys/lily_7.jpg'],
    [20, 'Royal Lilies', 40.00, 30.00, 'Lilies', 'Purple', 'Deep purple lilies that exude luxury and sophistication.', 1, 'assets/img/items/lilys/lily_9.jpg'],
    
    // Sunflower products (21-30)
    [21, 'Sunny Sunflower', 25.00, 30.00, 'Sunflowers', 'Yellow', 'Classic bright sunflowers that follow the sun and spread happiness.', 1, 'assets/img/items/sunflowers/sunflower_2.jpg'],
    [22, 'Golden Rays', 28.00, 28.00, 'Sunflowers', 'Gold', 'Beautiful golden sunflowers that represent loyalty and adoration.', 1, 'assets/img/items/sunflowers/sunflower_2.jpg'],
    [23, 'Sunflower Bliss', 30.00, 30.00, 'Sunflowers', 'Yellow', 'A blissful arrangement of fresh sunflowers to brighten someone\'s day.', 1, 'assets/img/items/sunflowers/sunflower_3.jpg'],
    [24, 'Sunshine Bundle', 32.00, 28.00, 'Sunflowers', 'Yellow', 'A generous bundle of sunflowers, perfect for celebrations.', 1, 'assets/img/items/sunflowers/sunflower_4.jpg'],
    [25, 'Bright Sunflowers', 29.00, 22.00, 'Sunflowers', 'Yellow', 'Naturally bright sunflowers that symbolize vitality and longevity.', 1, 'assets/img/items/sunflowers/sunflower_6.jpg'],
    [26, 'Yellow Happiness', 34.00, 35.00, 'Sunflowers', 'Yellow', 'A cheerful collection of yellow sunflowers for pure joy.', 1, 'assets/img/items/sunflowers/sunflower_6.jpg'],
    [27, 'Sunflower Dreams', 31.00, 24.00, 'Sunflowers', 'Yellow', 'Dreamy sunflowers that bring a touch of the countryside indoors.', 1, 'assets/img/items/sunflowers/sunflower_3.jpg'],
    [28, 'Golden Harvest', 35.00, 17.00, 'Sunflowers', 'Gold/Yellow', 'A rich harvest-themed sunflower arrangement.', 1, 'assets/img/items/sunflowers/sunflower_2.jpg'],
    [29, 'Summer Sunshine', 27.00, 22.00, 'Sunflowers', 'Yellow', 'Capturing the essence of summer with vibrant yellow sunflowers.', 1, 'assets/img/items/sunflowers/sunflower_4.jpg'],
    [30, 'Sunflower Giant Heart', 38.00, 28.00, 'Sunflowers', 'Yellow', 'A large, heart-shaped sunflower arrangement for someone special.', 1, 'assets/img/items/sunflowers/sunflower_10.jpg'],
    
    // Buttercup products (40-44)
    [40, 'Golden Buttercup', 20.00, 14.00, 'Buttercups', 'Yellow', 'Sweet and simple yellow buttercups that signify neatness and charm.', 1, 'assets/img/items/buttercup/buttercup.jpg'],
    [41, 'Buttercup Elegance', 24.00, 16.00, 'Buttercups', 'Yellow', 'Elegant buttercups with delicate petals for a refined look.', 1, 'assets/img/items/buttercup/modernbuttercup.jpg'],
    [42, 'Premium Buttercup', 32.00, 22.00, 'Buttercups', 'Yellow', 'A premium selection of the finest yellow buttercups.', 1, 'assets/img/items/buttercup/buttercup6.jpg'],
    [43, 'Orange Sunshine', 28.00, 17.00, 'Buttercups', 'Orange', 'Rare orange buttercups that bring a unique warmth and energy.', 1, 'assets/img/items/buttercup/orangebuttercup.jpg'],
    [44, 'Buttercup Dreams', 22.00, 14.00, 'Buttercups', 'Pink', 'Lovely pink buttercups for a soft and romantic touch.', 1, 'assets/img/items/buttercup/pinkbuttercup.jpg'],
    
    // Daisy products (45-50)
    [45, 'Daisy Dreams', 28.00, 17.00, 'Daisies', 'White', 'Classic white daisies with yellow centers, representing innocence.', 1, 'assets/img/items/daisies/daisy.jpg'],
    [46, 'Sweet Daisies', 30.00, 20.00, 'Daisies', 'White/Yellow', 'Sweet and simple daisies to brighten any mood.', 1, 'assets/img/items/daisies/beautifuldaisy.jpg'],
    [47, 'Daisy Perfection', 32.00, 20.00, 'Daisies', 'White', 'Perfectly bloomed daisies for a fresh and clean look.', 1, 'assets/img/items/daisies/daisies.jpg'],
    [48, 'White Daisies', 35.00, 26.00, 'Daisies', 'White', 'Pure white daisies for a classic and timeless gift.', 1, 'assets/img/items/daisies/whitedaisy.jpg'],
    [49, 'Daisy Sunshine', 31.00, 24.00, 'Daisies', 'Yellow', 'Bright yellow daisies that symbolize joy and happiness.', 1, 'assets/img/items/daisies/daisy.jpg'],
    [50, 'Blue Paradise Daisy', 26.00, 17.00, 'Daisies', 'Blue', 'Unique blue-tinted daisies for a touch of paradise.', 1, 'assets/img/items/daisies/prettybluedaisy.jpg'],
    
    // Mini Rose products (51-56)
    [51, 'Mini Rose Pink', 26.00, 17.00, 'Mini Roses', 'Pink', 'Adorable small pink roses, perfect for desk decor or small gifts.', 1, 'assets/img/items/minirose/pinkybabyrosie.jpg'],
    [52, 'Mini Rose Red', 28.00, 14.00, 'Mini Roses', 'Red', 'Small but passionate red roses in a cute mini bouquet.', 1, 'assets/img/items/minirose/redminirose.jpg'],
    [53, 'Mini Rose Gold', 30.00, 24.00, 'Mini Roses', 'Gold/Yellow', 'Beautiful golden-yellow mini roses for a touch of luxury.', 1, 'assets/img/items/minirose/goldenrosie.jpg'],
    [54, 'Ocean Breeze Mini Roses', 29.00, 19.00, 'Mini Roses', 'Blue', 'Rare blue mini roses that evoke a sense of calm and mystery.', 1, 'assets/img/items/minirose/oceanrosie.jpg'],
    [55, 'Mini Rose Romance', 32.00, 22.00, 'Mini Roses', 'Pink', 'Romantic pink mini roses for a sweet gesture.', 1, 'assets/img/items/minirose/prettypinkyrosie.jpg'],
    [56, 'Fairy White Mini Roses', 34.00, 16.00, 'Mini Roses', 'White', 'Delicate white mini roses that look like they belong in a fairytale.', 1, 'assets/img/items/minirose/fairywhiterosie.jpg'],
    
    // Daffodil products (57-61)
    [57, 'Daffodil Yellow', 24.00, 16.00, 'Daffodils', 'Yellow', 'Classic yellow daffodils that signal the arrival of spring.', 1, 'assets/img/items/daffodils/babydaffoldis.jpg'],
    [58, 'Golden Daffodil', 22.00, 17.00, 'Daffodils', 'Gold', 'Golden yellow daffodils representing rebirth and new beginnings.', 1, 'assets/img/items/daffodils/gorgousdaffoldils.jpg'],
    [59, 'Spring Daffodil', 28.00, 22.00, 'Daffodils', 'Yellow/White', 'A fresh spring mix of yellow and white daffodils.', 1, 'assets/img/items/daffodils/daffoldilsss.jpg'],
    [60, 'Lavender Daffodil', 32.00, 22.00, 'Daffodils', 'Purple/Lavender', 'Unique lavender-toned daffodils for a creative floral gift.', 1, 'assets/img/items/daffodils/lavenderdaffoldils.jpg'],
    [61, 'Sunny Daffodils', 26.00, 17.00, 'Daffodils', 'Light Yellow', 'Light yellow daffodils that bring a soft sunshine to any room.', 1, 'assets/img/items/daffodils/lightyellowdaffoldils.jpg'],
    
    // Birthday/Special products (62-73)
    [62, 'Birthday Bouquet', 35.00, 28.00, 'Special Occasions', 'Mixed', 'A colorful mixed bouquet designed specifically for birthdays.', 1, 'assets/img/items/popular/popular_1.jpg'],
    [63, 'Birthday Special', 32.00, 25.00, 'Special Occasions', 'Mixed', 'A special arrangement of seasonal flowers for a birthday surprise.', 1, 'assets/img/items/popular/popular_2.jpg'],
    [64, 'Happy Birthday Mix', 30.00, 24.00, 'Special Occasions', 'Mixed', 'A happy and vibrant mix of flowers to celebrate another year.', 1, 'assets/img/items/popular/popular_3.jpg'],
    [65, 'Birthday Joy', 28.00, 22.00, 'Special Occasions', 'Yellow/Pink', 'Joyful colors of yellow and pink to bring birthday smiles.', 1, 'assets/img/items/popular/popular_4.jpg'],
    [66, 'Celebration Bundle', 50.00, 42.00, 'Special Occasions', 'Mixed', 'A large bundle of flowers and accessories for a grand celebration.', 1, 'assets/img/items/popular/popular_5.jpg'],
    [67, 'Grand Birthday', 48.00, 39.00, 'Special Occasions', 'Mixed', 'A premium, large-scale bouquet for a milestone birthday.', 1, 'assets/img/items/popular/popular_6.jpg'],
    [68, 'Birthday Elegance', 38.00, 31.00, 'Special Occasions', 'White/Pink', 'An elegant and sophisticated arrangement for a refined birthday.', 1, 'assets/img/items/popular/popular_7.jpg'],
    [69, 'Birthday Bliss', 36.00, 29.00, 'Special Occasions', 'Mixed', 'Pure bliss in a vase, featuring a mix of the season\'s best blooms.', 1, 'assets/img/items/popular/popular_8.jpg'],
    [70, 'Birthday Premium', 42.00, 34.00, 'Special Occasions', 'Mixed', 'Our finest selection of flowers in a premium birthday arrangement.', 1, 'assets/img/items/popular/popular_1.jpg'],
    [71, 'Birthday Star', 34.00, 27.00, 'Special Occasions', 'Yellow/Gold', 'For the star of the day! Bright yellow and gold flowers.', 1, 'assets/img/items/popular/popular_2.jpg'],
    [72, 'Birthday Magic', 30.00, 24.00, 'Special Occasions', 'Purple/Pink', 'A magical mix of purple and pink flowers for a special day.', 1, 'assets/img/items/popular/popular_3.jpg'],
    [73, 'Birthday Perfection', 28.00, 22.00, 'Special Occasions', 'Mixed', 'Simple, perfect, and beautiful floral gift for birthdays.', 1, 'assets/img/items/popular/popular_4.jpg'],
    
    // Gifts & Chocolates (74-86)
    [74, 'Cute Teddy Bear', 24.99, 22.00, 'Gifts', 'Brown', 'A soft and cuddly brown teddy bear, perfect for hugging.', 0, 'assets/img/items/bear/bear_1.jpg'],
    [75, 'Ruby Red Romance', 38.00, 24.00, 'Roses', 'Red', 'Deep red roses that symbolize passionate love and romance.', 1, 'assets/img/items/roses/rose_5.jpg'],
    [76, 'Choco Delight', 28.00, 30.00, 'Chocolates', 'Dark Brown', 'A delicious selection of assorted milk and dark chocolates.', 0, 'assets/img/items/chocolate/chocolate_4.jpg'],
    [77, 'Huggable Teddy', 22.00, 22.00, 'Gifts', 'Cream', 'An extra-soft cream-colored teddy bear for a warm hug.', 0, 'assets/img/items/bear/bear_2.jpg'],
    [78, 'Cozy Bear Friend', 20.00, 14.00, 'Gifts', 'Light Brown', 'A cozy companion bear with a friendly face.', 0, 'assets/img/items/bear/bear_3.jpg'],
    [79, 'Blush Pink Roses', 32.00, 21.00, 'Roses', 'Pink', 'Soft pink roses that represent grace and elegance.', 1, 'assets/img/items/roses/rose_7.jpg'],
    [80, 'Luxury Teddy', 35.00, 14.00, 'Gifts', 'White', 'A premium, high-quality white teddy bear with a silk ribbon.', 0, 'assets/img/items/bear/bear_6.jpg'],
    [81, 'Premium Bear', 34.00, 14.00, 'Gifts', 'Grey', 'A stylish grey bear, part of our premium gift collection.', 0, 'assets/img/items/bear/bear_7.jpg'],
    [82, 'Dark Chocolate Box', 32.00, 27.00, 'Chocolates', 'Black/Gold', 'A luxury box of intense dark chocolates for connoisseurs.', 0, 'assets/img/items/chocolate/chocolate_1.jpg'],
    [83, 'Heart Chocolate Box', 38.00, 28.00, 'Chocolates', 'Red', 'A heart-shaped box filled with romantic chocolate truffles.', 0, 'assets/img/items/chocolate/chocolate_2.jpg'],
    [84, 'Caramel Treats', 34.00, 25.00, 'Chocolates', 'Brown/Gold', 'Smooth caramel-filled chocolates that melt in your mouth.', 0, 'assets/img/items/chocolate/chocolate_3.jpg'],
    [85, 'Sweet Chocolate Mix', 36.00, 32.00, 'Chocolates', 'Multi', 'A diverse mix of our most popular chocolate flavors.', 0, 'assets/img/items/chocolate/chocolate_5.jpg'],
    [86, 'Premium Choco Set', 45.00, 36.00, 'Chocolates', 'Gold', 'A gold-standard chocolate set for a truly impressive gift.', 0, 'assets/img/items/chocolate/chocolate_4.jpg'],
    
    // Tulips & Mixed (87-95)
    [87, 'Rainbow Romance Roses', 42.00, 25.00, 'Roses', 'Multicolor', 'A vibrant mix of multi-colored roses for a fun and romantic gift.', 1, 'assets/img/items/roses/rose_2.jpg'],
    [88, 'Pink Galaxy Lilies', 35.00, 22.00, 'Lilies', 'Pink/Purple', 'Lilies that look like a starry galaxy with pink and purple hues.', 1, 'assets/img/items/lilys/lily_4.jpg'],
    [89, 'Ruby Red Tulip Bouquet', 30.00, 24.00, 'Tulips', 'Red', 'Elegant red tulips that symbolize perfect and deep love.', 1, 'assets/img/items/tulips/tulip_6.jpg'],
    [90, 'Pretty Pink Rosie Bunch', 32.00, 20.00, 'Mini Roses', 'Pink', 'A generous bunch of pink mini roses for a soft, lovely look.', 1, 'assets/img/items/minirose/prettypinkyrosie.jpg'],
    [91, 'Elegant White Tulips', 34.00, 27.00, 'Tulips', 'White', 'Classic white tulips representing worthiness and forgiveness.', 1, 'assets/img/items/tulips/tulip_1.jpg'],
    [92, 'Golden Sunset Mix', 38.00, 30.00, 'Mixed', 'Orange/Gold', 'A warm mix of orange, yellow, and golden flowers like a sunset.', 1, 'assets/img/items/mixed/mixed_1.jpg'],
    [93, 'Romantic Bouquet', 45.00, 36.00, 'Mixed', 'Red/Pink', 'A lush, romantic mix of roses and lilies in red and pink.', 1, 'assets/img/items/mixed/mixed_2.jpg'],
    [94, 'Blush Blossom Bundle', 36.00, 25.00, 'Mixed', 'Blush/Pink', 'A delicate bundle of blush-toned blossoms and greenery.', 1, 'assets/img/items/mixed/mixed_3.jpg'],
    [95, 'Garden Fresh Mix', 40.00, 32.00, 'Mixed', 'Green/White/Pink', 'A fresh-from-the-garden look with whites, pinks, and lush greens.', 1, 'assets/img/items/mixed/mixed_6.jpg'],
    [96, 'Rosy Daisy Garden', 32.00, 20.00, 'Daisies', 'Pink/White', 'A charming mix of pink roses and white daisies.', 1, 'assets/img/items/daisies/rosiedaisie.jpg'],
    [98, 'Golden Spring Elegance', 34.00, 19.00, 'Daffodils', 'Gold/Yellow', 'The finest golden daffodils for a touch of spring elegance.', 1, 'assets/img/items/daffodils/gorgousdaffoldils.jpg'],
    [100, 'Classic Sunflower Bouquet', 30.00, 14.00, 'Sunflowers', 'Yellow', 'A large, classic bouquet of premium yellow sunflowers.', 1, 'assets/img/items/sunflowers/sunflower_2.jpg'],
    [101, 'Cute Bear Gift Set', 38.00, 25.00, 'Gifts', 'Multi', 'A complete gift set featuring a teddy bear and small flower box.', 0, 'assets/img/items/other/c6.jpg'],
    [102, 'Mini Succulent Tray', 35.00, 27.00, 'Gifts', 'Green', 'A collection of easy-to-care-for mini succulents.', 1, 'assets/img/items/other/c10.jpg'],
    [103, 'Mini Garden Gift', 48.00, 28.00, 'Gifts', 'Green/Mixed', 'A miniature indoor garden in a beautiful container.', 1, 'assets/img/items/other/Mini Garden Gift.jpg'],
    [105, 'Tea Time Basket', 45.00, 30.00, 'Gifts', 'Tan/Mixed', 'A thoughtful gift basket with tea, treats, and a small flower bunch.', 0, 'assets/img/items/other/s3.jpg'],
    [108, 'Tulip Mix Color VIP', 48.00, 42.00, 'VIP', 'Multicolor', 'A luxury assortment of multi-colored tulips for a grand gesture.', 1, 'assets/img/items/vip/vip_1.jpg'],
    [109, 'Tulips Luxury VIP', 50.00, 45.00, 'VIP', 'Purple/Pink', 'Our most exclusive purple and pink tulips in a luxury arrangement.', 1, 'assets/img/items/vip/vip_2.jpg'],
    
    // NEW ORANGE FLOWERS (to satisfy user request)
    [110, 'Orange Zest Bouquet', 32.00, 48.00, 'Mixed', 'Orange', 'A vibrant zest of orange blooms mixed with seasonal greenery.', 1, 'assets/img/items/buttercup/orangebuttercup.jpg'],
    [111, 'Tangerine Dream', 38.00, 46.00, 'Roses', 'Orange', 'Bright tangerine-colored roses that symbolize energy and passion.', 1, 'assets/img/items/roses/rose_5.jpg'],
    [112, 'Autumn Glow', 35.00, 50.00, 'Mixed', 'Orange/Yellow', 'A warm autumn-inspired bouquet with orange and yellow tones.', 1, 'assets/img/items/mixed/mixed_1.jpg'],
];

$stmt = $conn->prepare('INSERT INTO products (id, name, price, sale_price, category, color, description, is_flower, image_url, is_active) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1)
                       ON DUPLICATE KEY UPDATE 
                       name=VALUES(name), price=VALUES(price), sale_price=VALUES(sale_price), 
                       category=VALUES(category), color=VALUES(color), description=VALUES(description), 
                       is_flower=VALUES(is_flower), image_url=VALUES(image_url)');
$count = 0;
foreach ($products as $p) {
    $stmt->bind_param('isddsssis', $p[0], $p[1], $p[2], $p[3], $p[4], $p[5], $p[6], $p[7], $p[8]);
    if ($stmt->execute()) {
        $count++;
    }
}
$stmt->close();
echo "   ✓ Updated $count products with rich details and colors\n";

// Step 3: Create default users if not exists
echo "\n3️⃣  Checking test user...\n";
$username = 'demo';
$checkUser = $conn->query("SELECT id FROM users WHERE username = '$username'");
if ($checkUser->num_rows === 0) {
    $stmt = $conn->prepare('INSERT INTO users (username, first_name, last_name, email, password_hash, is_active) VALUES (?, ?, ?, ?, ?, 1)');
    $firstName = 'Demo';
    $lastName = 'User';
    $email = 'demo@liora.shop';
    $passwordHash = password_hash('demo123', PASSWORD_BCRYPT);
    $stmt->bind_param('sssss', $username, $firstName, $lastName, $email, $passwordHash);
    $stmt->execute();
    $userId = $conn->insert_id;
    $stmt->close();
    echo "   ✓ Test user created (ID: $userId)\n";
} else {
    echo "   ✓ Test user already exists\n";
}

echo "\n4️⃣  Checking admin users...\n";
liora_sync_admin_accounts($conn, true);
foreach (liora_admin_accounts() as $admin) {
    echo "   ✓ Admin account ready: {$admin['email']}\n";
}

// Verify
echo "\n✅ Database setup complete!\n";
$result = $conn->query('SELECT COUNT(*) as count FROM products WHERE is_active = 1');
$row = $result->fetch_assoc();
echo "   Total active products: " . $row['count'] . "\n";
?>
