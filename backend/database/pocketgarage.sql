-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2024 at 03:33 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pocketgarage`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appraisal`
--

CREATE TABLE `appraisal` (
  `appraisal_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_type` enum('seller','customer') NOT NULL,
  `appraisal_value` double NOT NULL,
  `appraisal_status` enum('Pending','Complete','','') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bid_listing`
--

CREATE TABLE `bid_listing` (
  `bidding_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bid_room`
--

CREATE TABLE `bid_room` (
  `bidding_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `start_amount` double NOT NULL,
  `bid_increment` double NOT NULL,
  `bid_status` enum('Open','Closed','','') NOT NULL DEFAULT 'Open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `customer_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `customer_Id`) VALUES
(3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `cart_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`cart_id`, `model_id`, `quantity`, `total`) VALUES
(3, 1, 4, 3596),
(3, 2, 1, 799);

-- --------------------------------------------------------

--
-- Table structure for table `chat_message`
--

CREATE TABLE `chat_message` (
  `message_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `user_type` enum('customer','seller') NOT NULL,
  `encrypted_message` text NOT NULL,
  `attachment` text DEFAULT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_message`
--

INSERT INTO `chat_message` (`message_id`, `room_id`, `sender_id`, `user_type`, `encrypted_message`, `attachment`, `sent_at`) VALUES
(1, 1, 12, 'seller', 'ZEpFNmJSYlh4QmdHbVdvMVR4bGY3aFdvY0ozQytTZTdxMVU0am1TUFErWT06Oo7Hf0kwg5fUVo3cThLFLEM=', NULL, '2024-10-07 11:15:08'),
(2, 1, 12, 'seller', 'ZEpFNmJSYlh4QmdHbVdvMVR4bGY3aFdvY0ozQytTZTdxMVU0am1TUFErWT06Oo7Hf0kwg5fUVo3cThLFLEM=', NULL, '2024-10-07 11:15:08'),
(3, 1, 12, 'seller', 'ZEpFNmJSYlh4QmdHbVdvMVR4bGY3aFdvY0ozQytTZTdxMVU0am1TUFErWT06Oo7Hf0kwg5fUVo3cThLFLEM=', NULL, '2024-10-07 11:15:08'),
(4, 1, 12, 'seller', 'ZEpFNmJSYlh4QmdHbVdvMVR4bGY3aFdvY0ozQytTZTdxMVU0am1TUFErWT06Oo7Hf0kwg5fUVo3cThLFLEM=', NULL, '2024-10-07 11:15:08'),
(5, 1, 12, 'seller', 'ZEpFNmJSYlh4QmdHbVdvMVR4bGY3aFdvY0ozQytTZTdxMVU0am1TUFErWT06Oo7Hf0kwg5fUVo3cThLFLEM=', NULL, '2024-10-07 11:15:08'),
(6, 1, 12, 'seller', 'ZEpFNmJSYlh4QmdHbVdvMVR4bGY3aFdvY0ozQytTZTdxMVU0am1TUFErWT06Oo7Hf0kwg5fUVo3cThLFLEM=', NULL, '2024-10-07 11:15:08'),
(7, 1, 3, 'customer', 'ZEpFNmJSYlh4QmdHbVdvMVR4bGY3aFdvY0ozQytTZTdxMVU0am1TUFErWT06Oo7Hf0kwg5fUVo3cThLFLEM=', NULL, '2024-10-07 11:15:08'),
(8, 1, 3, 'customer', 'ZEpFNmJSYlh4QmdHbVdvMVR4bGY3aFdvY0ozQytTZTdxMVU0am1TUFErWT06Oo7Hf0kwg5fUVo3cThLFLEM=', NULL, '2024-10-07 11:15:08'),
(9, 1, 3, 'customer', 'ZEpFNmJSYlh4QmdHbVdvMVR4bGY3aFdvY0ozQytTZTdxMVU0am1TUFErWT06Oo7Hf0kwg5fUVo3cThLFLEM=', NULL, '2024-10-07 11:15:08'),
(10, 1, 12, 'seller', 'ZEpFNmJSYlh4QmdHbVdvMVR4bGY3aFdvY0ozQytTZTdxMVU0am1TUFErWT06Oo7Hf0kwg5fUVo3cThLFLEM=', NULL, '2024-10-07 11:15:08'),
(11, 1, 12, 'seller', 'ZEpFNmJSYlh4QmdHbVdvMVR4bGY3aFdvY0ozQytTZTdxMVU0am1TUFErWT06Oo7Hf0kwg5fUVo3cThLFLEM=', NULL, '2024-10-07 11:15:08'),
(12, 1, 3, 'customer', 'ZEpFNmJSYlh4QmdHbVdvMVR4bGY3aFdvY0ozQytTZTdxMVU0am1TUFErWT06Oo7Hf0kwg5fUVo3cThLFLEM=', NULL, '2024-10-07 11:15:08'),
(13, 1, 12, 'seller', 'ZEpFNmJSYlh4QmdHbVdvMVR4bGY3aFdvY0ozQytTZTdxMVU0am1TUFErWT06Oo7Hf0kwg5fUVo3cThLFLEM=', NULL, '2024-10-07 11:15:08'),
(14, 1, 3, 'customer', 'ZEpFNmJSYlh4QmdHbVdvMVR4bGY3aFdvY0ozQytTZTdxMVU0am1TUFErWT06Oo7Hf0kwg5fUVo3cThLFLEM=', NULL, '2024-10-07 11:15:08'),
(15, 1, 12, 'seller', 'ZEpFNmJSYlh4QmdHbVdvMVR4bGY3aFdvY0ozQytTZTdxMVU0am1TUFErWT06Oo7Hf0kwg5fUVo3cThLFLEM=', NULL, '2024-10-07 11:15:08'),
(16, 1, 3, 'customer', 'ZEpFNmJSYlh4QmdHbVdvMVR4bGY3aFdvY0ozQytTZTdxMVU0am1TUFErWT06Oo7Hf0kwg5fUVo3cThLFLEM=', NULL, '2024-10-07 20:33:05'),
(17, 1, 3, 'customer', 'YnNvUHUwOGVabDFyNy9oU3RyQzRCRVRBdXFKQXdCcXk3WjNIczAxaWl4dz06OjYqoQvPVJFOQfRRjFybP7Q=', NULL, '2024-10-07 20:33:41'),
(18, 1, 3, 'customer', 'aFE5NTlnL3QzR3RGVHNHZDRRN2h1Zmp2Qzlla045eDkwTFR3cUwwUjJ5cz06OgY8vnsUkcsqNRJ2eLkHGSU=', NULL, '2024-10-07 20:34:33');

-- --------------------------------------------------------

--
-- Table structure for table `chat_room`
--

CREATE TABLE `chat_room` (
  `room_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_room`
--

INSERT INTO `chat_room` (`room_id`, `seller_id`, `customer_id`, `created_at`) VALUES
(1, 12, 3, '2024-10-07 19:10:19');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `address` varchar(200) NOT NULL,
  `email_address` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `first_name`, `last_name`, `contact_number`, `address`, `email_address`, `password`, `created_at`) VALUES
(3, 'John 1', 'Doe', '1234567890', '123 Main St, Anytown, USA', 'johndoe@example.com', '$2y$10$4LJMnTd2rfj7ZIqCt5IRP.PDjhnvCYEquY0P.tt5Ic3LaTSXkCR.6', '2024-10-04 00:29:25');

-- --------------------------------------------------------

--
-- Table structure for table `diecast_brand`
--

CREATE TABLE `diecast_brand` (
  `brand_id` int(11) NOT NULL,
  `brand_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diecast_brand`
--

INSERT INTO `diecast_brand` (`brand_id`, `brand_name`) VALUES
(8, 'Auto World'),
(4, 'Bburago'),
(5, 'Greenlight'),
(1, 'Hot Wheels'),
(7, 'Jada Toys'),
(9, 'M2 Machines'),
(3, 'Maisto'),
(2, 'Matchbox'),
(6, 'Tomica'),
(10, 'Welly');

-- --------------------------------------------------------

--
-- Table structure for table `diecast_model`
--

CREATE TABLE `diecast_model` (
  `model_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `model_name` varchar(200) NOT NULL,
  `model_description` longtext NOT NULL,
  `model_price` double NOT NULL,
  `model_stock` int(11) NOT NULL,
  `model_availability` enum('Available','Not Available','Out of stock','') NOT NULL,
  `model_tags` varchar(200) NOT NULL,
  `model_type` enum('Premium','Regular') NOT NULL,
  `model_image_url` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diecast_model`
--

INSERT INTO `diecast_model` (`model_id`, `seller_id`, `size_id`, `brand_id`, `model_name`, `model_description`, `model_price`, `model_stock`, `model_availability`, `model_tags`, `model_type`, `model_image_url`, `created_at`) VALUES
(1, 12, 2, 2, 'Honda Civic EK9 Type R', 'A detailed diecast model of Honda Civic EK9 Type R.', 899, 100, 'Available', 'limited edition, featured', 'Premium', 'upload/P1.png', '2024-10-07 23:26:15'),
(2, 12, 5, 8, 'Honda Civic EK9 Type R 1/64', 'A detailed diecast model of Honda Civic EK9 Type R 1/64.', 799, 100, 'Not Available', 'new arrivals', 'Regular', 'upload/P2.png', '2024-10-04 22:54:47'),
(3, 12, 1, 7, 'Honda Civic EK9 Type R', 'A detailed diecast model of Honda Civic EK9 Type R.', 699, 0, 'Out of stock', 'featured', 'Premium', 'upload/P3.png', '2024-10-04 22:54:49'),
(4, 12, 4, 9, 'Honda Civic EK9 Type R', 'A detailed diecast model of Honda Civic EK9 Type R.', 599, 100, 'Available', 'Limited edition, new arrivals', 'Regular', 'upload/P4.png', '2024-10-04 22:54:51'),
(5, 12, 5, 1, 'Honda Civic EK9 Type R', 'A detailed diecast model of Honda Civic EK9 Type R.', 899, 100, 'Available', 'featured', 'Premium', 'upload/P1.png', '2024-10-04 22:54:39'),
(6, 12, 2, 6, 'Honda Civic EK9 Type R', 'A detailed diecast model of Honda Civic EK9 Type R.', 899, 100, 'Not Available', 'Limited edition', 'Regular', 'upload/P2.png', '2024-10-04 22:54:54'),
(7, 12, 4, 4, 'Honda Civic EK9 Type R 1/18', 'A detailed diecast model of Honda Civic EK9 Type R 1/18.', 899, 100, 'Available', 'new arrivals', 'Premium', 'upload/P3.png', '2024-10-04 22:54:56'),
(8, 12, 2, 4, 'Honda Civic EK9 Type R 1/64', 'A detailed diecast model of Honda Civic EK9 Type R 1/64.', 699, 0, 'Out of stock', 'featured', 'Regular', 'upload/P4.png', '2024-10-04 22:54:58'),
(9, 12, 1, 6, 'Honda Civic EK9 Type R', 'A detailed diecast model of Honda Civic EK9 Type R.', 899, 100, 'Available', 'Limited edition', 'Premium', 'upload/P1.png', '2024-10-04 22:55:00'),
(10, 12, 1, 1, 'Honda Civic EK9 Type R', 'A detailed diecast model of Honda Civic EK9 Type R.', 1899, 100, 'Available', 'featured, new arrivals', 'Premium', 'upload/P2.png', '2024-10-04 22:55:02'),
(11, 12, 4, 2, 'Model X', 'This is a detailed model of Model X.', 1999, 50, 'Available', 'Limited Edition, New Arrival', 'Premium', 'upload/P1.png', '2024-10-04 22:55:05'),
(12, 12, 4, 2, 'Model X', 'This is a detailed model of Model X.', 1999, 50, 'Available', 'Limited Edition, New Arrival', 'Premium', 'upload/P2.png', '2024-10-04 22:55:22'),
(13, 12, 4, 2, 'Model X', 'This is a detailed model of Model X.', 1999, 50, 'Available', 'Limited Edition, New Arrival', 'Premium', 'upload/P3.png', '2024-10-04 22:55:27'),
(14, 12, 4, 2, 'Model X', 'This is a detailed model of Model X.', 1999, 50, 'Available', 'Limited Edition, New Arrival', 'Premium', 'upload/P1.png', '2024-10-04 22:55:10'),
(15, 12, 4, 2, 'Model X', 'This is a detailed model of Model X.', 1999, 50, 'Available', 'Limited Edition, New Arrival', 'Premium', 'upload/P4.png', '2024-10-04 22:55:30'),
(16, 12, 4, 2, 'Model X', 'This is a detailed model of Model X.', 1999, 50, 'Available', 'Limited Edition, New Arrival', 'Premium', 'upload/P1.png', '2024-10-04 22:55:12'),
(17, 12, 4, 2, 'Model X', 'This is a detailed model of Model X.', 1999, 50, 'Available', 'Limited Edition, New Arrival', 'Premium', 'upload/P2.png', '2024-10-04 22:55:32'),
(18, 12, 4, 2, 'Model X', 'This is a detailed model of Model X.', 1999, 50, 'Available', 'Limited Edition, New Arrival', 'Premium', 'upload/P1.png', '2024-10-04 22:55:15'),
(19, 12, 4, 2, 'Model X', 'This is a detailed model of Model X.', 1999, 50, 'Available', 'Limited Edition, New Arrival', 'Premium', 'upload/P3.png', '2024-10-04 22:55:34');

-- --------------------------------------------------------

--
-- Table structure for table `diecast_size`
--

CREATE TABLE `diecast_size` (
  `size_id` int(11) NOT NULL,
  `ratio` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diecast_size`
--

INSERT INTO `diecast_size` (`size_id`, `ratio`) VALUES
(1, '1:18'),
(2, '1:24'),
(3, '1:32'),
(4, '1:43'),
(5, '1:64');

-- --------------------------------------------------------

--
-- Table structure for table `order_info`
--

CREATE TABLE `order_info` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `shipping_addr` varchar(200) NOT NULL,
  `order_ref_no` varchar(200) NOT NULL,
  `order_total` double NOT NULL,
  `order_payment_option` enum('Cash on Delivery','','','') NOT NULL,
  `order_status` enum('Order Received','Processing','Packed','Ready to Ship','Shipped','Delivered') NOT NULL DEFAULT 'Processing',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_info`
--

INSERT INTO `order_info` (`order_id`, `customer_id`, `shipping_addr`, `order_ref_no`, `order_total`, `order_payment_option`, `order_status`, `created_at`) VALUES
(1, 3, 'Sa tabi ng kanto ng dagat', 'REF-3-1728002104-AF140B', 200, 'Cash on Delivery', '', '2024-10-04 00:35:04'),
(4, 3, 'Sa tabi ng kanto ng dagat', 'REF-3-1728003594-571BD2', 1798, 'Cash on Delivery', '', '2024-10-04 01:10:30'),
(5, 3, 'Sa tabi ng kanto ng dagat', 'REF-3-1728067262-65B694', 2597, 'Cash on Delivery', '', '2024-10-04 18:41:02');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_id`, `model_id`, `quantity`, `total`) VALUES
(4, 1, 0, 0),
(5, 1, 2, 1798),
(5, 2, 1, 799);

-- --------------------------------------------------------

--
-- Table structure for table `order_tracker`
--

CREATE TABLE `order_tracker` (
  `order_id` int(11) NOT NULL,
  `current_track` enum('Delivered','Shipped','Ready to Ship','Packed','Processing','Order Received') NOT NULL DEFAULT 'Processing',
  `status` enum('Done','Not Done') NOT NULL DEFAULT 'Not Done',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_tracker`
--

INSERT INTO `order_tracker` (`order_id`, `current_track`, `status`, `created_at`) VALUES
(4, '', 'Not Done', '2024-10-04 00:59:54'),
(5, '', 'Not Done', '2024-10-04 18:41:02');

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

CREATE TABLE `seller` (
  `seller_id` int(11) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `address` varchar(200) NOT NULL,
  `email_address` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seller`
--

INSERT INTO `seller` (`seller_id`, `first_name`, `last_name`, `contact_number`, `address`, `email_address`, `password`, `created_at`) VALUES
(12, 'John', 'Doe', '1234567890', '123 Main St, Anytown, USA', 'johndoe@example.com', '$2y$10$IftVtSik9c9/qXCPaQhP2.IV3aWV5lNX9TFwUJofw84AsRXcEX/ma', '2024-10-03 23:54:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `appraisal`
--
ALTER TABLE `appraisal`
  ADD PRIMARY KEY (`appraisal_id`),
  ADD KEY `appraisal-model` (`model_id`);

--
-- Indexes for table `bid_listing`
--
ALTER TABLE `bid_listing`
  ADD KEY `bid-relation` (`bidding_id`),
  ADD KEY `customer-bid` (`customer_id`);

--
-- Indexes for table `bid_room`
--
ALTER TABLE `bid_room`
  ADD PRIMARY KEY (`bidding_id`),
  ADD KEY `seller-bid` (`seller_id`),
  ADD KEY `model-bid-room` (`model_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD UNIQUE KEY `customer_Id` (`customer_Id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD KEY `cart-item` (`cart_id`),
  ADD KEY `model-item` (`model_id`);

--
-- Indexes for table `chat_message`
--
ALTER TABLE `chat_message`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `room-relation` (`room_id`);

--
-- Indexes for table `chat_room`
--
ALTER TABLE `chat_room`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `seller-convo` (`seller_id`),
  ADD KEY `customer-convo` (`customer_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `email_address` (`email_address`);

--
-- Indexes for table `diecast_brand`
--
ALTER TABLE `diecast_brand`
  ADD PRIMARY KEY (`brand_id`),
  ADD UNIQUE KEY `brand_name` (`brand_name`);

--
-- Indexes for table `diecast_model`
--
ALTER TABLE `diecast_model`
  ADD PRIMARY KEY (`model_id`),
  ADD KEY `seller-r` (`seller_id`),
  ADD KEY `size-r` (`size_id`),
  ADD KEY `brand-r` (`brand_id`);

--
-- Indexes for table `diecast_size`
--
ALTER TABLE `diecast_size`
  ADD PRIMARY KEY (`size_id`);

--
-- Indexes for table `order_info`
--
ALTER TABLE `order_info`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer-r` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD KEY `order-re` (`order_id`),
  ADD KEY `model-re` (`model_id`);

--
-- Indexes for table `order_tracker`
--
ALTER TABLE `order_tracker`
  ADD KEY `order-rel` (`order_id`);

--
-- Indexes for table `seller`
--
ALTER TABLE `seller`
  ADD PRIMARY KEY (`seller_id`),
  ADD UNIQUE KEY `email_address` (`email_address`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appraisal`
--
ALTER TABLE `appraisal`
  MODIFY `appraisal_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bid_room`
--
ALTER TABLE `bid_room`
  MODIFY `bidding_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `chat_message`
--
ALTER TABLE `chat_message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `chat_room`
--
ALTER TABLE `chat_room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `diecast_brand`
--
ALTER TABLE `diecast_brand`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `diecast_model`
--
ALTER TABLE `diecast_model`
  MODIFY `model_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `diecast_size`
--
ALTER TABLE `diecast_size`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_info`
--
ALTER TABLE `order_info`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `seller`
--
ALTER TABLE `seller`
  MODIFY `seller_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appraisal`
--
ALTER TABLE `appraisal`
  ADD CONSTRAINT `appraisal-model` FOREIGN KEY (`model_id`) REFERENCES `diecast_model` (`model_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bid_listing`
--
ALTER TABLE `bid_listing`
  ADD CONSTRAINT `bid-relation` FOREIGN KEY (`bidding_id`) REFERENCES `bid_room` (`bidding_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `customer-bid` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bid_room`
--
ALTER TABLE `bid_room`
  ADD CONSTRAINT `model-bid-room` FOREIGN KEY (`model_id`) REFERENCES `diecast_model` (`model_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `seller-bid` FOREIGN KEY (`seller_id`) REFERENCES `seller` (`seller_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `customer-cart` FOREIGN KEY (`customer_Id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart-item` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `model-item` FOREIGN KEY (`model_id`) REFERENCES `diecast_model` (`model_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `chat_message`
--
ALTER TABLE `chat_message`
  ADD CONSTRAINT `room-relation` FOREIGN KEY (`room_id`) REFERENCES `chat_room` (`room_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `chat_room`
--
ALTER TABLE `chat_room`
  ADD CONSTRAINT `customer-convo` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `seller-convo` FOREIGN KEY (`seller_id`) REFERENCES `seller` (`seller_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `diecast_model`
--
ALTER TABLE `diecast_model`
  ADD CONSTRAINT `brand-r` FOREIGN KEY (`brand_id`) REFERENCES `diecast_brand` (`brand_id`),
  ADD CONSTRAINT `seller-r` FOREIGN KEY (`seller_id`) REFERENCES `seller` (`seller_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `size-r` FOREIGN KEY (`size_id`) REFERENCES `diecast_size` (`size_id`);

--
-- Constraints for table `order_info`
--
ALTER TABLE `order_info`
  ADD CONSTRAINT `customer-r` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `model-re` FOREIGN KEY (`model_id`) REFERENCES `diecast_model` (`model_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order-re` FOREIGN KEY (`order_id`) REFERENCES `order_info` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_tracker`
--
ALTER TABLE `order_tracker`
  ADD CONSTRAINT `order-rel` FOREIGN KEY (`order_id`) REFERENCES `order_info` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
