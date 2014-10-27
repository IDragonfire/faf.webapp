<?php

namespace App;
include 'parsedown.php';

class Votes_List extends Controller {

	function get($f3) {
        // set to nav menu shows correct selected item
        $f3->set( 'selected_page', 'vote' );

        $player = $f3->get( 'logged_in_player' );    

        if( !$player ) {
            $this->template_error($f3, 'Please log in'); 
            return;
        }
        $current_player_id = $f3->get( 'logged_in_player' )->player_id;
        $list_mapper =  $f3->get( 'DB_CLANS' )->exec( 
            'SELECT * FROM fafclans.votes l LEFT JOIN vote_user v ON l.id = v.vote_id AND v.user_id = ? WHERE vote_id is NULL;',
            $current_player_id);

        $f3->set( 'list_arr', $list_mapper );

        // page content
        $f3->set('main_content_template', 'votes_list.htm'); 

    }

    private function template_error( $f3, $msg ) {

        $f3->set( 'error', $msg );
        // page content
        $f3->set('main_content_template', '_error.htm'); 

    }
}