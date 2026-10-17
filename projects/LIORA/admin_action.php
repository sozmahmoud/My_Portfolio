<?php
session_start();
require_once 'config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'approve_user':
        $id = intval($_POST['id']);
        $stmt = $conn->prepare("UPDATE users SET is_active = 1 WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'User activated manually!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to approve user.']);
        }
        break;

    case 'reject_user':
        $id = intval($_POST['id']);
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'User rejected and removed.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to reject user.']);
        }
        break;

    case 'accept_order':
        $id = intval($_POST['id']);
        // Transition from pending to paid/shipped
        $stmt = $conn->prepare("UPDATE orders SET status = 'paid' WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Order accepted!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to accept order.']);
        }
        break;

    case 'edit_review':
        $id = intval($_POST['id']);
        $comment = $_POST['comment'] ?? '';
        $rating = intval($_POST['rating'] ?? 5);
        $stmt = $conn->prepare("UPDATE reviews SET comment = ?, rating = ? WHERE id = ?");
        $stmt->bind_param("sii", $comment, $rating, $id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Review updated!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update review.']);
        }
        break;

    case 'update_order_status':
        $id = intval($_POST['id']);
        $newStatus = $_POST['status'] ?? 'pending';
        
        // Get current status
        $stmt = $conn->prepare("SELECT status FROM orders WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            echo json_encode(['success' => false, 'message' => 'Order not found.']);
            break;
        }
        $oldStatus = $result->fetch_assoc()['status'];
        $stmt->close();
        
        // Update status
        $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $newStatus, $id);
        if ($stmt->execute()) {
            // Adjust stock if status changed to/from cancelled
            if ($oldStatus !== 'cancelled' && $newStatus === 'cancelled') {
                // Order cancelled, restore stock
                $stmt2 = $conn->prepare("UPDATE products p JOIN order_items oi ON p.id = oi.product_id SET p.stock = p.stock + oi.quantity WHERE oi.order_id = ?");
                $stmt2->bind_param("i", $id);
                $stmt2->execute();
                $stmt2->close();
            } elseif ($oldStatus === 'cancelled' && $newStatus !== 'cancelled') {
                // Order reactivated, decrease stock again
                $stmt2 = $conn->prepare("UPDATE products p JOIN order_items oi ON p.id = oi.product_id SET p.stock = p.stock - oi.quantity WHERE oi.order_id = ?");
                $stmt2->bind_param("i", $id);
                $stmt2->execute();
                $stmt2->close();
            }
            echo json_encode(['success' => true, 'message' => "Order marked as $newStatus!"]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update order.']);
        }
        break;

    case 'add_product':
        $name = $_POST['name'] ?? '';
        $price = floatval($_POST['price'] ?? 0);
        $stock = intval($_POST['stock'] ?? 0);
        $category = $_POST['category'] ?? 'Uncategorized';
        $image_url = $_POST['image_url'] ?? 'assets/img/default-flower.jpg';
        
        $stmt = $conn->prepare("INSERT INTO products (name, price, stock, category, image_url) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sdiss", $name, $price, $stock, $category, $image_url);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Product added!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add product.']);
        }
        break;

    case 'update_product':
        $id = intval($_POST['id']);
        $name = $_POST['name'] ?? '';
        $price = floatval($_POST['price'] ?? 0);
        $stock = intval($_POST['stock'] ?? 0);
        $stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, stock = ? WHERE id = ?");
        $stmt->bind_param("sdii", $name, $price, $stock, $id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Product updated!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update product.']);
        }
        break;

    case 'delete_product':
        $id = intval($_POST['id']);
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Product deleted.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete product.']);
        }
        break;

    case 'delete_review':
        $id = intval($_POST['id']);
        $stmt = $conn->prepare("DELETE FROM reviews WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Review deleted.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete review.']);
        }
        break;

    case 'update_support_status':
        $id = intval($_POST['id']);
        $status = $_POST['status'] ?? 'new';
        $allowedStatuses = ['new', 'read', 'replied', 'closed'];
        if (!in_array($status, $allowedStatuses, true)) {
            echo json_encode(['success' => false, 'message' => 'Invalid support status.']);
            break;
        }

        $stmt = $conn->prepare("UPDATE support_messages SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => "Support message marked as $status."]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update support message.']);
        }
        break;

    case 'delete_support_message':
        $id = intval($_POST['id']);
        $stmt = $conn->prepare("DELETE FROM support_messages WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Support message deleted.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete support message.']);
        }
        break;

    case 'delete_user':
        $id = intval($_POST['id']);
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'User deleted.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete user.']);
        }
        break;

    case 'delete_order':
        $id = intval($_POST['id']);
        
        // Instead of deleting, we cancel the order to preserve history
        $stmt = $conn->prepare("SELECT status FROM orders WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows === 0) {
            echo json_encode(['success' => false, 'message' => 'Order not found.']);
            break;
        }
        $currentStatus = $res->fetch_assoc()['status'];
        $stmt->close();

        if ($currentStatus === 'cancelled') {
            echo json_encode(['success' => true, 'message' => 'Order is already cancelled. Record preserved.']);
            break;
        }

        // Update to cancelled
        $stmt = $conn->prepare("UPDATE orders SET status = 'cancelled' WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            // Restore stock
            $stmt2 = $conn->prepare("UPDATE products p JOIN order_items oi ON p.id = oi.product_id SET p.stock = p.stock + oi.quantity WHERE oi.order_id = ?");
            $stmt2->bind_param("i", $id);
            $stmt2->execute();
            $stmt2->close();
            
            echo json_encode(['success' => true, 'message' => 'Order cancelled and stock restored! History preserved. 🌸']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to cancel order.']);
        }
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}
