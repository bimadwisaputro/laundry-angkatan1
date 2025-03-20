-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2025 at 02:18 PM
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
-- Database: `angkatan1_laundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `address`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Bima', '0812931923812', 'Jl Indah Masa Depan', 1, '2025-03-20 04:43:06', '2025-03-20 11:01:05', NULL),
(2, 'Dian', '0812923421', 'Jl Indah Masa Depan', 1, '2025-03-19 21:43:06', NULL, NULL),
(3, 'Lina', '08129314234', 'Jl Indah Masa Depan', 1, '2025-03-19 21:43:06', NULL, NULL),
(4, 'Jojo', '08129314234', 'Jl Indah Masa Depan', 1, '2025-03-19 21:43:06', NULL, NULL),
(5, 'Linda', '08121334399', 'Jl Indah Masa Depan', 1, '2025-03-19 21:43:06', NULL, NULL),
(6, 'Freya', '08126769679', 'Jl Indah Masa Depan', 1, '2025-03-19 21:43:06', NULL, NULL),
(7, 'John', '081213212311', 'Jl Indah Masa Depan', 1, '2025-03-19 21:43:06', NULL, NULL),
(8, 'Lala', '0811112323', 'Jl Indah Masa Depan', 1, '2025-03-19 21:43:06', NULL, NULL),
(9, 'Robert', '08153523524', 'Jl Indah Masa Depan', 1, '2025-03-19 21:43:06', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`id`, `name`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Administrator', 1, '2025-03-18 09:31:07', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `description` text NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `price`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Cuci dan Gosok', 5000, 'Per 1kg', 1, '2025-03-20 04:44:36', '2025-03-20 05:29:06', NULL),
(2, 'Cuci Kecil', 4500, 'Per 1kg', 1, '2025-03-20 05:28:44', NULL, NULL),
(3, 'Gosok', 5000, 'per 1kg', 1, '2025-03-20 05:29:32', '2025-03-20 05:29:44', NULL),
(4, 'Cuci Besar', 7000, 'Per 1kg', 1, '2025-03-20 05:30:06', NULL, NULL),
(5, 'Cuci Sepatu', 40000, 'per 1pcs', 1, '2025-03-20 09:54:02', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tx_orders`
--

CREATE TABLE `tx_orders` (
  `id` int(11) NOT NULL,
  `customers_id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `end_date` date NOT NULL,
  `pay` int(11) NOT NULL,
  `changes` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tx_orders`
--

INSERT INTO `tx_orders` (`id`, `customers_id`, `code`, `date`, `end_date`, `pay`, `changes`, `total`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '200320250001', '2025-03-20', '2025-03-20', 20000, 6000, 15000, 1, '2025-03-20 05:31:11', '2025-03-20 06:39:42', NULL),
(2, 2, '200320250002', '2025-03-20', '2025-03-22', 20000, 1000, 19000, 0, '2025-03-20 06:50:09', NULL, NULL),
(3, 3, '200320250003', '2025-03-20', '2025-03-20', 50000, 21000, 29000, 0, '2025-03-20 06:50:58', NULL, NULL),
(4, 4, '200320250004', '2025-03-20', '2025-03-20', 20000, 5000, 15000, 0, '2025-03-20 06:51:12', NULL, NULL),
(5, 5, '200320250005', '2025-03-20', '2025-03-20', 50000, 8500, 41500, 1, '2025-03-20 06:51:28', '2025-03-20 06:59:56', NULL),
(6, 6, '200320250006', '2025-03-20', '2025-03-20', 50000, 10000, 40000, 1, '2025-03-20 06:56:11', '2025-03-20 06:59:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tx_orders_d`
--

CREATE TABLE `tx_orders_d` (
  `id` int(11) NOT NULL,
  `orders_id` int(11) NOT NULL,
  `services_id` int(11) NOT NULL,
  `qty` double(16,2) NOT NULL,
  `subtotal` double(10,2) NOT NULL,
  `notes` text NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tx_orders_d`
--

INSERT INTO `tx_orders_d` (`id`, `orders_id`, `services_id`, `qty`, `subtotal`, `notes`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 1, 1, 1.00, 5000.00, 'a', 1, '2025-03-20 05:46:20', '2025-03-20 06:39:46', NULL),
(3, 1, 3, 2.00, 10000.00, 'b', 1, '2025-03-20 05:46:20', '2025-03-20 06:39:48', NULL),
(4, 2, 1, 1.00, 5000.00, 'd', 0, '2025-03-20 06:50:09', NULL, NULL),
(5, 2, 4, 2.00, 14000.00, 'v', 0, '2025-03-20 06:50:09', NULL, NULL),
(6, 3, 1, 3.00, 15000.00, 'a', 0, '2025-03-20 06:50:58', NULL, NULL),
(7, 3, 4, 2.00, 14000.00, 'd', 0, '2025-03-20 06:50:58', NULL, NULL),
(8, 4, 1, 3.00, 15000.00, 'a', 0, '2025-03-20 06:51:12', NULL, NULL),
(9, 5, 2, 3.00, 13500.00, 'a', 1, '2025-03-20 06:51:28', '2025-03-20 06:59:56', NULL),
(10, 5, 4, 4.00, 28000.00, 'd', 1, '2025-03-20 06:51:28', '2025-03-20 06:59:56', NULL),
(11, 6, 1, 1.50, 7500.00, 'a', 1, '2025-03-20 06:56:11', '2025-03-20 06:59:23', NULL),
(12, 6, 3, 2.70, 13500.00, 'b', 1, '2025-03-20 06:56:11', '2025-03-20 06:59:23', NULL),
(13, 6, 3, 3.80, 19000.00, 'c', 1, '2025-03-20 06:56:11', '2025-03-20 06:59:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tx_pickups`
--

CREATE TABLE `tx_pickups` (
  `id` int(11) NOT NULL,
  `customers_id` int(11) NOT NULL,
  `orders_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `notes` text NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tx_pickups`
--

INSERT INTO `tx_pickups` (`id`, `customers_id`, `orders_id`, `date`, `notes`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, '2025-03-20', 'Done ', 0, '2025-03-20 06:39:07', '2025-03-20 07:43:08', NULL),
(3, 6, 6, '2025-03-20', 'done', 1, '2025-03-20 06:59:05', NULL, NULL),
(5, 5, 5, '2025-03-20', 'done test', 1, '2025-03-20 06:59:56', '2025-03-20 07:17:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `level_id`, `name`, `email`, `password`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Administrator', 'admin@gmail.com', '194b0079b8f984e52128d624782f3fade738d08d', 1, '2025-03-18 09:30:40', '2025-03-18 09:30:56', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tx_orders`
--
ALTER TABLE `tx_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tx_orders_d`
--
ALTER TABLE `tx_orders_d`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tx_pickups`
--
ALTER TABLE `tx_pickups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tx_orders`
--
ALTER TABLE `tx_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tx_orders_d`
--
ALTER TABLE `tx_orders_d`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tx_pickups`
--
ALTER TABLE `tx_pickups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
