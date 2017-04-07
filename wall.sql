-- MySQL dump 10.13  Distrib 5.7.17, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: wall
-- ------------------------------------------------------
-- Server version	5.7.17-0ubuntu0.16.04.1

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wall_activity_logs`
--

LOCK TABLES `wall_activity_logs` WRITE;
/*!40000 ALTER TABLE `wall_activity_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `wall_activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wall_category`
--

DROP TABLE IF EXISTS `wall_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wall_category` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wall_category`
--

LOCK TABLES `wall_category` WRITE;
/*!40000 ALTER TABLE `wall_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `wall_category` ENABLE KEYS */;
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
  `file_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wall_image`
--

LOCK TABLES `wall_image` WRITE;
/*!40000 ALTER TABLE `wall_image` DISABLE KEYS */;
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
  `last_logged_in` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `one_id` int(11) DEFAULT NULL,
  `many_id` int(11) DEFAULT NULL,
  `model_one` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model_many` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wall_relate`
--

LOCK TABLES `wall_relate` WRITE;
/*!40000 ALTER TABLE `wall_relate` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wall_roles`
--

LOCK TABLES `wall_roles` WRITE;
/*!40000 ALTER TABLE `wall_roles` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wall_settings`
--

LOCK TABLES `wall_settings` WRITE;
/*!40000 ALTER TABLE `wall_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `wall_settings` ENABLE KEYS */;
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
  `last_logged_in` datetime DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `role_id` int(5) DEFAULT NULL,
  `status` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `verify_code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wall_users`
--

LOCK TABLES `wall_users` WRITE;
/*!40000 ALTER TABLE `wall_users` DISABLE KEYS */;
INSERT INTO `wall_users` VALUES (1,'admin','e10adc3949ba59abbe56e057f20f883e','Admin','admin',NULL,'0000-00-00 00:00:00',NULL,'1',NULL,NULL,'admin@gmail.com');
/*!40000 ALTER TABLE `wall_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-04-08  1:14:30