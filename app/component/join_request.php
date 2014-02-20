<?php
namespace App\Component;

class Join_Request extends \App\Controller {
    
    function get($f3) {   
		$player = $f3->get('logged_in_player');
    	if($player->player_id < 0) {
    		echo 'you are not logged in';
    		die();
    	}
    	// if player is already into a clan
    	if($this->getClanId($f3) > 0) {
    		echo 'you are already in a clan';
    		die();
    	}
    	$clan_id = $f3->get('GET.clan_id');
        $invites = new \Model\Clan_Invites( $f3->get( 'DB_CLANS' ) );
		$invites->addInvite($player->player_id, $clan_id );
		$f3->reroute('/clan_' . $clan_id);
	}
}