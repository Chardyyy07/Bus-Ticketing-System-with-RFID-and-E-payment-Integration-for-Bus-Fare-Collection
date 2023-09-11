-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2023 at 08:11 AM
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
-- Table structure for table `passenger`
--

CREATE TABLE `passenger` (
  `No.` int(10) NOT NULL,
  `UM_ID` varchar(255) DEFAULT NULL,
  `Completed` varchar(255) DEFAULT NULL,
  `Entry_Time` varchar(255) DEFAULT NULL,
  `Entry_Location` varchar(255) DEFAULT NULL,
  `Exit_Time` varchar(255) DEFAULT NULL,
  `Exit_Location` varchar(255) DEFAULT NULL,
  `km_travel` decimal(10,2) NOT NULL DEFAULT 0.00,
  `Fare` decimal(10,2) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `passenger`
--

INSERT INTO `passenger` (`No.`, `UM_ID`, `Completed`, `Entry_Time`, `Entry_Location`, `Exit_Time`, `Exit_Location`, `km_travel`, `Fare`, `date_created`) VALUES
(1, 'e0 5a 89 51', 'Not Yet', '00/00/0,08:00AM', 'GPS NOT READY', '', '', 0.00, 0.00, '2023-07-31 05:41:44'),
(2, 'ab d1 3a 25', 'Not Yet', '00/00/0,08:00AM', 'GPS NOT READY', '', '', 0.00, 0.00, '2023-07-31 05:51:12'),
(3, 'ab d1 3a 25', 'Completed', '', '', '00/00/0,08:00AM', 'GPS NOT READY', 60.00, 126.00, '2023-07-31 06:05:45');

--
-- Triggers `passenger`
--
DELIMITER $$
CREATE TRIGGER `after_passenger_insert` AFTER INSERT ON `passenger` FOR EACH ROW BEGIN
    DECLARE last_total_balance DECIMAL(10,2);
    DECLARE trans_type ENUM('Departed','Arrived','Insufficient Balance');
    SET last_total_balance = (SELECT total_balance FROM rfid_transaction WHERE rfid = NEW.UM_ID ORDER BY id DESC LIMIT 1);
    IF last_total_balance IS NULL THEN
        SET last_total_balance = 0;
    END IF;

    IF NEW.Completed = 'Not Yet' THEN
        SET trans_type = 'Departed'; 
    ELSEIF NEW.Completed = 'Completed' THEN
        SET trans_type = 'Arrived'; 
    ELSE
        SET trans_type = 'Insufficient Balance';
    END IF;

    IF last_total_balance >= NEW.Fare AND last_total_balance >= 200 THEN
        INSERT INTO rfid_transaction (rfid, type, Fare, current_balance, total_balance, km_travel)
        VALUES (NEW.UM_ID, trans_type, NEW.Fare, last_total_balance, last_total_balance - NEW.Fare, NEW.km_travel);
    ELSE
        INSERT INTO rfid_transaction (rfid, type, Fare, current_balance, total_balance, km_travel)
        VALUES (NEW.UM_ID, 'Insufficient Balance', NEW.Fare, last_total_balance, last_total_balance, NEW.km_travel);
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `rfid_transaction`
--

CREATE TABLE `rfid_transaction` (
  `id` int(10) NOT NULL,
  `ticket_no.` varchar(20) NOT NULL,
  `rfid` varchar(20) NOT NULL,
  `type` enum('Completed','Not Yet','loading','failed','Arrived','Departed','Expired','Insufficient Balance') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `Fare` decimal(10,2) NOT NULL,
  `current_balance` decimal(10,2) NOT NULL,
  `total_balance` decimal(10,2) NOT NULL,
  `km_travel` decimal(10,2) NOT NULL DEFAULT 0.00,
  `valid_until` date DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rfid_transaction`
--

INSERT INTO `rfid_transaction` (`id`, `ticket_no.`, `rfid`, `type`, `amount`, `Fare`, `current_balance`, `total_balance`, `km_travel`, `valid_until`, `date_created`) VALUES
(1, '1-310723', 'ab d1 3a 25', 'failed', 500.00, 0.00, 0.00, 0.00, 0.00, '2029-07-31', '2023-07-31 05:36:01'),
(2, '2-310723', '22 7b 4f 4c', 'loading', 1000.00, 0.00, 0.00, 1000.00, 0.00, '2029-07-31', '2023-07-31 05:38:28'),
(3, '3-310723', 'e0 5a 89 51', 'Insufficient Balance', 0.00, 0.00, 0.00, 0.00, 0.00, '2029-07-31', '2023-07-31 05:41:44'),
(4, '4-310723', 'ab d1 3a 25', 'loading', 500.00, 0.00, 0.00, 500.00, 0.00, '2029-07-31', '2023-07-31 05:48:15'),
(5, '5-310723', 'ab d1 3a 25', 'Departed', 0.00, 0.00, 500.00, 500.00, 0.00, '2029-07-31', '2023-07-31 05:51:12'),
(6, '6-310723', 'ab d1 3a 25', 'Arrived', 0.00, 126.00, 500.00, 374.00, 60.00, '2029-07-31', '2023-07-31 06:05:45');

--
-- Triggers `rfid_transaction`
--
DELIMITER $$
CREATE TRIGGER `before_rfid_transaction_insert` BEFORE INSERT ON `rfid_transaction` FOR EACH ROW BEGIN
    DECLARE sequence_number INT;
    DECLARE today_suffix CHAR(6);

    -- Get the latest sequence number for the current date
    SET sequence_number = (
        SELECT COALESCE(MAX(CAST(SUBSTRING_INDEX(`ticket_no.`, '-', 1) AS SIGNED)) + 1, 1)
        FROM `rfid_transaction`
        WHERE DATE(`date_created`) = DATE(NOW())
    );

    -- Get today's date in the format 'ddmmyy'
    SET today_suffix = DATE_FORMAT(NOW(), '%d%m%y');

    -- Combine the sequence number and the suffix to create the ticket_no.
    SET NEW.`ticket_no.` = CONCAT(sequence_number, '-', today_suffix);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_rfid_transaction_insert_check_validity` BEFORE INSERT ON `rfid_transaction` FOR EACH ROW BEGIN
    DECLARE first_trans_date DATE;
    DECLARE expiry_date DATE;

    SET first_trans_date = (
        SELECT MIN(date_created) FROM rfid_transaction WHERE rfid = NEW.rfid
    );
    
    IF first_trans_date IS NOT NULL THEN
        SET expiry_date = DATE_ADD(first_trans_date, INTERVAL 6 YEAR);
        
        IF NOW() > expiry_date THEN
            SET NEW.type = 'Expired';
            SET NEW.amount = 0;
            SET NEW.Fare = 0;
            SET NEW.current_balance = 0;
            SET NEW.total_balance = 0;
            SET NEW.valid_until = expiry_date;
        ELSE
            SET NEW.valid_until = expiry_date;
        END IF;
    ELSE
        SET NEW.valid_until = DATE_ADD(NOW(), INTERVAL 6 YEAR);
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bus_management`
--

CREATE TABLE `tbl_bus_management` (
  `id` int(10) NOT NULL,
  `busno` varchar(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `purchdate` date NOT NULL,
  `operator` varchar(255) NOT NULL,
  `driver` varchar(255) NOT NULL,
  `route` varchar(255) NOT NULL,
  `status` enum('in-service','maintenance','not available') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_bus_management`
--

INSERT INTO `tbl_bus_management` (`id`, `busno`, `type`, `purchdate`, `operator`, `driver`, `route`, `status`, `created_at`, `updated_at`) VALUES
(1, '123', 'Deluxe', '2020-11-22', 'ABC Bus ', 'Arnold', 'Cubao - Alaminos, Pangasinan', 'in-service', '2023-06-27 07:42:40', '2023-06-27 07:42:40'),
(3, '431', 'Deluxe', '2021-04-23', 'Allan', 'Jose', 'Cubao-Bulacan', 'not available', '2023-06-28 00:11:53', '2023-07-03 16:26:34'),
(4, '1235', 'Ordinary', '2013-04-05', 'CBA ', 'Ryan ', ' Alaminos, Pangasinan - Cubao', 'maintenance', '2023-07-03 16:26:26', '2023-07-03 16:30:30');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_personnel`
--

CREATE TABLE `tbl_personnel` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `e_mail` varchar(255) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_personnel`
--

INSERT INTO `tbl_personnel` (`id`, `fullname`, `position`, `e_mail`, `contact`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Richard John Flores', 'Driver', 'chard@gmail.com', '0912345671', 'Antipolo City', '2023-06-25 08:13:08', '2023-07-04 08:23:16'),
(3, 'John Andrei Nunez', 'Cashier', 'Andrei@gmail.com', '09512356123', 'Marikina City', '2023-07-04 08:24:05', '2023-07-04 08:24:05'),
(4, 'Regienald Montalvo', 'Dispatcher', 'regie@gmail.com', '0945023351', 'Caloocan City', '2023-07-04 08:28:56', '2023-07-04 08:28:56');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reload_history`
--

CREATE TABLE `tbl_reload_history` (
  `id` int(10) NOT NULL,
  `rfid` varchar(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `paymethod` varchar(12) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_status` enum('Failed','Completed') NOT NULL DEFAULT 'Failed',
  `payment_intent` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_reload_history`
--

INSERT INTO `tbl_reload_history` (`id`, `rfid`, `email`, `paymethod`, `amount`, `payment_status`, `payment_intent`, `created_at`) VALUES
(1, 'ab d1 3a 25', 'chard@gmail.com', 'Card Payment', 500.00, 'Failed', NULL, '2023-07-31 05:36:01'),
(2, '22 7b 4f 4c', 'chard@gmail.com', 'Card Payment', 1000.00, 'Completed', 'pi_3NZoodIxDOHqY5HO1Xizg6ef', '2023-07-31 05:38:28'),
(3, 'ab d1 3a 25', 'chard@gmail.com', 'Card Payment', 500.00, 'Completed', 'pi_3NZoxxIxDOHqY5HO0tUGtsNh', '2023-07-31 05:48:15');

--
-- Triggers `tbl_reload_history`
--
DELIMITER $$
CREATE TRIGGER `after_tbl_reload_history_insert` AFTER INSERT ON `tbl_reload_history` FOR EACH ROW BEGIN
    DECLARE last_total_balance DECIMAL(10,2);
    SET last_total_balance = (SELECT total_balance FROM rfid_transaction WHERE rfid = NEW.rfid ORDER BY id DESC LIMIT 1);
    IF last_total_balance IS NULL THEN
        SET last_total_balance = 0;
    END IF;
    IF NEW.payment_intent IS NOT NULL THEN
        INSERT INTO rfid_transaction (rfid, type, amount, current_balance, total_balance)
        VALUES (NEW.rfid, 'loading', NEW.amount, last_total_balance, last_total_balance + NEW.amount);
    ELSE
        INSERT INTO rfid_transaction (rfid, type, amount, current_balance, total_balance)
        VALUES (NEW.rfid, 'Failed', NEW.amount, last_total_balance, last_total_balance);
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_tbl_reload_history_update` AFTER UPDATE ON `tbl_reload_history` FOR EACH ROW BEGIN
    DECLARE last_total_balance DECIMAL(10,2);
    SET last_total_balance = (SELECT total_balance FROM rfid_transaction WHERE rfid = NEW.rfid ORDER BY id DESC LIMIT 1);
    IF OLD.payment_intent IS NULL AND NEW.payment_intent IS NOT NULL THEN
        UPDATE rfid_transaction SET type = 'loading', current_balance = last_total_balance, total_balance = last_total_balance + NEW.amount WHERE rfid = NEW.rfid AND type = 'Failed' ORDER BY id DESC LIMIT 1;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `user_role_id` int(11) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(25) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `user_role_id`, `full_name`, `username`, `email`, `mobile`, `password`, `status`, `created_at`, `updated_at`) VALUES
(12, 1, 'Anya Forger', 'anyapeanut', 'anya@anya', '911', '$2y$10$EqgwvYW9IeTJFX/FOWpuk.AkFpiOHhzq/j7nqBjy0/AvGTXva4I5W', 1, '2023-06-16 22:42:38', '2023-06-18 15:33:34'),
(13, 2, 'Loid Forger', 'Starlight', 'loid@loid', '911', '$2y$10$bsxUXMaaTJRrjLn07uS/euhBhkz05kr.Pjm4geuGMh8sOGiI.e3aK', 1, '2023-06-16 22:43:39', '2023-06-16 22:43:47'),
(14, 3, 'Yor Forger', 'YorAssassin', 'yor@yor', '911', '$2y$10$Hfbganfaunj54se//hpvEu7s4yTKMdX/2YDeRFcoYKejRsZKD9Mli', 1, '2023-06-16 22:45:37', '2023-07-26 22:30:08');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_role`
--

CREATE TABLE `tbl_user_role` (
  `id` int(11) NOT NULL,
  `user_role` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user_role`
--

INSERT INTO `tbl_user_role` (`id`, `user_role`) VALUES
(1, 'Admin'),
(2, 'Editor'),
(3, 'User Only');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `passenger`
--
ALTER TABLE `passenger`
  ADD PRIMARY KEY (`No.`);

--
-- Indexes for table `rfid_transaction`
--
ALTER TABLE `rfid_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_reload_history`
--
ALTER TABLE `tbl_reload_history`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `passenger`
--
ALTER TABLE `passenger`
  MODIFY `No.` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rfid_transaction`
--
ALTER TABLE `rfid_transaction`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_reload_history`
--
ALTER TABLE `tbl_reload_history`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
