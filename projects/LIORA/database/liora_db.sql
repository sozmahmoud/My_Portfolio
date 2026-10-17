-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2026 at 12:50 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `liora_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `options` text NOT NULL DEFAULT '',
  `product_type` varchar(100) NOT NULL DEFAULT '',
  `variant` varchar(100) NOT NULL DEFAULT '',
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `user_id`, `product_id`, `quantity`, `options`, `product_type`, `variant`, `added_at`) VALUES
(79, 22, 104, 1, '', 'Gift Box', 'Mixed', '2026-05-14 21:28:59');

-- --------------------------------------------------------

--
-- Table structure for table `chat_history`
--

CREATE TABLE `chat_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` enum('user','model') NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_history`
--

INSERT INTO `chat_history` (`id`, `user_id`, `role`, `message`, `created_at`) VALUES
(31, 2, 'user', 'flowers for new year?', '2026-05-14 22:47:36'),
(32, 2, 'model', 'Happy New Year! 🎉 For New Year celebrations, bright and festive flowers are a wonderful choice. Here are some delightful recommendations:<br />\n<br />\n- <strong>White and Gold Bouquets</strong> for a classy touch<br />\n- <strong>Red Roses with Festive Wrapping</strong> to spread love and cheer<br />\n- <strong>Winter Flower Arrangements</strong> for a seasonal vibe<br />\n<br />\nI highly recommend the [PRODUCT:11] for pure elegance or the [PRODUCT:1] for a vibrant touch. You can also explore more options on our [Roses page](rose.php) and [Tulips page](tulip.php). Wishing you a joyful start to the year! 🌸✨', '2026-05-14 22:47:36'),
(33, 2, 'user', 'flower for graduation please', '2026-05-14 22:49:06'),
(34, 2, 'model', 'Congratulations on the graduation! 🎓 For this special occasion, bright and celebratory flowers are perfect. Here are some great options to consider:<br /><br />\n<br /><br />\n- <strong>Sunflowers</strong> for happiness and positivity<br /><br />\n- <strong>Blue and White Bouquets</strong> for a classic touch<br /><br />\n- <strong>Mixed Roses</strong> for a colorful celebration<br /><br />\n<br /><br />\nI highly recommend the [PRODUCT:27] for a cheerful sunflower arrangement or the [PRODUCT:2] for a vibrant mix of colors. Best wishes for your future endeavors! 🌼🎉', '2026-05-14 22:49:06'),
(35, 2, 'user', 'ok flower for anniversary', '2026-05-14 22:51:58'),
(36, 2, 'model', 'Happy Anniversary! 💖 For this special celebration, romantic and elegant flowers are the perfect choice. Here are some lovely suggestions:<br /><br /><br />\n- <strong>Red Roses</strong> to symbolize deep love<br /><br />\n- <strong>Rose Boxes</strong> for a luxurious touch<br /><br />\n- <strong>Tulip Arrangements</strong> for a unique elegance<br /><br />\n<br /><br />\nI highly recommend the [PRODUCT:4] for a classic red rose experience or the [PRODUCT:6] for a romantic blush pink bouquet. Wishing you both many more wonderful years together! 🌹✨', '2026-05-14 22:51:58'),
(37, 2, 'user', 'thank you', '2026-05-14 22:52:56'),
(38, 2, 'model', 'You\'re very welcome! 😊 If you have any more questions or need further assistance, feel free to ask. Enjoy your flower selection and have a lovely day! 🌸✨', '2026-05-14 22:52:56'),
(43, 23, 'user', 'could you give me some blue flower options please', '2026-05-21 22:11:38'),
(44, 23, 'model', 'Of course! Here are some beautiful blue flower options for you:<br />\n<br />\n1. <strong>[PRODUCT:1]</strong> - Elegant blue sapphire roses bouquet.<br />\n2. <strong>[PRODUCT:19]</strong> - Ocean blue magical lily arrangement.<br />\n3. <strong>[PRODUCT:48]</strong> - Blue daisy magic bouquet.<br />\n<br />\nThese options are stunning and perfect for any occasion! 🌊🌸 You can also see more on our [Daisies page](daisies.php) if you\'re interested in exploring further.', '2026-05-21 22:11:38');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `status` enum('pending','paid','shipped','delivered','completed','cancelled') DEFAULT 'pending',
  `subtotal` decimal(10,2) NOT NULL CHECK (`subtotal` >= 0),
  `shipping_cost` decimal(10,2) DEFAULT 0.00 CHECK (`shipping_cost` >= 0),
  `total` decimal(10,2) NOT NULL CHECK (`total` >= 0),
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `postcode` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `delivery_time` time DEFAULT NULL,
  `gift_message` text DEFAULT NULL,
  `order_note` text DEFAULT NULL,
  `payment_method` varchar(100) DEFAULT NULL,
  `card_name` varchar(255) DEFAULT NULL,
  `card_number` varchar(50) DEFAULT NULL,
  `paypal_email` varchar(255) DEFAULT NULL,
  `coupon_code` varchar(50) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_number`, `status`, `subtotal`, `shipping_cost`, `total`, `customer_name`, `customer_email`, `address`, `city`, `country`, `postcode`, `phone`, `delivery_date`, `delivery_time`, `gift_message`, `order_note`, `payment_method`, `card_name`, `card_number`, `paypal_email`, `coupon_code`, `discount`, `created_at`) VALUES
(16, 20, 'LIORA20260510125608760737', 'completed', 48.00, 10.00, 58.00, 'sara mahmood', 'sara123@gmail.com', 'Bakrajo', 'Sulaymaniyah', '', '', '08976654432', '2026-05-10', '14:57:00', 'good morning beautiful!', 'please send it carefully', 'Credit Card (Visa)', 'visa', '**** **** **** 3445', '', '', 0.00, '2026-05-10 10:56:08'),
(17, 22, 'LIORA20260514222052186629', 'completed', 70.00, 10.00, 66.00, 'sara', 'saramahmood@gmail.com', 'Twi Malik', 'Sulaymaniyah', '', '', '07508990597', '2026-05-15', '00:22:00', 'please take care of yourslf, love you', 'be careful and i ma available at 9 am to 9 pm ok', 'PayPal', '', '', '**** **** **** 8726', 'LOVE10', 14.00, '2026-05-14 20:20:52'),
(18, 2, 'LIORA20260514231442711051', 'completed', 64.00, 10.00, 67.60, 'soz', 'sozmahmoud68@gmail.com', 'Bakrajo, Sulaymaniyah', 'Sulaymaniyah', '', '', '07507778786', '2026-05-15', '01:20:00', 'good', 'good', 'Credit Card (Visa)', 'visa', '**** **** **** 8999', '', '', 6.40, '2026-05-14 21:14:42'),
(19, 22, 'LIORA20260514232306863181', 'completed', 83.00, 0.00, 66.40, 'sara', 'saramahmood@gmail.com', 'kurdsat', 'Sulaymaniyah', '', '', '07655433212', '2026-05-16', '01:22:00', 'good', 'good', 'Credit Card (Visa)', 'visa', '**** **** **** 1111', '', 'LOVE10', 16.60, '2026-05-14 21:23:06'),
(20, 22, 'LIORA20260514232534917300', 'completed', 14.00, 10.00, 22.60, 'sara', 'saramahmood@gmail.com', 'kurdsat', 'Sulaymaniyah', '', '', '07508888888', '2026-05-16', '01:25:00', 'good', 'good', 'PayPal', '', '', '**** **** **** 6666', 'LOVE10', 1.40, '2026-05-14 21:25:34'),
(21, 2, 'LIORA20260514234308163087', 'completed', 70.00, 10.00, 66.00, 'soz', 'sozmahmoud68@gmail.com', 'Bakrajo, Sulaymaniyah, Sulaymaniyah', 'Sulaymaniyah', '', '', '07500000000', '2026-05-16', '01:42:00', '', '', 'Credit Card (Visa)', 'visa', '**** **** **** 5252', '', 'LOVE10', 14.00, '2026-05-14 21:43:08'),
(22, 2, 'LIORA20260517104854419300', 'pending', 39.00, 10.00, 49.00, 'soz', 'sozmahmoud68@gmail.com', 'Bakrajo, Sulaymaniyah, Sulaymaniyah, Sulaymaniyah', 'Sulaymaniyah', '', '', '07508990597', '2026-05-17', '12:52:00', 'good', 'good', 'PayPal', '', '', '**** **** **** 8888', '', 0.00, '2026-05-17 08:48:54'),
(23, 2, 'LIORA20260517104939770648', 'pending', 40.00, 10.00, 46.00, 'soz', 'sozmahmoud68@gmail.com', 'Bakrajo, Sulaymaniyah, Sulaymaniyah, Sulaymaniyah', 'Sulaymaniyah', '', '', '07655555555', '2026-05-17', '12:55:00', '', '', 'PayPal', '', '', '**** **** **** 6666', 'LOVE10', 4.00, '2026-05-17 08:49:39'),
(24, 2, 'LIORA20260517105110919904', 'pending', 45.00, 10.00, 45.20, 'soz', 'sozmahmoud68@gmail.com', 'Bakrajo, Sulaymaniyah, Sulaymaniyah, Sulaymaniyah', 'Sulaymaniyah', '', '', '07508999059', '2026-05-17', '12:56:00', '', ' Spent 106 reward points.', 'Reward Points', '', '', '6', 'LOVE10', 9.80, '2026-05-17 08:51:10'),
(25, 23, 'LIORA20260517114028788760', 'completed', 56.00, 10.00, 54.80, 'rwanin', 'rwanin123@gmail.com', 'Bakrajo, Sulaymaniyah, Sulaymaniyah, Sulaymaniyah', 'Sulaymaniyah', '', '', '07742225252', '2026-05-19', '14:00:00', 'happy birthday', 'please deliver it with care', 'Credit Card (Visa)', 'visa', '**** **** **** 8999', '', 'LOVE10', 11.20, '2026-05-17 09:40:28'),
(26, 23, 'LIORA20260519215551237789', 'completed', 237.00, 0.00, 213.30, 'rwanin', 'rwanin123@gmail.com', 'Bakrajo, Sulaymaniyah, Sulaymaniyah, Sulaymaniyah, Sulaymaniyah', 'Sulaymaniyah', '', '', '07508990597', '2026-05-20', '00:00:00', 'happy birhday', 'please deliver it carefuly.', 'PayPal', '', '', '**** **** **** 4444', '', 23.70, '2026-05-19 19:55:51'),
(27, 23, 'LIORA20260520234559711911', 'completed', 353.00, 0.00, 317.70, 'rwanin', 'rwanin123@gmail.com', 'Bakrajo, Sulaymaniyah, Sulaymaniyah, Sulaymaniyah, Sulaymaniyah', 'Sulaymaniyah', '', '', '07564736373', '2026-05-21', '04:52:00', 'good luck', 'good', 'PayPal', '', '', '**** **** **** 1111', '', 35.30, '2026-05-20 21:45:59'),
(28, 23, 'LIORA20260522001830574089', 'pending', 289.00, 0.00, 260.10, 'rwa', 'rwanin123@gmail.com', 'Bakrajo, Sulaymaniyah, Sulaymaniyah, Sulaymaniyah, Sulaymaniyah, Sulaymaniyah', 'Sulaymaniyah', '', '', '11111111111', '2026-05-23', '14:17:00', '', '', 'PayPal', '', '11', '**** **** **** 1111', '', 28.90, '2026-05-21 22:18:30');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `unit_price` decimal(10,2) NOT NULL CHECK (`unit_price` >= 0),
  `options` text NOT NULL DEFAULT '',
  `product_type` varchar(100) NOT NULL DEFAULT '',
  `variant` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `unit_price`, `options`, `product_type`, `variant`) VALUES
(33, 16, 25, 1, 48.00, '[{\"label\":\"Product Type\",\"value\":\"گولی ئۆرکید زێڕینی هەڵاتنی خۆر\"},{\"label\":\"Wrapping Style\",\"value\":\"Golden Ribbon Wrap\"},{\"label\":\"Ribbon Color\",\"value\":\"White\"}]', 'گولی ئۆرکید زێڕینی هەڵاتنی خۆر', ''),
(34, 17, 104, 1, 28.00, '', 'Gift Box', ''),
(35, 17, 1, 1, 20.00, '[{\"label\":\"Product Type\",\"value\":\"گولی سەفیر شین\"},{\"label\":\"Wrapping Style\",\"value\":\"Classic Pink Wrap\"},{\"label\":\"Ribbon Color\",\"value\":\"Pink\"}]', 'گولی سەفیر شین', ''),
(36, 17, 88, 1, 22.00, '[{\"label\":\"Product Type\",\"value\":\"گولی لیلیی پینکی گەلاکسی\"},{\"label\":\"Wrapping Style\",\"value\":\"Classic Pink Wrap\"},{\"label\":\"Ribbon Color\",\"value\":\"Pink\"}]', 'گولی لیلیی پینکی گەلاکسی', 'Pink/Purple'),
(37, 18, 75, 1, 24.00, '', 'Roses', ''),
(38, 18, 8, 2, 20.00, '', 'Roses', ''),
(39, 19, 103, 1, 28.00, '', 'Gifts', 'Mixed'),
(40, 19, 102, 1, 27.00, '', 'Home', 'Mixed'),
(41, 19, 104, 1, 28.00, '', 'Gift Box', 'Mixed'),
(42, 20, 81, 1, 14.00, '[{\"label\":\"Product Type\",\"value\":\"Gifts\"},{\"label\":\"Wrapping Style\",\"value\":\"Sweet Gift Bag\"},{\"label\":\"Ribbon Color\",\"value\":\"Pink\"},{\"label\":\"Variant\",\"value\":\"Brown\"}]', 'Gifts', 'Brown'),
(43, 21, 103, 1, 28.00, '', 'Gifts', 'Mixed'),
(44, 21, 108, 1, 42.00, '[{\"label\":\"Wrapping Style\",\"value\":\"Classic Pink Wrap\"},{\"label\":\"Ribbon Color\",\"value\":\"Pink\"}]', 'Flowers', 'Mixed'),
(45, 22, 1, 1, 20.00, '', 'Roses', 'Blue'),
(46, 22, 11, 1, 19.00, '', 'Tulips', 'White'),
(47, 23, 8, 1, 20.00, '', 'Roses', 'Pink'),
(48, 23, 18, 1, 20.00, '', 'Lilies', 'White'),
(49, 24, 8, 1, 20.00, '', 'Roses', 'Pink'),
(50, 24, 87, 1, 25.00, '', 'Roses', 'Multi'),
(51, 25, 29, 1, 22.00, '', 'Sunflowers', 'Yellow'),
(52, 25, 50, 2, 17.00, '', 'Daisies', 'White'),
(53, 26, 29, 4, 22.00, '', 'Sunflowers', 'Yellow'),
(54, 26, 8, 1, 20.00, '', 'Roses', 'Pink'),
(55, 26, 48, 1, 26.00, '', 'Daisies', 'Blue'),
(56, 26, 25, 1, 22.00, '', 'Orchids', 'Yellow'),
(57, 26, 75, 1, 24.00, '', 'Roses', 'Red'),
(58, 26, 58, 1, 17.00, '', 'Daffodils', 'Yellow'),
(59, 26, 18, 2, 20.00, '', 'Lilies', 'White'),
(60, 27, 29, 2, 22.00, '', 'Sunflowers', 'Yellow'),
(61, 27, 75, 1, 24.00, '', 'Roses', 'Red'),
(62, 27, 96, 1, 20.00, '', 'Daisies', 'Pink'),
(63, 27, 58, 1, 17.00, '', 'Daffodils', 'Yellow'),
(64, 27, 22, 1, 28.00, '', 'Orchids', 'Pink'),
(65, 27, 52, 1, 14.00, '', 'Mini Roses', 'Pink'),
(66, 27, 89, 1, 24.00, '', 'Tulips', 'Red'),
(67, 27, 74, 1, 22.00, '', 'Gifts', 'Brown'),
(68, 27, 76, 1, 30.00, '', 'Chocolates', 'Brown'),
(69, 27, 77, 1, 22.00, '', 'Gifts', 'Pink'),
(70, 27, 83, 1, 28.00, '', 'Chocolates', 'Brown'),
(71, 27, 102, 1, 27.00, '', 'Home', 'Mixed'),
(72, 27, 101, 1, 25.00, '', 'Gifts', 'Pink'),
(73, 27, 103, 1, 28.00, '', 'Gifts', 'Mixed'),
(74, 28, 75, 1, 24.00, '', 'Roses', 'Red'),
(75, 28, 24, 1, 28.00, '', 'Orchids', 'Pink'),
(76, 28, 88, 1, 22.00, '', 'Lilies', 'Pink'),
(77, 28, 102, 1, 27.00, '', 'Home', 'Mixed'),
(78, 28, 101, 1, 25.00, '', 'Gifts', 'Pink'),
(79, 28, 84, 1, 25.00, '', 'Chocolates', 'Red'),
(80, 28, 81, 1, 14.00, '', 'Gifts', 'Brown'),
(81, 28, 104, 1, 28.00, '', 'Gift Box', 'Mixed'),
(82, 28, 76, 1, 30.00, '', 'Chocolates', 'Brown'),
(83, 28, 83, 1, 28.00, '', 'Chocolates', 'Brown'),
(84, 28, 52, 1, 14.00, '', 'Mini Roses', 'Pink'),
(85, 28, 89, 1, 24.00, '', 'Tulips', 'Red');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_requests`
--

CREATE TABLE `password_reset_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `new_password_hash` varchar(255) NOT NULL DEFAULT '',
  `requested_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expires_at` datetime DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `used_at` timestamp NULL DEFAULT NULL,
  `is_used` tinyint(1) DEFAULT 0,
  `ip_address` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_reset_requests`
--

INSERT INTO `password_reset_requests` (`id`, `user_id`, `email`, `token`, `new_password_hash`, `requested_at`, `expires_at`, `sent_at`, `used_at`, `is_used`, `ip_address`) VALUES
(27, 20, 'sara123@gmail.com', 'PROFILE_UPDATE_7a0c7f10f6175186', '$2y$10$ou7fSEUMFigZ2.hUEsPDVuSGI1W6q9XY2yuMKJk7CKI0VD536XiSi', '2026-05-10 10:52:37', NULL, NULL, '2026-05-10 10:52:37', 1, '::1'),
(28, 20, 'sara123@gmail.com', '4b803aed620cfb5dfa35dd56c48af309800fa7ff9a1ab5b31b7593ad0a1c954a', '', '2026-05-10 10:57:11', '2026-05-10 13:57:11', NULL, NULL, 0, '::1'),
(29, 2, 'sozmahmoud68@gmail.com', 'PROFILE_UPDATE_9df4f12cd0047234', '$2y$10$MSnOYr7mZ7idHQ9gjrZyfu/jXPbmnPktCfYHI.0g3FPOqrT86a/CW', '2026-05-12 19:55:27', NULL, NULL, '2026-05-12 19:55:27', 1, '::1'),
(30, 2, 'sozmahmoud68@gmail.com', 'PROFILE_UPDATE_9f8f3bd7fb8fc3f1', '$2y$10$MGBnKVA8sDuIlND8RPpLXejljlJQOHJJaEJQUCcZTZ/WsC6YQ/ium', '2026-05-14 18:43:52', NULL, NULL, '2026-05-14 18:43:52', 1, '::1'),
(31, 23, 'rwanin123@gmail.com', 'bc4b1e460a01509e6ac31dc19a4e3176f1693c9aa27484a87e5b0abeb0abc565', '', '2026-05-17 09:59:30', '2026-05-17 12:59:30', NULL, NULL, 0, '::1');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL CHECK (`price` >= 0),
  `sale_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `image_url` varchar(500) NOT NULL,
  `category` varchar(100) NOT NULL DEFAULT 'Uncategorized',
  `color` varchar(100) NOT NULL DEFAULT 'Mixed',
  `description` varchar(1000) NOT NULL DEFAULT '',
  `is_flower` tinyint(1) NOT NULL DEFAULT 1,
  `stock` int(10) UNSIGNED NOT NULL DEFAULT 10,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `sale_price`, `image_url`, `category`, `color`, `description`, `is_flower`, `stock`, `is_active`, `created_at`) VALUES
(1, 'Blue Sapphire Roses', 20.00, 20.00, 'assets/img/items/roses/rose_1.jpg', 'Roses', 'Blue', 'Elegant blue sapphire roses bouquet', 1, 49, 1, '2026-05-14 21:03:16'),
(2, 'Rainbow Romance Roses', 32.00, 25.00, 'assets/img/items/roses/rose_2.jpg', 'Roses', 'Multi-color', 'Beautiful rainbow colored romance roses', 1, 50, 1, '2026-05-14 21:03:16'),
(3, 'Golden Sunshine Roses', 24.00, 19.00, 'assets/img/items/roses/rose_3.jpg', 'Roses', 'Yellow', 'Bright golden sunshine rose arrangement', 1, 50, 1, '2026-05-14 21:03:16'),
(4, 'Ruby Red Romance', 31.00, 24.00, 'assets/img/items/roses/rose_5.jpg', 'Roses', 'Red', 'Deep ruby red romance roses', 1, 50, 1, '2026-05-14 21:03:16'),
(5, 'Peach Paradise Roses', 26.00, 20.00, 'assets/img/items/roses/rose_6.jpg', 'Roses', 'Peach', 'Soft peach paradise roses collection', 1, 50, 1, '2026-05-14 21:03:16'),
(6, 'Blush Pink Dream', 27.00, 21.00, 'assets/img/items/roses/rose_7.jpg', 'Roses', 'Pink', 'Romantic blush pink dream roses', 1, 50, 1, '2026-05-14 21:03:16'),
(7, 'Pure White Elegance', 36.00, 28.00, 'assets/img/items/roses/rose_9.jpg', 'Roses', 'White', 'Pure white elegant rose bouquet', 1, 50, 1, '2026-05-14 21:03:16'),
(8, 'Soft Pink Ribbon Roses', 20.00, 20.00, 'assets/img/items/roses/rose_10.jpg', 'Roses', 'Pink', 'Soft pink roses with ribbon decoration', 1, 45, 1, '2026-05-14 21:03:16'),
(9, 'Rainbow Mixed Tulips', 22.00, 17.00, 'assets/img/items/tulips/tulip_1.jpg', 'Tulips', 'Multi-color', 'Colorful mixed rainbow tulips', 1, 50, 1, '2026-05-14 21:03:16'),
(10, 'Red & White Romance Tulips', 28.00, 22.00, 'assets/img/items/tulips/tulip_2.jpg', 'Tulips', 'Red/White', 'Striking red and white tulips', 1, 50, 1, '2026-05-14 21:03:16'),
(11, 'Pure White Elegance Tulips', 19.00, 19.00, 'assets/img/items/tulips/tulip_3.jpg', 'Tulips', 'White', 'Pure white elegant tulip collection', 1, 49, 1, '2026-05-14 21:03:16'),
(12, 'Lavender Love Tulips', 24.00, 19.00, 'assets/img/items/tulips/tulip_5.jpg', 'Tulips', 'Purple', 'Lovely lavender love tulips', 1, 50, 1, '2026-05-14 21:03:16'),
(13, 'Ruby Red Tulip Bouquet', 31.00, 24.00, 'assets/img/items/tulips/tulip_6.jpg', 'Tulips', 'Red', 'Deep ruby red tulip arrangement', 1, 50, 1, '2026-05-14 21:03:16'),
(14, 'Blush Pink Tulip Bouquet', 26.00, 20.00, 'assets/img/items/tulips/tulip_8.jpg', 'Tulips', 'Pink', 'Soft blush pink tulips', 1, 50, 1, '2026-05-14 21:03:16'),
(15, 'Sunset Orange Tiger Lilies', 32.00, 25.00, 'assets/img/items/lilys/lily_2.jpg', 'Lilies', 'Orange', 'Sunset orange tiger lily bouquet', 1, 50, 1, '2026-05-14 21:03:16'),
(16, 'Pink Galaxy Stargazer Lilies', 28.00, 22.00, 'assets/img/items/lilys/lily_4.jpg', 'Lilies', 'Pink', 'Pink galaxy stargazer lily collection', 1, 50, 1, '2026-05-14 21:03:16'),
(17, 'Blush Pink Bouquet Lilies', 35.00, 27.00, 'assets/img/items/lilys/lily_6.jpg', 'Lilies', 'Pink', 'Blush pink lily bouquet', 1, 50, 1, '2026-05-14 21:03:16'),
(18, 'White Heaven Lilies', 20.00, 20.00, 'assets/img/items/lilys/lily_7.jpg', 'Lilies', 'White', 'Pure white heaven lilies', 1, 47, 1, '2026-05-14 21:03:16'),
(19, 'Ocean Blue Magic Lilies', 35.00, 27.00, 'assets/img/items/lilys/lily_9.jpg', 'Lilies', 'Blue', 'Ocean blue magical lily arrangement', 1, 50, 1, '2026-05-14 21:03:16'),
(20, 'Pastel Pink Dream Lilies', 39.00, 30.00, 'assets/img/items/lilys/lily_10.jpg', 'Lilies', 'Pink', 'Pastel pink dream lily collection', 1, 50, 1, '2026-05-14 21:03:16'),
(21, 'Purple Majesty Orchids', 39.00, 30.00, 'assets/img/items/orchids/orchid_1.jpg', 'Orchids', 'Purple', 'Purple majesty orchid arrangement', 1, 50, 1, '2026-05-14 21:03:16'),
(22, 'Pink Champagne Orchids', 28.00, 28.00, 'assets/img/items/orchids/orchid_5.jpg', 'Orchids', 'Pink', 'Elegant pink champagne orchids', 1, 49, 1, '2026-05-14 21:03:16'),
(23, 'Sunset Coral Orchids', 39.00, 30.00, 'assets/img/items/orchids/orchid_6.jpg', 'Orchids', 'Coral', 'Sunset coral orchid collection', 1, 50, 1, '2026-05-14 21:03:16'),
(24, 'Pink Cascade Orchids', 28.00, 28.00, 'assets/img/items/orchids/orchid_7.jpg', 'Orchids', 'Pink', 'Pink cascade orchid bouquet', 1, 49, 1, '2026-05-14 21:03:16'),
(25, 'Golden Sunrise Orchids', 22.00, 22.00, 'assets/img/items/orchids/orchid_9.jpg', 'Orchids', 'Yellow', 'Golden sunrise orchid arrangement', 1, 49, 1, '2026-05-14 21:03:16'),
(26, 'Ocean Breeze Blue Orchids', 45.00, 35.00, 'assets/img/items/orchids/orchid_10.jpg', 'Orchids', 'Blue', 'Ocean breeze blue orchid luxury', 1, 50, 1, '2026-05-14 21:03:16'),
(27, 'Classic Yellow Sunflower Bouquet', 18.00, 14.00, 'assets/img/items/sunflowers/sunflower_2.jpg', 'Sunflowers', 'Yellow', 'Classic yellow sunflower arrangement', 1, 50, 1, '2026-05-14 21:03:16'),
(28, 'Sunny Day Basket', 22.00, 17.00, 'assets/img/items/sunflowers/sunflower_3.jpg', 'Sunflowers', 'Yellow', 'Sunny day sunflower basket', 1, 50, 1, '2026-05-14 21:03:16'),
(29, 'Golden Vase Arrangement', 22.00, 22.00, 'assets/img/items/sunflowers/sunflower_4.jpg', 'Sunflowers', 'Yellow', 'Golden vase sunflower arrangement', 1, 43, 1, '2026-05-14 21:03:16'),
(30, 'Giant Sunflower Heart', 36.00, 28.00, 'assets/img/items/sunflowers/sunflower_6.jpg', 'Sunflowers', 'Yellow', 'Giant sunflower heart shape', 1, 50, 1, '2026-05-14 21:03:16'),
(31, 'Elegant Wrapped Sunflowers', 26.00, 20.00, 'assets/img/items/sunflowers/sunflower_10.jpg', 'Sunflowers', 'Yellow', 'Elegantly wrapped sunflowers', 1, 50, 1, '2026-05-14 21:03:16'),
(32, 'Pink Garden Delight', 28.00, 22.00, 'assets/img/items/mixed/mixed_1.jpg', 'Mixed', 'Pink', 'Pink garden delight mixed bouquet', 1, 50, 1, '2026-05-14 21:03:16'),
(33, 'Sweet Blossom Dream', 32.00, 25.00, 'assets/img/items/mixed/mixed_2.jpg', 'Mixed', 'Multi-color', 'Sweet blossom dream arrangement', 1, 50, 1, '2026-05-14 21:03:16'),
(34, 'White Daisy Charm', 36.00, 28.00, 'assets/img/items/mixed/mixed_3.jpg', 'Mixed', 'White', 'White daisy charm mixed bouquet', 1, 50, 1, '2026-05-14 21:03:16'),
(35, 'Soft Pastel Love', 35.00, 27.00, 'assets/img/items/mixed/mixed_6.jpg', 'Mixed', 'Pastel', 'Soft pastel love mixed arrangement', 1, 50, 1, '2026-05-14 21:03:16'),
(36, 'Lavender Whisper', 26.00, 20.00, 'assets/img/items/mixed/mixed_7.jpg', 'Mixed', 'Purple', 'Lavender whisper mixed bouquet', 1, 50, 1, '2026-05-14 21:03:16'),
(37, 'Spring Morning Glow', 35.00, 27.00, 'assets/img/items/mixed/mixed_8.jpg', 'Mixed', 'Multi-color', 'Spring morning glow arrangement', 1, 50, 1, '2026-05-14 21:03:16'),
(38, 'Blush Blossom Fantasy', 32.00, 25.00, 'assets/img/items/mixed/mixed_9.jpg', 'Mixed', 'Pink', 'Blush blossom fantasy bouquet', 1, 50, 1, '2026-05-14 21:03:16'),
(39, 'White Elegance Bouquet', 32.00, 25.00, 'assets/img/items/mixed/mixed_10.jpg', 'Mixed', 'White', 'White elegance mixed collection', 1, 50, 1, '2026-05-14 21:03:16'),
(40, 'Golden Buttercup Bouquet', 18.00, 14.00, 'assets/img/items/buttercup/buttercup.jpg', 'Buttercup', 'Yellow', 'Golden buttercup flower bouquet', 1, 50, 1, '2026-05-14 21:03:16'),
(41, 'Cream & Gold Buttercup Wrap', 16.00, 16.00, 'assets/img/items/buttercup/buttercup6.jpg', 'Buttercup', 'Yellow', 'Cream and gold buttercup arrangement', 1, 50, 1, '2026-05-14 21:03:16'),
(42, 'Modern Buttercup Arrangement', 22.00, 22.00, 'assets/img/items/buttercup/modernbuttercup.jpg', 'Buttercup', 'Yellow', 'Modern buttercup collection', 1, 50, 1, '2026-05-14 21:03:16'),
(43, 'Sunset Orange Buttercup', 22.00, 17.00, 'assets/img/items/buttercup/orangebuttercup.jpg', 'Buttercup', 'Orange', 'Sunset orange buttercup bouquet', 1, 50, 1, '2026-05-14 21:03:16'),
(44, 'Rosy Pink Buttercup Bundle', 18.00, 14.00, 'assets/img/items/buttercup/pinkbuttercup.jpg', 'Buttercup', 'Pink', 'Rosy pink buttercup bundle', 1, 50, 1, '2026-05-14 21:03:16'),
(45, 'Golden Daisy Sunshine', 22.00, 17.00, 'assets/img/items/daisies/beautifuldaisy.jpg', 'Daisies', 'Yellow', 'Golden daisy sunshine bouquet', 1, 50, 1, '2026-05-14 21:03:16'),
(46, 'Pure White Daisy Bloom', 26.00, 20.00, 'assets/img/items/daisies/daisies.jpg', 'Daisies', 'White', 'Pure white daisy bloom arrangement', 1, 50, 1, '2026-05-14 21:03:16'),
(47, 'Soft Daisy Charm', 26.00, 20.00, 'assets/img/items/daisies/daisy.jpg', 'Daisies', 'White/Pink', 'Soft daisy charm collection', 1, 50, 1, '2026-05-14 21:03:16'),
(48, 'Blue Daisy Magic', 26.00, 26.00, 'assets/img/items/daisies/prettybluedaisy.jpg', 'Daisies', 'Blue', 'Blue daisy magic bouquet', 1, 49, 1, '2026-05-14 21:03:16'),
(49, 'Rosy Daisy Garden', 26.00, 20.00, 'assets/img/items/daisies/rosiedaisie.jpg', 'Daisies', 'Pink', 'Rosy daisy garden arrangement', 1, 50, 1, '2026-05-14 21:03:16'),
(50, 'Simple White Daisy Wrap', 17.00, 17.00, 'assets/img/items/daisies/whitedaisy.jpg', 'Daisies', 'White', 'Simple white daisy wrap bouquet', 1, 48, 1, '2026-05-14 21:03:16'),
(51, 'Crimson Mini Rose Bouquet', 22.00, 17.00, 'assets/img/items/minirose/redminirose.jpg', 'Mini Roses', 'Red', 'Crimson mini rose bouquet', 1, 50, 1, '2026-05-14 21:03:16'),
(52, 'Pinky Baby Rose Wrap', 14.00, 14.00, 'assets/img/items/minirose/pinkybabyrosie.jpg', 'Mini Roses', 'Pink', 'Pinky baby rose wrap', 1, 48, 1, '2026-05-14 21:03:16'),
(53, 'Pretty Pink Rosie Bunch', 26.00, 20.00, 'assets/img/items/minirose/prettypinkyrosie.jpg', 'Mini Roses', 'Pink', 'Pretty pink mini rose bunch', 1, 50, 1, '2026-05-14 21:03:16'),
(54, 'Ocean Peach Rosie Bouquet', 24.00, 19.00, 'assets/img/items/minirose/oceanrosie.jpg', 'Mini Roses', 'Peach', 'Ocean peach mini rose bouquet', 1, 50, 1, '2026-05-14 21:03:16'),
(55, 'Golden Sunset Rosie', 28.00, 22.00, 'assets/img/items/minirose/goldenrosie.jpg', 'Mini Roses', 'Yellow', 'Golden sunset mini rose collection', 1, 50, 1, '2026-05-14 21:03:16'),
(56, 'Fairy White Rosie Bouquet', 16.00, 16.00, 'assets/img/items/minirose/fairywhiterosie.jpg', 'Mini Roses', 'White', 'Fairy white mini rose bouquet', 1, 50, 1, '2026-05-14 21:03:16'),
(57, 'Baby Spring Daffodils', 20.00, 16.00, 'assets/img/items/daffodils/babydaffoldis.jpg', 'Daffodils', 'Yellow', 'Baby spring daffodil collection', 1, 50, 1, '2026-05-14 21:03:16'),
(58, 'Classic Yellow Daffodils', 17.00, 17.00, 'assets/img/items/daffodils/daffoldilsss.jpg', 'Daffodils', 'Yellow', 'Classic yellow daffodil bouquet', 1, 48, 1, '2026-05-14 21:03:16'),
(59, 'Golden Spring Elegance', 24.00, 19.00, 'assets/img/items/daffodils/gorgousdaffoldils.jpg', 'Daffodils', 'Yellow', 'Golden spring elegance daffodils', 1, 50, 1, '2026-05-14 21:03:16'),
(60, 'Lavender Sunshine Mix', 28.00, 22.00, 'assets/img/items/daffodils/lavenderdaffoldils.jpg', 'Daffodils', 'Purple/Yellow', 'Lavender sunshine daffodil mix', 1, 50, 1, '2026-05-14 21:03:16'),
(61, 'Light Yellow Dream', 17.00, 17.00, 'assets/img/items/daffodils/lightyellowdaffoldils.jpg', 'Daffodils', 'Yellow', 'Light yellow dream daffodils', 1, 50, 1, '2026-05-14 21:03:16'),
(62, 'Blue Sapphire Roses Birthday', 26.00, 20.00, 'assets/img/items/roses/rose_1.jpg', 'Roses', 'Blue', 'Premium blue roses for birthday celebration', 1, 50, 1, '2026-05-14 21:03:16'),
(63, 'Peach Paradise Birthday Roses', 26.00, 20.00, 'assets/img/items/roses/rose_6.jpg', 'Roses', 'Peach', 'Beautiful peach roses for birthday', 1, 50, 1, '2026-05-14 21:03:16'),
(64, 'Pure White Elegance Birthday Tulips', 24.00, 19.00, 'assets/img/items/tulips/tulip_3.jpg', 'Tulips', 'White', 'White tulips for birthday celebration', 1, 50, 1, '2026-05-14 21:03:16'),
(65, 'Lavender Love Birthday Tulips', 24.00, 19.00, 'assets/img/items/tulips/tulip_5.jpg', 'Tulips', 'Lavender', 'Lavender tulips for birthday', 1, 50, 1, '2026-05-14 21:03:16'),
(66, 'Pink Champagne Birthday Orchids', 36.00, 28.00, 'assets/img/items/orchids/orchid_5.jpg', 'Orchids', 'Pink', 'Pink orchids for birthday celebration', 1, 50, 1, '2026-05-14 21:03:16'),
(67, 'Sunset Coral Birthday Orchids', 39.00, 30.00, 'assets/img/items/orchids/orchid_6.jpg', 'Orchids', 'Coral', 'Coral orchids for birthday', 1, 50, 1, '2026-05-14 21:03:16'),
(68, 'Sunset Orange Birthday Lilies', 32.00, 25.00, 'assets/img/items/lilys/lily_2.jpg', 'Lilies', 'Orange', 'Orange lilies for birthday celebration', 1, 50, 1, '2026-05-14 21:03:16'),
(69, 'Ocean Blue Birthday Lilies', 35.00, 27.00, 'assets/img/items/lilys/lily_9.jpg', 'Lilies', 'Blue', 'Blue lilies for birthday', 1, 50, 1, '2026-05-14 21:03:16'),
(70, 'Blush Blossom Birthday Mix', 32.00, 25.00, 'assets/img/items/mixed/mixed_9.jpg', 'Mixed', 'Pink', 'Mixed flowers for birthday', 1, 50, 1, '2026-05-14 21:03:16'),
(71, 'Blue Daisy Birthday Magic', 26.00, 26.00, 'assets/img/items/daisies/prettybluedaisy.jpg', 'Daisies', 'Blue', 'Blue daisies for birthday', 1, 50, 1, '2026-05-14 21:03:16'),
(72, 'Golden Birthday Elegance Daffodils', 24.00, 19.00, 'assets/img/items/daffodils/gorgousdaffoldils.jpg', 'Daffodils', 'Golden', 'Golden daffodils for birthday', 1, 50, 1, '2026-05-14 21:03:16'),
(73, 'Sunset Birthday Orange Buttercup', 22.00, 17.00, 'assets/img/items/buttercup/orangebuttercup.jpg', 'Buttercup', 'Orange', 'Orange buttercup for birthday', 1, 50, 1, '2026-05-14 21:03:16'),
(74, 'Soft Classic Teddy Bear', 22.00, 22.00, 'assets/img/items/bear/bear_1.jpg', 'Gifts', 'Brown', 'Classic soft teddy bear gift', 0, 49, 1, '2026-05-14 21:03:16'),
(75, 'Ruby Red Romance', 24.00, 24.00, 'assets/img/items/roses/rose_5.jpg', 'Roses', 'Red', 'Deep ruby red roses for Valentine', 1, 46, 1, '2026-05-14 21:03:16'),
(76, 'Premium Chocolate Collection', 30.00, 30.00, 'assets/img/items/chocolate/chocolate_4.jpg', 'Chocolates', 'Brown', 'Premium assortment of fine chocolates', 0, 48, 1, '2026-05-14 21:03:16'),
(77, 'Elegant Pink Dress Bear', 22.00, 22.00, 'assets/img/items/bear/bear_2.jpg', 'Gifts', 'Pink', 'Adorable bear in pink dress', 0, 49, 1, '2026-05-14 21:03:16'),
(78, 'Mini Cute Bear', 19.00, 14.00, 'assets/img/items/bear/bear_3.jpg', 'Gifts', 'Brown', 'Tiny cute teddy bear', 0, 50, 1, '2026-05-14 21:03:16'),
(79, 'Blush Pink Dream Valentine', 27.00, 21.00, 'assets/img/items/roses/rose_7.jpg', 'Roses', 'Pink', 'Blush pink roses for Valentine', 1, 50, 1, '2026-05-14 21:03:16'),
(80, 'Pink Love Bear', 19.00, 14.00, 'assets/img/items/bear/bear_6.jpg', 'Gifts', 'Pink', 'Sweet pink bear with love', 0, 50, 1, '2026-05-14 21:03:16'),
(81, 'Classic Brown Bear', 14.00, 14.00, 'assets/img/items/bear/bear_7.jpg', 'Gifts', 'Brown', 'Timeless classic brown teddy bear', 0, 48, 1, '2026-05-14 21:03:16'),
(82, 'Luxury Chocolate Box', 35.00, 27.00, 'assets/img/items/chocolate/chocolate_1.jpg', 'Chocolates', 'Brown', 'Luxurious premium chocolates', 0, 50, 1, '2026-05-14 21:03:16'),
(83, 'Heart Chocolate Box', 28.00, 28.00, 'assets/img/items/chocolate/chocolate_2.jpg', 'Chocolates', 'Brown', 'Heart-shaped chocolate box', 0, 48, 1, '2026-05-14 21:03:16'),
(84, 'Strawberry Chocolate Set', 25.00, 25.00, 'assets/img/items/chocolate/chocolate_3.jpg', 'Chocolates', 'Red', 'Delicious strawberry chocolates', 0, 49, 1, '2026-05-14 21:03:16'),
(85, 'Luxury Valentine Chocolate', 41.00, 32.00, 'assets/img/items/chocolate/chocolate_5.jpg', 'Chocolates', 'Brown', 'Premium Valentine chocolate collection', 0, 50, 1, '2026-05-14 21:03:16'),
(86, 'Peach Romance Valentine Roses', 26.00, 20.00, 'assets/img/items/roses/rose_6.jpg', 'Roses', 'Peach', 'Romantic peach roses', 1, 50, 1, '2026-05-14 21:03:16'),
(87, 'Rainbow Romance Roses', 25.00, 25.00, 'assets/img/items/roses/rose_2.jpg', 'Roses', 'Multi', 'Mixed romantic roses', 1, 49, 1, '2026-05-14 21:03:16'),
(88, 'Pink Galaxy Stargazer Lilies', 22.00, 22.00, 'assets/img/items/lilys/lily_4.jpg', 'Lilies', 'Pink', 'Pink lilies for Valentine', 1, 49, 1, '2026-05-14 21:03:16'),
(89, 'Ruby Red Tulip Bouquet', 24.00, 24.00, 'assets/img/items/tulips/tulip_6.jpg', 'Tulips', 'Red', 'Red tulips for Valentine', 1, 48, 1, '2026-05-14 21:03:16'),
(90, 'Pretty Pink Valentine Mini Roses', 26.00, 20.00, 'assets/img/items/minirose/prettypinkyrosie.jpg', 'Mini Roses', 'Pink', 'Pink mini roses for Valentine', 1, 50, 1, '2026-05-14 21:03:16'),
(91, 'Peach Paradise Mother Roses', 26.00, 20.00, 'assets/img/items/roses/rose_6.jpg', 'Roses', 'Peach', 'Peach roses for mother', 1, 50, 1, '2026-05-14 21:03:16'),
(92, 'Pure White Elegance Mother Tulips', 24.00, 19.00, 'assets/img/items/tulips/tulip_3.jpg', 'Tulips', 'White', 'White tulips for mothers day', 1, 50, 1, '2026-05-14 21:03:16'),
(93, 'Pink Champagne Mother Orchids', 36.00, 28.00, 'assets/img/items/orchids/orchid_5.jpg', 'Orchids', 'Pink', 'Pink orchids for mother', 1, 50, 1, '2026-05-14 21:03:16'),
(94, 'Blush Blossom Mother Mix', 32.00, 25.00, 'assets/img/items/mixed/mixed_9.jpg', 'Mixed', 'Pink', 'Mixed flowers for mothers day', 1, 50, 1, '2026-05-14 21:03:16'),
(95, 'Pink Galaxy Mother Lilies', 28.00, 22.00, 'assets/img/items/lilys/lily_4.jpg', 'Lilies', 'Pink', 'Pink lilies for mother', 1, 50, 1, '2026-05-14 21:03:16'),
(96, 'Rosy Daisy Garden', 20.00, 20.00, 'assets/img/items/daisies/rosiedaisie.jpg', 'Daisies', 'Pink', 'Pink daisies for mothers day', 1, 49, 1, '2026-05-14 21:03:16'),
(97, 'Pretty Pink Mother Rosie Bunch', 26.00, 20.00, 'assets/img/items/minirose/prettypinkyrosie.jpg', 'Mini Roses', 'Pink', 'Pink mini roses for mother', 1, 50, 1, '2026-05-14 21:03:16'),
(98, 'Golden Mother Spring Elegance', 24.00, 19.00, 'assets/img/items/daffodils/gorgousdaffoldils.jpg', 'Daffodils', 'Golden', 'Golden daffodils for mother', 1, 50, 1, '2026-05-14 21:03:16'),
(99, 'Cream & Gold Mother Buttercup', 20.00, 16.00, 'assets/img/items/buttercup/buttercup6.jpg', 'Buttercup', 'Cream', 'Buttercup for mothers day', 1, 50, 1, '2026-05-14 21:03:16'),
(100, 'Classic Yellow Mother Sunflower', 18.00, 14.00, 'assets/img/items/sunflowers/sunflower_2.jpg', 'Sunflowers', 'Yellow', 'Yellow sunflowers for mother', 1, 50, 1, '2026-05-14 21:03:16'),
(101, 'Cute Bear Gift Set', 25.00, 20.00, 'assets/img/items/other/c6.jpg', 'Gifts', 'Pink', 'Pink roses for new year', 1, 48, 1, '2026-05-14 21:03:16'),
(102, 'Mini Succulent Tray', 27.00, 0.00, 'assets/img/items/other/c10.jpg', 'Home', 'Mixed', '', 1, 7, 1, '2026-05-14 21:22:07'),
(103, 'Mini Garden Gift', 28.00, 0.00, 'assets/img/items/other/Mini Garden Gift.jpg', 'Gifts', 'Mixed', '', 1, 7, 1, '2026-05-14 21:22:03'),
(104, 'Romantic Gift Box', 28.00, 0.00, 'assets/img/items/other/s2.jpg', 'Gift Box', 'Mixed', '', 1, 8, 1, '2026-05-14 21:22:12'),
(108, 'Tulip Mix Color', 42.00, 0.00, 'assets/img/items/vip/vip_1.jpg', 'Flowers', 'Mixed', '', 1, 9, 1, '2026-05-14 21:21:56'),
(109, 'tulips', 45.00, 0.00, 'assets/img/items/vip/vip_2.jpg', 'Bouquets', 'Mixed', '', 1, 10, 1, '2026-05-21 21:55:25'),
(110, 'white tulips Luxury', 48.00, 0.00, 'assets/img/items/vip/vip_3.jpg', 'Bouquets', 'Mixed', '', 1, 10, 1, '2026-05-21 21:55:23');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `rating`, `comment`, `created_at`) VALUES
(23, 20, 25, 5, 'so pretty, i will chose that to send it to my mom.', '2026-05-10 10:51:00'),
(24, 2, 108, 5, 'so so prety realyy', '2026-05-13 08:24:55'),
(25, 22, 104, 5, 'so cute i love it', '2026-05-14 18:53:55'),
(26, 21, 104, 3, 'omg so pretty', '2026-05-14 18:54:26'),
(27, 22, 88, 5, 'so beautiful', '2026-05-14 20:03:31'),
(28, 2, 88, 3, 'so pretty omg', '2026-05-14 20:03:46'),
(29, 22, 87, 5, 'good', '2026-05-14 21:55:14'),
(30, 22, 79, 5, 'good', '2026-05-14 21:58:05'),
(31, 22, 23, 3, 'cute', '2026-05-14 21:58:25'),
(32, 22, 81, 1, 'cute', '2026-05-14 21:58:51'),
(33, 22, 82, 5, 'delicious', '2026-05-14 21:59:10'),
(34, 22, 11, 2, 'cute', '2026-05-14 21:59:28'),
(35, 22, 50, 4, 'whiteee', '2026-05-14 21:59:39'),
(36, 22, 5, 3, 'beautiful', '2026-05-14 21:59:51'),
(37, 22, 103, 3, 'great', '2026-05-14 22:00:04'),
(38, 23, 8, 5, 'so pretty', '2026-05-17 10:10:38');

-- --------------------------------------------------------

--
-- Table structure for table `reward_points`
--

CREATE TABLE `reward_points` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reward_points`
--

INSERT INTO `reward_points` (`id`, `user_id`, `points`, `created_at`) VALUES
(17, 20, 24, '2026-05-10 10:56:08'),
(18, 22, 35, '2026-05-14 20:20:52'),
(19, 2, 32, '2026-05-14 21:14:42'),
(20, 22, 41, '2026-05-14 21:23:06'),
(21, 22, 7, '2026-05-14 21:25:34'),
(22, 2, 35, '2026-05-14 21:43:08'),
(23, 2, 19, '2026-05-17 08:48:54'),
(24, 2, 20, '2026-05-17 08:49:39'),
(25, 2, 22, '2026-05-17 08:51:10'),
(26, 2, -106, '2026-05-17 08:51:10'),
(27, 23, 28, '2026-05-17 09:40:28'),
(28, 23, 118, '2026-05-19 19:55:51'),
(29, 23, 176, '2026-05-20 21:45:59'),
(30, 23, 144, '2026-05-21 22:18:30');

-- --------------------------------------------------------

--
-- Table structure for table `support_messages`
--

CREATE TABLE `support_messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `topic` varchar(80) NOT NULL,
  `order_number` varchar(50) DEFAULT NULL,
  `preferred_contact` enum('email','phone') DEFAULT 'email',
  `message` text NOT NULL,
  `status` enum('new','read','replied','closed') DEFAULT 'new',
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `support_messages`
--

INSERT INTO `support_messages` (`id`, `user_id`, `name`, `email`, `phone`, `topic`, `order_number`, `preferred_contact`, `message`, `status`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(2, 20, 'sara2 mahmood', 'sara123@gmail.com', '99999999999', 'Partnership', '#LIORA20260510125608760737', 'email', 'pleaase help', 'closed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0', '2026-05-10 10:58:26', '2026-05-14 21:12:59'),
(3, 22, 'sara Mahmood', 'saramahmood@gmail.com', '07508990597', 'Delivery question', 'ORDER #LIORA20260514222052186629', 'email', 'please i need it to get me fast please', 'closed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-14 20:23:37', '2026-05-14 21:12:55'),
(4, 23, 'rwanin dara', 'rwanin123@gmail.com', '07742225252', 'Delivery question', '#LIORA20260517114028788760', 'email', 'please i changed the date so send me my order tomorrow,thank you!', 'new', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0', '2026-05-17 09:45:55', '2026-05-17 09:45:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `verification_token` varchar(255) DEFAULT NULL,
  `role` enum('customer','admin') NOT NULL DEFAULT 'customer',
  `loyalty_points` int(10) UNSIGNED DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `email`, `password_hash`, `verification_token`, `role`, `loyalty_points`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'soz', 'Soz', 'Mahmoud', 'sozmahmoud68@gmail.com', '$2y$10$0aJiqCsoqW2KtLtDYcqTSuhFz85kVli0a1QIOU/zje88m4yccsrr.', NULL, 'admin', 0, 1, '2026-05-03 22:18:24', '2026-05-14 18:43:52'),
(3, 'LioraSupport', 'Liora', 'Support', 'support@liora.com', '$2y$10$clCzh/mfty0dzweG1WxXc.zmNp4eVPsktq6TwramCEOegnqibvAHC', NULL, 'admin', 0, 1, '2026-05-03 22:29:34', '2026-05-03 22:29:34'),
(20, 'saramahmood', 'sara2', 'mahmood', 'sara123@gmail.com', '$2y$10$0lqUJFH3CKWqilBAGxQaSO3f5c6UeqXUXiD6s0h8uag7VI6ikd8nS', '305c1e5191aeeef3f25cd89787cb0a4c77d284cf2baef4bdfdeeb06afdbe356f', 'customer', 0, 1, '2026-05-10 10:45:10', '2026-05-10 10:52:37'),
(21, 'sima', 'sima', '', 'sima@gmail.com', '$2y$10$r1XDcTjbDO0X/CmUtxDjRe2p5LdExNy3wvKsQ0DVD3rXeQCrmBITu', '50265f7d4832f12961e5afadbb522943b886f16a3aa533cbdaaaec6a016621e5', 'customer', 0, 1, '2026-05-12 19:56:37', '2026-05-12 19:56:37'),
(22, 'sara Mahmood', 'sara Mahmood', '', 'saramahmood@gmail.com', '$2y$10$1wnok5DSLeawmjvhd4.McePY3c1Gl6QzcvrdQ2O6QalCy.YgeK8Ua', '1d38dcf68b147880be2bf73dd78d333b3ec145326f30d29b84d9f3b8b9f57f3b', 'customer', 0, 1, '2026-05-14 18:46:25', '2026-05-14 18:46:25'),
(23, 'rwanin dara', 'rwanin dara', '', 'rwanin123@gmail.com', '$2y$10$KAfwqh7R9/zSJyiAhSxg/eY45xpUhKCJ530SRNgenuA5fRnQv/s8i', 'bd9c6ce2352803223fafdddc3f689112ea6f5cd6f65702530c3f20240df0a39c', 'customer', 0, 1, '2026-05-17 09:33:32', '2026-05-17 09:33:32');

-- --------------------------------------------------------

--
-- Table structure for table `user_search_history`
--

CREATE TABLE `user_search_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `search_query` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_search_history`
--

INSERT INTO `user_search_history` (`id`, `user_id`, `search_query`, `timestamp`) VALUES
(18, 20, 'orchid', '2026-05-10 10:50:18'),
(19, 2, 'گولی لیلیی سپی بەهەشت', '2026-05-10 11:01:23'),
(20, 22, 'rose', '2026-05-14 20:24:22'),
(21, 22, 'گولی ڕەنگاو ڕۆمانس', '2026-05-14 20:24:34'),
(22, 2, 'tulip mix color', '2026-05-14 21:40:09'),
(29, 23, 'گولی دەیزی سپی سادە', '2026-05-21 21:13:39');

-- --------------------------------------------------------

--
-- Table structure for table `user_special_dates`
--

CREATE TABLE `user_special_dates` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_name` varchar(100) NOT NULL,
  `event_date` date NOT NULL,
  `occasion_type` varchar(50) DEFAULT 'Special Moment',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_special_dates`
--

INSERT INTO `user_special_dates` (`id`, `user_id`, `event_name`, `event_date`, `occasion_type`, `created_at`) VALUES
(64, 20, 'Quick Select', '2026-04-16', 'Special Moment', '2026-05-10 10:58:45'),
(65, 20, 'moms bday', '2026-05-11', 'Birthday', '2026-05-10 10:58:58'),
(66, 22, 'Quick Select', '2026-04-04', 'Special Moment', '2026-05-14 20:24:06'),
(67, 23, 'mom\'s birthday', '2026-05-18', 'Birthday', '2026-05-17 09:43:17'),
(68, 23, 'Quick Select', '2026-06-03', 'Special Moment', '2026-05-21 22:15:14');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist_items`
--

CREATE TABLE `wishlist_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `options` text NOT NULL DEFAULT '',
  `product_type` varchar(100) NOT NULL DEFAULT '',
  `variant` varchar(100) NOT NULL DEFAULT '',
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist_items`
--

INSERT INTO `wishlist_items` (`id`, `user_id`, `product_id`, `options`, `product_type`, `variant`, `added_at`) VALUES
(52, 20, 25, '', '', '', '2026-05-10 10:50:34'),
(53, 20, 24, '', '', '', '2026-05-10 10:51:27'),
(54, 20, 88, '', '', '', '2026-05-10 10:51:29'),
(55, 20, 102, '', '', '', '2026-05-10 10:51:31'),
(56, 20, 5, '', '', '', '2026-05-10 10:51:40'),
(59, 2, 87, '', '', '', '2026-05-14 17:12:53'),
(62, 22, 104, '', '', '', '2026-05-14 18:53:42'),
(63, 2, 8, '', '', '', '2026-05-14 19:05:54'),
(65, 2, 18, '', '', '', '2026-05-14 22:14:57'),
(67, 2, 11, '', '', '', '2026-05-14 22:47:39'),
(69, 23, 29, '', '', '', '2026-05-17 09:35:05'),
(70, 23, 8, '', '', '', '2026-05-17 10:10:17'),
(71, 23, 22, '', '', '', '2026-05-21 21:55:17'),
(72, 23, 56, '', '', '', '2026-05-21 21:55:18'),
(73, 23, 61, '', '', '', '2026-05-21 21:55:19'),
(74, 23, 42, '', '', '', '2026-05-21 21:55:21'),
(75, 23, 110, '', '', '', '2026-05-21 21:55:23'),
(76, 23, 109, '', '', '', '2026-05-21 21:55:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_cart` (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `idx_cart_user` (`user_id`);

--
-- Indexes for table `chat_history`
--
ALTER TABLE `chat_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_chat_history_user` (`user_id`),
  ADD KEY `idx_chat_history_created` (`created_at`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD KEY `idx_orders_user` (`user_id`),
  ADD KEY `idx_orders_status` (`status`),
  ADD KEY `idx_orders_created` (`created_at`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `idx_order_items_order` (`order_id`);

--
-- Indexes for table `password_reset_requests`
--
ALTER TABLE `password_reset_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `idx_password_reset_requests_user_id` (`user_id`),
  ADD KEY `idx_password_reset_requests_email` (`email`),
  ADD KEY `idx_password_reset_requests_token` (`token`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_products_category` (`category`),
  ADD KEY `idx_products_active` (`is_active`),
  ADD KEY `idx_products_price` (`price`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_review` (`user_id`,`product_id`),
  ADD KEY `idx_reviews_product` (`product_id`);

--
-- Indexes for table `reward_points`
--
ALTER TABLE `reward_points`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_reward_points_user` (`user_id`);

--
-- Indexes for table `support_messages`
--
ALTER TABLE `support_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_support_messages_user` (`user_id`),
  ADD KEY `idx_support_messages_status` (`status`),
  ADD KEY `idx_support_messages_created` (`created_at`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_users_email` (`email`),
  ADD KEY `idx_users_role` (`role`),
  ADD KEY `idx_users_created` (`created_at`);

--
-- Indexes for table `user_search_history`
--
ALTER TABLE `user_search_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_search_history_user` (`user_id`),
  ADD KEY `idx_search_history_timestamp` (`timestamp`),
  ADD KEY `idx_search_history_query` (`search_query`);

--
-- Indexes for table `user_special_dates`
--
ALTER TABLE `user_special_dates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_special_dates_user` (`user_id`),
  ADD KEY `idx_special_dates_date` (`event_date`);

--
-- Indexes for table `wishlist_items`
--
ALTER TABLE `wishlist_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_wishlist` (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `idx_wishlist_user` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `chat_history`
--
ALTER TABLE `chat_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `password_reset_requests`
--
ALTER TABLE `password_reset_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `reward_points`
--
ALTER TABLE `reward_points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `support_messages`
--
ALTER TABLE `support_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user_search_history`
--
ALTER TABLE `user_search_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `user_special_dates`
--
ALTER TABLE `user_special_dates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `wishlist_items`
--
ALTER TABLE `wishlist_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chat_history`
--
ALTER TABLE `chat_history`
  ADD CONSTRAINT `chat_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `password_reset_requests`
--
ALTER TABLE `password_reset_requests`
  ADD CONSTRAINT `fk_password_reset_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reward_points`
--
ALTER TABLE `reward_points`
  ADD CONSTRAINT `reward_points_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `support_messages`
--
ALTER TABLE `support_messages`
  ADD CONSTRAINT `fk_support_messages_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user_search_history`
--
ALTER TABLE `user_search_history`
  ADD CONSTRAINT `user_search_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_special_dates`
--
ALTER TABLE `user_special_dates`
  ADD CONSTRAINT `user_special_dates_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlist_items`
--
ALTER TABLE `wishlist_items`
  ADD CONSTRAINT `wishlist_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
