-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 12, 2023 at 06:12 AM
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
(2, 'foodjaguar', '$2y$10$BO/COk9RVY2jm5tCH3sT.uZxRwgXJvQMqgfOwIHCg6J5/0v18U5LO', 'foodjaguar.prmsu@gmail.com', 'admin', '', '2023-01-27 06:52:00');

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
(1, 'Food Jaguar', 'Sample Name', '0912345678901', 'fj.prmsu@gmail.com', 'food_jaguar', '$2y$10$goFb5QV58L4zyNJmzQQUP.d703a5UHBjtM5jcUnsMBPdzkOX03lM.', 'PRMSU Iba Campus', 'canteen', '1', 'Yes', '');

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
(1, 1, 1, 'Pinakbet', 'Pinakbet is an indigenous Filipino dish from the northern regions of the Philippines. Pinakbet is made from mixed vegetables sautÃ©ed in fish or shrimp sauce. The word is the contracted from the Ilokano word pinakebbet, meaning \"shrunk\" or \"shriveled.\"', '100.00', '63ddf6f51787c.jpg', 4, 'Post'),
(2, 2, 1, 'Sisig', 'Sisig is a Filipino dish made from parts of a pig\'s face and belly, and chicken liver which is usually seasoned with calamansi, onions, and chili peppers. It originates from the Pampanga region in Luzon. Sisig is a staple of Kapampangan cuisine. ', '150.00', '63ddf8677b7d6.jpg', 30, 'Draft'),
(3, 2, 1, 'Adobong Manok', 'Chicken adobo, also known as adobong manok, is a quintessential filipino braised chicken, marinated and stewed with vinegar, soy sauce, garlic, bay leaves, black peppercorns. The word adobo actually came from the spanish word \"adobar,\" meaning to marinate or pickle', '50.00', '63e8735d5d30c.jpg', 10, 'Draft');

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

--
-- Dumping data for table `fave_table`
--

INSERT INTO `fave_table` (`id`, `u_id`, `d_id`, `c_id`) VALUES
(3, 2, 1, 1);

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
(8, 1, 5, 'closed', '', '2023-02-05 13:18:16');

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
(1, 1, '25.00');

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
(5, 'user1', 'User', 'One', 'user1@gmail.com', '0945461421', '$2y$10$28TshhczVTA5X8hQfdM08.eYJ.ks7J5kFCwM5mVWFd8/3PqMWaKl.', 'Iba Zambales', '0', 'Yes', 1, '2023-02-09 04:45:18'),
(6, 'user3', 'User', 'Three', 'user3@gmail.com', '0912345682', '$2y$10$9dYCr0AahrQt6LC.VlS4Su0ltsubRlp9/rNG/IhOvHKMQGRoKkOdm', 'Sample Address', '0', 'Yes', 1, '2023-02-05 09:25:13'),
(7, 'jayzon_06', 'Jayzon', 'Clement', 'jayzon@gmail.com', '09123456254', '$2y$10$AoSmXMDcRlpzNSG5qdnkpemTEvJTC/DWXfFKPsuEvOUi0/OmErDXm', 'San Isidro Cabangan, Zambales', '0', 'Yes', 1, '2023-02-10 13:31:00');

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
(2, 2, 1, 'Sisig', 2, '300.00', '150.00', 'deliver', '15.00', '', 'PRMSU', '', 2, '2023-02-10 05:11:02');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dishes`
--
ALTER TABLE `dishes`
  MODIFY `d_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fave_table`
--
ALTER TABLE `fave_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `food_category`
--
ALTER TABLE `food_category`
  MODIFY `f_catid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `remark`
--
ALTER TABLE `remark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `u_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_orders`
--
ALTER TABLE `user_orders`
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_testimonials`
--
ALTER TABLE `user_testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
