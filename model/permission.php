<?php

namespace Model;

class Permission  extends \DB\SQL\Mapper {
	const MY_CLAN_REMOVE_MEMBER = 'my_clan_remove_member';
	const MY_CLAN_INVITE_PLAYER = 'my_clan_invite_member';
	const MY_CLAN_HANDLE_MEMBERSHIP_REQUEST = 'my_clan_handle_membership_request';
	const MY_CLAN_EDIT_DETAILS = 'my_clan_edit_details';

	// Instantiate mapper
	function __construct( \DB\SQL $db ) {
		// This is where the mapper and DB structure synchronization occurs
		parent::__construct( $db, 'clan_member');
	}
	
	function hasPerm($player_id, $perm) {
		return TRUE;
	}
}
