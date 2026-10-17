# 🌸 LIORA Authentication System - Setup Guide

## ✅ What Has Been Implemented

### 1. **Backend Authentication System**
- ✅ `auth_handler.php` - Handles login, register, and logout
- ✅ `protect.php` - Simple protection to check if user is logged in
- ✅ Password hashing using PHP's `password_hash()` and `password_verify()`
- ✅ Session-based user tracking with `$_SESSION['user_id']`

### 2. **Frontend Login/Register Page**
- ✅ Updated `login-register.php` with backend integration
- ✅ Updated `login-register.js` - Now sends data to backend instead of localStorage
- ✅ Form validation (email, password length, matching passwords)
- ✅ Success/error messages displayed to users

### 3. **User-Specific Features**
- ✅ **Cart System** - User cart stored in `cart_items` database table with user_id
- ✅ **Wishlist System** - User wishlist stored in `wishlist_items` database table with user_id
- ✅ **Cart JS** - `cart.js` already has user_id support
- ✅ **Wishlist JS** - Updated `wishlist.js` with `wishlist_action.php` API
- ✅ **Checkout** - Only logged-in users can checkout (protected)
- ✅ **Account Page** - Shows user's orders and profile (protected)

### 4. **Header Updates**
- ✅ Shows "Log In / Sign Up" for non-logged-in users
- ✅ Shows user's name and "Logout" button for logged-in users
- ✅ Added logout functionality

### 5. **Page Protection**
- ✅ `cart.php` - Shows login message if not logged in
- ✅ `wishlist.php` - Shows login message if not logged in  
- ✅ `checkout.php` - Shows login message if not logged in
- ✅ `accounts.php` - Shows login message if not logged in

## 📋 Files Created

1. **auth_handler.php** - Authentication backend
2. **protect.php** - Protection helper (for future use)
3. **wishlist_action.php** - Wishlist API with user_id support

## 📝 Files Modified

1. **login-register.php** - Updated with backend integration
2. **login-register.js** - Updated to use auth_handler.php
3. **header.php** - Added user info display and logout button
4. **cart.php** - Added login check
5. **wishlist.php** - Added login check + updated wishlist.js call
6. **checkout.php** - Added login check
7. **accounts.php** - Added login check + user data from database
8. **wishlist.js** - Complete rewrite to use wishlist_action.php API

## 🗄️ Database Requirements

The schema.sql already has all required tables:

```sql
-- Users table (for storing registration/login)
CREATE TABLE users (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    username        VARCHAR(100) UNIQUE NOT NULL,
    first_name      VARCHAR(100) NOT NULL,
    last_name       VARCHAR(100) NOT NULL,
    email           VARCHAR(255) UNIQUE NOT NULL,
    password_hash   VARCHAR(255) NOT NULL,
    role            ENUM('customer', 'admin') DEFAULT 'customer' NOT NULL,
    loyalty_points  INT UNSIGNED DEFAULT 0,
    is_active       BOOLEAN DEFAULT TRUE,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Cart items table (stores user cart with user_id)
CREATE TABLE cart_items (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    user_id      INT NOT NULL,
    product_id   INT NOT NULL,
    quantity     INT UNSIGNED NOT NULL DEFAULT 1,
    added_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_cart (user_id, product_id)
);

-- Wishlist items table (stores user wishlist with user_id)
CREATE TABLE wishlist_items (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    user_id      INT NOT NULL,
    product_id   INT NOT NULL,
    added_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_wishlist (user_id, product_id)
);

-- Orders table (for checkout)
CREATE TABLE orders (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    user_id         INT NOT NULL,
    order_number    VARCHAR(50) UNIQUE NOT NULL,
    status          ENUM('pending', 'paid', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    subtotal        DECIMAL(10,2) NOT NULL CHECK (subtotal >= 0),
    shipping_cost   DECIMAL(10,2) DEFAULT 0.00 CHECK (shipping_cost >= 0),
    total           DECIMAL(10,2) NOT NULL CHECK (total >= 0),
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Order items table (items in each order)
CREATE TABLE order_items (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    order_id     INT NOT NULL,
    product_id   INT NOT NULL,
    quantity     INT UNSIGNED NOT NULL,
    unit_price   DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);
```

## 🚀 How It Works (User Journey)

### 1. **Registration**
- User goes to `login-register.php`
- Fills in: Username, Email, Password, Confirm Password
- Backend validates and hashes password
- User stored in `users` table
- Success message shown

### 2. **Login**
- User enters Email and Password
- Backend verifies credentials
- Session created with: `user_id`, `username`, `email`, `first_name`
- User redirected to home page
- Header now shows: "Welcome, [First Name]! 🌸"

### 3. **Using Cart**
- When user adds to cart → saved to `cart_items` table with their `user_id`
- Cart persists across sessions
- Only shows their own items

### 4. **Using Wishlist**
- When user adds to wishlist → saved to `wishlist_items` table with their `user_id`
- Wishlist persists across sessions
- Only shows their own items

### 5. **Checkout**
- Protected page - redirects to login if not logged in
- Shows user's cart items
- Creates order in `orders` table
- Clears cart after checkout

### 6. **Account Page**
- Protected page - redirects to login if not logged in
- Shows user's profile with name and email
- Shows user's past orders
- Can edit profile, change password, etc.

### 7. **Logout**
- User clicks "Logout" button in header
- Session destroyed
- Redirected to home page
- Header shows "Log In / Sign Up" again

## 🔧 What You Need to Do in Localhost

### Step 1: Update Database ⚠️
Run the **entire schema.sql** file in your MySQL (phpMyAdmin):

1. Open phpMyAdmin
2. Go to `liora_db` database
3. Click "Import"
4. Select `schema.sql` from your project folder
5. Click "Go"

**This will ensure all tables exist with proper structure.**

### Step 2: Test Registration
1. Go to `http://localhost/LIORA/login-register.php`
2. Fill in the registration form
3. Click "Register 🌼"
4. You should see success message ✅

### Step 3: Test Login
1. On same page, fill in the login form with your email and password
2. Click "Login 💖"
3. You should be redirected to home page
4. Header should show your name ✅

### Step 4: Test Cart
1. Go to `flower.php`
2. Add items to cart
3. Go to `cart.php`
4. You should see your items (not login message) ✅

### Step 5: Test Wishlist
1. Go to `flower.php`
2. Click heart icon to add to wishlist
3. Go to `wishlist.php`
4. You should see your items ✅

### Step 6: Test Checkout
1. Go to `cart.php`
2. Click "Proceed To Checkout"
3. See your items and place order ✅

### Step 7: Test Logout
1. Click your name in top right
2. Click "Logout"
3. You should be back on home page
4. Header should show "Log In / Sign Up" again ✅

## 🔒 Security Features

✅ Passwords are hashed using PHP's `password_hash()` (bcrypt)
✅ Sessions prevent unauthorized access
✅ SQL prepared statements prevent injection
✅ User data is validated before processing
✅ Protected pages redirect to login automatically

## 🎯 Key Points

- **No localStorage** - Data is saved in database, not browser
- **Session-based** - User session lasts for browser session
- **Product IDs** - Still using static product IDs (as requested)
- **Style preserved** - All existing CSS/design unchanged
- **Same structure** - Same folder structure and file naming

## 📱 Testing Accounts

After setup, you can test with:
- Email: `test@example.com`
- Password: `password123`

(Create these during registration testing)

## 🛠️ Troubleshooting

### Issue: "Database connection failed"
- Check `config.php` has correct credentials
- If your MySQL user/password or database name differs, copy `config.local.php.example` to `config.local.php` and update it
- Or set environment variables: `LIORA_DB_HOST`, `LIORA_DB_USER`, `LIORA_DB_PASS`, `LIORA_DB_NAME`
- Check MySQL is running
- Check database name is `liora_db`

### Issue: "Email already exists"
- That email is already registered
- Use different email for testing
- Or delete user from database manually

### Issue: Cart not saving
- Make sure you're logged in
- Check browser cookies are enabled
- Check `cart_items` table exists

### Issue: Can't add to wishlist
- Make sure you're logged in
- Check `wishlist_items` table exists

## 📞 Support

All authentication is now tied to:
- `users` table for storing user data
- Session management for authentication
- Individual tables for each user's data (cart, wishlist, orders)

**No changes were made to your design or style!**

---

**Created: May 1, 2026**
**Version: 1.0 - Authentication System**
