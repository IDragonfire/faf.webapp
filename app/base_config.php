<?php

// use UTC timezone for all aspects of app
date_default_timezone_set("UTC");

// force session cookie name to be different to the standard PHP session name 
session_name('id');


// global log-to-apache-error-log function
function _log( $msg )
{
	list( , $caller ) = debug_backtrace( false );
	if( isset( $caller[ 'class' ] ) )
		$class = $caller[ 'class' ];
	else
		$class = 'Global';
	error_log( $class . '::' . $caller['function']. ' : '. $msg );
}

