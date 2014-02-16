<?php

/**

Clan Details page component

**/

namespace App\Component;

class _Delete_Clan extends \App\Controller {
    
    function get($f3, $f3_request_info = null) {
    	$player = $f3->get( 'logged_in_player' );
    	$db = $f3->get( 'DB_CLANS' );

    	// if not in a clan
    	$clan_id = $this->getClanId($f3);
    	if($clan_id < 0) {
    		echo 'not in a clan';
    		die();
    	}

	    // if player has no permission
        $perm = new \Model\Permission($db);
        if(!$perm->hasPerm($player->player_id, \Model\Permission::MY_CLAN_CHANGE_LEADER)) {
            echo 'no perm';
            die();
        }
		 
		 $clan = new \Model\Clans_List( $f3->get( 'DB_CLANS' ) );
		 $clan->deleteClan($this->getClanId($f3));
		 $f3->reroute('/my_clan');
    }
    
}