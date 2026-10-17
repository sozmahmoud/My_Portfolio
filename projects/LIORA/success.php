<?php
session_start();
include 'config.php';
include 'reward_helper.php';
include 'header.php';

$orderNumber = $_GET['order_number'] ?? '';
$orderId = $_GET['id'] ?? '';

if (!$orderNumber) {
    header('Location: index.php');
    exit;
}

// Fetch order details to show summary
$stmt = $conn->prepare("SELECT * FROM orders WHERE order_number = ?");
$stmt->bind_param("s", $orderNumber);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
$stmt->close();

$pointsEarned = 0;
$currentPoints = 0;
if ($order && !empty($order['user_id'])) {
    $pointsEarned = calculatePointsFromAmount(floatval($order['total'] ?? 0));
    $currentPoints = getUserRewardPoints($conn, intval($order['user_id']));
}
?>

<main class="main">
    <section class="success section">
        <div class="success__container container">
            <div class="success__content">
                <div class="success__icon-wrapper">
                    <span class="success__icon pulse">✅</span>
                </div>
                <h1 class="success__title">Payment Successful!</h1>
                <p class="success__message">Thank you for your order, <strong><?php echo htmlspecialchars($order['customer_name'] ?? 'dear'); ?></strong>! 🌸</p>
                <p>after 1 hours your bouquet will be ready for delivery</p>
                <div class="success__order-info">
                    <p>Order Number: <span class="order-id">#<?php echo htmlspecialchars($orderNumber); ?></span></p>
                    <p>Status: <span class="badge badge--success">Processing</span></p>
                    <p>Points Earned: <span class="order-id">+<?php echo intval($pointsEarned); ?></span></p>
                    <p>Current Points: <span class="order-id"><?php echo intval($currentPoints); ?></span></p>
                </div>
                <p>We've sent a confirmation email to <strong><?php echo htmlspecialchars($order['customer_email'] ?? ''); ?></strong>.</p>
                
                <div class="success__actions">
                    <a href="accounts.php?tab=orders&refresh=1" class="btn btn--md">View My Orders</a>
                    <a href="accounts.php?tab=reward-points&refresh=1" class="btn btn--md btn--secondary">View Reward Points</a>
                    <a href="deliveryMap.php?order_id=<?php echo intval($orderId); ?>" class="btn btn--md btn--secondary">Locate Delivery</a>
                    <a href="index.php" class="btn btn--md btn--secondary">Continue Shopping</a>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
.success {
    padding-top: 8rem;
    padding-bottom: 4rem;
    text-align: center;
}
.success__container {
    display: flex;
    justify-content: center;
    align-items: center;
}
.success__content {
    max-width: 600px;
    width: 100%;
}
.success__icon-wrapper {
    font-size: 5rem;
    margin-bottom: 1.5rem;
}
.success__title {
    font-size: var(--h1-font-size);
    color: var(--first-color);
    margin-bottom: 1rem;
}
.success__message {
    font-size: 1.2rem;
    margin-bottom: 2rem;
}
.success__order-info {
    background: #fff5f8;
    padding: 1.5rem;
    border-radius: 15px;
    margin-bottom: 2rem;
    display: inline-block;
    text-align: left;
}
.order-id {
    font-weight: 700;
    color: var(--first-color);
}
.badge--success {
    background: #d4edda;
    color: #155724;
    padding: 0.3rem 0.8rem;
    border-radius: 50px;
    font-size: 0.9rem;
}
.success__actions {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 1rem;
    margin-top: 2rem;
}

@media screen and (max-width: 768px) {
    .success__actions {
        flex-direction: column;
    }
}


    /* Animations */
    .pulse {
        display: inline-block;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    /* Falling Petals Animation */
    .petals-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 9999;
        overflow: hidden;
    }

    .petal {
        position: absolute;
        background: #ffb6d9;
        border-radius: 150% 0 150% 0;
        opacity: 0.7;
        animation: fall linear infinite;
    }

    @keyframes fall {
        0% { transform: translateY(-10vh) rotate(0deg); opacity: 0; }
        10% { opacity: 0.7; }
        90% { opacity: 0.7; }
        100% { transform: translateY(110vh) rotate(720deg); opacity: 0; }
    }
</style>

<div class="petals-container" id="petals"></div>

<script>
function createPetals() {
    const container = document.getElementById('petals');
    const colors = ['#ffb6d9', '#ff9a9e', '#fad0c4', '#ffecd2', '#fcb69f'];
    
    for (let i = 0; i < 30; i++) {
        const petal = document.createElement('div');
        petal.className = 'petal';
        
        const size = Math.random() * 15 + 10;
        const left = Math.random() * 100;
        const duration = Math.random() * 5 + 5;
        const delay = Math.random() * 5;
        const color = colors[Math.floor(Math.random() * colors.length)];
        
        petal.style.width = size + 'px';
        petal.style.height = (size * 0.8) + 'px';
        petal.style.left = left + '%';
        petal.style.animationDuration = duration + 's';
        petal.style.animationDelay = delay + 's';
        petal.style.background = color;
        
        container.appendChild(petal);
    }
}
createPetals();
</script>

<?php include 'footer.php'; ?>
