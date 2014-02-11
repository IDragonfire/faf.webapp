SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE TABLE IF NOT EXISTS `clans_details_page_view` (
`clan_id` int(11)
,`clan_name` varchar(50)
,`clan_tag` varchar(16)
,`leader_name` varchar(50)
,`founder_name` varchar(50)
,`founded_date` varchar(10)
);
CREATE TABLE IF NOT EXISTS `clans_list` (
  `clan_id` int(11) NOT NULL AUTO_INCREMENT,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL DEFAULT '0',
  `clan_name` varchar(50) NOT NULL,
  `clan_tag` varchar(16) DEFAULT NULL,
  `clan_founder_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`clan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

INSERT INTO `clans_list` (`clan_id`, `create_date`, `status`, `clan_name`, `clan_tag`, `clan_founder_id`) VALUES
(1, '2014-02-11 10:22:49', 1, 'Spearhead', 'SPQR', 2),
(2, '2014-02-11 10:22:49', 0, 'Loyalist', 'AUS', NULL),
(3, '2014-02-11 10:22:49', 1, 'Percival', 'DND', NULL),
(4, '2014-02-11 10:22:49', 1, 'Revenant', 'PwnStars', NULL);
CREATE TABLE IF NOT EXISTS `clans_list_page_view` (
`clan_id` int(11)
,`clan_name` varchar(50)
,`clan_tag` varchar(16)
,`leader_name` varchar(50)
,`clan_active_members` bigint(21)
);
CREATE TABLE IF NOT EXISTS `clan_leader` (
  `clan_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `player_name` varchar(50) NOT NULL,
  `became_leader_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`clan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `clan_leader` (`clan_id`, `player_id`, `player_name`, `became_leader_date`) VALUES
(1, 46, 'Gordon', '2014-02-11 10:42:00');

CREATE TABLE IF NOT EXISTS `clan_members` (
  `clan_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `join_clan_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `clan_rank` varchar(20) NOT NULL,
  PRIMARY KEY (`clan_id`,`player_id`),
  KEY `player_id` (`player_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `clan_members` (`clan_id`, `player_id`, `join_clan_date`, `clan_rank`) VALUES
(1, 44, '2014-02-11 10:26:00', 'Plebian'),
(1, 46, '2014-02-11 10:26:00', 'Plebian'),
(1, 48, '2014-02-11 10:26:00', 'Plebian');
CREATE TABLE IF NOT EXISTS `clan_members_list_view` (
`clan_id` int(11)
,`player_id` int(11)
,`player_name` varchar(50)
,`join_clan_date` timestamp
,`clan_rank` varchar(20)
);
CREATE TABLE IF NOT EXISTS `messages` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `from_player_id` int(11) NOT NULL,
  `to_player_id` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `type` int(1) NOT NULL DEFAULT '0',
  `date_sent` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `body` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `players_list` (
  `player_id` int(11) NOT NULL AUTO_INCREMENT,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL DEFAULT '0',
  `faf_id` mediumint(8) unsigned NOT NULL,
  `player_name` varchar(50) NOT NULL,
  PRIMARY KEY (`player_id`),
  UNIQUE KEY `faf_id` (`faf_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50 ;

INSERT INTO `players_list` (`player_id`, `create_date`, `status`, `faf_id`, `player_name`) VALUES
(43, '2014-02-11 10:25:47', 1, 1, 'Lara Croft'),
(44, '2014-02-11 10:25:47', 1, 2, 'Max Payne'),
(45, '2014-02-11 10:25:47', 1, 3, 'Donkey Kong'),
(46, '2014-02-11 10:25:47', 1, 4, 'Gordon Freeman'),
(47, '2014-02-11 10:25:47', 1, 5, 'Adam Jensen'),
(48, '2014-02-11 10:25:47', 1, 6, 'The Nameless One'),
(49, '2014-02-11 10:25:47', 1, 7, 'Guybrush Threepwood');

CREATE TABLE IF NOT EXISTS `recipients` (
  `recipient_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_id` int(11) NOT NULL,
  `type` int(1) NOT NULL,
  `entity_id` int(11) NOT NULL,
  PRIMARY KEY (`recipient_id`),
  KEY `message_id` (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `seen_messages` (
  `seen_message_id` int(11) NOT NULL AUTO_INCREMENT,
  `player_id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`seen_message_id`),
  KEY `player_id` (`player_id`,`message_id`,`status`),
  KEY `message_id` (`message_id`,`player_id`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
DROP TABLE IF EXISTS `clans_details_page_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `clans_details_page_view` AS select `c`.`clan_id` AS `clan_id`,`c`.`clan_name` AS `clan_name`,`c`.`clan_tag` AS `clan_tag`,`l`.`player_name` AS `leader_name`,`f`.`player_name` AS `founder_name`,date_format(`c`.`create_date`,'%Y-%c-%e') AS `founded_date` from ((`clans_list` `c` left join `clan_leader` `l` on((`c`.`clan_id` = `l`.`clan_id`))) left join `players_list` `f` on((`c`.`clan_founder_id` = `f`.`player_id`))) where (`c`.`status` = 1);
DROP TABLE IF EXISTS `clans_list_page_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `clans_list_page_view` AS select distinct `c`.`clan_id` AS `clan_id`,`c`.`clan_name` AS `clan_name`,`c`.`clan_tag` AS `clan_tag`,`l`.`player_name` AS `leader_name`,count(`p`.`player_id`) AS `clan_active_members` from (((`clans_list` `c` join `clan_members` `m` on((`c`.`clan_id` = `m`.`clan_id`))) join `clan_leader` `l` on((`c`.`clan_id` = `l`.`clan_id`))) join `players_list` `p` on(((`m`.`player_id` = `p`.`player_id`) and (`p`.`status` = 1)))) where (`c`.`status` = 1) group by `c`.`clan_id`;
DROP TABLE IF EXISTS `clan_members_list_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `clan_members_list_view` AS select `cm`.`clan_id` AS `clan_id`,`pl`.`player_id` AS `player_id`,`pl`.`player_name` AS `player_name`,`cm`.`join_clan_date` AS `join_clan_date`,`cm`.`clan_rank` AS `clan_rank` from (`players_list` `pl` join `clan_members` `cm` on((`cm`.`player_id` = `pl`.`player_id`))) where (`pl`.`status` = 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
