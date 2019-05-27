-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2018 at 10:42 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kenyafarmers`
--
CREATE DATABASE kenyafarmers;
-- --------------------------------------------------------

--
-- Table structure for table `kenyafarmerscategories`
--

CREATE TABLE `kenyafarmerscategories` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kenyafarmersitems`
--

CREATE TABLE `kenyafarmersitems` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `price` text NOT NULL,
  `quantity` text NOT NULL,
  `pic` blob NOT NULL,
  `uploaderid` int(11) NOT NULL,
  `location` text NOT NULL,
  `categoryid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kenyafarmersusers`
--

CREATE TABLE `kenyafarmersusers` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `hash` text NOT NULL,
  `phonenumber` text NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `location` text NOT NULL,
  `admin` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wakulimaconnectagrovetadmins`
--

CREATE TABLE `wakulimaconnectagrovetadmins` (
  `id` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `password` text,
  `hash` text,
  `activated` tinyint(1) DEFAULT '0',
  `admin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wakulimaconnectagrovetagents`
--

CREATE TABLE `wakulimaconnectagrovetagents` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `phone_number` text NOT NULL,
  `idnumber` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `hash` text NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `dateemployed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wakulimaconnectagrovetcategories`
--

CREATE TABLE `wakulimaconnectagrovetcategories` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `pic` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wakulimaconnectagrovetcustomers`
--

CREATE TABLE `wakulimaconnectagrovetcustomers` (
  `id` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `password` text,
  `hash` text,
  `activated` tinyint(1) DEFAULT '0',
  `phone` text,
  `address` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wakulimaconnectagrovetitems`
--

CREATE TABLE `wakulimaconnectagrovetitems` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `pic` blob NOT NULL,
  `discount` int(11) NOT NULL,
  `Uploader` int(11) NOT NULL,
  `categoryid` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `description` text,
  `identifier` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wakulimaconnectagrovetorders`
--

CREATE TABLE `wakulimaconnectagrovetorders` (
  `id` int(11) NOT NULL,
  `agent` text NOT NULL,
  `dateordered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `datecompleted` datetime NOT NULL,
  `items` text NOT NULL,
  `customer` int(11) NOT NULL,
  `customerpaymentid` text NOT NULL,
  `wakulimaconnectagrovettransactionid` text NOT NULL,
  `transactioncomplete` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kenyafarmerscategories`
--
ALTER TABLE `kenyafarmerscategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kenyafarmersitems`
--
ALTER TABLE `kenyafarmersitems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kenyafarmersusers`
--
ALTER TABLE `kenyafarmersusers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wakulimaconnectagrovetadmins`
--
ALTER TABLE `wakulimaconnectagrovetadmins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wakulimaconnectagrovetagents`
--
ALTER TABLE `wakulimaconnectagrovetagents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idnumber` (`idnumber`(9)),
  ADD UNIQUE KEY `companyid` (`email`(10));

--
-- Indexes for table `wakulimaconnectagrovetcategories`
--
ALTER TABLE `wakulimaconnectagrovetcategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wakulimaconnectagrovetcustomers`
--
ALTER TABLE `wakulimaconnectagrovetcustomers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wakulimaconnectagrovetitems`
--
ALTER TABLE `wakulimaconnectagrovetitems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Uploader` (`Uploader`),
  ADD KEY `categoryid` (`categoryid`);

--
-- Indexes for table `wakulimaconnectagrovetorders`
--
ALTER TABLE `wakulimaconnectagrovetorders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `custpaymentid` (`customerpaymentid`(40));

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kenyafarmerscategories`
--
ALTER TABLE `kenyafarmerscategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kenyafarmersitems`
--
ALTER TABLE `kenyafarmersitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kenyafarmersusers`
--
ALTER TABLE `kenyafarmersusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wakulimaconnectagrovetadmins`
--
ALTER TABLE `wakulimaconnectagrovetadmins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wakulimaconnectagrovetagents`
--
ALTER TABLE `wakulimaconnectagrovetagents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wakulimaconnectagrovetcategories`
--
ALTER TABLE `wakulimaconnectagrovetcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wakulimaconnectagrovetcustomers`
--
ALTER TABLE `wakulimaconnectagrovetcustomers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wakulimaconnectagrovetitems`
--
ALTER TABLE `wakulimaconnectagrovetitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wakulimaconnectagrovetorders`
--
ALTER TABLE `wakulimaconnectagrovetorders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
