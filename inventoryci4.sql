-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 03, 2022 at 01:48 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventoryci4`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`id`, `category_name`, `description`, `date_added`) VALUES
(3, 'qweqwehaha', 'haawqwe', '2022-10-31 20:00:00'),
(5, 'pagkain', 'pagkain lang', '2022-11-01 09:50:08');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

CREATE TABLE `tbl_products` (
  `id` int(11) NOT NULL,
  `product_id` varchar(100) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `category` varchar(255) NOT NULL,
  `product_qty` decimal(10,0) NOT NULL,
  `supplier` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `product_image` text NOT NULL,
  `buying_price` int(11) NOT NULL,
  `selling_price` int(11) NOT NULL,
  `product_total_price` int(11) DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_products`
--

INSERT INTO `tbl_products` (`id`, `product_id`, `product_name`, `category`, `product_qty`, `supplier`, `description`, `product_image`, `buying_price`, `selling_price`, `product_total_price`, `date_added`) VALUES
(3, 'PID-98DCD8', 'hotdogo', 'pagkain', '6512', 'patrick', 'hotdog boi', 'no_image.jpg', 20, 22, 143264, '2022-11-01 09:54:52'),
(4, 'PID-EEB54D', 'qwe', 'qweqwehaha', '2199', 'qwe', 'qwe', 'no_image.jpg', 22, 22, 48378, '2022-11-01 10:35:26'),
(5, 'PID-1DC047', 'qwe1', 'pagkain', '1', 'qwe', 'qwe', '1667270197_c4b192fdeb4dd5e8da68.jpeg', 22, 1, 1, '2022-11-01 10:36:37'),
(6, 'PID-DA8376', 'haha', 'pagkain', '1', 'ewan', 'qwe', 'no_image.jpg', 20, 40, 40, '2022-11-01 19:29:34');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sales`
--

CREATE TABLE `tbl_sales` (
  `id` int(11) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `product_name` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `number_of_orders` int(11) NOT NULL,
  `purchase_total_price` int(11) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_sales`
--

INSERT INTO `tbl_sales` (`id`, `transaction_id`, `product_name`, `customer_name`, `number_of_orders`, `purchase_total_price`, `date_added`) VALUES
(1, 'TID-1C9E7C', 3, 'edward', 5, 110, '2022-11-01 19:43:34'),
(2, 'TID-DC9B98', 4, 'qwe', 2, 44, '2022-11-02 09:31:47'),
(3, 'TID-7865ED', 4, 'qwe', 20, 440, '2022-11-02 09:41:07'),
(4, 'TID-4463F0', 5, 'qwe', 20, 440, '2022-11-02 09:41:30'),
(5, 'TID-61DE4F', 5, 'qwe', 99, 2178, '2022-11-02 09:42:42'),
(6, 'TID-B59394', 4, 'qwe', 0, 0, '2022-11-02 09:44:18'),
(7, 'TID-207314', 4, 'qwe', 1, 22, '2022-11-02 09:45:44');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `contact` int(11) NOT NULL,
  `position` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `profile` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `user_id`, `first_name`, `last_name`, `contact`, `position`, `email`, `password`, `date_added`, `profile`) VALUES
(1, 'UID-8F7FDB', 'edward', 'aguilar', 12345678, 'admin', 'edward@email.com', '$2y$10$SiPMFFxSn.P3E404bryNGOXH40CmkBOcw4qmINFWHGSYtcQg.MPWi', '2022-11-01 07:36:02', '1667259362_6330a6d3ea45bb03a1a6.jpg'),
(2, 'UID-E813EC', 'qwe', 'qwe', 1123, 'employee', 'qwe@email.com', '$2y$10$nIXIDvJ9DfBXIA9kQ6WZ.OUn3GCqGCAc7cksOQa8Vg1X2qc5c4VIK', '2022-11-02 20:15:00', 'user_male.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `catergory_name` (`category_name`);

--
-- Indexes for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`,`product_name`,`category`,`product_qty`),
  ADD KEY `buying_price` (`buying_price`,`selling_price`,`date_added`);

--
-- Indexes for table `tbl_sales`
--
ALTER TABLE `tbl_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `first_name` (`first_name`),
  ADD KEY `last_name` (`last_name`,`position`,`email`),
  ADD KEY `date_added` (`date_added`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_products`
--
ALTER TABLE `tbl_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_sales`
--
ALTER TABLE `tbl_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
