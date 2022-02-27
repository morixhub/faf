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
-- Table structure for table `wp_snippets`
--

DROP TABLE IF EXISTS `wp_snippets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_snippets` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` tinytext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `code` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `tags` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `scope` varchar(15) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'global',
  `priority` smallint NOT NULL DEFAULT '10',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_snippets`
--

LOCK TABLES `wp_snippets` WRITE;
/*!40000 ALTER TABLE `wp_snippets` DISABLE KEYS */;
INSERT INTO `wp_snippets` VALUES (1,'Example HTML shortcode','This is an example snippet for demonstrating how to add an HTML shortcode.\r\n\r\nYou can remove it, or edit it to add your own content.','add_shortcode( \'shortcode_name\', function () {\r\n\r\n	$out = \'<p>write your HTML shortcode content here</p>\';\r\n\r\n	return $out;\r\n} );','shortcode','global',10,1,'2022-02-07 22:16:27'),(2,'Example CSS snippet','This is an example snippet for demonstrating how to add custom CSS code to your website.\n\nYou can remove it, or edit it to add your own content.','\nadd_action( \'wp_head\', function () { ?>\n<style>\n\n	/* write your CSS code here */\n\n</style>\n<?php } );\n','css','front-end',10,0,'2022-02-07 22:15:12'),(3,'Example JavaScript snippet','This is an example snippet for demonstrating how to add custom JavaScript code to your website.\n\nYou can remove it, or edit it to add your own content.','\nadd_action( \'wp_head\', function () { ?>\n<script>\n\n	/* write your JavaScript code here */\n\n</script>\n<?php } );\n','javascript','front-end',10,0,'2022-02-07 22:15:12'),(4,'Order snippets by name','Order snippets by name by default in the snippets table.','\nadd_filter( \'code_snippets/list_table/default_orderby\', function () {\n	return \'name\';\n} );\n','code-snippets-plugin','admin',10,0,'2022-02-07 22:15:12'),(5,'Order snippets by date','Order snippets by last modification date by default in the snippets table.','\nadd_filter( \'code_snippets/list_table/default_orderby\', function () {\n	return \'modified\';\n} );\n\nadd_filter( \'code_snippets/list_table/default_order\', function () {\n	return \'desc\';\n} );\n','code-snippets-plugin','admin',10,0,'2022-02-07 22:15:12'),(6,'Test HTML','This is an example snippet for demonstrating how to add an HTML shortcode.\r\n\r\nYou can remove it, or edit it to add your own content.','add_shortcode( \'test_html\', function () {\r\n\r\n	$out = \'<p>write your HTML shortcode content here</p>\';\r\n\r\n	return $out;\r\n} );','shortcode','global',10,1,'2022-02-07 22:20:35');
/*!40000 ALTER TABLE `wp_snippets` ENABLE KEYS */;
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
