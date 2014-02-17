<?php

/**

Clan Details page component

**/

namespace App\Component;

class _Clan_Details extends \App\Controller {

  function get( $f3, $f3_request_info = null ) {
  
    $clan = $f3->get( 'clan' );
    
    if( !$f3->get( 'GET.clan_id' ) ) {
    
      $clan_id = $clan['clan_id'];
    }
    else {
    
      $clan_id = $f3->get( 'GET.clan_id' );
    }
    
    $clan_details_view = new \DB\SQL\Mapper( $f3->get( 'DB_CLANS'), 'clans_details_page_view' );
    
    $clan_details_view->load( array( ' clan_id = ? ', $clan_id ) );
    
    $clan_details_view_arr =  $clan_details_view->cast();
    
    // run direct sql to get clan members count then merge the result into the data array
    $result = $f3->get( 'DB_CLANS')->exec(
      'select count(*) as clan_member_active_total from clan_members CM join players_list PL on CM.player_id = PL.player_id '.
      'where CM.clan_id = ? and PL.status = '.\Model\Players_List::PLAYER_STATUS_ACTIVE,
      $clan_id
    );
 
    $clan_details_view_arr = array_merge( $clan_details_view_arr, $result[0] );
 
    $f3->set( 'clan_details', $clan_details_view_arr );
    
    
    // 2nd param of GET is populated by routing mapper, thus is populated if request from external, not an internal call

    if( $f3_request_info ) { 

      // component called as AJAX    
  		$template=new \Template;
  	  echo $template->render( '_clan_details.htm' );
  	  die();
    }
    else
    {
      // component called internally
      $f3->set( 'clan_details_component_template', '_clan_details.htm' );
    }
  
  }
  
}