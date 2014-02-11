<?php

namespace App;

class Phpinfo extends Controller {

	function get($f3) {

		ob_start();
		phpinfo();
		$data = ob_get_contents();
		ob_clean();

		$phpinfo_body = substr( $data, strpos( $data, '<body>' ) + 6, strpos( $data, '</body>' ) - strpos( $data, '<body>' ) );
		
		$f3->set( 'results', $phpinfo_body );
	}

	// overrride parent
	function afterroute() {
		echo \View::instance()->render( 'phpinfo.htm' );
	}
}
