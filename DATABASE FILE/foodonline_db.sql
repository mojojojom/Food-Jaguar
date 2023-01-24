-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 24, 2023 at 03:26 AM
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
(2, 'foodjaguar', '$2y$10$BO/COk9RVY2jm5tCH3sT.uZxRwgXJvQMqgfOwIHCg6J5/0v18U5LO', 'foodjaguar@gmail.com', '', '2023-01-19 12:05:46');

-- --------------------------------------------------------

--
-- Table structure for table `dishes`
--

CREATE TABLE `dishes` (
  `d_id` int(222) NOT NULL,
  `rs_id` int(222) NOT NULL,
  `title` varchar(222) NOT NULL,
  `slogan` varchar(222) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `img` varchar(222) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dishes`
--

INSERT INTO `dishes` (`d_id`, `rs_id`, `title`, `slogan`, `price`, `img`) VALUES
(1, 2, 'Yorkshire Lamb Patties', 'Lamb patties which melt in your mouth, and are quick and easy to make. Served hot with a crisp salad.', '14.00', '62908867a48e4.jpg'),
(2, 1, 'Lobster Thermidor', 'Lobster Thermidor is a French dish of lobster meat cooked in a rich wine sauce, stuffed back into a lobster shell, and browned.', '36.00', '629089fee52b9.jpg'),
(3, 2, 'Chicken Madeira', 'Chicken Madeira, like Chicken Marsala, is made with chicken, mushrooms, and a special fortified wine. But, the wines are different;', '23.00', '62908bdf2f581.jpg'),
(4, 1, 'Stuffed Jacket Potatoes', 'Deep fry whole potatoes in oil for 8-10 minutes or coat each potato with little oil. Mix the onions, garlic, tomatoes and mushrooms. Add yoghurt, ginger, garlic, chillies, coriander', '8.00', '62908d393465b.jpg'),
(5, 2, 'Pink Spaghetti Gamberoni', 'Spaghetti with prawns in a fresh tomato sauce. This dish originates from Southern Italy and with the combination of prawns, garlic, chilli and pasta. Garnish each with remaining tablespoon parsley.', '21.00', '606d7491a9d13.jpg'),
(6, 2, 'Cheesy Mashed Potato', 'Deliciously Cheesy Mashed Potato. The ultimate mash for your Thanksgiving table or the perfect accompaniment to vegan sausage casserole. Everyone will love it\'s fluffy, cheesy.', '5.00', '606d74c416da5.jpg'),
(7, 2, 'Crispy Chicken Strips', 'Fried chicken strips, served with special honey mustard sauce.', '8.00', '606d74f6ecbbb.jpg'),
(8, 2, 'Lemon Grilled Chicken And Pasta', 'Marinated rosemary grilled chicken breast served with mashed potatoes and your choice of pasta.', '11.00', '606d752a209c3.jpg'),
(9, 3, 'Vegetable Fried Rice', 'Chinese rice wok with cabbage, beans, carrots, and spring onions.', '5.00', '606d7575798fb.jpg'),
(10, 1, 'Prawn Crackers', '12 pieces deep-fried prawn crackers', '7.00', '606d75a7e21ec.jpg'),
(11, 3, 'Spring Rolls', 'Lightly seasoned shredded cabbage, onion and carrots, wrapped in house made spring roll wrappers, deep fried to golden brown.', '6.00', '606d75ce105d0.jpg'),
(12, 1, 'Manchurian Chicken', 'Chicken pieces slow cooked with spring onions in our house made manchurian style sauce.', '11.00', '606d7600dc54c.jpg'),
(13, 4, ' Buffalo Wings', 'Fried chicken wings tossed in spicy Buffalo sauce served with crisp celery sticks and Blue cheese dip.', '11.00', '606d765f69a19.jpg'),
(14, 1, 'Mac N Cheese Bites', 'Served with our traditional spicy queso and marinara sauce.', '9.00', '606d768a1b2a1.jpg'),
(15, 1, 'Signature Potato Twisters', 'Spiral sliced potatoes, topped with our traditional spicy queso, Monterey Jack cheese, pico de gallo, sour cream and fresh cilantro.', '6.00', '606d76ad0c0cb.jpg'),
(16, 1, 'Meatballs Penne Pasta', 'Garlic-herb beef meatballs tossed in our house-made marinara sauce and penne pasta topped with fresh parsley.', '10.00', '606d76eedbb99.jpg'),
(17, 1, 'Dinuguan', 'Sample Description', '100.00', '63b791e470000.jpg'),
(18, 2, 'Coca-cola (Can)', 'Coca-cola drink', '50.00', '63b794e249182.png'),
(23, 4, 'Dinuguans', 'Dinuguan na masarap', '150.00', '63cb992f04872.jpg');

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
(1, 'Student-Meal'),
(2, 'Drinks'),
(3, 'Combo-Meal'),
(4, 'Meat'),
(5, 'Vegetables'),
(6, 'Best-Sellers');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(255) NOT NULL,
  `u_id` int(255) NOT NULL,
  `order_names` varchar(255) NOT NULL,
  `order_quantity` int(255) NOT NULL,
  `order_total` int(255) NOT NULL,
  `order_number` int(255) NOT NULL,
  `order_ship` varchar(255) NOT NULL,
  `order_fee` decimal(10,2) NOT NULL,
  `order_status` varchar(255) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(1, 2, 'in process', 'none', '2022-05-01 05:17:49'),
(2, 3, 'in process', 'none', '2022-05-27 11:01:30'),
(3, 2, 'closed', 'thank you for your order!', '2022-05-27 11:11:41'),
(4, 3, 'closed', 'none', '2022-05-27 11:42:35'),
(5, 4, 'in process', 'none', '2022-05-27 11:42:55'),
(6, 1, 'rejected', 'none', '2022-05-27 11:43:26'),
(7, 7, 'in process', 'none', '2022-05-27 13:03:24'),
(8, 8, 'in process', 'none', '2022-05-27 13:03:38'),
(9, 9, 'rejected', 'thank you', '2022-05-27 13:03:53'),
(10, 7, 'closed', 'thank you for your ordering with us', '2022-05-27 13:04:33'),
(11, 8, 'closed', 'thanks ', '2022-05-27 13:05:24'),
(12, 5, 'closed', 'none', '2022-05-27 13:18:03'),
(13, 47, 'in process', 'thank you for ordering!', '2023-01-14 01:32:11'),
(14, 47, 'closed', 'Thank you for ordering!', '2023-01-14 05:15:08'),
(18, 48, 'in process', 'thanks for ordering!', '2023-01-21 04:49:42'),
(19, 48, 'closed', 'thanks for ordering!', '2023-01-21 04:50:40'),
(20, 45, 'rejected', '', '2023-01-21 09:16:20'),
(21, 53, 'closed', '', '2023-01-21 09:18:12'),
(22, 47, 'in process', '', '2023-01-21 09:19:13'),
(23, 52, 'rejected', '', '2023-01-21 09:20:22'),
(24, 98, 'closed', '', '2023-01-22 00:24:19');

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
(2, 'foodjaguar', 'Food', 'Jaguar', 'foodjaguar@gmail.com', '09123456789', '$2y$10$psqbNLa7wW26pUmzfujIRuobay6wn3H9GhCpWMDtRwerXgFOllbvG', 'PRMSU', '0', 'Yes', 1, '2023-01-22 00:21:01');

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
(79, 1, 'Meatballs Penne Pasta', 1, '10.00', '0.00', 'deliver', '0.00', '', '', '', 1, '2023-01-21 03:05:35'),
(80, 1, 'Spring Rolls', 1, '6.00', '0.00', 'deliver', '0.00', '', '', '', 1, '2023-01-21 03:05:35'),
(81, 1, 'Crispy Chicken Strips', 1, '8.00', '0.00', 'deliver', '0.00', '', '', '', 1, '2023-01-21 03:05:35'),
(82, 1, 'Yorkshire Lamb Patties', 1, '14.00', '0.00', 'deliver', '0.00', '', '', '', 1, '2023-01-21 03:05:35'),
(83, 1, 'Lobster Thermidor', 2, '72.00', '0.00', 'deliver', '0.00', '', '', 'rejected', 1, '2023-01-21 03:05:35'),
(84, 1, 'Stuffed Jacket Potatoes', 1, '8.00', '0.00', 'deliver', '0.00', '', '', 'rejected', 1, '2023-01-21 03:05:35'),
(85, 1, 'Chicken Madeira', 1, '23.00', '0.00', 'deliver', '0.00', '', '', 'rejected', 1, '2023-01-21 03:05:35'),
(86, 1, 'Pink Spaghetti Gamberoni', 1, '21.00', '0.00', 'deliver', '0.00', '', '', 'rejected', 1, '2023-01-21 03:05:35'),
(87, 1, 'Lemon Grilled Chicken And Pasta', 4, '44.00', '0.00', 'deliver', '0.00', '', '', '', 2, '2023-01-21 03:08:44'),
(88, 1, 'Spring Rolls', 1, '6.00', '0.00', 'deliver', '0.00', '', '', '', 3, '2023-01-21 06:36:02'),
(89, 1, 'Crispy Chicken Strips', 1, '8.00', '0.00', 'deliver', '0.00', '', '', '', 3, '2023-01-21 06:36:02'),
(90, 1, 'Stuffed Jacket Potatoes', 1, '8.00', '0.00', 'deliver', '0.00', '', '', '', 3, '2023-01-21 06:36:02'),
(91, 1, 'Spring Rolls', 1, '6.00', '0.00', 'pick-up', '0.00', '', '', '', 4, '2023-01-21 06:52:32'),
(92, 1, 'Crispy Chicken Strips', 1, '8.00', '0.00', 'pick-up', '0.00', '', '', '', 4, '2023-01-21 06:52:32'),
(93, 1, 'Stuffed Jacket Potatoes', 1, '8.00', '0.00', 'pick-up', '0.00', '', '', '', 4, '2023-01-21 06:52:32'),
(94, 1, 'Lobster Thermidor', 1, '36.00', '0.00', 'pick-up', '0.00', '', '', '', 5, '2023-01-21 06:53:54'),
(95, 1, 'Mac N Cheese Bites', 3, '27.00', '0.00', 'pick-up', '0.00', '', '', '', 5, '2023-01-21 06:53:54'),
(99, 2, 'Stuffed Jacket Potatoes', 1, '8.00', '0.00', 'deliver', '0.00', '', '', 'rejected', 7, '2023-01-21 16:21:30'),
(108, 2, 'Manchurian Chicken', 1, '11.00', '0.00', 'deliver', '5.00', 'ccit', '', '', 10, '2023-01-23 04:23:10'),
(109, 2, 'Stuffed Jacket Potatoes', 5, '40.00', '0.00', 'deliver', '5.00', 'ccit', '', '', 10, '2023-01-23 04:23:10'),
(110, 2, 'Lobster Thermidor', 1, '36.00', '0.00', 'pick-up', '0.00', 'ccit', 'PRMSU', '', 11, '2023-01-23 04:37:37'),
(111, 2, 'Lobster Thermidor', 2, '72.00', '0.00', 'deliver', '5.00', 'CON', 'PRMSU', '', 12, '2023-01-23 15:12:28'),
(112, 2, 'Prawn Crackers', 5, '35.00', '0.00', 'deliver', '5.00', 'CON', 'PRMSU', '', 12, '2023-01-23 15:12:28'),
(113, 2, 'Signature Potato Twisters', 5, '30.00', '0.00', 'deliver', '5.00', 'CON', 'PRMSU', '', 12, '2023-01-23 15:12:28'),
(114, 2, 'Dinuguan', 1, '100.00', '100.00', 'deliver', '5.00', '', 'PRMSU', '', 13, '2023-01-23 17:06:38'),
(115, 2, 'Meatballs Penne Pasta', 5, '50.00', '10.00', 'deliver', '5.00', '', 'PRMSU', '', 13, '2023-01-23 17:06:38'),
(116, 2, 'Coca-cola (Can)', 2, '100.00', '50.00', 'deliver', '5.00', '', 'PRMSU', '', 13, '2023-01-23 17:06:38');

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `remark`
--
ALTER TABLE `remark`
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
  MODIFY `d_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `food_category`
--
ALTER TABLE `food_category`
  MODIFY `f_catid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `remark`
--
ALTER TABLE `remark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_orders`
--
ALTER TABLE `user_orders`
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
