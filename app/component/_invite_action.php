<?php
namespace App\Component;

class _Invite_Action extends \App\Controller {
    
    function get($f3, $f3_request_info = null) {
		$clan_id = $f3->get( 'GET.clan' );
        if (!$clan_id) {
            die();
        }
		$player_id = $f3->get('logged_in_player')->player_id;
        
		$action = $f3->get( 'GET.action' );
		$db = $f3->get('DB_CLANS');
		
		if($action == 'accept') {
			$mapper = new \Model\Clan_Member($db);
			$mapper->player_join_clan($player_id, $clan_id);
		}
		$mapper = new \Model\Clan_Invites($db);
		$result = $mapper->load(array(
            'clan_id = ? AND player_id = ?',
            $clan_id, $player_id
        ));
		$result->erase();
		if($action == 'accept') {
			$f3->reroute('/my_clan');
		} else {
			$f3->reroute('/notifications');
		}
    }
}