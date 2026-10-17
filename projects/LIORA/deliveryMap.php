<?php
session_start();
require_once 'config.php';

$userId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
$requestedOrderId = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
$isEmbed = isset($_GET['embed']);
$forcePreview = isset($_GET['preview']) || isset($_GET['guest']);
$deliveryOrder = null;
$deliveryItemCount = 0;
$itemSummary = '';
$isGuestView = false;

if ($userId > 0 && !$forcePreview) {
  if ($requestedOrderId > 0) {
    $stmt = $conn->prepare("SELECT id, order_number, status, total, address, city, delivery_date, delivery_time, customer_name, phone, created_at FROM orders WHERE id = ? AND user_id = ? AND status NOT IN ('cancelled', 'delivered', 'completed', 'arrived') LIMIT 1");
    $stmt->bind_param('ii', $requestedOrderId, $userId);
  } else {
    $stmt = $conn->prepare("SELECT id, order_number, status, total, address, city, delivery_date, delivery_time, customer_name, phone, created_at FROM orders WHERE user_id = ? AND status NOT IN ('cancelled', 'delivered', 'completed', 'arrived') ORDER BY created_at DESC, id DESC LIMIT 1");
    $stmt->bind_param('i', $userId);
  }

  if ($stmt) {
    $stmt->execute();
    $deliveryOrder = $stmt->get_result()->fetch_assoc();
    $stmt->close();
  }

  if ($deliveryOrder) {
    // Get total count
    $itemStmt = $conn->prepare('SELECT COALESCE(SUM(quantity), 0) AS item_count FROM order_items WHERE order_id = ?');
    $orderIdForItems = intval($deliveryOrder['id']);
    $itemStmt->bind_param('i', $orderIdForItems);
    $itemStmt->execute();
    $itemRow = $itemStmt->get_result()->fetch_assoc();
    $deliveryItemCount = intval($itemRow['item_count'] ?? 0);
    $itemStmt->close();

    // Get specific item names for the summary
    $detailStmt = $conn->prepare('SELECT p.name, oi.quantity FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ? LIMIT 3');
    $detailStmt->bind_param('i', $orderIdForItems);
    $detailStmt->execute();
    $detailResult = $detailStmt->get_result();
    $itemNames = [];
    while ($detailRow = $detailResult->fetch_assoc()) {
      $itemNames[] = $detailRow['name'];
    }
    $detailStmt->close();

    if (empty($itemNames)) {
      $itemSummary = $deliveryItemCount . ' Items';
    } else {
      $summaryText = implode(', ', $itemNames);
      if ($deliveryItemCount > count($itemNames)) {
        $summaryText .= ' and ' . ($deliveryItemCount - count($itemNames)) . ' more';
      }
      $itemSummary = $deliveryItemCount . ' Items (' . $summaryText . ')';
    }
  }
}

// If no delivery order found, set guest view mode with warehouse as default
if (!$deliveryOrder) {
  $isGuestView = true;
  $deliveryOrder = [
    'id' => 0,
    'order_number' => 'WAREHOUSE',
    'status' => 'demo',
    'address' => 'LIORA Central Warehouse',
    'city' => 'Sulaymaniyah',
    'delivery_date' => '',
    'delivery_time' => '',
    'customer_name' => 'Welcome',
    'phone' => '',
    'created_at' => '',
    'total' => 0
  ];
  $itemSummary = '🌸 Welcome to LIORA Warehouse';
}

$orderNumber = $deliveryOrder['order_number'] ?? 'LIORA';
$scheduleDateRaw = $deliveryOrder['delivery_date'] ?? '';
$scheduleTimeRaw = $deliveryOrder['delivery_time'] ?? '';
$scheduleDateLabel = $scheduleDateRaw ? (new DateTime($scheduleDateRaw))->format('j M Y') : 'not scheduled';
$destinationAddress = trim(($deliveryOrder['address'] ?? 'LIORA Central Warehouse') . (!empty($deliveryOrder['city']) ? ', ' . $deliveryOrder['city'] : ''));

$pageStyles = [
  'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css',
  'assets/css/styles_delivery.css'
];
$pageHeadScripts = ['https://unpkg.com/leaflet@1.9.4/dist/leaflet.js'];
$bodyClass = 'delivery-page';
if ($isEmbed) {
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">';
    foreach ($pageStyles as $style) {
        echo '<link rel="stylesheet" href="' . htmlspecialchars($style, ENT_QUOTES, 'UTF-8') . '">';
    }
    foreach ($pageHeadScripts as $script) {
        echo '<script src="' . htmlspecialchars($script, ENT_QUOTES, 'UTF-8') . '"></script>';
    }
    echo '</head><body class="' . htmlspecialchars($bodyClass, ENT_QUOTES, 'UTF-8') . ' delivery-page--embed">';
} else {
    include 'header.php';
}
?>
<!--=============== MAIN CONTENT ===============-->
  <main class="container section delivery-main" style="<?php echo isset($_GET['embed']) ? 'padding: 0; margin: 0; width: 100%;' : ''; ?>">

    <!-- Floating petals decoration -->
    <div class="petals-bg" aria-hidden="true" style="<?php echo isset($_GET['embed']) ? 'display: none;' : ''; ?>">
      <span class="petal">🌸</span>
      <span class="petal">🌷</span>
      <span class="petal">🌸</span>
      <span class="petal">🌹</span>
      <span class="petal">🌸</span>
    </div>

    <!-- Order Header -->
    <div class="delivery__header-card">
      <div class="delivery__header-left">
        <div class="order-badge">ORDER #<?php echo htmlspecialchars($orderNumber); ?></div>
        <h2 class="delivery__title"><?php echo $isGuestView ? '🏭 LIORA Warehouse' : 'Track Your Bouquet 🌹'; ?></h2>
        <p class="delivery__subtitle"><?php echo $itemSummary ? htmlspecialchars($itemSummary) . ($scheduleDateLabel !== 'not scheduled' ? ' • Scheduled for ' : '') : ''; ?><span id="original-date"><?php echo $scheduleDateLabel !== 'not scheduled' ? htmlspecialchars($scheduleDateLabel) : ''; ?></span></p>
        <p class="delivery__address"><i class="fi fi-rs-marker"></i> Location: <strong><?php echo htmlspecialchars($destinationAddress); ?></strong></p>
      </div>
      <div class="delivery__header-right">
        <div class="order-status-pill">
          <span class="status-dot"></span> <?php echo $isGuestView ? 'Welcome' : 'On the Way'; ?>
        </div>
      </div>
    </div>

    <!-- Progress Steps -->
    <div class="delivery__progress" style="<?php echo $isGuestView ? 'display: none;' : ''; ?>">
      <div class="progress-steps">
        <div class="step completed" data-step="1">
          <div class="step-circle">✓</div>
          <span>Order Placed</span>
        </div>
        <div class="step completed" data-step="2">
          <div class="step-circle">✓</div>
          <span>Packed</span>
        </div>
        <div class="step active" data-step="3">
          <div class="step-circle">🚚</div>
          <span>On the way</span>
        </div>
        <div class="step" data-step="4">
          <div class="step-circle">🏠</div>
          <span>Delivered</span>
        </div>
      </div>
    </div>

    <!-- Locate Delivery Header -->
    <div class="eta-strip locate-delivery-box" style="<?php echo $isGuestView ? 'display: none;' : ''; ?>">
      <div class="eta-strip__icon truck-pulse">🚚</div>
      <div class="eta-strip__info">
        <div class="eta-strip__label">Delivery Map</div>
        <div class="locate-delivery-box__title">Locate your delivery</div>
        <div class="locate-delivery-box__note">Follow your bouquet on the map below.</div>
      </div>
      <button onclick="liveTrack()" class="map-btn live-btn" id="live-track-btn">
        <span class="live-dot"></span> Live Track
      </button>
    </div>

    <!-- REAL INTERACTIVE MAP -->
    <div class="map-container">
      <div id="map">
        <div class="map-static-fallback" aria-hidden="true">
          <div class="map-static-grid"></div>
          <div class="map-static-route"></div>
          <div class="map-static-pin map-static-pin--warehouse">🏭<span>LIORA Warehouse</span></div>
          <?php if (!$isGuestView): ?>
            <div class="map-static-pin map-static-pin--destination">🏠<span>Delivery Address</span></div>
          <?php endif; ?>
        </div>
      </div>
      <div class="map-overlay-badge">
        <span class="live-dot"></span> Live Tracking
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons" style="<?php echo $isGuestView ? 'display: none;' : ''; ?>">
      <button onclick="showRescheduleModal()" class="option-btn--reschedule">
        📅 Reschedule Delivery
      </button>
      <button onclick="showCallDriverModal()" class="option-btn--call">
        📞 Call Driver
      </button>
    </div>

    <!-- Delivery Info Cards -->
    <div class="delivery__info">
      <div class="delivery-info-card">
        <div class="info-card__icon">📅</div>
        <div>
          <div class="info-card__title">Delivery Date</div>
          <div class="info-card__value" id="display-delivery-date"><?php echo htmlspecialchars($scheduleDateLabel); ?></div>
          <small style="color:#b085a0;">Scheduled time</small>
        </div>
      </div>
      <div class="delivery-info-card">
        <div class="info-card__icon">📍</div>
        <div>
          <div class="info-card__title">Current Location</div>
          <div class="info-card__value" id="current-location">Near Central Flower Market</div>
          <small style="color:#b085a0;">Updated just now</small>
        </div>
      </div>
      <div class="delivery-info-card">
        <div class="info-card__icon">🚚</div>
        <div>
          <div class="info-card__title">Driver</div>
          <div class="info-card__value">Sara • +750 899 0555</div>
          <small style="color:#4caf50;">🟢 Online now</small>
        </div>
      </div>
      
    </div>

  </main>

  <!-- =============== RESCHEDULE MODAL =============== -->
  <div id="reschedule-modal" class="liora-modal" role="dialog" aria-modal="true">
    <div class="liora-modal__backdrop" onclick="hideModals()"></div>
    <div class="liora-modal__box">
      <button class="modal-close-btn" onclick="hideModals()">✕</button>
      <div class="modal-icon">📅</div>
      <h3>Reschedule Delivery</h3>
      <p>Choose a new delivery date — we'll make it work!</p>
      <div class="reschedule-dates" id="date-options"></div>
      <div class="liora-modal__actions">
        <button onclick="hideModals()" class="modal-btn--keep">Keep Original</button>
        <button onclick="confirmReschedule()" class="modal-btn--confirm">Confirm Date ✓</button>
      </div>
    </div>
  </div>

  <!-- =============== CALL DRIVER MODAL =============== -->
  <div id="call-modal" class="liora-modal" role="dialog" aria-modal="true">
    <div class="liora-modal__backdrop" onclick="hideModals()"></div>
    <div class="liora-modal__box">
      <button class="modal-close-btn" onclick="hideModals()">✕</button>
      <div class="modal-icon">📞</div>
      <h3>Contact Your Driver</h3>
      <p>Sara is currently delivering your flowers 🌷</p>
      <div class="driver-card">
        <div class="driver-avatar">🚚</div>
        <div class="driver-details">
          <div class="driver-name">Sara</div>
          <div class="driver-phone">+750 899 0555</div>
          <div class="driver-status"><span style="color:#4caf50;">●</span> Online • 2.4km away</div>
        </div>
      </div>
      <div class="liora-modal__actions">
        <button onclick="hideModals()" class="modal-btn--keep">Close</button>
        <a href="tel:+7508990555" class="modal-btn--confirm" style="text-decoration:none; display:flex; align-items:center; justify-content:center; gap:0.4rem;" target="_self">📞 Call Now</a>
      </div>
    </div>
  </div>

  <!-- =============== DELIVERY CONFIRM MODAL =============== -->
  <div id="delivery-confirm-modal" class="liora-modal liora-modal--small" role="dialog" aria-modal="true">
    <div class="liora-modal__backdrop"></div>
    <div class="liora-modal__box delivery-confirm-box">
      <div class="modal-icon">🌷</div>
      <p id="delivery-confirm-message">Your order arrived</p>
      <button id="delivery-confirm-button" type="button" class="modal-btn--confirm">Confirm</button>
    </div>
  </div>

  <!-- =============== TOAST NOTIFICATION =============== -->
  <div id="toast" class="delivery-notification" style="display:none;" role="alert">
    <span class="notif-icon" id="toast-icon">🌷</span>
    <div class="notif-text" id="toast-text"></div>
    <button class="toast-close" onclick="closeToast()">✕</button>
  </div>

  <script>
    window.deliveryOrder = <?php echo json_encode([
      'id' => isset($deliveryOrder['id']) ? intval($deliveryOrder['id']) : 0,
      'order_number' => $orderNumber,
      'status' => $deliveryOrder['status'] ?? '',
      'total' => isset($deliveryOrder['total']) ? floatval($deliveryOrder['total']) : 0,
      'address' => $destinationAddress,
      'city' => $deliveryOrder['city'] ?? '',
      'delivery_date' => $scheduleDateRaw,
      'delivery_time' => $scheduleTimeRaw,
      'created_at' => $deliveryOrder['created_at'] ?? '',
      'item_count' => $deliveryItemCount,
      'item_summary' => $itemSummary,
      'isGuestView' => $isGuestView
    ], JSON_UNESCAPED_UNICODE); ?>;
  </script>
  <script src="assets/js/deliveryMap.js?v=<?php echo time(); ?>"></script>
<?php if ($isEmbed) {
    echo '</body></html>';
} else {
    include 'footer.php';
} ?>
