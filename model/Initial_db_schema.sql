


CREATE DATABASE clans
 CHARACTER SET utf8
 DEFAULT CHARACTER SET utf8
 COLLATE utf8_general_ci
 DEFAULT COLLATE utf8_general_ci
 ;

CREATE TABLE `clans_list` (
  `clan_id` int(11) NOT NULL AUTO_INCREMENT,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) DEFAULT 0 NOT NULL,
  `clan_name` varchar(50) NOT NULL,
  `clan_tag` varchar(16),
  `clan_founder_id` int(11),
  PRIMARY KEY (`clan_id`)
) 
ENGINE=InnoDB 
DEFAULT CHARSET=utf8; 

CREATE TABLE `players_list` (
  `player_id` int(11) NOT NULL AUTO_INCREMENT,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) DEFAULT 0 NOT NULL,
  `faf_id` mediumint(8) unsigned NOT NULL ,	
  `player_name` varchar(50) NOT NULL,
  PRIMARY KEY (`player_id`),
  UNIQUE INDEX (faf_id)
) 
ENGINE=InnoDB 
DEFAULT CHARSET=utf8; 

CREATE TABLE `clan_members` (
  `clan_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `join_clan_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `clan_rank` varchar(20) NOT NULL,
  PRIMARY KEY (`clan_id`, `player_id` ),
  INDEX( `player_id` )
) 
ENGINE=InnoDB 
DEFAULT CHARSET=utf8; 

CREATE TABLE `clan_leader` (
  `clan_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `player_name` varchar(50) NOT NULL,
  `became_leader_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`clan_id`)
) 
ENGINE=InnoDB 
DEFAULT CHARSET=utf8; 

CREATE TABLE `messages` (
  message_id int(11) NOT NULL AUTO_INCREMENT,
  from_player_id int(11) NOT NULL,
  status int(1) DEFAULT 0 NOT NULL,
  type int(1) DEFAULT 0 NOT NULL,
  date_sent timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  body varchar(1024),
  PRIMARY KEY (`message_id`)
)
ENGINE=InnoDB 
DEFAULT CHARSET=utf8; 

CREATE TABLE `seen_messages` (
  seen_message_id int(11) NOT NULL AUTO_INCREMENT,
  player_id int(11) NOT NULL,
  message_id int(11) NOT NULL,
  status int(1) DEFAULT 0 NOT NULL,
  PRIMARY KEY (`seen_message_id`),
  INDEX( player_id, message_id, status ),
  INDEX( message_id, player_id, status )
  
)
ENGINE=InnoDB 
DEFAULT CHARSET=utf8; 


CREATE TABLE `recipients` (
  recipient_id int(11) NOT NULL AUTO_INCREMENT,
  message_id int(11) NOT NULL,
  type int(1) NOT NULL,
  entity_id int(11) NOT NULL,
  PRIMARY KEY (recipient_id),
  INDEX( message_id)
  
)
ENGINE=InnoDB 
DEFAULT CHARSET=utf8; 



CREATE VIEW Clans_List_Page_View as
select distinct `c`.`clan_id` AS `clan_id`, 
`c`.`clan_name` AS `clan_name`, 
`c`.`clan_tag` AS `clan_tag`, 
`l`.`player_name` AS `leader_name`, 
count(p.player_id) as `clan_active_members` 
from  `clans_list` `c`  
join `clan_members` `m` on `c`.`clan_id` = `m`.`clan_id` 
join `clan_leader` `l` on `c`.`clan_id` = `l`.`clan_id` 
join players_list p on m.player_id = p.player_id and p.status = 1 
where (`c`.`status` = 1) 
group by clan_id;

CREATE VIEW Clans_Details_Page_View as
SELECT    
c.clan_id, 
c.clan_name, 
c.clan_tag,    
l.player_name as leader_name, 
f.player_name as founder_name, 
DATE_FORMAT( c.create_date, '%Y-%c-%e') as founded_date
FROM    
clans_list c    
LEFT OUTER JOIN clan_leader l      
ON c.clan_id = l.clan_id    
LEFT OUTER JOIN players_list f      
ON c.clan_founder_id = f.player_id 
WHERE    
c.status = 1;

CREATE VIEW Clan_Members_List_View as
SELECT
  CM.clan_id,
  PL.player_id,
  PL.player_name,
  CM.join_clan_date,
  CM.clan_rank
FROM
  players_list PL join clan_members CM ON CM.player_id = PL.player_id
WHERE
  PL.status = 1

/*

select distinct `c`.`clan_id` AS `clan_id`, 
`c`.`clan_name` AS `clan_name`, 
`c`.`clan_tag` AS `clan_tag`, 
`l`.`player_name` AS `leader_name`, 
count(p.player_id) as `clan_active_members` 
from  `clans_list` `c`  
join `clan_members` `m` on `c`.`clan_id` = `m`.`clan_id` 
join `clan_leader` `l` on `c`.`clan_id` = `l`.`clan_id` 
join players_list p on m.player_id = p.player_id and p.status = 1 
where (`c`.`status` = 1) 
group by clan_id;





*/








