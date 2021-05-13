-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2021 at 12:32 PM
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
-- Table structure for table `Device`
--

CREATE TABLE `Device` (
  `deviceId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedOn` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `isDeleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `File`
--

CREATE TABLE `File` (
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
-- Table structure for table `Item`
--

CREATE TABLE `Item` (
  `itemId` int(11) NOT NULL,
  `serviceId` int(11) NOT NULL,
  `price` text NOT NULL,
  `orderId` int(11) NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedOn` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Item`
--

INSERT INTO `Item` (`itemId`, `serviceId`, `price`, `orderId`, `createdOn`, `updatedOn`) VALUES
(1, 1, '30.00', 1030, '2021-04-14 01:08:42', '0000-00-00 00:00:00'),
(2, 16, '25.00', 1031, '2021-04-14 01:09:37', '0000-00-00 00:00:00'),
(3, 17, '25.00', 1032, '2021-04-14 01:10:06', '0000-00-00 00:00:00'),
(4, 1, '30.00', 1033, '2021-04-28 19:23:47', '0000-00-00 00:00:00'),
(5, 1, '30.00', 1034, '2021-04-29 01:24:02', '0000-00-00 00:00:00'),
(6, 1, '30.00', 1035, '2021-04-29 01:25:32', '0000-00-00 00:00:00'),
(7, 1, '30.00', 1036, '2021-04-29 01:54:07', '0000-00-00 00:00:00'),
(8, 1, '30.00', 1037, '2021-04-29 01:55:07', '0000-00-00 00:00:00'),
(9, 1, '30.00', 1038, '2021-05-02 04:03:31', '0000-00-00 00:00:00'),
(10, 1, '30.00', 1039, '2021-05-02 04:18:14', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `Orders`
--

CREATE TABLE `Orders` (
  `ordersId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `orderStatus` int(2) NOT NULL,
  `lat` text NOT NULL,
  `lng` text NOT NULL,
  `instruction` text NOT NULL,
  `orderDate` datetime NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedOn` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Orders`
--

INSERT INTO `Orders` (`ordersId`, `userId`, `orderStatus`, `lat`, `lng`, `instruction`, `orderDate`, `createdOn`, `updatedOn`) VALUES
(1030, 12, 1, '', '0', '', '2021-04-14 01:00:08', '2021-04-14 01:08:42', '0000-00-00 00:00:00'),
(1031, 12, 1, '', '0', '', '2021-04-14 01:00:09', '2021-04-14 01:09:37', '0000-00-00 00:00:00'),
(1032, 12, 1, '', '0', '', '2021-04-14 01:00:10', '2021-04-14 01:10:06', '0000-00-00 00:00:00'),
(1033, 12, 1, '', '0', '', '2021-04-28 07:00:23', '2021-04-28 19:23:47', '0000-00-00 00:00:00'),
(1034, 12, 1, '', '0', '', '2021-04-29 01:00:24', '2021-04-29 01:24:02', '0000-00-00 00:00:00'),
(1035, 12, 1, '', '0', '', '2021-04-29 01:00:25', '2021-04-29 01:25:32', '0000-00-00 00:00:00'),
(1036, 12, 1, '12.978903780136', '77.692595422268', 'test', '2021-04-29 01:00:54', '2021-04-29 01:54:07', '0000-00-00 00:00:00'),
(1037, 12, 2, '13.940783224191', '77.465758323669', 'new test', '2021-04-29 01:00:55', '2021-04-29 01:55:07', '0000-00-00 00:00:00'),
(1038, 12, 2, '13.940783224191', '77.465758323669', 'test', '2021-05-02 04:00:03', '2021-05-02 04:03:31', '0000-00-00 00:00:00'),
(1039, 12, 2, '13.938685682075', '77.456420212984', 'test instructions', '2021-05-02 04:00:18', '2021-05-02 04:18:14', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `OrderStatus`
--

CREATE TABLE `OrderStatus` (
  `orderStatusId` int(11) NOT NULL,
  `orderStatusDescription` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `OrderStatus`
--

INSERT INTO `OrderStatus` (`orderStatusId`, `orderStatusDescription`) VALUES
(1, 'Yet to pickup'),
(2, 'Picked up'),
(3, 'In process'),
(4, 'Out for delivery'),
(5, 'Delivered');

-- --------------------------------------------------------

--
-- Table structure for Sable `service`
--

CREATE TABLE `Service` (
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
-- Dumping data for table `Service`
--

INSERT INTO `Service` (`serviceId`, `name`, `description`, `price`, `images`, `status`, `createdOn`, `updatedOn`, `isDeleted`) VALUES
(1, 'Ironing ', '', '30.00', 'http://localhost:8012/VLT-backend/images/1618247438/test.png', 1, '2021-03-23 17:18:28', '0000-00-00 00:00:00', 0),
(16, 'Dry cleaning', 'The best service in town here how we do it.', '25.00', 'http://localhost:8012/VLT-backend/images/1618247465/test.png', 1, '2021-03-24 15:46:43', '2021-04-06 16:39:20', 0),
(17, 'Washing + ironing', 'This service include washing and ironing', '25.00', 'http://localhost:8012/VLT-backend/images/1618247585/test.png', 1, '2021-04-06 16:49:46', '2021-04-11 19:07:27', 0);

-- --------------------------------------------------------

--
-- Table structure for table `Task`
--

CREATE TABLE `Task` (
  `taskId` int(11) NOT NULL,
  `staffId` int(11) NOT NULL,
  `ordersId` int(11) NOT NULL,
  `orderStatus` int(11) NOT NULL,
  `taskStatus` int(11) NOT NULL,
  `taskType` int(11) NOT NULL,
  `taskAssignedOn` date NOT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `isDeleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Task`
--

INSERT INTO `Task` (`taskId`, `staffId`, `ordersId`, `OrderStatus`, `TaskStatus`, `TaskType`, `taskAssignedOn`, `createdOn`, `updatedOn`, `isDeleted`) VALUES
(1, 14, 1037, 2, 2, 1, '0000-00-00', '2021-04-29 08:22:10', '2021-05-01 16:22:42', 0),
(2, 14, 1037, 5, 2, 2, '0000-00-00', '2021-04-29 08:32:54', '2021-05-01 16:22:44', 0),
(3, 13, 1037, 5, 2, 2, '0000-00-00', '2021-05-01 20:31:07', '2021-05-01 20:33:03', 0),
(4, 13, 1037, 1, 1, 1, '0000-00-00', '2021-05-01 20:31:46', '2021-05-01 20:33:05', 0),
(5, 14, 1037, 1, 1, 1, '0000-00-00', '2021-05-01 20:32:36', '0000-00-00 00:00:00', 0),
(6, 13, 1038, 5, 2, 2, '0000-00-00', '2021-05-01 22:35:34', '0000-00-00 00:00:00', 0),
(7, 13, 1038, 2, 2, 1, '0000-00-00', '2021-05-01 22:41:49', '0000-00-00 00:00:00', 0),
(8, 13, 1039, 2, 2, 1, '0000-00-00', '2021-05-01 22:48:58', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `TaskStatus`
--

CREATE TABLE `TaskStatus` (
  `taskStatusId` int(11) NOT NULL,
  `taskStatusDescription` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `TaskStatus`
--

INSERT INTO `TaskStatus` (`taskStatusId`, `taskStatusDescription`) VALUES
(1, 'Assigned'),
(2, 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `TaskType`
--

CREATE TABLE `TaskType` (
  `taskTypeId` int(11) NOT NULL,
  `taskTypeDescription` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `TaskType`
--

INSERT INTO `TaskType` (`taskTypeId`, `taskTypeDescription`) VALUES
(1, 'Picking'),
(2, 'Dropping');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `userId` int(120) NOT NULL,
  `firstName` varchar(266) DEFAULT NULL,
  `lastName` varchar(266) DEFAULT NULL,
  `email` varchar(266) DEFAULT NULL,
  `phoneNumber` varchar(266) DEFAULT NULL,
  `address` varchar(256) NOT NULL,
  `lat` text NOT NULL,
  `lng` text NOT NULL,
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
-- Dumping data for table `User`
--

INSERT INTO `User` (`userId`, `firstName`, `lastName`, `email`, `phoneNumber`, `address`, `lat`, `lng`, `password`, `userStatus`, `UserRole`, `lastLogIn`, `logInIP`, `createdOn`, `updatedOn`, `isDeleted`) VALUES
(3, 'test3', 'test', 'test1', 'test', 'test', '', '', 0x293e4451a7b8aafea54f29e608c6f3e8, 0, 3, '2021-03-23 08:38:50', '::1', '2021-03-23 02:04:03', '2021-04-22 02:57:41', 0),
(4, 'test4', 'test', 'test2 ', 'test', 'test', '', '', 0x293e4451a7b8aafea54f29e608c6f3e8, 0, 3, '2021-03-23 02:04:14', '0', '2021-03-23 02:04:14', '2021-04-22 02:57:45', 0),
(5, 'test5', 'test', 'test3', 'test', 'test', '', '', 0x293e4451a7b8aafea54f29e608c6f3e8, 0, 3, '2021-03-23 02:04:33', '0', '2021-03-23 02:04:33', '2021-04-22 02:57:47', 0),
(6, 'test6', 'test', 'test4', 'test', 'test', '', '', 0x293e4451a7b8aafea54f29e608c6f3e8, 1, 3, '2021-03-23 02:08:19', '0', '2021-03-23 02:08:19', '2021-04-22 02:57:50', 0),
(8, 'test7', 'test', 'test5', 'test', 'test', '', '', 0x293e4451a7b8aafea54f29e608c6f3e8, 1, 3, '2021-03-23 08:38:14', '::1', '2021-03-23 13:03:52', '2021-04-22 02:57:55', 0),
(9, 'test8', 'test', 'test6', 'test', 'test', '', '', 0x293e4451a7b8aafea54f29e608c6f3e8, 1, 3, '2021-03-23 08:38:08', '::1', '2021-03-23 13:04:22', '2021-04-22 02:57:58', 0),
(10, 'Demo', 'Admin', 'demo@gmail.com', '9876767899', '467,this street that block', '', '', 0x293e4451a7b8aafea54f29e608c6f3e8, 1, 1, '2021-05-02 00:48:41', '::1', '2021-03-23 13:16:28', '2021-04-11 14:59:25', 0),
(11, 'Test9', NULL, 'test7', NULL, '', '', '', NULL, 1, 3, '2021-04-06 02:07:51', '0', '2021-04-06 02:07:51', '2021-04-22 02:58:03', 0),
(12, 'Demo', 'User', 'me@gmail.com', '2346676676766', '', '13.938685682075', '77.456420212984', 0x6624db168ad16b43e7d2098acdcd1333, 1, 3, '2021-05-08 14:26:16', '::1', '2021-04-11 13:15:01', '2021-04-28 18:58:12', 0),
(13, 'staff', 'one', 'mhe@gmail.com', '909090909090', '', '', '', 0x6624db168ad16b43e7d2098acdcd1333, 1, 2, '2021-04-11 13:24:05', '0', '2021-04-11 13:24:05', '2021-04-29 23:39:22', 0),
(14, 'staff', 'two', 'staff@gmail.com', '909090909090', '', '', '', 0x6624db168ad16b43e7d2098acdcd1333, 1, 2, '2021-04-11 13:25:49', '0', '2021-04-11 13:25:49', '2021-04-29 23:39:30', 0),
(15, 'staff', 'three', 'gmhe@gmail.com', '909090909090', '', '', '', 0x6624db168ad16b43e7d2098acdcd1333, 1, 2, '2021-04-11 13:30:04', '0', '2021-04-11 13:30:04', '2021-04-29 23:39:39', 0),
(16, 'first name 4', 'last name ', 'hhhme@gmail.com', '909090909090', '', '', '', 0x6624db168ad16b43e7d2098acdcd1333, 1, 3, '2021-04-11 13:31:10', '0', '2021-04-11 13:31:10', '2021-04-22 02:57:37', 0);

-- --------------------------------------------------------

--
-- Table structure for table `UserRole`
--

CREATE TABLE `UserRole` (
  `id` int(11) NOT NULL,
  `roleName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `UserRole`
--

INSERT INTO `UserRole` (`id`, `roleName`) VALUES
(1, 'admin'),
(2, 'staff'),
(3, 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Device`
--
ALTER TABLE `Device`
  ADD PRIMARY KEY (`deviceId`);

--
-- Indexes for table `File`
--
ALTER TABLE `File`
  ADD PRIMARY KEY (`fileId`);

--
-- Indexes for table `Item`
--
ALTER TABLE `Item`
  ADD PRIMARY KEY (`itemId`);

--
-- Indexes for table `Orders`
--
ALTER TABLE `Orders`
  ADD PRIMARY KEY (`ordersId`);

--
-- Indexes for table `OrderStatus`
--
ALTER TABLE `OrderStatus`
  ADD PRIMARY KEY (`orderStatusId`);

--
-- Indexes for table `Service`
--
ALTER TABLE `Service`
  ADD PRIMARY KEY (`serviceId`);

--
-- Indexes for table `Task`
--
ALTER TABLE `Task`
  ADD PRIMARY KEY (`taskId`);

--
-- Indexes for table `TaskStatus`
--
ALTER TABLE `TaskStatus`
  ADD PRIMARY KEY (`taskStatusId`);

--
-- Indexes for table `TaskType`
--
ALTER TABLE `TaskType`
  ADD PRIMARY KEY (`taskTypeId`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`userId`);

--
-- Indexes for table `UserRole`
--
ALTER TABLE `UserRole`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Device`
--
ALTER TABLE `Device`
  MODIFY `deviceId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `File`
--
ALTER TABLE `File`
  MODIFY `fileId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Item`
--
ALTER TABLE `Item`
  MODIFY `itemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `Orders`
--
ALTER TABLE `Orders`
  MODIFY `ordersId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1040;

--
-- AUTO_INCREMENT for table `OrderStatus`
--
ALTER TABLE `OrderStatus`
  MODIFY `orderStatusId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `Service`
--
ALTER TABLE `Service`
  MODIFY `serviceId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `Task`
--
ALTER TABLE `Task`
  MODIFY `taskId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for TablS `taskstatus`
--
ALTER TABLE `TaskStatus`
  MODIFY `taskStatusId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `TaskType`
--
ALTER TABLE `TaskType`
  MODIFY `taskTypeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `userId` int(120) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `UserRole`
--
ALTER TABLE `UserRole`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
