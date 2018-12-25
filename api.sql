-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 25, 2018 at 08:34 PM
-- Server version: 10.1.34-MariaDB-0ubuntu0.18.04.1
-- PHP Version: 7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `api`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `enabled`, `slug`, `description`, `position`, `created_at`, `updated_at`) VALUES
(1, 'Electrónica', 1, 'electronica', NULL, NULL, '2018-12-25 18:42:04', '2018-12-25 18:42:04'),
(2, 'Libros', 1, 'libros', NULL, NULL, '2018-12-25 18:42:05', '2018-12-25 18:42:05'),
(3, 'Moda', 1, 'moda', NULL, NULL, '2018-12-25 18:42:05', '2018-12-25 18:42:05');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `enabled` tinyint(1) NOT NULL,
  `length` decimal(10,2) DEFAULT NULL,
  `photo` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `user_id`, `name`, `description`, `enabled`, `length`, `photo`, `updated_at`, `created_at`) VALUES
(1, 1, 1, 'Iphone 6', 'mobile', 1, '299.00', '/uploads/img/iphone.jpg', '2018-12-25 19:23:37', '2018-12-25 19:23:37'),
(2, 1, 1, 'Iphone 7', 'mobile', 1, '349.00', '/uploads/img/iphone7.jpg', '2018-12-25 19:26:34', '2018-12-25 19:26:34'),
(3, 1, 1, 'Iphone 8', 'mobile', 1, '599.00', '/uploads/img/iphone8.jpg', '2018-12-25 19:26:53', '2018-12-25 19:26:53'),
(4, 2, 1, 'Restfull', 'restfull', 1, '25.00', '/uploads/img/restull.jpg', '2018-12-25 19:28:11', '2018-12-25 19:28:11'),
(5, 3, 1, 'zapatilla adidas', 'zapatailla deporte adidas', 1, '49.00', '/uploads/img/zapatilla-adidas.jpg', '2018-12-25 19:29:24', '2018-12-25 19:29:24');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `roles` varchar(1000) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `username`, `password`, `roles`, `created_at`, `updated_at`) VALUES
(1, 'Federico Martín', 'federico@api.com', 'federico', '5GEsbV329dS/hk4pnfXmy5Z/LDz6UUKrMBHw3ulAd1SmvPHJ8zm91Mg7pIZBgULPUByqVOkhTA9y4irxoQIqEA==', '[]', '2018-12-25 18:33:25', '2018-12-25 18:33:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5C6DD74E12469DE2` (`category_id`),
  ADD KEY `products_user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
