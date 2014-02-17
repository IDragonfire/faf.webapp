<?php

namespace Model;

class Clan_Invites extends \DB\SQL\Mapper {

    const INVITE_USER_REQUEST = 1;
    const INVITE_LEADER_REQUEST = 0;
    
    // Instantiate mapper
    function __construct(\DB\SQL $db) {
        // This is where the mapper and DB structure synchronization occurs
        parent::__construct($db, 'clan_invites');
    }
    
    function get_invitations($player_id) {
        // find invites
        return $this->find(array(
            ' player_id = ? ',
            $player_id
        ));       
    }
	
	function addInvite($player_id, $clan_id, $mode = self::INVITE_USER_REQUEST) {
        if($player_id < 0) {
            return FALSE;
        }
        // check if clan exists
        $clans = new \Model\Clans_List($this->db);
        $clans->load(array('clan_id = ?', $clan_id));
        if($clans->dry()) {
            return False;
        }
		$this->player_id = $player_id;
		$this->clan_id = $clan_id;
		$this->user_request = $mode;
		$this->save();
	}
}
