<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// header.php

$reminderData = null;
if (!empty($_SESSION['user_id'])) {
  require_once 'config.php';
  $userId = intval($_SESSION['user_id']);
  $today = new DateTime('today');
  $maxDate = (clone $today)->modify('+3 days');

  $stmt = $conn->prepare("
    SELECT event_name, event_date, occasion_type
    FROM user_special_dates
    WHERE user_id = ?
      AND event_date BETWEEN ? AND ?
    ORDER BY event_date ASC
    LIMIT 1
  ");
  if ($stmt) {
    $startDate = $today->format('Y-m-d');
    $endDate = $maxDate->format('Y-m-d');
    $stmt->bind_param('iss', $userId, $startDate, $endDate);
    $stmt->execute();
    $stmt->bind_result($eventName, $eventDate, $occasionType);

    if ($stmt->fetch()) {
      $eventDt = new DateTime($eventDate);
      $days = (int)$today->diff($eventDt)->format('%a');
      if ($days >= 0 && $days <= 3) {
        $dayText = $days === 0 ? 'today 🎉' : ($days === 1 ? 'tomorrow 💕' : "in {$days} days ✨");
        
        $fullEventName = $eventName;
        if (!empty($occasionType) && strtolower($occasionType) !== 'special moment' && strtolower($occasionType) !== 'other') {
          // If event name doesn't already contain occasion type, add it
          if (stripos($eventName, $occasionType) === false) {
            $fullEventName = $eventName . "'s " . $occasionType;
          }
        }

        $reminderData = array(
          'event' => htmlspecialchars($fullEventName, ENT_QUOTES, 'UTF-8'),
          'dayText' => $dayText,
          'days' => $days
        );
      }
    }
    $stmt->close();
  }
}
?>

<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!--=============== FLATICON ===============-->
  <link rel="stylesheet"
    href="https://cdn-uicons.flaticon.com/2.0.0/uicons-regular-straight/css/uicons-regular-straight.css" />
  <!--=============== SWIPER CSS ===============-->
  <link rel="stylesheet" href="assets/css/swiper.css">
  <!--=============== SEARCH CSS ===============-->
  <link rel="stylesheet" href="assets/css/search.css">
  <!--=============== CSS ===============-->
  <link rel="stylesheet" href="assets/css/styles.css?v=<?php echo filemtime(__DIR__ . '/assets/css/styles.css'); ?>" />
  <?php if (!empty($pageStyles) && is_array($pageStyles)): ?>
    <?php foreach ($pageStyles as $style): ?>
      <link rel="stylesheet" href="<?php echo htmlspecialchars($style, ENT_QUOTES, 'UTF-8'); ?>" />
    <?php endforeach; ?>
  <?php endif; ?>
  <?php if (!empty($pageHeadScripts) && is_array($pageHeadScripts)): ?>
    <?php foreach ($pageHeadScripts as $scriptSrc): ?>
      <script src="<?php echo htmlspecialchars($scriptSrc, ENT_QUOTES, 'UTF-8'); ?>"></script>
    <?php endforeach; ?>
  <?php endif; ?>
</head>

<body<?php echo !empty($bodyClass) ? ' class="'.htmlspecialchars($bodyClass, ENT_QUOTES, 'UTF-8').'"' : ''; ?>>
  <script>
    window.isLoggedIn = <?php echo !empty($_SESSION['user_id']) ? 'true' : 'false'; ?>;
    window.lioraUserId = <?php echo !empty($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 'null'; ?>;
  </script>
  <!--=============== HEADER ===============-->
  <!--=============== HEADER ===============-->
  <header class="header">
    <div class="header__top">
      <div class="header__container container">
        <div class="header__contact">
          <span>Fresh flowers for every special moment 🌷</span>
        </div>

        <?php if (empty($_SESSION['user_id'])): ?>
        <a href="login-register.php" class="header__top-action">
          Log In / Sign Up
        </a>
        <?php else: ?>
        <div class="header__user-info">
          <?php if(isset($_SESSION['email']) && function_exists('liora_is_admin_email') && liora_is_admin_email($_SESSION['email'])): ?>
          <a href="admin.php" class="admin-top-link" style="color: #c14e8f; font-weight: 700; text-decoration: none; margin-right: 15px;">Dashboard 👑</a>
          <?php endif; ?>
          <span class="user-greeting">Welcome, <?php echo htmlspecialchars($_SESSION['first_name'] ?? $_SESSION['username'] ?? 'User'); ?>! 🌸</span>
          <div class="user-actions-dropdown">
            <a href="accounts.php" class="user-action-link">My Account</a>
            <a href="javascript:void(0)" class="user-action-link" onclick="logout()">Logout</a>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <nav class="nav container">
      <div class="nav__menu" id="nav-menu">

        <ul class="nav__list custom-nav">

          <li class="nav__item brand-item">
            <a href="index.php" class="nav__link brand-logo">
              <img src="assets/img/liora_logo.svg" alt="Liora Logo" class="nav__logo-img">
            </a>
          </li>

          <li class="nav__item">
            <a href="flower.php" class="nav__link active-link">Flowers</a>
          </li>

          <li class="nav__item">
            <a href="mother.php" class="nav__link">Mother’s Day</a>
          </li>
          <li class="nav__item">
            <a href="birthday.php" class="nav__link">Birthday</a>
          </li>

       <li class="nav__item search-center">
  <div class="header__search custom-search">
    <input type="text" placeholder="Search flowers..." class="form__input search-input" />
    <button class="search__btn">
      <img src="assets/img/search.svg" alt="search icon" />
    </button>

    <div id="search-history" class="search-history-box"></div>
  </div>
</li>

          <li class="nav__item">
            <a href="newyear.php" class="nav__link">New Year</a>
          </li>

          <li class="nav__item">
            <a href="valentine.php" class="nav__link">Valentine</a>
          </li>
          <li class="nav__item">
            <a href="occasions.php" class="nav__link">Occasions</a>
          </li>
        </ul>
      </div>

      <div class="header__user-actions">

        <a href="wishlist.php" class="header__action-btn" title="Wishlist">
          <img src="assets/img/heart-pink.svg" alt="Wishlist" />
          <span class="count" id="wishlist-count" style="display:none;">0</span>
        </a>

        <a href="cart.php" class="header__action-btn" title="Cart">
          <img src="assets/img/cart-pink.svg" alt="Cart" />
          <span class="count" id="cart-count" style="display:none;">0</span>
        </a>

        <a href="chatbot.php" class="header__action-btn" title="AI Assistant">
          <img src="assets/img/robot-pink.svg" alt="AI Assistant" class="robot-icon" />
        </a>

              <!-- Cute Menu Dropdown -->
        <div class="user-menu-container">
          <a href="javascript:void(0)" class="header__action-btn user-menu-btn" title="My Liora Menu">
            <img src="assets/img/menu-pink.svg" alt="Menu" />
          </a>

          <!-- Beautiful dropdown list -->
          <div class="user-dropdown">
            <ul>
              <?php if(isset($_SESSION['email']) && function_exists('liora_is_admin_email') && liora_is_admin_email($_SESSION['email'])): ?>
              <li><a href="admin.php" style="color: var(--primary-color); font-weight: 700; border-bottom: 2px solid var(--accent-color); margin-bottom: 5px;">👑 Admin Dashboard</a></li>
              <?php endif; ?>
              <li><a href="login-register.php">🌸 Log In / Sign Up</a></li>
              <li><a href="accounts.php">👤 My Account</a></li>
              <li><a href="calendar.php">📅 Calendar</a></li>
              <li><a href="deliveryMap.php">📍 Locate My Delivery</a></li>
              <li><a href="accounts.php?tab=reward-points">🎁 Flower Points & Rewards</a></li>
              <li><a href="wishlist.php">❤️ My Wishlist</a></li>
              <li><a href="cart.php">🛒 My Cart</a></li>
              <li class="divider"></li>
              <li><a href="flower.php">🌷 Browse All Flowers</a></li>
              <li><a href="occasions.php">🎉 Special Occasions</a></li>
              <li><a href="contact.php">☎ Contact & Support</a></li>
            </ul>
          </div>
        </div>

      </div>
    </nav>
  </header>

  <!-- Date Reminder Notification -->

  <?php if ($reminderData): ?>
  <div style="
    width: 100%;
    background: linear-gradient(135deg, #fff5f7 0%, #ffe8f0 100%);
    border-bottom: 3px solid #ff69b4;
    padding: 1.2rem 1rem;
    box-sizing: border-box;
    box-shadow: 0 4px 12px rgba(255, 105, 180, 0.15);
  ">
    <div style="max-width: 1200px; margin: 0 auto; display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
      <span style="font-size: 1.8rem; line-height: 1;">
        <?php echo $reminderData['days'] === 0 ? '🎉' : ($reminderData['days'] === 1 ? '💕' : '✨'); ?>
      </span>
      <div style="flex: 1; min-width: 250px;">
        <p style="margin: 0; font-size: 0.95rem; color: #666; font-weight: 500;">Reminder</p>
        <p style="margin: 0.3rem 0 0 0; font-size: 1.05rem; color: #d81b60; font-weight: 600;">
          <?php echo $reminderData['event']; ?> is <?php echo $reminderData['dayText']; ?>
        </p>
      </div>
      <button onclick="this.parentElement.parentElement.style.display='none';" style="
        background: white;
        border: 1px solid #ffb6d9;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        cursor: pointer;
        font-size: 1.2rem;
        color: #d81b60;
        transition: all 0.2s;
        flex-shrink: 0;
      " onmouseover="this.style.background='#fff0f5'; this.style.transform='scale(1.1)';" onmouseout="this.style.background='white'; this.style.transform='scale(1)';">
        ✕
      </button>
    </div>
  </div>
  <?php endif; ?>

  <script>
  // Logout function
  async function logout() {
    const formData = new FormData();
    formData.append("action", "logout");

    try {
      const response = await fetch("auth_handler.php", {
        method: "POST",
        body: formData,
        credentials: "same-origin"
      });

      const data = await response.json();
      if (data.success) {
        localStorage.removeItem("lioraUser");
        // Redirect to home page after logout
        window.location.href = "index.php";
      }
    } catch (error) {
      console.error("Logout error:", error);
      window.location.href = "index.php";
    }
  }
  </script>
