<?php

namespace App;

class Home extends Controller {

	function get($f3) {

    // set nav menu to show correct selected item
    $f3->set( 'selected_page', 'home' );

    // page content
    $f3->set('main_content_template', 'home_news.htm'); 

	}

	function post( $f3 ) {

    $this->get( $f3 );
		
	}


}