-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2024 at 06:47 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bank`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `account_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `balance` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `user_id`, `balance`) VALUES
(1, 1, 18838.00),
(2, 2, 3069.00);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` enum('Deposit','Withdrawal') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `user_id`, `type`, `amount`, `balance`, `timestamp`) VALUES
(1, 1, 'Deposit', 1000.00, 1000.00, '2024-02-14 18:09:16'),
(2, 2, 'Deposit', 10.00, 10.00, '2024-02-20 19:23:45'),
(3, 1, 'Deposit', 200.00, 300.00, '2024-02-21 09:58:45'),
(4, 1, 'Deposit', 578.00, 878.00, '2024-02-21 09:58:56'),
(5, 1, 'Deposit', 456.00, 1334.00, '2024-02-21 09:59:03'),
(6, 1, 'Deposit', 200.00, 1534.00, '2024-02-21 10:21:26'),
(7, 1, 'Deposit', 40.00, 1574.00, '2024-02-21 10:23:04'),
(8, 1, 'Deposit', 500.00, 2074.00, '2024-02-21 10:25:41'),
(9, 1, 'Deposit', 1000.00, 3074.00, '2024-02-21 10:26:21'),
(10, 1, 'Deposit', 100.00, 3174.00, '2024-02-21 10:32:16'),
(11, 2, 'Deposit', 1000.00, 1500.00, '2024-02-21 15:25:42'),
(12, 2, 'Deposit', 1000.00, 2500.00, '2024-02-21 15:25:53'),
(13, 2, 'Deposit', 123.00, 2623.00, '2024-02-21 15:32:40'),
(14, 2, 'Deposit', 546.00, 3169.00, '2024-02-21 15:56:42'),
(15, 1, 'Deposit', 1200.00, 4374.00, '2024-02-21 16:00:55'),
(16, 1, 'Deposit', 4534.00, 8908.00, '2024-02-21 16:01:03'),
(17, 1, 'Deposit', 120.00, 9028.00, '2024-02-21 16:04:58'),
(18, 1, 'Deposit', 1000.00, 10028.00, '2024-02-21 17:34:08'),
(19, 1, 'Withdrawal', 1000.00, -1000.00, '2024-02-21 17:34:18'),
(20, 1, 'Deposit', 1000.00, 10028.00, '2024-02-21 17:35:49'),
(21, 1, '', 1000.00, 9028.00, '2024-02-21 17:35:59'),
(22, 1, 'Withdrawal', 1000.00, 8028.00, '2024-02-21 17:37:33'),
(23, 2, 'Withdrawal', 100.00, 3069.00, '2024-02-21 17:47:07'),
(24, 1, 'Deposit', 100.00, 8128.00, '2024-02-21 19:36:24'),
(25, 1, 'Withdrawal', 100.00, 8028.00, '2024-02-21 19:36:47'),
(26, 1, 'Withdrawal', 190.00, 7838.00, '2024-02-21 20:51:27'),
(27, 1, 'Deposit', 12000.00, 19838.00, '2024-02-21 21:40:29'),
(28, 1, 'Withdrawal', 1000.00, 18838.00, '2024-02-21 21:41:46');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('customer','banker') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `user_type`) VALUES
(1, 'Himanshu Singh', 'singhraj7607@gmail.com', 'himanshu', 'customer'),
(2, 'Heman Singh', 'hs10himanshu@gmail.com', 'heman', 'customer'),
(3, 'Vinay Singh', 'vinay1234@gmail.com', 'vinay', 'banker'),
(4, 'Deepak Singh', 'deepak@gmail.com', 'deepak', 'banker');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
