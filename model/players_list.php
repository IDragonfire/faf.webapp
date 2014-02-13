<?php

namespace Model;

class Players_List extends \DB\SQL\Mapper {

  const PLAYER_STATUS_INACTIVE = 0;
  const PLAYER_STATUS_ACTIVE = 1;

  // Instantiate mapper
  function __construct( \DB\SQL $db ) {
  
    // This is where the mapper and DB structure synchronization occurs
    parent::__construct( $db, 'players_list ');
  }

  function updateOrCreate( $faf_id, $username ) {
  
    $this->load( array(' faf_id = ? ', $faf_id ) );
    
    if( $this->dry() ) {

      $this->status = self::PLAYER_STATUS_ACTIVE;
      $this->faf_id = $faf_id;
      $this->player_name = $username;
      
    } else {

      // player username may have changed from last login
      $this->player_name = $username;

    }
    
    $this->save();        
  }
  
  function __toString() {
	return $this->faf_id . ':' . $this->player_name . ':' . $this->status;
  }    
}
