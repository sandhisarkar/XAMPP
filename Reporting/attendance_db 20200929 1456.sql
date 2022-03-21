-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.5.50


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema attendance_db
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ attendance_db;
USE attendance_db;

--
-- Table structure for table `attendance_db`.`tbl_admin`
--

DROP TABLE IF EXISTS `tbl_admin`;
CREATE TABLE `tbl_admin` (
  `s_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`s_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance_db`.`tbl_admin`
--

/*!40000 ALTER TABLE `tbl_admin` DISABLE KEYS */;
INSERT INTO `tbl_admin` (`s_id`,`user_name`,`password`) VALUES 
 (1,'admin','admin@');
/*!40000 ALTER TABLE `tbl_admin` ENABLE KEYS */;


--
-- Table structure for table `attendance_db`.`tbl_attendance`
--

DROP TABLE IF EXISTS `tbl_attendance`;
CREATE TABLE `tbl_attendance` (
  `slno` int(100) NOT NULL AUTO_INCREMENT,
  `operator_id` varchar(100) NOT NULL,
  `updatecorrection` int(100) NOT NULL,
  `enrollment` int(100) NOT NULL,
  `created_DTTM` date NOT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`slno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance_db`.`tbl_attendance`
--

/*!40000 ALTER TABLE `tbl_attendance` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_attendance` ENABLE KEYS */;


--
-- Table structure for table `attendance_db`.`tbl_operator`
--

DROP TABLE IF EXISTS `tbl_operator`;
CREATE TABLE `tbl_operator` (
  `sl_no` int(100) NOT NULL AUTO_INCREMENT,
  `state` varchar(100) NOT NULL,
  `district` varchar(100) NOT NULL,
  `operator_id` varchar(100) NOT NULL,
  `pec_location` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `station_id` varchar(50) DEFAULT NULL,
  `emp_status` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sl_no`)
) ENGINE=InnoDB AUTO_INCREMENT=274 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance_db`.`tbl_operator`
--

/*!40000 ALTER TABLE `tbl_operator` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_operator` ENABLE KEYS */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
