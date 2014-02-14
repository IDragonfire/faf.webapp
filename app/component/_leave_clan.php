<?php

/**

Clan Details page component

**/

namespace App\Component;

class _Leave_Clan extends \App\Controller {
    
    function get($f3, $f3_request_info = null) {
		 $player = $f3->get( 'logged_in_player' );
		 $clan_members = new \Model\Clan_Member( $f3->get( 'DB_CLANS' ) );
		 $clan_members->leaveClan($player->player_id);
		 $f3->reroute('/my_clan');
    }
    
}