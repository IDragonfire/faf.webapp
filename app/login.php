<?php

/*
 *	login.php	Login controller 
 */

namespace App;

class Login extends Controller {

  function get( $f3 ) {
    
    // GET request for login not allowed,  run the "home" page in response
    $home = new \App\Home();
    $home->get($f3);
  
  }
  
  function post( $f3 ) {

    // login attempts must be made over HTTPS  
    if( FALSE /* empty( $_SERVER[ 'HTTPS' ] ) || $_SERVER[ 'HTTPS' ] !== 'on' */) {
    
      // not secure, return with error
      $f3->set( 'login_error_message', 'Secure login only' );
      return;
		}
    
    // check for required parameters
		if( ( $f3->get( 'POST.username' ) === NULL ) ||  $f3->get( 'POST.password' ) === NULL )	{

			// login failed, params missing
			$f3->set( 'login_error_message', 'Please enter both username and password' );
			return;
		}

    // Authenticate against the database via the FAF_Login helper class
		$username = $f3->get( 'POST.username' );
		$password = $f3->get( 'POST.password' );
			
		$db_faf = $f3->get('DB_FAF');
		
		$faf_login = new \Model\FAF_Login( $db_faf );
		
		if( $faf_login->authenticate_user( $username, $password ) )	{
			
			// authentication successful
			
			// retrieve the FAF ID which is unchanging, even if username changes
			$faf_id = $faf_login->id;
			
			// check if player exists in the Clans DB and update if found or create if new
			$player = new \Model\Players_List( $f3->get('DB_CLANS') );
			
			$player->updateOrCreate( $faf_id, $username );
			
			// only allow "active" players to login
			if( $player->status !== \Model\Players_List::PLAYER_STATUS_ACTIVE )
			{
  			$f3->set( 'login_error_message', 'Player account is not active in FAF Clans Management App' );
  			return;			
			}

      // all login checks succeded, set token which indicates active login
			$f3->set( 'SESSION.logged_in_username', $username );
			$f3->set( 'SESSION.logged_in_player_id', $player->player_id );
			
			// 303 redirect to app home page on the secure connection
			$f3->reroute( 'http://' . $f3->get( 'HOST' ) . $f3->get( 'BASE' ) );
			
		}	else {
		
		  // authentication failed
			$f3->set( 'login_error_message', 'Username and password could not be verified' );
			return;		
		}		
    
  }
  
}