-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2023 at 05:45 PM
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
-- Database: `gymtest`
--

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `ID` int(10) NOT NULL,
  `class` varchar(10) NOT NULL,
  `staff` varchar(15) NOT NULL,
  `member` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`ID`, `class`, `staff`, `member`) VALUES
(0, 'esgyh', 'khsgb', 'thiswork'),
(42, 'moped', 'nooje', '0'),
(123456789, 'test', 'testing', 'testmember');

-- --------------------------------------------------------

--
-- Table structure for table `gymmembers`
--

CREATE TABLE `gymmembers` (
  `memberID` int(10) NOT NULL,
  `FirstName` varchar(15) NOT NULL,
  `lastname` varchar(15) NOT NULL,
  `dateofbirth` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `membertomembership` varchar(8) NOT NULL,
  `phonenumber` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `gymmembers`
--

INSERT INTO `gymmembers` (`memberID`, `FirstName`, `lastname`, `dateofbirth`, `gender`, `membertomembership`, `phonenumber`) VALUES
(4321365, 'ejrniuh', 'kejynrkjn', '2023-11-23', 'ekjne', 'Basic', 345432345),
(4321366, 'ejrniuh', 'kejynrkjn', '2023-11-23', 'ekjne', 'Basic', 345432345),
(4321367, 'ejrniuh', 'kejynrkjn', '2023-11-23', 'ekjne', 'Basic', 345432345),
(4321368, 'trying', 'cycle', '2023-11-15', 'seuh', 'Premium', 654345432),
(4321369, 'trying', 'cycle', '2023-11-15', 'seuh', 'Premium', 654345432),
(4321370, 'ahjgb', 'asjhemgb', '2023-11-01', 'asoguh', 'Premium', 543234),
(4321371, 'ahjgb', 'asjhemgb', '2023-11-01', 'asoguh', 'Premium', 543234),
(4321372, 'ahjgb', 'asjhemgb', '2023-11-01', 'asoguh', 'Premium', 543234);

-- --------------------------------------------------------

--
-- Table structure for table `membershiptype`
--

CREATE TABLE `membershiptype` (
  `Type` varchar(8) NOT NULL,
  `Fee` float NOT NULL,
  `Description` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `membershiptype`
--

INSERT INTO `membershiptype` (`Type`, `Fee`, `Description`) VALUES
('Basic', 10, 'Basic membershi'),
('Premium', 50, 'premium is best');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role` varchar(15) NOT NULL,
  `id` int(10) NOT NULL,
  `roledescription` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `classid` int(10) NOT NULL,
  `name` varchar(15) NOT NULL,
  `description` varchar(20) NOT NULL,
  `schedule` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffid` int(10) NOT NULL,
  `firstname` varchar(15) NOT NULL,
  `lastname` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phonenumber` int(10) NOT NULL,
  `startdate` date NOT NULL,
  `role` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staffid`, `firstname`, `lastname`, `email`, `phonenumber`, `startdate`, `role`) VALUES
(9, 'Manveer', 'singh', 'afgoiJ@GMAIL.COM', 54321234, '2023-11-02', 'sgejg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `gymmembers`
--
ALTER TABLE `gymmembers`
  ADD PRIMARY KEY (`memberID`),
  ADD KEY `membertomembership` (`membertomembership`);

--
-- Indexes for table `membershiptype`
--
ALTER TABLE `membershiptype`
  ADD PRIMARY KEY (`Type`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`classid`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gymmembers`
--
ALTER TABLE `gymmembers`
  MODIFY `memberID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4321373;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staffid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gymmembers`
--
ALTER TABLE `gymmembers`
  ADD CONSTRAINT `membertomembership` FOREIGN KEY (`membertomembership`) REFERENCES `membershiptype` (`Type`);

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`classid`) REFERENCES `class` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
