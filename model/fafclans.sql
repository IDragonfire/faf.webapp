CREATE DATABASE  IF NOT EXISTS `fafclans` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `fafclans`;
-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: fafclans
-- ------------------------------------------------------
-- Server version	5.6.14

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
-- Table structure for table `clan_invites`
--

DROP TABLE IF EXISTS `clan_invites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clan_invites` (
  `clan_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `user_request` int(11) NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`clan_id`,`player_id`,`user_request`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clan_invites`
--

LOCK TABLES `clan_invites` WRITE;
/*!40000 ALTER TABLE `clan_invites` DISABLE KEYS */;
INSERT INTO `clan_invites` VALUES (1,51,1,'2014-02-13 13:08:50');
/*!40000 ALTER TABLE `clan_invites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clan_leader`
--

DROP TABLE IF EXISTS `clan_leader`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clan_leader` (
  `clan_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `player_name` varchar(50) NOT NULL,
  `became_leader_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`clan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clan_leader`
--

LOCK TABLES `clan_leader` WRITE;
/*!40000 ALTER TABLE `clan_leader` DISABLE KEYS */;
INSERT INTO `clan_leader` VALUES (1,46,'Gordon','2014-02-11 10:42:00'),(7,43,'dragon','2014-02-12 20:14:53');
/*!40000 ALTER TABLE `clan_leader` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clan_members`
--

DROP TABLE IF EXISTS `clan_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clan_members` (
  `clan_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `join_clan_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `clan_rank` varchar(20) NOT NULL,
  PRIMARY KEY (`clan_id`,`player_id`),
  KEY `player_id` (`player_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clan_members`
--

LOCK TABLES `clan_members` WRITE;
/*!40000 ALTER TABLE `clan_members` DISABLE KEYS */;
INSERT INTO `clan_members` VALUES (1,44,'2014-02-11 10:26:00','Plebian'),(1,46,'2014-02-11 10:26:00','Plebian'),(1,48,'2014-02-11 10:26:00','Plebian'),(7,43,'2014-02-13 12:00:43','LAB'),(7,45,'2014-02-13 11:04:03','LAB'),(7,441,'2014-02-13 11:00:09','LAB');
/*!40000 ALTER TABLE `clan_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `clan_members_list_view`
--

DROP TABLE IF EXISTS `clan_members_list_view`;
/*!50001 DROP VIEW IF EXISTS `clan_members_list_view`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `clan_members_list_view` (
  `clan_id` tinyint NOT NULL,
  `player_id` tinyint NOT NULL,
  `player_name` tinyint NOT NULL,
  `join_clan_date` tinyint NOT NULL,
  `clan_rank` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `clans_details_page_view`
--

DROP TABLE IF EXISTS `clans_details_page_view`;
/*!50001 DROP VIEW IF EXISTS `clans_details_page_view`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `clans_details_page_view` (
  `clan_id` tinyint NOT NULL,
  `clan_name` tinyint NOT NULL,
  `clan_tag` tinyint NOT NULL,
  `leader_name` tinyint NOT NULL,
  `founder_name` tinyint NOT NULL,
  `founded_date` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `clans_list`
--

DROP TABLE IF EXISTS `clans_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clans_list` (
  `clan_id` int(11) NOT NULL AUTO_INCREMENT,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL DEFAULT '0',
  `clan_name` varchar(50) NOT NULL,
  `clan_tag` varchar(3) DEFAULT NULL,
  `clan_founder_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`clan_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clans_list`
--

LOCK TABLES `clans_list` WRITE;
/*!40000 ALTER TABLE `clans_list` DISABLE KEYS */;
INSERT INTO `clans_list` VALUES (1,'2014-02-11 10:22:49',1,'Spearhead','SPQ',2),(2,'2014-02-11 10:22:49',0,'Loyalist','AUS',NULL),(3,'2014-02-11 10:22:49',1,'Percival','DND',NULL),(4,'2014-02-11 10:22:49',1,'Revenant','Pwn',NULL),(5,'2014-02-11 13:51:54',1,'MyCoolClan','MCC',NULL),(6,'2014-02-12 20:09:08',1,'test','t',43),(7,'2014-02-12 20:14:53',1,'dada','dad',43);
/*!40000 ALTER TABLE `clans_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `clans_list_page_view`
--

DROP TABLE IF EXISTS `clans_list_page_view`;
/*!50001 DROP VIEW IF EXISTS `clans_list_page_view`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `clans_list_page_view` (
  `clan_id` tinyint NOT NULL,
  `clan_name` tinyint NOT NULL,
  `clan_tag` tinyint NOT NULL,
  `leader_name` tinyint NOT NULL,
  `clan_active_members` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `membership_request_page_view`
--

DROP TABLE IF EXISTS `membership_request_page_view`;
/*!50001 DROP VIEW IF EXISTS `membership_request_page_view`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `membership_request_page_view` (
  `player_id` tinyint NOT NULL,
  `player_name` tinyint NOT NULL,
  `time` tinyint NOT NULL,
  `clan_id` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `from_player_id` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `type` int(1) NOT NULL DEFAULT '0',
  `date_sent` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `body` varchar(1024) DEFAULT NULL,
  `to_player_id` varchar(16) NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,50,1,0,'2014-02-12 13:49:35','This is \'d\'. Please let me join your clan \'Spearhead\'.\n\n',''),(2,51,1,0,'2014-02-12 14:20:52','This is \'d1\'. Please let me join your clan \'Spearhead\'.\n\ntest',''),(3,51,1,0,'2014-02-12 14:21:22','This is \'d1\'. Please let me join your clan \'Spearhead\'.\n\n',''),(4,51,1,0,'2014-02-12 14:21:33','This is \'d1\'. Please let me join your clan \'MyCoolClan\'.\n\ndfg',''),(5,51,1,0,'2014-02-12 21:02:24','This is \'d1\'. Please let me join your clan \'Spearhead\'.\n\na',''),(6,50,1,0,'2014-02-13 09:41:21','This is \'d\'. Please let me join your clan \'Spearhead\'.\n\na',''),(7,50,1,0,'2014-02-13 09:41:45','This is \'d\'. Please let me join your clan \'dada\'.\n\na',''),(8,441,1,0,'2014-02-13 09:43:35','This is \'John\'. Please let me join your clan \'dada\'.\n\na',''),(9,51,1,0,'2014-02-13 11:08:39','This is \'d1\'. Please let me join your clan \'dada\'.\n\na',''),(10,51,1,0,'2014-02-13 11:08:43','This is \'d1\'. Please let me join your clan \'dada\'.\n\na',''),(11,51,1,0,'2014-02-13 11:08:44','This is \'d1\'. Please let me join your clan \'dada\'.\n\na',''),(12,51,1,0,'2014-02-13 11:08:44','This is \'d1\'. Please let me join your clan \'dada\'.\n\na',''),(13,51,1,0,'2014-02-13 11:08:45','This is \'d1\'. Please let me join your clan \'dada\'.\n\na',''),(14,51,1,0,'2014-02-13 11:08:46','This is \'d1\'. Please let me join your clan \'dada\'.\n\na',''),(15,51,1,0,'2014-02-13 11:08:46','This is \'d1\'. Please let me join your clan \'dada\'.\n\na',''),(16,51,1,0,'2014-02-13 11:08:46','This is \'d1\'. Please let me join your clan \'dada\'.\n\na',''),(17,51,1,0,'2014-02-13 11:08:50','This is \'d1\'. Please let me join your clan \'Spearhead\'.\n\na',''),(18,51,1,0,'2014-02-13 11:08:53','This is \'d1\'. Please let me join your clan \'dada\'.\n\na',''),(19,51,1,0,'2014-02-13 11:08:57','This is \'d1\'. Please let me join your clan \'dada\'.\n\na',''),(20,51,1,0,'2014-02-13 11:08:58','This is \'d1\'. Please let me join your clan \'dada\'.\n\na',''),(21,51,1,0,'2014-02-13 11:08:58','This is \'d1\'. Please let me join your clan \'dada\'.\n\na','');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `player_invites_page_view`
--

DROP TABLE IF EXISTS `player_invites_page_view`;
/*!50001 DROP VIEW IF EXISTS `player_invites_page_view`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `player_invites_page_view` (
  `clan_name` tinyint NOT NULL,
  `player_id` tinyint NOT NULL,
  `clan_id` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `player_list_page_view`
--

DROP TABLE IF EXISTS `player_list_page_view`;
/*!50001 DROP VIEW IF EXISTS `player_list_page_view`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `player_list_page_view` (
  `player_id` tinyint NOT NULL,
  `player_name` tinyint NOT NULL,
  `clan_name` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `players_list`
--

DROP TABLE IF EXISTS `players_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `players_list` (
  `player_id` int(11) NOT NULL AUTO_INCREMENT,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL DEFAULT '0',
  `faf_id` mediumint(8) unsigned NOT NULL,
  `player_name` varchar(50) NOT NULL,
  PRIMARY KEY (`player_id`),
  UNIQUE KEY `faf_id` (`faf_id`)
) ENGINE=InnoDB AUTO_INCREMENT=442 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `players_list`
--

LOCK TABLES `players_list` WRITE;
/*!40000 ALTER TABLE `players_list` DISABLE KEYS */;
INSERT INTO `players_list` VALUES (43,'2014-02-11 10:25:47',1,1,'dragon'),(45,'2014-02-11 10:25:47',1,3,'Donkey Kong'),(46,'2014-02-11 10:25:47',1,4,'Gordon Freeman'),(47,'2014-02-11 10:25:47',1,5,'Adam Jensen'),(48,'2014-02-11 10:25:47',1,6,'The Nameless One'),(49,'2014-02-11 10:25:47',1,7,'Guybrush Threepwood'),(50,'2014-02-12 14:49:24',1,22,'d'),(51,'2014-02-12 15:00:45',1,101,'d1'),(440,'2014-02-11 10:25:47',1,20,'d'),(441,'2014-02-13 10:43:31',1,102,'John');
/*!40000 ALTER TABLE `players_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recipients`
--

DROP TABLE IF EXISTS `recipients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recipients` (
  `recipient_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_id` int(11) NOT NULL,
  `type` int(1) NOT NULL,
  `entity_id` int(11) NOT NULL,
  PRIMARY KEY (`recipient_id`),
  KEY `message_id` (`message_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recipients`
--

LOCK TABLES `recipients` WRITE;
/*!40000 ALTER TABLE `recipients` DISABLE KEYS */;
INSERT INTO `recipients` VALUES (1,1,2,1),(2,2,2,1),(3,3,2,1),(4,4,2,5),(5,5,2,1),(6,6,2,1),(7,7,2,7),(8,8,2,7),(9,9,2,7),(10,10,2,7),(11,11,2,7),(12,12,2,7),(13,13,2,7),(14,14,2,7),(15,15,2,7),(16,16,2,7),(17,17,2,1),(18,18,2,7),(19,19,2,7),(20,20,2,7),(21,21,2,7);
/*!40000 ALTER TABLE `recipients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seen_messages`
--

DROP TABLE IF EXISTS `seen_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seen_messages` (
  `seen_message_id` int(11) NOT NULL AUTO_INCREMENT,
  `player_id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`seen_message_id`),
  KEY `player_id` (`player_id`,`message_id`,`status`),
  KEY `message_id` (`message_id`,`player_id`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seen_messages`
--

LOCK TABLES `seen_messages` WRITE;
/*!40000 ALTER TABLE `seen_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `seen_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `clan_members_list_view`
--

/*!50001 DROP TABLE IF EXISTS `clan_members_list_view`*/;
/*!50001 DROP VIEW IF EXISTS `clan_members_list_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `clan_members_list_view` AS select `cm`.`clan_id` AS `clan_id`,`pl`.`player_id` AS `player_id`,`pl`.`player_name` AS `player_name`,`cm`.`join_clan_date` AS `join_clan_date`,`cm`.`clan_rank` AS `clan_rank` from (`players_list` `pl` join `clan_members` `cm` on((`cm`.`player_id` = `pl`.`player_id`))) where (`pl`.`status` = 1) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `clans_details_page_view`
--

/*!50001 DROP TABLE IF EXISTS `clans_details_page_view`*/;
/*!50001 DROP VIEW IF EXISTS `clans_details_page_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `clans_details_page_view` AS select `c`.`clan_id` AS `clan_id`,`c`.`clan_name` AS `clan_name`,`c`.`clan_tag` AS `clan_tag`, `l`.`player_name` AS `leader_name`,`f`.`player_name` AS `founder_name`,date_format(`c`.`create_date`,'%Y-%c-%e') AS `founded_date` from ((`clans_list` `c` left join `clan_leader` `l` on((`c`.`clan_id` = `l`.`clan_id`))) left join `players_list` `f` on((`c`.`clan_founder_id` = `f`.`player_id`))) where (`c`.`status` = 1) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `clans_list_page_view`
--

/*!50001 DROP TABLE IF EXISTS `clans_list_page_view`*/;
/*!50001 DROP VIEW IF EXISTS `clans_list_page_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `clans_list_page_view` AS select distinct `c`.`clan_id` AS `clan_id`,`c`.`clan_name` AS `clan_name`,`c`.`clan_tag` AS `clan_tag`,`l`.`player_name` AS `leader_name`,count(`p`.`player_id`) AS `clan_active_members` from (((`clans_list` `c` join `clan_members` `m` on((`c`.`clan_id` = `m`.`clan_id`))) join `clan_leader` `l` on((`c`.`clan_id` = `l`.`clan_id`))) join `players_list` `p` on(((`m`.`player_id` = `p`.`player_id`) and (`p`.`status` = 1)))) where (`c`.`status` = 1) group by `c`.`clan_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `membership_request_page_view`
--

/*!50001 DROP TABLE IF EXISTS `membership_request_page_view`*/;
/*!50001 DROP VIEW IF EXISTS `membership_request_page_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `membership_request_page_view` AS select `i`.`player_id` AS `player_id`,`p`.`player_name` AS `player_name`,`i`.`time` AS `time`,`i`.`clan_id` AS `clan_id` from (`clan_invites` `i` left join `players_list` `p` on((`i`.`player_id` = `p`.`player_id`))) where (`i`.`user_request` = 1) order by `i`.`time` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `player_invites_page_view`
--

/*!50001 DROP TABLE IF EXISTS `player_invites_page_view`*/;
/*!50001 DROP VIEW IF EXISTS `player_invites_page_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `player_invites_page_view` AS select `c`.`clan_name` AS `clan_name`,`i`.`player_id` AS `player_id`,`i`.`clan_id` AS `clan_id` from (`clan_invites` `i` join `clans_list` `c` on((`i`.`clan_id` = `c`.`clan_id`))) where (`i`.`user_request` = 0) order by `i`.`time` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `player_list_page_view`
--

/*!50001 DROP TABLE IF EXISTS `player_list_page_view`*/;
/*!50001 DROP VIEW IF EXISTS `player_list_page_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `player_list_page_view` AS select `p`.`player_id` AS `player_id`,`p`.`player_name` AS `player_name`,ifnull(`c`.`clan_name`,'-') AS `clan_name` from ((`players_list` `p` left join `clan_members` `m` on((`p`.`player_id` = `m`.`player_id`))) left join `clans_list` `c` on((`m`.`clan_id` = `c`.`clan_id`))) where (`p`.`status` = 1) order by `p`.`player_name` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-02-13 13:09:44
