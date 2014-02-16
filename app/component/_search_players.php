<?php

/**

Clan Details page component

**/

namespace App\Component;

class _Search_Players extends \App\Controller {
    
    function get($f3, $f3_request_info = null) {
		$player = $f3->get('GET.term');
		if(count($player) < 1) {
			die();
		}


		$db = $f3->get( 'DB_CLANS' );
		$current_player_id = $f3->get( 'logged_in_player' )->player_id;

		// if player has no permission
        $perm = new \Model\Permission($db);
        if(!$perm->hasPerm($current_player_id, \Model\Permission::MY_CLAN_CHANGE_LEADER)) {
            echo 'no perm';
            die();
        }

		$clan_id = $this->getClanId($f3);

		$player_list = new \DB\SQL\Mapper($db, 'player_list_page_view');
		$players = $player_list->find( array( "clan_id != ? AND player_name LIKE concat('%',?,'%')", $clan_id,  $player) ); 
		$data = array();
		foreach($players as $p) {
			 $data[] = array('id' => $p->player_id, 'value' => $p->player_name, 'label' => $p->player_name);
		}
		
		$json = json_encode($data);
		print $json;
		die();
		
        if ($f3_request_info) {
            
            // component called as AJAX    
            $template = new \Template;
            echo $template->render('_invite_players.htm');
            die();
        } else {
            // component called internally
        }
        
    }
    
}