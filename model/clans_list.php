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

	if(strlen($newClanName) < 8) {
		$errors[] = 'Minimum 4 characters!';
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
	
  }
    
}
