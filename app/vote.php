<?php

namespace App;
include 'parsedown.php';

class Vote extends Controller {

	function get($f3) {
        // set to nav menu shows correct selected item
        $f3->set( 'selected_page', 'vote' );

        $player = $f3->get( 'logged_in_player' );    

        if( !$player ) {
            $this->template_error($f3, 'Please log in'); 
            return;
        }


        $db = $f3->get( 'DB_CLANS' );
        $votes = new \Model\Votes( $db );
        $vote = $votes->load('close IS NULL', array('order' => 'start DESC'));

        $parser = new \Parsedown();
        $f3->set('vote_text',  $parser->text($vote->text));

        $option_table = new \Model\Vote_Option( $db );
        $voptions = $option_table->getFormattedOptions($vote->id, $parser);
        $f3->set('vote_options',  $voptions);


	   // page content
        $f3->set('main_content_template', 'vote.htm'); 

    }

    private function template_error( $f3, $msg ) {

        $f3->set( 'error', $msg );
        // page content
        $f3->set('main_content_template', '_error.htm'); 

    }
}