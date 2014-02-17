<?php

namespace Model;

class FAF_Login extends \DB\SQL\Mapper {

    // Instantiate mapper
    function __construct( \DB\SQL $db ) {
    
        // This is where the mapper and DB structure synchronization occurs
        parent::__construct( $db,'faf_lobby_login_view' );
    }

    // Specialized query
    function authenticate_user( $username, $password ) {
    
    	$this->load(array('login=?', $username));
    	
    	if( $this->dry() ) {
    		_log( 'Username not found in faf.login table' );
    		return false;
    	}
    	
    	_log( print_r( $this->login ,true ) );
    	
    	if( strcmp( $this->FAF_pw_hash( $password ), $this->password ) )
    	{
    		_log( 'hashed password does not match password field in faf.login table' );	
    		return false;
    	}
    	
    	$this->load( array( 'login = ?', $username ) );
    	
    	return true;
    }
    
    private function FAF_pw_hash( $cleartext_pw ) {
    	return hash('sha256', $cleartext_pw);
    }
    
    public function load_user( $username )
    {
    	$this->load( array( 'login = ?', $username ) );
    }

}
