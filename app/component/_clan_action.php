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
			// if we try to edit ourself
			if($player_id == $f3->get( 'logged_in_player' )->player_id) {
				echo 'you cannot edit yourself';
				die();
			}
			# TODO: check if player exists
			# TODO: check permission of initiator
			$clan_members = new \Model\Clan_Member( $f3->get( 'DB_CLANS' ) );
			$clan_members->leaveClan($player_id);
			$f3->reroute('/my_clan');
		}
		die();
    }
    
}