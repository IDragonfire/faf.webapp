<?php
namespace App\Component;

class _Edit_Action extends \App\Controller {
    
    function post($f3, $f3_request_info = null) {   
		$pk = $f3->get( 'POST.pk');
		$value = $f3->get( 'POST.value');
		
		$db = $f3->get( 'DB_CLANS');
		
		# TODO; check also on creation, make one unit
		if($pk == 'clan_tag') {
			if(strlen($value) > 3) {
				$this->error('Maximum 3 characters!');
			}
			$mapper = new \Model\Clans_List($db);
			$mapper->load( array( ' clan_id = ? ', $this->getClanId($f3) ) );
			$mapper->clan_tag = $value;
			$mapper->save();
			die();
		}
		# TODO: check also on creation, make one unit
		if($pk == 'clan_name') {
			if(strlen($value) < 4) {
				$this->error('Minimum 4 characters!');
			}
			$mapper = new \Model\Clans_List($db);
			$mapper->load( array( ' clan_id = ? ', $this->getClanId($f3) ) );
			$mapper->clan_name = $value;
			$mapper->save();
			die();
		}
		$this->error('invalid primary key');
    }
	
	function error($msg) {
		header('HTTP 400 Bad Request', true, 400);
		echo $msg;
		die();
	}
}