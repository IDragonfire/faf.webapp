<?php

namespace App;

class DBConnTest extends Controller {

	function get($f3) {

		$db=new \DB\SQL( 
			'mysql:host=localhost;dbname=faf',
			'fafclans',
			'fafclans' 

		);

	
		$res = $db->exec(
			'SELECT * FROM login WHERE login=?;',
			'thebeej' 
		);


		$results[] = array(
			"status" => "xxx",
			"text" => "<pre>\n" . print_r( $res, true ) . "</pre>\n",
		);

		$res = $db->exec( 
			'SELECT * FROM login WHERE login=:username;',
			array( ':username' => 'thebeej' )
		);

		$results[] = array(
			"status" => "xxx",
			"text" => "<pre>\n" . print_r( $res, true ) . "</pre>\n",
		);


		$f3->set( 'results', $results );
	}

}
