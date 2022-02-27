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
-- Table structure for table `wp_pp_groups`
--

DROP TABLE IF EXISTS `wp_pp_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_pp_groups` (
  `ID` bigint NOT NULL AUTO_INCREMENT,
  `group_name` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `group_description` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `metagroup_id` varchar(64) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `metagroup_type` varchar(32) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `pp_grp_metaid` (`metagroup_type`,`metagroup_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_pp_groups`
--

LOCK TABLES `wp_pp_groups` WRITE;
/*!40000 ALTER TABLE `wp_pp_groups` DISABLE KEYS */;
INSERT INTO `wp_pp_groups` VALUES (1,'[WP administrator]','All users with a WordPress administrator role','administrator','wp_role'),(2,'[WP editor]','All users with a WordPress editor role','editor','wp_role'),(3,'[WP author]','All users with a WordPress author role','author','wp_role'),(4,'[WP contributor]','All users with a WordPress contributor role','contributor','wp_role'),(5,'[WP subscriber]','All users with a WordPress subscriber role','subscriber','wp_role'),(6,'Not Logged In','Anonymous users (not logged in)','wp_anon','wp_role'),(7,'Logged In','All users who are logged in and have a role on the site','wp_auth','wp_role'),(8,'Everyone','All users (including anonymous)','wp_all','wp_role'),(9,'Pending Revision Monitors','Administrators / Publishers to notify (by default) of pending revisions','rvy_pending_rev_notice','rvy_notice'),(10,'Scheduled Revision Monitors','Administrators / Publishers to notify when any scheduled revision is published','rvy_scheduled_rev_notice','rvy_notice');
/*!40000 ALTER TABLE `wp_pp_groups` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-02-28  0:10:05
