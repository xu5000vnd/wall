-- MySQL dump 10.13  Distrib 5.7.18, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: wall
-- ------------------------------------------------------
-- Server version	5.7.18-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `YiiSession`
--

DROP TABLE IF EXISTS `YiiSession`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `YiiSession` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `YiiSession`
--

LOCK TABLES `YiiSession` WRITE;
/*!40000 ALTER TABLE `YiiSession` DISABLE KEYS */;
INSERT INTO `YiiSession` VALUES ('i9e0e350p7l5kle9adrchbm2r1',1492107965,''),('ia2fac3kc7bovfk3e2o0tj5e23',1492530356,''),('ija94t4ffmtl6mn4k4lcg8ndj7',1492454410,''),('p61ocimol658fs3svq0dj2uqc3',1492030993,''),('rbabe0cq110d99g7322up4h7r0',1493391904,''),('rminvtgtot4c8j8fhpt7hqdbg6',1492332430,'');
/*!40000 ALTER TABLE `YiiSession` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wall_action_role`
--

DROP TABLE IF EXISTS `wall_action_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wall_action_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actions` text COLLATE utf8_unicode_ci,
  `controller` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wall_action_role`
--

LOCK TABLES `wall_action_role` WRITE;
/*!40000 ALTER TABLE `wall_action_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `wall_action_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wall_activity_logs`
--

DROP TABLE IF EXISTS `wall_activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wall_activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `controller` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `module` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` int(2) DEFAULT NULL,
  `record_id` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `ip` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text CHARACTER SET utf8,
  `model` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wall_activity_logs`
--

LOCK TABLES `wall_activity_logs` WRITE;
/*!40000 ALTER TABLE `wall_activity_logs` DISABLE KEYS */;
INSERT INTO `wall_activity_logs` VALUES (1,'logout','site','admin',1,1,NULL,'2017-04-08 00:26:09','127.0.0.1','Logged in.',''),(2,'login','site','admin',1,1,NULL,'2017-04-08 00:26:14','127.0.0.1','Logged in.',''),(3,'login','site','admin',1,1,NULL,'2017-04-10 15:48:10','127.0.0.1','Logged in.',''),(4,'login','site','admin',1,1,NULL,'2017-04-12 18:11:26','127.0.0.1','Logged in.',''),(5,'login','site','admin',1,1,NULL,'2017-04-12 19:46:33','127.0.0.1','Logged in.',''),(6,'login','site','admin',1,1,NULL,'2017-04-13 17:09:25','127.0.0.1','Logged in.',''),(7,'login','site','admin',1,1,NULL,'2017-04-13 18:29:30','127.0.0.1','Logged in.',''),(8,'login','site','admin',1,1,NULL,'2017-04-16 07:30:30','127.0.0.1','Logged in.',''),(9,'login','site','admin',1,1,NULL,'2017-04-16 10:23:42','127.0.0.1','Logged in.',''),(10,'login','site','admin',1,1,NULL,'2017-04-16 11:11:21','127.0.0.1','Logged in.',''),(11,'login','site','admin',1,1,NULL,'2017-04-17 17:23:30','127.0.0.1','Logged in.',''),(12,'login','site','admin',1,1,NULL,'2017-04-18 14:29:16','127.0.0.1','Logged in.',''),(13,'login','site','admin',1,1,NULL,'2017-04-18 15:19:27','127.0.0.1','Logged in.',''),(14,'create','image','admin',1,1,1,'2017-04-18 16:17:57','127.0.0.1','Created a Image',''),(15,'create','image','admin',1,1,2,'2017-04-18 16:17:57','127.0.0.1','Created a Image',''),(16,'delete','image','admin',1,1,1,'2017-04-18 17:11:43','127.0.0.1','Deleted a Image',''),(17,'delete','image','admin',1,1,2,'2017-04-18 17:13:11','127.0.0.1','Deleted a Image',''),(18,'create','image','admin',1,1,5,'2017-04-18 17:20:28','127.0.0.1','Created a Image',''),(19,'create','image','admin',1,1,6,'2017-04-18 17:20:28','127.0.0.1','Created a Image',''),(20,'create','image','admin',1,1,7,'2017-04-18 17:21:26','127.0.0.1','Created a Image',''),(21,'create','image','admin',1,1,8,'2017-04-18 17:21:26','127.0.0.1','Created a Image',''),(22,'create','image','admin',1,1,9,'2017-04-18 17:42:45','127.0.0.1','Created a Image',''),(23,'create','image','admin',1,1,10,'2017-04-18 17:43:01','127.0.0.1','Created a Image',''),(24,'create','image','admin',1,1,11,'2017-04-18 17:43:01','127.0.0.1','Created a Image','');
/*!40000 ALTER TABLE `wall_activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wall_category`
--

DROP TABLE IF EXISTS `wall_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wall_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_name` text CHARACTER SET utf8,
  `parent_id` int(11) DEFAULT '0',
  `created_date` datetime DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  `future` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wall_category`
--

LOCK TABLES `wall_category` WRITE;
/*!40000 ALTER TABLE `wall_category` DISABLE KEYS */;
INSERT INTO `wall_category` VALUES (1,'Anime','',NULL,0,'2017-04-10 17:39:10',1,NULL,'anime'),(2,'Naruto','',NULL,1,'2017-04-10 17:50:46',1,NULL,'naruto'),(3,'Dragon Ball','',NULL,1,'2017-04-10 17:51:50',1,NULL,'dragon-ball'),(4,'Bleach','',NULL,1,'2017-04-10 17:55:42',1,'1','bleach'),(5,'One Piece','','',1,'2017-04-10 19:07:25',1,'1','one-piece');
/*!40000 ALTER TABLE `wall_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wall_favorite`
--

DROP TABLE IF EXISTS `wall_favorite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wall_favorite` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `email_user` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_id` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wall_favorite`
--

LOCK TABLES `wall_favorite` WRITE;
/*!40000 ALTER TABLE `wall_favorite` DISABLE KEYS */;
INSERT INTO `wall_favorite` VALUES (89,'xu1vndgmail.com',7,'2017-05-04 17:06:14');
/*!40000 ALTER TABLE `wall_favorite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wall_image`
--

DROP TABLE IF EXISTS `wall_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wall_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_name` text CHARACTER SET utf8,
  `description` text COLLATE utf8_unicode_ci,
  `created_date` datetime DEFAULT NULL,
  `status` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `views` bigint(20) DEFAULT NULL,
  `vote` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wall_image`
--

LOCK TABLES `wall_image` WRITE;
/*!40000 ALTER TABLE `wall_image` DISABLE KEYS */;
INSERT INTO `wall_image` VALUES (3,'abc',NULL,NULL,'2017-04-18 17:17:46','1',NULL,NULL),(4,'abc',NULL,NULL,'2017-04-18 17:19:00','1',NULL,NULL),(5,'abc','1492528828_5_Gir-by-thekeyofE.png',NULL,'2017-04-18 17:20:28','1',NULL,NULL),(6,'abc','1492528828_6_cthulhu-by-veprikov-d359mq0.jpg',NULL,'2017-04-18 17:20:28','1',NULL,NULL),(7,'aaaa','1492528886_7_Gir-by-thekeyofE.png',NULL,'2017-04-18 17:21:26','1',NULL,NULL),(8,'aaaa','1492528886_8_Dodge-Charger-by-roobi.jpg',NULL,'2017-04-18 17:21:26','1',NULL,NULL),(9,'bbbbb',NULL,NULL,'2017-04-18 17:42:45','1',NULL,NULL),(10,'bbbbb','1492530181_10_Dodge-Charger-by-roobi.jpg',NULL,'2017-04-18 17:43:01','1',NULL,NULL),(11,'bbbbb','1492530181_11_the-weeping-willow-by-ineedchemicalx-d5oa1ra.jpg',NULL,'2017-04-18 17:43:01','1',NULL,NULL);
/*!40000 ALTER TABLE `wall_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wall_ip_logs`
--

DROP TABLE IF EXISTS `wall_ip_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wall_ip_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wall_ip_logs`
--

LOCK TABLES `wall_ip_logs` WRITE;
/*!40000 ALTER TABLE `wall_ip_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `wall_ip_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wall_logger`
--

DROP TABLE IF EXISTS `wall_logger`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wall_logger` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `message` text COLLATE utf8_unicode_ci,
  `logtime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wall_logger`
--

LOCK TABLES `wall_logger` WRITE;
/*!40000 ALTER TABLE `wall_logger` DISABLE KEYS */;
/*!40000 ALTER TABLE `wall_logger` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wall_members`
--

DROP TABLE IF EXISTS `wall_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wall_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_hash` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `full_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_ip_login` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_time_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wall_members`
--

LOCK TABLES `wall_members` WRITE;
/*!40000 ALTER TABLE `wall_members` DISABLE KEYS */;
/*!40000 ALTER TABLE `wall_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wall_relate`
--

DROP TABLE IF EXISTS `wall_relate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wall_relate` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `one_id` int(11) DEFAULT NULL,
  `many_id` int(11) DEFAULT NULL,
  `model_one` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model_many` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wall_relate`
--

LOCK TABLES `wall_relate` WRITE;
/*!40000 ALTER TABLE `wall_relate` DISABLE KEYS */;
INSERT INTO `wall_relate` VALUES (1,1,1,'Image','Category','2017-04-18 16:17:57'),(2,1,2,'Image','Category','2017-04-18 16:17:57'),(3,2,1,'Image','Category','2017-04-18 16:17:57'),(4,2,2,'Image','Category','2017-04-18 16:17:57'),(5,5,2,'Image','Category','2017-04-18 17:20:28'),(6,6,2,'Image','Category','2017-04-18 17:20:28'),(7,7,2,'Image','Category','2017-04-18 17:21:26'),(8,8,2,'Image','Category','2017-04-18 17:21:26'),(9,9,2,'Image','Category','2017-04-18 17:42:45'),(10,10,2,'Image','Category','2017-04-18 17:43:01'),(11,11,2,'Image','Category','2017-04-18 17:43:01');
/*!40000 ALTER TABLE `wall_relate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wall_roles`
--

DROP TABLE IF EXISTS `wall_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wall_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wall_roles`
--

LOCK TABLES `wall_roles` WRITE;
/*!40000 ALTER TABLE `wall_roles` DISABLE KEYS */;
INSERT INTO `wall_roles` VALUES (1,'Admin');
/*!40000 ALTER TABLE `wall_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wall_settings`
--

DROP TABLE IF EXISTS `wall_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wall_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf8_unicode_ci,
  `updated` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wall_settings`
--

LOCK TABLES `wall_settings` WRITE;
/*!40000 ALTER TABLE `wall_settings` DISABLE KEYS */;
INSERT INTO `wall_settings` VALUES (1,'projectName','s:9:\"Back Menu\";',NULL),(2,'defaultPageSize','s:2:\"50\";',NULL);
/*!40000 ALTER TABLE `wall_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wall_tag`
--

DROP TABLE IF EXISTS `wall_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wall_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wall_tag`
--

LOCK TABLES `wall_tag` WRITE;
/*!40000 ALTER TABLE `wall_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `wall_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wall_users`
--

DROP TABLE IF EXISTS `wall_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wall_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_ip_login` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `role_id` int(5) DEFAULT NULL,
  `status` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `verify_code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_time_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wall_users`
--

LOCK TABLES `wall_users` WRITE;
/*!40000 ALTER TABLE `wall_users` DISABLE KEYS */;
INSERT INTO `wall_users` VALUES (1,'admin','e10adc3949ba59abbe56e057f20f883e','Admin','admin','127.0.0.1','2017-04-07 21:31:12',1,'1',NULL,NULL,'admin@gmail.com','2017-04-18 15:19:27');
/*!40000 ALTER TABLE `wall_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wall_vote`
--

DROP TABLE IF EXISTS `wall_vote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wall_vote` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) DEFAULT NULL,
  `image_id` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wall_vote`
--

LOCK TABLES `wall_vote` WRITE;
/*!40000 ALTER TABLE `wall_vote` DISABLE KEYS */;
/*!40000 ALTER TABLE `wall_vote` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-05-10 12:23:54
