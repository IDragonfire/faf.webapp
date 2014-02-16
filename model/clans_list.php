<?php

namespace Model;

class Clans_List extends \DB\SQL\Mapper {

  const CLAN_STATUS_INACTIVE = 0;
  const CLAN_STATUS_ACTIVE = 1;

  // Instantiate mapper
  function __construct( \DB\SQL $db ) {
  
    // This is where the mapper and DB structure synchronization occurs
    parent::__construct( $db, 'clans_list ');
  }
  
  function checkClanName($newClanName) {
	$errors = array();

	if(strlen($newClanName) < 4) {
		$errors[] = 'Minimum 4 characters!';
	}

	if(strlen($newClanName) > 40) {
		$errors[] = 'Maximum 40 characters!';
	}

	if(!preg_match('/^[A-Za-z ]+$/', $newClanName)) {
		$errors[] = 'Only alphabet letters are allowed!';
	}

	// look for duplicate clan name
	$this->load( array( 'clan_name = ?', $newClanName));

	if( !$this->dry() ) {
		// error, field is duplicated
		$errors[] =  'A clan with that name already exists';
	}
	return $errors;
  }
  
  function checkClanTag($newClanTag) {
	$errors = array();

	if(strlen($newClanTag) > 3) {
		$errors[] = 'Maximum 3 characters!';
	}

	if(strlen($newClanTag) < 1) {
		$errors[] = 'Minimum 1 character!';
	}

	if(!preg_match('/^[A-Za-z]+$/', $newClanTag)) {
		$errors[] = 'Only alphabet letters are allowed!';
	}

	// look for duplicate clan name
	$this->load( array( 'clan_tag = ?', $newClanTag));

	if( !$this->dry() ) {
		// error, field is duplicated
		$errors[] =  'A clan with that tag already exists';
	}
	return $errors;
  }

  function deleteClan($clan_id) {
  	$db = $this->db;
  	$params = array('1' => $clan_id);
  	// delete all invites
  	$db->exec('DELETE FROM `clan_invites` WHERE `clan_id`= ?', $params);
  	// delete all members
  	$db->exec('DELETE FROM `clan_members` WHERE `clan_id`= ?', $params);
  	// delete all leaders
  	$db->exec('DELETE FROM `clan_leader` WHERE `clan_id`= ?', $params);
  	// delete clan
  	$db->exec('DELETE FROM `clans_list` WHERE `clan_id`= ?', $params);
  }
    
}
