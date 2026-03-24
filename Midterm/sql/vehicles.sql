-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2026 at 01:36 AM
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
-- Database: `zippyusedautos`
--

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `vehicle_id` int(11) NOT NULL,
  `year` int(11) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `make_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`vehicle_id`, `year`, `model`, `price`, `type_id`, `class_id`, `make_id`) VALUES
(2, 2011, 'F150', 22999.00, 2, 1, 2),
(3, 2012, 'Escalade', 24999.00, 1, 3, 3),
(4, 2018, 'Rogue', 34999.00, 1, 2, 4),
(5, 2016, 'Sonata', 29999.00, 3, 2, 5),
(6, 2020, 'Challenger', 49999.00, 4, 4, 6),
(7, 2015, 'Tahoe', 26999.00, 1, 1, 1),
(8, 2017, 'QX80', 54999.00, 1, 3, 7),
(9, 2015, 'Fusion', 19999.00, 3, 2, 2),
(10, 2014, 'XTS', 19999.00, 3, 3, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`vehicle_id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `make_id` (`make_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `types` (`type_id`),
  ADD CONSTRAINT `vehicles_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`),
  ADD CONSTRAINT `vehicles_ibfk_3` FOREIGN KEY (`make_id`) REFERENCES `makes` (`make_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
