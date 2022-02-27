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
-- Table structure for table `wp_wpdatatables`
--

DROP TABLE IF EXISTS `wp_wpdatatables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_wpdatatables` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `show_title` tinyint(1) NOT NULL DEFAULT '1',
  `table_type` varchar(55) NOT NULL,
  `content` text NOT NULL,
  `filtering` tinyint(1) NOT NULL DEFAULT '1',
  `filtering_form` tinyint(1) NOT NULL DEFAULT '0',
  `sorting` tinyint(1) NOT NULL DEFAULT '1',
  `tools` tinyint(1) NOT NULL DEFAULT '1',
  `server_side` tinyint(1) NOT NULL DEFAULT '0',
  `editable` tinyint(1) NOT NULL DEFAULT '0',
  `inline_editing` tinyint(1) NOT NULL DEFAULT '0',
  `popover_tools` tinyint(1) NOT NULL DEFAULT '0',
  `editor_roles` varchar(255) NOT NULL DEFAULT '',
  `mysql_table_name` varchar(255) NOT NULL DEFAULT '',
  `edit_only_own_rows` tinyint(1) NOT NULL DEFAULT '0',
  `userid_column_id` int NOT NULL DEFAULT '0',
  `display_length` int NOT NULL DEFAULT '10',
  `auto_refresh` int NOT NULL DEFAULT '0',
  `fixed_columns` tinyint(1) NOT NULL DEFAULT '-1',
  `fixed_layout` tinyint(1) NOT NULL DEFAULT '0',
  `responsive` tinyint(1) NOT NULL DEFAULT '0',
  `scrollable` tinyint(1) NOT NULL DEFAULT '0',
  `word_wrap` tinyint(1) NOT NULL DEFAULT '0',
  `hide_before_load` tinyint(1) NOT NULL DEFAULT '0',
  `var1` varchar(255) NOT NULL DEFAULT '',
  `var2` varchar(255) NOT NULL DEFAULT '',
  `var3` varchar(255) NOT NULL DEFAULT '',
  `tabletools_config` varchar(255) NOT NULL DEFAULT '',
  `advanced_settings` text NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_wpdatatables`
--

LOCK TABLES `wp_wpdatatables` WRITE;
/*!40000 ALTER TABLE `wp_wpdatatables` DISABLE KEYS */;
INSERT INTO `wp_wpdatatables` VALUES (1,'FafPlayers',1,'simple','{\"rowNumber\":5,\"colNumber\":5,\"colWidths\":[100,100,100,100,100],\"colHeaders\":[],\"reloadCounter\":0,\"mergedCells\":[]}',1,0,1,1,0,0,0,0,'','',0,0,10,0,-1,0,0,0,0,0,'','','','a:5:{s:5:\"print\";i:1;s:4:\"copy\";i:1;s:5:\"excel\";i:1;s:3:\"csv\";i:1;s:3:\"pdf\";i:0;}','{\"simpleResponsive\":0,\"simpleHeader\":0,\"stripeTable\":0,\"cellPadding\":10,\"removeBorders\":0,\"borderCollapse\":\"collapse\",\"borderSpacing\":0,\"verticalScroll\":0,\"verticalScrollHeight\":600}');
/*!40000 ALTER TABLE `wp_wpdatatables` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-02-28  0:10:06
