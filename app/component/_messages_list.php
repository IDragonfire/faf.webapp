<?php

/**

Messages list page component

**/

namespace App\Component;

class _Messages_List extends \App\Controller {

  function get( $f3, $f3_request_info = null ) {
  
    $player = $f3->get( 'logged_in_player' );
    
    if( !$player ) {
      die(__CLASS__.'::'.__FUNCTION__.': no player logged in');
    }
    
    // retrieve data for messages lists (inbox and outbox)
    $this->displayMessagesList( $f3, $player );

    
    // 2nd param of GET is populated by routing mapper, thus is populated if request from external, not an internal call
    if( $f3_request_info ) { 
      // component called as AJAX    
  		$template=new \Template;
  	  echo $template->render( '_messages_list.htm' );
  	  die();
    }
    else
    {
      // component called internally
      $f3->set( 'messages_list_component_template', '_messages_list.htm' );
    }
  }

  function post ( $f3 ) {

    switch( $f3->get( 'POST.action' ) ) {
      case 'delete':
        $this->deleteMessageRequest( $f3 );
        break;
        
      case 'accept':
        $this->acceptSupplicantRequest( $f3 );
        break;
        
        
      default:
        die( __CLASS__.'::'.__FUNCTION__.': invalid request' );
    }
    
    $this->get( $f3, TRUE );
    
  }
  
  private function displayMessagesList( $f3, $player ) {
  
    $messages = new \Model\Messages( $f3->get( 'DB_CLANS') );
    
    $messages_in_arr = $messages->get_active_messages_for_player( $player->player_id );
    
    foreach( $messages_in_arr as $i => $message ) {
    
      // replace numeric message type code with human readable text
      switch( $message[ 'type' ] ) {
      
        case \Model\Messages::MESSAGE_TYPE_JOIN_CLAN_REQUEST:
          $messages_in_arr[ $i ][ 'type' ] = 'Request to Join Clan';
          break;
        
        default:
          $messages_in_arr[ $i ][ 'type' ] = 'Unknown Message Type';
      }
      
      // actions html for row
      
      $action_html_view = '<a href="/component/_message_details?message_id='. $message[ 'message_id' ] .'" class="btn  btn-small" data-message-action="view">View</a>';

      $action_html_delete = '<a href="/component/_messages_list?action=delete&message_id='. $message[ 'message_id' ] .'" class="btn  btn-small" data-message-action="delete">Delete</a>';
      
      $messages_in_arr[ $i ][ 'actions' ] = "$action_html_view $action_html_delete";
      
    }
    
    $f3->set( 'inbox_messages', $messages_in_arr );
  
  
  
    $messages_out_arr = $messages->get_active_messages_from_player( $player->player_id );

    foreach( $messages_out_arr as $i => $message ) {

      // HACK! to get around PHP considering a switch to be a loop and thus preventing 'continue' of the outer foreach
      $continue_foreach = false;
    
      // replace numeric message type code with human readable text
      switch( $message[ 'type' ] ) {
      
        case \Model\Messages::MESSAGE_TYPE_INVITE_PLAYER_REQUEST:
          $messages_out_arr[ $i ][ 'type' ] = 'Invitation to Join Clan';
          break;

        // do not show invite reponses in sent messages list if you are sender 
        case \Model\Messages::MESSAGE_TYPE_JOIN_CLAN_RESPONSE:
          if( $player->player_id == $message[ 'from_player_id' ] ) {
            unset( $messages_out_arr[ $i ] );
            $continue_foreach = true;
          }
          break;

        
        default:
          $messages_out_arr[ $i ][ 'type' ] = 'Unknown Message Type';
      }
      
      // HACK! see note above
      if( $continue_foreach ) {
        continue;
      }
      
      // actions html for row
      
      $action_html_view = '<a href="/component/_message_details?message_id='. $message[ 'message_id' ] .'" class="btn  btn-small" data-message-action="view">View</a>';

      $action_html_delete = '<a href="/component/_messages_list?action=delete&message_id='. $message[ 'message_id' ] .'" class="btn btn-small" data-message-action="delete">Delete</a>';
      
      $messages_out_arr[ $i ][ 'actions' ] = "$action_html_view $action_html_delete";
      
    }
  
    // TODO: get real outbox messages
    $f3->set( 'outbox_messages', $messages_out_arr );   
  
  }
  
  private function deleteMessageRequest( $f3 ) {
  
    $player = $f3->get( 'logged_in_player' );
    
    if( !$player ) {
      die( __CLASS__.'::'.__FUNCTION__.'('.__LINE__.'): no player logged in' );
    }    
    
    // check required param present, validate it
    $message_id = $f3->get( 'POST.message_id' );
    
    if( is_null( $message_id ) || !is_numeric(  $message_id ) || intval(  $message_id ) < 1 ) {
      die( __CLASS__.'::'.__FUNCTION__.'('.__LINE__.'): param error' );
    } 
    
    $message_id = intval(  $message_id );
    
    // check message exists and is owned by the logged in player
    $messages = new \Model\Messages( $f3->get( 'DB_CLANS') );

    $messages->load( array( ' message_id = ? AND ( to_player_id = ? OR from_player_id = ? ) ', $message_id, $player->player_id, $player->player_id ) );
    
    if( $messages->dry() ) {
      die( __CLASS__.'::'.__FUNCTION__.'('.__LINE__.'): shenanigans!' );
    }
    else {
      $messages->status = \Model\Messages::MESSAGE_STATUS_CLEARED;
      $messages->save();
    }
    
  }
  
  
  private function acceptSupplicantRequest( $f3 ) {

    $player = $f3->get( 'logged_in_player' );
    
    if( !$player ) {
      die( __CLASS__.'::'.__FUNCTION__.'('.__LINE__.'): no player logged in' );
    }
  
    // check required params are present (message_id is enough, player and clan ids can be lookup up from message)
    $message_id = $f3->get( 'POST.message_id' );
    
    if( is_null( $message_id ) || !is_numeric(  $message_id ) || intval(  $message_id ) < 1 ) {
      die( __CLASS__.'::'.__FUNCTION__.'('.__LINE__.'): param error' );
    }
    
    // get supplicant playerid, clan leader id, clan id from message record
    $request_message = new \Model\Messages( $f3->get( 'DB_CLANS') );

    $request_message->load( array( ' message_id = ? AND status = ? ', $message_id, \Model\Messages::MESSAGE_STATUS_ACTIVE )  );
    
    if( $request_message->dry() ) {
      die( __CLASS__.'::'.__FUNCTION__.'('.__LINE__.'): message not found' );
    } 

    
    // validate constraints/permissions: player exists and is active
    $supplicant_player = new \Model\Players_List( $f3->get( 'DB_CLANS') );
    
    $supplicant_player->load( array( ' player_id = ? and status = ?', $request_message->from_player_id, \Model\Players_List::PLAYER_STATUS_ACTIVE ) );
    
    if( $supplicant_player->dry() ) {
      die( __CLASS__.'::'.__FUNCTION__.'('.__LINE__.'): player not found or inactive' );
    } 
    
    // validate constraints/permissions: clan leader / clan exists
    $clan_leader = new \Model\Clan_Leader( $f3->get( 'DB_CLANS') );
    
    $clan_leader->load( array( 'player_id = ?', $request_message->to_player_id ) );
    
    if( $clan_leader->dry() ) {
      die( __CLASS__.'::'.__FUNCTION__.'('.__LINE__.'): clan leader not found' );
    }
    
    // validate constraints/permissions: clan exists and is active
    $clan = new \Model\Clans_List( $f3->get( 'DB_CLANS') );
    
    $clan->load( array( 'clan_id = ? and status = ?', $clan_leader->clan_id , \Model\Clans_List::CLAN_STATUS_ACTIVE) );
    
    if( $clan_leader->dry() ) {
      die( __CLASS__.'::'.__FUNCTION__.'('.__LINE__.'): clan not found or inactive' );
    }  
    
    
    // remove existing clan leadership (if exists)
    $clan_leader->reset();
    $clan_leader->remove_leadership_from_player( $supplicant_player->player_id );
    
    // change supplicant's clan membership
    $clan_membership = new \Model\Clan_Member( $f3->get( 'DB_CLANS') );
    $clan_membership->player_join_clan( $supplicant_player->player_id, $clan->clan_id );
    
   
    // send response message to supplicant
    $response_message = new \Model\Messages( $f3->get( 'DB_CLANS') );
    
    $response_message->create(
      $request_message->to_player_id,                     // param $fromPlayerID, set to recipient of original request message
      $request_message->from_player_id,                   // param $toPlayerID, set to sender of original request message
      \Model\Messages::MESSAGE_STATUS_ACTIVE,             // $status
      \Model\Messages::MESSAGE_TYPE_JOIN_CLAN_RESPONSE,   // $type
      "'Your request to join the '{$clan->clan_name}' has been successful. Welcome!"
    );
    
    // remove request message
    $request_message->status = \Model\Messages::MESSAGE_STATUS_CLEARED;
    $request_message->save();
    
  
  }
}
