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
		if($action == 'changeLeader') {
			$db = $f3->get( 'DB_CLANS' );
			$current_player_id = $f3->get( 'logged_in_player' )->player_id;
			// if player has no permission
	        $perm = new \Model\Permission($db);
	        if(!$perm->hasPerm($current_player_id, \Model\Permission::MY_CLAN_CHANGE_LEADER)) {
	            echo 'no perm';
	            die();
	        }
	        $clan_id = $this->getClanId($f3);
	        $new_leader = $f3->get( 'GET.player' );
	        // check if new leader is in the clan
	        $members = new \Model\Clan_Member($db);
	        if($clan_id !== $members->get_clan_membership($new_leader)) {
	        	echo 'new leader it not in this clan';
	        	die();
	        }
	        // check if you are the current leader
	        $leaders = new \Model\Clan_Leader($db);
	        if($clan_id !== $leaders->get_clan_leadership($current_player_id)) {
	        	echo 'you are not the leader';
	        	die();
	        }
	        $members->setRank($current_player_id, 'LAB');
	        $members->setRank($new_leader, 'ACU');
	        $leaders->remove_leadership_from_player($current_player_id);
	        $leaders->set_clan_leader($clan_id, $new_leader);

		}
		$f3->reroute('/my_clan');
    }
    
}