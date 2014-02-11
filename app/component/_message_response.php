<?php

/**

Message Response ajax component

**/

namespace App\Component;

class _Message_Response extends \App\Controller {

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
    
    $message_arr = $messages->get_message_detail_for_response( $message_id );
    
    if( count($message_arr) ) {
    
      $orig_message = $message_arr[0];
      
      $response[ 'to_player_id' ] = $orig_message[ 'from_player_id' ];
      $response[ 'to_name' ] = $orig_message[ 'from_name' ];

      // response type and prefilled body depend on the request type
      switch( $orig_message[ 'type' ] ) {
      
        case \Model\Messages::MESSAGE_TYPE_JOIN_CLAN_REQUEST:
          $response[ 'type' ] = \Model\Messages::MESSAGE_TYPE_JOIN_CLAN_RESPONSE;
          $response[ 'body' ] = "Thank you, but I will not accept your invitation to join your clan '' at this time.\n";
          break;
        
        default:
          break;
      
      }
      
      $f3->set( 'response', $response );

    }  
    else {
      die(__CLASS__.'::'.__FUNCTION__.': message not found' );  
    }
    
    
    // 2nd param of GET is populated by routing mapper, thus is populated if request from external, not an internal call
    if( $f3_request_info ) { 
      // component called as AJAX    
  		$template=new \Template;
  	  echo $template->render( '_message_response.htm' );
  	  die();
    }
    else
    {
      // component called internally
      die(__CLASS__.'::'.__FUNCTION__.': component should not be called internally');
    }
  }
  
  
  function post( $f3 ) {
  
    // check player is logged in and get player record
    $player = $f3->get( 'logged_in_player' );
    
    if( !$player ) {
      die(__CLASS__.'::'.__FUNCTION__.': no player logged in' );
    }
    
    // validate POST data
    $errors = array();
    $sanitized_fields = array();

    if( $this->validate_and_clean_params( $f3, 'POST', $errors, $sanitized_fields ) == false ) {   
      die(__CLASS__.'::'.__FUNCTION__.': invalid response message parameters');
    }
    
    // create new message
    FIX ME HERE!
    
    
    // redirect to myclans page
    
  }
  
  private function validate_and_clean_params( $f3, $request_method, &$errors, &$sanitized_fields ) {

    $validator = new \Helper\Validation;

    if( $request_method == 'GET' ) {

      $rules_array = array(
      
      );
    
       $validator->addSource( $f3->get( 'GET' ) );
    } 
    else if( $request_method == 'POST' ) {
    
      $rules_array = array(
      
        'to_player_id'            => array( 'type' => 'numeric', 'required' => true, 'min' => 1, 'max' => PHP_INT_MAX  ),   
        'type'                    => array( 'type' => 'numeric', 'required' => true, 'min' => 1, 'max' => PHP_INT_MAX  ),
        'response_message_body'   => array( 'type' => 'string', 'required' => false, 'min' => 1, 'max' => 960, 'trim' => true  ),
      
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
  
}
