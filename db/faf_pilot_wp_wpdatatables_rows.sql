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
-- Table structure for table `wp_wpdatatables_rows`
--

DROP TABLE IF EXISTS `wp_wpdatatables_rows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_wpdatatables_rows` (
  `id` int NOT NULL AUTO_INCREMENT,
  `table_id` int NOT NULL,
  `data` text NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_wpdatatables_rows`
--

LOCK TABLES `wp_wpdatatables_rows` WRITE;
/*!40000 ALTER TABLE `wp_wpdatatables_rows` DISABLE KEYS */;
INSERT INTO `wp_wpdatatables_rows` VALUES (1,1,'{\"cells\":[{\"data\":\"\",\"hidden\":false,\"type\":\"text\"},{\"data\":\"\",\"hidden\":false,\"type\":\"text\"},{\"data\":\"\",\"hidden\":false,\"type\":\"text\"},{\"data\":\"\",\"hidden\":false,\"type\":\"text\"},{\"data\":\"\",\"hidden\":false,\"type\":\"text\"}]}'),(2,1,'{\"cells\":[{\"data\":\"\",\"hidden\":false,\"type\":\"text\"},{\"data\":\"\",\"hidden\":false,\"type\":\"text\"},{\"data\":\"\",\"hidden\":false,\"type\":\"text\"},{\"data\":\"\",\"hidden\":false,\"type\":\"text\"},{\"data\":\"\",\"hidden\":false,\"type\":\"text\"}]}'),(3,1,'{\"cells\":[{\"data\":\"\",\"hidden\":false,\"type\":\"text\"},{\"data\":\"\",\"hidden\":false,\"type\":\"text\"},{\"data\":\"\",\"hidden\":false,\"type\":\"text\"},{\"data\":\"\",\"hidden\":false,\"type\":\"text\"},{\"data\":\"\",\"hidden\":false,\"type\":\"text\"}]}'),(4,1,'{\"cells\":[{\"data\":\"\",\"hidden\":false,\"type\":\"text\"},{\"data\":\"\",\"hidden\":false,\"type\":\"text\"},{\"data\":\"\",\"hidden\":false,\"type\":\"text\"},{\"data\":\"\",\"hidden\":false,\"type\":\"text\"},{\"data\":\"\",\"hidden\":false,\"type\":\"text\"}]}'),(5,1,'{\"cells\":[{\"data\":\"\",\"hidden\":false,\"type\":\"text\"},{\"data\":\"\",\"hidden\":false,\"type\":\"text\"},{\"data\":\"\",\"hidden\":false,\"type\":\"text\"},{\"data\":\"\",\"hidden\":false,\"type\":\"text\"},{\"data\":\"\",\"hidden\":false,\"type\":\"text\"}]}');
/*!40000 ALTER TABLE `wp_wpdatatables_rows` ENABLE KEYS */;
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
