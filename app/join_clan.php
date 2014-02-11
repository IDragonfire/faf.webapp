<?php

/**
Join clan modal page
**/

namespace App;

class Join_Clan extends Controller {

  function get( $f3, $f3_request_info = null ) {

    // logged in players only
    if( !$f3->get( 'logged_in_player' ) ) {
    
      $f3->set( 'join_clan_error_message', 'You must be logged in to use this function' );
      $this->render_and_die( '_join_clan.htm' );       
    }
    

    $errors = array();
    $sanitized_fields = array();

    if( $this->validate_and_clean_params( $f3, 'GET', $errors, $sanitized_fields ) == false ) {
    
      $f3->set( 'join_clan_error_message', 'Invalid parameter(s) on get request ('.__LINE__.')' );
      
    }
    else {
    
      $clan = new \Model\Clans_List( $f3->get( 'DB_CLANS' ) );
      
      $clan->load( array( 'clan_id = ? AND status = ?', $sanitized_fields[ 'clan_id' ], \Model\Clans_List::CLAN_STATUS_ACTIVE ) );
      
      if( $clan->dry() ) {
      
        $f3->set( 'join_clan_error_message', 'Invalid parameter(s) on get request ('.__LINE__.')' );
      }
      
      $f3->set( 'clan', $clan );
    
    }

    
  
    if( $f3_request_info ) { 

      // component called as AJAX modal  
      $this->render_and_die( '_join_clan.htm' );       
    }
    else
    {
      // component called internally

    }
  
  }
  
  function post( $f3 ) {
    
    // logged in players only
    if( !$f3->get( 'logged_in_player' ) ) {
    
      $f3->set( 'join_clan_error_message', 'You must be logged in to use this function' );
      $this->render_and_die( '_join_clan.htm' );       
    }
      
    // dummy data
    $f3->set( 'clan', 
      array(
        'clan_id' => '1',
        'clan_name' => 'beavercrew',
        'postdata' => print_r( $_POST, true ), 
      )
    );
    
    $errors = array();
    $sanitized_fields = array();    
   
    if( $this->validate_and_clean_params( $f3, 'POST', $errors, $sanitized_fields ) === false )
    {
      // error was found in params
      
      // we could display the error details here but this form has one editable field with no real restrictions except length, 
      // so any tampering is likely intentional and doesnt deserve a helpful response
      $f3->set( 'join_clan_error_message', 'Invalid parameter(s) on POST request ('.__LINE__.')' );
      
      $template_name = '_join_clan.htm';
      
    }
    else {
    
      if( $this->check_data_and_save( $f3, $errors, $sanitized_fields ) === false )
      {
        $f3->set( 'join_clan_error_message', $errors[0] );
        
        $template_name = '_join_clan.htm';       
      }
      else {
      
        $template_name = '_join_clan_success.htm';       
      }
      
    }
  
    // component called as AJAX modal   
    $this->render_and_die( $template_name );
  }
  
  private function render_and_die( $template_name ) {
  
 		$template=new \Template;
	  echo $template->render( $template_name );
	  die();   
  
  }
  
  
  function validate_and_clean_params( $f3, $request_method, &$errors, &$sanitized_fields ) {

    $validator = new \Helper\Validation;

    if( $request_method == 'GET' ) {

      $rules_array = array(
        'clan_id' => array( 'type' => 'numeric', 'required' => true, 'min' => 1, 'max' => PHP_INT_MAX  ),   
      );
    
       $validator->addSource( $f3->get( 'GET' ) );
    } 
    else if( $request_method == 'POST' ) {
    
      $rules_array = array(
      
        'join_clan_id'   => array( 'type' => 'numeric', 'required' => true, 'min' => 1, 'max' => PHP_INT_MAX  ),   
        'join_player_id' => array( 'type' => 'numeric', 'required' => true, 'min' => 1, 'max' => PHP_INT_MAX  ),
        'join_reason'    => array( 'type' => 'string', 'required' => false, 'min' => 1, 'max' => 960, 'trim' => true  ),
      
      );
    
      $validator->addSource( $f3->get( 'POST' ) );
    }
    
    $validator->addRules( $rules_array );

    $validator->run();
    
    if(sizeof($validator->errors) > 0) {

      $errors = $validator->errors;
      $sanitized_fields = $validator->sanitized;
      return false;

    } else {

      $errors = array();
      $sanitized_fields = $validator->sanitized;     
      return true;
    }
 
  }
  
  function check_data_and_save( $f3, &$errors, $sanitized_fields ) {
  
    // check clan with (ID = join_clan_id) exists and is not disabled
    $clan = new \Model\Clans_List( $f3->get( 'DB_CLANS' ) );

    $clan->load( array( 'clan_id = ? AND status = ?', $sanitized_fields[ 'join_clan_id' ], \Model\Clans_List::CLAN_STATUS_ACTIVE ) );

    if( $clan->dry() ) {
      $errors[] = 'Requested Clan does not exist or is not active.';
      return false;
    }
    
    
    // check player with (ID = join_player_id) exists and is not disabled
    $player = new \Model\Players_List( $f3->get( 'DB_CLANS' ) );

    $player->load( array( 'player_id = ? AND status = ?', $sanitized_fields[ 'join_player_id' ], \Model\Players_List::PLAYER_STATUS_ACTIVE ) );

    if( $player->dry() ) {
      $errors[] = 'Requesting Player does not exist or is not active.';
      return false;      
    }
    
    
    // check player with (ID = join_player_id) is the currently logged in player
    $player = $f3->get( 'logged_in_player' );
    
    if( $player->player_id <> $sanitized_fields[ 'join_player_id' ] ) {
      $errors[] = 'Requesting Player does not match the logged in player.';
      return false;      
    }
    
    
    // TODO: check clan is accepting applicants 

    // TODO: check number of supplicants already waiting on response from this clan

    // TODO: check player does not have excessive unclosed requests
    
    // retrieve the clan's message recipient player id (assume clan leader gets the requests
    $clan_leader = new \Model\Clan_Leader( $f3->get( 'DB_CLANS' ) );
    
    $clan_leader->load( array( 'clan_id = ?', $sanitized_fields[ 'join_clan_id' ] ) );
    
    if( $clan_leader->dry() ) {
      $errors[] = 'Requested Clan does not have a leader.';
      return false;    
    }


    $result = $this->sendClanJoinRequestMessage( 
      $f3,
      $sanitized_fields[ 'join_player_id' ], 
      $sanitized_fields[ 'join_clan_id' ], 
      "This is '{$player->player_name}'. Please let me join your clan '{$clan->clan_name}'.\n\n". $f3->scrub( $sanitized_fields[ 'join_reason' ] )
    );
    
    /*
    // create message
    $message = new \Model\Messages( $f3->get( 'DB_CLANS' ) );
    
    //create( $fromPlayerID, $toPlayerID, $status, $type, $body )
    $result = $message->create(
      $sanitized_fields[ 'join_player_id' ],
      $clan_leader->player_id,
      \Model\Messages::MESSAGE_STATUS_ACTIVE,
      \Model\Messages::MESSAGE_TYPE_JOIN_CLAN_REQUEST,
      "This is '{$player->player_name}'. Please let me join your clan '{$clan->clan_name}'.\n\n". $f3->scrub( $sanitized_fields[ 'join_reason' ] )
    );
    */
  
    if( !$result ) {
      $errors[] = 'Unable to create request message.';
      return false;       
    }
    
  }

  private function sendClanJoinRequestMessage( $f3, $fromPlayerID, $toClanID, $body ) {

    $db = $f3->get( 'DB_CLANS' );
    
    $db->begin();
    
    // create message
    $message = new \Model\Messages( $db );
    
    $result = $message->create( 
      $fromPlayerID, 
      \Model\Messages::MESSAGE_STATUS_ACTIVE,
      \Model\Messages::MESSAGE_TYPE_JOIN_CLAN_REQUEST,
      $body
    );
    
    if( !$result ) {
      return false;
    }
      
    // create recipients entry
    $recipient = new \Model\Message_Recipients( $db );
    
    $recipient->message_id = $message->message_id;
    $recipient->type = \Model\Message_Recipients::RECIPIENT_TYPE_CLAN_LEADER;
    $recipient->entity_id = $toClanID;
    
    $result = $recipient->save();

    $db->commit();
    
    if( !$result ) {
      return false;
    }
    
    return true;
     
  }

}
