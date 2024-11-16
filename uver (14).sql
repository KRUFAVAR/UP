-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 08 2024 г., 18:02
-- Версия сервера: 5.7.39
-- Версия PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `uver`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Cart`
--

CREATE TABLE `Cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `Cart`
--

INSERT INTO `Cart` (`cart_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 21, '2024-11-04 22:01:45', '2024-11-04 22:01:45'),
(2, 21, '2024-11-04 23:22:08', '2024-11-07 23:22:08'),
(3, 21, '2024-11-04 23:23:22', '2024-11-04 23:23:22'),
(4, 21, '2024-11-05 07:03:25', '2024-11-05 07:03:25'),
(5, 21, '2024-11-05 07:51:45', '2024-11-05 07:51:45'),
(6, 21, '2024-11-05 07:54:16', '2024-11-05 07:54:16'),
(7, 21, '2024-11-05 07:54:19', '2024-11-05 07:54:19'),
(8, 21, '2024-11-05 07:54:32', '2024-11-05 07:54:32'),
(9, 21, '2024-11-05 07:57:21', '2024-11-05 07:57:21'),
(10, 21, '2024-11-05 07:57:55', '2024-11-05 07:57:55'),
(11, 21, '2024-11-05 07:58:20', '2024-11-05 07:58:20'),
(12, 21, '2024-11-05 07:58:24', '2024-11-05 07:58:24'),
(13, 21, '2024-11-05 07:59:09', '2024-11-05 07:59:09'),
(14, 21, '2024-11-05 08:01:09', '2024-11-05 08:01:09'),
(15, 21, '2024-11-05 08:02:06', '2024-11-05 08:02:06'),
(16, 21, '2024-11-05 08:03:54', '2024-11-05 08:03:54'),
(17, 21, '2024-11-05 08:04:24', '2024-11-05 08:04:24'),
(18, 21, '2024-11-05 08:04:46', '2024-11-05 08:04:46'),
(19, 21, '2024-11-05 08:08:42', '2024-11-05 08:08:42'),
(20, 21, '2024-11-05 08:11:20', '2024-11-05 08:11:20'),
(21, 21, '2024-11-05 08:24:24', '2024-11-05 08:24:24'),
(22, 21, '2024-11-05 08:27:46', '2024-11-05 08:27:46'),
(23, 21, '2024-11-05 08:51:52', '2024-11-05 08:51:52'),
(24, 21, '2024-11-06 09:05:09', '2024-11-08 14:16:31'),
(25, 21, '2024-11-05 09:14:58', '2024-11-05 09:14:58'),
(26, 21, '2024-11-05 09:15:57', '2024-11-05 09:15:57'),
(27, 21, '2024-11-05 09:20:02', '2024-11-05 09:20:02'),
(28, 21, '2024-11-05 09:20:19', '2024-11-05 09:20:19'),
(29, 21, '2024-11-05 09:20:27', '2024-11-05 09:20:27'),
(30, 21, '2024-11-05 09:20:51', '2024-11-05 09:20:51'),
(31, 21, '2024-11-05 09:21:04', '2024-11-05 09:21:04'),
(32, 21, '2024-11-05 09:21:43', '2024-11-05 09:21:43'),
(33, 21, '2024-11-05 09:21:51', '2024-11-05 09:21:51'),
(34, 21, '2024-11-05 06:22:15', '2024-11-05 06:22:15'),
(35, 21, '2024-11-05 06:23:00', '2024-11-05 06:23:00'),
(36, 21, '2024-11-05 06:24:05', '2024-11-05 06:24:05'),
(37, 21, '2024-11-05 06:25:10', '2024-11-05 06:25:10'),
(38, 21, '2024-11-08 06:26:00', '2024-11-08 14:16:23'),
(39, 21, '2024-11-05 06:27:15', '2024-11-05 06:27:15'),
(40, 21, '2024-11-05 06:28:00', '2024-11-05 06:28:00'),
(41, 21, '2024-11-05 06:29:00', '2024-11-05 06:29:00'),
(42, 21, '2024-11-05 06:30:10', '2024-11-05 06:30:10'),
(43, 21, '2024-11-05 06:31:20', '2024-11-05 06:31:20'),
(44, 21, '2024-11-05 06:32:00', '2024-11-05 06:32:00'),
(45, 21, '2024-11-05 06:33:00', '2024-11-05 06:33:00'),
(46, 21, '2024-11-05 06:34:30', '2024-11-05 06:34:30'),
(47, 21, '2024-11-05 06:35:15', '2024-11-05 06:35:15');

-- --------------------------------------------------------

--
-- Структура таблицы `Cart_Items`
--

CREATE TABLE `Cart_Items` (
  `item_id` int(11) NOT NULL,
  `order_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT '1',
  `price` decimal(10,2) NOT NULL,
  `action_type` enum('add','update','remove') COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `Cart_Items`
--

INSERT INTO `Cart_Items` (`item_id`, `order_number`, `cart_id`, `product_id`, `quantity`, `price`, `action_type`, `timestamp`) VALUES
(1, NULL, 1, 11, 2, '500.00', 'add', '2024-11-05 08:31:54'),
(2, NULL, 34, 10, 1, '3000.00', 'add', '2024-11-05 06:32:45'),
(3, NULL, 35, 11, 2, '10000.00', 'add', '2024-11-05 06:33:15'),
(4, NULL, 36, 12, 1, '7000.00', 'add', '2024-11-05 06:34:00'),
(5, NULL, 37, 13, 1, '20000.00', 'add', '2024-11-05 06:35:00'),
(6, NULL, 38, 14, 1, '2500.00', 'add', '2024-11-05 06:36:00'),
(7, NULL, 39, 15, 1, '3500.00', 'add', '2024-11-05 06:37:00'),
(8, NULL, 40, 16, 2, '1800.00', 'add', '2024-11-05 06:38:00'),
(9, NULL, 41, 17, 3, '1200.00', 'add', '2024-11-05 06:39:00'),
(10, NULL, 42, 18, 1, '2200.00', 'add', '2024-11-05 06:40:00'),
(11, NULL, 43, 19, 2, '1000.00', 'add', '2024-11-05 06:41:00'),
(12, NULL, 44, 20, 3, '1500.00', 'add', '2024-11-05 06:42:00'),
(13, NULL, 45, 21, 1, '2500.00', 'add', '2024-11-05 06:43:00'),
(14, NULL, 46, 25, 1, '3000.00', 'add', '2024-11-05 06:44:00');

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Rings'),
(2, 'Necklaces'),
(3, 'Earrings'),
(4, 'Bracelets'),
(5, 'Watches'),
(6, 'Brooches'),
(7, 'Pendants'),
(8, 'Chains'),
(9, 'Charms'),
(10, 'Anklets'),
(11, 'Cufflinks'),
(12, 'Rings - Custom'),
(13, 'Luxury Watches'),
(14, 'Bracelets - Custom'),
(15, 'Pendants - Unique'),
(16, 'Engraved Items'),
(17, 'Personalized Gifts'),
(18, 'Gold Jewelry'),
(19, 'Diamond Jewelry'),
(20, 'Gemstones'),
(21, 'Exotic Metals'),
(22, 'Jewelry for Men'),
(23, 'Bridal Jewelry'),
(24, 'Vintage Jewelry'),
(25, 'Limited Editions');

-- --------------------------------------------------------

--
-- Структура таблицы `Jewelers`
--

CREATE TABLE `Jewelers` (
  `jeweler_id` int(11) NOT NULL,
  `first_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `specialization` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `Jewelers`
--

INSERT INTO `Jewelers` (`jeweler_id`, `first_name`, `last_name`, `specialization`) VALUES
(2, 'Olivia', 'Taylor', 'Silversmith'),
(3, 'Michael', 'Martinez', 'Gemstone Specialist'),
(4, 'Sophia', 'Clark', 'Jewelry Designer'),
(5, 'Liam', 'Walker', 'Repair Specialist'),
(8, 'Diamond', 'King', NULL),
(9, 'Ruby', 'Queen', NULL),
(10, 'Emerald', 'Prince', NULL),
(16, 'James', 'Carter', 'Goldsmith'),
(17, 'Grace', 'Harrison', 'Silversmith'),
(18, 'Ethan', 'Brown', 'Gemstone Specialist'),
(19, 'Lucas', 'Davis', 'Jewelry Designer'),
(20, 'Mason', 'Rodriguez', 'Repair Specialist'),
(21, 'Ella', 'Martinez', 'Silversmith'),
(22, 'Henry', 'Lee', 'Goldsmith'),
(23, 'Amelia', 'Young', 'Gemstone Specialist'),
(24, 'Oliver', 'Harris', 'Jewelry Designer'),
(25, 'Sophia', 'Walker', 'Repair Specialist'),
(26, 'Jackson', 'Scott', 'Jewelry Designer'),
(27, 'Avery', 'King', 'Goldsmith'),
(28, 'Harper', 'Adams', 'Silversmith'),
(29, 'Jack', 'Baker', 'Gemstone Specialist');

-- --------------------------------------------------------

--
-- Структура таблицы `Materials`
--

CREATE TABLE `Materials` (
  `material_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `material_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `Materials`
--

INSERT INTO `Materials` (`material_id`, `name`, `material_type`, `unit_cost`) VALUES
(1, 'Gold', NULL, NULL),
(2, 'Silver', NULL, NULL),
(3, 'Platinum', NULL, NULL),
(4, 'Titanium', NULL, NULL),
(5, 'Steel', NULL, NULL),
(6, 'Bronze', NULL, NULL),
(7, 'Copper', NULL, NULL),
(8, 'Palladium', NULL, NULL),
(9, 'Nickel', NULL, NULL),
(10, 'Tungsten', NULL, NULL),
(11, 'Zirconium', 'Metal', '500.00'),
(12, 'Palladium', 'Metal', '600.00'),
(13, 'Titanium', 'Metal', '700.00'),
(14, 'Platinum', 'Metal', '1200.00'),
(15, 'Aluminum', 'Metal', '150.00'),
(16, 'Copper', 'Metal', '100.00'),
(17, 'Rhodium', 'Metal', '900.00'),
(18, 'Silver', 'Metal', '200.00'),
(19, 'Gold', 'Metal', '1000.00'),
(20, 'Diamond', 'Gemstone', '5000.00'),
(21, 'Ruby', 'Gemstone', '3000.00'),
(22, 'Emerald', 'Gemstone', '2500.00'),
(23, 'Sapphire', 'Gemstone', '2000.00'),
(24, 'Opal', 'Gemstone', '1500.00');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jeweler_id` int(11) DEFAULT NULL,
  `material` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `year_of_creation` year(4) DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sku` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('В продаже','В наличии','Нет в наличии') COLLATE utf8mb4_unicode_ci DEFAULT 'Нет в наличии',
  `category_id` int(11) DEFAULT NULL,
  `discount` decimal(5,2) DEFAULT '0.00',
  `shop_id` int(11) DEFAULT NULL,
  `op` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`product_id`, `name`, `jeweler_id`, `material`, `weight`, `price`, `year_of_creation`, `photo`, `sku`, `status`, `category_id`, `discount`, `shop_id`, `op`) VALUES
(2, 'Silver Necklace', 2, 'Silver', '10.00', '3000.00', 2022, 'Без имени-1 копия.jpg', '21', 'В наличии', 2, '25.00', 2, 'уацуацаываыа'),
(4, 'Ruby Bracelet', 4, 'Gold', '7.50', '7000.00', 2021, NULL, NULL, 'Нет в наличии', 4, '0.00', 4, NULL),
(5, 'Platinum Watch', 5, 'Platinum', '15.00', '20000.00', 2023, NULL, NULL, 'Нет в наличии', 5, '0.00', 5, NULL),
(6, 'Silver Brooch', NULL, 'Silver', '3.00', '2500.00', 2019, NULL, NULL, 'Нет в наличии', 6, '0.00', 6, NULL),
(7, 'Gold Pendant', NULL, 'Gold', '4.00', '3500.00', 2022, NULL, NULL, 'Нет в наличии', 7, '0.00', 7, NULL),
(10, 'Bronze Anklet', 10, 'Bronze', '6.00', '2200.00', 2023, 'i (1).jpg', '', 'Нет в наличии', 10, '0.00', 10, ''),
(11, 'Ring_Gold_black', 8, 'Gold', '12.00', '1000.00', 2005, 'photo_2024-11-01_17-44-05.jpg', '12', 'В продаже', 1, '5.00', 2, ''),
(12, 'Custom Silver Necklace', 16, 'Silver', '5.00', '1500.00', 2023, NULL, '22', 'В продаже', 2, '15.00', 2, 'Custom design'),
(13, 'Luxury Diamond Earrings', 17, 'Diamond', '2.00', '8000.00', 2022, '', '25', 'В наличии', 3, '10.00', 2, 'High quality'),
(14, 'Titanium Watch', 18, 'Titanium', '10.00', '5000.00', 2024, NULL, '35', 'В продаже', 5, '5.00', 3, 'Limited Edition'),
(15, 'Gold Engagement Ring', 19, 'Gold', '7.00', '3000.00', 2023, '', '29', 'В продаже', 6, '15.00', 1, 'Wedding collection'),
(16, 'Platinum Necklace', 20, 'Platinum', '3.00', '5000.00', 2024, NULL, '38', 'В наличии', 7, '8.00', 1, 'High quality'),
(17, 'Exotic Gemstone Pendant', 21, 'Emerald', '1.50', '2000.00', 2023, NULL, '45', 'В продаже', 2, '10.00', 5, 'Luxury collection'),
(18, 'Personalized Silver Bracelet', 22, 'Silver', '4.00', '2500.00', 2024, NULL, '51', 'В продаже', 8, '15.00', 5, 'Custom design'),
(19, 'Gold Chain Necklace', 23, 'Gold', '6.00', '3500.00', 2023, NULL, '63', 'В наличии', 4, '12.00', 1, 'New arrival'),
(20, 'Sapphire Ring', 24, 'Sapphire', '2.00', '5000.00', 2023, NULL, '72', 'В продаже', 9, '10.00', 2, 'Limited Edition'),
(21, 'Vintage Cufflinks', 25, 'Gold', '1.50', '1200.00', 2024, NULL, '80', 'В наличии', 5, '5.00', 3, 'Limited Edition'),
(22, 'Engraved Gold Necklace', 26, 'Gold', '8.00', '4500.00', 2024, NULL, '85', 'В продаже', 6, '8.00', 2, 'Customizable'),
(23, 'Luxury Watch with Diamonds', 27, 'Platinum', '15.00', '18000.00', 2022, '', '90', 'В продаже', 3, '20.00', 4, 'Exclusive collection'),
(24, 'Custom-made Bracelet', 28, 'Silver', '3.00', '2300.00', 2024, 'custom-bracelet.jpg', '102', 'В наличии', 8, '10.00', 5, 'Custom design'),
(25, 'Rose Gold Necklace', 29, 'Gold', '7.00', '4000.00', 2023, 'rose-gold-necklace.jpg', '110', 'В наличии', 7, '12.00', 2, 'New collection');

-- --------------------------------------------------------

--
-- Структура таблицы `Repairs`
--

CREATE TABLE `Repairs` (
  `repair_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `repair_date` date NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `Repairs`
--

INSERT INTO `Repairs` (`repair_id`, `product_id`, `repair_date`, `description`, `cost`) VALUES
(1, 1, '2024-01-15', 'Cleaned and polished', NULL),
(2, 2, '2024-01-16', 'Chain repaired', NULL),
(3, 3, '2024-01-17', 'Stone replaced', NULL),
(4, 4, '2024-01-18', 'Clasp adjusted', NULL),
(5, 5, '2024-01-19', 'Engraving added', NULL),
(6, 6, '2024-01-20', 'Link replaced', NULL),
(7, 7, '2024-01-21', 'Reshaped', NULL),
(8, 8, '2024-01-22', 'Cleaning', NULL),
(9, 9, '2024-01-23', 'Polished', NULL),
(10, 10, '2024-01-24', 'Length adjusted', NULL),
(11, 16, '2024-11-05', 'Cleaned and polished', '500.00'),
(12, 17, '2024-11-06', 'Chain repaired', '700.00'),
(13, 18, '2024-11-07', 'Refurbished clasp', '350.00'),
(14, 19, '2024-11-08', 'Replaced gem', '1500.00'),
(15, 20, '2024-11-08', 'Engraved initials', '300.00'),
(16, 21, '2024-11-09', 'Repaired bracelet', '1000.00'),
(17, 22, '2024-11-10', 'Polished metal', '400.00'),
(18, 23, '2024-11-11', 'Refurbished ring band', '800.00'),
(19, 24, '2024-11-12', 'Polished and resized', '600.00'),
(20, 25, '2024-11-12', 'Cleaned and adjusted', '250.00'),
(21, 26, '2024-11-13', 'Replaced stones', '1200.00'),
(22, 27, '2024-11-14', 'Replicated design', '1500.00'),
(23, 28, '2024-11-15', 'Repaired clasp', '400.00'),
(24, 29, '2024-11-16', 'Custom adjustments', '200.00');

-- --------------------------------------------------------

--
-- Структура таблицы `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comments` text COLLATE utf8mb4_unicode_ci,
  `rating` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `review`
--

INSERT INTO `review` (`id`, `product_id`, `user_id`, `comments`, `rating`, `created_at`) VALUES
(5, 5, 10, 'Luxurious watch.', 5, '2024-10-30 17:21:53'),
(6, 6, 11, 'Lovely brooch.', 4, '2024-10-30 17:21:53'),
(7, 7, 12, 'Stunning pendant.', 5, '2024-10-30 17:21:53'),
(10, 10, 15, 'Nice anklet.', 4, '2024-10-30 17:21:53'),
(26, 12, 4, 'Great quality! Really loved the craftsmanship.', 5, '2024-11-04 21:00:00'),
(27, 13, 12, 'Beautiful earrings, but a bit expensive.', 4, '2024-11-05 21:00:00'),
(28, 14, 13, 'Absolutely amazing watch. Worth every penny!', 5, '2024-11-06 21:00:00'),
(29, 15, 14, 'Engagement ring is beautiful, but the stone is a little small.', 4, '2024-11-07 21:00:00'),
(30, 16, 15, 'This necklace exceeded my expectations. Stunning piece!', 5, '2024-11-08 21:00:00'),
(31, 17, 16, 'Good quality but it arrived late.', 3, '2024-11-09 21:00:00'),
(32, 18, 17, 'Love this pendant! A perfect gift.', 5, '2024-11-10 21:00:00'),
(33, 19, 18, 'Nice ring, but a little tight.', 4, '2024-11-11 21:00:00'),
(34, 20, 19, 'Great ring, the sapphire is breathtaking.', 5, '2024-11-12 21:00:00'),
(35, 21, 20, 'These cufflinks are stunning!', 5, '2024-11-13 21:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `Roles`
--

CREATE TABLE `Roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `Roles`
--

INSERT INTO `Roles` (`role_id`, `role_name`) VALUES
(1, 'Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Структура таблицы `shop`
--

CREATE TABLE `shop` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `shop`
--

INSERT INTO `shop` (`id`, `name`, `address`, `contact`) VALUES
(1, 'Downtown Shop', NULL, NULL),
(2, 'Mall Shop', NULL, NULL),
(3, 'Airport Shop', NULL, NULL),
(4, 'High Street Shop', NULL, NULL),
(5, 'Outlet Shop', NULL, NULL),
(6, 'Luxury Shop', NULL, NULL),
(7, 'Vintage Shop', NULL, NULL),
(8, 'New Age Shop', NULL, NULL),
(9, 'Express Shop', NULL, NULL),
(10, 'Online Shop', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `Stones`
--

CREATE TABLE `Stones` (
  `stone_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stone_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `carat_weight` decimal(10,2) DEFAULT NULL,
  `unit_cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `Stones`
--

INSERT INTO `Stones` (`stone_id`, `name`, `stone_type`, `carat_weight`, `unit_cost`) VALUES
(1, 'Diamond', NULL, NULL, NULL),
(2, 'Ruby', NULL, NULL, NULL),
(3, 'Emerald', NULL, NULL, NULL),
(4, 'Sapphire', NULL, NULL, NULL),
(5, 'Amethyst', NULL, NULL, NULL),
(6, 'Topaz', NULL, NULL, NULL),
(7, 'Opal', NULL, NULL, NULL),
(8, 'Onyx', NULL, NULL, NULL),
(9, 'Pearl', NULL, NULL, NULL),
(10, 'Quartz', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `Users`
--

CREATE TABLE `Users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'default/xb.jpg',
  `role_id` int(11) DEFAULT '2',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `phone_number` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `online_status` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `Users`
--

INSERT INTO `Users` (`user_id`, `username`, `email`, `password`, `profile_picture`, `role_id`, `created_at`, `phone_number`, `address`, `last_login`, `online_status`) VALUES
(4, 'test2', 'uvvdwetgv@mailru', '$2y$10$sN/tnisrkbPCqE1CtoRTsuq8KFeze.jnDLPDUIlKtpDp5fmY0Y6CO', 'anime-anime-girls-Oshi-no-Ko-Kurokawa-Akane-Japanese-tears-crying-short-hair-looking-at-viewer-gradient-hair-two-tone-hair-2248766.jpg', 1, '2024-08-23 13:36:11', '', '', NULL, 0),
(10, 'admin', 'admin@example.com', 'password1', 'default/xb.jpg', 1, '2024-10-30 17:08:25', NULL, NULL, NULL, 0),
(11, 'user1', 'user1@example.com', 'password2', 'default/xb.jpg', 2, '2024-10-30 17:08:25', NULL, NULL, NULL, 0),
(12, 'user2', 'user2@example.com', 'password3', 'default/xb.jpg', 2, '2024-10-30 17:08:25', NULL, NULL, NULL, 0),
(13, 'user3', 'user3@example.com', 'password4', 'default/xb.jpg', 2, '2024-10-30 17:08:25', NULL, NULL, NULL, 0),
(14, 'user4', 'user4@example.com', 'password5', 'default/xb.jpg', 2, '2024-10-30 17:08:25', NULL, NULL, NULL, 0),
(15, 'manager', 'manager@example.com', 'password6', 'default/xb.jpg', 2, '2024-10-30 17:08:25', NULL, NULL, NULL, 0),
(16, 'user5', 'user5@example.com', 'password7', 'default/xb.jpg', 2, '2024-10-30 17:08:25', NULL, NULL, NULL, 0),
(17, 'user6', 'user6@example.com', 'password8', 'default/xb.jpg', 2, '2024-10-30 17:08:25', NULL, NULL, NULL, 0),
(18, 'user7', 'user7@example.com', 'password9', 'default/xb.jpg', 2, '2024-10-30 17:08:25', NULL, NULL, NULL, 0),
(19, 'user8', 'user8@example.com', 'password10', 'default/xb.jpg', 2, '2024-10-30 17:08:25', NULL, NULL, NULL, 0),
(20, 'vadim', 'qweeqweew@mail.ru', '$2y$10$y/9mCxiT3XgUXHOUehdxGe6kBoTaYJMuK4Yy/dDjX23iUEn0icA4C', 'default/xb.jpg', 1, '2024-11-02 15:33:05', NULL, NULL, '2024-11-08 17:59:52', 0),
(21, 'vadim2', 'vdwhcfk@lejbf.ru', '$2y$10$pz6KAtveb32TJlpoDFh08OW6/Hw1IEfRNfW9Ylz9dop79nYRLq8AC', 'i (1).jpg', 2, '2024-11-03 13:01:09', NULL, NULL, '2024-11-08 17:59:58', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Cart`
--
ALTER TABLE `Cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `Cart_Items`
--
ALTER TABLE `Cart_Items`
  ADD PRIMARY KEY (`item_id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `Jewelers`
--
ALTER TABLE `Jewelers`
  ADD PRIMARY KEY (`jeweler_id`);

--
-- Индексы таблицы `Materials`
--
ALTER TABLE `Materials`
  ADD PRIMARY KEY (`material_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `jeweler_id` (`jeweler_id`),
  ADD KEY `fk_product_category` (`category_id`),
  ADD KEY `fk_product_shop` (`shop_id`);

--
-- Индексы таблицы `Repairs`
--
ALTER TABLE `Repairs`
  ADD PRIMARY KEY (`repair_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user` (`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `Roles`
--
ALTER TABLE `Roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Индексы таблицы `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `Stones`
--
ALTER TABLE `Stones`
  ADD PRIMARY KEY (`stone_id`);

--
-- Индексы таблицы `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Cart`
--
ALTER TABLE `Cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT для таблицы `Cart_Items`
--
ALTER TABLE `Cart_Items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `Jewelers`
--
ALTER TABLE `Jewelers`
  MODIFY `jeweler_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT для таблицы `Materials`
--
ALTER TABLE `Materials`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `Repairs`
--
ALTER TABLE `Repairs`
  MODIFY `repair_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT для таблицы `Roles`
--
ALTER TABLE `Roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `shop`
--
ALTER TABLE `shop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `Stones`
--
ALTER TABLE `Stones`
  MODIFY `stone_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `Users`
--
ALTER TABLE `Users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `Cart`
--
ALTER TABLE `Cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `Cart_Items`
--
ALTER TABLE `Cart_Items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `Cart` (`cart_id`),
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_product_shop` FOREIGN KEY (`shop_id`) REFERENCES `shop` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`jeweler_id`) REFERENCES `Jewelers` (`jeweler_id`);

--
-- Ограничения внешнего ключа таблицы `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`);

--
-- Ограничения внешнего ключа таблицы `Users`
--
ALTER TABLE `Users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `Roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
