<?php
namespace App\Component;

class Vote_Action extends \App\Controller {
    
    function get($f3, $f3_request_info = null) {
		$action = $f3->get( 'GET.action' );	
		if($action == 'vote') {
			$db = $f3->get( 'DB_CLANS' );
			// is logged in
			if($f3->get( 'logged_in_player' ) == null) {
				$f3->reroute('/votes_list');
				return;
			}
			$current_player_id = $f3->get( 'logged_in_player' )->player_id;
			$vote_id = $f3->get( 'GET.id' );	
			$option_id = $f3->get( 'GET.option' );	
			// if player already voted
	        $result = $f3->get( 'DB_CLANS' )->exec( 'SELECT * FROM vote_user WHERE vote_id = ? AND user_id = ? LIMIT 1',
	        										array(1=>$vote_id, 2=>$current_player_id));
	        if(count($result) > 0) {
	        	$f3->reroute('/votes_list');
				return;
	        }
	        $result = $f3->get( 'DB_CLANS' )->exec( 'INSERT INTO vote_user (vote_id, option_id, user_id) VALUES(?, ?, ?)',
	         										 array(1=>$vote_id, 2=>$option_id, 3=>$current_player_id));
		}
		$f3->reroute('/votes_list');
    }
    
}