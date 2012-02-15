INSERT INTO `product_styles` (`sid`, `name`, `pretty`, `description1`, `description2`, `campaign`, `label`, `category`, `gender`, `price`) VALUES
(1, 'Brazil Boxer Brief', 'brazil-boxer-brief', 'Seamless Front and Back', NULL, 'FW11', 'select', 'underwear', 'mens', 35.00),
(2, 'Original Boxer Brief', 'original-boxer-brief', 'The Fundamental Boxer Brief', NULL, 'FW11', 'select', 'underwear', 'mens', 35.00),
(3, 'Classic Brief', 'classic-brief', 'The Timeless Silhouette', NULL, 'FW11', 'select', 'underwear', 'mens', 35.00),
(4, 'Sexy Campbell Brief', 'sexy-campbell-brief', 'Less coverage than Classic Brief', NULL, 'FW11', 'select', 'underwear', 'mens', 35.00),
(5, 'Cowboy Brief', 'cowboy-brief', 'Two buttons for the open seam', NULL, 'FW11', 'select', 'underwear', 'mens', 35.00);

INSERT INTO `products` (`pid`, `ref_sid`, `ref_size`, `color`, `weight`, `sku`) VALUES
(1, 1, 0, 'black', 2.00, 0),
(2, 1, 1, 'black', 2.00, 0),
(3, 1, 2, 'black', 2.00, 0),
(4, 1, 3, 'black', 2.00, 1000),
(5, 1, 4, 'black', 2.00, 1000),
(6, 1, 5, 'black', 2.00, 0),
(7, 2, 0, 'black', 2.00, 0),
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

INSERT INTO `sizing_chart` (`size_id`, `name`, `description`) VALUES
(0, 'extra extra small', 'this size is for extremely skinny guys'),
(1, 'extra small', 'this is for really skinny guys'),
(2, 'small', 'this is for skinny guys'),
(3, 'medium', 'this is for normal sized guys'),
(4, 'large', 'this is for slightly bigger guys'),
(5, 'extra large', 'this is for big guys');


INSERT INTO `users` (`id`, `username`, `password`, `salt`, `role`, `date_created`) VALUES
(1, 'admin', 'Vamp5near', 'ce8d96d579d389e783f95b3772785783ea1a9854', 'administrator', '2011-11-24 21:17:02');
