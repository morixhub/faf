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
-- Table structure for table `wp_faf_league_rounds`
--

DROP TABLE IF EXISTS `wp_faf_league_rounds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_faf_league_rounds` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_league` int NOT NULL,
  `round_name` varchar(256) NOT NULL,
  `opening` datetime NOT NULL,
  `closing` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_wp_faf_league_rounds_leagues_idx` (`id_league`),
  CONSTRAINT `fk_wp_faf_league_rounds_leagues` FOREIGN KEY (`id_league`) REFERENCES `wp_faf_leagues` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_faf_league_rounds`
--

LOCK TABLES `wp_faf_league_rounds` WRITE;
/*!40000 ALTER TABLE `wp_faf_league_rounds` DISABLE KEYS */;
INSERT INTO `wp_faf_league_rounds` VALUES (1,1,'Prima giornata','2022-03-21 00:00:00','2022-04-04 00:00:00'),(2,1,'Seconda giornata','2022-03-21 00:00:00','2022-04-04 00:00:00'),(3,1,'Test finale','2022-03-01 00:00:00','2022-03-29 00:00:00'),(4,1,'Test finale 22222','2022-03-01 00:00:00','2022-03-30 00:00:00'),(5,1,'Test finale 3','2022-03-01 00:00:00','2022-04-09 00:00:00'),(6,1,'Test per Sergio','2022-05-02 00:00:00','2022-05-16 00:00:00'),(7,1,'Giornata terza','2022-05-02 00:00:00','2022-05-16 00:00:00');
/*!40000 ALTER TABLE `wp_faf_league_rounds` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-05-06 21:17:55
