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
-- Table structure for table `wp_faf_round_enabled_teams`
--

DROP TABLE IF EXISTS `wp_faf_round_enabled_teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_faf_round_enabled_teams` (
  `id_round` int NOT NULL,
  `id_team` int NOT NULL,
  KEY `fk_wp_faf_round_enabled_teams_rounds_idx` (`id_round`),
  KEY `fk_wp_faf_round_enabled_teams_teams_idx` (`id_team`),
  CONSTRAINT `fk_wp_faf_round_enabled_teams_rounds` FOREIGN KEY (`id_round`) REFERENCES `wp_faf_league_rounds` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_wp_faf_round_enabled_teams_teams` FOREIGN KEY (`id_team`) REFERENCES `wp_faf_teams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_faf_round_enabled_teams`
--

LOCK TABLES `wp_faf_round_enabled_teams` WRITE;
/*!40000 ALTER TABLE `wp_faf_round_enabled_teams` DISABLE KEYS */;
INSERT INTO `wp_faf_round_enabled_teams` VALUES (2,3),(2,1),(2,5),(3,1),(3,3),(3,4),(3,5),(4,1),(4,3),(4,5),(5,4),(5,5),(6,1),(6,3),(6,4),(7,1),(7,3),(7,4),(7,5);
/*!40000 ALTER TABLE `wp_faf_round_enabled_teams` ENABLE KEYS */;
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
