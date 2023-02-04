-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 04, 2023 at 09:40 AM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `foodonline_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adm_id` int(222) NOT NULL,
  `username` varchar(222) NOT NULL,
  `password` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `code` varchar(222) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adm_id`, `username`, `password`, `email`, `code`, `date`) VALUES
(1, 'admin', 'CAC29D7A34687EB14B37068EE4708E7B', 'admin@mail.com', '', '2022-05-27 13:21:52'),
(2, 'foodjaguar', '$2y$10$BO/COk9RVY2jm5tCH3sT.uZxRwgXJvQMqgfOwIHCg6J5/0v18U5LO', 'foodjaguar.prmsu@gmail.com', '', '2023-01-27 06:52:00');

-- --------------------------------------------------------

--
-- Table structure for table `dishes`
--

CREATE TABLE `dishes` (
  `d_id` int(222) NOT NULL,
  `rs_id` int(222) NOT NULL,
  `title` varchar(222) NOT NULL,
  `slogan` longtext NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `img` varchar(222) NOT NULL,
  `d_stock` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dishes`
--

INSERT INTO `dishes` (`d_id`, `rs_id`, `title`, `slogan`, `price`, `img`, `d_stock`) VALUES
(1, 1, 'Pinakbet', 'Pinakbet is an indigenous Filipino dish from the northern regions of the Philippines. Pinakbet is made from mixed vegetables sautÃ©ed in fish or shrimp sauce. The word is the contracted from the Ilokano word pinakebbet, meaning \"shrunk\" or \"shriveled.\"', '100.00', '63ddf6f51787c.jpg', 0),
(2, 2, 'Sisig', 'Sisig is a Filipino dish made from parts of a pig\'s face and belly, and chicken liver which is usually seasoned with calamansi, onions, and chili peppers. It originates from the Pampanga region in Luzon. Sisig is a staple of Kapampangan cuisine. ', '150.00', '63ddf8677b7d6.jpg', 5),
(3, 3, 'Burger and Fries w/ small drink', '', '100.00', '63ddf956030e9.jpg', 20);

-- --------------------------------------------------------

--
-- Table structure for table `food_category`
--

CREATE TABLE `food_category` (
  `f_catid` int(11) NOT NULL,
  `f_catname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `food_category`
--

INSERT INTO `food_category` (`f_catid`, `f_catname`) VALUES
(1, 'Vegetable'),
(2, 'Meat'),
(3, 'Combo-Meal'),
(4, 'Student-Meal');

-- --------------------------------------------------------

--
-- Table structure for table `remark`
--

CREATE TABLE `remark` (
  `id` int(11) NOT NULL,
  `frm_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `remark` mediumtext NOT NULL,
  `remarkDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `remark`
--

INSERT INTO `remark` (`id`, `frm_id`, `status`, `remark`, `remarkDate`) VALUES
(1, 12, 'preparing', '', '2023-02-04 08:14:21'),
(2, 13, 'preparing', '', '2023-02-04 08:17:01'),
(3, 13, 'closed', 'Thank you for ordering!', '2023-02-04 08:17:21'),
(4, 14, '', '', '2023-02-04 08:34:41'),
(5, 14, 'preparing', '', '2023-02-04 09:26:16');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_settings`
--

CREATE TABLE `shipping_settings` (
  `id` int(11) NOT NULL,
  `s_fee` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shipping_settings`
--

INSERT INTO `shipping_settings` (`id`, `s_fee`) VALUES
(1, '15.00');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `site_name` varchar(220) NOT NULL,
  `site_tag` varchar(255) NOT NULL,
  `site_about` longtext NOT NULL,
  `site_logo` varchar(220) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `site_name`, `site_tag`, `site_about`, `site_logo`) VALUES
(2, 'Food Jaguar', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad libero accusamus, velit magni cum voluptatum ea repudiandae ipsa voluptates nihil labore enim laborum ullam expedita provident commodi aliquam. Laboriosam, beatae?', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Perferendis tempora minus vitae officiis harum fugit! Illum facilis in quo eaque dicta asperiores laboriosam provident fugiat accusantium architecto blanditiis, inventore ex! Incidunt quis unde odit harum, quo facilis culpa delectus voluptates ex impedit libero distinctio recusandae itaque ipsum assumenda provident quam, dolorem, numquam cum corporis! Illum eum cum adipisci voluptatem nihil! Quia debitis dolorum itaque molestiae, neque sequi vitae nobis voluptatibus minus omnis iusto corrupti inventore nihil temporibus iure mollitia dolore reprehenderit ab id excepturi autem impedit? Accusantium quis ut incidunt. Illo suscipit magni ratione. Facilis cumque, hic voluptatum quo numquam quis dolor debitis neque, iure necessitatibus officia, ipsum modi aut. Perferendis dicta neque explicabo labore quas autem blanditiis nam! Eos! Reprehenderit dolorum delectus, tempore expedita cum culpa illo non magni quas qui tenetur laboriosam ipsum aut, odio, fugiat sint nobis corrupti repudiandae sed commodi. Culpa officiis consequatur soluta beatae odit?', '63dddd8e15bb1.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(222) NOT NULL,
  `username` varchar(222) NOT NULL,
  `f_name` varchar(222) NOT NULL,
  `l_name` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `phone` varchar(222) NOT NULL,
  `password` varchar(222) NOT NULL,
  `address` text NOT NULL,
  `u_vcode` varchar(100) NOT NULL,
  `u_verify` text NOT NULL,
  `status` int(222) NOT NULL DEFAULT '1',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `username`, `f_name`, `l_name`, `email`, `phone`, `password`, `address`, `u_vcode`, `u_verify`, `status`, `date`) VALUES
(2, 'foodjaguar', 'Food', 'Jaguar', 'foodjaguar@gmail.com', '09123456789', '$2y$10$6PCYBXtddqrM7NiM3P8u7eWZBVL3yolQvsrjJAvr.Yzo9TlC7U9hW', 'PRMSU', '0', 'Yes', 1, '2023-02-04 05:30:19'),
(5, 'user1', 'User', 'One', 'user1@gmail.com', '0945461421', '$2y$10$28TshhczVTA5X8hQfdM08.eYJ.ks7J5kFCwM5mVWFd8/3PqMWaKl.', 'Iba Zambales', '0', 'Yes', 1, '2023-02-04 09:25:46');

-- --------------------------------------------------------

--
-- Table structure for table `user_orders`
--

CREATE TABLE `user_orders` (
  `o_id` int(11) NOT NULL,
  `u_id` int(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `original_price` decimal(10,2) NOT NULL,
  `mop` varchar(255) NOT NULL,
  `s_fee` decimal(10,2) NOT NULL,
  `s_address` varchar(255) NOT NULL,
  `original_address` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `order_number` int(255) NOT NULL,
  `date` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_orders`
--

INSERT INTO `user_orders` (`o_id`, `u_id`, `title`, `quantity`, `price`, `original_price`, `mop`, `s_fee`, `s_address`, `original_address`, `status`, `order_number`, `date`) VALUES
(1, 2, 'Sisig', 1, '150.00', '150.00', 'pick-up', '0.00', '', 'PRMSU', 'rejected', 1, '2023-02-03 23:08:25'),
(2, 2, 'Sisig', 1, '150.00', '150.00', 'deliver', '5.00', '', 'PRMSU', 'rejected', 2, '2023-02-03 23:08:39'),
(3, 2, 'Burger and Fries w/ small drink', 2, '200.00', '100.00', 'deliver', '10.00', '', 'PRMSU', 'rejected', 3, '2023-02-03 23:10:04'),
(4, 2, 'Pinakbet', 2, '200.00', '100.00', 'pick-up', '0.00', '', 'PRMSU', 'rejected', 4, '2023-02-03 23:17:10'),
(5, 2, 'Pinakbet', 2, '200.00', '100.00', 'deliver', '10.00', '', 'PRMSU', 'rejected', 5, '2023-02-03 23:19:05'),
(6, 2, 'Pinakbet', 2, '200.00', '100.00', 'deliver', '10.00', '', 'PRMSU', 'rejected', 6, '2023-02-03 23:21:23'),
(7, 2, 'Burger and Fries w/ small drink', 1, '100.00', '100.00', 'deliver', '10.00', '', 'PRMSU', 'rejected', 7, '2023-02-03 23:31:39'),
(8, 2, 'Burger and Fries w/ small drink', 1, '100.00', '100.00', 'deliver', '10.00', '', 'PRMSU', 'rejected', 8, '2023-02-03 23:32:21'),
(9, 2, 'Burger and Fries w/ small drink', 1, '100.00', '100.00', 'deliver', '10.00', '', 'PRMSU', 'rejected', 9, '2023-02-03 23:40:41'),
(10, 2, 'Burger and Fries w/ small drink', 1, '100.00', '100.00', 'deliver', '10.00', '', 'PRMSU', 'rejected', 10, '2023-02-03 23:42:03'),
(11, 2, 'Pinakbet', 2, '200.00', '100.00', 'deliver', '10.00', '', 'PRMSU', 'rejected', 11, '2023-02-03 23:43:21'),
(12, 2, 'Sisig', 2, '300.00', '150.00', 'deliver', '10.00', '', 'PRMSU', 'rejected', 11, '2023-02-03 23:43:21'),
(13, 2, 'Sisig', 5, '750.00', '150.00', 'deliver', '10.00', '', 'PRMSU', 'preparing', 12, '2023-02-03 23:47:14'),
(14, 2, 'Pinakbet', 2, '200.00', '100.00', 'deliver', '10.00', '', 'PRMSU', 'closed', 13, '2023-02-04 00:12:49'),
(15, 2, 'Sisig', 1, '150.00', '150.00', 'deliver', '10.00', 'ccit building', 'PRMSU', 'preparing', 14, '2023-02-04 00:34:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adm_id`);

--
-- Indexes for table `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`d_id`);

--
-- Indexes for table `food_category`
--
ALTER TABLE `food_category`
  ADD PRIMARY KEY (`f_catid`);

--
-- Indexes for table `remark`
--
ALTER TABLE `remark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_settings`
--
ALTER TABLE `shipping_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- Indexes for table `user_orders`
--
ALTER TABLE `user_orders`
  ADD PRIMARY KEY (`o_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adm_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dishes`
--
ALTER TABLE `dishes`
  MODIFY `d_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `food_category`
--
ALTER TABLE `food_category`
  MODIFY `f_catid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `remark`
--
ALTER TABLE `remark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `shipping_settings`
--
ALTER TABLE `shipping_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_orders`
--
ALTER TABLE `user_orders`
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
