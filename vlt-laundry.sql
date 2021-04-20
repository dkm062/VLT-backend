-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2021 at 02:47 PM
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
  `serviceId` int(11) NOT NULL,
  `price` text NOT NULL,
  `orderId` int(11) NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedOn` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`itemId`, `serviceId`, `price`, `orderId`, `createdOn`, `updatedOn`) VALUES
(1, 1, '30.00', 1030, '2021-04-14 01:08:42', '0000-00-00 00:00:00'),
(2, 16, '25.00', 1031, '2021-04-14 01:09:37', '0000-00-00 00:00:00'),
(3, 17, '25.00', 1032, '2021-04-14 01:10:06', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `ordersId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `orderStatus` int(2) NOT NULL,
  `orderDate` datetime NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedOn` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`ordersId`, `userId`, `orderStatus`, `orderDate`, `createdOn`, `updatedOn`) VALUES
(1030, 12, 1, '2021-04-14 01:00:08', '2021-04-14 01:08:42', '0000-00-00 00:00:00'),
(1031, 12, 1, '2021-04-14 01:00:09', '2021-04-14 01:09:37', '0000-00-00 00:00:00'),
(1032, 12, 1, '2021-04-14 01:00:10', '2021-04-14 01:10:06', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `serviceId` int(10) NOT NULL,
  `name` varchar(266) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `images` text NOT NULL,
  `status` int(1) NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedOn` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `isDeleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`serviceId`, `name`, `description`, `price`, `images`, `status`, `createdOn`, `updatedOn`, `isDeleted`) VALUES
(1, 'Ironing ', '', '30.00', 'http://localhost:8012/VLT-backend/images/1618247438/test.png', 1, '2021-03-23 17:18:28', '0000-00-00 00:00:00', 0),
(16, 'Dry cleaning', 'The best service in town here how we do it.', '25.00', 'http://localhost:8012/VLT-backend/images/1618247465/test.png', 1, '2021-03-24 15:46:43', '2021-04-06 16:39:20', 0),
(17, 'Washing + ironing', 'This service include washing and ironing', '25.00', 'http://localhost:8012/VLT-backend/images/1618247585/test.png', 1, '2021-04-06 16:49:46', '2021-04-11 19:07:27', 0);

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
(3, 'test3', 'test', 'test', 'test', 'test', 0x293e4451a7b8aafea54f29e608c6f3e8, 0, 3, '2021-03-23 08:38:50', '::1', '2021-03-23 02:04:03', '2021-04-06 01:45:33', 0),
(4, 'test4', 'test', 'test', 'test', 'test', 0x293e4451a7b8aafea54f29e608c6f3e8, 0, 3, '2021-03-23 02:04:14', '0', '2021-03-23 02:04:14', '2021-04-06 01:45:37', 0),
(5, 'test5', 'test', 'test', 'test', 'test', 0x293e4451a7b8aafea54f29e608c6f3e8, 0, 3, '2021-03-23 02:04:33', '0', '2021-03-23 02:04:33', '2021-04-06 01:45:40', 0),
(6, 'test6', 'test', 'test', 'test', 'test', 0x293e4451a7b8aafea54f29e608c6f3e8, 1, 3, '2021-03-23 02:08:19', '0', '2021-03-23 02:08:19', '2021-04-06 01:45:42', 0),
(8, 'test7', 'test', 'test1', 'test', 'test', 0x293e4451a7b8aafea54f29e608c6f3e8, 1, 3, '2021-03-23 08:38:14', '::1', '2021-03-23 13:03:52', '2021-04-06 01:45:45', 0),
(9, 'test8', 'test', 'test12', 'test', 'test', 0x293e4451a7b8aafea54f29e608c6f3e8, 1, 3, '2021-03-23 08:38:08', '::1', '2021-03-23 13:04:22', '2021-04-06 01:45:47', 0),
(10, 'Demo', 'Admin', 'demo@gmail.com', '9876767899', '467,this street that block', 0x293e4451a7b8aafea54f29e608c6f3e8, 1, 1, '2021-04-12 21:57:34', '::1', '2021-03-23 13:16:28', '2021-04-11 14:59:25', 0),
(11, NULL, NULL, NULL, NULL, '', NULL, 1, 3, '2021-04-06 02:07:51', '0', '2021-04-06 02:07:51', NULL, 0),
(12, 'Demo', 'User', 'me@gmail.com', '2346676676766', '', 0x6624db168ad16b43e7d2098acdcd1333, 1, 3, '2021-04-13 21:25:51', '::1', '2021-04-11 13:15:01', '2021-04-11 14:58:56', 0),
(13, 'first name', 'last name ', 'mhe@gmail.com', '909090909090', '', 0x6624db168ad16b43e7d2098acdcd1333, 1, 3, '2021-04-11 13:24:05', '0', '2021-04-11 13:24:05', NULL, 0),
(14, 'first name', 'last name ', 'gme@gmail.com', '909090909090', '', 0x6624db168ad16b43e7d2098acdcd1333, 1, 3, '2021-04-11 13:25:49', '0', '2021-04-11 13:25:49', NULL, 0),
(15, 'first name', 'last name ', 'gmhe@gmail.com', '909090909090', '', 0x6624db168ad16b43e7d2098acdcd1333, 1, 3, '2021-04-11 13:30:04', '0', '2021-04-11 13:30:04', NULL, 0),
(16, 'first name', 'last name ', 'hhhme@gmail.com', '909090909090', '', 0x6624db168ad16b43e7d2098acdcd1333, 1, 3, '2021-04-11 13:31:10', '0', '2021-04-11 13:31:10', NULL, 0);

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
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`itemId`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ordersId`);

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
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `itemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `ordersId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1033;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `serviceId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userId` int(120) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `userrole`
--
ALTER TABLE `userrole`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
