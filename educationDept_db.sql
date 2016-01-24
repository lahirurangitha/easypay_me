-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2015 at 01:46 PM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `educationdept_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `exam_date_time`
--

CREATE TABLE IF NOT EXISTS `exam_date_time` (
  `aca_year` int(4) NOT NULL,
  `aca_sem` int(1) NOT NULL,
  `sub_code` varchar(10) NOT NULL,
  `dates` date NOT NULL,
  `times` varchar(20) NOT NULL,
  `place` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exam_date_time`
--

INSERT INTO `exam_date_time` (`aca_year`, `aca_sem`, `sub_code`, `dates`, `times`, `place`) VALUES
(1, 2, 'SCS1108', '2015-12-14', '9.00-11.00 a.m.', '4th Floor'),
(1, 2, 'SCS1111', '2015-12-15', '9.00-11.00 a.m.', 'Mini Auditorium'),
(2, 2, 'SCS2101', '2015-12-14', '2.00-4.00 p.m.', 'W002'),
(2, 2, 'SCS2102', '2015-12-17', '2.00-4.00 p.m.', '4th Floor'),
(3, 2, 'SCS3101', '2015-12-20', '9.00-11.00 a.m.', 'W002'),
(3, 2, 'SCS3102', '2015-12-21', '9.00-11.00 a.m.', 'Mini Auditorium');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE IF NOT EXISTS `results` (
  `index_no` varchar(8) NOT NULL,
  `sub_code` varchar(10) NOT NULL,
  `attempt` int(1) NOT NULL,
  `sub_name` varchar(50) NOT NULL,
  `aca_year` int(4) NOT NULL,
  `aca_sem` int(1) NOT NULL,
  `result` varchar(3) NOT NULL,
  `repeat_status` int(1) NOT NULL,
  `assignments` int(1) NOT NULL COMMENT '1 for completed'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`index_no`, `sub_code`, `attempt`, `sub_name`, `aca_year`, `aca_sem`, `result`, `repeat_status`, `assignments`) VALUES
('13000111', 'SCS1108', 1, 'Programming II', 1, 2, 'D-', 1, 1),
('13000111', 'SCS1111', 1, 'Algo II', 1, 2, 'A-', 1, 0),
('13000111', 'SCS1111', 2, 'Networking I', 1, 2, 'B-', 1, 1),
('13000146', 'IS2103', 1, 'SE I', 2, 2, 'A-', 0, 1),
('13000241', 'IS2102', 1, 'Marketing II', 2, 2, 'B-', 0, 0),
('13000889', 'SCS1110', 1, 'Database II', 1, 2, 'C-', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE IF NOT EXISTS `subjects` (
  `sub_code` varchar(10) NOT NULL,
  `sub_name` varchar(50) NOT NULL,
  `credits` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`sub_code`, `sub_name`, `credits`) VALUES
('IS1104', 'Marketing', 2),
('IS1105', 'Database', 2),
('SCS1101', 'Programing', 2),
('SCS1103', 'Database', 2),
('SCS1108', 'Algo', 2);

-- --------------------------------------------------------

--
-- Table structure for table `u_student`
--

CREATE TABLE IF NOT EXISTS `u_student` (
  `name_initial` varchar(50) NOT NULL,
  `name_full` varchar(80) NOT NULL,
  `nic` varchar(10) NOT NULL,
  `dob` date NOT NULL,
  `address` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `years` int(2) NOT NULL,
  `semester` int(1) NOT NULL,
  `reg_no` varchar(9) NOT NULL,
  `index_no` varchar(8) NOT NULL,
  `cs_is` int(1) NOT NULL COMMENT 'cs=1,is=0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `u_student`
--

INSERT INTO `u_student` (`name_initial`, `name_full`, `nic`, `dob`, `address`, `email`, `phone`, `years`, `semester`, `reg_no`, `index_no`, `cs_is`) VALUES
('N.Dilanga', 'Nadeesh Dilanga', '922940325v', '1992-10-13', 'asadaasadasxcxzsda', 'nadeesh@gmail.com', '0710236558', 2, 2, '2013CS027', '13000111', 1),
('S.Surangi', 'Shanika Surangi', '921235641v', '1992-11-30', 'asatehrjddfgddasda', 'shanika@gmail.com', '0714556612', 1, 2, '2013IS014', '13000146', 0),
('T.Upendra', 'Thisumi Upendra', '924568123v', '1992-03-14', 'asadcccbxcbxvdsdfsasda', 'thisumi@gmail.com', '071456882', 1, 2, '2013IS024', '13000241', 0),
('L.Niroshan', 'Lasith Niroshan', '924578456v', '1992-05-12', 'asadasda', 'lasith@gmail.com', '0714589123', 1, 2, '2013CS084', '13000846', 1),
('A.Nisal', 'Anjana Nisal', '921235431v', '1992-06-21', 'ascxvxcvsfadasda', 'anjana@gmail.com', '0719876523', 3, 2, '2013CS085', '13000857', 1),
('L.Rangitha', 'Lahiru Rangitha', '926784592v', '1992-11-11', 'xcvcvdasdasad', 'lahiru@gmail.com', '0717643322', 2, 2, '2013CS088', '13000889', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `exam_date_time`
--
ALTER TABLE `exam_date_time`
  ADD PRIMARY KEY (`sub_code`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`index_no`,`sub_code`,`attempt`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`sub_code`);

--
-- Indexes for table `u_student`
--
ALTER TABLE `u_student`
  ADD PRIMARY KEY (`index_no`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
