-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 14, 2024 at 11:09 PM
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
('23213', '1232132', '323', 'staff', '32321', '33', 13224),
('Admin', 'Admin', 'Admin', 'Admin', 'Admin', 'Admin', 123456),
('serrr', 'rewrwer', 'rere', 'staff', 'rwerwer', 'rwerewr', 12345678);

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
('Complete scheduling', 'Complete scheduling for all staff members by planning out their timetables and essential activities they need to complete.', '2024-03-15', 'Everyone');

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
('Testing this', 'An update for testing'),
('Complete scheduling', 'An update for scheduling'),
('Complete scheduling', 'Adding test'),
('Test', 'update'),
('Complete scheduling', 'test');

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
