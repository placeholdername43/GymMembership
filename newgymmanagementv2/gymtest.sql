-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2023 at 01:14 PM
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
(0, 'cycle', 'tnt', 'john');

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
(4321373, 'John', 'Doe', '1990-01-01', 'Male', 'Basic', 1234567890),
(4321376, 'kate', 'bdds', '1992-02-02', 'Male', 'Basic', 1234567891),
(4321377, 'lain', 'gswg', '1992-02-02', 'Female', 'Premium', 144567891),
(4321378, 'will', 'erger', '1992-02-02', 'Male', 'Basic', 1234567891),
(4321379, 'shafe', 'drkj', '1992-02-02', 'Female', 'Premium', 76532155),
(4321380, 'dem', 'skjeg', '1992-02-02', 'Male', 'Premium', 1234567891),
(4321381, 'kgnf', 'skjg', '1992-02-02', 'Female', 'Basic', 2147483647),
(4321382, 'aergu', 'rgn', '1992-02-02', 'Male', 'Premium', 765434568),
(4321383, 'rge', 'sgrkj', '1992-02-02', 'Female', 'Basic', 765567532),
(4321386, 'test', 'original', '2023-11-15', 'male', 'Basic', 654335);

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

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role`, `id`, `roledescription`) VALUES
('Aider', 3, 'Provides personal aid to members'),
('Instructor', 1, 'Conducts classes and training sessions'),
('Trainer', 2, 'Provides personal training to members');

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
(11, 'Alic', 'Smith', 'alice@example.com', 2147483647, '2023-12-01', 'Instructor'),
(12, 'tnt', 'Johnson', 'bob@example.com', 2147483647, '2022-12-02', 'Aider'),
(13, 'jeam', 'willain', 'jeam@example.com', 987653111, '2023-02-12', 'Aider'),
(14, 'mean', 'weiufw', 'mean@example.com', 2147483647, '2010-12-02', 'Trainer'),
(15, 'helo', 'gjewfj', 'halo@example.com', 7654765, '2013-12-02', 'Instructor'),
(17, 'hi', 'test', 'no@gmail.com', 654332, '2023-12-14', 'Trainer'),
(18, 'jhj', 'test', 'nooo@gmail.com', 8765678, '2023-12-14', 'Trainer');

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
  MODIFY `memberID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4321387;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staffid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
