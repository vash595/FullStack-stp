-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2025 at 02:27 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `florifydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` varchar(100) DEFAULT NULL,
  `Address` varchar(300) DEFAULT NULL,
  `order_amount` int(11) DEFAULT NULL,
  `payment_mode` varchar(20) DEFAULT NULL,
  `order_status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `product_id`, `Address`, `order_amount`, `payment_mode`, `order_status`) VALUES
(1, 2, '1,', '0', 1234, 'cod', 'Pending'),
(2, 2, '1,', '0', 1234, 'cod', 'Pending'),
(3, 2, '2,1', '0', 2734, '', 'Pending'),
(4, 2, '2,1', '0', 2734, '', 'Pending'),
(5, 2, '2,1', '0', 2734, '', 'Pending'),
(6, 2, '2,1', '0', 2734, 'cod', 'Pending'),
(7, 2, '2,1', '0', 2734, 'cod', 'Pending'),
(8, 2, '1,4', '0', 1374, 'cod', 'Pending'),
(9, 2, '1', '0', 1234, 'online', 'Pending'),
(10, 2, '9,10', '0', 15400, 'cod', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(40) DEFAULT NULL,
  `product_price` int(11) DEFAULT NULL,
  `product_description` varchar(300) DEFAULT NULL,
  `product_image` varchar(100) DEFAULT NULL,
  `product_type` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_price`, `product_description`, `product_image`, `product_type`) VALUES
(1, 'Bloom Burst', 1234, 'Bloom Burst is a joyful offering, created to light up her day like she lights up yours. Anna Karina roses bloom in full colour alongside golden helichrysum, soft yellow carnations, and bright yellow Asiatic lilies. Eucalyptus and yellow solidago add a gentle, airy flourish. Wrapped in peach-toned la', 'products/product_6884ae17052968.10846002.png', 'birthday'),
(2, 'Lilac Morning', 1500, 'As gentle as first light, Lilac Morning unfolds in soft, layered hues with sweet avalanche roses, deep purple roses, mauve spray chrysanthemum, purple daisies, pink santinis, a white spray carnation, and a wisp of purple eucalyptus. Wrapped in lavender with off-white tissue and tied with a purple ri', 'products/product_688681b5db8ad0.43985967.png', 'anniversary'),
(3, 'roses', 1500, 'hdk,ufjhm', 'products/product_6887787738cf64.80513561.png', 'anniversary'),
(4, 'Lilac Morning', 140, 'sdf', 'products/product_6888c83a7e8df2.19719526.png', 'birthday'),
(5, 'Red Rose', 4000, 'They say the meaning behind a single rose is love at first sight! This single red rose lays within an alluring presentation box, tied off with classy black ribbon. This romantic gift is an elegant way to show your love and appreciation. Order First Red Rose today!', 'products/product_6889fbbde4f7f8.55547627.png', 'birthday'),
(6, 'Divine Blooms', 6000, 'This vibrant flower bouquet of red roses, chrysanthemum and lisianthus are presented with bright touches of green and expertly wrapped. Tied with ribbon and delivered to your recipient, they will adore this divine floral gift.', 'products/product_6889fc2c9364f1.96137263.png', 'birthday'),
(7, 'Single Plant', 6000, 'This vibrant flower bouquet of red roses, chrysanthemum and lisianthus are presented with bright touches of green and expertly wrapped. Tied with ribbon and delivered to your recipient, they will adore this divine floral gift.', 'products/product_6889fc8ab224f3.63026240.png', 'birthday'),
(8, 'Sweet Gerberas', 5000, 'This petite floral arrangement is the perfect way to show a loved one that you’re thinking of them. Delicate white daisies, pink gerberas and spray roses, are presented amongst lovely white and green, in a white box with pink ribbon. Add a balloon or teddy bear to complement the charming Sweet Gerbe', 'products/product_6889fce52762e0.85249360.png', 'birthday'),
(9, 'Fruit Hamper', 5500, 'Disclaimer: Fruits may vary due to season Show loved ones you are thinking of them with this brightly fruit hamper. Brimming with an assortment of seasonal fresh fruit, Classic Fruity Gift Hamper is carefully presented and tied with ribbon. Ideal for almost every occasion, brighten their day with th', 'products/product_6889fd3369fa35.22772760.png', 'birthday'),
(10, 'Pink Roses', 9900, 'Impress them with this decadent gold pot overflowing with vibrant blooms and lush foliage. A stunning mix of pink roses, purple chrysanthemums, purple stock, amongst lime, and emerald foliage, expertly arranged by a local florist. This flower arrangement will delight your recipient', 'products/product_6889fd7c29a8f1.85913813.png', 'birthday'),
(11, 'Love Florals', 5500, 'Flowers pictured are the smallest size. The Eternal Love Florals Bouquet is a heartfelt floral arrangement designed to express deepest condolences and honour the memory of a loved one. This funeral bouquet features pink oriental lily, pink snapdragon, pink alstroemeria, and hot pink spray rose, care', 'products/product_6889fe01647806.71391376.png', 'birthday'),
(12, 'Eternal Rose', 4500, 'Wow your loved one with this gorgeous rose bouquet in a vase. Eternal Roses features 12 stunning red roses in a modern, reusable glass vase. They won&#039;t be able to resist this romantic gesture. Show your eternal love and order fresh flowers online today.', 'products/product_6889fe4d69fac6.88066521.png', 'birthday'),
(13, 'Colorful Gerberas', 7500, 'Celebrate with Colourful Gerberas! This explosion of colourful gerberas is sure to delight, featuring yellow, orange, pink gerberas wrapped in white paper, tied with a pink ribbon. They&#039;ll be drawn to this striking floral gift that evokes happiness, love and laughter, making this gerbera bouque', 'products/product_6889fea0696381.20869035.png', 'birthday'),
(14, 'Aquarius', 7700, 'Orchids represent the resilient and go with the flow traits that fit an Aquarius’ personality. You’re considered to be genuine, loyal, dependable and down-to-earth. You value family and friendship and would go to great lengths to show them how much you care for them.', 'products/product_6889feed236ac9.23209596.png', 'birthday'),
(15, '12 Roses Stems', 8800, 'The colors or floral varieties used in this bouquet will vary based on freshness and availability. Our Florist Originals Bouquets are created by local florists using the finest quality flowers. The actual design you or your recipient will receive will be different from the images shown here.', 'products/product_6889ffa51b1f40.36297020.png', 'anniversary'),
(16, 'Afternoon Tea Bouquet', 6780, 'Bright and beautiful, the Afternoon Tea Bouquet is the perfect jolt of energy in any space. Please Note: The bouquet pictured reflects our original design for this product. While we always try to follow the color palette, we may replace stems to deliver the freshest bouquet possible, and we may some', 'products/product_6889fff329c594.43409908.png', 'anniversary'),
(17, 'FIESTA BOUQUET', 4400, 'Combination of vibrant flowers arranged in a vase.The bouquet pictured reflects our original design for this product. While we always try to follow the color palette, we may replace stems to deliver the freshest bouquet possible, and we may sometimes need to use a different vase.', 'products/product_688a008acfceb8.44749025.png', 'anniversary'),
(18, 'Hope and Serenity Bouquet', 5675, 'A collection of lilies, roses and alstroemeria add freshness to your messages of love. Please Note: The bouquet pictured reflects our original design for this product. While we always try to follow the color palette, we may replace stems to deliver the freshest bouquet possible, and we may sometimes', 'products/product_688a00e81d4249.88368460.png', 'anniversary'),
(19, 'Eternal Friendship Bouquette', 9988, 'White flowers arranged in a vase The arrangement pictured reflects our original design for this product. While we always try to follow the color palette, we may replace stems to deliver the freshest bouquet possible, and we may sometimes need to use a different vase', 'products/product_688a015227ee16.58254582.png', 'anniversary'),
(20, 'Precious Bouquette', 7845, 'The bouquet pictured reflects our original design for this product. While we always try to follow the color palette, we may replace stems to deliver the freshest bouquet possible, and we may sometimes need to use a different vase.', 'products/product_688a01fbb1e433.03309366.png', 'anniversary');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `emailed` varchar(30) DEFAULT NULL,
  `password` varchar(30) DEFAULT NULL,
  `phoneno` bigint(20) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `emailed`, `password`, `phoneno`, `role`) VALUES
(2, 'mraduul', 'mraduul@a.a', 'asd', 1234, 'client'),
(7, 'Mradul Sharma', 'bittochikusharma@gmail.com', '$2y$10$NzwtzP/VArbadP90MpdZ3ep', 8696968289, 'client');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `emailed` (`emailed`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
