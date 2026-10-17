<?php
session_start();

if (empty($_SESSION['user_id'])) {
    header('Location: login-register.php?message=login_required');
    exit();
}

include 'header.php';
include 'reward_helper.php';
require_once 'config.php';

$isLoggedIn = !empty($_SESSION['user_id']);
$userId = intval($_SESSION['user_id']);
$userData = null;
$rewardPointsTotal = 0;
$orders = [];
$rewardOrders = [];

function getActiveOrderStatuses() {
    return ['pending', 'paid', 'shipped'];
}

function getPaidOrderStatuses() {
    return ['paid', 'shipped', 'delivered', 'completed', 'arrived'];
}

function getStatusSqlList($statuses) {
    return "'" . implode("','", array_map('strtolower', $statuses)) . "'";
}

function calculateAccountOrderPoints($amount) {
    return calculatePointsFromAmount($amount);
}

function isOrderEditableStatus($status) {
    return in_array(strtolower((string) $status), ['pending', 'paid'], true);
}

function e($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

$stmt = $conn->prepare('SELECT username, first_name, last_name, email FROM users WHERE id = ?');
$stmt->bind_param('i', $userId);
$stmt->execute();
$userData = $stmt->get_result()->fetch_assoc() ?: [];
$stmt->close();

$activeStatusSql = getStatusSqlList(getActiveOrderStatuses());
$orderStmt = $conn->prepare("SELECT id, order_number, status, total, created_at, delivery_date FROM orders WHERE user_id = ? AND LOWER(status) IN ($activeStatusSql) ORDER BY created_at DESC, id DESC");
$orderStmt->bind_param('i', $userId);
$orderStmt->execute();
$orderResult = $orderStmt->get_result();
while ($row = $orderResult->fetch_assoc()) {
    $orders[] = $row;
}
$orderStmt->close();

$paidStatusSql = getStatusSqlList(getPaidOrderStatuses());
$rewardStmt = $conn->prepare("SELECT id, order_number, status, total, created_at, delivery_date FROM orders WHERE user_id = ? AND LOWER(status) IN ($paidStatusSql) ORDER BY created_at DESC, id DESC");
$rewardStmt->bind_param('i', $userId);
$rewardStmt->execute();
$rewardResult = $rewardStmt->get_result();
while ($row = $rewardResult->fetch_assoc()) {
    $rewardOrders[] = [
        'id' => intval($row['id']),
        'order_number' => $row['order_number'],
        'total' => floatval($row['total']),
        'points' => calculateAccountOrderPoints($row['total']),
        'created_at' => $row['created_at'],
        'delivery_date' => $row['delivery_date']
    ];
}
$rewardStmt->close();

$rewardPointsTotal = getUserRewardPoints($conn, $userId);
$displayName = $userData['first_name'] ?: ($userData['username'] ?: 'Friend');
$completedRewardOrders = count($rewardOrders);
$nextTierPoints = 100;
$tierName = 'Sprout';
$tierLabel = 'Start earning';

if ($rewardPointsTotal >= 500) {
    $tierName = 'Legend';
    $tierLabel = 'Highest tier';
    $nextTierPoints = null;
} elseif ($rewardPointsTotal >= 250) {
    $tierName = 'Blossom';
    $tierLabel = 'VIP savings';
    $nextTierPoints = 500;
} elseif ($rewardPointsTotal >= 100) {
    $tierName = 'Bloom';
    $tierLabel = 'Rewards unlocked';
    $nextTierPoints = 250;
}

$tierProgress = $nextTierPoints ? min(($rewardPointsTotal / $nextTierPoints) * 100, 100) : 100;
?>

<main class="main account-page">
  <section class="account-hero">
    <div class="account-hero__inner container">
      <div>
        <span class="account-eyebrow">My Liora</span>
        <h1>Hello, <?php echo e($displayName); ?></h1>
        <p>Manage your profile, active orders, delivery tracking, reward points, and search history in one place.</p>
      </div>
      <div class="account-hero__actions">
        <a href="checkout.php" class="account-btn account-btn--light">
          <i class="fi fi-rs-shopping-cart"></i>
          Checkout
        </a>
        <a href="accounts.php?tab=reward-points" class="account-btn">
          <i class="fi fi-rs-gift"></i>
          Rewards
        </a>
      </div>
    </div>
  </section>

  <section class="accounts section--lg">
    <div class="accounts__container container">
      <aside class="account__sidebar">
        <div class="account__identity">
          <div class="account__avatar"><?php echo e(mb_strtoupper(mb_substr($displayName, 0, 1))); ?></div>
          <div>
            <strong><?php echo e(trim(($userData['first_name'] ?? '') . ' ' . ($userData['last_name'] ?? '')) ?: $displayName); ?></strong>
            <span><?php echo e($userData['email'] ?? ''); ?></span>
          </div>
        </div>

        <div class="account__tabs" aria-label="Account sections">
          <button type="button" class="account__tab active-tab" data-target="#dashboard">
            <i class="fi fi-rs-settings-sliders"></i>
            Dashboard
          </button>
          <button type="button" class="account__tab" data-target="#orders">
            <i class="fi fi-rs-shopping-bag"></i>
            Orders
          </button>
          <button type="button" class="account__tab" data-target="#reward-points">
            <i class="fi fi-rs-gift"></i>
            Reward Points
          </button>
          <button type="button" class="account__tab" data-target="#account-search-history">
            <i class="fi fi-rs-search"></i>
            Search History
          </button>
          <button type="button" class="account__tab" data-target="#update-profile">
            <i class="fi fi-rs-user"></i>
            Update Profile
          </button>
          <button type="button" class="account__tab" id="logout-tab">
            <i class="fi fi-rs-exit"></i>
            Logout
          </button>
        </div>
      </aside>

      <div class="tabs__content">
        <div class="tab__content active-tab" content id="dashboard">
          <div class="account-section-heading">
            <span>Overview</span>
            <h2 class="tab__header">Hello <?php echo e($displayName); ?></h2>
            <p>Quick access to the pieces customers use most after ordering.</p>
          </div>

          <div class="account-stats">
            <button type="button" class="account-stat account-jump" data-target="#orders">
              <i class="fi fi-rs-shopping-bag"></i>
              <strong><?php echo count($orders); ?></strong>
              <span>Active orders</span>
            </button>
            <button type="button" class="account-stat account-jump" data-target="#reward-points">
              <i class="fi fi-rs-gift"></i>
              <strong><?php echo intval($rewardPointsTotal); ?></strong>
              <span>Reward points</span>
            </button>
            <button type="button" class="account-stat account-jump" data-target="#account-search-history">
              <i class="fi fi-rs-search"></i>
              <strong>History</strong>
              <span>Recent searches</span>
            </button>
          </div>

          <div class="account-quick-grid">
            <a href="deliveryMap.php" class="account-action-card">
              <i class="fi fi-rs-marker"></i>
              <strong>Locate Delivery</strong>
              <span>Track the newest active order before it arrives.</span>
            </a>
            <a href="checkout.php" class="account-action-card">
              <i class="fi fi-rs-credit-card"></i>
              <strong>Continue Checkout</strong>
              <span>Finish payment and come back here to see orders and points.</span>
            </a>
            <a href="accounts.php?tab=reward-points" class="account-action-card">
              <i class="fi fi-rs-star"></i>
              <strong>Flower Points</strong>
              <span>See your point balance after every successful payment.</span>
            </a>
            <button type="button" class="account-action-card account-jump" data-target="#update-profile">
              <i class="fi fi-rs-user-pen"></i>
              <strong>Update Profile</strong>
              <span>Edit your name, email, username, or password.</span>
            </button>
          </div>
        </div>

        <div class="tab__content" content id="orders">
          <div class="account-section-heading">
            <span>Orders</span>
            <h2 class="tab__header">Active Orders</h2>
            <p>Paid, pending, and shipped orders stay here. Once delivery is marked arrived, this list becomes empty.</p>
          </div>

          <div class="account-table-wrap">
            <table class="placed__order-table account-order-table">
              <thead>
                <tr>
                  <th>Order</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>Total</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="orders-tbody">
                <?php if (!empty($orders)): ?>
                  <?php foreach ($orders as $order): ?>
                    <?php
                      $dateSource = !empty($order['delivery_date']) ? $order['delivery_date'] : $order['created_at'];
                      $formattedDate = (new DateTime($dateSource))->format('M j, Y');
                      $status = strtolower($order['status']);
                      $isEditable = isOrderEditableStatus($status);
                    ?>
                    <tr data-order-id="<?php echo intval($order['id']); ?>">
                      <td><strong>#<?php echo e($order['order_number']); ?></strong></td>
                      <td><?php echo e($formattedDate); ?></td>
                      <td><span class="account-status account-status--<?php echo e($status); ?>"><?php echo e(ucfirst($status)); ?></span></td>
                      <td><strong>$<?php echo number_format(floatval($order['total']), 2); ?></strong></td>
                      <td>
                        <div class="account-row-actions">
                          <a href="order_details.php?order_id=<?php echo intval($order['id']); ?>" class="view__order">View</a>
                          <a href="deliveryMap.php?order_id=<?php echo intval($order['id']); ?>" class="view__order view__order--track">Track</a>
                          <?php if ($isEditable): ?>
                            <button type="button" class="delete__order" title="Cancel Order">
                              <i class="fi fi-rs-trash"></i>
                            </button>
                          <?php endif; ?>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr><td colspan="5" class="account-empty-row">No active orders. New paid orders will appear here after checkout.</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>

          <div class="account-inline-actions">
            <a href="checkout.php" class="account-btn account-btn--soft">Go to Checkout</a>
            <a href="deliveryMap.php" class="account-btn account-btn--soft">Locate Latest Delivery</a>
          </div>
        </div>

        <div class="tab__content" content id="reward-points">
          <div class="account-section-heading">
            <span>Rewards</span>
            <h2 class="tab__header">Reward Points</h2>
            <p>Your balance updates after checkout payment succeeds. Use points at checkout when you reach the unlock amount.</p>
          </div>

          <div class="account-reward-layout">
            <div class="account-rewards__summary">
              <span class="reward-kicker">Total balance</span>
              <strong id="account-reward-points"><?php echo intval($rewardPointsTotal); ?></strong>
              <p>Earn 1 point for every $2 spent on flowers and gifts.</p>
              <a href="checkout.php" class="account-btn">Use at Checkout</a>
            </div>

            <div class="account-tier-panel">
              <div class="account-tier-panel__top">
                <div>
                  <span>Your tier</span>
                  <h3><?php echo e($tierName); ?></h3>
                </div>
                <strong><?php echo e($tierLabel); ?></strong>
              </div>
              <div class="account-progress">
                <span style="width: <?php echo e(number_format($tierProgress, 2)); ?>%;"></span>
              </div>
              <?php if ($nextTierPoints): ?>
                <p><?php echo max($nextTierPoints - $rewardPointsTotal, 0); ?> more points to reach the next tier.</p>
              <?php else: ?>
                <p>You reached the highest reward tier.</p>
              <?php endif; ?>
            </div>
          </div>

          <div class="reward-explanation">
            <div class="reward-step">
              <i class="fi fi-rs-shopping-bag"></i>
              <h4>Earn</h4>
              <p>Every successful payment adds points based on the order total.</p>
            </div>
            <div class="reward-step">
              <i class="fi fi-rs-credit-card"></i>
              <h4>Redeem</h4>
              <p>Use available points from the checkout payment section.</p>
            </div>
            <div class="reward-step">
              <i class="fi fi-rs-receipt"></i>
              <h4>Review</h4>
              <p>Return here from the payment success page to see your updated balance.</p>
            </div>
          </div>

          <div class="account-rewards__orders" id="account-reward-orders">
            <h3>Point History</h3>
            <?php if (!empty($rewardOrders)): ?>
              <?php foreach ($rewardOrders as $rewardOrder): ?>
                <?php
                  $dateSource = !empty($rewardOrder['delivery_date']) ? $rewardOrder['delivery_date'] : $rewardOrder['created_at'];
                  $formattedDate = (new DateTime($dateSource))->format('M j, Y');
                ?>
                <div class="account-reward-order">
                  <div>
                    <strong>#<?php echo e($rewardOrder['order_number']); ?></strong>
                    <span><?php echo e($formattedDate); ?> · $<?php echo number_format($rewardOrder['total'], 2); ?></span>
                  </div>
                  <p>+<?php echo intval($rewardOrder['points']); ?> points</p>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <p class="account-rewards__empty">Paid orders will appear here with the points they earned.</p>
            <?php endif; ?>
          </div>
        </div>

        <div class="tab__content" content id="account-search-history">
          <div class="account-section-heading">
            <span>Search</span>
            <h2 class="tab__header">Search History</h2>
            <p>This section is connected to <code>search_history.php</code> and your database history table.</p>
          </div>

          <div class="account-search-history-panel">
            <div class="account-search-history-panel__top">
              <div>
                <strong>Recent searches</strong>
                <span>Open a previous search or clear everything at once.</span>
              </div>
              <button type="button" class="account-btn account-btn--danger" id="clear-all-history">
                <i class="fi fi-rs-trash"></i>
                Clear All
              </button>
            </div>
            <div id="account-search-history-list" class="account-search-history">
              <p class="loading-text">Loading your search history...</p>
            </div>
          </div>
        </div>

        <div class="tab__content" content id="update-profile">
          <div class="account-section-heading">
            <span class="cute-tag">Security & Identity</span>
            <h2 class="tab__header">Personal Details</h2>
            <p>Your profile is the heart of your Liora experience. Keep your details current for faster checkouts and personalized rewards.</p>
          </div>

          <div class="profile-redesign">
            <div class="profile-card">
              <div class="profile-card__header">
                <div class="profile-card__avatar-wrap">
                   <div class="profile-card__avatar"><?php echo e(mb_strtoupper(mb_substr($displayName, 0, 1))); ?></div>
                   <div class="profile-card__badge" title="Verified Account">
                     <i class="fi fi-rs-badge-check"></i>
                   </div>
                </div>
                <div class="profile-card__info">
                  <h3><?php echo e($displayName); ?></h3>
                  <span>Liora Member since 2026</span>
                </div>
              </div>

              <div class="profile-card__details">
                <div class="profile-detail-item">
                  <i class="fi fi-rs-envelope"></i>
                  <div>
                    <label>Email Address</label>
                    <strong><?php echo e($userData['email'] ?? ''); ?></strong>
                  </div>
                </div>
                <div class="profile-detail-item">
                  <i class="fi fi-rs-shield-check"></i>
                  <div>
                    <label>Account Security</label>
                    <strong class="security-status low-risk">Healthy & Secure</strong>
                  </div>
                </div>
              </div>
              
              <div class="profile-card__note">
                <p>personal information</p>
              </div>
            </div>

            <div class="profile-form-wrap">
              <form class="form account-profile__form" id="profile-form">
                <div class="form-grid-2">
                  <div class="cute-input-group">
                    <label>First Name</label>
                    <div class="input-with-icon">
                      <i class="fi fi-rs-user"></i>
                      <input type="text" name="first_name" placeholder="E.g. Rose" class="form__input" value="<?php echo e($userData['first_name'] ?? ''); ?>" required />
                    </div>
                  </div>
                  <div class="cute-input-group">
                    <label>Last Name</label>
                    <div class="input-with-icon">
                      <i class="fi fi-rs-users"></i>
                      <input type="text" name="last_name" placeholder="E.g. Smith" class="form__input" value="<?php echo e($userData['last_name'] ?? ''); ?>" />
                    </div>
                  </div>
                </div>

                <div class="cute-input-group">
                  <label>Username</label>
                  <div class="input-with-icon">
                    <i class="fi fi-rs-at"></i>
                    <input type="text" name="username" placeholder="Choose a unique username" class="form__input" value="<?php echo e($userData['username'] ?? ''); ?>" required />
                  </div>
                </div>

                <div class="cute-input-group">
                  <label>Email Address</label>
                  <div class="input-with-icon">
                    <i class="fi fi-rs-envelope"></i>
                    <input type="email" name="email" placeholder="hello@example.com" class="form__input" value="<?php echo e($userData['email'] ?? ''); ?>" required />
                  </div>
                </div>

                <div class="cute-input-group">
                  <label>Update Password</label>
                  <div class="input-with-icon">
                    <i class="fi fi-rs-key"></i>
                    <input type="password" name="new_password" placeholder="••••••••" class="form__input" autocomplete="new-password" />
                  </div>
                  <span class="input-help">Leave blank if you don't want to change it.</span>
                </div>

                <button type="submit" class="premium-save-btn">
                  <span>Save Profile Updates</span>
                  <i class="fi fi-rs-disk"></i>
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<style>
.account-page {
  background: linear-gradient(180deg, #fff7fb 0%, #ffffff 55%, #fff8f1 100%);
  min-height: 100vh;
}

.account-hero {
  padding: 2.4rem 0 1rem;
}

.account-hero__inner {
  min-height: 210px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 1.5rem;
  padding: 2.3rem;
  border-radius: 8px;
  background: linear-gradient(135deg, #7f365d 0%, #d86f9a 55%, #f4b24f 100%);
  color: #fff;
  box-shadow: 0 22px 50px rgba(127, 54, 93, 0.22);
}

.account-eyebrow,
.account-section-heading span,
.reward-kicker {
  display: inline-flex;
  font-size: 0.78rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0;
}

.account-hero h1 {
  color: #fff;
  font-size: 2.5rem;
  margin: 0.35rem 0 0.6rem;
}

.account-hero p {
  max-width: 620px;
  color: rgba(255, 255, 255, 0.88);
}

.account-hero__actions,
.account-inline-actions,
.account-row-actions {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 0.7rem;
}

.accounts__container {
  display: grid;
  grid-template-columns: 280px minmax(0, 1fr);
  gap: 1.4rem;
}

.account__sidebar,
.tabs__content,
.account-search-history-panel,
.account-profile__panel,
.account-profile__form,
.account-rewards__summary,
.account-tier-panel {
  background: rgba(255, 255, 255, 0.96);
  border: 1px solid #f1d9e4;
  border-radius: 8px;
  box-shadow: 0 14px 36px rgba(122, 67, 93, 0.08);
}

.account__sidebar {
  position: sticky;
  top: 1rem;
  align-self: start;
  padding: 1rem;
}

.account__identity {
  display: flex;
  align-items: center;
  gap: 0.85rem;
  padding: 0.85rem;
  margin-bottom: 0.7rem;
  border-bottom: 1px solid #f4dce7;
}

.account__avatar {
  width: 48px;
  aspect-ratio: 1;
  border-radius: 50%;
  display: grid;
  place-items: center;
  color: #fff;
  font-weight: 800;
  background: #c14e8f;
}

.account__identity strong,
.account__identity span {
  display: block;
}

.account__identity span {
  max-width: 170px;
  color: #8b6a78;
  font-size: 0.85rem;
  overflow-wrap: anywhere;
}

.account__tabs {
  display: grid;
  gap: 0.45rem;
}

.account__tab {
  min-height: 46px;
  display: flex;
  align-items: center;
  gap: 0.7rem;
  padding: 0.75rem 0.9rem;
  border-radius: 8px;
  color: #7d365d;
  background: transparent;
  border: 1px solid transparent;
  font-weight: 700;
  text-align: left;
  cursor: pointer;
  transition: 0.2s ease;
}

.account__tab:hover,
.account__tab.active-tab {
  background: #fff1f7;
  border-color: #f0c7d8;
  color: #c14e8f;
}

.tabs__content {
  padding: 1.4rem;
  min-width: 0;
}

.tab__content {
  display: none;
}

.tab__content.active-tab {
  display: block;
  animation: accountFade 0.25s ease;
}

.account-section-heading {
  margin-bottom: 1.25rem;
}

.account-section-heading span,
.reward-kicker {
  color: #c14e8f;
}

.account-section-heading h2 {
  font-size: 1.9rem;
  margin: 0.25rem 0 0.35rem;
}

.account-section-heading p {
  color: #745463;
  max-width: 760px;
}

.account-btn,
.view__order,
.delete__order {
  min-height: 40px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 0.72rem 1rem;
  border-radius: 8px;
  background: #c14e8f;
  color: #fff;
  font-weight: 800;
  border: 0;
  cursor: pointer;
  transition: 0.2s ease;
}

.account-btn:hover,
.view__order:hover,
.delete__order:hover {
  transform: translateY(-1px);
  box-shadow: 0 10px 22px rgba(193, 78, 143, 0.18);
}

.account-btn--light {
  background: #fff;
  color: #9d3e73;
}

.account-btn--soft,
.view__order {
  background: #fff1f7;
  color: #9d3e73;
}

.view__order--track {
  background: #eef8f5;
  color: #24735f;
}

.account-btn--danger,
.delete__order {
  background: #df5a63;
  color: #fff;
}

.account-btn--wide {
  width: 100%;
}

.account-stats,
.account-quick-grid,
.reward-explanation {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 1rem;
}

.account-stat,
.account-action-card,
.reward-step {
  min-height: 132px;
  padding: 1.1rem;
  border: 1px solid #f0d7e2;
  border-radius: 8px;
  background: #fff;
  color: #65364e;
  text-align: left;
  cursor: pointer;
}

.account-stat i,
.account-action-card i,
.reward-step i {
  color: #c14e8f;
  font-size: 1.4rem;
}

.account-stat strong,
.account-stat span,
.account-action-card strong,
.account-action-card span {
  display: block;
}

.account-stat strong {
  margin: 0.65rem 0 0.1rem;
  font-size: 1.7rem;
  color: #4a1f2d;
}

.account-stat span,
.account-action-card span {
  color: #7b5b68;
}

.account-quick-grid {
  grid-template-columns: repeat(4, minmax(0, 1fr));
  margin-top: 1rem;
}

.account-action-card {
  border-color: #efd8dc;
}

.account-table-wrap {
  overflow-x: auto;
  border: 1px solid #f0d7e2;
  border-radius: 8px;
}

.account-order-table th {
  background: #7f365d;
  color: #fff;
  text-align: left;
  padding: 0.9rem;
  white-space: nowrap;
}

.account-order-table td {
  padding: 0.9rem;
  border-bottom: 1px solid #f4e1e8;
  vertical-align: middle;
}

.account-order-table tr:last-child td {
  border-bottom: 0;
}

.account-status {
  display: inline-flex;
  padding: 0.35rem 0.65rem;
  border-radius: 999px;
  background: #fff1f7;
  color: #9d3e73;
  font-size: 0.82rem;
  font-weight: 800;
}

.account-status--paid,
.account-status--shipped {
  background: #eef8f5;
  color: #24735f;
}

.account-empty-row,
.account-rewards__empty,
.loading-text,
.error-text {
  text-align: center;
  color: #7b5b68;
  padding: 1.4rem;
}

.account-inline-actions {
  margin-top: 1rem;
}

.account-reward-layout,
.account-profile {
  display: grid;
  grid-template-columns: minmax(0, 0.9fr) minmax(0, 1.1fr);
  gap: 1rem;
}

.account-rewards__summary,
.account-tier-panel,
.account-profile__panel,
.account-profile__form {
  padding: 1.25rem;
}

.account-rewards__summary {
  color: #fff;
  background: linear-gradient(135deg, #7f365d 0%, #c14e8f 60%, #e2a33f 100%);
}

.account-rewards__summary .reward-kicker,
.account-rewards__summary p {
  color: rgba(255, 255, 255, 0.86);
}

.account-rewards__summary strong {
  display: block;
  margin: 0.45rem 0;
  color: #fff;
  font-size: 3.4rem;
  line-height: 1;
}

.account-tier-panel__top {
  display: flex;
  justify-content: space-between;
  gap: 1rem;
  margin-bottom: 1rem;
}

.account-tier-panel__top span,
.account-tier-panel__top strong {
  color: #8b6a78;
  font-size: 0.9rem;
}

.account-tier-panel__top h3 {
  font-size: 1.8rem;
}

.account-progress {
  height: 10px;
  overflow: hidden;
  border-radius: 999px;
  background: #f5e3eb;
}

.account-progress span {
  display: block;
  height: 100%;
  background: linear-gradient(90deg, #c14e8f, #e2a33f);
}

.account-tier-panel p {
  margin-top: 0.8rem;
}

.reward-explanation {
  margin: 1rem 0;
}

.reward-step h4 {
  margin: 0.6rem 0 0.3rem;
}

.account-rewards__orders h3 {
  margin: 1.2rem 0 0.7rem;
}

.account-reward-order {
  display: flex;
  justify-content: space-between;
  gap: 1rem;
  padding: 0.95rem 1rem;
  margin-bottom: 0.65rem;
  border: 1px solid #f0d7e2;
  border-radius: 8px;
  background: #fff;
}

.account-reward-order span {
  display: block;
  color: #7b5b68;
  font-size: 0.9rem;
}

.account-reward-order p {
  color: #24735f;
  font-weight: 800;
  white-space: nowrap;
}

.account-search-history-panel__top {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 1rem;
  padding: 1rem;
  border-bottom: 1px solid #f0d7e2;
}

.account-search-history-panel__top span {
  display: block;
  color: #7b5b68;
  font-size: 0.9rem;
}

.account-search-history {
  padding: 0.6rem;
}

.account-search-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 1rem;
  padding: 0.85rem;
  border-bottom: 1px solid #f5e3eb;
}

.account-search-item:last-child {
  border-bottom: 0;
}

.account-search-item__query {
  display: flex;
  align-items: center;
  gap: 0.7rem;
  color: #4a1f2d;
  font-weight: 800;
  overflow-wrap: anywhere;
}

.account-search-item__actions {
  display: flex;
  gap: 0.55rem;
  flex-shrink: 0;
}

.delete-history-item {
  width: 40px;
  aspect-ratio: 1;
  border-radius: 8px;
  background: #fff1f2;
  color: #cf4b55;
  cursor: pointer;
}

.account-profile__badge {
  width: 54px;
  aspect-ratio: 1;
  display: grid;
  place-items: center;
  margin-bottom: 1rem;
  border-radius: 50%;
  background: #fff1f7;
  color: #c14e8f;
  font-size: 1.4rem;
}

.account-profile__panel p {
  margin: 0.7rem 0 1rem;
}

.account-profile__mini {
  padding: 0.9rem;
  border-radius: 8px;
  background: #fff8fb;
  overflow-wrap: anywhere;
}

.account-profile__mini span,
.account-profile__mini strong {
  display: block;
}

.account-profile__mini span {
  color: #8b6a78;
  font-size: 0.85rem;
}

.account-profile__form {
  display: grid;
  gap: 1rem;
}

.account-profile__form label,
.account-profile__form label span {
  display: grid;
  gap: 0.45rem;
}

.account-profile__form label span {
  color: #65364e;
  font-weight: 800;
}

.account-profile__form .form__input {
  width: 100%;
  height: 48px;
  padding: 0 0.9rem;
  border: 1px solid #edcadb;
  border-radius: 8px;
  background: #fff;
  font-size: 1rem;
}

.account-profile__form .form__input:focus {
  border-color: #c14e8f;
  box-shadow: 0 0 0 3px rgba(193, 78, 143, 0.12);
}

.account-form-grid {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
}

code {
  padding: 0.1rem 0.3rem;
  border-radius: 4px;
  background: #fff1f7;
  color: #9d3e73;
}

@keyframes accountFade {
  from { opacity: 0; transform: translateY(8px); }
  to { opacity: 1; transform: translateY(0); }
}

@media screen and (max-width: 992px) {
  .accounts__container,
  .account-reward-layout,
  .profile-redesign {
    grid-template-columns: 1fr;
  }

  .account__sidebar {
    position: static;
  }

  .account__tabs {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }

  .account-quick-grid,
  .account-stats,
  .reward-explanation {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }
}

/* Redesigned Profile Styles */
.profile-redesign {
  display: grid;
  grid-template-columns: 340px 1fr;
  gap: 2rem;
  align-items: start;
}

.cute-tag {
  color: #c14e8f;
  background: #fff1f7;
  padding: 0.3rem 0.8rem;
  border-radius: 99px;
  font-size: 0.75rem;
  font-weight: 800;
  display: inline-block;
  margin-bottom: 0.5rem;
}

.profile-card {
  background: white;
  border-radius: 20px;
  padding: 1.8rem;
  border: 1px solid #f1d9e4;
  box-shadow: 0 15px 45px rgba(122, 67, 93, 0.08);
  position: sticky;
  top: 1rem;
}

.profile-card__header {
  display: flex;
  align-items: center;
  gap: 1.2rem;
  margin-bottom: 2rem;
}

.profile-card__avatar-wrap {
  position: relative;
}

.profile-card__avatar {
  width: 70px;
  height: 70px;
  background: linear-gradient(135deg, #c14e8f 0%, #e97da8 100%);
  border-radius: 50%;
  display: grid;
  place-items: center;
  color: white;
  font-size: 1.8rem;
  font-weight: 800;
  box-shadow: 0 8px 20px rgba(193, 78, 143, 0.25);
}

.profile-card__badge {
  position: absolute;
  bottom: -4px;
  right: -4px;
  width: 24px;
  height: 24px;
  background: #24735f;
  color: white;
  border-radius: 50%;
  display: grid;
  place-items: center;
  font-size: 0.8rem;
  border: 2px solid white;
}

.profile-card__info h3 {
  font-size: 1.3rem;
  margin: 0;
  color: #2d1b24;
}

.profile-card__info span {
  font-size: 0.85rem;
  color: #8b6a78;
}

.profile-card__details {
  display: grid;
  gap: 1.4rem;
  margin-bottom: 2rem;
}

.profile-detail-item {
  display: flex;
  gap: 1rem;
  align-items: center;
}

.profile-detail-item i {
  width: 40px;
  height: 40px;
  background: #fff8fb;
  color: #c14e8f;
  border-radius: 12px;
  display: grid;
  place-items: center;
  font-size: 1.1rem;
}

.profile-detail-item label {
  display: block;
  font-size: 0.75rem;
  color: #8b6a78;
  margin-bottom: 2px;
}

.profile-detail-item strong {
  display: block;
  font-size: 0.95rem;
  color: #2d1b24;
}

.security-status.low-risk {
  color: #24735f;
}

.profile-card__note {
  padding-top: 1.5rem;
  border-top: 1px dashed #f1d9e4;
  font-size: 0.8rem;
  color: #8b6a78;
  line-height: 1.5;
}

.profile-form-wrap {
  background: white;
  border-radius: 20px;
  padding: 2.2rem;
  border: 1px solid #f1d9e4;
  box-shadow: 0 10px 30px rgba(0,0,0,0.02);
}

.cute-input-group {
  margin-bottom: 1.5rem;
}

.cute-input-group label {
  display: block;
  font-weight: 700;
  font-size: 0.9rem;
  color: #4a1f2d;
  margin-bottom: 0.6rem;
}

.input-with-icon {
  position: relative;
}

.input-with-icon i {
  position: absolute;
  left: 1.1rem;
  top: 50%;
  transform: translateY(-50%);
  color: #bfa5b1;
  transition: 0.3s;
}

.input-with-icon .form__input {
  padding-left: 3rem !important;
  background: #fffafa !important;
  border: 1px solid #edcadb !important;
  border-radius: 12px !important;
  height: 52px !important;
  transition: all 0.3s ease !important;
}

.input-with-icon .form__input:focus {
  background: white !important;
  border-color: #c14e8f !important;
  box-shadow: 0 0 0 4px rgba(193, 78, 143, 0.1) !important;
}

.input-with-icon .form__input:focus + i {
  color: #c14e8f;
}

.input-help {
  display: block;
  font-size: 0.78rem;
  color: #8b6a78;
  margin-top: 0.4rem;
}

.form-grid-2 {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1.2rem;
}

.premium-save-btn {
  width: 100%;
  height: 56px;
  background: linear-gradient(135deg, #7f365d 0%, #c14e8f 100%);
  color: white;
  border: none;
  border-radius: 14px;
  font-weight: 800;
  font-size: 1.05rem;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.8rem;
  cursor: pointer;
  transition: 0.3s;
  box-shadow: 0 10px 25px rgba(127, 54, 93, 0.2);
  margin-top: 1rem;
}

.premium-save-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 14px 35px rgba(127, 54, 93, 0.3);
  filter: brightness(1.1);
}

.premium-save-btn:active {
  transform: scale(0.98);
}

@media screen and (max-width: 992px) {
  .profile-redesign {
    grid-template-columns: 1fr;
  }
  .profile-card {
    position: static;
  }
}

@media screen and (max-width: 640px) {
  .form-grid-2 {
    grid-template-columns: 1fr;
  }
}

@media screen and (max-width: 640px) {
  .account-hero__inner,
  .account-search-history-panel__top,
  .account-search-item,
  .account-reward-order {
    align-items: stretch;
    flex-direction: column;
  }

  .account-hero__inner {
    padding: 1.4rem;
  }

  .account-hero h1 {
    font-size: 2rem;
  }

  .account__tabs,
  .account-quick-grid,
  .account-stats,
  .reward-explanation,
  .account-form-grid {
    grid-template-columns: 1fr;
  }

  .tabs__content {
    padding: 1rem;
  }
}
</style>

<script>
  window.isLoggedIn = true;
  window.accountUser = <?php echo json_encode([
      'firstName' => $userData['first_name'] ?? '',
      'lastName' => $userData['last_name'] ?? '',
      'username' => $userData['username'] ?? '',
      'email' => $userData['email'] ?? ''
  ]); ?>;
  window.userRewardPoints = <?php echo intval($rewardPointsTotal); ?>;
</script>
<script src="assets/js/account.js?v=<?php echo time(); ?>"></script>

<?php include 'footer.php'; ?>
