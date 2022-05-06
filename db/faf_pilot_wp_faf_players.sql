-- MySQL dump 10.13  Distrib 5.7.38, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: faf_pilot
-- ------------------------------------------------------
-- Server version	8.0.28

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
-- Table structure for table `wp_faf_players`
--

DROP TABLE IF EXISTS `wp_faf_players`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_faf_players` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `surname` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `import` int NOT NULL,
  `id_current_team` int DEFAULT NULL,
  `begin_validity` datetime NOT NULL,
  `end_validity` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_wp_faf_players_teams_idx` (`id_current_team`),
  CONSTRAINT `fk_wp_faf_players_teams` FOREIGN KEY (`id_current_team`) REFERENCES `wp_faf_teams` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_faf_players`
--

LOCK TABLES `wp_faf_players` WRITE;
/*!40000 ALTER TABLE `wp_faf_players` DISABLE KEYS */;
INSERT INTO `wp_faf_players` VALUES (16,'kj','kj',0,5,'2022-03-09 00:00:00','2022-04-01 00:00:00'),(17,'pippo','pluto',1,NULL,'2022-03-09 00:00:00','2022-04-15 00:00:00'),(18,'paolino','paperino',1,1,'2022-03-01 00:00:00','2023-03-19 00:00:00'),(21,'fffff','dsd',0,4,'2022-03-15 00:00:00','2023-03-15 00:00:00'),(22,'rrr',' required',0,NULL,'2022-03-15 00:00:00','2023-03-15 00:00:00'),(28,'Sergio','Vismara',1,1,'2022-05-02 00:00:00','2023-05-02 00:00:00');
/*!40000 ALTER TABLE `wp_faf_players` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-05-06 21:17:54
