-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2022 at 07:44 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `topsoft`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `login_token` varchar(100) DEFAULT NULL,
  `last_login` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `email`, `password`, `login_token`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$WpAJP7rwP1A0tBd0a8b3P.6DIsPRfhCW9/Duj1IJAQcg17Ok7tzgC', '3e969f4bf3b6f5f55119077fa4412cef', '2022-02-08 11:11:09', '2022-02-08 05:41:09', '2022-03-07 09:50:31');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `tax_number` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(50) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `occupation` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active',
  `note` text DEFAULT NULL,
  `note2` text DEFAULT NULL,
  `postal_code` varchar(10) NOT NULL,
  `region` varchar(50) DEFAULT NULL,
  `tax_post` varchar(50) DEFAULT NULL,
  `discount` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `name`, `tax_number`, `address`, `city`, `telephone`, `mobile`, `occupation`, `email`, `status`, `note`, `note2`, `postal_code`, `region`, `tax_post`, `discount`, `created_at`, `updated_at`) VALUES
(4, 'sumit singh chauhan', 'AZUPC7395R', 'sainic colony', 'fatehgarh', '8604106692', '8604106692', 'Engineer', 'sumit@gmail.com', 'active', 'Note 1', 'Note 2', '209601', 'Farrukhabad', 'Fatehgarh', '209601', '2022-02-27 12:53:13', '2022-02-28 12:05:34');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `company_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `greek_name` varchar(100) DEFAULT NULL,
  `private_key` varchar(100) NOT NULL,
  `public_key` varchar(255) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`company_id`, `name`, `greek_name`, `private_key`, `public_key`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Appscioto', 'vhkvhhv', '$2y$10$OMMLulTXwxF2ey3JAC2McO.o8w7VxVF0XhDMg0Ljnx6oLQmHT1xpG', 'sumit.chauhan183@gmail.com', 'active', '2022-02-10 01:54:26', '2022-03-07 12:27:16'),
(2, 'Amazon', 'kknlkl', '$2y$10$Zu/BnJKpJxeYtVZ0tyg4ZunpY3JkhXjZ5xnc/g7HKKnUrC6rK3EYa', 'amazon@gmail.com', 'active', '2022-02-28 13:18:35', '2022-02-28 13:29:20');

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `device_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `otp` varchar(6) DEFAULT NULL,
  `unique_token` varchar(100) DEFAULT NULL,
  `device_token` varchar(255) DEFAULT NULL,
  `login_token` varchar(255) DEFAULT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'android',
  `status` varchar(10) NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`device_id`, `company_id`, `email`, `password`, `otp`, `unique_token`, `device_token`, `login_token`, `type`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'sumit.chauhan183@gmail.com', '$2y$10$uYJpo.lMPTjPZuhLQWHHIu4b9MxckL6wWtYMsD./kZYM3hYUp0s9e', '816567', '000000001', 'lhgjlbljvjhbvjhvjhvjhllh', '2c29ade55e1a1695e9ba8658b75e43a2', 'android', 'active', '2022-02-10 02:51:57', '2022-03-01 05:45:28'),
(4, 1, 'sumit@gmail.com', '$2y$10$8NZnlSL8uQCVMrrRstsKoeHwIU1LPVmrRwT3QO0X5XIBvoX1qGzAK', NULL, NULL, NULL, NULL, 'android', 'active', '2022-03-07 10:11:07', '2022-03-07 10:11:07'),
(11, 1, 'sumit1@gmail.com', '$2y$10$PqUPdk02YB/SxbLweizgFek2AECTdz0BbrNkZoyaBCuXXy7NoLtnS', NULL, NULL, NULL, NULL, 'android', 'active', '2022-03-07 12:26:32', '2022-03-07 12:26:32');

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `feature_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `invoice_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `device_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `invoice_number` varchar(15) DEFAULT NULL,
  `payment_method` varchar(10) NOT NULL,
  `address` text NOT NULL,
  `maintainance` varchar(5) NOT NULL DEFAULT 'yes',
  `note` text NOT NULL,
  `user_info` text NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`invoice_id`, `client_id`, `device_id`, `company_id`, `type`, `invoice_number`, `payment_method`, `address`, `maintainance`, `note`, `user_info`, `status`, `created_at`, `updated_at`) VALUES
(3, 4, 1, 1, '', 'APPINV1000003', '', '', '', '', '', 'draft', '2022-03-02 06:25:56', '2022-03-02 06:25:57'),
(4, 4, 1, 1, '', 'APPINV1000004', '', '', '', '', '', 'draft', '2022-03-02 06:26:00', '2022-03-02 06:26:00'),
(5, 4, 1, 1, '', 'APPINV1000005', '', '', '', '', '', 'draft', '2022-03-02 06:26:02', '2022-03-02 06:26:02'),
(6, 4, 1, 1, '', 'APPINV1000006', '', '', '', '', '', 'draft', '2022-03-02 06:26:03', '2022-03-02 06:26:03'),
(7, 4, 1, 1, '', 'APPINV1000007', '', '', '', '', '', 'draft', '2022-03-02 06:26:05', '2022-03-02 06:26:05'),
(8, 4, 1, 1, '', 'APPINV1000008', '', '', '', '', '', 'draft', '2022-03-02 06:26:06', '2022-03-02 06:26:06');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `invoice_item_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`invoice_item_id`, `invoice_id`, `item_id`, `quantity`, `created_at`, `updated_at`) VALUES
(2, 2, 7, 2, '2022-03-02 06:18:24', '2022-03-02 06:18:24'),
(3, 3, 6, 2, '2022-03-02 06:25:57', '2022-03-02 06:25:57'),
(4, 3, 7, 2, '2022-03-02 06:25:57', '2022-03-02 06:25:57'),
(5, 4, 6, 2, '2022-03-02 06:26:00', '2022-03-02 06:26:00'),
(6, 4, 7, 2, '2022-03-02 06:26:01', '2022-03-02 06:26:01'),
(7, 5, 6, 2, '2022-03-02 06:26:02', '2022-03-02 06:26:02'),
(8, 5, 7, 2, '2022-03-02 06:26:02', '2022-03-02 06:26:02'),
(9, 6, 6, 2, '2022-03-02 06:26:03', '2022-03-02 06:26:03'),
(10, 6, 7, 2, '2022-03-02 06:26:04', '2022-03-02 06:26:04'),
(11, 7, 6, 2, '2022-03-02 06:26:05', '2022-03-02 06:26:05'),
(12, 7, 7, 2, '2022-03-02 06:26:05', '2022-03-02 06:26:05'),
(13, 8, 6, 2, '2022-03-02 06:26:06', '2022-03-02 06:26:06'),
(14, 8, 7, 2, '2022-03-02 06:26:06', '2022-03-02 06:26:06'),
(15, 2, 6, 2, '2022-03-02 06:51:29', '2022-03-02 06:51:29'),
(16, 2, 7, 2, '2022-03-02 06:51:29', '2022-03-02 06:51:29');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float NOT NULL DEFAULT 0,
  `description` text NOT NULL,
  `vat` int(11) NOT NULL DEFAULT 0,
  `discount` int(11) NOT NULL DEFAULT 0,
  `final_price` float NOT NULL DEFAULT 0,
  `barcode` varchar(50) DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `name`, `quantity`, `price`, `description`, `vat`, `discount`, `final_price`, `barcode`, `status`, `created_at`, `updated_at`) VALUES
(6, 'Soap 8', 50, 260.99, 'shampoo for wash hairs.', 10, 10, 260.99, 'sha6IaJA9r', 'available', '2022-03-01 06:05:10', '2022-03-01 06:32:36'),
(7, 'shampoo', 20, 293.99, 'shampoo for wash hairs.', 20, 20, 293.99, 'sha7Uh5TqM', 'available', '2022-03-01 06:05:58', '2022-03-01 06:05:58'),
(8, 'shampoo 1', 50, 290.99, 'shampoo for wash hairs.', 10, 10, 290.99, 'sha8lFqPXm', 'available', '2022-03-01 06:06:23', '2022-03-01 06:06:23'),
(9, 'Soap 1', 50, 290.99, 'shampoo for wash hairs.', 10, 10, 290.99, 'Soa9qsHxQa', 'available', '2022-03-01 06:06:36', '2022-03-01 06:06:36');

-- --------------------------------------------------------

--
-- Table structure for table `licences`
--

CREATE TABLE `licences` (
  `licence_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `licence_key` varchar(100) NOT NULL,
  `device_count` int(11) NOT NULL,
  `expiration_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `licences`
--

INSERT INTO `licences` (`licence_id`, `company_id`, `licence_key`, `device_count`, `expiration_date`, `created_at`, `updated_at`) VALUES
(1, 1, 'AS124587', 2, '2023-02-09 18:30:00', '2022-02-10 02:12:51', '2022-02-10 02:12:51'),
(3, 2, 'e51e547540b8cbd143ed0cc0a979b87f', 5, '2023-06-06 18:30:00', '2022-03-07 12:40:59', '2022-03-07 12:40:59');

-- --------------------------------------------------------

--
-- Table structure for table `licence_features`
--

CREATE TABLE `licence_features` (
  `licence_id` int(11) NOT NULL,
  `feature_id` int(11) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'enable',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `receipts`
--

CREATE TABLE `receipts` (
  `receipt_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `receipt_number` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `observation` text NOT NULL,
  `note` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`device_id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`feature_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`invoice_item_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `licences`
--
ALTER TABLE `licences`
  ADD PRIMARY KEY (`licence_id`);

--
-- Indexes for table `receipts`
--
ALTER TABLE `receipts`
  ADD PRIMARY KEY (`receipt_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `device_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `feature_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `invoice_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `licences`
--
ALTER TABLE `licences`
  MODIFY `licence_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `receipts`
--
ALTER TABLE `receipts`
  MODIFY `receipt_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
