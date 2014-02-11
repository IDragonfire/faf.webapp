<?php

namespace App;

class Players_List extends Controller {

	function get($f3) {

    // set to nav menu shows correct selected item
    $f3->set( 'selected_page', 'players_list' );

    $tbl_players_list = new \Model\Players_List( $f3->get( 'DB_CLANS' ) );
    
    $players_list_mapper_arr = $tbl_players_list->find( array( 'status = ?', \Model\Players_List::PLAYER_STATUS_ACTIVE ) ); 
    
	  $f3->set( 'players_list_arr', $players_list_mapper_arr );
	
	
	  // page content
    $f3->set('main_content_template', '_players_list.htm'); 
	
	
	
	}
}