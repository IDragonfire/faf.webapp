<?php

namespace App;

class Vote extends Controller {

	function get($f3) {

    $player =  $f3->get( 'logged_in_player' );    
    
    if( $player ) {
    
      $clan_members = new \Model\Clan_Member( $f3->get( 'DB_CLANS' ) );
      
      $players_clan_id = $clan_members->get_clan_membership( $player->player_id );
      
    } else {
    
      $players_clan_id = null;
    }


    // set to nav menu shows correct selected item
    $f3->set( 'selected_page', 'vote' );

    $db = $f3->get( 'DB_CLANS' );
    
	
	  // page content
    $f3->set('main_content_template', '_vote.htm'); 
	
	}
}