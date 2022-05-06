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
-- Table structure for table `wp_ppc_exception_items`
--

DROP TABLE IF EXISTS `wp_ppc_exception_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_ppc_exception_items` (
  `eitem_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `exception_id` bigint unsigned NOT NULL,
  `item_id` bigint unsigned NOT NULL,
  `assign_for` enum('item','children') COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'item',
  `inherited_from` bigint unsigned DEFAULT '0',
  `assigner_id` bigint unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`eitem_id`),
  KEY `pp_exception_item` (`item_id`,`exception_id`,`assign_for`),
  KEY `pp_eitem_fk` (`exception_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_ppc_exception_items`
--

LOCK TABLES `wp_ppc_exception_items` WRITE;
/*!40000 ALTER TABLE `wp_ppc_exception_items` DISABLE KEYS */;
INSERT INTO `wp_ppc_exception_items` VALUES (1,1,25,'item',0,1),(2,2,25,'item',0,1),(3,3,25,'item',0,1),(4,4,25,'item',0,1),(5,1,25,'children',0,1),(6,2,25,'children',0,1),(7,3,25,'children',0,1),(8,4,25,'children',0,1);
/*!40000 ALTER TABLE `wp_ppc_exception_items` ENABLE KEYS */;
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
