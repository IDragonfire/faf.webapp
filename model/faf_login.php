<?php

namespace Model;

class FAF_Login {

    // Instantiate mapper
    function __construct( \DB\SQL $db ) {
       $this->db = $db;
    }

    // Specialized query
    function authenticate_user( $username, $password ) {
    
    	$user = $this->db->exec(
    	    'SELECT id, login, password, email, validated FROM login WHERE login=?',
    	    $username
    	);
    	
    	if( $this->db->count() <> 1 ) 
    	{
    		_log( 'Username not found in faf.login table' );
    		return false;
    	}
    	
    	_log( print_r( $user ,true ) );
    	if( strcmp( $this->FAF_pw_hash( $password ), $user[0]['password'] ) )
    	{
    		_log( 'hashed password does not match password field in faf.login table' );	
    		return false;
    	}    	
        $this->id = $user[0]['id'];
    	return true;
    }
    
    private function FAF_pw_hash( $cleartext_pw )
    {
    	return hash('sha256', $cleartext_pw);
    }

}
