-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2021 at 04:42 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(50) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Gadget'),
(2, 'Sports'),
(3, 'Accessories'),
(4, 'Stationary'),
(12, 'mask');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `username` varchar(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL,
  `first_name` varchar(128) NOT NULL,
  `last_name` varchar(118) NOT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `birthdate` date NOT NULL,
  `registration_date_time` datetime NOT NULL DEFAULT current_timestamp(),
  `account_status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`username`, `email`, `password`, `first_name`, `last_name`, `gender`, `birthdate`, `registration_date_time`, `account_status`) VALUES
('ew', 'elliewong1125@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'd', 'wong', 1, '2001-01-08', '2021-11-27 15:59:45', 1),
('ewew', 'ellietheelai@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'c', 'wong', 1, '2001-01-08', '2021-11-27 16:03:52', 1),
('jonas', 'elliewong1125@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'b', 'wong', 0, '1999-11-18', '2021-11-27 16:28:03', 1),
('qw', 'wq1125@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Ellie', 'wong', 0, '1999-02-10', '2021-11-28 16:24:59', 0),
('tim', 'klahtao@gmail.com', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'tim', 'wong', 0, '1899-11-18', '2021-11-28 16:22:54', 1),
('wq', 'wq@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'a', 'wong', 0, '1999-11-10', '2021-11-27 16:29:29', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `orderdetail_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`orderdetail_id`, `order_id`, `product_id`, `quantity`) VALUES
(1, 49, 6, 1),
(2, 49, 6, 1),
(3, 49, 4, 2),
(4, 49, 4, 2),
(5, 49, 1, 3),
(6, 51, 8, 1),
(7, 51, 5, 2),
(8, 51, 3, 3),
(9, 52, 8, 1),
(10, 52, 6, 2),
(11, 52, 3, 3),
(12, 52, 4, 2),
(13, 52, 7, 1),
(14, 53, 8, 2),
(15, 53, 6, 3),
(16, 57, 5, 2),
(17, 58, 8, 2),
(18, 58, 8, 3),
(19, 59, 10, 2),
(20, 60, 5, 1),
(21, 60, 8, 3),
(22, 60, 7, 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(20) NOT NULL,
  `customer` varchar(50) NOT NULL,
  `order_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer`, `order_datetime`) VALUES
(49, 'jonas', '2021-12-15 02:04:28'),
(50, 'jonas', '2021-12-15 02:04:28'),
(51, 'tim', '2021-12-15 02:07:14'),
(52, 'qw', '2021-12-15 02:09:51'),
(53, 'ewew', '2021-12-15 02:48:08'),
(57, 'jonas', '2021-12-15 03:16:12'),
(58, 'qw', '2021-12-15 03:30:20'),
(59, 'tim', '2021-12-20 05:32:57'),
(60, 'qw', '2021-12-20 07:22:21');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `category` int(50) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `promotion_price` decimal(10,2) NOT NULL,
  `manufacture_date` date NOT NULL,
  `expired_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `description`, `price`, `created`, `modified`, `promotion_price`, `manufacture_date`, `expired_date`) VALUES
(1, 'Basketball', 2, 'A ball used in the NBA.', '50.00', '2015-08-02 12:04:03', '2021-12-01 02:58:31', '0.00', '0000-00-00', '0000-00-00'),
(3, 'Gatorade', 2, 'This is a very good drink for athletes.', '2.00', '2015-08-02 12:14:29', '2021-12-01 02:58:31', '0.00', '0000-00-00', '0000-00-00'),
(4, 'Eye Glasses', 3, 'It will make you read better.', '6.00', '2015-08-02 12:15:04', '2021-12-01 02:59:44', '0.00', '0000-00-00', '0000-00-00'),
(5, 'Trash Can', 3, 'It will help you maintain cleanliness.', '4.00', '2015-08-02 12:16:08', '2021-12-01 02:59:44', '0.00', '0000-00-00', '0000-00-00'),
(6, 'Mouse', 1, 'Very useful if you love your computer.', '11.00', '2015-08-02 12:17:58', '2021-12-01 03:00:46', '0.00', '0000-00-00', '0000-00-00'),
(7, 'Earphone', 1, 'You need this one if you love music.', '7.00', '2015-08-02 12:18:21', '2021-12-01 03:00:46', '0.00', '0000-00-00', '0000-00-00'),
(8, 'Pillow', 3, 'Sleeping well is important and a pillow is one of the essentials.', '9.00', '2015-08-02 12:18:56', '2021-12-01 02:59:44', '0.00', '0000-00-00', '0000-00-00'),
(10, 'Pencil', 4, 'Use to write', '3.00', '2021-10-21 05:09:24', '2021-12-01 03:00:35', '0.00', '0000-00-00', '0000-00-00'),
(43, 'f', 3, 'sdf', '9.00', '2021-12-14 09:44:13', '2021-12-14 08:44:13', '7.00', '2021-12-01', '2022-01-01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`orderdetail_id`),
  ADD KEY `orderdetail_fk_constraint` (`order_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `order_fk_constraint` (`customer`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_FK_constraint` (`category`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `orderdetail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetail_fk_constraint` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `order_fk_constraint` FOREIGN KEY (`Customer`) REFERENCES `customers` (`username`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `product_FK_constraint` FOREIGN KEY (`category`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
