CREATE TABLE IF NOT EXISTS `users` (
  `uid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'user id',
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `salt` varchar(50) NOT NULL,
  `ref_rid` tinyint(4) NOT NULL COMMENT 'reference to roles_chart',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

CREATE TABLE IF NOT EXISTS `shipping_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `carrier` varchar(100) NOT NULL,
  `cost_per_pound` decimal(10,0) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `products` (
  `pid` tinyint(100) unsigned NOT NULL AUTO_INCREMENT,
  `ref_sid` mediumint(100) unsigned NOT NULL,
  `ref_size` tinyint(4) DEFAULT NULL,
  `color` varchar(50) NOT NULL,
  `weight` decimal(19,2) NOT NULL,
  `sku` int(11) NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

CREATE TABLE IF NOT EXISTS `sizing_chart` (
  `size_id` x NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`size_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;