<?php

/**

Messages details ajax component

**/

namespace App\Component;

class _Message_Details extends \App\Controller {

  function get( $f3, $f3_request_info = null ) {
  
    $player = $f3->get( 'logged_in_player' );
    
    if( !$player ) {
      die(__CLASS__.'::'.__FUNCTION__.': no player logged in' );
    }
    
    $message_id = $f3->get( 'GET.message_id' );
    
    if( ! $message_id ) {
      die(__CLASS__.'::'.__FUNCTION__.': no message_id supplied' );    
    }
    
    if( !is_string( $message_id ) || strlen( $message_id ) == 0 || intval( $message_id ) <= 0 ) {
      die(__CLASS__.'::'.__FUNCTION__.': invalid message_id supplied' );  
    }
    
    $message_id = intval( $message_id );
    
    $messages = new \Model\Messages( $f3->get( 'DB_CLANS') );
    
    $message_arr = $messages->get_message_detail_for_display( $message_id );
    
    if( count($message_arr) ) {
    
      $message = $message_arr[0];
      
      $message_content = 
        'From: '. $message[ 'from_name' ] .'<br>'.
        'Date: '. $message[ 'date' ] .'<br>'.
        '<br>'.
        '<p>'. $message[ 'body' ] .'</p>';
      
      switch( $message[ 'type' ] ) {
      
        case \Model\Messages::MESSAGE_TYPE_JOIN_CLAN_REQUEST:
          $message_actions  = '<a href="/component/_messages_list?action=accept&message_id='. $message_id .'" class="btn" data-modal-message-action="Accept">Accept Join Request</a> ';
          $message_actions .= '<a href="/component/_message_response?action=refuse&message_id='. $message_id .'" class="btn" data-modal-message-action="Refuse">Refuse Join Request</a> ';
          break;
        
        default:
          $message_actions = '[Delete Message]';
      
      }
      
      $message_detail[ 'content' ] = $message_content;
      $message_detail[ 'actions' ] = $message_actions; 
      
      $f3->set( 'message_detail', $message_detail );

    }  
    else {
      die(__CLASS__.'::'.__FUNCTION__.': message not found' );  
    }
    
    
    // 2nd param of GET is populated by routing mapper, thus is populated if request from external, not an internal call
    if( $f3_request_info ) { 
      // component called as AJAX    
  		$template=new \Template;
  	  echo $template->render( '_message_details.htm' );
  	  die();
    }
    else
    {
      // component called internally
      die(__CLASS__.'::'.__FUNCTION__.': component should not be called internally');
    }
  }
  
}
