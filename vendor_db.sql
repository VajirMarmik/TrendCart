-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2025 at 03:11 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vendor_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `email` varchar(70) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `email`, `password`, `created_at`) VALUES
(1, 'trendcarts2024@gmail.com', '$2y$10$p4xDNvAmZqG8ufxulu6P0OAO8NE.OT4eBIdTdoiFEiLxxl9XEubZ2', '2024-08-30 05:10:25');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `created_at`) VALUES
(1, 'Adidas', '2024-08-01 13:22:45'),
(2, 'Puma', '2024-08-04 13:22:45'),
(3, 'Nike', '2024-07-13 13:22:45'),
(4, 'Reebok', '2024-06-18 13:22:45'),
(5, 'Under Armour', '2024-07-16 13:22:45'),
(6, 'New Balance', '2024-08-20 13:22:45'),
(7, 'Skechers', '2024-08-24 13:22:45'),
(8, 'Fila', '2024-08-24 13:22:45'),
(9, 'Asics', '2024-08-15 13:22:45'),
(10, 'Converse', '2024-06-29 13:22:45'),
(11, 'Vans', '2024-09-01 13:22:45'),
(12, 'Brooks', '2024-06-13 13:22:45'),
(13, 'Merrell', '2024-07-24 13:22:45'),
(14, 'Timberland', '2024-07-14 13:22:45'),
(15, 'Saucony', '2024-07-24 13:22:45'),
(16, 'Salomon', '2024-07-13 13:22:45'),
(17, 'Columbia', '2024-07-19 13:22:45'),
(18, 'Keen', '2024-06-21 13:22:45'),
(19, 'La Sportiva', '2024-07-12 13:22:45'),
(20, 'Hoka One One', '2024-07-25 13:22:45'),
(21, 'The North Face', '2024-07-23 13:22:45'),
(22, 'Patagonia', '2024-06-05 13:22:45'),
(23, 'Arc’teryx', '2024-07-11 13:22:45'),
(24, 'Mammut', '2024-06-07 13:22:45'),
(25, 'Outdoor Research', '2024-08-27 13:22:45');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`) VALUES
(1, 'Man', '2024-08-03 13:28:45'),
(2, 'Woman', '2024-08-28 13:28:45'),
(3, 'Children', '2024-08-09 13:28:45'),
(4, 'Unisex', '2024-08-19 13:28:45');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `full_name` varchar(70) NOT NULL,
  `phone` varchar(13) NOT NULL,
  `email` varchar(70) NOT NULL,
  `password` varchar(255) NOT NULL,
  `code` text NOT NULL,
  `registered_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `full_name`, `phone`, `email`, `password`, `code`, `registered_date`) VALUES
(17, 'Divyesh Mavani', '9601603869', 'mdmavani9@gmail.com', '1d4bbcfed31c6e01e90d8e4099e39eb7', 'c87d202023557da839e234f24cc7d5b7', '2024-10-22 19:39:58'),
(26, 'Krishnkumar M Mavani', '08866172158', 'mavanikrishnm@gmail.com', '3fcb7254e17254fec4d9a0d45bac5ff4', '25e35b822250c6a207ead14fe72398c7', '2024-12-13 20:47:58');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `customer_id`, `name`, `email`, `message`, `created_at`) VALUES
(40, 26, 'Krishnkumar M Mavani', 'krishnkumarmmavani7@gmail.com', 'dfdef', '2024-12-13 20:53:08');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(35) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `size` int(11) NOT NULL,
  `color` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `status` enum('pending','verified','not_verified','') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `category_id` int(11) NOT NULL,
  `photo_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `description`, `price`, `size`, `color`, `type`, `vendor_id`, `brand_id`, `status`, `created_at`, `category_id`, `photo_path`) VALUES
(31, 'Nike Air Max 270', 'Stylish and comfortable running shoes with excellent cushioning.', 150.00, 10, 'Black', 'Running Shoes', 2, 11, 'verified', '2024-06-13 15:21:37', 1, '../uploads/products/Nike Air Max 270.jpeg'),
(32, 'Adidas Ultraboost 21', 'High-performance running shoes with a responsive boost midsole.', 180.00, 9, 'White', 'Running Shoes', 2, 15, 'pending', '2024-06-24 15:21:37', 3, '../uploads/products/Adidas Ultraboost 21.jpeg'),
(33, 'Puma RS-X', 'Bold and fashionable sneakers with a retro design.', 110.00, 11, 'Blue', 'Sneakers', 2, 11, 'verified', '2024-07-06 15:21:37', 4, '../uploads/products/Puma RS-X.jpeg'),
(35, 'Asics Gel-Kayano 27', 'Supportive running shoes with gel cushioning for a smooth ride.', 160.00, 10, 'Green', 'Running Shoes', 2, 3, 'not_verified', '2024-07-19 15:21:37', 2, '../uploads/products/Asics Gel-Kayano 27.jpeg'),
(36, 'Skechers Go Walk 5', 'Comfortable walking shoes with a lightweight and flexible design.', 95.00, 8, 'Gray', 'Walking Shoes', 2, 16, 'pending', '2024-07-27 15:21:37', 3, '../uploads/products/Skechers Go Walk 5.jpeg'),
(37, 'Fila Disruptor 2', 'Chunky sneakers with a distinctive design and solid grip.', 70.00, 10, 'White', 'Sneakers', 2, 14, 'verified', '2024-08-03 15:21:37', 2, '../uploads/products/Fila Disruptor 2.jpeg'),
(38, 'Vans Old Skool', 'Classic skate shoes with a signature stripe and durable canvas upper.', 65.00, 9, 'Black', 'Skate Shoes', 2, 15, 'pending', '2024-08-03 15:21:37', 2, '../uploads/products/Vans Old Skool woman.jpeg'),
(39, 'Brooks Ghost 13', 'Neutral running shoes providing a smooth and comfortable ride.', 140.00, 11, 'Blue', 'Running Shoes', 2, 15, 'not_verified', '2024-06-17 15:21:37', 2, '../uploads/products/Brooks Ghost 13.jpeg'),
(40, 'Merrell Moab 2', 'Reliable hiking shoes with excellent traction and support.', 130.00, 12, 'Brown', 'Hiking Shoes', 2, 11, 'pending', '2024-08-10 15:21:37', 1, '../uploads/products/Merrell Moab 2 Man.jpeg'),
(41, 'Timberland PRO 6-Inch', 'Durable work boots designed for tough environments.', 190.00, 10, 'Yellow', 'Boots', 2, 18, 'not_verified', '2024-08-11 15:21:37', 1, '../uploads/products/Timberland PRO 6-Inch.jpeg'),
(42, 'Saucony Ride 14', 'Running shoes with a plush and responsive feel for long runs.', 120.00, 9, 'Red', 'Running Shoes', 2, 19, 'verified', '2024-07-19 15:21:37', 1, '../uploads/products/Saucony Ride 14.jpeg'),
(43, 'Salomon Speedcross 5', 'Trail shoes with aggressive traction for rugged terrains.', 135.00, 11, 'Green', 'Trail Shoes', 2, 24, 'pending', '2024-08-07 15:21:37', 3, '../uploads/products/Salomon Speedcross 5.jpeg'),
(44, 'Columbia Montrail Caldorado', 'Trail footwear with a balanced mix of cushioning and support.', 125.00, 10, 'Gray', 'Trail Shoes', 2, 17, 'verified', '2024-07-02 15:21:37', 4, '../uploads/products/Columbia Montrail Caldorado.jpeg'),
(45, 'Keen Targhee III', 'Hiking shoes designed for comfort and support on various terrains.', 140.00, 12, 'Black', 'Hiking Shoes', 2, 9, 'verified', '2024-08-22 15:21:37', 3, '../uploads/products/Keen Targhee III.jpeg'),
(46, 'La Sportiva Bushido II', 'Lightweight trail shoes providing stability and protection.', 155.00, 9, 'Blue', 'Trail Shoes', 2, 12, 'not_verified', '2024-07-06 15:21:37', 1, '../uploads/products/La Sportiva Bushido II.jpeg'),
(47, 'Hoka One One Clifton 8', 'Highly cushioned running shoes for a smooth and soft ride.', 130.00, 10, 'White', 'Running Shoes', 2, 2, 'not_verified', '2024-07-05 15:21:37', 1, '../uploads/products/Hoka One One Clifton 8.jpeg'),
(48, 'The North Face Vectiv', 'High-performance trail shoes designed for speed and stability.', 140.00, 11, 'Brown', 'Trail Shoes', 2, 2, 'pending', '2024-06-29 15:21:37', 4, '../uploads/products/The North Face Vectiv.jpeg'),
(49, 'Patagonia Drifter A/C', 'Versatile and comfortable footwear suitable for hiking and casual use.', 130.00, 9, 'Green', 'Hiking Shoes', 2, 10, 'verified', '2024-06-19 15:21:37', 4, '../uploads/products/Patagonia Drifter AC.jpeg'),
(50, 'Arc’teryx Norvan VT', 'Technical footwear offering a precise fit and excellent grip for trail running.', 160.00, 10, 'Black', 'Trail Shoes', 2, 7, 'pending', '2024-06-10 15:21:37', 2, '../uploads/products/Arc’teryx Norvan VT.jpeg'),
(51, 'Mammut Ducan Mid', 'Mid-cut hiking boots providing comfort and protection for demanding trails.', 175.00, 12, 'Gray', 'Hiking Boots', 2, 2, 'verified', '2024-08-14 15:21:37', 1, '../uploads/products/Mammut Ducan Mid.jpeg'),
(52, 'Outdoor Research Helium', 'Lightweight and breathable trail shoes built for fast hikes.', 125.00, 8, 'Blue', 'Trail Shoes', 2, 15, 'not_verified', '2024-06-22 15:21:37', 1, '../uploads/products/Outdoor Research Helium.jpeg'),
(53, 'Garmont Dragontail', 'Approach shoes with excellent traction and durability for rocky terrain.', 145.00, 10, 'Brown', 'Approach Shoes', 2, 17, 'verified', '2024-08-23 15:21:37', 1, '../uploads/products/Garmont Dragontail.jpeg'),
(54, 'Lowa Innox Pro', 'Versatile footwear offering lightweight comfort for varied activities.', 140.00, 11, 'Black', 'Hiking Shoes', 2, 24, 'verified', '2024-08-16 15:21:37', 1, '../uploads/products/Lowa Innox Pro.jpeg'),
(55, 'Inov-8 Terraultra', 'High-cushioning trail shoes designed for ultra-distance running.', 155.00, 9, 'Gray', 'Trail Shoes', 2, 22, 'not_verified', '2024-08-07 15:21:37', 3, '../uploads/products/Inov-8 Terraultra.jpeg'),
(56, 'Oboz Sawtooth', 'Durable hiking shoes with excellent grip and support.', 135.00, 10, 'Green', 'Hiking Shoes', 2, 5, 'pending', '2024-06-15 15:21:37', 3, '../uploads/products/Oboz Sawtooth.jpeg'),
(57, 'Scarpa Kinesis', 'High-performance footwear for demanding alpine conditions.', 170.00, 12, 'Brown', 'Alpine Boots', 2, 18, 'verified', '2024-07-03 15:21:37', 2, '../uploads/products/Scarpa Kinesis.jpeg'),
(58, 'La Sportiva Nepal Cube', 'Sturdy boots designed for mountaineering and high-altitude treks.', 190.00, 11, 'Black', 'Mountaineering Boots', 2, 6, 'pending', '2024-08-01 15:21:37', 3, '../uploads/products/La Sportiva Nepal Cube.jpeg'),
(59, 'Zamberlan 996', 'Durable and supportive boots ideal for long hikes and trekking.', 180.00, 12, 'Gray', 'Hiking Boots', 2, 17, 'pending', '2024-07-29 15:21:37', 3, '../uploads/products/Zamberlan 996.jpeg'),
(60, 'Kenetrek Mountain', 'Heavy-duty boots designed for rugged terrain and extended wear.', 210.00, 11, 'Brown', 'Hiking Boots', 2, 22, 'verified', '2024-08-08 15:21:37', 2, '../uploads/products/Kenetrek Mountain.jpeg'),
(61, 'Boreal Tofana', 'Climbing boots with precise fit and durability for technical ascents.', 160.00, 10, 'Black', 'Climbing Shoes', 2, 25, 'verified', '2024-06-28 15:21:37', 2, '../uploads/products/Boreal Tofana.jpeg'),
(62, 'Five Ten Anasazi', 'High-performance climbing shoes offering exceptional grip and precision.', 150.00, 9, 'Red', 'Climbing Shoes', 2, 6, 'pending', '2024-06-09 15:21:37', 2, '../uploads/products/Five Ten Anasazi.jpeg'),
(63, 'Black Diamond Momentum', 'Comfortable climbing shoes designed for both indoor and outdoor use.', 130.00, 10, 'Blue', 'Climbing Shoes', 2, 9, 'not_verified', '2024-07-06 15:21:37', 1, '../uploads/products/Black Diamond Momentum.jpeg'),
(64, 'Evolv Defy', 'All-around climbing shoes offering a balance of performance and comfort.', 140.00, 11, 'Gray', 'Climbing Shoes', 2, 14, 'verified', '2024-08-09 15:21:37', 4, '../uploads/products/Evolv Defy.jpeg'),
(65, 'Scarpa Drago', 'Performance climbing shoes with a high level of sensitivity and precision.', 160.00, 10, 'Black', 'Climbing Shoes', 2, 12, 'pending', '2024-07-24 15:21:37', 1, '../uploads/products/Scarpa Drago.jpeg'),
(66, 'Arc’teryx Konseal', 'Versatile approach shoes designed for technical approaches and rugged use.', 150.00, 9, 'Brown', 'Approach Shoes', 2, 13, 'pending', '2024-07-26 15:21:37', 4, '../uploads/products/Arc’teryx Konseal.jpeg'),
(68, 'Garmont Ascent', 'High-performance approach shoes for technical climbs and rugged terrain.', 170.00, 11, 'Green', 'Approach Shoes', 2, 15, 'verified', '2024-07-14 15:21:37', 4, '../uploads/products/Garmont Ascent.jpeg'),
(69, 'Evolv Kira', 'Approach shoes with excellent grip and stability for technical terrain.', 145.00, 10, 'Black', 'Approach Shoes', 2, 16, 'pending', '2024-06-11 15:21:37', 3, '../uploads/products/Evolv Kira.jpeg'),
(70, 'Keen Austin', 'Casual footwear with a comfortable fit and classic design.', 100.00, 11, 'Brown', 'Casual Shoes', 2, 1, 'not_verified', '2024-08-11 15:21:37', 1, '../uploads/products/Keen Austin.jpeg'),
(71, 'Merrell Jungle Moc', 'Easy-to-wear slip-on shoes with a versatile design.', 90.00, 10, 'Gray', 'Casual Shoes', 2, 8, 'not_verified', '2024-07-20 15:21:37', 1, '../uploads/products/Merrell Jungle Moc.jpeg'),
(72, 'Clarks Desert Boot', 'Iconic desert boots with a stylish and durable construction.', 110.00, 9, 'Tan', 'Casual Shoes', 2, 18, 'pending', '2024-06-18 15:21:37', 4, '../uploads/products/Clarks Desert Boot.jpeg'),
(73, 'Dr. Martens 1460', 'Classic 8-eye boots with a distinctive design and robust build.', 130.00, 11, 'Black', 'Boots', 2, 5, 'pending', '2024-06-15 15:21:37', 1, '../uploads/products/Dr. Martens 1460.jpeg'),
(74, 'Timberland PRO Boondock', 'Heavy-duty work boots built for durability and comfort in challenging conditions.', 160.00, 10, 'Brown', 'Work Boots', 2, 13, 'not_verified', '2024-07-17 15:21:37', 1, '../uploads/products/Timberland PRO Boondock.jpeg'),
(76, 'Sorel Caribou', 'Insulated winter boots designed for warmth and protection in cold conditions.', 180.00, 11, 'Black', 'Winter Boots', 2, 15, 'not_verified', '2024-06-08 15:21:37', 2, '../uploads/products/Sorel Caribou.jpeg'),
(77, 'Columbia Bugaboot', 'Durable winter boots offering excellent insulation and waterproofing.', 170.00, 10, 'Gray', 'Winter Boots', 2, 9, 'pending', '2024-06-10 15:21:37', 4, '../uploads/products/Columbia Bugaboot.jpeg'),
(78, 'Kamik Forester', 'Heavy-duty winter boots designed for extreme cold and snow.', 200.00, 12, 'Brown', 'Winter Boots', 2, 15, 'pending', '2024-07-06 15:21:37', 3, '../uploads/products/Kamik Forester.jpeg'),
(79, 'Baffin Impact', 'Insulated winter boots offering superior warmth and comfort in harsh conditions.', 190.00, 11, 'Black', 'Winter Boots', 2, 15, 'verified', '2024-06-24 15:21:37', 4, '../uploads/products/Baffin Impact.webp'),
(80, 'Mammut Alvar', 'High-performance winter boots with exceptional insulation and durability.', 210.00, 10, 'Gray', 'Winter Boots', 2, 19, 'pending', '2024-06-18 15:21:37', 4, '../uploads/products/Mammut Alvar.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pancard_number` varchar(10) NOT NULL,
  `pancard_front` varchar(255) NOT NULL,
  `pancard_back` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verification_code` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `verification_status` enum('Verified','Not Verified') NOT NULL DEFAULT 'Not Verified',
  `is_verified` varchar(10) NOT NULL DEFAULT 'Not Joined',
  `reset_status` enum('not reset','reset') DEFAULT 'not reset',
  `reset_token` varchar(255) DEFAULT NULL,
  `upi_id` varchar(50) NOT NULL,
  `make_plan` enum('Free','Basic','Standard','Premium') NOT NULL DEFAULT 'Free',
  `payment_photo` varchar(255) NOT NULL,
  `plan_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `full_name`, `username`, `photo`, `phone`, `email`, `pancard_number`, `pancard_front`, `pancard_back`, `password`, `verification_code`, `created_at`, `verification_status`, `is_verified`, `reset_status`, `reset_token`, `upi_id`, `make_plan`, `payment_photo`, `plan_time`) VALUES
(2, 'Mavani Divyesh', 'MD', '../uploads/vendors/MD.jpg', '9601603869', 'mdmavani9@gmail.com', 'ABCDE1234D', '../uploads/panfront/Pancard Front.png', '../uploads/panback/Pancard Back.png', '$2y$10$0JpMSWdYuX9zUVdQheS.8.hQ3pEiFoE99WBjSn1bPxcrzJcBrpzfW', '1ba44c21693755a521084409cf1ea3aa', '2024-06-07 15:41:08', 'Verified', 'Joined', 'not reset', '', '', 'Premium', '../uploads/payment/1499.jpg', '2024-12-08 16:46:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_ibfk_1` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feedback_ibfk_1` (`customer_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_category` (`category_id`),
  ADD KEY `fk_brand` (`brand_id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=227;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_brand` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
