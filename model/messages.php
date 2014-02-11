<?php

namespace Model;

class Messages extends \DB\SQL\Mapper {

  const MESSAGE_STATUS_CLEARED = 0; // in general, no longer displayed
  const MESSAGE_STATUS_ACTIVE = 1;
  
  const MESSAGE_TYPE_JOIN_CLAN_REQUEST = 0;
  const MESSAGE_TYPE_JOIN_CLAN_RESPONSE = 1;
  const MESSAGE_TYPE_INVITE_PLAYER_REQUEST = 2;  
  const MESSAGE_TYPE_INVITE_PLAYER_RESPONSE = 3;  
  

  // Instantiate mapper
  function __construct( \DB\SQL $db ) {
  
    // This is where the mapper and DB structure synchronization occurs
    parent::__construct( $db, 'messages ');
  }

  function create( $fromPlayerID, $status, $type, $body ) {
  
    // validate from player id
    $from_player = new \Model\Players_List( $this->db );
    
    $from_player->load( array( 'player_id = ?', $fromPlayerID ) );
    
    if( $from_player->dry() ) {
    
      return false;
    }

    // validate status
    if( !is_int( $status ) || $status > 255 ) {
      return false;
    }
    
    // validate type    
    if( !is_int( $type ) || $type > 255 ) {
      return false;
    }    
    
    $this->from_player_id = $fromPlayerID;
    $this->status         = $status;
    $this->type           = $type;
    $this->date_sent      = date("Y-m-d H:i:s", time()); 
    $this->body           = substr( $body, 0, 1023 );

    return $this->save();
  }
  
  function get_active_messages_for_player( $toPlayerID ) {
  
    return $this->db->exec(
      "SELECT message_id, from_player_id, player_name as from_name, type, DATE_FORMAT( date_sent, '%Y-%c-%e') as date FROM messages M ".
      "JOIN players_list PL on M.from_player_id = PL.player_id ".
      "WHERE M.status = ". self::MESSAGE_STATUS_ACTIVE ." AND to_player_id = ?",
      $toPlayerID 
    );
  
  }

  function get_active_messages_from_player( $fromPlayerID ) {
  
    return $this->db->exec(
      "/* A */ SELECT message_id, from_player_id, player_name as to_name, type, DATE_FORMAT( date_sent, '%Y-%c-%e') as date FROM messages M ".
      "JOIN players_list PL on M.to_player_id = PL.player_id ".
      "WHERE M.status = ". self::MESSAGE_STATUS_ACTIVE ." AND from_player_id = ?",
      $fromPlayerID 
    );
  
  }
  
  function get_message_detail_for_display( $message_id ) {
    return $this->db->exec(
      "SELECT message_id, player_name as from_name, type, DATE_FORMAT( date_sent, '%Y-%c-%e') as date, body FROM messages M ".
      "JOIN players_list PL on M.from_player_id = PL.player_id ".
      "WHERE M.status = ". self::MESSAGE_STATUS_ACTIVE ." AND message_id = ?",
      $message_id 
    );  
  }
  
  function get_message_detail_for_response( $message_id ) {
    return $this->db->exec(
      "SELECT message_id, from_player_id, player_name as from_name, type FROM messages M ".
      "JOIN players_list PL on M.from_player_id = PL.player_id ".
      "WHERE M.status = ". self::MESSAGE_STATUS_ACTIVE ." AND message_id = ?",
      $message_id 
    );  
  }
  
    
}
