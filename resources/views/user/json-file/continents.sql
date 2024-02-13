-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 21, 2020 at 11:20 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bma-member-management-software`
--

-- --------------------------------------------------------

--
-- Table structure for table `continents`
--

CREATE TABLE `continents` (
  `code` varchar(2) NOT NULL DEFAULT '',
  `name` varchar(15) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `continents`
--

INSERT INTO `continents` (`code`, `name`) VALUES
('AF', 'Africa'),
('AN', 'Antarctica'),
('AS', 'Asia'),
('EU', 'Europe'),
('NA', 'North America'),
('OC', 'Oceania'),
('SA', 'South America');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `continents`
--
ALTER TABLE `continents`
  ADD UNIQUE KEY `code` (`code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
