CREATE DATABASE IF NOT EXISTS liora_db 
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE liora_db;

-- =============================================
-- 1. USERS
-- =============================================
CREATE TABLE users (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    username        VARCHAR(100) UNIQUE NOT NULL,
    first_name      VARCHAR(100) NOT NULL,
    last_name       VARCHAR(100) NOT NULL,
    email           VARCHAR(255) UNIQUE NOT NULL,
    password_hash   VARCHAR(255) NOT NULL,
    verification_token VARCHAR(255) NULL,
    role            ENUM('customer', 'admin') DEFAULT 'customer' NOT NULL,
    loyalty_points  INT UNSIGNED DEFAULT 0,
    is_active       BOOLEAN DEFAULT TRUE,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_users_email     (email),
    INDEX idx_users_verification_token (verification_token),
    INDEX idx_users_role      (role),
    INDEX idx_users_created   (created_at)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS password_reset_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    email VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL UNIQUE,
    requested_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at DATETIME DEFAULT NULL,
    sent_at TIMESTAMP NULL DEFAULT NULL,
    used_at TIMESTAMP NULL DEFAULT NULL,
    is_used BOOLEAN DEFAULT FALSE,
    ip_address VARCHAR(45) DEFAULT NULL,
    INDEX idx_password_reset_requests_user_id (user_id),
    INDEX idx_password_reset_requests_email (email),
    INDEX idx_password_reset_requests_token (token),
    CONSTRAINT fk_password_reset_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- =============================================
-- 2. PRODUCTS (static IDs 1–100+)
-- =============================================
CREATE TABLE products (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    name         VARCHAR(255) NOT NULL,
    price        DECIMAL(10,2) NOT NULL CHECK (price >= 0),
    sale_price   DECIMAL(10,2) NOT NULL DEFAULT 0.00 CHECK (sale_price >= 0),
    image_url    VARCHAR(500) NOT NULL,
    category     VARCHAR(100) NOT NULL DEFAULT 'Uncategorized',
    color        VARCHAR(100) NOT NULL DEFAULT 'Mixed',
    description  VARCHAR(1000) NOT NULL DEFAULT '',
    is_flower    BOOLEAN NOT NULL DEFAULT TRUE,
    stock        INT UNSIGNED NOT NULL DEFAULT 10,
    is_active    BOOLEAN NOT NULL DEFAULT TRUE,
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_products_category (category),
    INDEX idx_products_active   (is_active),
    INDEX idx_products_price    (price)
) ENGINE=InnoDB;

-- =============================================
-- 3. CART
-- =============================================
CREATE TABLE cart_items (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    user_id      INT NOT NULL,
    product_id   INT NOT NULL,
    quantity     INT UNSIGNED NOT NULL DEFAULT 1,
    options      TEXT NULL,
    product_type VARCHAR(100) NULL,
    variant      VARCHAR(100) NULL,
    added_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)    REFERENCES users(id)    ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,

    UNIQUE KEY unique_cart (user_id, product_id),
    INDEX idx_cart_user (user_id)
) ENGINE=InnoDB;

-- =============================================
-- 4. WISHLIST
-- =============================================
CREATE TABLE wishlist_items (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    user_id      INT NOT NULL,
    product_id   INT NOT NULL,
    options      TEXT NULL,
    product_type VARCHAR(100) NULL,
    variant      VARCHAR(100) NULL,
    added_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)    REFERENCES users(id)    ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,

    UNIQUE KEY unique_wishlist (user_id, product_id),
    INDEX idx_wishlist_user (user_id)
) ENGINE=InnoDB;

-- =============================================
-- 5. ORDERS
-- =============================================
CREATE TABLE orders (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    user_id         INT NOT NULL,
    order_number    VARCHAR(50) UNIQUE NOT NULL,
    status          ENUM('pending', 'paid', 'shipped', 'delivered', 'completed', 'cancelled') DEFAULT 'pending',
    subtotal        DECIMAL(10,2) NOT NULL CHECK (subtotal >= 0),
    shipping_cost   DECIMAL(10,2) DEFAULT 0.00 CHECK (shipping_cost >= 0),
    total           DECIMAL(10,2) NOT NULL CHECK (total >= 0),
    customer_name   VARCHAR(255) NULL,
    customer_email  VARCHAR(255) NULL,
    address         VARCHAR(255) NULL,
    city            VARCHAR(100) NULL,
    country         VARCHAR(100) NULL,
    postcode        VARCHAR(50) NULL,
    phone           VARCHAR(50) NULL,
    delivery_date   DATE NULL,
    delivery_time   TIME NULL,
    gift_message    TEXT NULL,
    order_note      TEXT NULL,
    payment_method  VARCHAR(100) NULL,
    card_name       VARCHAR(255) NULL,
    card_number     VARCHAR(50) NULL,
    paypal_email    VARCHAR(255) NULL,
    coupon_code     VARCHAR(50) NULL,
    discount        DECIMAL(10,2) DEFAULT 0.00,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,

    INDEX idx_orders_user      (user_id),
    INDEX idx_orders_status    (status),
    INDEX idx_orders_created   (created_at)
) ENGINE=InnoDB;

-- =============================================
-- 6. REWARD POINTS
-- =============================================
CREATE TABLE reward_points (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    user_id      INT NOT NULL,
    points       INT NOT NULL,
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,

    INDEX idx_reward_points_user (user_id)
) ENGINE=InnoDB;

-- =============================================
-- 7. ORDER ITEMS
-- =============================================
CREATE TABLE order_items (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    order_id     INT NOT NULL,
    product_id   INT NOT NULL,
    quantity     INT UNSIGNED NOT NULL,
    unit_price   DECIMAL(10,2) NOT NULL CHECK (unit_price >= 0),
    options      TEXT NULL,
    product_type VARCHAR(100) NULL,
    variant      VARCHAR(100) NULL,

    FOREIGN KEY (order_id)   REFERENCES orders(id)     ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id)   ON DELETE RESTRICT,

    INDEX idx_order_items_order (order_id)
) ENGINE=InnoDB;

-- =============================================
-- 7. REVIEWS (optional but recommended)
-- =============================================
CREATE TABLE reviews (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    user_id      INT NOT NULL,
    product_id   INT NOT NULL,
    rating       TINYINT UNSIGNED NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment      TEXT,
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)    REFERENCES users(id)    ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,

    UNIQUE KEY unique_review (user_id, product_id),
    INDEX idx_reviews_product (product_id)
) ENGINE=InnoDB;

-- =============================================
-- 8. USER SPECIAL DATES (Date Reminders)
-- =============================================
CREATE TABLE user_special_dates (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    user_id      INT NOT NULL,
    event_name      VARCHAR(100) NOT NULL,
    event_date      DATE NOT NULL,
    occasion_type   VARCHAR(50) DEFAULT 'Special Moment',
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,

    INDEX idx_special_dates_user (user_id),
    INDEX idx_special_dates_date (event_date)
) ENGINE=InnoDB;

-- =============================================
-- 9. USER SEARCH HISTORY
-- =============================================
CREATE TABLE user_search_history (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    user_id      INT NOT NULL,
    search_query VARCHAR(255) NOT NULL,
    timestamp    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,

    INDEX idx_search_history_user (user_id),
    INDEX idx_search_history_timestamp (timestamp),
    INDEX idx_search_history_query (search_query)
) ENGINE=InnoDB;

-- =============================================
-- 10. CHAT HISTORY
-- =============================================
CREATE TABLE chat_history (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    user_id      INT NOT NULL,
    role         ENUM('user', 'model') NOT NULL,
    message      TEXT NOT NULL,
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,

    INDEX idx_chat_history_user (user_id),
    INDEX idx_chat_history_created (created_at)
) ENGINE=InnoDB;

-- =============================================
-- 11. SUPPORT MESSAGES
-- =============================================
CREATE TABLE support_messages (
    id                INT AUTO_INCREMENT PRIMARY KEY,
    user_id           INT NULL,
    name              VARCHAR(150) NOT NULL,
    email             VARCHAR(255) NOT NULL,
    phone             VARCHAR(50) DEFAULT NULL,
    topic             VARCHAR(80) NOT NULL,
    order_number      VARCHAR(50) DEFAULT NULL,
    preferred_contact ENUM('email', 'phone') DEFAULT 'email',
    message           TEXT NOT NULL,
    status            ENUM('new', 'read', 'replied', 'closed') DEFAULT 'new',
    ip_address        VARCHAR(45) DEFAULT NULL,
    user_agent        VARCHAR(255) DEFAULT NULL,
    created_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,

    INDEX idx_support_messages_user (user_id),
    INDEX idx_support_messages_status (status),
    INDEX idx_support_messages_created (created_at)
) ENGINE=InnoDB;
