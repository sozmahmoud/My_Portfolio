<?php
session_start();
header('Content-Type: application/json');
require_once 'config.php';

$user_id = $_SESSION['user_id'] ?? 0;
$user_name = $_SESSION['first_name'] ?? 'Customer';

// Check if user is logged in
if ($user_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Please log in to use the chatbot.']);
    exit;
}

// Get POST data
$input = json_decode(file_get_contents('php://input'), true);
$message = $input['message'] ?? '';

if (empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Empty message']);
    exit;
}

$apiKey = defined('OPENAI_API_KEY') ? OPENAI_API_KEY : '';
// Fallback if user hasn't set OpenAI key but set Gemini
if (empty($apiKey) || strpos($apiKey, 'sk-proj-placeholder') !== false) {
    echo json_encode(['success' => false, 'message' => 'API Key not configured. Please add your OpenAI API Key to config.php.']);
    exit;
}

// 1. Fetch Chat History (Last 10 messages)
$messages_for_api = [];

// System Prompt
$system_prompt = "You are Liora, the expert AI Florist for 'Liora' luxury shop. You are speaking with $user_name.\n\n";

$path = __DIR__ . '/CHATBOT_TRAINING_DATA.md';
if (file_exists($path)) {
    $system_prompt .= file_get_contents($path) . "\n\n";
}

// 2. Fetch ALL products - Focus on accuracy
$products_query = $conn->query("SELECT id, name, category, color, is_flower, description FROM products WHERE is_active = 1");
$products_text = "";
while ($row = $products_query->fetch_assoc()) {
    $type = $row['is_flower'] ? "Flower" : "Gift";
    $products_text .= "ID:{$row['id']} | Name:{$row['name']} | Cat:{$row['category']} | Type:$type | Color:{$row['color']} | Desc:{$row['description']}\n";
}

$system_prompt .= "### CATALOG KNOWLEDGE (STRICT):\nBelow is the ONLY list of products you can recommend. You MUST follow the 'Color' field exactly.\n$products_text\n\n";
$system_prompt .= "### ABSOLUTE RULES:
1. **PRODUCT CARDS**: When you want to recommend a product, you MUST output [PRODUCT:id] where id is the numeric ID from the catalog above. The website will automatically convert this into a beautiful product frame that the user can click.
   - Example: \"I highly recommend the [PRODUCT:12] for this occasion.\"
2. **PAGE LINKS**: If the user asks for a specific category like sunflowers, mention that they can view the dedicated page! (e.g. 'You can also see more on our Sunflowers page at sunflower.php'). The pages available are: sunflower.php, rose.php, tulip.php, orchids.php, lily.php, daisies.php, mother.php, valentine.php, etc.
3. **COLOR & CATEGORY PURITY**: Only recommend items that actually match the request based on the catalog.
4. **FORMATTING**: Use elegant language, keep responses concise but warm, and use emojis (🌷, 🌹, 🌸). Use markdown formatting for readability.
5. **MEMORY**: You have access to the chat history. Refer to previous choices if relevant.

### RESPONSE STRUCTURE:
- Friendly greeting or acknowledgment.
- Direct emotional and helpful answer based on training data.
- Recommend 2-3 specific items using [PRODUCT:id] in the text.
- Optionally mention the category page if they asked for a specific flower type.";

$messages_for_api[] = [
    "role" => "system",
    "content" => $system_prompt
];

if ($user_id > 0) {
    $stmt = $conn->prepare("SELECT role, message FROM chat_history WHERE user_id = ? ORDER BY created_at ASC LIMIT 10");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        // Map database roles to OpenAI roles
        $role = ($row['role'] === 'model' || $row['role'] === 'assistant') ? 'assistant' : 'user';
        $messages_for_api[] = [
            "role" => $role,
            "content" => $row['message']
        ];
    }
    $stmt->close();
}

// Add current message
$messages_for_api[] = [
    "role" => "user",
    "content" => $message
];

$url = "https://api.openai.com/v1/chat/completions";
$data = [
    "model" => "gpt-4o-mini", // Very fast, cost-effective, high quality
    "messages" => $messages_for_api,
    "temperature" => 0.7,
    "max_tokens" => 500
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey
]);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 30); // 30-second timeout to prevent freezing 

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

if ($httpCode === 200) {
    require_once 'map_product_id.php';
    $result = json_decode($response, true);
    
    $aiResponse = $result['choices'][0]['message']['content'] ?? "I'm sorry, I couldn't process that.";
    
    // Convert markdown to simple HTML for frontend
    $aiResponse = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $aiResponse);
    $aiResponse = nl2br($aiResponse);
    
    // 3. Save to History (if logged in)
    if ($user_id > 0) {
        // We use 'assistant' as role in the DB to align better, or keep 'model' for backward compatibility
        $stmt = $conn->prepare("INSERT INTO chat_history (user_id, role, message) VALUES (?, 'user', ?), (?, 'model', ?)");
        $stmt->bind_param("isis", $user_id, $message, $user_id, $aiResponse);
        $stmt->execute();
        $stmt->close();
    }

    // Parse for [PRODUCT:id]
    $found_products = [];
    preg_match_all('/\[PRODUCT:(\d+)\]/', $aiResponse, $matches);
    
    if (!empty($matches[1])) {
        $ids = array_unique($matches[1]);
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $conn->prepare("SELECT id, name, price, sale_price, category, image_url, description FROM products WHERE id IN ($placeholders)");
        $stmt->bind_param(str_repeat('i', count($ids)), ...$ids);
        $stmt->execute();
        $db_res = $stmt->get_result();
        
        while ($row = $db_res->fetch_assoc()) {
            $row['slug'] = getStringId($row['id']);
            $staticData = getStaticProductById($row['id']);
            if ($staticData && !empty($staticData['link'])) {
                $row['link'] = $staticData['link'];
            }
            $found_products[] = $row;
        }
        $stmt->close();
    }

    echo json_encode([
        'success' => true, 
        'reply' => $aiResponse,
        'products' => $found_products
    ]);
} else {
    echo json_encode([
        'success' => false, 
        'message' => 'API Error', 
        'details' => $response,
        'curl_error' => $curlError
    ]);
}
?>
