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
-- Table structure for table `wp_wpdatatables_columns`
--

DROP TABLE IF EXISTS `wp_wpdatatables_columns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_wpdatatables_columns` (
  `id` int NOT NULL AUTO_INCREMENT,
  `table_id` int NOT NULL,
  `orig_header` varchar(255) NOT NULL,
  `display_header` varchar(255) NOT NULL,
  `filter_type` enum('none','null_str','text','number','number-range','date-range','datetime-range','time-range','select','checkbox') NOT NULL,
  `column_type` enum('autodetect','string','int','float','date','link','email','image','formula','datetime','time') NOT NULL,
  `input_type` enum('none','text','textarea','mce-editor','date','datetime','time','link','email','selectbox','multi-selectbox','attachment') NOT NULL DEFAULT 'text',
  `input_mandatory` tinyint(1) NOT NULL DEFAULT '0',
  `id_column` tinyint(1) NOT NULL DEFAULT '0',
  `group_column` tinyint(1) NOT NULL DEFAULT '0',
  `sort_column` tinyint(1) NOT NULL DEFAULT '0',
  `hide_on_phones` tinyint(1) NOT NULL DEFAULT '0',
  `hide_on_tablets` tinyint(1) NOT NULL DEFAULT '0',
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `sum_column` tinyint(1) NOT NULL DEFAULT '0',
  `skip_thousands_separator` tinyint(1) NOT NULL DEFAULT '0',
  `width` varchar(4) NOT NULL DEFAULT '',
  `possible_values` text NOT NULL,
  `default_value` varchar(100) NOT NULL DEFAULT '',
  `css_class` varchar(255) NOT NULL DEFAULT '',
  `text_before` varchar(255) NOT NULL DEFAULT '',
  `text_after` varchar(255) NOT NULL DEFAULT '',
  `formatting_rules` text NOT NULL,
  `calc_formula` text NOT NULL,
  `color` varchar(255) NOT NULL DEFAULT '',
  `advanced_settings` text NOT NULL,
  `pos` int NOT NULL DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_wpdatatables_columns`
--

LOCK TABLES `wp_wpdatatables_columns` WRITE;
/*!40000 ALTER TABLE `wp_wpdatatables_columns` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_wpdatatables_columns` ENABLE KEYS */;
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
