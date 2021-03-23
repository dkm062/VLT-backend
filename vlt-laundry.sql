-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2021 at 07:42 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vlt-laundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `device`
--

CREATE TABLE `device` (
  `deviceId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedOn` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `isDeleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE `file` (
  `fileId` int(11) NOT NULL,
  `fileName` varchar(200) DEFAULT NULL,
  `fileLocation` text,
  `fileAuthor` int(11) DEFAULT NULL,
  `fileStructureName` varchar(200) DEFAULT NULL,
  `fileServiceId` int(11) DEFAULT NULL,
  `fileSize` varchar(26) NOT NULL DEFAULT '0',
  `createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedOn` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `isDeleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `itemId` int(11) NOT NULL,
  `orderId` int(11) NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedOn` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `orderId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `orderStatus` int(2) NOT NULL,
  `orderDate` datetime NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedOn` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `serviceId` int(10) NOT NULL,
  `name` varchar(266) NOT NULL,
  `description` varchar(266) NOT NULL,
  `price` float NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedOn` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `isDeleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userId` int(120) NOT NULL,
  `firstName` varchar(266) DEFAULT NULL,
  `lastName` varchar(266) DEFAULT NULL,
  `email` varchar(266) DEFAULT NULL,
  `phoneNumber` varchar(266) DEFAULT NULL,
  `address` varchar(256) NOT NULL,
  `password` varbinary(500) DEFAULT NULL,
  `userStatus` int(1) NOT NULL DEFAULT '0',
  `userRole` int(5) NOT NULL DEFAULT '2',
  `lastLogIn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `logInIP` varchar(32) NOT NULL DEFAULT '0',
  `createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedOn` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `isDeleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `firstName`, `lastName`, `email`, `phoneNumber`, `address`, `password`, `userStatus`, `userRole`, `lastLogIn`, `logInIP`, `createdOn`, `updatedOn`, `isDeleted`) VALUES
(1, NULL, NULL, NULL, NULL, '', NULL, 0, 3, '2021-03-23 01:59:40', '0', '2021-03-23 01:59:40', NULL, 0),
(2, NULL, NULL, NULL, NULL, '', NULL, 0, 3, '2021-03-23 02:01:36', '0', '2021-03-23 02:01:36', NULL, 0),
(3, 'test', 'test', 'test', 'test', 'test', 0x293e4451a7b8aafea54f29e608c6f3e8, 0, 3, '2021-03-23 02:04:03', '0', '2021-03-23 02:04:03', NULL, 0),
(4, 'test', 'test', 'test', 'test', 'test', 0x293e4451a7b8aafea54f29e608c6f3e8, 0, 3, '2021-03-23 02:04:14', '0', '2021-03-23 02:04:14', NULL, 0),
(5, 'test', 'test', 'test', 'test', 'test', 0x293e4451a7b8aafea54f29e608c6f3e8, 0, 3, '2021-03-23 02:04:33', '0', '2021-03-23 02:04:33', NULL, 0),
(6, 'test', 'test', 'test', 'test', 'test', 0x293e4451a7b8aafea54f29e608c6f3e8, 1, 3, '2021-03-23 02:08:19', '0', '2021-03-23 02:08:19', NULL, 0),
(7, NULL, NULL, NULL, NULL, '', NULL, 1, 3, '2021-03-23 02:36:02', '0', '2021-03-23 02:36:02', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `userrole`
--

CREATE TABLE `userrole` (
  `id` int(11) NOT NULL,
  `roleName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `device`
--
ALTER TABLE `device`
  ADD PRIMARY KEY (`deviceId`);

--
-- Indexes for table `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`fileId`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`serviceId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userId`);

--
-- Indexes for table `userrole`
--
ALTER TABLE `userrole`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `device`
--
ALTER TABLE `device`
  MODIFY `deviceId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `file`
--
ALTER TABLE `file`
  MODIFY `fileId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `serviceId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userId` int(120) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `userrole`
--
ALTER TABLE `userrole`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
