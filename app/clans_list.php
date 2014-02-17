<?php

namespace App;

class Clans_List extends Controller {

	function get($f3) {

    $player =  $f3->get( 'logged_in_player' );    
    
    if( $player ) {
    
      $clan_members = new \Model\Clan_Member( $f3->get( 'DB_CLANS' ) );
      
      $players_clan_id = $clan_members->get_clan_membership( $player->player_id );
      
    } else {
    
      $players_clan_id = null;
    }


    // set to nav menu shows correct selected item
    $f3->set( 'selected_page', 'clans_list' );

    $db = $f3->get( 'DB_CLANS' );
    
    $clans_list_page_view = $db->exec( 'SELECT * FROM clans_list_page_view');
	
	 // player is logged in but does not have a clan membership
	$playerCanJoin = $player && !$players_clan_id;
	
    // add action button HTML for each entry
	# TODO: resign/leave button?
    foreach( $clans_list_page_view as &$clan ) {

      $action_html = '<a href="component/_clan_details?clan_id='. $clan['clan_id'] .'" class="btn" data-toggle-extended="modal" data-modal-type="clan_details" >Details</a>';
      
      // player is logged in but does not have a clan membership
      if( $playerCanJoin ) {
        $action_html .= ' <a href="join_clan?clan_id='. $clan['clan_id'] .'" class="btn" data-toggle-extended="modal" data-modal-type="join_clan">Join</a>';
      }

      $clan['action'] = $action_html;

    }
    
	  $f3->set( 'clans_list_arr', $clans_list_page_view );
	
	  // page content
    $f3->set('main_content_template', '_clans_list.htm'); 
	
	}
}