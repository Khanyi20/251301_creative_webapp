-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2026 at 08:43 AM
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
-- Database: `creative_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(50) NOT NULL,
  `item_condition` varchar(50) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `user_id`, `item_name`, `description`, `category`, `item_condition`, `image_path`, `status`, `created_at`) VALUES
(1, 5, 'Mysterious Pencil Case', 'A pencil case I have had since first year. I don\'t remember where it came from.', 'Stationary', 'Used', NULL, 'available', '2026-08-19 06:47:42'),
(2, 5, 'Book Of spells', 'A Blank Note Book that Looks old but new.', 'Stationary', 'New', NULL, 'traded', '2026-08-19 07:12:27'),
(4, 5, 'sample', 'sample', 'Stationary', 'New', 'uploads/items/item_6a86c0b5ab4143.06475566.jpg', 'available', '2026-08-20 08:54:13'),
(5, 5, 'Rubiks cube', 'play this game and see if you succeed.', 'Toy', 'New', 'uploads/items/item_6a8eced8daa7e2.83513214.jpg', 'traded', '2026-08-26 11:32:40'),
(7, 1, 'Argon Nuts', 'They are just nuts. Do what you will with them.', 'Plant', 'New', '', 'available', '2026-08-26 12:39:49'),
(9, 6, 'chess board', 'old chess board to play try it out.', 'Toy', 'Used', '', 'traded', '2026-08-27 06:28:10'),
(10, 7, 'Glass Heart', 'heart made of red and pink glass.', 'Toy', 'New', '', 'available', '2026-08-27 06:34:41');

-- --------------------------------------------------------

--
-- Table structure for table `trade_requests`
--

CREATE TABLE `trade_requests` (
  `id` int(11) NOT NULL,
  `requester_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trade_requests`
--

INSERT INTO `trade_requests` (`id`, `requester_id`, `item_id`, `status`, `created_at`) VALUES
(1, 1, 4, 'rejected', '2026-08-20 10:39:49'),
(2, 1, 2, 'rejected', '2026-08-20 11:08:10'),
(3, 1, 4, 'accepted', '2026-08-26 05:31:38'),
(4, 1, 1, 'accepted', '2026-08-26 05:32:30'),
(5, 1, 2, 'accepted', '2026-08-26 05:55:44'),
(6, 7, 7, 'rejected', '2026-08-27 06:33:29'),
(7, 7, 5, 'accepted', '2026-08-27 06:33:41'),
(8, 7, 9, 'accepted', '2026-08-27 06:33:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'testuser', 'test@example.com', '$2y$10$RfH55e3mFwpEmviom/0wSeGtaa6eK9lemqf8covUwGDTcCwzb7DeO', '2026-08-18 22:27:10'),
(5, 'test1', 'test1@example.com', '$2y$10$/MHSflRUOI/3lkoOJKOcS.l.xAOL6JWncgwaxXK.bC9HqRFwvRlSu', '2026-08-18 22:47:05'),
(6, 'Jane', 'jane123@gmail.com', '$2y$10$7r1ipTt5XD57D2LR/yak6ejtmYNneVuH2ZhcewnyCa1wg6f5U5bpS', '2026-08-27 06:16:32'),
(7, 'Kerry', 'kerry123@gmail.com', '$2y$10$NGIodIIdHyjlWZn5ONrRMeBADjOB..cmm9.J.uAy.SsYH1RlBskd2', '2026-08-27 06:32:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_items_user` (`user_id`);

--
-- Indexes for table `trade_requests`
--
ALTER TABLE `trade_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_trade_request_user` (`requester_id`),
  ADD KEY `fk_trade_request_item` (`item_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `trade_requests`
--
ALTER TABLE `trade_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `fk_items_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `trade_requests`
--
ALTER TABLE `trade_requests`
  ADD CONSTRAINT `fk_trade_request_item` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_trade_request_user` FOREIGN KEY (`requester_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
