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
		
		$player_list = new \Model\Players_List( $f3->get( 'DB_CLANS' ) );
		$players = $player_list->find( array( "player_name LIKE concat('%',?,'%')", $player) ); 
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