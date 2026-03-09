-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Värd: mysql
-- Tid vid skapande: 20 feb 2026 kl 14:48
-- Serverversion: 8.0.40
-- PHP-version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `webbshopDB`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `customers`
--

CREATE TABLE `customers` (
  `id` int NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `zipcode` varchar(20) NOT NULL,
  `city` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumpning av Data i tabell `customers`
--

INSERT INTO `customers` (`id`, `firstname`, `lastname`, `phone`, `address`, `zipcode`, `city`, `email`, `created_at`) VALUES
(1, 'e', 'y', '44', 'ry', '45', 'rt', 'rt@gmail.com', '2026-02-17 17:05:55'),
(2, 'q', 'q', 'q', 'q', 'q', 'q', 'q@q.com', '2026-02-19 12:31:52'),
(3, 'eyad', 'hussen', '076666666', 'Storgatan', '23 223', 'Malmö', 'eyad@gmail.com', '2026-02-19 15:09:20'),
(4, 'David', 'TT', '012345678', 'qq', '12345', 'Malmö', 'q@gmail.com', '2026-02-20 14:29:36'),
(5, 'David', 'TT', '012345678', 'qq', '12345', 'Malmö', 'q@gmail.com', '2026-02-20 14:36:06'),
(6, 'a', 'a', '33', 'a3', '33333', '33', '3@gdg', '2026-02-20 14:43:34');

-- --------------------------------------------------------

--
-- Tabellstruktur `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `customer_id` int NOT NULL,
  `status` enum('Ordered','Packed','Shipped','Paid') DEFAULT 'Ordered',
  `order_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `total_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumpning av Data i tabell `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `status`, `order_date`, `total_amount`) VALUES
(1, 1, 'Ordered', '2026-02-17 17:05:55', 1800.00),
(3, 3, 'Packed', '2026-02-19 15:09:21', 1000.00),
(4, 5, 'Ordered', '2026-02-20 14:36:06', 600.00);

-- --------------------------------------------------------

--
-- Tabellstruktur `order_items`
--

CREATE TABLE `order_items` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumpning av Data i tabell `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `amount`) VALUES
(1, 1, 1, 2, 900.00),
(4, 3, 2, 1, 600.00),
(5, 3, 3, 1, 300.00),
(6, 3, 4, 1, 100.00),
(7, 4, 3, 2, 300.00);

-- --------------------------------------------------------

--
-- Tabellstruktur `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumpning av Data i tabell `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`) VALUES
(1, 'Laptop', 'Högpresterande dator', 900.00, 'images/laptop.jpg'),
(2, 'Powerbank', 'Kraftfull powerbank', 600.00, 'images/powerbank.jpg'),
(3, 'Hörlurar', 'Upp till 76 timmars batteritid', 300.00, 'images/headphones.jpg'),
(4, 'Tangentbord', 'Mekaniskt tangentbord', 100.00, 'images/keyboard.jpg'),
(5, 'Mus', 'Trådlös mus', 60.00, 'images/mouse.jpg');

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Index för tabell `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Index för tabell `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT för tabell `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT för tabell `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT för tabell `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Restriktioner för tabell `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
