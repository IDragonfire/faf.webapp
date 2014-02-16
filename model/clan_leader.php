<?php

namespace Model;

class Clan_Leader extends \DB\SQL\Mapper {

  // Instantiate mapper
  function __construct( \DB\SQL $db ) {
  
    // This is where the mapper and DB structure synchronization occurs
    parent::__construct( $db, 'clan_leader ');
  }

  function set_clan_leader( $clan_id, $player_id ) {
  
    $this->erase( array( ' clan_id = ? OR player_id = ? ', $clan_id, $player_id ) );
    
    // get playername from playerid
    $player = new \Model\Players_List( $this->db );
    $player->load( array( 'player_id = ?', $player_id ) );
    
    $this->reset();
    $this->clan_id = $clan_id;
    $this->player_id = $player_id;
    $this->player_name = $player->player_name;
    $this->save();
  }
  
  function remove_leadership_from_player( $player_id ) {
    
    $list = $this->find( array( ' player_id = ? ', $player_id ) );
    
    foreach( $list as $clan_leader_mapper ) {
    
      $clan_leader_mapper->erase();
    }
  }

  function get_clan_leadership( $player_id ) {
  
    // find existing record for player
    $this->load( array( 'player_id = ?', $player_id ) );
    
    if( $this->dry() ) {
      return FALSE;
    }
    else {
      return $this->clan_id;
    }
  
  }
  
}
