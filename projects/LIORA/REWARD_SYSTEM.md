# 🎁 Reward Points System Documentation

## Overview
The LIORA Reward Points System allows customers to earn points on every purchase and redeem them for discounts and exclusive rewards. Points accumulate over time and are instantly reflected in the user's account.

---

## 💰 Reward System Rules

### Points Earning
- **$50 spent = 25 points**
- Points are awarded automatically after a successful purchase for every full $50 block.
- Subtotal amount (before discounts) is used for point calculation.
- Points are immediately added to the user's account once the order is marked as paid.

### Points Redemption
- **100 points = $5 discount**
- **Minimum threshold**: You must have at least **100 points** to start redeeming for payments.
- **250 points = $12.50 discount** (or "Reward Points Full" for specific tiers).
- Users can redeem points during checkout only if they have reached the 100-point milestone.
- Discount cannot exceed the order subtotal.

---

## 🏆 Reward Tiers

### Tier System
Users progress through reward tiers as they accumulate points:

1. **🌱 Sprout** (0-99 points)
   - Entry level
   - Progress to: 100 points

2. **🌸 Bloom** (100-249 points)
   - Unlock €5 discount reward
   - Progress to: 250 points

3. **🌺 Blossom** (250-499 points)
   - Unlock 10% discount reward
   - Progress to: 500 points

4. **👑 Legend** (500+ points)
   - Unlock free product rewards
   - Exclusive VIP benefits

Each tier shows a progress bar indicating advancement to the next reward level.

---

## 🛒 Using Reward Points at Checkout

### Step-by-Step Guide

1. **Add Items to Cart**
   - Browse and add desired products to your cart

2. **Proceed to Checkout**
   - Click "Checkout" in your cart

3. **View Available Points**
   - In the "Redeem Reward Points" section, you'll see:
     - Your total accumulated points
     - Quick reward buttons (if eligible)

4. **Redeem Points (Optional)**
   - Enter the number of points to redeem
   - Click "Apply" to see the discount
   - System shows the resulting discount amount
   - The discount is automatically capped to not exceed the order total

5. **Place Order**
   - Complete your billing details
   - Select payment method
   - Click "Place Order"
   - Earned points are added, redeemed points are deducted

---

## 📊 Manage Your Rewards (My Account)

### Access Rewards Section
1. Login to your account
2. Click "My Account"
3. Select "Reward Points" tab

### Rewards Dashboard Shows:
- **Total Points Display**: Large numeric value showing all accumulated points
- **Tier Information**: Current level with progress indicator to next tier
- **Available Rewards**: Cards showing all redemption options with:
  - Points required
  - Reward description
  - Redemption button (enabled if you have enough points)

### Reward Cards
Each reward card displays:
- 💰 **€5 Discount** (100 points)
- 🎁 **10% Discount** (250 points)
- 🌷 **Free Premium Bouquet** (500 points)

---

## 🔧 Technical Implementation

### Database Schema

#### reward_points Table
```sql
CREATE TABLE reward_points (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    points INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_reward_points_user (user_id)
) ENGINE=InnoDB;
```

#### users Table (Extended)
```sql
ALTER TABLE users ADD COLUMN loyalty_points INT UNSIGNED DEFAULT 0;
```

### Key Files

#### Backend
- **reward_helper.php**: Core reward functions
  - `getUserRewardPoints()`: Get total points for user
  - `calculatePointsFromAmount()`: Calculate points from purchase
  - `calculateDiscountFromPoints()`: Calculate discount value
  - `awardPointsForPurchase()`: Add points for purchase
  - `deductPointsFromUser()`: Remove points for redemption
  - `getRewardTier()`: Get current tier info
  - `getRewardOptions()`: Get available rewards
  - `redeemReward()`: Process reward redemption

- **checkout_action.php**: Updated with reward system
  - `checkout` action: Awards and redeems points
  - `get_points` action: Returns points, tier, and rewards data

- **accounts_action.php**: Extended with reward handling
  - `redeem_reward` action: Processes reward redemption from accounts page

#### Frontend
- **checkout.php**: Checkout form with reward redemption section
- **accounts.php**: Enhanced reward points display and management
- **assets/js/checkout.js**: Reward points UI and calculation logic
- **assets/js/account.js**: Tab switching and profile management

---

## 📱 User Experience Features

### Real-Time Calculations
- Points total updates immediately after checkout
- Discount preview as you enter points
- Max points validation prevents over-redemption

### Visual Feedback
- Color-coded reward cards (active/locked)
- Progress bars showing tier advancement
- Success/error messages for redemptions
- Quick-select buttons for recommended rewards

### Accessibility
- ONLY numeric value shown in rewards display
- Clear tier system with emojis
- Mobile-responsive design
- Intuitive UI with tooltips

---

## 🚀 Example Scenarios

### Scenario 1: New Customer Earns Points
1. Jane registers and places first order for $120
2. System awards 50 points ($50 x 2 = $100, 25 x 2 = 50 pts)
3. Jane's tier: 🌱 Sprout (50/100 points)
4. Jane cannot spend points yet as she hasn't hit the 100-point threshold.

### Scenario 2: Customer Redeems First Reward
1. Jane has accumulated 125 points
2. She's eligible for $6.25 discount (125 points x $0.05) or can use 100 points for $5.
3. At checkout, Jane enters 100 in redemption field
4. System applies $5 discount
5. Jane now has 25 points left, moves toward next reward

### Scenario 3: VIP Customer Gets Free Product
1. Marco has 550 points (👑 Legend tier)
2. He wants to claim free premium bouquet (500 points)
3. Goes to My Account → Reward Points
4. Clicks "Free Premium Bouquet" redeem button
5. Confirms redemption
6. 500 points deducted, reward processed
7. Marco has 50 points left

---

## ✅ Verification Checklist

- [x] Points calculate correctly (1€ = 1 point)
- [x] Points display as numeric value only in My Account
- [x] Rewards update immediately after checkout
- [x] Users can redeem points during checkout
- [x] My Account shows current points and tier
- [x] Redemption interface is intuitive
- [x] Discount calculations are accurate
- [x] Points cannot be redeemed beyond user balance
- [x] Transactions are atomic (all-or-nothing)
- [x] Mobile-responsive design

---

## 🐛 Troubleshooting

### Points Not Showing
- Verify user is logged in
- Check `reward_points` table has entries for user
- Clear browser cache and refresh

### Redemption Not Working
- Verify user has sufficient points
- Check reward_helper.php is included
- Check database connection

### Discount Not Applied
- Verify points input is numeric
- Check discount doesn't exceed subtotal
- Verify checkout_action.php has reward logic

---

## 📝 Future Enhancements

Potential features for future versions:
- Point expiration policies
- Seasonal bonus point events
- Tiered level-up bonuses
- Social sharing for points
- Birthday bonus points
- Referral points system
- Point transfer between accounts
- Points history/transaction log

---

## Support
For issues or questions about the reward system, contact support@liora.com

**Last Updated**: May 2, 2026
