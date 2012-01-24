SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `db111575_nc`
--

-- --------------------------------------------------------

---------------------------------------------
-- Table structure for table `shipping_addresses`
---------------------------------------------
CREATE TABLE IF NOT EXISTS `shipping_addresses` (
	`shid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'shipping address id',
	`ref_cid` BIGINT UNSIGNED NOT NULL COMMENT 'ref to customer id',
	`address1` VARCHAR( 255 ) NOT NULL ,
	`address2` VARCHAR( 255 ) NOT NULL ,
	`city` VARCHAR( 255 ) NOT NULL ,
	`state` VARCHAR( 30 ) NOT NULL ,
	`country` VARCHAR( 255 ) NOT NULL ,
	`zip` VARCHAR( 10 ) NOT NULL ,
	`created_at` DATETIME NOT NULL
);

---------------------------------------------
-- Table structure for table `billing_addresses`
---------------------------------------------
CREATE TABLE IF NOT EXISTS `billing_addresses` (
	`bid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'billing address id',
	`ref_cid` BIGINT UNSIGNED NOT NULL COMMENT 'ref to customer id',
	`address1` VARCHAR( 255 ) NOT NULL ,
	`address2` VARCHAR( 255 ) NOT NULL ,
	`city` VARCHAR( 255 ) NOT NULL ,
	`state` VARCHAR( 30 ) NOT NULL ,
	`country` VARCHAR( 255 ) NOT NULL ,
	`zip` VARCHAR( 10 ) NOT NULL ,
	`created_at` DATETIME NOT NULL
);

--
-- Table structure for table `product_styles`
--

CREATE TABLE IF NOT EXISTS `product_styles` (
  `sid` mediumint(100) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `pretty` varchar(255) NOT NULL,
  `description1` varchar(255) DEFAULT NULL,
  `description2` varchar(255) DEFAULT NULL,
  `campaign` varchar(255) DEFAULT NULL,
  `label` enum('select','black') NOT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'uncategorized',
  `gender` enum('mens','womens') NOT NULL,
  `price` decimal(19,2) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


---------------------------------------------
-- Table structure for table `products`
---------------------------------------------

CREATE TABLE IF NOT EXISTS `products` (
  `pid` tinyint(100) unsigned NOT NULL AUTO_INCREMENT,
  `ref_sid` mediumint(100) unsigned NOT NULL,
  `ref_size` tinyint(4) DEFAULT NULL,
  `color` varchar(50) NOT NULL,
  `weight` decimal(19,2) NOT NULL,
  `sku` int(11) NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



----------------------------------------------
-- Table structure for table `ref_sizing_chart`
----------------------------------------------
CREATE TABLE IF NOT EXISTS `ref_sizing_chart` (
  `size_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`size_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `ref_sizing_chart`
--

INSERT INTO `ref_sizing_chart` (`size_id`, `name`, `description`) VALUES
(0, 'extra extra small', 'this size is for extremely skinny guys'),
(1, 'extra small', 'this is for really skinny guys'),
(2, 'small', 'this is for skinny guys'),
(3, 'medium', 'this is for normal sized guys'),
(4, 'large', 'this is for slightly bigger guys'),
(5, 'extra large', 'this is for big guys');


--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `salt` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `salt`, `role`, `date_created`) VALUES
(1, 'admin', 'Vamp5near', 'ce8d96d579d389e783f95b3772785783ea1a9854', 'administrator', '2011-11-24 21:17:02');
