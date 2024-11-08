-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2024 at 01:09 AM
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

--
-- Dumping data for table `bid_listing`
--

INSERT INTO `bid_listing` (`bidding_id`, `customer_id`, `amount`, `created_at`) VALUES
(16, 3, 1001, '2024-11-07 14:33:39'),
(16, 3, 1002, '2024-11-07 14:36:15'),
(16, 3, 1003, '2024-11-07 14:42:44');

-- --------------------------------------------------------

--
-- Table structure for table `bid_room`
--

CREATE TABLE `bid_room` (
  `bidding_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `details` text NOT NULL,
  `start_amount` double NOT NULL,
  `end_amount` int(11) NOT NULL DEFAULT 0,
  `bid_status` enum('Active','Closed','','') NOT NULL DEFAULT 'Active',
  `start_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `end_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bid_room`
--

INSERT INTO `bid_room` (`bidding_id`, `seller_id`, `model_id`, `details`, `start_amount`, `end_amount`, `bid_status`, `start_time`, `end_time`, `created_at`) VALUES
(16, 12, 26, 'this is the details of bid item test 1', 1000, 1003, 'Closed', '2024-11-07 16:00:00', '2024-11-09 16:00:00', '2024-10-31 05:24:28'),
(22, 12, 33, 'this is the details of bid item test 2', 1000, 0, 'Active', '2024-11-05 16:00:00', '2024-11-06 16:00:00', '2024-11-05 04:17:17'),
(23, 12, 34, 'this is the details of bid item test 2', 1000, 0, 'Active', '2024-11-05 16:00:00', '2024-11-06 16:00:00', '2024-11-05 04:17:30');

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
(6, 3);

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
(18, 1, 3, 'customer', 'aFE5NTlnL3QzR3RGVHNHZDRRN2h1Zmp2Qzlla045eDkwTFR3cUwwUjJ5cz06OgY8vnsUkcsqNRJ2eLkHGSU=', NULL, '2024-10-07 20:34:33'),
(19, 1, 12, 'seller', 'cW9UVFdJWU5sSWJCMU4zWlJ5SXJOSkV2LzcxSk9YNUE3bzlmNzVULzdQU2tiU09OUEIwd1YybDdEWmJrS0hEazo6XdlwvXuPv2nqSBgOfFzXOg==', NULL, '2024-10-31 06:04:14'),
(20, 1, 12, 'seller', 'TXMzK3pwc3Z1emtiQVRBdDJqL1BBZldTYjFBbzJaRkhUQndteFlsTHhlQTFWdTBKY3dJclFZYmMrRnVSRWtYRjo6K158TGzOuywVkewx55YyZw==', NULL, '2024-10-31 06:05:03'),
(21, 1, 12, 'seller', 'VjdqTHZlN1NObnArNG5hWVlxckU2b2tKUWZac094MDdTUGxkWVhNTi9VZHlGSjcrMUQ3cFBxOXNFbmpOWUJTWDo6dhlKjxKWksq55icW4YhCEg==', NULL, '2024-10-31 06:05:05'),
(22, 1, 12, 'seller', 'NlRYQnlicGhtMnpuVHc0cFNtbTAxSzhwekZhbG04OG1pb0VaWmpiNy9PYURoVElicmxhcXlXR0RPeXVWRGJ2STo6BEC7oBG2E0S9kGMojiT6sg==', NULL, '2024-10-31 06:05:29'),
(23, 1, 12, 'seller', 'SVhiblF5SGU0SkV2dEFXRlU5NlBOMVBGMVRxOFJTV09JVG5ZcTgyeGFSM3ZuZ0VoWXcvVVBPeUlsTGRKVDJ1YXJhZ09rMkp4WU1SN0ZFOVJZdWhnNGc9PTo6QamNpP5NTqjyPtxvS6wReA==', NULL, '2024-10-31 06:06:09'),
(24, 1, 12, 'seller', 'WnNYNXNsQmZ1aW9DTVZENDZzNitzRTFyTGpYTW5VbHFhazBRbTZ4WkNBY3ArdnNjMWxDOFdDb005UjQvb2pzYXRwS2drQzhVSWcrZU1laG5lWGsyaGc9PTo6S/+6C05p5x8DWq81J/XdLA==', 'upload/67231eef9d0fa-P1.png', '2024-10-31 06:08:47');

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
  `role` enum('customer','seller') NOT NULL DEFAULT 'customer',
  `avatar` text NOT NULL,
  `status` enum('Active','Pending','Deactivated','') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `first_name`, `last_name`, `contact_number`, `address`, `email_address`, `password`, `role`, `avatar`, `status`, `created_at`) VALUES
(3, 'John', ' Doeee', '12345678910', '123 Main St, Anytown, USA', 'admin1@gmail.com', '$2y$10$4LJMnTd2rfj7ZIqCt5IRP.PDjhnvCYEquY0P.tt5Ic3LaTSXkCR.6', 'customer', 'upload/672d050f35842-P1.png', 'Active', '2024-11-07 18:23:19'),


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
  `model_type` enum('Premium','Regular','Bidding') NOT NULL,
  `model_packaging` enum('None','Unopened','Opened') NOT NULL DEFAULT 'None',
  `model_condition` enum('Mint','Good Condition','Near Mint','Non Mint','Played') NOT NULL DEFAULT 'Mint',
  `model_image_url` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diecast_model`
--

INSERT INTO `diecast_model` (`model_id`, `seller_id`, `size_id`, `brand_id`, `model_name`, `model_description`, `model_price`, `model_stock`, `model_availability`, `model_tags`, `model_type`, `model_packaging`, `model_condition`, `model_image_url`, `created_at`) VALUES
(1, 12, 2, 2, 'Honda Civic EK9 Type R', 'A detailed diecast model of Honda Civic EK9 Type R.', 899, 90, 'Available', 'limited edition, featured', 'Premium', 'None', 'Mint', 'upload/P1.png', '2024-11-05 04:34:50'),
(2, 12, 5, 8, 'Honda Civic EK9 Type R 1/64', 'A detailed diecast model of Honda Civic EK9 Type R 1/64.', 799, 97, 'Not Available', 'new arrivals', 'Regular', 'None', 'Mint', 'upload/P2.png', '2024-11-05 04:32:08'),
(3, 12, 1, 7, 'Honda Civic EK9 Type R', 'A detailed diecast model of Honda Civic EK9 Type R.', 699, 0, 'Out of stock', 'featured', 'Premium', 'None', 'Mint', 'upload/P3.png', '2024-10-04 22:54:49'),
(4, 12, 4, 9, 'Honda Civic EK9 Type R', 'A detailed diecast model of Honda Civic EK9 Type R.', 599, 100, 'Available', 'Limited edition, new arrivals', 'Regular', 'None', 'Mint', 'upload/P4.png', '2024-10-04 22:54:51'),
(5, 12, 5, 1, 'Honda Civic EK9 Type R', 'A detailed diecast model of Honda Civic EK9 Type R.', 899, 99, 'Available', 'featured', 'Premium', 'None', 'Mint', 'upload/P1.png', '2024-10-31 00:07:22'),
(6, 12, 2, 6, 'Honda Civic EK9 Type R', 'A detailed diecast model of Honda Civic EK9 Type R.', 899, 100, 'Not Available', 'Limited edition', 'Regular', 'None', 'Mint', 'upload/P2.png', '2024-10-04 22:54:54'),
(7, 12, 4, 4, 'Honda Civic EK9 Type R 1/18', 'A detailed diecast model of Honda Civic EK9 Type R 1/18.', 899, 100, 'Available', 'new arrivals', 'Premium', 'None', 'Mint', 'upload/P3.png', '2024-10-04 22:54:56'),
(8, 12, 2, 4, 'Honda Civic EK9 Type R 1/64', 'A detailed diecast model of Honda Civic EK9 Type R 1/64.', 699, 0, 'Out of stock', 'featured', 'Regular', 'None', 'Mint', 'upload/P4.png', '2024-10-04 22:54:58'),
(9, 12, 1, 6, 'Honda Civic EK9 Type R', 'A detailed diecast model of Honda Civic EK9 Type R.', 899, 100, 'Available', 'Limited edition', 'Premium', 'None', 'Mint', 'upload/P1.png', '2024-10-04 22:55:00'),
(10, 12, 1, 1, 'Honda Civic EK9 Type R', 'A detailed diecast model of Honda Civic EK9 Type R.', 1899, 100, 'Available', 'featured, new arrivals', 'Premium', 'None', 'Mint', 'upload/P2.png', '2024-10-04 22:55:02'),
(11, 12, 4, 2, 'Model X', 'This is a detailed model of Model X.', 1999, 50, 'Available', 'Limited Edition, New Arrival', 'Premium', 'None', 'Mint', 'upload/P1.png', '2024-10-04 22:55:05'),
(12, 12, 4, 2, 'Model X', 'This is a detailed model of Model X.', 1999, 50, 'Available', 'Limited Edition, New Arrival', 'Premium', 'None', 'Mint', 'upload/P2.png', '2024-10-04 22:55:22'),
(13, 12, 4, 2, 'Model Z', 'This is a detailed model of Model X.', 1999, 50, 'Available', 'Limited Edition, New Arrival', 'Premium', 'None', 'Mint', 'upload/P3.png', '2024-10-08 18:11:58'),
(14, 12, 4, 2, 'Model X', 'This is a detailed model of Model X.', 1999, 50, 'Available', 'Limited Edition, New Arrival', 'Premium', 'None', 'Mint', 'upload/P1.png', '2024-10-04 22:55:10'),
(15, 12, 4, 2, 'Model X', 'This is a detailed model of Model X.', 1999, 50, 'Available', 'Limited Edition, New Arrival', 'Premium', 'None', 'Mint', 'upload/P4.png', '2024-10-04 22:55:30'),
(16, 12, 4, 2, 'Model X', 'This is a detailed model of Model X.', 1999, 50, 'Available', 'Limited Edition, New Arrival', 'Premium', 'None', 'Mint', 'upload/P1.png', '2024-10-04 22:55:12'),
(17, 12, 4, 2, 'Model X', 'This is a detailed model of Model X.', 1999, 50, 'Available', 'Limited Edition, New Arrival', 'Premium', 'None', 'Mint', 'upload/P2.png', '2024-10-04 22:55:32'),
(18, 12, 4, 2, 'Model X', 'This is a detailed model of Model X.', 1999, 50, 'Available', 'Limited Edition, New Arrival', 'Premium', 'None', 'Mint', 'upload/P1.png', '2024-10-04 22:55:15'),
(19, 12, 4, 2, 'Model Z', 'This is a detailed model of Model X.', 1999, 50, 'Available', 'Limited Edition, New Arrival', 'Premium', 'None', 'Mint', 'upload/P3.png', '2024-10-30 22:38:22'),
(26, 12, 1, 8, 'bid item test 1', '', 1003, 1, 'Available', '', 'Bidding', 'None', 'Mint', 'upload/6723148c753e1-P1.png', '2024-11-07 14:42:44'),
(27, 12, 1, 8, 'New Product Test', 'this is a description for new product test', 1000, 10, 'Available', 'Limited Edition, New Arrivals, Featured', 'Regular', 'Unopened', 'Mint', 'upload/6729991606115-P1.png', '2024-11-05 04:03:34'),
(33, 12, 1, 8, 'bid item test 2', 'Empty Description', 1000, 1, 'Available', 'Limited Edition, Featured, Best Seller', 'Bidding', 'Unopened', 'Good Condition', 'upload/67299c4d2a60f-P1.png', '2024-11-07 12:00:05'),
(34, 12, 1, 8, 'bid item test 3', 'Empty Description', 1000, 1, 'Available', 'Limited Edition, Featured, Best Seller', 'Bidding', 'Unopened', 'Good Condition', 'upload/67299c5acfac4-P1.png', '2024-11-07 12:00:06');

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
  `order_payment_option` text NOT NULL,
  `order_status` enum('Order Received','Processing','Packed','Ready to Ship','Shipped','Delivered','Order Placed','In Transit','Delivered','Waiting for courier') NOT NULL DEFAULT 'Processing',
  `order_trackingnum` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_info`
--

INSERT INTO `order_info` (`order_id`, `customer_id`, `shipping_addr`, `order_ref_no`, `order_total`, `order_payment_option`, `order_status`, `order_trackingnum`, `created_at`) VALUES
(4, 3, 'Sa tabi ng kanto ng dagat', 'REF-3-1728003594-571BD2', 1798, 'Cash on Delivery (CoD)', 'Order Placed', '1', '2024-11-07 17:47:57'),
(5, 3, 'Sa tabi ng kanto ng dagat', 'REF-3-1728067262-65B694', 2597, 'Cash on Delivery (CoD)', 'Order Placed', '100', '2024-11-07 17:47:59'),
(17, 3, 'shipping address', 'REF-3-1728945073-5F047D', 7891, 'Cash on Delivery (CoD)', 'Delivered', '', '2024-11-07 17:48:00'),
(18, 3, 'dito sa tabi ng kanto', 'REF-3-1731001787-0E3382', 5294, 'Cash on Delivery (CoD)', 'Processing', '', '2024-11-07 17:50:11');

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
(4, 1, 2, 2000),
(5, 1, 2, 1798),
(5, 2, 1, 799),
(17, 1, 6, 5394),
(17, 2, 2, 1598),
(17, 5, 1, 899),
(18, 1, 5, 4495),
(18, 2, 1, 799);

-- --------------------------------------------------------

--
-- Table structure for table `order_tracker`
--

CREATE TABLE `order_tracker` (
  `order_id` int(11) NOT NULL,
  `current_track` text NOT NULL,
  `status` enum('Done','Not Done') NOT NULL DEFAULT 'Not Done',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_tracker`
--

INSERT INTO `order_tracker` (`order_id`, `current_track`, `status`, `created_at`) VALUES
(4, '', 'Not Done', '2024-10-04 00:59:54'),
(5, '', 'Not Done', '2024-10-04 18:41:02'),
(17, 'Processing', 'Not Done', '2024-10-14 22:31:13'),
(17, '', 'Not Done', '2024-10-31 00:07:22'),
(17, '', 'Not Done', '2024-10-31 00:08:48'),
(17, '', 'Not Done', '2024-10-31 00:09:10'),
(17, 'Delivered', 'Not Done', '2024-10-31 00:12:12'),
(5, 'In Transit', 'Not Done', '2024-11-05 04:31:36'),
(5, 'Delivered', 'Not Done', '2024-11-05 04:31:53'),
(5, 'Order Placed', 'Not Done', '2024-11-05 04:32:08'),
(4, 'Order Placed', 'Not Done', '2024-11-05 04:34:50'),
(18, '', 'Not Done', '2024-11-07 17:49:47');

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
  `front_id_url` text NOT NULL,
  `back_id_url` text NOT NULL,
  `proof_seller_url` text DEFAULT NULL,
  `avatar` text NOT NULL,
  `status` enum('Approved','Pending','Rejected','Deactivated') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seller`
--

INSERT INTO `seller` (`seller_id`, `first_name`, `last_name`, `contact_number`, `address`, `email_address`, `password`, `front_id_url`, `back_id_url`, `proof_seller_url`, `avatar`, `status`, `created_at`) VALUES
(12, 'John', 'Doe', '12345678901', '', 'johndoe@example.com', '$2y$10$4LJMnTd2rfj7ZIqCt5IRP.PDjhnvCYEquY0P.tt5Ic3LaTSXkCR.6', '', '', NULL, '', 'Approved', '2024-11-07 18:35:44'),
(13, 'test', 'test', '12345678902', '', 'admin@gmail.com', '$2y$10$swHVJuwTi8ufN7HPQRVpWOL8UvUH6CJ4hqw8j464Xgc8uTsdqzKnW', '', '', NULL, '', 'Rejected', '2024-11-07 18:49:01'),
(17, 'test', 'test', '12345678903', '', 'adm1in@gmail.com', '$2y$10$Q3udrFo6AmPKzIQcJ.pmVu3e/aElA.p4kvgo.u.bLnHytvhHg6c4m', '', '', 'upload/672c3a3d626ba-P1.png', '', 'Deactivated', '2024-11-07 18:59:25'),


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
  ADD PRIMARY KEY (`order_id`) USING BTREE,
  ADD KEY `customer-r` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD KEY `model-re` (`model_id`),
  ADD KEY `order-re` (`order_id`);

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
  MODIFY `bidding_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `chat_message`
--
ALTER TABLE `chat_message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `chat_room`
--
ALTER TABLE `chat_room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `diecast_brand`
--
ALTER TABLE `diecast_brand`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `diecast_model`
--
ALTER TABLE `diecast_model`
  MODIFY `model_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `diecast_size`
--
ALTER TABLE `diecast_size`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_info`
--
ALTER TABLE `order_info`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `seller`
--
ALTER TABLE `seller`
  MODIFY `seller_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
