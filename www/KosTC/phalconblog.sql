CREATE DATABASE  IF NOT EXISTS `phalconblog` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `phalconblog`;
-- MySQL dump 10.13  Distrib 5.7.17, for macos10.12 (x86_64)
--
-- Host: localhost    Database: phalconblog
-- ------------------------------------------------------
-- Server version	5.7.19-0ubuntu0.16.04.1

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
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `posts_id` int(11) NOT NULL,
  `body` text NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `submitted` datetime NOT NULL,
  `publish` enum('Yes','No') NOT NULL DEFAULT 'No',
  PRIMARY KEY (`id`),
  KEY `fk_comments_posts1` (`posts_id`),
  CONSTRAINT `fk_comments_posts1` FOREIGN KEY (`posts_id`) REFERENCES `posts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,13,'pokusaj','kos','kos@kos.hr','2017-08-17 18:44:47','Yes'),(2,13,'neki komentar','Kos','igor.kos@hexis.hr','2017-08-20 16:35:16','Yes'),(3,13,'ne znam ni ja sta radim','kos','kos@kos.hr','2017-08-20 21:58:03','Yes'),(5,33,'Comment','name','email@email.hr','2017-08-21 11:55:01','Yes'),(9,34,'test2','Kompanija UPDATE','kompanija@kompanija.comm','2017-08-23 09:10:59','Yes');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_tags`
--

DROP TABLE IF EXISTS `post_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `posts_id` int(11) NOT NULL,
  `tags_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_post_tags_tags1` (`tags_id`),
  KEY `fk_post_tags_posts1` (`posts_id`),
  CONSTRAINT `fk_post_tags_posts1` FOREIGN KEY (`posts_id`) REFERENCES `posts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_post_tags_tags1` FOREIGN KEY (`tags_id`) REFERENCES `tags` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_tags`
--

LOCK TABLES `post_tags` WRITE;
/*!40000 ALTER TABLE `post_tags` DISABLE KEYS */;
INSERT INTO `post_tags` VALUES (6,13,6),(7,14,7),(8,15,8),(9,16,9),(10,17,10),(11,18,11),(12,19,12),(13,20,13),(14,21,14),(15,22,15),(16,23,16),(17,24,17),(18,25,18),(19,27,19),(20,27,20),(21,28,21),(22,29,22),(23,30,23),(24,31,24),(25,13,25),(26,13,26),(27,32,27),(28,33,28),(29,33,29),(30,34,30),(31,34,31);
/*!40000 ALTER TABLE `post_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `title` text,
  `body` text,
  `published` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_posts_users` (`users_id`),
  CONSTRAINT `fk_posts_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (13,13,'prvi naslov updated 20.08.2017.','prvi teskt updated jos jednomupdate 16.08.2017. - 13:55','2017-08-09 10:49:59','2017-08-21 07:58:59'),(14,13,'dali je to ok? nadam se da je','dali je to ok?','2017-08-09 13:18:28','2017-08-20 16:20:54'),(15,14,'drugi pise svoj 1. post','drugi pise svoj 1. post','2017-08-09 13:20:37',NULL),(16,14,'drugi pise svoj 2. post','drugi pise svoj 2. post','2017-08-09 13:20:49',NULL),(17,15,'treci naslov','treci pise tekst','2017-08-09 13:29:54',NULL),(18,15,'treci pise drugi naslov','treci pise drugi tekst jer je blesav','2017-08-09 13:30:12',NULL),(19,15,'treci treci naslov','treci treci tekst','2017-08-09 13:30:32',NULL),(20,16,'4 naslov','4 tekst','2017-08-09 13:30:56',NULL),(21,16,'4-2 naslov','4-2 tekst','2017-08-09 13:31:11',NULL),(22,16,'4-3 naslov','4-3 tekst','2017-08-09 13:31:23',NULL),(23,13,'1-1 naslov','1-1 tekst','2017-08-09 13:31:59',NULL),(24,13,'1-2','1-2','2017-08-09 13:32:05',NULL),(25,13,'nesto nesto 222','nesto nesto 222','2017-08-16 09:51:49',NULL),(26,13,'nesto nesto 222','nesto nesto 222','2017-08-16 09:52:58',NULL),(27,18,'člasdkfjčkj','igor Kos','2017-08-16 09:57:41','2017-08-16 09:58:21'),(28,13,'pokusaj','pokusaj','2017-08-16 13:17:27',NULL),(29,13,'Despacito','Najveci ljetni hit sa najvise pogleda na Youtube-u','2017-08-17 13:13:00',NULL),(30,13,'srecica','srecica','2017-08-20 16:19:34',NULL),(31,20,'bubili :D','bubili :D','2017-08-20 16:24:52',NULL),(32,18,'admin post 1','neki teksti od admina','2017-08-21 07:27:29',NULL),(33,20,'My Twitter app','Advancement','2017-08-21 11:54:28',NULL),(34,24,'test','test text blablablaupdated','2017-08-21 13:36:04','2017-08-21 14:17:51');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag` (`tag`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (16,'1-1'),(17,'1-2'),(13,'4'),(14,'4-2'),(15,'4-3'),(7,'a bo'),(27,'admin'),(29,'advancement'),(5,'bezveze'),(24,'bubili :d'),(26,'drugi tag'),(19,'jhg'),(28,'job'),(22,'ljetni hit'),(2,'najnoviji'),(3,'ne znam\r\nnesto'),(18,'nesto'),(4,'nikad ne znas'),(20,'nisam znao nista'),(1,'novi'),(21,'pokusaj'),(9,'post 2'),(8,'prvi post'),(25,'prvi tag\r\ndrugi tag'),(6,'prvi tag'),(23,'srecica'),(30,'test'),(31,'test novitag'),(10,'treci'),(11,'treci drugi'),(12,'treci treci');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(70) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `role` enum('Guests','Users','Admin') NOT NULL DEFAULT 'Users',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (13,'prvi','011c945f30ce2cbafc452f39840f025693339c42','prvi','prvi@prvi.hr','2017-08-09 10:46:39','2017-08-21 06:38:15','Users'),(14,'drugi','39dfa55283318d31afe5a3ff4a0e3253e2045e43','drugi','drugi@drugi.hr','2017-08-09 13:19:22','2017-08-21 06:35:50','Users'),(15,'treci','dc648519bc60afd94ca987cb43f7601bc299963a','treci','treci@treci.hr','2017-08-09 13:19:47',NULL,'Users'),(16,'cetvrti','e28dd5b0bd97b5d69959af2ef4acd941bd0be481','cetvrti','cetvrti@cetvrti.hr','2017-08-09 13:20:03',NULL,'Users'),(18,'admin','d033e22ae348aeb5660fc2140aec35850c4da997','admin','admin@admin.hr','2017-08-16 07:40:44',NULL,'Admin'),(19,'cecka','b49ff949392f81f6a4eda63f27f89cdafa6a8fcc','cecka','cecka@cecka.hr','2017-08-16 08:44:08',NULL,'Users'),(20,'ivana','a164db9d5bd30c07ae8dc8f2586b944f6067f0f6','ivana','ivana@ivana.hr','2017-08-20 16:21:44',NULL,'Users'),(23,'neznam','d033069fbbc43316f369d25db68dd7f14e181008','neznam','neznam@neznam.hr','2017-08-21 12:56:18',NULL,'Users'),(24,'test','c129b324aee662b04eccf68babba85851346dff9','test','test@test.hr','2017-08-21 13:11:47','2017-08-23 09:33:09','Users');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-08-23 15:30:02
