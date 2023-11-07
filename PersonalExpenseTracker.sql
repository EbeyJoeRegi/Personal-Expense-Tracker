-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2023 at 07:07 AM
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
-- Database: `dailyexpense`
--

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `expense_id` int(20) NOT NULL,
  `user_id` varchar(15) NOT NULL,
  `expense` int(20) NOT NULL,
  `expensedate` varchar(15) NOT NULL,
  `expensecategory` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`expense_id`, `user_id`, `expense`, `expensedate`, `expensecategory`) VALUES
(101, '9', 789, '2023-08-31', 'Medicine'),
(102, '9', 3, '2023-08-31', 'Entertainment'),
(103, '9', 469, '2023-08-29', 'Clothings'),
(104, '9', 985, '2023-08-25', 'Entertainment'),
(105, '12', 3, '2023-08-31', 'Clothings'),
(106, '12', 89, '2023-08-16', 'Bills & Recharges'),
(107, '9', 3, '2023-09-06', 'Clothings'),
(108, '9', 300, '2023-07-04', 'Food'),
(109, '9', 456, '2023-09-01', 'Clothings'),
(110, '9', 3, '2023-08-28', 'Entertainment'),
(111, '9', 300, '2023-09-03', 'Clothings'),
(112, '9', 789, '2021-06-03', 'Medicine'),
(113, '9', 756, '2021-02-23', 'Entertainment'),
(114, '9', 123, '2022-09-03', 'Medicine'),
(115, '9', 256, '2021-09-07', 'Medicine'),
(116, '9', 798, '2023-09-04', 'Medicine'),
(117, '9', 45, '2023-08-28', 'Entertainment'),
(118, '9', 50, '2023-10-20', 'Medicine'),
(119, '9', 786, '2023-10-20', 'Food'),
(120, '9', 1000, '2023-10-04', 'Entertainment'),
(121, '9', 500, '2023-10-19', 'Clothings'),
(122, '9', 426, '2023-10-16', 'Household Items');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expense_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expense_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
