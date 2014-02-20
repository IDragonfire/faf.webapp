<?php

/**

Clan Details page component

**/

namespace App\Component;

class _Invite_Player extends \App\Controller {

	function get($f3, $f3_request_info = null) {
		$inv_player = $f3->get('GET.player');
		if($inv_player <= 0) {
			echo 'not a valid player';
		}
		
		$db = $f3->get( 'DB_CLANS' );

		// if player has no permission
		$perm = new \Model\Permission($db);
		if(!$perm->hasPerm($this->player_id, \Model\Permission::MY_CLAN_INVITE_PLAYER)) {
			echo 'no perm';
			die();
		}

		$clan_id = $this->getClanId($f3);
		
		$clan_member = new \Model\Clan_Invites($db);
		$clan_member->addInvite($inv_player, $clan_id, \Model\Clan_Invites::INVITE_LEADER_REQUEST);

		die();
	}

}