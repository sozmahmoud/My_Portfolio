<?php
session_start();
require_once 'config.php';

// Check if user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login-register.php");
    exit;
}

// Fetch general stats
$totalOrders = $conn->query("SELECT COUNT(*) FROM orders")->fetch_row()[0];
$totalUsers = $conn->query("SELECT COUNT(*) FROM users")->fetch_row()[0];
$pendingUsersCount = $conn->query("SELECT COUNT(*) FROM users WHERE is_active = 0")->fetch_row()[0];
$pendingOrdersCount = $conn->query("SELECT COUNT(*) FROM orders WHERE status = 'pending'")->fetch_row()[0];
$totalRevenue = $conn->query("SELECT SUM(total) FROM orders WHERE status != 'cancelled'")->fetch_row()[0] ?? 0;
$conn->query("
    CREATE TABLE IF NOT EXISTS support_messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NULL,
        name VARCHAR(150) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(50) DEFAULT NULL,
        topic VARCHAR(80) NOT NULL,
        order_number VARCHAR(50) DEFAULT NULL,
        preferred_contact ENUM('email', 'phone') DEFAULT 'email',
        message TEXT NOT NULL,
        status ENUM('new', 'read', 'replied', 'closed') DEFAULT 'new',
        ip_address VARCHAR(45) DEFAULT NULL,
        user_agent VARCHAR(255) DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_support_messages_user (user_id),
        INDEX idx_support_messages_status (status),
        INDEX idx_support_messages_created (created_at),
        CONSTRAINT fk_support_messages_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
");
$newSupportCount = $conn->query("SELECT COUNT(*) FROM support_messages WHERE status = 'new'")->fetch_row()[0] ?? 0;

// Fetch pending users for approval
$pendingUsersResult = $conn->query("SELECT * FROM users WHERE is_active = 0 ORDER BY created_at DESC");

// Fetch ALL users
$allUsersResult = $conn->query("SELECT * FROM users ORDER BY created_at DESC");

// Fetch ALL orders
$allOrdersResult = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");

// Fetch ACTIVE CARTS (Users who have items in their cart)
$activeCartsResult = $conn->query("
    SELECT u.username, u.email, p.name as product_name, c.quantity, p.price, p.image_url, c.added_at
    FROM cart_items c
    JOIN users u ON c.user_id = u.id
    JOIN products p ON c.product_id = p.id
    ORDER BY c.added_at DESC
");

// Fetch reviews
$reviewsResult = $conn->query("SELECT r.*, u.username, p.name as product_name FROM reviews r JOIN users u ON r.user_id = u.id JOIN products p ON r.product_id = p.id ORDER BY r.created_at DESC");

// Fetch support messages
$supportMessagesResult = $conn->query("
    SELECT sm.*, u.username
    FROM support_messages sm
    LEFT JOIN users u ON sm.user_id = u.id
    ORDER BY sm.created_at DESC
");

// Fetch products
$productsResult = $conn->query("SELECT id, name, price, stock, category, image_url FROM products ORDER BY id DESC");

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Liora | Admin Dashboard 🌸</title>
  <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.0.0/uicons-regular-rounded/css/uicons-regular-rounded.css">
  <link rel="stylesheet" href="assets/css/admin.css?v=<?php echo time(); ?>">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="admin-layout">
  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sidebar__brand">LIORA Admin</div>
    <nav class="sidebar__nav">
      <a href="#" class="nav-link active"><i class="fi fi-rr-apps"></i> Dashboard</a>
      <a href="#orders-section" class="nav-link"><i class="fi fi-rr-shopping-cart"></i> All Orders</a>
      <a href="#users-section" class="nav-link"><i class="fi fi-rr-users"></i> All Users</a>
      <a href="#carts-section" class="nav-link"><i class="fi fi-rr-shopping-bag"></i> Active Carts</a>
      <a href="#products-section" class="nav-link"><i class="fi fi-rr-box"></i> Inventory</a>
      <a href="#support-section" class="nav-link"><i class="fi fi-rr-headset"></i> Support</a>
      <a href="#reviews-section" class="nav-link"><i class="fi fi-rr-comment"></i> Reviews</a>
      <a href="index.php" class="nav-link"><i class="fi fi-rr-arrow-left"></i> View Site</a>
    </nav>
    <div class="sidebar__footer">
      <a href="javascript:void(0)" onclick="logout()" class="nav-link logout-btn"><i class="fi fi-rr-sign-out-alt"></i> Logout</a>
    </div>
  </aside>

  <!-- Main Content -->
  <main class="main-content">
    <header class="header">
      <div class="header__title">
        <h1>Dashboard Overview 🌸</h1>
        <p>Manage your flower shop with ease.</p>
      </div>
      <div class="header__stats-quick">
         <div class="revenue-pill">
            <span class="label">Total Revenue</span>
            <span class="val">$<?php echo number_format($totalRevenue, 2); ?></span>
         </div>
         <span id="live-time" class="live-clock"></span>
      </div>
    </header>

    <!-- Stats Grid -->
    <div class="stats-grid">
      <div class="stat-card glass-card">
        <div class="stat-icon"><i class="fi fi-rr-shopping-bag"></i></div>
        <div class="stat-info">
          <h3>Orders</h3>
          <div class="value"><?php echo $totalOrders; ?></div>
          <div class="sub-value"><?php echo $pendingOrdersCount; ?> Pending</div>
        </div>
      </div>
      <div class="stat-card glass-card">
        <div class="stat-icon icon-blue"><i class="fi fi-rr-user"></i></div>
        <div class="stat-info">
          <h3>Customers</h3>
          <div class="value"><?php echo $totalUsers; ?></div>
          <div class="sub-value"><?php echo $pendingUsersCount; ?> Unverified Users</div>
        </div>
      </div>
      <div class="stat-card glass-card">
        <div class="stat-icon icon-orange"><i class="fi fi-rr-star"></i></div>
        <div class="stat-info">
          <h3>Reviews</h3>
          <div class="value"><?php echo $reviewsResult->num_rows; ?></div>
          <div class="sub-value">Latest feedback</div>
        </div>
      </div>
      <div class="stat-card glass-card">
        <div class="stat-icon icon-purple"><i class="fi fi-rr-box"></i></div>
        <div class="stat-info">
          <h3>Products</h3>
          <div class="value"><?php echo $productsResult->num_rows; ?></div>
          <div class="sub-value">In Inventory</div>
        </div>
      </div>
      <div class="stat-card glass-card">
        <div class="stat-icon icon-blue"><i class="fi fi-rr-headset"></i></div>
        <div class="stat-info">
          <h3>Support</h3>
          <div class="value"><?php echo $newSupportCount; ?></div>
          <div class="sub-value">New Messages</div>
        </div>
      </div>
    </div>

    <!-- Charts Row -->
    <div class="charts-row">
      <div class="chart-container glass-card">
        <div class="chart-header">
            <h2>Revenue Growth</h2>
            <div class="chart-toggle">
                <button class="active" onclick="toggleSalesTimeframe('weekly')">Week</button>
                <button onclick="toggleSalesTimeframe('monthly')">Month</button>
            </div>
        </div>
        <div class="chart-canvas-wrapper">
            <canvas id="salesChart"></canvas>
            <?php if($totalOrders == 0): ?>
                <div class="chart-empty-overlay">No sales data available yet</div>
            <?php endif; ?>
        </div>
      </div>
      <div class="chart-container glass-card">
        <div class="chart-header">
            <h2>Most Sold Flowers</h2>
            <div class="chart-toggle">
                <button class="active" onclick="toggleProductTimeframe('weekly')">Week</button>
                <button onclick="toggleProductTimeframe('monthly')">Month</button>
            </div>
        </div>
        <div class="chart-canvas-wrapper">
            <canvas id="productsChart"></canvas>
            <?php if($totalOrders == 0): ?>
                <div class="chart-empty-overlay">No products sold yet</div>
            <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Pending Approvals -->
    <?php if($pendingUsersResult->num_rows > 0): ?>
    <section class="table-section glass-card animated-in" id="pending-users">
      <div class="section-header">
        <div class="section-title-box">
            <i class="fi fi-rr-user-add"></i>
            <h2>Pending Verification</h2>
        </div>
        <span class="badge pulse"><?php echo $pendingUsersCount; ?> Verification Pending</span>
      </div>
      <div class="table-responsive">
      <table class="admin-table">
        <thead>
          <tr>
            <th>User</th>
            <th>Email</th>
            <th>Joined</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
            <?php while($row = $pendingUsersResult->fetch_assoc()): ?>
            <tr>
              <td>
                <div class="user-row">
                    <div class="user-avatar"><?php echo strtoupper(substr($row['username'], 0, 1)); ?></div>
                    <strong><?php echo htmlspecialchars($row['username']); ?></strong>
                </div>
              </td>
              <td><?php echo htmlspecialchars($row['email']); ?></td>
              <td><?php echo date('M j, Y', strtotime($row['created_at'])); ?></td>
              <td>
                <div class="action-btns">
                  <button class="btn-icon btn-approve" onclick="handleUser('approve', <?php echo $row['id']; ?>)" title="Verify/Activate"><i class="fi fi-rr-check"></i></button>
                  <button class="btn-icon btn-reject" onclick="handleUser('reject', <?php echo $row['id']; ?>)" title="Reject"><i class="fi fi-rr-cross"></i></button>
                </div>
              </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
      </table>
      </div>
    </section>
    <?php endif; ?>

    <!-- Active Carts Monitoring -->
    <section class="table-section glass-card" id="carts-section">
      <div class="section-header">
        <div class="section-title-box">
            <i class="fi fi-rr-shopping-cart-add"></i>
            <h2>Live Shopping Carts</h2>
        </div>
        <p class="section-desc">See what customers are interested in right now.</p>
      </div>
      <div class="table-responsive">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Customer</th>
            <th>Product</th>
            <th>Qty</th>
            <th>Value</th>
            <th>Added At</th>
          </tr>
        </thead>
        <tbody>
          <?php if($activeCartsResult->num_rows > 0): ?>
            <?php while($row = $activeCartsResult->fetch_assoc()): ?>
            <tr>
              <td><strong>@<?php echo htmlspecialchars($row['username']); ?></strong></td>
              <td>
                <div class="product-mini">
                    <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="">
                    <span><?php echo htmlspecialchars($row['product_name']); ?></span>
                </div>
              </td>
              <td>x<?php echo $row['quantity']; ?></td>
              <td><strong>$<?php echo number_format($row['price'] * $row['quantity'], 2); ?></strong></td>
              <td><span class="time-stamp"><?php echo date('H:i, M j', strtotime($row['added_at'])); ?></span></td>
            </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="5" class="empty-state">No active carts found at the moment 🛒</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
      </div>
    </section>

    <!-- All Orders Section -->
    <section class="table-section glass-card" id="orders-section">
      <div class="section-header">
        <div class="section-title-box">
            <i class="fi fi-rr-box-open"></i>
            <h2>Order Management</h2>
        </div>
        <div class="header-actions">
            <span class="badge info"><?php echo $totalOrders; ?> Total</span>
        </div>
      </div>
      <div class="table-responsive">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Order #</th>
            <th>Customer</th>
            <th>Date</th>
            <th>Total</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
           <?php if($allOrdersResult->num_rows > 0): ?>
            <?php while($row = $allOrdersResult->fetch_assoc()): ?>
            <tr>
              <td><span class="order-num">#<?php echo $row['order_number']; ?></span></td>
              <td>
                <div class="customer-info">
                    <strong><?php echo htmlspecialchars($row['customer_name']); ?></strong>
                    <small><?php echo htmlspecialchars($row['customer_email']); ?></small>
                </div>
              </td>
              <td><?php echo date('M j, Y', strtotime($row['created_at'])); ?></td>
              <td><strong>$<?php echo number_format($row['total'], 2); ?></strong></td>
              <td>
                <select class="status-select <?php echo $row['status']; ?>" onchange="updateOrderStatus(<?php echo $row['id']; ?>, this.value)">
                    <option value="pending" <?php echo $row['status']=='pending'?'selected':''; ?>>Pending</option>
                    <option value="paid" <?php echo $row['status']=='paid'?'selected':''; ?>>Paid</option>
                    <option value="shipped" <?php echo $row['status']=='shipped'?'selected':''; ?>>Shipped</option>
                    <option value="delivered" <?php echo $row['status']=='delivered'?'selected':''; ?>>Delivered</option>
                    <option value="completed" <?php echo $row['status']=='completed'?'selected':''; ?>>Completed</option>
                    <option value="cancelled" <?php echo $row['status']=='cancelled'?'selected':''; ?>>Cancelled</option>
                </select>
              </td>
              <td>
                <div class="action-btns">
                  <button class="btn-icon btn-view" onclick="window.location.href='order_details.php?order_id=<?php echo $row['id']; ?>'" title="View Details"><i class="fi fi-rr-eye"></i></button>
                  <button class="btn-icon btn-reject" onclick="deleteOrder(<?php echo $row['id']; ?>)" title="Cancel Order"><i class="fi fi-rr-cross-circle"></i></button>
                </div>
              </td>
            </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="6" class="empty-state">No orders have been placed yet 🌸</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
      </div>
    </section>

    <!-- All Users Section -->
    <section class="table-section glass-card" id="users-section">
      <div class="section-header">
        <div class="section-title-box">
            <i class="fi fi-rr-users"></i>
            <h2>Customer Database</h2>
        </div>
      </div>
      <div class="table-responsive">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Customer</th>
            <th>Email</th>
            <th>Status</th>
            <th>Joined</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if($allUsersResult->num_rows > 0): ?>
            <?php while($row = $allUsersResult->fetch_assoc()): ?>
            <tr>
              <td>
                <div class="user-row">
                    <div class="user-avatar" style="background: <?php echo $row['role']=='admin'?'#ffd700':'#ffd6e7'; ?>"><?php echo strtoupper(substr($row['username'], 0, 1)); ?></div>
                    <div>
                        <strong><?php echo htmlspecialchars($row['username']); ?></strong>
                        <?php if($row['role']=='admin'): ?><span class="admin-tag">Admin</span><?php endif; ?>
                    </div>
                </div>
              </td>
              <td><?php echo htmlspecialchars($row['email']); ?></td>
              <td>
                <span class="status-dot <?php echo $row['is_active'] ? 'active' : 'inactive'; ?>"></span>
                <?php echo $row['is_active'] ? 'Active' : 'Pending'; ?>
              </td>
              <td><?php echo date('M j, Y', strtotime($row['created_at'])); ?></td>
              <td>
                <div class="action-btns">
                  <?php if($row['role'] !== 'admin'): ?>
                  <button class="btn-icon btn-reject" onclick="deleteUser(<?php echo $row['id']; ?>)" title="Delete User"><i class="fi fi-rr-trash"></i></button>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
            <?php endwhile; ?>
          <?php else: ?>
             <tr><td colspan="5" class="empty-state">No customers found 🌷</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
      </div>
    </section>

    <!-- Reviews Control -->
    <section class="table-section glass-card" id="reviews-section">
      <div class="section-header">
        <div class="section-title-box">
            <i class="fi fi-rr-comment-heart"></i>
            <h2>Review Moderation</h2>
        </div>
      </div>
      <div class="table-responsive">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Product</th>
            <th>User</th>
            <th>Rating</th>
            <th>Comment</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if($reviewsResult->num_rows > 0): ?>
            <?php while($row = $reviewsResult->fetch_assoc()): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['product_name']); ?></td>
              <td><strong>@<?php echo htmlspecialchars($row['username']); ?></strong></td>
              <td>
                <?php echo intval($row['rating'] ?? 0); ?>/5
              </td>
              <td><div class="comment-text"><?php echo htmlspecialchars($row['comment']); ?></div></td>
              <td>
                <div class="action-btns">
                  <button class="btn-icon btn-edit" onclick="editReview(<?php echo $row['id']; ?>, '<?php echo addslashes($row['comment']); ?>', <?php echo $row['rating']; ?>)" title="Edit Review"><i class="fi fi-rr-edit"></i></button>
                  <button class="btn-icon btn-reject" onclick="deleteReview(<?php echo $row['id']; ?>)" title="Delete Review"><i class="fi fi-rr-trash"></i></button>
                </div>
              </td>
            </tr>
            <?php endwhile; ?>
          <?php else: ?>
             <tr><td colspan="5" class="empty-state">No reviews to moderate 🌷</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
      </div>
    </section>

    <!-- Support Messages -->
    <section class="table-section glass-card" id="support-section">
      <div class="section-header">
        <div class="section-title-box">
            <i class="fi fi-rr-headset"></i>
            <h2>Contact & Support Messages</h2>
        </div>
        <div class="header-actions">
            <span class="badge info"><?php echo $supportMessagesResult ? $supportMessagesResult->num_rows : 0; ?> Total</span>
        </div>
      </div>
      <div class="table-responsive">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Customer</th>
            <th>Topic</th>
            <th>Message</th>
            <th>Contact</th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if($supportMessagesResult && $supportMessagesResult->num_rows > 0): ?>
            <?php while($row = $supportMessagesResult->fetch_assoc()): ?>
            <tr>
              <td>
                <div class="customer-info">
                  <strong><?php echo htmlspecialchars($row['name']); ?></strong>
                  <small><?php echo htmlspecialchars($row['username'] ? '@' . $row['username'] : 'Guest'); ?></small>
                </div>
              </td>
              <td>
                <strong><?php echo htmlspecialchars($row['topic']); ?></strong>
                <?php if(!empty($row['order_number'])): ?><small class="time-stamp">Order: <?php echo htmlspecialchars($row['order_number']); ?></small><?php endif; ?>
              </td>
              <td><div class="comment-text"><?php echo htmlspecialchars($row['message']); ?></div></td>
              <td>
                <div class="customer-info">
                  <small><?php echo htmlspecialchars($row['email']); ?></small>
                  <?php if(!empty($row['phone'])): ?><small><?php echo htmlspecialchars($row['phone']); ?></small><?php endif; ?>
                </div>
              </td>
              <td>
                <select class="status-select <?php echo htmlspecialchars($row['status']); ?>" onchange="updateSupportStatus(<?php echo $row['id']; ?>, this.value)">
                    <option value="new" <?php echo $row['status']=='new'?'selected':''; ?>>New</option>
                    <option value="read" <?php echo $row['status']=='read'?'selected':''; ?>>Read</option>
                    <option value="replied" <?php echo $row['status']=='replied'?'selected':''; ?>>Replied</option>
                    <option value="closed" <?php echo $row['status']=='closed'?'selected':''; ?>>Closed</option>
                </select>
              </td>
              <td><span class="time-stamp"><?php echo date('M j, H:i', strtotime($row['created_at'])); ?></span></td>
              <td>
                <div class="action-btns">
                  <a class="btn-icon btn-view" href="mailto:<?php echo htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?>?subject=Liora%20Support%20Ticket%20%23<?php echo intval($row['id']); ?>" title="Reply by email"><i class="fi fi-rr-envelope"></i></a>
                  <button class="btn-icon btn-reject" onclick="deleteSupportMessage(<?php echo $row['id']; ?>)" title="Delete Message"><i class="fi fi-rr-trash"></i></button>
                </div>
              </td>
            </tr>
            <?php endwhile; ?>
          <?php else: ?>
             <tr><td colspan="7" class="empty-state">No support messages yet.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
      </div>
    </section>

    <!-- Products Control -->
    <section class="table-section glass-card" id="products-section">
      <div class="section-header">
        <div class="section-title-box">
            <i class="fi fi-rr-box"></i>
            <h2>Inventory Control</h2>
        </div>
      </div>
      <div class="table-responsive">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Category</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if($productsResult && $productsResult->num_rows > 0): ?>
            <?php while($row = $productsResult->fetch_assoc()): ?>
            <tr>
              <td>
                <div class="user-row">
                    <img src="<?php echo htmlspecialchars($row['image_url'] ?: 'assets/img/default-flower.jpg'); ?>" class="product-img" alt="<?php echo htmlspecialchars($row['name']); ?>">
                    <strong><?php echo htmlspecialchars($row['name']); ?></strong>
                </div>
              </td>
              <td><strong>$<?php echo number_format($row['price'], 2); ?></strong></td>
              <td>
                <span class="stock-pill <?php echo $row['stock'] < 5 ? 'low' : ''; ?>">
                    <?php echo $row['stock']; ?> left
                </span>
              </td>
              <td><span class="cat-pill"><?php echo htmlspecialchars($row['category']); ?></span></td>
              <td>
                <div class="action-btns">
                  <button class="btn-icon btn-edit" onclick="editProduct(<?php echo $row['id']; ?>, '<?php echo addslashes($row['name']); ?>', <?php echo $row['price']; ?>, <?php echo $row['stock']; ?>)" title="Edit Product"><i class="fi fi-rr-edit"></i></button>
                  <button class="btn-icon btn-reject" onclick="deleteProduct(<?php echo $row['id']; ?>)" title="Delete Product"><i class="fi fi-rr-trash"></i></button>
                </div>
              </td>
            </tr>
            <?php endwhile; ?>
          <?php else: ?>
             <tr><td colspan="5" class="empty-state">No products found in inventory 🌷</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
      </div>
    </section>

  </main>
</div>

<div id="toast-container"></div>

<script src="assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
