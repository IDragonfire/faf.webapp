<?php

/**
Clan Page
**/

namespace App;

class Clan extends Controller {
    
    function get($f3) {
        $clan_id = $f3->get('PARAMS.clanid');
        // check if clan exists
        $clans = new \Model\Clans_List($this->db);
        $clans->load(array('clan_id = ?', $clan_id));
        if($clans->dry()) {
            $f3->reroute('/clans_list');
        }

        // set to nav menu shows correct selected item
        $f3->set( 'selected_page', 'clans_list' );

        // clan details page component
        $f3->set( 'GET.clan_id', $clan_id );
        $_clan_details = new \App\Component\_Clan_Details();
        $_clan_details->get( $f3 );
        $f3->set( 'GET.clan_id', NULL );

        $members = new \DB\SQL\Mapper( $this->db, 'clan_members_list_view' );
        $result = $members->find( array( 'clan_id = ?', $clan_id ) ); 
        $f3->set('clan_members_list_view_mapper_arr', $result );
        $f3->set('clan_members_list_template', 'clan_members_list_public.htm');
        // page content
        $f3->set('main_content_template', 'clan.htm');  
    }
}
