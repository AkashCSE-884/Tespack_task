-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2022 at 03:48 PM
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
  `id` bigint(20) NOT NULL,
  `si_id` varchar(50) NOT NULL,
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

INSERT INTO `sub_item` (`id`, `si_id`, `item_id`, `name`, `col_a`, `col_b`, `col_c`, `col_d`, `created_at`, `updated_at`) VALUES
(1, '01', 1, '', 'valA', 'valB', 'valC', 'valD', '2022-08-12 19:47:11', '2022-08-12 19:47:11'),
(2, '02', 1, '', 'valA', 'valB', 'valC', 'valD', '2022-08-12 19:47:11', '2022-08-12 19:47:11'),
(3, '03', 1, '', 'valA', 'valB', 'valC', 'valD', '2022-08-12 19:47:11', '2022-08-12 19:47:11'),
(4, '04', 1, '', 'valA', 'valB', 'valC', 'valD', '2022-08-12 19:47:11', '2022-08-12 19:47:11'),
(5, '05', 1, '', 'valA', 'valB', 'valC', 'valD', '2022-08-12 19:47:11', '2022-08-12 19:47:11'),
(6, '06', 1, '', 'valA', 'valB', 'valC', 'valD', '2022-08-12 19:47:11', '2022-08-12 19:47:11'),
(7, '07', 2, '', 'valA', 'valB', 'valC', 'valD', '2022-08-12 19:47:55', '2022-08-12 19:47:55'),
(8, '08', 2, '', 'valA', 'valB', 'valC', 'valD', '2022-08-12 19:47:55', '2022-08-12 19:47:55'),
(9, '09', 2, '', 'valA', 'valB', 'valC', 'valD', '2022-08-12 19:47:55', '2022-08-12 19:47:55'),
(10, '10', 2, '', 'valA', 'valB', 'valC', 'valD', '2022-08-12 19:47:55', '2022-08-12 19:47:55'),
(11, '11', 2, '', 'valA', 'valB', 'valC', 'valD', '2022-08-12 19:47:55', '2022-08-12 19:47:55'),
(12, '12', 2, '', 'valA', 'valB', 'valC', 'valD', '2022-08-12 19:47:55', '2022-08-12 19:47:55');

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `si_id` (`si_id`),
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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
