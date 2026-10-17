<?php
session_start();
// Redirect unauthenticated users to login with a message
if (empty($_SESSION['user_id'])) {
    header('Location: login-register.php?message=login_required');
    exit();
}

include 'header.php';
include 'config.php';

$userId = intval($_SESSION['user_id']);
$userRole = $_SESSION['role'] ?? 'customer';
$orderId = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

// Validate order exists and belongs to user (Admins can see all)
$order = null;
$orderItems = [];

if ($orderId > 0) {
    if ($userRole === 'admin') {
        $stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->bind_param('i', $orderId);
    } else {
        $stmt = $conn->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ? AND status IN ('pending', 'paid', 'shipped', 'delivered', 'completed', 'arrived')");
        $stmt->bind_param('ii', $orderId, $userId);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    $stmt->close();
    
    if ($order) {
        // Fetch order items
        $itemsStmt = $conn->prepare("SELECT oi.product_id, p.name, oi.quantity, oi.unit_price FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
        $itemsStmt->bind_param('i', $orderId);
        $itemsStmt->execute();
        $itemsResult = $itemsStmt->get_result();
        while ($row = $itemsResult->fetch_assoc()) {
            $orderItems[] = $row;
        }
        $itemsStmt->close();
    }
}

if (!$order) {
    // Order not found or not authorized
    echo '<div class="container" style="text-align: center; padding: 60px 20px;">';
    echo '<h3>Order not found or you do not have permission to view it.</h3>';
    echo '<p><a href="accounts.php" class="btn btn--md">Back to My Account</a></p>';
    echo '</div>';
    include 'footer.php';
    exit();
}

// Format dates
$orderDate = new DateTime($order['created_at']);
$formattedDate = $orderDate->format('M j, Y');
$deliveryDate = isset($order['delivery_date']) && $order['delivery_date'] ? (new DateTime($order['delivery_date']))->format('M j, Y') : 'N/A';
$deliveryTime = isset($order['delivery_time']) && $order['delivery_time'] ? $order['delivery_time'] : 'N/A';
$status = ucfirst($order['status']);
$isEditable = !in_array(strtolower((string) $order['status']), ['completed', 'delivered', 'arrived'], true);
$totalQuantity = 0;
foreach ($orderItems as $item) {
    $totalQuantity += intval($item['quantity']);
}
$itemSummary = $totalQuantity === 1 ? '1 item' : $totalQuantity . ' items';
?>
  <!--=============== MAIN =============== -->
  <main class="main">
    <div class="cart__header cart__header-box container">
      <h2 class="section__title">
        <span>Order #<?php echo htmlspecialchars($order['order_number']); ?></span>
      </h2>
      <p class="delivery__order">Order details and tracking</p>
    </div>

    <section class="section--lg">
      <div class="container">
        <div class="order-details">
          <div class="order-summary">
            <h3>Order Summary</h3>
            <table class="placed__order-table">
              <tbody>
                <tr>
                  <td>Order Number:</td>
                  <td>#<?php echo htmlspecialchars($order['order_number']); ?></td>
                </tr>
                <tr>
                  <td>Order Date:</td>
                  <td><?php echo $formattedDate; ?></td>
                </tr>
                <tr>
                  <td>Status:</td>
                  <td><?php echo $status; ?></td>
                </tr>
                <tr>
                  <td>Payment Method:</td>
                  <td><?php echo htmlspecialchars($order['payment_method'] ?? 'N/A'); ?></td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="order-info">
            <h3>Shipping Information</h3>
            <?php if (isset($order['customer_name']) && $order['customer_name']): ?>
              <p><?php echo htmlspecialchars($order['customer_name']); ?></p>
            <?php endif; ?>
            <?php if (isset($order['address']) && $order['address']): ?>
              <p><?php echo htmlspecialchars($order['address']); ?></p>
            <?php endif; ?>
            <?php if (isset($order['city']) || isset($order['country']) || isset($order['postcode'])): ?>
              <p>
                <?php echo htmlspecialchars($order['city'] ?? ''); ?>, <?php echo htmlspecialchars($order['country'] ?? ''); ?> <?php echo htmlspecialchars($order['postcode'] ?? ''); ?>
              </p>
            <?php endif; ?>
            <?php if (isset($order['phone']) && $order['phone']): ?>
              <p>Phone: <?php echo htmlspecialchars($order['phone']); ?></p>
            <?php endif; ?>
            <?php if (isset($order['customer_email']) && $order['customer_email']): ?>
              <p>Email: <?php echo htmlspecialchars($order['customer_email']); ?></p>
            <?php endif; ?>
            <p>Delivery Date: <?php echo $deliveryDate; ?></p>
            <p>Delivery Time: <?php echo $deliveryTime; ?></p>
            <?php if (!empty($order['gift_message'])): ?>
              <p><strong>Gift Message:</strong> "<?php echo htmlspecialchars($order['gift_message']); ?>"</p>
            <?php endif; ?>
            <?php if (!empty($order['order_note'])): ?>
              <p><strong>Order Note:</strong> <?php echo htmlspecialchars($order['order_note']); ?></p>
            <?php endif; ?>
          </div>

          <div class="order-items">
            <h3>Items</h3>
            <table class="placed__order-table">
              <thead>
                <tr>
                  <th>Package</th>
                  <th>Quantity</th>
                  <th>Unit Price</th>
                  <th>Total</th>
                  <?php if ($isEditable): ?>
                  <th>Actions</th>
                  <?php endif; ?>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($orderItems as $item): ?>
                  <tr data-product-id="<?php echo $item['product_id']; ?>">
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td>
                      <?php echo $item['quantity']; ?>
                    </td>
                    <td>$<?php echo number_format($item['unit_price'], 2); ?></td>
                    <td class="item-total">$<?php echo number_format($item['unit_price'] * $item['quantity'], 2); ?></td>
                    <?php if ($isEditable): ?>
                    <td>
                      <button class="remove-item-btn" title="Remove Item">
                        <i class="fi fi-rs-trash"></i>
                      </button>
                    </td>
                    <?php endif; ?>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
            <?php if (!$isEditable): ?>
              <p style="color: #666; font-style: italic; margin-top: 10px;">This order has been completed and cannot be edited.</p>
            <?php endif; ?>
          </div>

          <div class="order-totals">
            <table class="placed__order-table">
              <tbody>
                <tr>
                  <td>Subtotal:</td>
                  <td>$<?php echo number_format($order['subtotal'], 2); ?></td>
                </tr>
                <tr>
                  <td>Shipping:</td>
                  <td>$<?php echo number_format($order['shipping_cost'], 2); ?></td>
                </tr>
                <tr>
                  <td><strong>Total:</strong></td>
                  <td><strong>$<?php echo number_format($order['total'], 2); ?></strong></td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="order-actions">
            <a href="accounts.php" class="btn btn--md">Back to My Orders</a>
            <?php if ($isEditable): ?>
              <a href="deliveryMap.php?order_id=<?php echo intval($order['id']); ?>" class="btn btn--md">Track / Reschedule</a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const orderId = <?php echo $orderId; ?>;

        // Update quantity button removed as quantity is now read-only

        // Remove item button
        document.querySelectorAll('.remove-item-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const productId = row.dataset.productId;

                if (confirm('Are you sure you want to remove this item from your order?')) {
                    removeOrderItem(productId);
                }
            });
        });

        // Auto-update on quantity change removed as quantity is now read-only

        // updateOrderItem function removed as quantity is now read-only

        function removeOrderItem(productId) {
            fetch('order_action.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=remove_order_item&order_id=${orderId}&product_id=${productId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload the page to show updated totals
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while removing the item.');
            });
        }
    });
    </script>
  </main>
<?php include 'footer.php'; ?>
