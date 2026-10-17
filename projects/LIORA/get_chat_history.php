<?php
session_start();
header('Content-Type: application/json');
require_once 'config.php';

$user_id = $_SESSION['user_id'] ?? 0;

if ($user_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Not logged in', 'history' => []]);
    exit;
}

// Handle DELETE request to clear history
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $stmt = $conn->prepare("DELETE FROM chat_history WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Chat history cleared']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to clear chat history']);
    }
    $stmt->close();
    exit;
}

// Fetch last 20 messages for display (most recent first for history list)
$stmt = $conn->prepare("SELECT role, message, created_at FROM chat_history WHERE user_id = ? ORDER BY created_at DESC LIMIT 20");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();

require_once 'map_product_id.php';

$history = [];
while ($row = $res->fetch_assoc()) {
    // Format timestamp for display
    $timestamp = date('M j, g:i A', strtotime($row['created_at']));
    
    // Parse for [PRODUCT:id]
    $found_products = [];
    preg_match_all('/\[PRODUCT:(\d+)\]/', $row['message'], $matches);
    
    if (!empty($matches[1])) {
        $ids = array_unique($matches[1]);
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $prod_stmt = $conn->prepare("SELECT id, name, price, sale_price, category, image_url, description FROM products WHERE id IN ($placeholders)");
        $prod_stmt->bind_param(str_repeat('i', count($ids)), ...$ids);
        $prod_stmt->execute();
        $db_res = $prod_stmt->get_result();
        
        while ($prod_row = $db_res->fetch_assoc()) {
            $prod_row['slug'] = getStringId($prod_row['id']);
            $staticData = getStaticProductById($prod_row['id']);
            if ($staticData && !empty($staticData['link'])) {
                $prod_row['link'] = $staticData['link'];
            }
            $found_products[] = $prod_row;
        }
        $prod_stmt->close();
    }

    $history[] = [
        'role' => $row['role'],
        'message' => $row['message'],
        'timestamp' => $timestamp,
        'products' => $found_products
    ];
}
$stmt->close();

// Reverse the array so oldest messages come first for chat window replay
$history = array_reverse($history);

echo json_encode(['success' => true, 'history' => $history]);
?>
