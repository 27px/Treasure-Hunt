-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2020 at 05:26 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `treasure`
--

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `phone` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `college` varchar(150) NOT NULL,
  `course` varchar(75) NOT NULL,
  `password` varchar(25) NOT NULL,
  `answered` tinyint(4) NOT NULL DEFAULT '0',
  `last_answered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`phone`, `name`, `college`, `course`, `password`, `answered`, `last_answered`) VALUES
('9595959595', 'Siny', 'RIT', 'MCA', '1234567890', 4, '2020-02-23 02:12:13'),
('987654321', 'Jeny', 'CET', 'M.Tech', '1234567890', 14, '2020-02-23 02:51:45'),
('9898989898', 'Sily', 'TKM', 'MCA', '1234567890', 19, '2020-02-23 01:50:42'),
('9999999999', 'Danny', 'IIT', 'B.Tech', '1234567890', 19, '2020-02-23 02:54:13');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `questions` varchar(500) NOT NULL,
  `answer` varchar(100) NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`no`, `questions`, `answer`) VALUES
(1, 'Who is the Actor of Iron Man ?', 'ans'),
(2, 'Who is the founder of Avengers ?', 'ans'),
(3, 'Who is the Actor of Iron Man ?', 'ans'),
(4, 'Who is the Actor of Iron Man ?', 'ans'),
(5, 'Who is the Actor of Iron Man ?', 'ans'),
(6, 'Who is the Actor of Iron Man ?', 'ans'),
(7, 'Who is the Actor of Iron Man ?', 'ans'),
(8, 'Who is the Actor of Iron Man ?', 'ans'),
(9, 'Who is the Actor of Iron Man ?', 'ans'),
(10, 'Who is the Actor of Iron Man ?', 'ans'),
(11, 'Who is the Actor of Iron Man ?', 'ans'),
(12, 'Who is the Actor of Iron Man ?', 'ans'),
(13, 'Who is the Actor of Iron Man ?', 'ans'),
(14, 'Who is the Actor of Iron Man ?', 'ans'),
(15, 'Who is the Actor of Iron Man ?', 'ans'),
(16, 'Who is the Actor of Iron Man ?', 'ans'),
(17, 'Who is the Actor of Iron Man ?', 'ans'),
(18, 'Who is the Actor of Iron Man ?', 'ans'),
(19, 'Who is the Actor of Iron Man ?', 'ans'),
(20, 'Who is the Actor of Terminator ?', 'ans');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
