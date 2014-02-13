<?php

/**

Clan Details page component

**/

namespace App\Component;

class _Invite_Player extends \App\Controller {
    
    function get($f3, $f3_request_info = null) {
		$inv_player = $f3->get('GET.player');
		
		$player = $f3->get( 'logged_in_player' );	
		$f3->get( 'DB_CLANS' );
		
		$db = $f3->get( 'DB_CLANS' );
    
		$result = $db->exec( 'SELECT clan_id FROM clan_members WHERE player_id = ?', $player->player_id);	
		$clan_id = $result[0]['clan_id'];
		
		$clan_member = new \Model\Clan_Invites($db);
		$clan_member->addInvite($inv_player, $clan_id, \Model\Clan_Invites::INVITE_LEADER_REQUEST);

        die();
    }
    
}