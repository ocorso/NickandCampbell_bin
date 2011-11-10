SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `db111575_nc`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` tinyint(100) unsigned NOT NULL AUTO_INCREMENT,
  `sid` mediumint(100) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `pretty` varchar(255) NOT NULL,
  `description1` varchar(255) DEFAULT NULL,
  `description2` varchar(255) DEFAULT NULL,
  `campaign` varchar(255) DEFAULT NULL,
  `label` enum('select','black') NOT NULL,
  `size` tinyint(4) DEFAULT NULL,
  `color` varchar(50) NOT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'uncategorized',
  `gender` enum('mens','womens') NOT NULL,
  `weight` decimal(19,2) NOT NULL,
  `price` decimal(19,2) NOT NULL,
  `sku` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;


--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `sid`, `name`, `pretty`, `description1`, `description2`, `campaign`, `label`, `size`, `color`, `category`, `gender`, `weight`, `price`, `sku`) VALUES
(1, 1, 'The Brazil Boxer Brief', 'brazil-boxer-brief', 'This is a really great pair of underwear', 'Seriously, its really great', 'FW11', 'select', 1, 'black', 'underwear', 'mens', 2, 19.95, 0),
(2, 1, 'The Brazil Boxer Brief', 'brazil-boxer-brief', 'This is a really great pair of underwear', 'Seriously, its really great', 'FW11', 'select', 2, 'black', 'underwear', 'mens', 2, 19.95, 1000),
(3, 1, 'The Brazil Boxer Brief', 'brazil-boxer-brief', 'This is a really great pair of underwear', 'Seriously, its really great', 'FW11', 'select', 3, 'black', 'underwear', 'mens', 2, 19.95, 999),
(4, 1, 'The Brazil Boxer Brief', 'brazil-boxer-brief', 'This is a really great pair of underwear', 'Seriously, its really great', 'FW11', 'select', 4, 'black', 'underwear', 'mens', 2, 19.95, 0),
(5, 1, 'The Brazil Boxer Brief', 'brazil-boxer-brief', 'This is a really great pair of underwear', 'Seriously, its really great', 'FW11', 'select', 5, 'black', 'underwear', 'mens', 2, 19.95, 0),
(6, 2, 'The Original Boxer Brief', 'original-boxer-brief', 'This pair is sick', 'You want these', 'FW11', 'select', 1, 'black', 'underwear', 'mens', 2, 19.95, 0),
(7, 2, 'The Original Boxer Brief', 'original-boxer-brief', 'This pair is sick', 'You want these', 'FW11', 'select', 2, 'black', 'underwear', 'mens', 2, 19.95, 1000),
(8, 2, 'The Original Boxer Brief', 'original-boxer-brief', 'This pair is sick', 'You want these', 'FW11', 'select', 3, 'black', 'underwear', 'mens', 2, 19.95, 1000),
(9, 2, 'The Original Boxer Brief', 'original-boxer-brief', 'This pair is sick', 'You want these', 'FW11', 'select', 4, 'black', 'underwear', 'mens', 2, 19.95, 0),
(10, 2, 'The Original Boxer Brief', 'original-boxer-brief', 'This pair is sick', 'You want these', 'FW11', 'select', 5, 'black', 'underwear', 'mens', 2, 19.95, 0);

--
-- Table structure for table `ref_sizing_chart`
--
CREATE TABLE `ref_sizing_chart` (
  `size_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`size_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `ref_sizing_chart`
--

INSERT INTO `ref_sizing_chart` (`size_id`, `name`, `description`) VALUES
(1, 'extra small', 'this is for really skinny guys'),
(2, 'small', 'this is for skinny guys'),
(3, 'medium', 'this is for normal sized guys'),
(4, 'large', 'this is for slightly bigger guys'),
(5, 'extra large', 'this is for big guys');
