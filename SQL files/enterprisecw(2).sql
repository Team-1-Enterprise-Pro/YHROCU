-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2024 at 02:31 AM
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
-- Database: `enterprisecw`
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
('23213', '1232132', '323', 'staff', '32321', '33', 13224),
('Admin', 'Admin', 'Admin', 'Admin', 'Admin', 'Admin', 123456);

-- --------------------------------------------------------

--
-- Table structure for table `tasklist`
--

CREATE TABLE `tasklist` (
  `taskName` varchar(40) NOT NULL,
  `taskDescription` text NOT NULL,
  `taskDate` date NOT NULL,
  `whoCanView` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasklist`
--

INSERT INTO `tasklist` (`taskName`, `taskDescription`, `taskDate`, `whoCanView`) VALUES
('eewqe', 'ewqewqe', '2024-03-16', 'ewqewqe'),
('eqqweqwe', 'eqweqweqw', '2024-03-10', 'weqewq'),
('eweqqeqwewq', 'ewqeweqw', '2024-03-02', 'eqeee'),
('ewqeqe', 'ewqeqwe', '2024-03-21', 'dewewqe'),
('wqeeqwewqe', 'wqwqee', '2024-03-09', 'eweqqeqw'),
('wqewqeqwe', 'wqeeqe', '2024-03-10', 'wqewqeqwe'),
('www', 'wqwqw', '2024-03-14', 'wwqw');

-- --------------------------------------------------------

--
-- Table structure for table `taskupdates`
--

CREATE TABLE `taskupdates` (
  `taskName` varchar(40) NOT NULL,
  `update` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `taskupdates`
--

INSERT INTO `taskupdates` (`taskName`, `update`) VALUES
('eewqe', 'htfhdrhtrd'),
('eewqe', 'htfhdrhtrd'),
('eewqe', 'gegrthtrhtr'),
('eewqe', 'gegrthtrhtr'),
('eewqe', 'gegrthtrhtr'),
('eewqe', 'gegrthtrhtr'),
('eewqe', 'htrhrt'),
('eewqe', 'dADADA'),
('eewqe', 'DASDADA'),
('eewqe', 'oK');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffNumber`);

--
-- Indexes for table `tasklist`
--
ALTER TABLE `tasklist`
  ADD PRIMARY KEY (`taskName`);

--
-- Indexes for table `taskupdates`
--
ALTER TABLE `taskupdates`
  ADD KEY `Test 1` (`taskName`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `taskupdates`
--
ALTER TABLE `taskupdates`
  ADD CONSTRAINT `Test` FOREIGN KEY (`staffNumber`) REFERENCES `staff` (`staffNumber`),
  ADD CONSTRAINT `Test 1` FOREIGN KEY (`taskName`) REFERENCES `tasklist` (`taskName`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
