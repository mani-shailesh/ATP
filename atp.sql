-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2015 at 08:14 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `atp`
--

-- --------------------------------------------------------

--
-- Table structure for table `alert`
--

CREATE TABLE IF NOT EXISTS `alert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student` text NOT NULL,
  `teacher` text NOT NULL,
  `course` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `attendance_date` date NOT NULL,
  `show_student` int(11) NOT NULL DEFAULT '1',
  `class` int(11) NOT NULL DEFAULT '1',
  `from` int(11) NOT NULL DEFAULT '1',
  `to` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `alert`
--

INSERT INTO `alert` (`id`, `student`, `teacher`, `course`, `time`, `attendance_date`, `show_student`, `class`, `from`, `to`) VALUES
(1, '2013CSB1069', 'anil.kumar@iitrpr.ac.in', 'CSL105', '2015-04-28 05:36:33', '2015-04-01', 0, 1, 0, 1),
(2, '2013CSB1036', 'anil.kumar@iitrpr.ac.in', 'CSL201', '2015-04-28 05:43:38', '2015-04-01', 1, 2, 1, 0),
(3, '2013CSB1069', 'anil.kumar@iitrpr.ac.in', 'CSL201', '2015-04-28 05:43:38', '2015-04-01', 0, 2, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `csl105`
--

CREATE TABLE IF NOT EXISTS `csl105` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `2013CSB1069` int(11) NOT NULL DEFAULT '0',
  `2013CSB1036` int(11) NOT NULL DEFAULT '0',
  `2013CSB1004` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `date` (`date`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `csl105`
--

INSERT INTO `csl105` (`id`, `date`, `2013CSB1069`, `2013CSB1036`, `2013CSB1004`) VALUES
(2, '2015-04-01', 1, 1, 0),
(4, '2015-04-02', 1, 0, 1),
(5, '2015-04-11', 1, 1, 0),
(6, '2015-02-11', 1, 1, 1),
(7, '2014-10-15', 0, 1, 0),
(8, '2013-12-16', 0, 0, 1),
(11, '2015-04-17', 0, 0, 0),
(12, '2015-04-23', 0, 0, 0),
(13, '2015-04-30', 1, 0, 0),
(14, '2015-04-25', 1, 0, 0),
(17, '2015-05-07', 0, 0, 0),
(18, '2015-05-08', 0, 0, 0),
(19, '2015-05-09', 0, 0, 0),
(20, '2015-05-10', 0, 0, 0),
(21, '2015-05-11', 0, 0, 0),
(22, '2015-05-12', 0, 0, 0),
(23, '2015-05-13', 0, 0, 0),
(24, '2015-05-14', 0, 0, 0),
(25, '2015-05-15', 0, 0, 0),
(26, '2015-05-16', 0, 0, 0),
(27, '2015-05-17', 0, 0, 0),
(28, '2015-05-18', 0, 0, 0),
(29, '2015-05-19', 0, 0, 0),
(30, '2015-05-20', 0, 0, 0),
(31, '2015-04-10', 1, 0, 1),
(32, '2015-04-22', 0, 1, 1),
(33, '2015-04-15', 0, 1, 1),
(34, '2015-04-16', 0, 1, 0),
(35, '2015-04-14', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `csl201`
--

CREATE TABLE IF NOT EXISTS `csl201` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `2013CSB1069` int(11) NOT NULL DEFAULT '0',
  `2013CSB1036` int(11) NOT NULL DEFAULT '0',
  `2013CSB1004` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `csl201`
--

INSERT INTO `csl201` (`id`, `date`, `2013CSB1069`, `2013CSB1036`, `2013CSB1004`) VALUES
(1, '2015-04-01', 1, 1, 1),
(3, '2015-04-02', 1, 0, 1),
(4, '2015-04-16', 1, 0, 1),
(5, '2015-04-18', 1, 1, 1),
(6, '2015-04-14', 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `master_student`
--

CREATE TABLE IF NOT EXISTS `master_student` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `courses` text,
  `com_code` text,
  `entryno` text NOT NULL,
  `forgot_code` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `master_student`
--

INSERT INTO `master_student` (`id`, `name`, `email`, `password`, `courses`, `com_code`, `entryno`, `forgot_code`) VALUES
(5, 'Shailesh Mani Pandey', 'shailesh.pandey@iitrpr.ac.in', 'b2f0c4b7c55cc5aa7c8b0746ff0f67aa', 'CSL105,CSL201', NULL, '2013CSB1069', NULL),
(7, 'Anil Modi', 'am@iitrpr.ac.in', '2677877fea7fa6e07288c10a44459dc4', 'CSL105', NULL, '2013CSB1004', NULL),
(16, 'Utkarsh', 'utkarsh.chauhan@iitrpr.ac.in', '4fb8d264fbab9e29ca049b21f3764e14', 'CSL201,CSL105', NULL, '2013CSB1036', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `master_teacher`
--

CREATE TABLE IF NOT EXISTS `master_teacher` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `courses` text,
  `com_code` text,
  `forgot_code` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `master_teacher`
--

INSERT INTO `master_teacher` (`id`, `name`, `email`, `password`, `courses`, `com_code`, `forgot_code`) VALUES
(16, 'Anil Modi', 'anil.kumar@iitrpr.ac.in', 'b8de63ee144c1b90d385f83518e4a6f9', 'CSL201,CSL105', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `teacher` text NOT NULL,
  `student` text NOT NULL,
  `message` text NOT NULL,
  `show_teacher` tinyint(1) NOT NULL DEFAULT '1',
  `show_student` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

-- --------------------------------------------------------

--
-- Table structure for table `roll_list`
--

CREATE TABLE IF NOT EXISTS `roll_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course` text NOT NULL,
  `instructors` text NOT NULL,
  `students` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `roll_list`
--

INSERT INTO `roll_list` (`id`, `course`, `instructors`, `students`) VALUES
(1, 'CSL201', 'anil.kumar@iitrpr.ac.in', '2013CSB1069, 2013CSB1036, 2013CSB1004'),
(2, 'CSL105', 'anil.kumar@iitrpr.ac.in', '2013CSB1069, 2013CSB1036, 2013CSB1004');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
