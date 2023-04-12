-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 12, 2023 at 07:18 AM
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
-- Database: `foodjaguar_db`
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
  `type` enum('admin','canteen') NOT NULL,
  `code` varchar(222) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adm_id`, `username`, `password`, `email`, `type`, `code`, `date`) VALUES
(1, 'admin', 'CAC29D7A34687EB14B37068EE4708E7B', 'admin@mail.com', 'admin', '', '2022-05-27 13:21:52'),
(2, 'foodjaguar', '$2y$10$BO/COk9RVY2jm5tCH3sT.uZxRwgXJvQMqgfOwIHCg6J5/0v18U5LO', 'foodjaguar.prmsu@gmail.com', 'admin', '', '2023-02-20 08:42:14');

-- --------------------------------------------------------

--
-- Table structure for table `canteen_table`
--

CREATE TABLE `canteen_table` (
  `id` int(11) NOT NULL,
  `canteen_name` varchar(255) NOT NULL,
  `c_oname` varchar(255) NOT NULL,
  `c_phone` varchar(255) NOT NULL,
  `c_email` varchar(255) NOT NULL,
  `c_user` varchar(255) NOT NULL,
  `c_pass` varchar(255) NOT NULL,
  `c_address` varchar(255) NOT NULL,
  `type` enum('admin','canteen') NOT NULL,
  `c_status` enum('1','0') NOT NULL,
  `c_verify` enum('Yes','No') NOT NULL,
  `c_email_sent` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `canteen_table`
--

INSERT INTO `canteen_table` (`id`, `canteen_name`, `c_oname`, `c_phone`, `c_email`, `c_user`, `c_pass`, `c_address`, `type`, `c_status`, `c_verify`, `c_email_sent`) VALUES
(1, 'Food Jaguar', 'Food Jaguar', '09452365780', 'fj.prmsu@gmail.com', 'foodjaguar', '$2y$10$BLxgeAcsbzubtQe08fEgReDu6KY.RMWQbcfezF7IbbJNluRVHXQEW', 'PRMSU - IBA', 'canteen', '0', 'Yes', ''),
(2, 'Jollikod', 'John Doe', '09452365789', 'johndoe@gmail.com', 'jollikod', '$2y$10$BLxgeAcsbzubtQe08fEgReDu6KY.RMWQbcfezF7IbbJNluRVHXQEW', 'PRMSU - IBA', 'canteen', '0', 'Yes', '');

-- --------------------------------------------------------

--
-- Table structure for table `dishes`
--

CREATE TABLE `dishes` (
  `d_id` int(222) NOT NULL,
  `rs_id` int(222) NOT NULL,
  `c_id` int(11) NOT NULL,
  `title` varchar(222) NOT NULL,
  `slogan` longtext NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `img` varchar(222) NOT NULL,
  `d_stock` int(255) NOT NULL,
  `d_status` enum('Post','Draft') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dishes`
--

INSERT INTO `dishes` (`d_id`, `rs_id`, `c_id`, `title`, `slogan`, `price`, `img`, `d_stock`, `d_status`) VALUES
(1, 1, 1, 'Pinakbet', 'Pinakbet is an indigenous Filipino dish from the northern regions of the Philippines. Pinakbet is made from mixed vegetables sautÃ©ed in fish or shrimp sauce. The word is the contracted from the Ilokano word pinakebbet, meaning \"shrunk\" or \"shriveled.\"', '100.00', '63ddf6f51787c.jpg', 0, 'Post'),
(2, 5, 1, 'Sisig', 'Sisig is a Filipino dish made from parts of a pig\'s face and belly, and chicken liver which is usually seasoned with calamansi, onions, and chili peppers. It originates from the Pampanga region in Luzon. Sisig is a staple of Kapampangan cuisine. ', '150.00', '63ddf8677b7d6.jpg', 15, 'Post'),
(3, 2, 1, 'Adobong Manok', 'Chicken adobo, also known as adobong manok, is a quintessential filipino braised chicken, marinated and stewed with vinegar, soy sauce, garlic, bay leaves, black peppercorns. The word adobo actually came from the spanish word \"adobar,\" meaning to marinate or pickle', '50.00', '63e8735d5d30c.jpg', 20, 'Post'),
(4, 3, 1, 'Pan-Fried Sesame Garlic Tofu', 'Soy sauce, honey, sesame oil, sambal oelek, rice wine vinegar', '100.00', '6422b7c1b4f37.jpg', 20, 'Post'),
(5, 2, 1, 'Kare-kare Bagnet', 'Kare Kare is a type of Filipino stew with a rich and thick peanut sauce. It is a popular dish in the Philippines served during special occasions.', '120.00', '642e1d5a70dea.jpg', 10, 'Post'),
(6, 2, 1, 'Bicol Express', 'Bicol Express, known natively in Bikol as sinilihan, is a popular Filipino dish which was popularized in the district of Malate, Manila but made in traditional Bicolano style.', '80.00', '642e1e294c048.jpg', 10, 'Post'),
(7, 5, 1, 'Dinuguan', 'Dinuguan is a Filipino savory stew usually of pork offal and/or meat simmered in a rich, spicy dark gravy of pig blood, garlic, chili, and vinegar.', '100.00', '642e1ebade2b4.jpg', 10, 'Post'),
(8, 3, 1, 'Sinigang', 'Sinigang is a Filipino soup or stew characterized by its sour and savory taste. It is most often associated with tamarind, although it can use other sour fruits and leaves as the souring agent. It is one of the more popular dishes in Filipino cuisine. The soup is usually accompanied by rice.', '100.00', '642e22f7f3d2a.jpg', 10, 'Post'),
(9, 5, 1, 'Lumpia', 'Lumpia are various types of spring rolls commonly found in the Philippines and Indonesia. Lumpia are made of thin paper-like or crepe-like pastry skin called \"lumpia wrapper\" enveloping savory or sweet fillings. It is often served as an appetizer or snack, and might be served deep-fried or fresh.', '30.00', '642e2359c5467.jpg', 10, 'Post'),
(10, 5, 2, 'Dinuguan', '', '100.00', '642e2bb0e98b4.jpg', 10, 'Post');

-- --------------------------------------------------------

--
-- Table structure for table `fave_table`
--

CREATE TABLE `fave_table` (
  `id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `d_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(4, 'Student-Meal'),
(5, 'Best-Seller');

-- --------------------------------------------------------

--
-- Table structure for table `remark`
--

CREATE TABLE `remark` (
  `id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `frm_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `remark` mediumtext NOT NULL,
  `remarkDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `remark`
--

INSERT INTO `remark` (`id`, `c_id`, `frm_id`, `status`, `remark`, `remarkDate`) VALUES
(1, 0, 12, 'preparing', '', '2023-02-04 08:14:21'),
(2, 0, 13, 'preparing', '', '2023-02-04 08:17:01'),
(3, 0, 13, 'closed', 'Thank you for ordering!', '2023-02-04 08:17:21'),
(4, 0, 14, '', '', '2023-02-04 08:34:41'),
(5, 0, 14, 'preparing', '', '2023-02-04 09:26:16'),
(6, 1, 5, 'preparing', '', '2023-02-05 13:18:06'),
(7, 1, 5, 'in process', '', '2023-02-05 13:18:12'),
(8, 1, 5, 'closed', '', '2023-02-05 13:18:16'),
(9, 1, 3, 'preparing', '', '2023-02-12 09:15:08'),
(10, 1, 3, 'closed', 'Thanks for ordering!', '2023-02-12 09:34:31'),
(11, 1, 1, 'preparing', '', '2023-03-04 00:58:44'),
(12, 1, 1, '', 'Thanks for ordering', '2023-03-04 01:05:45'),
(13, 1, 6, 'preparing', '', '2023-03-04 01:30:49');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_settings`
--

CREATE TABLE `shipping_settings` (
  `id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `s_fee` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shipping_settings`
--

INSERT INTO `shipping_settings` (`id`, `c_id`, `s_fee`) VALUES
(1, 1, '15.00');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `site_name` varchar(220) NOT NULL,
  `site_tag` varchar(255) NOT NULL,
  `site_about` longtext NOT NULL,
  `site_email` varchar(255) NOT NULL,
  `site_phone` varchar(100) NOT NULL,
  `site_best` varchar(100) NOT NULL,
  `site_logo` varchar(220) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `site_name`, `site_tag`, `site_about`, `site_email`, `site_phone`, `site_best`, `site_logo`) VALUES
(2, 'Food Jaguar', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad libero accusamus, velit magni cum voluptatum ea repudiandae ipsa voluptates nihil labore enim laborum ullam expedita provident commodi aliquam. Laboriosam, beatae?', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Perferendis tempora minus vitae officiis harum fugit! Illum facilis in quo eaque dicta asperiores laboriosam provident fugiat accusantium architecto blanditiis, inventore ex! Incidunt quis unde odit harum, quo facilis culpa delectus voluptates ex impedit libero distinctio recusandae itaque ipsum assumenda provident quam, dolorem, numquam cum corporis! Illum eum cum adipisci voluptatem nihil! Quia debitis dolorum itaque molestiae, neque sequi vitae nobis voluptatibus minus omnis iusto corrupti inventore nihil temporibus iure mollitia dolore reprehenderit ab id excepturi autem impedit? Accusantium quis ut incidunt. Illo suscipit magni ratione. Facilis cumque, hic voluptatum quo numquam quis dolor debitis neque, iure necessitatibus officia, ipsum modi aut. Perferendis dicta neque explicabo labore quas autem blanditiis nam! Eos! Reprehenderit dolorum delectus, tempore expedita cum culpa illo non magni quas qui tenetur laboriosam ipsum aut, odio, fugiat sint nobis corrupti repudiandae sed commodi. Culpa officiis consequatur soluta beatae odit?', 'foodjaguar.prmsu@gmail.com', '09123456780', 'Best-Seller', '63dddd8e15bb1.png');

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
(2, 'foodjaguar', 'Food', 'Jaguar', 'foodjaguar@gmail.com', '09123456789', '$2y$10$6PCYBXtddqrM7NiM3P8u7eWZBVL3yolQvsrjJAvr.Yzo9TlC7U9hW', 'PRMSU - Iba', '0', 'Yes', 1, '2023-03-04 03:54:37'),
(5, 'user101', 'User', 'One', 'user1@gmail.com', '0945461420', '$2y$10$1aN4C5B2eAQI.oHptXNWc.xszodjJeznUQ601zFlZ.h7CtQpeokcy', 'Iba Zambales', '0', 'Yes', 1, '2023-04-12 03:02:20');

-- --------------------------------------------------------

--
-- Table structure for table `user_orders`
--

CREATE TABLE `user_orders` (
  `o_id` int(11) NOT NULL,
  `u_id` int(255) NOT NULL,
  `c_id` int(11) NOT NULL,
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

INSERT INTO `user_orders` (`o_id`, `u_id`, `c_id`, `title`, `quantity`, `price`, `original_price`, `mop`, `s_fee`, `s_address`, `original_address`, `status`, `order_number`, `date`) VALUES
(1, 2, 1, 'Sisig', 2, '300.00', '150.00', 'deliver', '15.00', '', 'PRMSU', 'rejected', 1, '2023-02-10 05:06:01'),
(2, 2, 1, 'Sisig', 2, '300.00', '150.00', 'deliver', '15.00', '', 'PRMSU', 'rejected', 2, '2023-02-10 05:11:02'),
(3, 2, 1, 'Pinakbet', 1, '100.00', '100.00', 'deliver', '20.00', 'SAMPLE ADDRESS', 'PRMSU', 'closed', 3, '2023-02-12 01:12:51'),
(7, 2, 1, 'Sisig', 1, '150.00', '150.00', 'deliver', '20.00', '', 'PRMSU', '', 5, '2023-03-03 17:23:15'),
(8, 2, 1, 'Pinakbet', 1, '100.00', '100.00', 'deliver', '20.00', '', 'PRMSU', '', 6, '2023-03-03 17:25:55'),
(9, 2, 1, 'Adobong Manok', 1, '50.00', '50.00', 'deliver', '20.00', '', 'PRMSU', 'rejected', 6, '2023-03-03 17:25:55'),
(10, 2, 1, 'Sisig', 1, '150.00', '150.00', 'deliver', '20.00', '', 'PRMSU', 'rejected', 6, '2023-03-03 17:25:55'),
(11, 5, 1, 'Pinakbet', 1, '100.00', '100.00', 'deliver', '20.00', '', 'Iba Zambales', 'rejected', 7, '2023-03-03 20:14:24'),
(12, 5, 1, 'Adobong Manok', 1, '50.00', '50.00', 'deliver', '20.00', '', 'Iba Zambales', 'rejected', 7, '2023-03-03 20:14:24'),
(13, 5, 1, 'Sisig', 2, '300.00', '150.00', 'deliver', '20.00', '', 'Iba Zambales', 'rejected', 8, '2023-03-03 20:44:08'),
(14, 5, 1, 'Adobong Manok', 2, '100.00', '50.00', 'deliver', '20.00', '', 'Iba Zambales', 'rejected', 8, '2023-03-03 20:44:08'),
(15, 5, 1, 'Sisig', 5, '750.00', '150.00', 'deliver', '20.00', '', 'Iba Zambales', 'rejected', 9, '2023-03-03 21:59:05'),
(16, 5, 1, 'Adobong Manok', 5, '250.00', '50.00', 'deliver', '20.00', '', 'Iba Zambales', 'rejected', 9, '2023-03-03 21:59:05'),
(19, 5, 1, 'Sisig', 5, '750.00', '150.00', 'deliver', '20.00', '', 'Iba Zambales', 'rejected', 10, '2023-03-04 00:25:31'),
(20, 5, 1, 'Adobong Manok', 5, '250.00', '50.00', 'deliver', '20.00', '', 'Iba Zambales', 'rejected', 10, '2023-03-04 00:25:31'),
(21, 5, 1, 'Sinigang', 1, '100.00', '100.00', 'pick-up', '0.00', '', 'Iba Zambales', 'rejected', 11, '2023-04-11 19:01:43');

-- --------------------------------------------------------

--
-- Table structure for table `user_testimonials`
--

CREATE TABLE `user_testimonials` (
  `id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `u_testi` varchar(300) NOT NULL,
  `testi_approval` enum('Yes','No') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_testimonials`
--

INSERT INTO `user_testimonials` (`id`, `u_id`, `u_testi`, `testi_approval`) VALUES
(2, 2, 'Sample Review', 'Yes'),
(3, 5, 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Pariatur maxime rem optio dicta, deleniti illum repudiandae excepturi quae molestiae animi ipsum architecto numquam minus magni corrupti voluptate quia facilis non!Lorem ipsum, dolor Lorem ipsum, dolor sit amet consectetur adipisicing elitsn.', 'Yes'),
(9, 6, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable Eng', 'Yes');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adm_id`);

--
-- Indexes for table `canteen_table`
--
ALTER TABLE `canteen_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`d_id`);

--
-- Indexes for table `fave_table`
--
ALTER TABLE `fave_table`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `user_testimonials`
--
ALTER TABLE `user_testimonials`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adm_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `canteen_table`
--
ALTER TABLE `canteen_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dishes`
--
ALTER TABLE `dishes`
  MODIFY `d_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `fave_table`
--
ALTER TABLE `fave_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `food_category`
--
ALTER TABLE `food_category`
  MODIFY `f_catid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `remark`
--
ALTER TABLE `remark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user_testimonials`
--
ALTER TABLE `user_testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
