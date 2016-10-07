/*
SQLyog Ultimate v12.04 (64 bit)
MySQL - 10.1.10-MariaDB : Database - stud_attendance
*********************************************************************
*/
DROP DATABASE /*!32312 IF EXISTS*/`stud_attendance`;

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`stud_attendance` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `stud_attendance`;

/*Table structure for table `beacon` */

DROP TABLE IF EXISTS `beacon`;

CREATE TABLE `beacon` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(100) NOT NULL,
  `major` varchar(10) DEFAULT NULL,
  `minor` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `beacon` */

insert into `beacon` (`id`, `uuid`, `major`, `minor`, `created_at`, `updated_at`) values
  (1, 'B9407F30-F5F8-466E-AFF9-25556B57FE6D', '52689', '51570', '0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (2, 'B9407F30-F5F8-466E-AFF9-25556B57FE6D', '16717', '179', '0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (3, 'B9407F30-F5F8-466E-AFF9-25556B57FE6D', '23254', '34430', '0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (4, 'B9407F30-F5F8-466E-AFF9-25556B57FE6D', '33078', '31465', '0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (5, 'B9407F30-F5F8-466E-AFF9-25556B57FE6D', '58949', '29933', '0000-00-00 00:00:00','2016-04-26 11:09:19');

/*Table structure for table `lecturer` */

DROP TABLE IF EXISTS `lecturer`;

CREATE TABLE `lecturer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

/*Data for the table `lecturer` */

insert  into `lecturer` (`id`,`name`) values 
  ("1", "Zhang Qinjie"),
  ("2", "Lecturer 2"),
  ("3", "Lecturer 3");

/*Table structure for table `lesson` */

DROP TABLE IF EXISTS `lesson`;

CREATE TABLE `lesson` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `semester` varchar(10) DEFAULT NULL,
  `module_id` varchar(10) DEFAULT NULL,
  `subject_area` varchar(10) DEFAULT NULL,
  `catalog_number` varchar(10) DEFAULT NULL,
  `class_section` varchar(5) DEFAULT NULL,
  `component` varchar(5) DEFAULT NULL,
  `facility` varchar(15) DEFAULT NULL,
  `venue_id` int(10) unsigned DEFAULT NULL,
  `weekday` varchar(5) DEFAULT NULL,
  `start_time` varchar(10) DEFAULT NULL,
  `end_time` varchar(10) DEFAULT NULL,
  `meeting_pattern` varchar(5) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `venue_id` (`venue_id`),
  CONSTRAINT `lesson_ibfk_1` FOREIGN KEY (`venue_id`) REFERENCES `venue` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

/*Data for the table `lesson` */

insert  into `lesson`(`id`,`semester`,`module_id`,`subject_area`,`catalog_number`,`class_section`,`component`,`facility`,`venue_id`,`weekday`,`start_time`,`end_time`,`meeting_pattern`,`created_at`,`updated_at`) values 
  (1,2,'007685','ELECTRO','   1AMPR','L2L','LEC','05-03-0001',1,'MON','10:00','12:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (2,2,'007685','ELECTRO','   1AMPR','P2L1','PRA','46-01-0003',1,'THUR','15:00','17:00','ODD','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (3,2,'011197','ELECTRO','   2CPP2','T2L1','TUT','58-01-0002',1,'WED','10:00','12:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (4,2,'010152','ELECTRO','   1EGPHY','T2L1','TUT','06-03-0006',1,'TUES','15:00','16:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (5,2,'008045','ELECTRO','   1APPG','P2L1','PRA','05-02-0015',1,'FRI','10:00','12:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (6,2,'008045','ELECTRO','   1APPG','P2L1','PRA','08-06-0001',1,'TUES','13:00','15:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (7,2,'006492','ELECTRO','   1DEL','LL12','LEC','06-05-0001',1,'MON','15:00','17:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (8,2,'006492','ELECTRO','   1DEL','LL12','LEC','06-05-0001',1,'THUR','12:00','13:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (9,2,'006492','ELECTRO','   1DEL','P2L1','PRA','06-03-0004',1,'MON','08:00','10:00','EVEN','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (10,2,'006492','ELECTRO','   1DEL','T2L1','TUT','06-06-0006',1,'THUR','10:00','11:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (11,2,'009885','ELECTRO','   1EDPT1','P2L1','PRA','04-05-0001',1,'TUES','09:00','12:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (12,2,'010152','ELECTRO','   1EGPHY','L2L','LEC','04-02-0002',1,'THUR','08:00','10:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (13,2,'005696','IS MATH','   1EM3A','LL12','LEC','04-02-0002',1,'MON','13:00','15:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (14,2,'005696','IS MATH','   1EM3A','LL12','LEC','04-02-0002',1,'FRI','09:00','10:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (15,2,'005696','IS MATH','   1EM3A','T2L1','TUT','04-03-0007',1,'THUR','11:00','12:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (16,2,'010428','AE','  75INT6','PL23','PRA','',3,'WED','17:00','18:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (17,2,'007777','AE','   2FAT','LM12','LEC','08-04-0001',3,'WED','09:00','10:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (18,2,'007777','AE','   2FAT','T1M2','TUT','04-02-0008',3,'TUES','15:00','17:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (19,2,'006897','ELECTRIC','   2ELTECH','L1M2','LEC','04-03-0009',3,'WED','10:00','12:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (20,2,'006897','ELECTRIC','   2ELTECH','P1M2','PRA','06-06-0007',3,'TUES','13:00','15:00','EVEN','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (21,2,'006897','ELECTRIC','   2ELTECH','T1M2','TUT','05-05-0003',3,'FRI','11:00','12:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (22,2,'009882','ELECTRO','   1EMPTS','P1M2','PRA','04-05-0002',3,'FRI','13:00','16:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (23,2,'011196','ELECTRO','   2CPP1','T1M2','TUT','05-03-0009',3,'WED','13:00','15:00','EVEN','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (24,2,'010449','IS IE','   8INNOVA','T05','TUT','72-03-0015',2,'MON','13:00','15:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (25,2,'005383','IS MATH','   3EG2','T1M2','TUT','04-03-0010',2,'THUR','10:00','12:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (26,2,'005383','IS MATH','   3EG2','L1M2','LEC','06-04-0007',2,'THUR','15:00','16:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (27,2,'005383','IS MATH','   3EG2','L1M2','LEC','05-02-0009',2,'TUES','10:00','12:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (28,2,'009521','IS PDA','   7COMISS','T03','TUT','05-04-0009',2,'MON','08:00','12:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (29,2,'006898','MECHANIC','   2ENGMEC','P1M2','PRA','47-06-0005',2,'TUES','13:00','15:00','ODD','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (30,2,'006898','MECHANIC','   2ENGMEC','L1M2','LEC','06-06-0006',2,'THUR','13:00','15:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (31,2,'006898','MECHANIC','   2ENGMEC','T1M2','TUT','04-03-0005',2,'FRI','10:00','11:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),


  (41,1,'007685','ELECTRO','   1AMPR','L2L','LEC','05-03-0001',1,'MON','10:00','12:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (42,1,'007685','ELECTRO','   1AMPR','P2L1','PRA','46-01-0003',1,'THUR','15:00','17:00','ODD','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (43,1,'011197','ELECTRO','   2CPP2','T2L1','TUT','58-01-0002',1,'WED','10:00','12:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (44,1,'010152','ELECTRO','   1EGPHY','T2L1','TUT','06-03-0006',1,'TUES','15:00','16:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (45,1,'008045','ELECTRO','   1APPG','P2L1','PRA','05-02-0015',1,'FRI','10:00','12:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (46,1,'008045','ELECTRO','   1APPG','P2L1','PRA','08-06-0001',1,'TUES','13:00','15:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (47,1,'006492','ELECTRO','   1DEL','LL12','LEC','06-05-0001',1,'MON','15:00','17:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (48,1,'006492','ELECTRO','   1DEL','LL12','LEC','06-05-0001',1,'THUR','12:00','13:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (49,1,'006492','ELECTRO','   1DEL','P2L1','PRA','06-03-0004',1,'MON','08:00','10:00','EVEN','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (50,1,'006492','ELECTRO','   1DEL','T2L1','TUT','06-06-0006',1,'THUR','10:00','11:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (51,1,'009885','ELECTRO','   1EDPT1','P2L1','PRA','04-05-0001',1,'TUES','09:00','12:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (52,1,'010152','ELECTRO','   1EGPHY','L2L','LEC','04-02-0002',1,'THUR','08:00','10:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (53,1,'005696','IS MATH','   1EM3A','LL12','LEC','04-02-0002',1,'MON','13:00','15:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (54,1,'005696','IS MATH','   1EM3A','LL12','LEC','04-02-0002',1,'FRI','09:00','10:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (55,1,'005696','IS MATH','   1EM3A','T2L1','TUT','04-03-0007',1,'THUR','11:00','12:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (56,1,'010428','AE','  75INT6','PL23','PRA','',3,'WED','17:00','18:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (57,1,'007777','AE','   2FAT','LM12','LEC','08-04-0001',3,'WED','09:00','10:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (58,1,'007777','AE','   2FAT','T1M2','TUT','04-02-0008',3,'TUES','15:00','17:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (59,1,'006897','ELECTRIC','   2ELTECH','L1M2','LEC','04-03-0009',3,'WED','10:00','12:00','','0000-00-00 00:00:00','2016-04-26 11:09:19'),
  (60,1,'006897','ELECTRIC','   2ELTECH','P1M2','PRA','06-06-0007',3,'TUES','13:00','15:00','EVEN','0000-00-00 00:00:00','2016-04-26 11:09:19');

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` varchar(255) DEFAULT '',
  `face_id` varchar(1000) DEFAULT '',
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `device_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profileImg` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `role` smallint(6) NOT NULL DEFAULT '10',
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) unsigned DEFAULT NULL,
  `updated_at` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user` */

insert  into `user`(`id`,`username`,`auth_key`,`password_hash`,`email`,`status`,`created_at`,`updated_at`,`name`,`role`, `device_hash`) values 
  (1,'u1','cPbJFG-iAzqNRTLRZnJ-r_Suqa9vzkgT','$2y$13$2hu6q.PtQF5jplH930GS1OLgW.e1VOjK4UpTtTXxu3TaTXbwkgzDW','mark.qj@gmail.com',10,1445415998,1461941104,'Teacher',20,'0'),
  (15,'u2','bMlOxgHdwTyLr3Nh3JI6StXz6SL0jOXE','$2y$13$upP/KvUhqRgqFv7AXQa8uuRD.XxqW2deMRU6IYdX9WavLYAI3ZL3a','parent@mail.ru',10,1447691728,1459412913,'Student',10,'0'),
  (18,'u3','x3','$2y$13$SZVzEK9bqUSf4CDFW3cbK.glXDubG6XzDhVnq3seXvNsxEI8.8s5e','teacher@mail.ru',10,1447745333,1461926244,'Teacher',20,'0'),
  (23,'u4','x4','$2y$13$/3TLZjGEkzg3VuksfqwUgetN58T/b3Vjp7vmklwryCXmlkPG2oLMa','manager@mail.ru',10,1460811289,1461926211,'Student',10,'0'),
  (52,'u5','BP4dN0s5LU5OItOd4XnytTFnR5phJ5X_','$2y$13$R31I9.Ah7CKIjclBtyPPk.Bi.st9jZoh8yBbuKszkjgW4/C.WK7Yq','principle@mail.ru',10,1461214049,1461926225,'Student',10,'0'),
  (53,'1234','ZdHvM_ryoZgGJiNsQhh2y95vllLXVseA','$2y$13$3p4KSrmepU5A8mduqEtz3eicSvfEskzLnnUsIukJayp3e7jDStnaa','1234@gmail.com',10,1461214049,1461926225,'student',20,'f8:32:e4:5f:6f:35'),
  (54,'5678','ev0ddY438lQUVzIBT4Cz6FfonldlZGwn','$2y$13$pm7wYtxExchdumcLXrb6DOTP0KeQSUda3hylys/JQ6t0aqjYtUbpq','5678@gmail.com',10,1461214049,1461926225,'student',20,'0'),
  (55,'3333','llF-xngHw2GG03B6VBFmRsz0Og962A7H','$2y$13$qY9oJdIfhhOYQAgtmlzK4uTuoEnE4IKMVqxKkSkmjdhwqKXStV.le','nhtc.123@gmail.com',10,1461214049,1461926225,'student',20,'0'),
  (56,'1111','eoUT-i7zLHcBDnl3m4kjvmmIGglADSiW','$2y$13$ctpUi82YuFrJp3.lBJLWG.bX/eXzJyD.cPwD.oF0uizHrFTlmQrNK','1111@mail.com',10,1468284085,1468284085,'student',20,'0');

/*Table structure for table `student` */

DROP TABLE IF EXISTS `student`;

CREATE TABLE `student` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `card` varchar(10) NOT NULL,
  `name` varchar(120) DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  `acad` varchar(10) DEFAULT NULL,
  `uuid` varchar(40) DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `student_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user1` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `student` */

insert  into `student`(`id`,`acad`,`card`,`gender`,`name`,`uuid`,`user_id`,`created_at`,`updated_at`) values 
  (1,'AE','10164662A',NULL,'ADRIAN YOO',NULL,53,'0000-00-00 00:00:00','2016-04-26 10:49:37'),
  (2,'AE','10157409D',NULL,'AIK YU CHE',NULL,54,'0000-00-00 00:00:00','2016-04-26 10:49:37'),
  (3,'AE','10169807E',NULL,'AKAASH SIN',NULL,55,'0000-00-00 00:00:00','2016-04-26 10:49:37'),
  (4,'AE','10169807E',NULL,'ANTHONY CHEN',NULL,56,'0000-00-00 00:00:00','2016-04-26 10:49:37');

/*Table structure for table `timetable` */

DROP TABLE IF EXISTS `timetable`;

CREATE TABLE `timetable` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(10) unsigned NOT NULL,
  `lesson_id` int(10) unsigned NOT NULL,
  `lecturer_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_id` (`student_id`,`lesson_id`),
  KEY `lesson_id` (`lesson_id`),
  CONSTRAINT `timetable_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `timetable_ibfk_2` FOREIGN KEY (`lesson_id`) REFERENCES `lesson` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `timetable_ibfk_3` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;

/*Data for the table `timetable` */

insert  into `timetable`(`id`,`student_id`,`lesson_id`,`created_at`, `lecturer_id`) values 
  (32,1,1,'2016-04-26 11:10:06',1),
  (33,1,2,'2016-04-26 11:10:06',1),
  (34,1,3,'2016-04-26 11:10:06',1),
  (35,1,4,'2016-04-26 11:10:06',1),
  (36,1,5,'2016-04-26 11:10:06',1),
  (37,1,6,'2016-04-26 11:10:06',1),
  (38,1,7,'2016-04-26 11:10:06',1),
  (39,1,8,'2016-04-26 11:10:06',1),
  (40,1,9,'2016-04-26 11:10:06',1),
  (41,1,10,'2016-04-26 11:10:06',1),
  (42,1,11,'2016-04-26 11:10:06',1),
  (43,1,12,'2016-04-26 11:10:06',1),
  (44,1,13,'2016-04-26 11:10:06',1),
  (45,1,14,'2016-04-26 11:10:06',1),
  (46,1,15,'2016-04-26 11:10:06',1),
  (47,1,16,'2016-04-26 11:10:06',1),
  (48,2,17,'2016-04-26 11:10:06',1),
  (49,2,18,'2016-04-26 11:10:06',1),
  (50,2,19,'2016-04-26 11:10:06',1),
  (51,2,20,'2016-04-26 11:10:06',1),
  (52,2,21,'2016-04-26 11:10:06',1),
  (53,2,22,'2016-04-26 11:10:06',1),
  (54,2,23,'2016-04-26 11:10:06',1),
  (55,2,24,'2016-04-26 11:10:06',1),
  (56,2,25,'2016-04-26 11:10:06',1),
  (57,2,26,'2016-04-26 11:10:06',1),
  (58,2,27,'2016-04-26 11:10:06',1),
  (59,2,28,'2016-04-26 11:10:06',1),
  (60,2,29,'2016-04-26 11:10:06',1),
  (61,2,30,'2016-04-26 11:10:06',1),
  (62,2,31,'2016-04-26 11:10:06',1),
  (137,3,6,'2016-04-26 11:10:06',1),
  (138,3,7,'2016-04-26 11:10:06',1),
  (139,3,8,'2016-04-26 11:10:06',1),
  (140,3,9,'2016-04-26 11:10:06',1),
  (141,3,10,'2016-04-26 11:10:06',1),
  (142,3,11,'2016-04-26 11:10:06',1),
  (143,3,12,'2016-04-26 11:10:06',1),
  (144,3,13,'2016-04-26 11:10:06',1),
  (145,3,14,'2016-04-26 11:10:06',1),
  (146,3,15,'2016-04-26 11:10:06',1),
  (147,3,16,'2016-04-26 11:10:06',1),
  (148,3,17,'2016-04-26 11:10:06',1),
  (149,3,18,'2016-04-26 11:10:06',1),
  (150,3,19,'2016-04-26 11:10:06',1),
  (151,3,20,'2016-04-26 11:10:06',1),
  (152,3,21,'2016-04-26 11:10:06',1),
  (153,3,22,'2016-04-26 11:10:06',1),
  (154,3,23,'2016-04-26 11:10:06',1),
  (243,4,12,'2016-04-26 11:10:06',1),
  (244,4,13,'2016-04-26 11:10:06',1),
  (245,4,14,'2016-04-26 11:10:06',1),
  (246,4,15,'2016-04-26 11:10:06',1),
  (247,4,16,'2016-04-26 11:10:06',1),
  (248,4,17,'2016-04-26 11:10:06',1),
  (249,4,18,'2016-04-26 11:10:06',1),
  (250,4,19,'2016-04-26 11:10:06',1),
  (251,4,20,'2016-04-26 11:10:06',1),
  (252,4,21,'2016-04-26 11:10:06',1),
  (253,4,22,'2016-04-26 11:10:06',1),
  (254,4,23,'2016-04-26 11:10:06',1),
  (255,4,24,'2016-04-26 11:10:06',1),
  (256,4,25,'2016-04-26 11:10:06',1),
  (257,4,26,'2016-04-26 11:10:06',1),
  (258,4,27,'2016-04-26 11:10:06',1),
  (259,4,28,'2016-04-26 11:10:06',1),
  (260,4,29,'2016-04-26 11:10:06',1),
  (261,4,30,'2016-04-26 11:10:06',1),
  (262,4,31,'2016-04-26 11:10:06',1),
  (337,4,6,'2016-04-26 11:10:06',1),
  (338,4,7,'2016-04-26 11:10:06',1),
  (339,4,8,'2016-04-26 11:10:06',1),


  (72,1,41,'2016-04-26 11:10:06',1),
  (73,1,42,'2016-04-26 11:10:06',1),
  (74,1,43,'2016-04-26 11:10:06',1),
  (75,1,44,'2016-04-26 11:10:06',1),
  (76,1,45,'2016-04-26 11:10:06',1),
  (77,1,46,'2016-04-26 11:10:06',1),
  (78,1,47,'2016-04-26 11:10:06',1),
  (79,1,48,'2016-04-26 11:10:06',1),
  (80,1,49,'2016-04-26 11:10:06',1),
  (81,1,50,'2016-04-26 11:10:06',1),
  (82,1,51,'2016-04-26 11:10:06',1),
  (83,1,52,'2016-04-26 11:10:06',1),
  (84,1,53,'2016-04-26 11:10:06',1),
  (85,1,54,'2016-04-26 11:10:06',1),
  (86,1,55,'2016-04-26 11:10:06',1),
  (87,1,56,'2016-04-26 11:10:06',1),
  (88,2,57,'2016-04-26 11:10:06',1),
  (89,2,58,'2016-04-26 11:10:06',1),
  (90,2,59,'2016-04-26 11:10:06',1),
  (91,2,60,'2016-04-26 11:10:06',1),
  (92,2,41,'2016-04-26 11:10:06',1),
  (93,2,42,'2016-04-26 11:10:06',1),
  (94,2,43,'2016-04-26 11:10:06',1),
  (95,2,44,'2016-04-26 11:10:06',1),
  (96,2,45,'2016-04-26 11:10:06',1),
  (97,2,46,'2016-04-26 11:10:06',1),
  (98,2,47,'2016-04-26 11:10:06',1),
  (100,2,48,'2016-04-26 11:10:06',1),
  (101,2,49,'2016-04-26 11:10:06',1),
  (102,2,50,'2016-04-26 11:10:06',1),
  (103,2,51,'2016-04-26 11:10:06',1),
  (477,3,46,'2016-04-26 11:10:06',1),
  (478,3,47,'2016-04-26 11:10:06',1),
  (479,3,48,'2016-04-26 11:10:06',1),
  (480,3,49,'2016-04-26 11:10:06',1),
  (481,3,50,'2016-04-26 11:10:06',1),
  (482,3,51,'2016-04-26 11:10:06',1),
  (483,3,52,'2016-04-26 11:10:06',1),
  (484,3,53,'2016-04-26 11:10:06',1),
  (485,3,54,'2016-04-26 11:10:06',1),
  (486,3,55,'2016-04-26 11:10:06',1),
  (487,3,56,'2016-04-26 11:10:06',1),
  (497,4,46,'2016-04-26 11:10:06',1),
  (498,4,47,'2016-04-26 11:10:06',1),
  (4100,4,48,'2016-04-26 11:10:06',1),
  (4101,4,49,'2016-04-26 11:10:06',1),
  (4102,4,50,'2016-04-26 11:10:06',1),
  (4103,4,51,'2016-04-26 11:10:06',1),
  (583,4,52,'2016-04-26 11:10:06',1),
  (584,4,53,'2016-04-26 11:10:06',1);

/*Table structure for table `user_token` */

DROP TABLE IF EXISTS `user_token`;

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `expire_date` datetime NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `action` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`),
  CONSTRAINT `usertoken_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

/*Data for the table `user_token` */

insert  into `user_token`(`id`,`user_id`,`token`,`title`,`ip_address`,`expire_date`,`created_date`,`updated_date`,`action`) values 
  (2,15,'uEjx4gdvgBZmJbxEZfqG8E6Qs1H6c6nu','ACTION_CHANGE_EMAIL','127.0.0.1','2015-12-14 13:28:25','2015-12-07 13:28:05','2015-12-07 13:28:25',3),
  (4,15,'mHQk3giA-4jAl7NHHoeMWjXXyUC6Sf6e','ACTION_CHANGE_EMAIL','127.0.0.1','2015-12-14 18:04:33','2015-12-07 18:04:28','2015-12-07 18:04:33',3),
  (5,23,'H_4Ismh6tcr0JgLSJNohXN703lXn1WKv','ACTION_ACTIVATE_ACCOUNT','127.0.0.1','2015-12-15 21:51:58','2015-12-08 21:51:58','2015-12-08 21:51:58',1),
  (6,24,'NvuTHLloI-pOYjwuTHlzmQO5MIQl3T0N','ACTION_ACTIVATE_ACCOUNT','127.0.0.1','2015-12-15 21:53:50','2015-12-08 21:53:50','2015-12-08 21:53:50',1),
  (7,23,'ZItZpQugkTc6Z9ne5_UN6kFNM6lIjY2o','ACTION_ACTIVATE_ACCOUNT','127.0.0.1','2015-12-18 19:13:30','2015-12-11 19:13:30','2015-12-11 19:13:30',1),
  (8,18,'K3pnWmgdOMxo4Zx318vMKIeiq6Op9LXr','ACTION_RESET_PASSWORD','127.0.0.1','2016-04-02 19:10:36','2016-03-26 19:10:36','2016-03-26 19:10:36',2),
  (9,20,'FskuVth7ZFef-du2ZaoNJe6i21flTwSV','ACTION_CHANGE_EMAIL','5.57.8.106','2016-04-23 08:41:00','2016-04-16 08:41:00','2016-04-16 08:41:00',3),
  (10,20,'s5GCHQXtg_1weudrhbKExxh0erB-RbGs','ACTION_CHANGE_EMAIL','5.57.8.106','2016-04-23 08:43:16','2016-04-16 08:43:16','2016-04-16 08:43:16',3),
  (11,21,'XgnnkvXAL6-ugI3QA__bB3_e9oSaHDj0','ACTION_CHANGE_EMAIL','5.57.8.106','2016-04-23 08:50:38','2016-04-16 08:50:38','2016-04-16 08:50:38',3),
  (12,21,'85I2tLb-Xrx0cXER0Q8rdXdiaabe5y3Q','ACTION_CHANGE_EMAIL','5.57.8.106','2016-04-23 09:03:02','2016-04-16 09:03:02','2016-04-16 09:03:02',3),
  (13,21,'hgNTlkhX8pxLn6dVrVw2ri5o73VgY_C-','ACTION_CHANGE_EMAIL','5.57.8.106','2016-04-23 09:04:46','2016-04-16 09:04:46','2016-04-16 09:04:46',3),
  (14,21,'DmBc3C6DlXeiW7vu_czS23ndg6sTqgcL','ACTION_CHANGE_EMAIL','5.57.8.106','2016-04-23 09:05:29','2016-04-16 09:05:29','2016-04-16 09:05:29',3),
  (15,21,'AdgD-Tyx_fedkZ0GT4UlR5lGDQMoCZBz','ACTION_CHANGE_EMAIL','5.57.8.106','2016-04-23 09:08:11','2016-04-16 09:07:59','2016-04-16 09:08:11',3),
  (16,21,'uhrUFnYn0h4aoEWeilaWBO1rRlKADitz','ACTION_CHANGE_EMAIL','5.57.8.106','2016-04-23 09:09:45','2016-04-16 09:09:45','2016-04-16 09:09:45',3),
  (17,30,'RG8CRBk38whuzxZi4jDPLnnrI9SbxAN6','ACTION_ACTIVATE_ACCOUNT','77.95.61.49','2016-04-26 04:40:34','2016-04-19 04:40:12','2016-04-19 04:40:34',1),
  (18,35,'S6WCSc0RGlC6tBFoiAKF3nLZpcS2HKpa','ACTION_ACTIVATE_ACCOUNT','77.95.61.49','2016-04-26 05:07:31','2016-04-19 05:07:02','2016-04-19 05:07:31',1),
  (21,40,'FYWbNT57SwigP2PtZ_BKBLRz0Z-mcn1N','ACTION_ACTIVATE_ACCOUNT','178.217.174.2','2016-04-27 07:47:43','2016-04-20 07:47:43','2016-04-20 07:47:43',1),
  (22,42,'J5151vo8a5o4wVADvduHnU9KNcCn3kPy','ACTION_ACTIVATE_ACCOUNT','178.217.174.2','2016-04-27 09:33:27','2016-04-20 09:33:27','2016-04-20 09:33:27',1),
  (23,51,'PTrvVM--hRCxPDOcQC1Dweqzg5qmUvmB','ACTION_ACTIVATE_ACCOUNT','94.143.199.47','2016-04-28 04:46:11','2016-04-21 04:46:11','2016-04-21 04:46:11',1),
  (24,52,'fFTZnjgnZaWdulJYZ-un8JRX-yg-Q9_l','ACTION_ACTIVATE_ACCOUNT','94.143.199.47','2016-04-28 04:48:10','2016-04-21 04:47:29','2016-04-21 04:48:10',1);

/*Table structure for table `venue` */

DROP TABLE IF EXISTS `venue`;

CREATE TABLE `venue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `location` varchar(20) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `venue` */

insert into `venue` (`id`, `location`, `name`) values
  (1, 'Location 1', 'Venue 1'),
  (2, 'Location 2', 'Venue 2'),
  (3, 'Location 3', 'Venue 3');

/*Table structure for table `venue_beacon` */

DROP TABLE IF EXISTS `venue_beacon`;

CREATE TABLE `venue_beacon` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `venue_id` int(10) unsigned DEFAULT NULL,
  `beacon_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `venue_id` (`venue_id`),
  KEY `beacon_id` (`beacon_id`),
  CONSTRAINT `venue_beacon_ibfk_1` FOREIGN KEY (`venue_id`) REFERENCES `venue` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `venue_beacon_ibfk_2` FOREIGN KEY (`beacon_id`) REFERENCES `beacon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into `venue_beacon` (`id`, `venue_id`, `beacon_id`) values
  (1, 1, 1),
  (2, 2, 1),
  (3, 3, 1);

/*Data for the table `venue_beacon` */

/*Table structure for table `venue_beacon` */

DROP TABLE IF EXISTS `attendance`;

CREATE TABLE `attendance` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(10) unsigned NOT NULL,
  `lesson_id` int(10) unsigned NOT NULL,
  `signed_in` datetime DEFAULT NULL,
  `signed_out` datetime DEFAULT NULL,
  `is_absent` int(1) unsigned NOT NULL DEFAULT '0',
  `is_late` tinyint(1) NOT NULL DEFAULT '0',
  `late_min` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
/* For test: UNIQUE KEY `studentId` (`student_id`,`lesson_id`), */
  -- KEY `lessonId` (`lesson_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`lesson_id`) REFERENCES `lesson` (`id`) ON UPDATE CASCADE;

/*Data for the table `attendance` */

-- INSERT INTO `attendance` (`id`, `student_id`, `lesson_id`, `signed_in`, `signed_out`, `is_absent`, `is_late`, `late_min`, `created_at`, `updated_at`) VALUES
--   (40, 1, 1, NULL, NULL, 0, 0, 0, '2015-07-30 08:11:00', '2016-06-13 09:50:00'),
--   (41, 1, 12, NULL, NULL, 1, 0, 0, '2015-07-30 08:11:00', '2016-06-16 23:00:00'),
--   (42, 1, 1, NULL, NULL, 0, 1, 10, '2015-07-30 08:11:00', '2016-06-20 10:10:00'),
--   (43, 1, 12, NULL, NULL, 1, 0, 0, '2015-07-30 08:11:00', '2016-06-23 10:30:00');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
