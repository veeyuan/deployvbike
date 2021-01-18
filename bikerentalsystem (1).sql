-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2021 at 01:02 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bikerentalsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminID` int(10) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `statusID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminID`, `username`, `password`, `email`, `statusID`) VALUES
(1, 'admin', '123456789', 'admin@gmail.com', 1),
(2, 'admin1', '123456789', 'admin1@gmail.com', 2);

-- --------------------------------------------------------

--
-- Table structure for table `bikes`
--

CREATE TABLE `bikes` (
  `ID` int(10) UNSIGNED NOT NULL,
  `Model` text NOT NULL,
  `Year of prodaction` int(10) UNSIGNED NOT NULL,
  `Engine Volume` int(10) UNSIGNED NOT NULL,
  `Hourse Power` int(10) UNSIGNED NOT NULL,
  `Rent START` date NOT NULL,
  `Rent END` date NOT NULL,
  `In Stock` tinyint(1) NOT NULL,
  `Fuel Consumption` int(10) UNSIGNED NOT NULL,
  `Price per day` int(10) UNSIGNED NOT NULL,
  `Order ID` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bikes`
--

INSERT INTO `bikes` (`ID`, `Model`, `Year of prodaction`, `Engine Volume`, `Hourse Power`, `Rent START`, `Rent END`, `In Stock`, `Fuel Consumption`, `Price per day`, `Order ID`) VALUES
(1, 'Kawasaki Z750', 2008, 750, 90, '2016-11-18', '2016-11-21', 1, 5, 20, 0),
(2, 'Suzuki Bandit', 2010, 650, 89, '2016-11-19', '2016-11-30', 1, 4, 25, 0);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservationID` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `bikeID` int(10) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `startTime` time NOT NULL,
  `endTime` time NOT NULL,
  `totalPrice` double NOT NULL,
  `comments` varchar(255) NOT NULL,
  `status` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservationID`, `userID`, `bikeID`, `startDate`, `endDate`, `startTime`, `endTime`, `totalPrice`, `comments`, `status`) VALUES
(1, 1, 1, '2021-01-27', '2021-01-30', '10:00:00', '18:00:00', 30, '', 4),
(2, 2, 2, '2021-02-02', '2021-02-04', '10:00:00', '18:00:00', 25, '', 4),
(3, 2, 1, '2021-01-04', '2021-01-06', '09:00:00', '12:00:00', 45.5, 'very good', 3),
(4, 2, 2, '2021-01-11', '2021-01-13', '09:00:00', '12:00:00', 65, '', 3);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `statusID` int(10) NOT NULL,
  `statusDescription` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`statusID`, `statusDescription`) VALUES
(1, 'Active'),
(2, 'Inactive'),
(3, 'Done'),
(4, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobileNo` int(11) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `username`, `password`, `email`, `mobileNo`, `address`) VALUES
(1, 'user', '123456789', 'user123@gmail.com', 12355555, '1, Jln Melaka, 66000, Melaka'),
(2, 'user1', '123456789', 'user1@gmail.com', 1234567890, '300, Jln Alor, Bdr Jaya, 26300, Kedah'),
(3, 'user2', '123456789', 'user2@gmail.com', 123456789, '24, Jln Wawasan, Bdr Hijau, 204491, Kuala Lumpur'),
(4, 'user3', '123456789', 'user3@gmail.com', 123456789, '19, Jln Bangau, Bdr Puchong Jaya, 56000, Selangor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminID`),
  ADD KEY `statusID` (`statusID`);

--
-- Indexes for table `bikes`
--
ALTER TABLE `bikes`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID` (`ID`),
  ADD KEY `ID_2` (`ID`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservationID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `bikeID` (`bikeID`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`statusID`),
  ADD KEY `statusID` (`statusID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bikes`
--
ALTER TABLE `bikes`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservationID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `statusID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
