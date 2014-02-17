<?php

namespace App;

class Controller {

  // hold current db
  protected $db;
  protected $player_id = -1;

  function getClanId($f3) {
    $player  = $f3->get('logged_in_player');
    $result  = $f3->get( 'DB_CLANS' )->exec('SELECT clan_id FROM clan_members WHERE player_id = ?', $player->player_id);
    return (count($result) == 0) ? -1 : $result[0]['clan_id'];
  }

	function beforeroute( $f3 ) {
    
    // logged in status
    $username = $f3->get( 'SESSION.logged_in_username' );
    
   
    
    if( $username ) {
    
      // if request is for a logged in user, check that we are on a secure HTTPS connection
      if(FALSE /* empty( $_SERVER[ 'HTTPS' ] ) || $_SERVER[ 'HTTPS' ] !== 'on' */) {
      
        // not secure, clear session, return to home page
        $f3->clear( 'SESSION' );
        $f3->reroute( 'http://' . $f3->get( 'HOST' ) . $f3->get( 'BASE' ) );
      }    
    
      $f3->set('logged_in_username', $username);
      
      $player = new \Model\Players_List( $f3->get( 'DB_CLANS' ) );
      $player->load( array( 'player_id = ?', $f3->get( 'SESSION.logged_in_player_id') ) );
      
      if( $player->dry() ) {
        $f3->clear( 'SESSION' );
        die( 'player record not found even though supposed to be logged in' );
      }
      $f3->set('logged_in_player', $player);
      $this->player_id = $player->player_id;
    }
    
    // login URL as a param
    $f3->set( 'login_url', 'http://' . $f3->get( 'HOST' ) . $f3->get( 'BASE' ) . '/login' );
    
    // setup menu items
    $nav_menu = array();
    $nav_menu['home']         = array( 'text_name' => 'Home / News' );
    $nav_menu['clans_list']   = array( 'text_name' => 'Clans List' );
    $nav_menu['players_list'] = array( 'text_name' => 'Players List' );
    
    if( $username ) // show for logged in users only
    {
      $nav_menu['my_clan']      = array( 'text_name' => 'My Clan' );
      $nav_menu['create_clan']  = array( 'text_name' => 'Create Clan' );
	  $nav_menu['notifications']  = array( 'text_name' => 'Notifications' );
    }
    
    $f3->set( 'nav_menu', $nav_menu );
    // set global values
    $this->db = $f3->get( 'DB_CLANS' );
	}

	function afterroute() {

    $f3 = \Base::instance();
    
    // default to the home/news template if none specifically set
    if( !$f3->get( 'main_content_template' ) ) {
      $f3->set( 'main_content_template', '_home_news.htm' );
      $f3->set( 'selected_page', 'home' ); 
    }
	
		$template=new \Template;
	  echo $template->render( 'layout.htm' );		
	}

}

class Map {

	function get() {
	}

	function post() {
	}

}
