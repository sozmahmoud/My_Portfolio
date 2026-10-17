<?php
/**
 * ===================================
 * ORDER ACTION HANDLER
 * Manages order item updates and removals
 * ===================================
 */
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once 'config.php';

if (!$conn || $conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.'], JSON_UNESCAPED_UNICODE);
    exit;
}

$userId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;

if ($userId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Please log in to manage your orders.', 'logged_in' => false]);
    exit;
}

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

function sendResponse($data) {
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
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

function isOrderEditableStatus($status) {
    return !in_array(strtolower((string) $status), ['completed', 'delivered', 'arrived'], true);
}

function getOrderCompletionStatus($conn) {
    $result = $conn->query("SHOW COLUMNS FROM orders LIKE 'status'");
    $column = $result ? $result->fetch_assoc() : null;
    $type = strtolower((string) ($column['Type'] ?? ''));

    if (strpos($type, "'completed'") !== false) {
        return 'completed';
    }

    if (strpos($type, "'arrived'") !== false) {
        return 'arrived';
    }

    return 'delivered';
}

function getOrderItemCount($conn, $orderId) {
    $stmt = prepareStatement($conn, 'SELECT COALESCE(SUM(quantity), 0) AS item_count FROM order_items WHERE order_id = ?');
    $stmt->bind_param('i', $orderId);
    executeStatement($stmt);
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    return intval($row['item_count'] ?? 0);
}

function formatItemSummary($count) {
    return $count === 1 ? '1 item' : $count . ' items';
}

if ($action === 'get_order') {
    $orderId = isset($_REQUEST['order_id']) ? intval($_REQUEST['order_id']) : 0;
    $where = $orderId > 0 ? 'id = ? AND user_id = ?' : "user_id = ? AND status <> 'cancelled'";
    $query = "SELECT id, order_number, status, address, city, delivery_date, delivery_time, customer_name, phone
              FROM orders
              WHERE {$where}
              ORDER BY created_at DESC, id DESC
              LIMIT 1";
    $stmt = prepareStatement($conn, $query);
    if ($orderId > 0) {
        $stmt->bind_param('ii', $orderId, $userId);
    } else {
        $stmt->bind_param('i', $userId);
    }
    executeStatement($stmt);
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    $stmt->close();

    if (!$order || strtolower((string) $order['status']) === 'cancelled') {
        sendResponse(['success' => false, 'message' => 'Order not found.']);
    }

    $itemCount = getOrderItemCount($conn, intval($order['id']));
    sendResponse([
        'success' => true,
        'order' => [
            'id' => intval($order['id']),
            'order_number' => $order['order_number'],
            'status' => $order['status'],
            'address' => $order['address'] ?? '',
            'city' => $order['city'] ?? '',
            'delivery_date' => $order['delivery_date'] ?? '',
            'delivery_time' => $order['delivery_time'] ?? '',
            'customer_name' => $order['customer_name'] ?? '',
            'phone' => $order['phone'] ?? '',
            'item_count' => $itemCount,
            'item_summary' => formatItemSummary($itemCount)
        ]
    ]);
}

if ($action === 'reschedule_order') {
    $orderId = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
    $deliveryDate = isset($_POST['delivery_date']) ? trim($_POST['delivery_date']) : '';
    $deliveryTime = isset($_POST['delivery_time']) ? trim($_POST['delivery_time']) : '';

    if ($orderId <= 0 || $deliveryDate === '' || $deliveryTime === '') {
        sendResponse(['success' => false, 'message' => 'Please choose a new delivery date and time.']);
    }

    $dateOk = DateTime::createFromFormat('Y-m-d', $deliveryDate);
    $timeOk = DateTime::createFromFormat('H:i', substr($deliveryTime, 0, 5));
    if (!$dateOk || !$timeOk) {
        sendResponse(['success' => false, 'message' => 'Invalid delivery schedule.']);
    }

    $orderStmt = prepareStatement($conn, "SELECT status FROM orders WHERE id = ? AND user_id = ? AND status <> 'cancelled'");
    $orderStmt->bind_param('ii', $orderId, $userId);
    executeStatement($orderStmt);
    $orderResult = $orderStmt->get_result();
    $order = $orderResult->fetch_assoc();
    $orderStmt->close();

    if (!$order) {
        sendResponse(['success' => false, 'message' => 'Order not found.']);
    }

    if (!isOrderEditableStatus($order['status'])) {
        sendResponse(['success' => false, 'message' => 'Cannot reschedule completed orders.']);
    }

    $deliveryTime = substr($deliveryTime, 0, 5);
    $stmt = prepareStatement($conn, 'UPDATE orders SET delivery_date = ?, delivery_time = ? WHERE id = ? AND user_id = ?');
    $stmt->bind_param('ssii', $deliveryDate, $deliveryTime, $orderId, $userId);
    executeStatement($stmt);
    $stmt->close();

    sendResponse([
        'success' => true,
        'message' => 'Delivery rescheduled successfully.',
        'delivery_date' => $deliveryDate,
        'delivery_time' => $deliveryTime
    ]);
}

// Update order location/address
if ($action === 'update_order_location') {
    $orderId = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';

    if ($orderId <= 0 || empty($address)) {
        sendResponse(['success' => false, 'message' => 'Invalid parameters.']);
    }

    $orderStmt = prepareStatement($conn, "SELECT status FROM orders WHERE id = ? AND user_id = ?");
    $orderStmt->bind_param('ii', $orderId, $userId);
    executeStatement($orderStmt);
    $orderResult = $orderStmt->get_result();
    $order = $orderResult->fetch_assoc();
    $orderStmt->close();

    if (!$order) {
        sendResponse(['success' => false, 'message' => 'Order not found.']);
    }

    if (!isOrderEditableStatus($order['status'])) {
        sendResponse(['success' => false, 'message' => 'Cannot update location for completed orders.']);
    }

    $stmt = prepareStatement($conn, "UPDATE orders SET address = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param('sii', $address, $orderId, $userId);
    executeStatement($stmt);
    $stmt->close();

    sendResponse(['success' => true, 'message' => 'Delivery location updated successfully! 📍']);
}

if ($action === 'cancel_order') {
    $orderId = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
    if ($orderId <= 0) {
        sendResponse(['success' => false, 'message' => 'Invalid order.']);
    }

    $orderStmt = prepareStatement($conn, "SELECT status, order_note FROM orders WHERE id = ? AND user_id = ? AND status <> 'cancelled'");
    $orderStmt->bind_param('ii', $orderId, $userId);
    executeStatement($orderStmt);
    $orderResult = $orderStmt->get_result();
    $order = $orderResult->fetch_assoc();
    $orderStmt->close();

    if (!$order) {
        sendResponse(['success' => false, 'message' => 'Order not found.']);
    }

    if (!isOrderEditableStatus($order['status'])) {
        sendResponse(['success' => false, 'message' => 'Cannot cancel completed orders.']);
    }

    $refundNote = trim(($order['order_note'] ?? '') . "\n[System: Refund of full amount issued on " . date('Y-m-d H:i') . " via original payment method.]");
    $stmt = prepareStatement($conn, "UPDATE orders SET status = 'cancelled', order_note = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param('sii', $refundNote, $orderId, $userId);
    executeStatement($stmt);
    $stmt->close();

    sendResponse(['success' => true, 'message' => 'Order cancelled and refund issued successfully! 🌷']);
}

if ($action === 'mark_delivered') {
    $completionStatus = getOrderCompletionStatus($conn);
    
    // Update ALL active orders for this user to the completion status
    $stmt = prepareStatement($conn, "UPDATE orders SET status = ? WHERE user_id = ? AND LOWER(status) IN ('pending', 'paid', 'shipped')");
    $stmt->bind_param('si', $completionStatus, $userId);
    executeStatement($stmt);
    $affectedRows = $stmt->affected_rows;
    $stmt->close();

    sendResponse([
        'success' => true,
        'message' => 'Delivery marked as completed for all active orders!',
        'status' => $completionStatus,
        'affected_orders' => $affectedRows
    ]);
}

// Update order item quantity
if ($action === 'update_order_item_quantity') {
    $orderId = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
    $productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;

    if ($orderId <= 0 || $productId <= 0 || $quantity < 0) {
        sendResponse(['success' => false, 'message' => 'Invalid parameters.']);
    }

    // Check if order exists and belongs to user and is editable
    $orderStmt = prepareStatement($conn, "SELECT status FROM orders WHERE id = ? AND user_id = ?");
    $orderStmt->bind_param('ii', $orderId, $userId);
    executeStatement($orderStmt);
    $orderResult = $orderStmt->get_result();
    $order = $orderResult->fetch_assoc();
    $orderStmt->close();

    if (!$order) {
        sendResponse(['success' => false, 'message' => 'Order not found.']);
    }

    if (!isOrderEditableStatus($order['status'])) {
        sendResponse(['success' => false, 'message' => 'Cannot edit completed orders.']);
    }

    if ($quantity === 0) {
        // Remove item if quantity is 0
        $deleteStmt = prepareStatement($conn, "DELETE FROM order_items WHERE order_id = ? AND product_id = ?");
        $deleteStmt->bind_param('ii', $orderId, $productId);
        executeStatement($deleteStmt);
        $affected = $deleteStmt->affected_rows;
        $deleteStmt->close();

        if ($affected === 0) {
            sendResponse(['success' => false, 'message' => 'Item not found in order.']);
        }
    } else {
        // Update quantity
        $updateStmt = prepareStatement($conn, "UPDATE order_items SET quantity = ? WHERE order_id = ? AND product_id = ?");
        $updateStmt->bind_param('iii', $quantity, $orderId, $productId);
        executeStatement($updateStmt);
        $affected = $updateStmt->affected_rows;
        $updateStmt->close();

        if ($affected === 0) {
            sendResponse(['success' => false, 'message' => 'Item not found in order.']);
        }
    }

    // Recalculate order totals
    recalculateOrderTotals($conn, $orderId);

    sendResponse(['success' => true, 'message' => 'Order item updated successfully.']);
}

// Remove order item
if ($action === 'remove_order_item') {
    $orderId = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
    $productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

    if ($orderId <= 0 || $productId <= 0) {
        sendResponse(['success' => false, 'message' => 'Invalid parameters.']);
    }

    // Check if order exists and belongs to user and is editable
    $orderStmt = prepareStatement($conn, "SELECT status FROM orders WHERE id = ? AND user_id = ?");
    $orderStmt->bind_param('ii', $orderId, $userId);
    executeStatement($orderStmt);
    $orderResult = $orderStmt->get_result();
    $order = $orderResult->fetch_assoc();
    $orderStmt->close();

    if (!$order) {
        sendResponse(['success' => false, 'message' => 'Order not found.']);
    }

    if (!isOrderEditableStatus($order['status'])) {
        sendResponse(['success' => false, 'message' => 'Cannot edit completed orders.']);
    }

    // Remove item
    $deleteStmt = prepareStatement($conn, "DELETE FROM order_items WHERE order_id = ? AND product_id = ?");
    $deleteStmt->bind_param('ii', $orderId, $productId);
    executeStatement($deleteStmt);
    $affected = $deleteStmt->affected_rows;
    $deleteStmt->close();

    if ($affected === 0) {
        sendResponse(['success' => false, 'message' => 'Item not found in order.']);
    }

    // Recalculate order totals
    recalculateOrderTotals($conn, $orderId);

    sendResponse(['success' => true, 'message' => 'Order item removed successfully.']);
}

// Function to recalculate order totals
function recalculateOrderTotals($conn, $orderId) {
    // Get subtotal from order items
    $subtotalStmt = prepareStatement($conn, "
        SELECT SUM(oi.quantity * oi.unit_price) as subtotal
        FROM order_items oi
        WHERE oi.order_id = ?
    ");
    $subtotalStmt->bind_param('i', $orderId);
    executeStatement($subtotalStmt);
    $subtotalResult = $subtotalStmt->get_result();
    $subtotalRow = $subtotalResult->fetch_assoc();
    $subtotal = floatval($subtotalRow['subtotal'] ?? 0);
    $subtotalStmt->close();

    if ($subtotal <= 0) {
        $deleteOrderStmt = prepareStatement($conn, "DELETE FROM orders WHERE id = ?");
        $deleteOrderStmt->bind_param('i', $orderId);
        executeStatement($deleteOrderStmt);
        $deleteOrderStmt->close();
        return;
    }

    // Get shipping cost from order
    $shippingStmt = prepareStatement($conn, "SELECT shipping_cost FROM orders WHERE id = ?");
    $shippingStmt->bind_param('i', $orderId);
    executeStatement($shippingStmt);
    $shippingResult = $shippingStmt->get_result();
    $shippingRow = $shippingResult->fetch_assoc();
    $shippingCost = floatval($shippingRow['shipping_cost'] ?? 0);
    $shippingStmt->close();

    // Calculate new total
    $total = $subtotal + $shippingCost;

    // Update order
    $updateStmt = prepareStatement($conn, "UPDATE orders SET subtotal = ?, total = ? WHERE id = ?");
    $updateStmt->bind_param('ddi', $subtotal, $total, $orderId);
    executeStatement($updateStmt);
    $updateStmt->close();
}

// Invalid action
sendResponse(['success' => false, 'message' => 'Invalid action.']);
?>
