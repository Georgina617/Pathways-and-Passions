-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 20, 2026 at 11:11 AM
-- Server version: 5.7.44-log
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpbeginner`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(5, 'wawoo'),
(7, 'Biggi'),
(8, 'Products'),
(9, 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(255) DEFAULT NULL,
  `message` text,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '0',
  `post_id` bigint(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(1000) DEFAULT NULL,
  `amount` varchar(1000) DEFAULT NULL,
  `user_id` int(255) DEFAULT NULL,
  `product_id` int(255) DEFAULT NULL,
  `quantity` int(255) DEFAULT NULL,
  `status` varchar(1000) DEFAULT NULL,
  `payment_status` varchar(100) DEFAULT NULL,
  `payment_method` varchar(1000) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_id`, `amount`, `user_id`, `product_id`, `quantity`, `status`, `payment_status`, `payment_method`, `timestamp`) VALUES
(12, '71722946', '200000', 8, 5, 2, 'Completed', 'paid', 'paystack', '2026-02-13 17:24:10'),
(13, '285576376', '500000', 8, 6, 1, 'Completed', 'paid', 'paystack', '2026-02-14 12:18:07'),
(14, '987806089', '500000', 9, 6, 1, 'processing', 'paid', 'paystack', '2026-02-14 12:37:21'),
(15, 'PHP_102868', '9000', 9, 4, 3, 'Completed', 'paid', 'flutterwave', '2026-02-14 12:51:07');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(1000) DEFAULT NULL,
  `content` text,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '0',
  `category_id` varchar(1000) DEFAULT NULL,
  `thumbnail` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `timestamp`, `status`, `category_id`, `thumbnail`) VALUES
(2, 'It\'s big news', 'I can code and that is the big news.', '2026-01-04 13:30:42', 1, '5', 'uploads/voyager.png'),
(3, 'Another Post', 'Its the beginning of a new dawn today in oyo state.\r\n', '2026-01-19 13:53:42', 0, '5', 'uploads/Beowin.png'),
(4, 'Fashion at its core', 'Choose from different fashion items in our store and let us redefine your style.', '2026-01-19 13:55:00', 1, '7', 'uploads/Ecommerce.png');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(1000) DEFAULT NULL,
  `image` varchar(1000) DEFAULT NULL,
  `status` int(255) DEFAULT '0',
  `category_id` varchar(1000) DEFAULT NULL,
  `content` text,
  `price` varchar(1000) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `image`, `status`, `category_id`, `content`, `price`, `timestamp`) VALUES
(4, 'New Product', 'uploads/IMG_6204.PNG', 1, '5', 'I love to code all the time.', '3000', '2026-02-03 12:56:53'),
(5, 'Beowin', 'uploads/Beowin.png', 1, '8', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '1000', '2026-02-03 14:32:37'),
(6, 'Agricultural implement', 'uploads/Tractor.jpeg', 1, '8', 'This is an Tractor for sale, which will make your work easier and faster.', '5000', '2026-02-11 16:44:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(1000) DEFAULT NULL,
  `email` varchar(1000) DEFAULT NULL,
  `password` varchar(1000) DEFAULT NULL,
  `role` varchar(1000) NOT NULL DEFAULT 'user',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `timestamp`) VALUES
(8, 'Odusanya Omolola Georgina', 'emmy1234@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'admin', '2026-01-04 14:57:45'),
(9, 'Biggiman', 'biggiman@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'user', '2026-02-01 15:23:39'),
(10, 'Domenica Montero', 'georginaodusanya@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'user', '2026-02-06 14:08:28');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
