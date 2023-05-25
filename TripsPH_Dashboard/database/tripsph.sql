-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2023 at 05:03 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tripsph`
--

-- --------------------------------------------------------

--
-- Table structure for table `bus_fare_collection`
--

CREATE TABLE `bus_fare_collection` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `card_user_id` bigint(20) UNSIGNED NOT NULL,
  `origin` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `total_fare` bigint(20) NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `transaction_details` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cards_user`
--

CREATE TABLE `cards_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `card_holder_name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `card_id_number` bigint(20) NOT NULL,
  `current_balance` bigint(20) NOT NULL,
  `status` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `card_reload`
--

CREATE TABLE `card_reload` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `card_user_id` bigint(20) UNSIGNED NOT NULL,
  `reload_amount` bigint(20) NOT NULL,
  `transaction_details` varchar(255) NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(39, 'admin', '$2y$10$WPhPgw6zVcmR/uKCXAjvr.PLXpHBbZZktq3C6ZWSVRo4UALmCwzOq', '2023-05-25 23:02:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bus_fare_collection`
--
ALTER TABLE `bus_fare_collection`
  ADD PRIMARY KEY (`id`),
  ADD KEY `card_user_id` (`card_user_id`);

--
-- Indexes for table `cards_user`
--
ALTER TABLE `cards_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `card_id_number` (`card_id_number`);

--
-- Indexes for table `card_reload`
--
ALTER TABLE `card_reload`
  ADD PRIMARY KEY (`id`),
  ADD KEY `card_user_id` (`card_user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bus_fare_collection`
--
ALTER TABLE `bus_fare_collection`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cards_user`
--
ALTER TABLE `cards_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `card_reload`
--
ALTER TABLE `card_reload`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bus_fare_collection`
--
ALTER TABLE `bus_fare_collection`
  ADD CONSTRAINT `bus_fare_collection_ibfk_1` FOREIGN KEY (`card_user_id`) REFERENCES `cards_user` (`id`);

--
-- Constraints for table `card_reload`
--
ALTER TABLE `card_reload`
  ADD CONSTRAINT `card_reload_ibfk_1` FOREIGN KEY (`card_user_id`) REFERENCES `cards_user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
