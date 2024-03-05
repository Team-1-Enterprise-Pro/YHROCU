-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 05, 2024 at 06:00 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `enterpriseCW`
--

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `firstName` varchar(40) NOT NULL,
  `lastName` varchar(40) NOT NULL,
  `team` varchar(40) NOT NULL,
  `role` varchar(40) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(40) NOT NULL,
  `staffNumber` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`firstName`, `lastName`, `team`, `role`, `email`, `password`, `staffNumber`) VALUES
('23213', '1232132', '323', 'staff', '32321', '33', 13224);

-- --------------------------------------------------------

--
-- Table structure for table `taskList`
--

CREATE TABLE `taskList` (
  `taskName` varchar(40) NOT NULL,
  `taskDescription` text NOT NULL,
  `taskDate` date NOT NULL,
  `whoCanView` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `taskList`
--

INSERT INTO `taskList` (`taskName`, `taskDescription`, `taskDate`, `whoCanView`) VALUES
('www', 'wqwqw', '2024-03-14', 'wwqw'),
('eewqe', 'ewqewqe', '2024-03-16', 'ewqewqe'),
('ewqeqe', 'ewqeqwe', '2024-03-21', 'dewewqe'),
('eqqweqwe', 'eqweqweqw', '2024-03-10', 'weqewq'),
('wqewqeqwe', 'wqeeqe', '2024-03-10', 'wqewqeqwe'),
('wqeeqwewqe', 'wqwqee', '2024-03-09', 'eweqqeqw'),
('eweqqeqwewq', 'ewqeweqw', '2024-03-02', 'eqeee');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
