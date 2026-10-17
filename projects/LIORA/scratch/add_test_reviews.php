<?php
include 'config.php';
$productId = 1;
$userIds = [1, 2, 3, 4, 5]; // Assuming these exist or I'll just use random ones if they don't have FK constraints or if they do I'll find existing ones
$ratings = [5, 5, 4, 3, 5, 4, 5, 2, 5, 5];
$comments = ["Beautiful!", "Loved it", "Pretty good", "Okay", "Amazing", "Very nice", "The best!", "Not what I expected", "Perfect", "Wow"];

foreach ($ratings as $index => $rating) {
    $comment = $comments[$index];
    $userId = ($index % 5) + 1; // 1, 2, 3, 4, 5
    $conn->query("INSERT IGNORE INTO reviews (user_id, product_id, rating, comment) VALUES ($userId, $productId, $rating, '$comment')");
}
echo "Done adding reviews for product 1\n";
?>
