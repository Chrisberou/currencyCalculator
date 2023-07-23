-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 23, 2023 at 01:37 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `currency_calculator`
--

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `id` int(11) NOT NULL,
  `code` varchar(3) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `code`, `name`) VALUES
(1, 'USD', 'US Dollar'),
(2, 'EUR', 'Euro'),
(3, 'GBP', 'British Pound'),
(4, 'CHF', 'Swiss Franc'),
(5, 'CAD', 'Canadian Dollar'),
(6, 'JPY', 'Japanese Yen');

-- --------------------------------------------------------

--
-- Table structure for table `exchange_rate`
--

CREATE TABLE `exchange_rate` (
  `id` int(11) NOT NULL,
  `base_currency` varchar(255) NOT NULL,
  `target_currency` varchar(255) NOT NULL,
  `rate` decimal(10,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exchange_rate`
--

INSERT INTO `exchange_rate` (`id`, `base_currency`, `target_currency`, `rate`) VALUES
(1, 'Euro', 'US Dollar', '1.3764'),
(2, 'Euro', 'Swiss Franc', '1.2079'),
(3, 'Euro', 'British Pound', '0.8731'),
(4, 'US Dollar', 'JPY', '76.7200'),
(5, 'Swiss Franc', 'US Dollar', '1.1379'),
(6, 'British Pound', 'CAD', '1.5648'),
(7, 'Euro', 'JPY', '76.7200'),
(8, 'US Dollar', 'Euro', '0.7265'),
(9, 'US Dollar', 'Swiss Franc', '0.8279'),
(10, 'US Dollar', 'British Pound', '1.1453'),
(11, 'Swiss Franc', 'Euro', '0.8279'),
(12, 'Swiss Franc', 'US Dollar', '0.8788'),
(13, 'Swiss Franc', 'British Pound', '0.6391'),
(14, 'British Pound', 'Euro', '1.1453'),
(15, 'British Pound', 'US Dollar', '0.6391'),
(16, 'British Pound', 'Swiss Franc', '0.6391');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `isLogged` tinyint(1) DEFAULT 0,
  `admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `isLogged`, `admin`) VALUES
(1, 'test@test.com', '1234', 0, 0),
(2, 'testadmin@testadmin.com', '1234', 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exchange_rate`
--
ALTER TABLE `exchange_rate`
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
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `exchange_rate`
--
ALTER TABLE `exchange_rate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
