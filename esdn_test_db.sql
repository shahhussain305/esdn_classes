/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 5.7.40-0ubuntu0.18.04.1 : Database - esdn_test_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`esdn_test_db` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `esdn_test_db`;

/*Table structure for table `employees` */

CREATE TABLE `employees` (
  `sno` int(11) NOT NULL AUTO_INCREMENT,
  `emp_name` text,
  `emp_email` text,
  PRIMARY KEY (`sno`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `employees` */

insert  into `employees`(`sno`,`emp_name`,`emp_email`) values 
(1,'shah hussain','shahhussain305@gmail.com'),
(2,'amjad khan','amjad@yahoo.com'),
(3,'Ali Khan','ali@gmail.com');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
