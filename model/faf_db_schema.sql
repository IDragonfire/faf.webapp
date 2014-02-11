CREATE TABLE IF NOT EXISTS `login` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(20) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `password` char(64) NOT NULL,
  `email` char(64) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `ip` varchar(15) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `uniqueId` varchar(45) DEFAULT NULL,
  `validated` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_login` (`login`),
  UNIQUE KEY `unique_email` (`email`),
  UNIQUE KEY `uniqueId` (`uniqueId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='login' AUTO_INCREMENT=1 ;


/*

Load test data

use faf;
insert into login (login, password, validated) values ( 'thebeej', '1234', 1 );
insert into login (login, password, validated) values ( 'john', '1234', 1 );
insert into login (login, password, validated) values ( 'paul', '1234', 1 );
insert into login (login, password, validated) values ( 'george', '1234', 1 );
insert into login (login, password, validated) values ( 'ringo', '1234', 1 );

*/
