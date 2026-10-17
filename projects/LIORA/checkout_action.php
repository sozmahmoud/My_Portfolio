<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
include 'config.php';
include 'reward_helper.php';
require_once 'map_product_id.php';

if (!$conn || $conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.'], JSON_UNESCAPED_UNICODE);
    exit;
}

$userId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
if ($userId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Please log in to complete checkout.', 'logged_in' => false]);
    exit;
}

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

function sendResponse($data) {
    echo json_encode($data);
    exit;
}

function prepareStatement($conn, $query) {
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception('Database prepare error: ' . $conn->error);
    }
    return $stmt;
}

function executeStatement($stmt) {
    if (!$stmt->execute()) {
        throw new Exception('Database execute error: ' . $stmt->error);
    }
}

function getCartItems($conn, $userId) {
    $stmt = $conn->prepare(
        'SELECT ci.product_id AS id, ci.quantity, ci.options, ci.product_type, ci.variant, COALESCE(p.sale_price, p.price) AS price, p.stock, p.name
         FROM cart_items ci
         JOIN products p ON ci.product_id = p.id
         WHERE ci.user_id = ?'
    );
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $items = [];
    while ($row = $result->fetch_assoc()) {
        $staticProduct = getStaticProductById($row['id']);
        $price = isset($staticProduct['price']) ? floatval($staticProduct['price']) : floatval($row['price']);
        $items[] = [
            'id' => intval($row['id']),
            'quantity' => intval($row['quantity']),
            'price' => $price,
            'options' => $row['options'],
            'product_type' => $row['product_type'],
            'variant' => $row['variant'],
            'stock' => intval($row['stock']),
            'name' => $row['name']
        ];
    }
    $stmt->close();
    return $items;
}

function getPostedField($key) {
    return isset($_POST[$key]) ? trim((string) $_POST[$key]) : '';
}

function isValidLuhnNumber($number) {
    $digits = preg_replace('/\D+/', '', (string) $number);
    $sum = 0;
    $shouldDouble = false;

    for ($i = strlen($digits) - 1; $i >= 0; $i--) {
        $digit = intval($digits[$i]);

        if ($shouldDouble) {
            $digit *= 2;
            if ($digit > 9) {
                $digit -= 9;
            }
        }

        $sum += $digit;
        $shouldDouble = !$shouldDouble;
    }

    return strlen($digits) >= 13 && $sum % 10 === 0;
}

function isValidFixedCardNumber($number, $digitCount = 16) {
    $digits = preg_replace('/\D+/', '', (string) $number);
    return strlen($digits) === $digitCount;
}

function normalizeDeliveryTime($time) {
    $time = trim((string) $time);

    if (preg_match('/^(0[1-9]|1[0-2]):(0[1-9]|[1-5][0-9]|60) (am|pm)$/i', $time, $matches)) {
        $hours = intval($matches[1]);
        $minutes = intval($matches[2]);
        $period = strtolower($matches[3]);

        if ($period === 'pm' && $hours !== 12) {
            $hours += 12;
        }

        if ($period === 'am' && $hours === 12) {
            $hours = 0;
        }

        if ($minutes === 60) {
            $hours = ($hours + 1) % 24;
            $minutes = 0;
        }

        return sprintf('%02d:%02d', $hours, $minutes);
    }

    if (preg_match('/^([01]\d|2[0-3]):([0-5]\d)$/', $time)) {
        return $time;
    }

    return null;
}

function getCouponDiscountRate($code) {
    $code = strtoupper(trim((string) $code));
    $rates = [
        'LOVE10' => 0.10,
        'SPRING15' => 0.15,
        'SUMMER20' => 0.20
    ];

    return $rates[$code] ?? 0.0;
}

function getCartVolumeDiscount($subtotal) {
    return $subtotal >= 50 ? $subtotal * 0.10 : 0.0;
}

function getCartShippingCost($subtotal) {
    return $subtotal >= 75 ? 0.0 : 10.0;
}

function columnExists($conn, $tableName, $columnName) {
    $query = "SELECT 1
              FROM information_schema.COLUMNS
              WHERE TABLE_SCHEMA = DATABASE()
                AND TABLE_NAME = ?
                AND COLUMN_NAME = ?
              LIMIT 1";
    $stmt = prepareStatement($conn, $query);
    $stmt->bind_param('ss', $tableName, $columnName);
    executeStatement($stmt);
    $result = $stmt->get_result();
    $exists = $result && $result->num_rows > 0;
    $stmt->close();
    return $exists;
}

function ensureOrderColumns($conn) {
    $requiredColumns = [
        'customer_name' => "ALTER TABLE orders ADD COLUMN customer_name VARCHAR(255) NULL AFTER total",
        'customer_email' => "ALTER TABLE orders ADD COLUMN customer_email VARCHAR(255) NULL AFTER customer_name",
        'address' => "ALTER TABLE orders ADD COLUMN address VARCHAR(255) NULL AFTER customer_email",
        'city' => "ALTER TABLE orders ADD COLUMN city VARCHAR(100) NULL AFTER address",
        'country' => "ALTER TABLE orders ADD COLUMN country VARCHAR(100) NULL AFTER city",
        'postcode' => "ALTER TABLE orders ADD COLUMN postcode VARCHAR(50) NULL AFTER country",
        'phone' => "ALTER TABLE orders ADD COLUMN phone VARCHAR(50) NULL AFTER postcode",
        'delivery_date' => "ALTER TABLE orders ADD COLUMN delivery_date DATE NULL AFTER phone",
        'delivery_time' => "ALTER TABLE orders ADD COLUMN delivery_time TIME NULL AFTER delivery_date",
        'gift_message' => "ALTER TABLE orders ADD COLUMN gift_message TEXT NULL AFTER delivery_time",
        'order_note' => "ALTER TABLE orders ADD COLUMN order_note TEXT NULL AFTER gift_message",
        'payment_method' => "ALTER TABLE orders ADD COLUMN payment_method VARCHAR(100) NULL AFTER order_note",
        'coupon_code' => "ALTER TABLE orders ADD COLUMN coupon_code VARCHAR(50) NULL AFTER payment_method",
        'discount' => "ALTER TABLE orders ADD COLUMN discount DECIMAL(10,2) DEFAULT 0.00 AFTER total",
        'card_name' => "ALTER TABLE orders ADD COLUMN card_name VARCHAR(255) NULL AFTER coupon_code",
        'card_number' => "ALTER TABLE orders ADD COLUMN card_number VARCHAR(50) NULL AFTER card_name",
        'paypal_email' => "ALTER TABLE orders ADD COLUMN paypal_email VARCHAR(255) NULL AFTER card_number"
    ];

    foreach ($requiredColumns as $columnName => $alterSql) {
        if (!columnExists($conn, 'orders', $columnName)) {
            $conn->query($alterSql); // Fail silently if it already exists or other error
        }
    }

    $statusResult = $conn->query("SHOW COLUMNS FROM orders LIKE 'status'");
    $statusColumn = $statusResult ? $statusResult->fetch_assoc() : null;
    if ($statusColumn && strpos($statusColumn['Type'], "'completed'") === false) {
        $conn->query("ALTER TABLE orders MODIFY status ENUM('pending', 'paid', 'shipped', 'delivered', 'completed', 'cancelled') DEFAULT 'pending'");
    }
}

function generateUniqueOrderNumber($conn) {
    for ($attempt = 0; $attempt < 10; $attempt++) {
        $orderNumber = 'LIORA' . date('YmdHis') . random_int(100000, 999999);
        $stmt = prepareStatement($conn, 'SELECT id FROM orders WHERE order_number = ? LIMIT 1');
        $stmt->bind_param('s', $orderNumber);
        executeStatement($stmt);
        $result = $stmt->get_result();
        $exists = $result && $result->num_rows > 0;
        $stmt->close();

        if (!$exists) {
            return $orderNumber;
        }
    }

    throw new Exception('Unable to generate a unique order number.');
}

if ($action === 'checkout') {
    ensureOrderColumns($conn);

    $items = getCartItems($conn, $userId);
    if (empty($items)) {
        sendResponse(['success' => false, 'message' => 'Your cart is empty.']);
    }

    $customerName = getPostedField('full_name');
    $customerEmail = getPostedField('email');
    $address = getPostedField('address');
    $city = getPostedField('city');
    $country = getPostedField('country');
    $postcode = getPostedField('postcode');
    $phone = getPostedField('phone');
    $deliveryDate = getPostedField('delivery_date');
    $deliveryTime = getPostedField('delivery_time');
    $giftMessage = getPostedField('gift_message');
    $orderNote = getPostedField('order_note');
    $paymentMethod = getPostedField('payment_method');
    $couponCode = getPostedField('coupon_code');
    $redeemPointsRaw = isset($_POST['redeem_points']) ? trim((string) $_POST['redeem_points']) : '';
    $redeemPoints = 0;

    if ($customerName === '' || $customerEmail === '' || $address === '' || $city === '' || $phone === '') {
        sendResponse(['success' => false, 'message' => 'Please complete all required delivery fields.']);
    }

    if (!filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
        sendResponse(['success' => false, 'message' => 'Please enter a valid email address.']);
    }

    if (!preg_match('/^\d{11}$/', $phone)) {
        sendResponse(['success' => false, 'message' => 'Please enter a valid Iraqi phone number with exactly 11 digits.']);
    }

    if ($deliveryDate === '' || $deliveryTime === '') {
        sendResponse(['success' => false, 'message' => 'Please choose delivery date and time.']);
    }

    $normalizedDeliveryTime = normalizeDeliveryTime($deliveryTime);
    if ($normalizedDeliveryTime === null) {
        sendResponse(['success' => false, 'message' => 'Please write delivery time like 12:59 PM. Hours must be 01-12, minutes 01-60, and use AM or PM.']);
    }
    $deliveryTime = $normalizedDeliveryTime;

    if ($paymentMethod === '') {
        $paymentMethod = 'Credit Card (Visa)';
    }

    if ($paymentMethod === 'Reward Points') {
        if ($redeemPointsRaw === '' || !preg_match('/^\d+$/', $redeemPointsRaw)) {
            sendResponse(['success' => false, 'message' => 'Please enter reward points as a whole number only.']);
        }

        $redeemPoints = intval($redeemPointsRaw);
        if ($redeemPoints <= 0) {
            sendResponse(['success' => false, 'message' => 'Please enter reward points as a whole number only.']);
        }
    }

    $paypalEmail = getPostedField('paypal_email');
    if ($paymentMethod === 'PayPal' && !isValidFixedCardNumber($paypalEmail, 16)) {
        sendResponse(['success' => false, 'message' => 'Please enter a valid 16-digit PayPal card number.']);
    }

    if ($paymentMethod === 'Credit Card (Visa)') {
        $cardName = strtolower(getPostedField('card_name'));
        $cardNumber = getPostedField('card_number');
        $cardCvv = getPostedField('card_cvv');

        if ($cardName !== 'visa' && $cardName !== 'visacard') {
            sendResponse(['success' => false, 'message' => 'Cardholder Name must be visa or visacard.']);
        }

        if (!isValidFixedCardNumber($cardNumber, 16)) {
            sendResponse(['success' => false, 'message' => 'Please enter a valid 16-digit card number.']);
        }

        if (!preg_match('/^\d{3}$/', $cardCvv)) {
            sendResponse(['success' => false, 'message' => 'Please enter a valid 3-digit CVV.']);
        }
    }

    // Calculate subtotal
    $subtotal = 0.0;
    foreach ($items as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }

    $couponDiscount = $subtotal * getCouponDiscountRate($couponCode);
    $volumeDiscount = getCartVolumeDiscount($subtotal);
    $cartDiscount = $couponDiscount + $volumeDiscount;

    // Apply reward points discount if requested
    $rewardDiscount = 0.0;
    $pointsUsed = 0;
    if ($paymentMethod === 'Reward Points' && $redeemPoints > 0) {
        $userPoints = getUserRewardPoints($conn, $userId);
        if ($userPoints < 100) {
            sendResponse(['success' => false, 'message' => 'Reward points unlock at 100 points.']);
        }

        if ($userPoints < $redeemPoints) {
            sendResponse(['success' => false, 'message' => 'Insufficient reward points.']);
        }

        $rewardDiscount = calculateDiscountFromPoints($redeemPoints, $userPoints);
        $rewardDiscount = min($rewardDiscount, max($subtotal - $cartDiscount, 0));
        $pointsUsed = $redeemPoints;
        $orderNote .= ' Spent ' . $pointsUsed . ' reward points.';
    }

    $shipping = getCartShippingCost($subtotal);
    $totalDiscount = $cartDiscount + $rewardDiscount;
    $total = max($subtotal - $totalDiscount + $shipping, 0);
    $orderNumber = generateUniqueOrderNumber($conn);
    $status = 'pending';

    $totalPointsToDeduct = $pointsUsed;
    if ($totalPointsToDeduct > 0 && getUserRewardPoints($conn, $userId) < $totalPointsToDeduct) {
        sendResponse(['success' => false, 'message' => 'Insufficient reward points for the selected redemption.']);
    }

    // Check stock availability
    foreach ($items as $item) {
        if ($item['stock'] < $item['quantity']) {
            sendResponse(['success' => false, 'message' => 'Insufficient stock for ' . $item['name'] . '. Available: ' . $item['stock'] . '.']);
        }
    }

    $conn->begin_transaction();
    try {
        // Insert order
        $orderStmt = prepareStatement(
            $conn,
            'INSERT INTO orders (
                user_id, order_number, status, subtotal, shipping_cost, discount, total,
                customer_name, customer_email, address, city, country, postcode, phone,
                delivery_date, delivery_time, gift_message, order_note, payment_method, coupon_code,
                card_name, card_number, paypal_email
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        
        $cardName = getPostedField('card_name');
        $cardNumber = getPostedField('card_number');

        // Mask card number for security
        if ($cardNumber !== '' && strlen($cardNumber) > 4) {
            $cardNumber = '**** **** **** ' . substr($cardNumber, -4);
        }

        $paypalDigits = preg_replace('/\D+/', '', $paypalEmail);
        if ($paypalDigits !== '' && strlen($paypalDigits) > 4) {
            $paypalEmail = '**** **** **** ' . substr($paypalDigits, -4);
        }

        $orderStmt->bind_param(
            'issddddssssssssssssssss',
            $userId,
            $orderNumber,
            $status,
            $subtotal,
            $shipping,
            $totalDiscount,
            $total,
            $customerName,
            $customerEmail,
            $address,
            $city,
            $country,
            $postcode,
            $phone,
            $deliveryDate,
            $deliveryTime,
            $giftMessage,
            $orderNote,
            $paymentMethod,
            $couponCode,
            $cardName,
            $cardNumber,
            $paypalEmail
        );
        executeStatement($orderStmt);
        $orderId = $conn->insert_id;
        $orderStmt->close();

        // Insert order items
        $itemStmt = prepareStatement($conn, 'INSERT INTO order_items (order_id, product_id, quantity, unit_price, options, product_type, variant) VALUES (?, ?, ?, ?, ?, ?, ?)');
        foreach ($items as $item) {
            $itemStmt->bind_param('iiidsss', $orderId, $item['id'], $item['quantity'], $item['price'], $item['options'], $item['product_type'], $item['variant']);
            executeStatement($itemStmt);
        }
        $itemStmt->close();

        // Decrease stock for each ordered item
        $updateStockStmt = prepareStatement($conn, 'UPDATE products SET stock = stock - ? WHERE id = ?');
        foreach ($items as $item) {
            $updateStockStmt->bind_param('ii', $item['quantity'], $item['id']);
            executeStatement($updateStockStmt);
        }
        $updateStockStmt->close();

        // 🛒 EMPTY CART AFTER CHECKOUT
        $clearCartStmt = prepareStatement($conn, 'DELETE FROM cart_items WHERE user_id = ?');
        $clearCartStmt->bind_param('i', $userId);
        executeStatement($clearCartStmt);
        $clearCartStmt->close();

        // Award new points for this purchase
        $earnedPoints = calculatePointsFromAmount($subtotal);
        if ($earnedPoints > 0) {
            awardPointsForPurchase($conn, $userId, $subtotal);
        }

        // Deduct points for redemption
        if ($pointsUsed > 0) {
            deductPointsFromUser($conn, $userId, $pointsUsed, 'checkout_redemption');
        }
        $conn->commit();
        
        // Get updated points for response
        $updatedPoints = getUserRewardPoints($conn, $userId);
        
        sendResponse([
            'success' => true,
            'order_id' => $orderId,
            'order_number' => $orderNumber,
            'points_earned' => $earnedPoints,
            'points_used' => $pointsUsed,
            'total_points' => $updatedPoints,
            'saved_customer' => [
                'customer_name' => $customerName,
                'customer_email' => $customerEmail,
                'address' => $address,
                'city' => $city,
                'country' => $country,
                'postcode' => $postcode,
                'phone' => $phone,
                'delivery_date' => $deliveryDate,
                'delivery_time' => $deliveryTime,
                'gift_message' => $giftMessage,
                'order_note' => $orderNote,
                'payment_method' => $paymentMethod
            ]
        ]);
    } catch (Exception $e) {
        $conn->rollback();
        sendResponse(['success' => false, 'message' => 'Unable to complete checkout: ' . $e->getMessage()]);
    }
}

if ($action === 'get_points') {
    $userPoints = getUserRewardPoints($conn, $userId);
    $tier = getRewardTier($userPoints);
    $rewards = getRewardOptions();
    
    sendResponse([
        'success' => true,
        'points' => $userPoints,
        'tier' => $tier,
        'rewards' => $rewards
    ]);
}

sendResponse(['success' => false, 'message' => 'Invalid checkout action.']);
?>
