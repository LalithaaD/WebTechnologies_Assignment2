-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2024 at 08:21 PM
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
-- Database: `assignment2`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `Products` varchar(200) NOT NULL,
  `Quantities` int(50) NOT NULL,
  `User` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`Products`, `Quantities`, `User`) VALUES
('Product1,Product2', 0, '1'),
('Product1,Product2', 0, '1'),
('Product1,Product2', 0, '1'),
('Product1,Product2', 0, '1'),
('Product1,Product2', 0, '1'),
('Product1,Product2', 0, '1'),
('Product1,Product2', 0, '1'),
('Product1,Product2', 2, '1'),
('Product1,Product2', 2, '1'),
('Product1,Product2', 2, '1'),
('Product1,Product2', 0, '1'),
('Product1,Product2', 0, '1'),
('Product1,Product2', 2, ''),
('Product1,Product2', 2, ''),
('Product1,Product2', 2, ''),
('Product1,Product2', 2, ''),
('Product1,Product2', 2, ''),
('Product1,Product2', 2, ''),
('Product1,Product2', 2, ''),
('Product1,Product2', 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `Product` varchar(50) NOT NULL,
  `User` text NOT NULL,
  `Rating` int(5) NOT NULL,
  `Image` varbinary(10) NOT NULL,
  `Text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`Product`, `User`, `Rating`, `Image`, `Text`) VALUES
('1', '1', 5, '', 'This is a great product!'),
('1', '1', 5, '', 'This is a great product!'),
('1', '1', 5, '', 'This is a great product!'),
('1', '1', 5, '', 'This is a great product!'),
('1', '1', 5, '', 'This is a great product!'),
('1', '1', 5, '', 'This is a great product!'),
('1', '1', 5, '', 'This is a great product!'),
('1', '1', 5, '', 'This is a great product!'),
('1', '1', 5, '', 'This is a great product!');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `user_id` int(11) NOT NULL,
  `products` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`user_id`, `products`, `id`) VALUES
(1, 0, 0),
(1, 0, 0),
(1, 0, 0),
(1, 0, 0),
(1, 0, 0),
(1, 0, 0),
(1, 0, 0),
(1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `Description` text NOT NULL,
  `Image` text NOT NULL,
  `Pricing` int(200) NOT NULL,
  `ShippingCost` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `Description`, `Image`, `Pricing`, `ShippingCost`) VALUES
(0, 'New Product', 'new_product.jpg', 50, 0),
(0, 'Updated Product', 'updated_product.jpg', 60, 0),
(0, 'Updated Product', 'updated_product.jpg', 60, 0),
(0, 'Updated Product', 'updated_product.jpg', 60, 0),
(0, 'Updated Product', 'updated_product.jpg', 60, 0),
(0, 'Updated Product', 'updated_product.jpg', 60, 0),
(0, 'Updated Product', 'updated_product.jpg', 60, 0),
(0, '', '', 0, 0),
(0, '', '', 0, 0),
(0, 'Updated Product', 'updated_product.jpg', 60, 0),
(0, 'Updated Product', 'updated_product.jpg', 60, 0),
(0, 'Updated Product', 'updated_product.jpg', 60, 0),
(0, 'Updated Product', 'updated_product.jpg', 60, 0),
(0, 'Updated Product', 'updated_product.jpg', 60, 0),
(0, 'Updated Product', 'updated_product.jpg', 60, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Password` varchar(18) NOT NULL,
  `Username` varchar(20) NOT NULL,
  `Purchase History` varchar(50) NOT NULL,
  `Shipping Address` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `Email`, `Password`, `Username`, `Purchase History`, `Shipping Address`) VALUES
(8, 'newuser2@example.com', 'password1234', 'NewUser2', '', ''),
(16, 'newuser3@example.com', 'password1234', 'NewUser2', '', ''),
(17, 'user4@example.com', 'password123', 'NewUser', '', ''),
(18, 'user4@example.com', 'password123', 'NewUser', '', ''),
(19, 'user4@example.com', 'password123', 'NewUser', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
