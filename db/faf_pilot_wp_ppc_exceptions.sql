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
-- Table structure for table `wp_ppc_exceptions`
--

DROP TABLE IF EXISTS `wp_ppc_exceptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_ppc_exceptions` (
  `exception_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `agent_type` varchar(32) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `agent_id` bigint unsigned NOT NULL,
  `for_item_source` varchar(32) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `for_item_type` varchar(32) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `for_item_status` varchar(127) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `operation` varchar(32) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `mod_type` varchar(32) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `via_item_source` varchar(32) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `via_item_type` varchar(32) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `assigner_id` bigint unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`exception_id`),
  KEY `pp_exc` (`agent_type`,`agent_id`,`exception_id`,`operation`,`for_item_type`),
  KEY `pp_exc_mod` (`mod_type`),
  KEY `pp_exc_status` (`for_item_status`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_ppc_exceptions`
--

LOCK TABLES `wp_ppc_exceptions` WRITE;
/*!40000 ALTER TABLE `wp_ppc_exceptions` DISABLE KEYS */;
INSERT INTO `wp_ppc_exceptions` VALUES (1,'pp_group',8,'post','page','','read','exclude','post','',1),(2,'pp_group',7,'post','page','','read','exclude','post','',1),(3,'pp_group',6,'post','page','','read','exclude','post','',1),(4,'pp_group',5,'post','page','','read','additional','post','',1);
/*!40000 ALTER TABLE `wp_ppc_exceptions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-02-28  0:10:04
