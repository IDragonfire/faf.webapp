<?php

namespace Model;

class Message_Recipients extends \DB\SQL\Mapper {

  /*
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
  */
  
  const RECIPIENT_TYPE_PLAYER = 1;
  const RECIPIENT_TYPE_CLAN_LEADER = 2;
  const RECIPIENT_TYPE_CLAN_ALL_MEMBERS = 3;
  //const RECIPIENT_TYPE_CLAN_SENIOR_MEMBERS = 4;   // this is not implemented 


  // Instantiate mapper
  function __construct( \DB\SQL $db ) {
  
    // This is where the mapper and DB structure synchronization occurs
    parent::__construct( $db, 'recipients');
  }

    
}
