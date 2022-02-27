-- MySQL dump 10.13  Distrib 5.7.37, for Linux (x86_64)
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
-- Table structure for table `wp_faf_round_selections`
--

DROP TABLE IF EXISTS `wp_faf_round_selections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_faf_round_selections` (
  `id_user` bigint unsigned NOT NULL,
  `id_round` int NOT NULL,
  `id_player` int NOT NULL,
  `id_role` varchar(8) NOT NULL,
  KEY `fk_wp_faf_round_selections_rounds_idx` (`id_round`),
  KEY `fk_wp_faf_round_selections_players_idx` (`id_player`),
  KEY `fk_wp_faf_round_selections_roles_idx` (`id_role`),
  KEY `fk_wp_faf_round_selections_1_idx` (`id_user`),
  CONSTRAINT `fk_wp_faf_round_selections_players` FOREIGN KEY (`id_player`) REFERENCES `wp_faf_players` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_wp_faf_round_selections_roles` FOREIGN KEY (`id_role`) REFERENCES `wp_faf_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_wp_faf_round_selections_rounds` FOREIGN KEY (`id_round`) REFERENCES `wp_faf_league_rounds` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_wp_faf_round_selections_users` FOREIGN KEY (`id_user`) REFERENCES `wp_users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_faf_round_selections`
--

LOCK TABLES `wp_faf_round_selections` WRITE;
/*!40000 ALTER TABLE `wp_faf_round_selections` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_faf_round_selections` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-02-28  0:10:03
