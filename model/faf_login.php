<?php

namespace Model;

class FAF_Login extends \DB\SQL\Mapper {

    // Instantiate mapper
    function __construct( \DB\SQL $db ) {
    
        // This is where the mapper and DB structure synchronization occurs
        parent::__construct( $db,'login' );
    }

    // Specialized query
    function authenticate_user( $username, $password ) {
    
    	$user = $this->db->exec(
    	    'SELECT * FROM login WHERE login=?',
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
    	
    	$this->load( array( 'login = ?', $username ) );
    	
    	return true;
    }
    
    private function FAF_pw_hash( $cleartext_pw )
    {
    	// needs details from Ze_Pilot
    	
    	return $cleartext_pw;
    
    }
    
    public function load_user( $username )
    {
    	$this->load( array( 'login = ?', $username ) );
    }

}
