-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2025 at 07:00 PM
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
-- Database: `sports_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_requests`
--

CREATE TABLE `contact_requests` (
  `request_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_requests`
--

INSERT INTO `contact_requests` (`request_id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'Harshil', 'harshil@gmail.com', 'great', '2024-11-13 06:43:11');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `total_price`) VALUES
(1, 1, '2024-11-13 08:27:39', 64.99),
(2, 1, '2024-11-13 09:51:38', 109.98);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 16, 1, 15.00),
(2, 1, 3, 1, 49.99),
(3, 2, 2, 1, 59.99),
(4, 2, 3, 1, 49.99);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `payment_status` varchar(50) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `card_last4` varchar(4) NOT NULL,
  `card_expiry` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `order_id`, `payment_method`, `payment_status`, `transaction_id`, `amount`, `payment_date`, `card_last4`, `card_expiry`) VALUES
(1, 1, 'Credit Card', 'Completed', 'TXN66be8e20', 64.99, '2024-11-13 08:27:39', '1526', '12/24'),
(2, 2, 'Credit Card', 'Completed', 'TXN2c6ef7bf', 109.98, '2024-11-13 09:51:38', '1526', '02/26');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `category`, `price`, `description`, `image_url`, `created_at`) VALUES
(1, 'Yoga Mat', 'Fitness', 19.99, 'Non-slip yoga mat for all your fitness and yoga needs.', 'images/yoga_mat.jpeg', '2024-11-11 11:57:50'),
(2, 'Running Shoes', 'Footwear', 59.99, 'Comfortable and lightweight shoes for sports activities.', 'images/running_shoes.jpeg', '2024-11-11 11:57:50'),
(3, 'Tennis Racket', 'Tennis', 49.99, 'A professional-grade tennis racket with a lightweight frame.', 'images/tennis_racket.jpeg', '2024-11-11 11:57:50'),
(4, 'Basketball', 'Basketball', 24.99, 'A durable basketball suitable for indoor and outdoor use.', 'images/basketball.jpeg', '2024-11-11 11:57:50'),
(5, 'Football', 'Football', 29.99, 'A high-quality football for outdoor play.', 'images/football.jpeg', '2024-11-11 11:57:50'),
(16, 'Swim Goggles', 'Swimming', 15.00, 'Anti-fog swim goggles for clear underwater vision.', 'images/swim_goggles.jpeg', '2024-11-11 16:01:23'),
(17, 'Goalkeeper Gloves', 'Football', 35.99, 'Professional gloves with excellent grip.', 'images/goalkeeper_gloves.jpeg', '2024-11-11 16:01:23'),
(18, 'Basketball Shoes', 'Basketball', 85.00, 'High-performance shoes for traction and support.', 'images/basketball_shoes.jpeg', '2024-11-11 16:01:23'),
(19, 'Swim Cap', 'Swimming', 5.99, 'Durable swim cap for reduced drag in water.', 'images/swim_cap.jpeg', '2024-11-11 16:01:23'),
(20, 'Trail Running Shoes', 'Running', 90.00, 'Trail shoes designed for off-road comfort.', 'images/trail_running_shoes.jpeg', '2024-11-11 16:01:23'),
(21, 'Tennis Balls', 'Tennis', 9.99, 'Set of 3 high-bounce tennis balls.', 'images/tennis_balls.jpeg', '2024-11-11 16:01:23'),
(22, 'Road Bike', 'Cycling', 799.99, 'Lightweight road bike for high-speed cycling.', 'images/road_bike.jpeg', '2024-11-12 04:22:09'),
(23, 'Mountain Bike', 'Cycling', 950.00, 'Durable bike designed for mountain trails.', 'images/mountain_bike.png', '2024-11-12 04:22:09'),
(24, 'Cycling Helmet', 'Cycling', 45.99, 'Protective helmet for safe cycling.', 'images/cycling_helmet.jpeg', '2024-11-12 04:22:09'),
(25, 'Cycling Gloves', 'Cycling', 15.00, 'Comfortable gloves for better grip.', 'images/cycling_gloves.jpeg', '2024-11-12 04:22:09'),
(26, 'Bike Pump', 'Cycling', 12.99, 'Portable pump to keep your tires inflated.', 'images/bike_pump.jpeg', '2024-11-12 04:22:09'),
(27, 'Golf Club Set', 'Golf', 1200.00, 'Complete set of golf clubs for all skill levels.', 'images/golf_club_set.jpeg', '2024-11-12 04:22:09'),
(28, 'Golf Ball Pack', 'Golf', 24.99, 'Pack of 12 high-quality yellow colored golf balls.', 'images/golf_ball_pack.jpeg', '2024-11-12 04:22:09'),
(29, 'Golf Glove', 'Golf', 10.00, 'Glove for a secure grip on the golf club.', 'images/golf_glove.jpeg', '2024-11-12 04:22:09'),
(30, 'Golf Tees', 'Golf', 4.99, 'Pack of 100 multicolored pointed golf tees.', 'images/golf_tees.jpeg', '2024-11-12 04:22:09'),
(31, 'Golf Bag', 'Golf', 89.99, 'Lightweight golf bag with ample storage.', 'images/golf_bag.jpeg', '2024-11-12 04:22:09'),
(32, 'Boxing Gloves', 'Boxing', 50.00, 'Durable gloves for intense boxing training.', 'images/boxing_gloves.jpeg', '2024-11-12 06:01:26'),
(33, 'Punching Bag', 'Boxing', 100.00, 'Premium Heavy leather bag for boxing practice.', 'images/punching_bag.jpeg', '2024-11-12 06:01:26'),
(34, 'Hand Wraps', 'Boxing', 8.99, 'Protective hand wraps for boxing.', 'images/hand_wraps.jpeg', '2024-11-12 06:01:26'),
(35, 'Boxing Shoes', 'Boxing', 65.00, 'High-traction shoes suitable for boxing.', 'images/boxing_shoes.jpeg', '2024-11-12 06:01:26'),
(36, 'Mouth Guard', 'Boxing', 5.99, 'Mouth guard for protection during sparring.', 'images/mouth_guard.jpeg', '2024-11-12 06:01:26'),
(37, 'Badminton Racket', 'Badminton', 29.99, 'Lightweight racket for faster swings.', 'images/badminton_racket.jpeg', '2024-11-12 06:01:26'),
(38, 'Shuttlecock Pack', 'Badminton', 9.99, 'Pack of 6 durable plastic shuttlecocks.', 'images/shuttlecock_pack.jpeg', '2024-11-12 06:01:26'),
(39, 'Badminton Net', 'Badminton', 25.00, 'Regulation-size net for badminton matches.', 'images/badminton_net.jpeg', '2024-11-12 06:01:26'),
(40, 'Badminton Shoes', 'Badminton', 49.99, 'Lightweight shoes for agility on court.', 'images/badminton_shoes.jpeg', '2024-11-12 06:01:26'),
(41, 'Badminton Bag', 'Badminton', 19.99, 'Convenient bag to carry your badminton gear.', 'images/badminton_bag.jpeg', '2024-11-12 06:01:26'),
(42, 'Yoga Blocks', 'Yoga', 12.99, 'Set of two blocks for extended poses.', 'images/yoga_blocks.jpeg', '2024-11-12 06:01:26'),
(43, 'Yoga Strap', 'Yoga', 7.99, 'Strap to aid in stretching and flexibility.', 'images/yoga_strap.jpeg', '2024-11-12 06:01:26'),
(44, 'Meditation Cushion', 'Yoga', 25.00, 'Cushion for comfortable meditation.', 'images/meditation_cushion.jpeg', '2024-11-12 06:01:26'),
(45, 'Resistance Bands', 'Yoga', 15.99, 'Set of resistance bands for strength exercises.', 'images/resistance_bands.jpeg', '2024-11-12 06:01:26'),
(46, 'Yoga Ball', 'Yoga', 22.99, 'Exercise ball for core strengthening.', 'images/yoga_ball.jpeg', '2024-11-12 06:01:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `address`, `created_at`) VALUES
(1, 'Harshil', 'harshil@gmail.com', '123', 'Utraj', '2024-11-13 06:42:48'),
(2, 'H', 'xasow73255@lineacr.com', '$2y$10$bJDaWHfvfCvBrtKlL9swfOLbEKYpZ6zj1OrvbEJQkgeDzhyidyNbC', 'a', '2024-11-15 07:22:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_requests`
--
ALTER TABLE `contact_requests`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_requests`
--
ALTER TABLE `contact_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
