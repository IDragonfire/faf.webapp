<?php

namespace Model;

class Clan_Member extends \DB\SQL\Mapper {

  // Instantiate mapper
  function __construct( \DB\SQL $db ) {
  
    // This is where the mapper and DB structure synchronization occurs
    parent::__construct( $db, 'clan_members ');
  }

  function player_join_clan( $player_id, $clan_id, $rank = 'LAB' )
  {
    _log( "param: player_id : $player_id| clan_id : $clan_id|" );

    $this->load(array('player_id = ?', $player_id));
    if(!$this->dry()) {
      // Player has a clan
      return FALSE;
    }
  
    // find existing record for player
    $this->load( array( 'player_id = ?', $player_id ) );
    
    _log( "is dry?:".( $this->dry() ? 'YES': 'NO' ) );
    
    // doesn't matter if player record is dry, overwriting all fields anyway
    $this->clan_id = $clan_id;
    $this->player_id = $player_id;
    $this->clan_rank = $rank;
    $this->save();
    return TRUE;
  }

  function setRank($player_id, $new_rank) {
    $this->load(array('player_id = ?', $player_id));
    if($this->dry()) {
      return FALSE;
    }
    $this->clan_rank = $new_rank;
    $this->save();
    return TRUE;
  }
  
  function leaveClan($player_id) {
	$membership = $this->load( array( 'player_id = ?', $player_id ) );
    
    if( $this->dry() ) {
      return FALSE;
    }
    else {
      return $membership->erase();
    }
  }

  function get_clan_membership( $player_id ) {
  
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
