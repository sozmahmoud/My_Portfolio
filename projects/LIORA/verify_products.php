<?php
// Database connection
$host = 'localhost';
$db = 'liora_db';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== PRODUCT DATABASE VERIFICATION ===\n\n";
    
    // 1. Total count of products
    $totalStmt = $pdo->query("SELECT COUNT(*) as total FROM products");
    $total = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'];
    echo "1. TOTAL PRODUCTS: $total\n\n";
    
    // 2. Count by category
    echo "2. COUNT BY CATEGORY:\n";
    $categoryStmt = $pdo->query("SELECT category, COUNT(*) as count FROM products GROUP BY category ORDER BY category");
    while ($row = $categoryStmt->fetch(PDO::FETCH_ASSOC)) {
        echo "   - {$row['category']}: {$row['count']}\n";
    }
    echo "\n";
    
    // 3. Product ID range (using id column)
    echo "3. PRODUCT ID RANGE:\n";
    $rangeStmt = $pdo->query("SELECT MIN(id) as min_id, MAX(id) as max_id FROM products");
    $range = $rangeStmt->fetch(PDO::FETCH_ASSOC);
    echo "   - Min ID: {$range['min_id']}\n";
    echo "   - Max ID: {$range['max_id']}\n\n";
    
    // 4. Random products from different categories
    echo "4. RANDOM PRODUCTS FROM DIFFERENT CATEGORIES:\n";
    $categoriesStmt = $pdo->query("SELECT DISTINCT category FROM products ORDER BY category");
    $categories = $categoriesStmt->fetchAll(PDO::FETCH_COLUMN);
    
    foreach ($categories as $category) {
        $randomStmt = $pdo->prepare("SELECT * FROM products WHERE category = ? ORDER BY RAND() LIMIT 1");
        $randomStmt->execute([$category]);
        $product = $randomStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($product) {
            echo "\n   Category: {$category}\n";
            echo "   - Product ID: {$product['id']}\n";
            echo "   - Name: {$product['name']}\n";
            echo "   - Price: {$product['price']}\n";
            echo "   - Sale Price: {$product['sale_price']}\n";
            echo "   - Stock: {$product['stock']}\n";
            if (isset($product['description'])) {
                echo "   - Description: " . substr($product['description'], 0, 60) . "...\n";
            }
        }
    }
    
    echo "\n=== VERIFICATION COMPLETE ===\n";
    
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>
