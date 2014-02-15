<?php

/**

Clan Details page component

**/

namespace App\Component;

class _Clan_Action extends \App\Controller {
    
    function get($f3, $f3_request_info = null) {
		$action = $f3->get( 'GET.action' );	
		if($action == 'remove') {
			$player_id = $f3->get( 'GET.player' );
			$db = $f3->get( 'DB_CLANS' );
			$current_player_id = $f3->get( 'logged_in_player' )->player_id;
			// if we try to edit ourself
			if($player_id == $current_player_id) {
				echo 'you cannot edit yourself';
				die();
			}
			// if player has no permission
	        $perm = new \Model\Permission($db);
	        if(!$perm->hasPerm($current_player_id, \Model\Permission::MY_CLAN_REMOVE_MEMBER)) {
	            echo 'no perm';
	            die();
	        }
			$clan_members = new \Model\Clan_Member( $db );
			$clan_members->leaveClan($player_id);
			$f3->reroute('/my_clan');
		}
		die();
    }
    
}