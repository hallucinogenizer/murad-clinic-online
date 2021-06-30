-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 25, 2017 at 06:54 AM
-- Server version: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_murad`
--

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

DROP TABLE IF EXISTS `expense`;
CREATE TABLE IF NOT EXISTS `expense` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TYPE` varchar(30) NOT NULL,
  `TITLE` varchar(100) DEFAULT NULL,
  `EXPENSE` int(10) NOT NULL,
  `DATE` date NOT NULL,
  KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`ID`, `TYPE`, `TITLE`, `EXPENSE`, `DATE`) VALUES
(1, 'Lab', 'Something', 200, '2017-11-23'),
(2, 'Lab', 'Something', 200, '2017-11-23'),
(3, 'Lab', 'Something', 200, '2017-11-23'),
(4, 'Lab', 'Something', 200, '2017-11-23'),
(5, 'Lab', 'Something', 200, '2017-11-23'),
(6, 'Lab', 'Something', 200, '2017-11-23'),
(7, 'Lab', 'Something', 200, '2017-11-23'),
(8, 'Lab', 'Something', 200, '2017-11-23'),
(9, 'Lab', 'Something', 200, '2017-11-23'),
(10, 'Lab', 'Something', 200, '2017-11-23'),
(11, 'Lab', 'Something', 200, '2017-11-23'),
(12, 'Lab', NULL, 500, '2017-11-23'),
(13, 'Lab', NULL, 500, '2017-11-23'),
(14, 'Medicine', NULL, 500, '2017-11-23'),
(15, 'Lab', NULL, 100, '2017-11-24'),
(23, 'Lab', 'Lorem', 100, '2017-11-25'),
(18, 'Medicine', 'Supplies', 500, '2017-11-24'),
(19, 'Staff Salary', 'Lab Technicians', 5000, '2017-11-24'),
(20, 'Miscellaneous', NULL, 50, '2017-11-24'),
(22, 'Utility Bills', 'Gas', 800, '2017-11-24'),
(24, 'Utility Bills', 'Ipsum', 200, '2017-11-25'),
(25, 'Equipment', NULL, 300, '2017-11-25'),
(26, 'Medicine', NULL, 300, '2017-11-25'),
(27, 'Staff Salary', NULL, 500, '2017-11-25'),
(32, 'Staff Salary', NULL, 800, '2017-11-25'),
(31, 'Staff Salary', NULL, 800, '2017-11-25'),
(33, 'Staff Salary', NULL, 800, '2017-11-25');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
