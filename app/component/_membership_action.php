<?php
namespace App\Component;

class _Membership_Action extends \App\Controller {
    
    function get($f3, $f3_request_info = null) {
        
        $db = $f3->get('DB_CLANS');
        
        $player  = $f3->get('logged_in_player');
        $result  = $db->exec('SELECT clan_id FROM clan_members WHERE player_id = ?', $player->player_id);
        $clan_id = $result[0]['clan_id'];

        if (!$clan_id) {
            die();
        }
        
		$action = $f3->get( 'GET.action' );
		$player = $f3->get( 'GET.player' );
		
		if($action == 'accept') {
			$mapper = new \Model\Clan_Member($db);
			$mapper->player_join_clan($player, $clan_id);
		}
		$mapper = new \Model\Clan_Invites($db);
		$result = $mapper->load(array(
            'clan_id = ? AND player_id = ?',
            $clan_id, $player
        ));
		$result->erase();
        $f3->reroute('/my_clan');
    }
}