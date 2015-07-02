-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2015 at 07:18 PM
-- Server version: 5.6.23-log
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pg`
--
-- drop database if exists pg;
create database if not exists pg;
-- --------------------------------------------------------
use pg;
--
-- Table structure for table `user_billing_data`
--

CREATE TABLE IF NOT EXISTS `user_billing_data` (
  `user_id` varchar(20) NOT NULL,
  `card_no` varchar(20) NOT NULL,
  `bank_acc_no` varchar(20) NOT NULL,
  `billing_address` varchar(100) NOT NULL,
  `shipping_address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_billing_data`
--

INSERT INTO `user_billing_data` (`user_id`, `card_no`, `bank_acc_no`, `billing_address`, `shipping_address`) VALUES
('1', 11, 11, '11', '11'),
('2', 2, 2, '2', '2');

-- --------------------------------------------------------

--
-- Table structure for table `user_login_data`
--

CREATE TABLE IF NOT EXISTS `user_login_data` (
  `user_id` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_login_data`
--

INSERT INTO `user_login_data` (`user_id`, `password`) VALUES
('1', '11'),
('2', '2');

-- --------------------------------------------------------

--
-- Table structure for table `user_primary_data`
--

CREATE TABLE IF NOT EXISTS `user_primary_data` (
  `user_id` varchar(20) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `mobile_number` int(15) NOT NULL,
  `country` varchar(20) NOT NULL,
  `ctizen_id_no` varchar(20) NOT NULL,
  `birth_day` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_primary_data`
--

INSERT INTO `user_primary_data` (`user_id`, `user_name`, `email`, `mobile_number`, `country`, `ctizen_id_no`, `birth_day`) VALUES
('1', '11', '1@gmail.com', 11, '11', '11', '2015-05-04'),
('2', '2', '2@gmail.co', 2, '2', '2', '2015-05-03');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
