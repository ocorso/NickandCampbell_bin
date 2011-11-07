-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 07, 2011 at 02:05 AM
-- Server version: 5.1.54
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db111575_nc`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` tinyint(100) unsigned NOT NULL AUTO_INCREMENT,
  `sid` mediumint(100) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `pretty` varchar(255) NOT NULL,
  `description1` varchar(255) DEFAULT NULL,
  `description2` varchar(255) DEFAULT NULL,
  `campaign` varchar(255) DEFAULT NULL,
  `label` enum('select','black') NOT NULL,
  `size` enum('extra small','small','medium','large','extra large') DEFAULT NULL,
  `color` varchar(50) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `gender` enum('mens','womens') NOT NULL,
  `weight` decimal(10,0) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `sku` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `sid`, `name`, `pretty`, `description1`, `description2`, `campaign`, `label`, `size`, `color`, `category`, `gender`, `weight`, `price`, `sku`) VALUES
(1, 1, 'The Brazil Boxer Brief', 'brazil-boxer-brief', 'This is a really great pair of underwear', 'Seriously, its really great', 'FW11', 'select', 'medium', 'black', 'underwear', 'mens', 2, 20, 1000),
(2, 2, 'The Original Boxer Brief', 'original-boxer-brief', 'This pair is sick', 'You want these', 'FW11', 'select', 'large', 'black', 'underwear', 'mens', 2, 20, 1000);
