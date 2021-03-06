-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 10, 2012 at 09:34 AM
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
-- Table structure for table `billing_addresses`
--

CREATE TABLE IF NOT EXISTS `billing_addresses` (
  `bid` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'billing address id',
  `ref_uid` bigint(20) unsigned NOT NULL COMMENT 'ref to customer id',
  `address1` varchar(255) NOT NULL,
  `address2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(30) NOT NULL,
  `country` varchar(255) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`bid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `billing_addresses`
--


-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `oid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `anet_id` varchar(255) DEFAULT NULL,
  `amount` decimal(14,2) NOT NULL,
  `total_tax` decimal(14,2) NOT NULL,
  `ref_uid` int(11) NOT NULL,
  `ref_bid` int(11) NOT NULL,
  `ref_shipping_id` int(11) NOT NULL,
  `details` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` set('incomplete sale','accepted payment','order received','accepted payment','order closed','payment declined') NOT NULL,
  UNIQUE KEY `oid` (`oid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `orders`
--


-- --------------------------------------------------------

--
-- Table structure for table `postorder_cart`
--

CREATE TABLE IF NOT EXISTS `postorder_cart` (
  `cart_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ref_oid` int(11) NOT NULL,
  `ref_pid` int(11) NOT NULL,
  `ref_uid` int(11) NOT NULL,
  `price_paid` decimal(14,2) NOT NULL,
  `tax` decimal(14,2) NOT NULL,
  `promo` varchar(255) DEFAULT NULL,
  `discount` varchar(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `cart_id` (`cart_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `postorder_cart`
--


-- --------------------------------------------------------

--
-- Table structure for table `preorder_cart`
--

CREATE TABLE IF NOT EXISTS `preorder_cart` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sesh_id` varchar(30) NOT NULL,
  `type` enum('real','wishlist') NOT NULL DEFAULT 'real',
  `discount` varchar(20) NOT NULL DEFAULT '0',
  `promo` varchar(255) NOT NULL DEFAULT 'nope',
  `ref_pid` bigint(20) NOT NULL,
  `ref_uid` bigint(20) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `preorder_cart`
--

INSERT INTO `preorder_cart` (`id`, `sesh_id`, `type`, `discount`, `promo`, `ref_pid`, `ref_uid`, `quantity`, `created_at`) VALUES
(7, '3dc7nmcc0sgn82bjkn53g425v4', 'real', '0', '0', 10, -1, 3, '2012-04-10 09:32:47');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `pid` tinyint(100) unsigned NOT NULL AUTO_INCREMENT,
  `ref_sid` mediumint(100) unsigned NOT NULL,
  `ref_size` tinyint(4) DEFAULT NULL,
  `color` varchar(50) NOT NULL,
  `weight` decimal(19,2) NOT NULL,
  `sku` int(11) NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`pid`, `ref_sid`, `ref_size`, `color`, `weight`, `sku`) VALUES
(1, 1, 0, 'black', 2.00, 0),
(2, 1, 1, 'black', 2.00, 0),
(3, 1, 2, 'black', 2.00, 0),
(4, 1, 3, 'black', 2.00, 0),
(5, 1, 4, 'black', 2.00, 0),
(6, 1, 5, 'black', 2.00, 0),
(8, 2, 1, 'black', 2.00, 0),
(9, 2, 2, 'black', 2.00, 0),
(10, 2, 3, 'black', 2.00, 1000),
(11, 2, 4, 'black', 2.00, 1000),
(12, 2, 5, 'black', 2.00, 0),
(13, 3, 0, 'black', 2.00, 0),
(14, 3, 1, 'black', 2.00, 0),
(15, 3, 2, 'black', 2.00, 0),
(16, 3, 3, 'black', 2.00, 1000),
(17, 3, 4, 'black', 2.00, 1000),
(18, 3, 5, 'black', 2.00, 0),
(19, 4, 0, 'black', 2.00, 0),
(20, 4, 1, 'black', 2.00, 0),
(21, 4, 2, 'black', 2.00, 0),
(22, 4, 3, 'black', 2.00, 1000),
(23, 4, 4, 'black', 2.00, 1000),
(24, 4, 5, 'black', 2.00, 0),
(25, 5, 0, 'black', 2.00, 0),
(26, 5, 1, 'black', 2.00, 0),
(27, 5, 2, 'black', 2.00, 0),
(28, 5, 3, 'black', 2.00, 1000),
(29, 5, 4, 'black', 2.00, 1000),
(30, 5, 5, 'black', 2.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_styles`
--

CREATE TABLE IF NOT EXISTS `product_styles` (
  `sid` mediumint(100) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `pretty` varchar(255) NOT NULL,
  `description1` text,
  `description2` text,
  `campaign` varchar(255) DEFAULT NULL,
  `label` enum('select','black') NOT NULL,
  `category` text NOT NULL COMMENT 'comma delimited set of categories',
  `gender` enum('mens','womens') NOT NULL,
  `price` decimal(19,2) NOT NULL,
  `discount` float NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_styles`
--

INSERT INTO `product_styles` (`sid`, `name`, `pretty`, `description1`, `description2`, `campaign`, `label`, `category`, `gender`, `price`, `discount`) VALUES
(1, 'Brazil Boxer Brief', 'brazil-boxer-brief', 'Seamless Front and Back', NULL, 'SS12', 'select', 'underwear', 'mens', 35.00, 0),
(2, 'Original Boxer Brief', 'original-boxer-brief', 'The Fundamental Boxer Brief', NULL, 'SS12', 'select', 'underwear', 'mens', 35.00, 0),
(3, 'Classic Brief', 'classic-brief', 'The Timeless Silhouette', NULL, 'SS12', 'select', 'underwear', 'mens', 35.00, 0),
(4, 'Sexy Campbell Brief', 'sexy-campbell-brief', 'Less coverage than Classic Brief', NULL, 'SS12', 'select', 'underwear', 'mens', 35.00, 0),
(5, 'Cowboy Brief', 'cowboy-brief', 'Two buttons for the open seam', NULL, 'SS12', 'select', 'underwear', 'mens', 35.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `roles_chart`
--

CREATE TABLE IF NOT EXISTS `roles_chart` (
  `rid` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'role id',
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  UNIQUE KEY `rid` (`rid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `roles_chart`
--

INSERT INTO `roles_chart` (`rid`, `name`, `description`) VALUES
(1, 'administrators', 'these guys get to see everything.'),
(2, 'customers', 'this guys only get to check their own order history, track current orders, and access a returns form.');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_addresses`
--

CREATE TABLE IF NOT EXISTS `shipping_addresses` (
  `shid` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'shipping address id',
  `ref_uid` bigint(20) unsigned NOT NULL COMMENT 'ref to customer id',
  `address1` varchar(255) NOT NULL,
  `address2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(30) NOT NULL,
  `country` varchar(255) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`shid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `shipping_addresses`
--

INSERT INTO `shipping_addresses` (`shid`, `ref_uid`, `address1`, `address2`, `city`, `state`, `country`, `zip`, `created_at`) VALUES
(1, 2, '648 broadway', 'suite 303', 'new york', 'ny', 'united states', '10012', '2012-03-20 23:56:05');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_info`
--

CREATE TABLE IF NOT EXISTS `shipping_info` (
  `shipping_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `shipping_price_paid` decimal(14,2) NOT NULL,
  `shipping_cost` decimal(14,2) DEFAULT NULL,
  `label_id` varchar(255) DEFAULT NULL,
  `carrier` varchar(255) DEFAULT NULL,
  `origin` int(11) NOT NULL,
  `destination` int(11) NOT NULL,
  `taxable` tinyint(1) DEFAULT NULL,
  `total_weight` decimal(14,3) DEFAULT NULL,
  `tracking_num` varchar(255) DEFAULT NULL,
  `ship_date` datetime DEFAULT NULL,
  UNIQUE KEY `shipping_id` (`shipping_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `shipping_info`
--


-- --------------------------------------------------------

--
-- Table structure for table `sizing_chart`
--

CREATE TABLE IF NOT EXISTS `sizing_chart` (
  `size_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `size_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`size_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `sizing_chart`
--

INSERT INTO `sizing_chart` (`size_id`, `size_name`, `description`) VALUES
(0, 'extra extra small', 'this size is for extremely skinny guys'),
(1, 'extra small', 'this is for really skinny guys'),
(2, 'small', 'this is for skinny guys'),
(3, 'medium', 'this is for normal sized guys'),
(4, 'large', 'this is for slightly bigger guys'),
(5, 'extra large', 'this is for big guys');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'user id',
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `salt` varchar(50) NOT NULL,
  `ref_rid` tinyint(4) NOT NULL COMMENT 'reference to roles_chart',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `first_name`, `last_name`, `email`, `phone`, `password`, `salt`, `ref_rid`, `created_at`) VALUES
(1, 'Owen', 'Corso', 'owen@nickandcampbell.com', '2016020069', 'Vamp5near', '', 1, '2012-02-27 13:46:26'),
(2, 'nick', 'lemons', 'nick@nickandcampbell.com', '9179876543', 'studionc', '', 1, '2012-03-03 16:25:59');
