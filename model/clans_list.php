<?php

namespace Model;

class Clans_List extends \DB\SQL\Mapper {

  const CLAN_STATUS_INACTIVE = 0;
  const CLAN_STATUS_ACTIVE = 1;

  // Instantiate mapper
  function __construct( \DB\SQL $db ) {
  
    // This is where the mapper and DB structure synchronization occurs
    parent::__construct( $db, 'clans_list ');
  }
    
}
