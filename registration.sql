-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2021 at 06:11 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `registration`
--

-- --------------------------------------------------------

--
-- Table structure for table `provincial`
--

CREATE TABLE `provincial` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `provincial`
--

INSERT INTO `provincial` (`id`, `name`) VALUES
(1, 'tokyo'),
(2, 'osaka'),
(3, 'VN');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_provin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_distri` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_house` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `code`, `address_provin`, `address_distri`, `address_house`, `phone`, `password`, `firstname`, `lastname`) VALUES
(202, 'truong11@gmail.com', '1234', '3', 'vn', 'vn', '0987654321', '25f9e794323b453885f5181f1b624d0b', 'Dinh', 'truong'),
(209, 'thuy@gmail.com', '123', '3', 'vn', 'vn', '0987654321', '25f9e794323b453885f5181f1b624d0b', 'Hoang', 'VanThuy'),
(212, 'thanh@gmail.com', '1234', '3', 'vn', 'vn', '0987654321', '25f9e794323b453885f5181f1b624d0b', 'Dinh', 'ThiKiem'),
(213, 'tung@gmail.com', '1234', '3', 'vn', 'vn', '0987654321', '25f9e794323b453885f5181f1b624d0b', 'Hoang', 'ThanhTung'),
(214, 'thuy@gmail.com', '1234', '3', 'vn', 'vn', '0987654321', '123456789', 'Trinh', 'thi'),
(222, 'h@gmail.com', '123', '3', 'vn', 'vn', '0987654321', '123456789', 'Dinh', 'thetruong'),
(223, 'd@gmail.com', '123', '3', 'vn', 'vn', '0987654321', '123456789', 'Dinh', 'thetruong'),
(224, 'm222@gmail.com', '1234', '2', 'NB', 'NB', '0987654321', '25f9e794323b453885f5181f1b624d0b', 'Dinh', 'thetruong'),
(225, 'giang@gmail.com', '123', '3', 'vn', 'vn', '0987654321', '123456789', 'Dinh', 'thetruong'),
(226, 'manh@gmail.com', '123', '3', 'vn', 'vn', '0987654321', '123456789', 'Dinh', 'thetruong'),
(227, 'hieu@gmail.com', '123', '3', 'vn', 'vn', '0987654321', '123456789', 'Dinh', 'thetruong'),
(228, 'Luyen@gmail.com', '1234', '1', 'Nd', 'nd', '0987654321', '25f9e794323b453885f5181f1b624d0b', 'Nguyen', 'VanLuyen');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `provincial`
--
ALTER TABLE `provincial`
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
-- AUTO_INCREMENT for table `provincial`
--
ALTER TABLE `provincial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=230;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
