<?php

namespace App;

class My_Clan extends Controller {

  function get( $f3 ) {

    $player = null;
    $clan = null;
    
    if( $this->_my_clan_setup( $f3, $player, $clan ) === FALSE)
    {
      return;
    }
    
    $f3->set('clan', $clan);

    // messages list page component
    $_messages_list = new \App\Component\_Messages_List();
    
    $_messages_list->get( $f3 );
 
    // clan details page component
    $_clan_details = new \App\Component\_Clan_Details();
    
    $_clan_details->get( $f3 );
    
    
    // set so nav menu shows correct selected item
    $f3->set( 'selected_page', 'my_clan' );

    // page content
    $f3->set('main_content_template', '_my_clan.htm');  
    

    
    $this->get_clan_members_list_data( $f3, $clan['clan_id'] );
    
  }
  
  
  private function _my_clan_setup( $f3, &$player, &$clan ) {
  
    // check user is logged in 
    if( !$f3->get( 'logged_in_username' ) )
    {
      $this->setup_template_access_error( $f3, 'You must be logged in to access this page' );
      return false;
    }

    // check player has record and is active
    $player = $f3->get( 'logged_in_player' );
    
    if( $player->dry() ) {
    
      $this->setup_template_access_error( $f3, 'Player record not found' );
      return false;
    }
    else if( $player->status <> \Model\Players_List::PLAYER_STATUS_ACTIVE ) {
    
      $this->setup_template_access_error( $f3, 'Your account is not active in the Clans Management Application' );
      return false;
    }
    
    $clan_member = new \Model\Clan_Member( $f3->get( 'DB_CLANS' ) );
    
    $clan_id = $clan_member->get_clan_membership( $player->player_id );
    
    if( $clan_id === false ) {
    
      $this->setup_template_access_error( $f3, 'You are not a member of any clan' );
      return false;
    }
    
    $clan = new \Model\Clans_List( $f3->get( 'DB_CLANS' ) );
    
    $clan->load( array ( 'clan_id = ?', $clan_id ) );
    
    if( $clan->dry() ) {
    
      $this->setup_template_access_error( $f3, 'Clan record not found' );
      return false;     
    } 
    else if( $clan->status <> \Model\Clans_List::CLAN_STATUS_ACTIVE ) {
    
      $this->setup_template_access_error( $f3, 'Your Clan is not active' );
      return false;      
    }
    
    return true;
  
  }
  
  private function setup_template_access_error( $f3, $msg ) {
  
    $f3->set( 'my_clan_error_message', $msg );

     // set to nav menu shows correct selected item
    $f3->set( 'selected_page', 'create_clan' );

    // page content
    $f3->set('main_content_template', '_my_clan_access_error.htm'); 
    
  }
  
  
  private function get_clan_members_list_data( $f3, $clan_id ) {

    $clan_members_list_view_mapper = new \DB\SQL\Mapper( $f3->get( 'DB_CLANS' ), 'Clan_Members_List_View' );
    
    $clan_members_list_view_mapper_arr = $clan_members_list_view_mapper->find( array( 'clan_id = ?', $clan_id ) ); 
    
	  $f3->set( 'clan_members_list_view_mapper_arr', $clan_members_list_view_mapper_arr );

    $f3->set('clan_members_list_template', '_clan_members_list.htm'); 

  }
  

}