-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2022 at 05:30 PM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tespack`
--

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `id` bigint(20) NOT NULL,
  `name` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'item_1', '2022-08-06 20:37:36', '2022-08-06 20:37:37'),
(2, 'item_2', '2022-08-06 20:37:50', '2022-08-06 20:37:51');

-- --------------------------------------------------------

--
-- Table structure for table `sub_item`
--

CREATE TABLE `sub_item` (
  `si_id` bigint(20) NOT NULL,
  `item_id` bigint(20) NOT NULL,
  `name` varchar(250) NOT NULL,
  `col_a` varchar(250) NOT NULL,
  `col_b` varchar(250) NOT NULL,
  `col_c` varchar(250) NOT NULL,
  `col_d` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_item`
--

INSERT INTO `sub_item` (`si_id`, `item_id`, `name`, `col_a`, `col_b`, `col_c`, `col_d`, `created_at`, `updated_at`) VALUES
(1, 1, 'sub_item_1', 'val_a', 'val_b', 'val_c', 'val_d', '2022-08-06 20:40:13', '2022-08-06 20:40:13'),
(2, 1, 'sub_item_2', 'val_a', 'val_b', 'val_c', 'val_d', '2022-08-06 20:40:26', '2022-08-06 20:40:26'),
(3, 1, 'sub_item_3', 'val_a', 'val_b', 'val_c', 'val_d', '2022-08-06 20:40:37', '2022-08-06 20:40:37'),
(4, 1, 'sub_item_4', 'val_a', 'val_b', 'val_c', 'val_d', '2022-08-06 20:40:46', '2022-08-06 20:40:46'),
(5, 1, 'sub_item_4', 'val_a', 'val_b', 'val_c', 'val_d', '2022-08-06 20:40:47', '2022-08-06 20:40:47'),
(6, 1, 'sub_item_5', 'val_a', 'val_b', 'val_c', 'val_d', '2022-08-06 20:41:01', '2022-08-06 20:41:01'),
(7, 1, 'sub_item_6', 'val_a', 'val_b', 'val_c', 'val_d', '2022-08-06 20:41:05', '2022-08-06 20:41:05'),
(8, 2, 'sub_item_1', 'val_a', 'val_b', 'val_c', 'val_d', '2022-08-06 20:41:21', '2022-08-06 20:41:21'),
(9, 2, 'sub_item_2', 'val_a', 'val_b', 'val_c', 'val_d', '2022-08-06 20:41:26', '2022-08-06 20:41:26'),
(10, 2, 'sub_item_3', 'val_a', 'val_b', 'val_c', 'val_d', '2022-08-06 20:41:30', '2022-08-06 20:41:30'),
(11, 2, 'sub_item_4', 'val_a', 'val_b', 'val_c', 'val_d', '2022-08-06 20:41:34', '2022-08-06 20:41:34'),
(12, 2, 'sub_item_5', 'val_a', 'val_b', 'val_c', 'val_d', '2022-08-06 20:41:39', '2022-08-06 20:41:39'),
(13, 2, 'sub_item_6', 'val_a', 'val_b', 'val_c', 'val_d', '2022-08-06 20:41:43', '2022-08-06 20:41:43'),
(14, 2, 'sub_item_7', 'val_a', 'val_b', 'val_c', 'val_d', '2022-08-06 21:03:05', '2022-08-06 21:03:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_item`
--
ALTER TABLE `sub_item`
  ADD PRIMARY KEY (`si_id`) USING BTREE,
  ADD KEY `FK_sub_item_item` (`item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sub_item`
--
ALTER TABLE `sub_item`
  MODIFY `si_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sub_item`
--
ALTER TABLE `sub_item`
  ADD CONSTRAINT `FK_sub_item_item` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
