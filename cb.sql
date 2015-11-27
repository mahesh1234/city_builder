-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2015 at 08:29 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cb`
--

-- --------------------------------------------------------

--
-- Table structure for table `building`
--

CREATE TABLE IF NOT EXISTS `building` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `building_type` varchar(250) NOT NULL,
  `level` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `status` varchar(250) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `building`
--

INSERT INTO `building` (`id`, `building_type`, `level`, `city_id`, `status`, `created_on`, `updated_on`) VALUES
(17, 'Supermarket', 2, 2, 'done', '2015-11-26 02:01:23', '2015-11-26 02:04:43'),
(13, 'Expo-center', 8, 1, 'done', '2015-11-26 01:04:57', '2015-11-27 12:40:41'),
(14, 'Restaurant', 5, 1, 'done', '2015-11-26 01:29:50', '2015-11-27 12:40:41'),
(20, 'town-hall', 1, 2, 'Upgrading', '2015-11-26 02:03:57', '2015-11-27 12:12:30'),
(19, 'Expo-center', 1, 2, 'done', '2015-11-26 02:03:39', '2015-11-27 11:01:28'),
(18, 'Restaurant', 1, 2, 'Upgrading', '2015-11-26 02:01:32', '2015-11-27 12:12:27'),
(16, 'town-hall', 3, 1, 'Upgrading', '2015-11-26 01:31:18', '2015-11-27 12:40:55'),
(15, 'Train-station', 2, 1, 'Upgrading', '2015-11-26 01:31:11', '2015-11-27 12:40:57'),
(12, 'Supermarket', 8, 1, 'done', '2015-11-26 01:04:51', '2015-11-27 11:59:33'),
(23, 'Expo-center', 0, 6, 'done', '2015-11-27 11:34:00', '2015-11-27 11:40:56'),
(22, 'Supermarket', 1, 6, 'done', '2015-11-27 01:21:29', '2015-11-27 11:34:22'),
(21, 'Supermarket', 0, 5, 'done', '2015-11-27 01:11:01', '2015-11-27 01:11:31'),
(24, 'Train-station', 0, 6, 'done', '2015-11-27 11:40:37', '2015-11-27 11:45:25'),
(25, 'Supermarket', 3, 15, 'done', '2015-11-27 12:14:48', '2015-11-27 12:46:30'),
(26, 'town-hall', 1, 15, 'Upgrading', '2015-11-27 12:27:54', '2015-11-27 12:46:57'),
(27, 'Supermarket', 0, 14, 'building', '2015-11-27 12:47:41', '2015-11-27 12:47:41'),
(28, 'Restaurant', 0, 14, 'building', '2015-11-27 12:47:44', '2015-11-27 12:47:44'),
(29, 'Supermarket', 0, 16, 'done', '2015-11-27 12:48:20', '2015-11-27 12:48:50'),
(30, 'Restaurant', 0, 16, 'done', '2015-11-27 12:48:23', '2015-11-27 12:48:53');

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE IF NOT EXISTS `city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `user_id` int(11) NOT NULL,
  `consume_points` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `name`, `user_id`, `consume_points`, `created_on`) VALUES
(1, 'mumbai', 1, 55, '2015-11-25 09:00:00'),
(2, 'pune', 0, 42, '2015-11-26 01:49:14'),
(3, 'punes', 0, 42, '2015-11-26 01:49:28'),
(4, 'punes', 0, 42, '2015-11-26 01:50:51'),
(5, 'sssss', 0, 42, '2015-11-26 01:54:35'),
(6, 'asa', 0, 30, '2015-11-27 01:21:04'),
(7, 'sdfsd', 0, 28, '2015-11-27 10:51:49'),
(15, '24234234', 0, 15, '2015-11-27 12:13:12'),
(14, 'zxczxc', 0, 15, '2015-11-27 12:13:03'),
(13, 'cxzvxcv', 0, 28, '2015-11-27 10:59:28'),
(16, 'ZXZXZX', 0, 2, '2015-11-27 12:48:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `points` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `points`, `created_on`, `updated_on`) VALUES
(1, 'nana', '', 70, '2015-11-25 00:31:00', '2015-11-27 12:48:10');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
