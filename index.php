<?php

// perform some config that is not part of F3
require('app/base_config.php');

$f3=require('lib/base.php');

$f3->set('DEBUG',3);
$f3->set('UI','ui/');

/* setup common DB connection */
$db_faf = new \DB\SQL( 
	'mysql:host=localhost;dbname=faf',
	'fafclans',
	'fafclans' 
);
$f3->set('DB_FAF', $db_faf);

/* setup common DB connection */
$db_clans = new \DB\SQL( 
	'mysql:host=localhost;dbname=clans',
	'fafclans',
	'fafclans' 
);
$f3->set('DB_CLANS', $db_clans);

// "normal" routes
$f3->route('GET /logout',
    function( $f3 ) {
        $f3->clear( 'SESSION' );
        $f3->reroute( 'http://' . $f3->get('HOST').'/'.$f3->get('BASE') );
    }
);

// RESTful application controllers
$f3->map('/','App\Home');
$f3->map('/component/@controller','App\component\@controller');
$f3->map('/@controller','App\@controller');


$f3->run();

