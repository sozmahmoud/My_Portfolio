<?php
/**
 * REWARD POINTS SYSTEM HELPER
 * Manages all reward points calculations and operations
 */

/**
 * Get total reward points for a user
 * @param mysqli $conn Database connection
 * @param int $userId User ID
 * @return int Total accumulated points
 */
function getUserRewardPoints($conn, $userId) {
    $stmt = $conn->prepare('SELECT COALESCE(SUM(points), 0) AS total FROM reward_points WHERE user_id = ?');
    if (!$stmt) {
        return 0;
    }

    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    return max(0, intval($row['total'] ?? 0));
}

/**
 * Calculate points earned from purchase amount
 * Rule: 25 points for every full $50 spent
 * @param float $amount Purchase amount in dollars
 * @return int Points earned
 */
function calculatePointsFromAmount($amount) {
    // Proportional rule: 1 point for every $2 spent (0.5 points per dollar)
    // Example: $50 = 25 points, $69 = 34.5 -> 34 points
    return max(0, (int) floor(floatval($amount) * 0.5));
}

/**
  * Calculate discount from reward points
  * Rule: 100 points = $5 discount (1 point = $0.05)
  * Note: Minimum 100 points required to start redeeming
  * @param int $points Points to redeem
  * @param int $totalUserPoints Total points the user currently has
  * @return float Discount amount in dollars
 */
function calculateDiscountFromPoints($points, $totalUserPoints = 0) {
    if ($totalUserPoints < 100 && $points > 0) {
        return 0.0;
    }
    return floatval(max(0, $points * 0.05));
}

/**
 * Award points to user for a purchase
 * @param mysqli $conn Database connection
 * @param int $userId User ID
 * @param float $amount Purchase amount in dollars
 * @return bool Success status
 */
function awardPointsForPurchase($conn, $userId, $amount) {
    $points = calculatePointsFromAmount($amount);
    if ($points <= 0) {
        return true; // No points to add, but not an error
    }
    
    $stmt = $conn->prepare('INSERT INTO reward_points (user_id, points) VALUES (?, ?)');
    if (!$stmt) {
        return false;
    }
    $stmt->bind_param('ii', $userId, $points);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

/**
 * Deduct points from user (for redemption)
 * @param mysqli $conn Database connection
 * @param int $userId User ID
 * @param int $points Points to deduct
 * @param string $reason Reason for deduction (e.g., 'checkout_redemption')
 * @return bool Success status
 */
function deductPointsFromUser($conn, $userId, $points, $reason = 'redemption') {
    if ($points <= 0) {
        return true; // No points to deduct
    }
    
    // Check if user has enough points
    $userPoints = getUserRewardPoints($conn, $userId);
    if ($userPoints < $points) {
        return false; // Insufficient points
    }

    // Rule: Cannot spend points before hitting 100 points
    if ($userPoints < 100) {
        return false; 
    }
    
    $negativePoints = -$points;
    $stmt = $conn->prepare('INSERT INTO reward_points (user_id, points) VALUES (?, ?)');
    if (!$stmt) {
        return false;
    }
    $stmt->bind_param('ii', $userId, $negativePoints);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

/**
 * Check if user can pay full with points
 * @param int $points User points
 * @return bool
 */
function canPayFullWithPoints($points) {
    return $points >= 250;
}

/**
 * Check if user can pay half with points
 * @param int $points User points
 * @return bool
 */
function canPayHalfWithPoints($points) {
    return $points >= 100;
}

/**
 * Deduct points for full payment redemption
 * @param mysqli $conn Database connection
 * @param int $userId User ID
 * @return bool Success status
 */
function deductForFullPayment($conn, $userId) {
    return deductPointsFromUser($conn, $userId, 250, 'full_payment_redemption');
}

/**
 * Deduct points for half payment redemption
 * @param mysqli $conn Database connection
 * @param int $userId User ID
 * @return bool Success status
 */
function deductForHalfPayment($conn, $userId) {
    return deductPointsFromUser($conn, $userId, 100, 'half_payment_redemption');
}

/**
 * Get reward tier information based on points
 * @param int $points Current user points
 * @return array Tier information
 */
function getRewardTier($points) {
    if ($points < 100) {
        return [
            'name' => 'Sprout',
            'icon' => '🌱',
            'nextReward' => 100,
            'nextBenefit' => '$5 Discount',
            'progress' => ($points / 100) * 100
        ];
    } elseif ($points < 250) {
        return [
            'name' => 'Bloom',
            'icon' => '🌸',
            'nextReward' => 250,
            'nextBenefit' => '10% Discount',
            'progress' => (($points - 100) / 150) * 100
        ];
    } elseif ($points < 500) {
        return [
            'name' => 'Blossom',
            'icon' => '🌺',
            'nextReward' => 500,
            'nextBenefit' => 'Free Product',
            'progress' => (($points - 250) / 250) * 100
        ];
    } else {
        return [
            'name' => 'Legend',
            'icon' => '👑',
            'nextReward' => 1000,
            'nextBenefit' => 'VIP Benefits',
            'progress' => min(100, (($points - 500) / 500) * 100)
        ];
    }
}

/**
 * Get all available reward options
 * @return array Array of reward redemption options
 */
function getRewardOptions() {
    return [
        [
            'id' => 'discount_5',
            'points' => 100,
            'title' => '$5 Discount',
            'description' => 'Get $5 off your next order',
            'icon' => '💰',
            'badge' => 'Popular'
        ],
        [
            'id' => 'discount_10pct',
            'points' => 250,
            'title' => '10% Discount',
            'description' => 'Get 10% off your entire order',
            'icon' => '🎁',
            'badge' => 'Best Value'
        ],
        [
            'id' => 'free_product',
            'points' => 500,
            'title' => 'Free Premium Bouquet',
            'description' => 'Claim a free bouquet worth up to $25',
            'icon' => '🌷',
            'badge' => 'Exclusive'
        ]
    ];
}

/**
 * Validate and redeem reward option
 * @param mysqli $conn Database connection
 * @param int $userId User ID
 * @param string $rewardId Reward option ID
 * @return array Result with 'success', 'message', and 'discount' or 'reward_applied'
 */
function redeemReward($conn, $userId, $rewardId) {
    $options = getRewardOptions();
    $selectedReward = null;
    
    foreach ($options as $option) {
        if ($option['id'] === $rewardId) {
            $selectedReward = $option;
            break;
        }
    }
    
    if (!$selectedReward) {
        return [
            'success' => false,
            'message' => 'Invalid reward option'
        ];
    }
    
    $userPoints = getUserRewardPoints($conn, $userId);
    if ($userPoints < $selectedReward['points']) {
        return [
            'success' => false,
            'message' => 'Insufficient points. You need ' . ($selectedReward['points'] - $userPoints) . ' more points.'
        ];
    }
    
    // Deduct the points
    if (!deductPointsFromUser($conn, $userId, $selectedReward['points'])) {
        return [
            'success' => false,
            'message' => 'Failed to process redemption. Please try again.'
        ];
    }
    
    return [
        'success' => true,
        'message' => 'Reward redeemed successfully!',
        'reward_id' => $rewardId,
        'reward_title' => $selectedReward['title'],
        'points_spent' => $selectedReward['points']
    ];
}
?>
