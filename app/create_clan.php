<?php

namespace App;

class Create_Clan extends Controller {

  // array key is used as the "field_name" (form input's "name" attribute )
  private $form_fields = array (
  
    'clan_name' => array (
      'id_prefix'   => 'create_clan',
      'label'       => 'Clan Name',
      'placeholder' => 'e.g. Unpleasant Company',
      'value'       => '',
      'help'        => 'Minimum 4 characters',
    ),

    'clan_tag' => array (
      'id_prefix'   => 'create_clan',
      'label'       => 'Clan Tag',
      'placeholder' => 'e.g. TMO',
      'value'       => '',
      'help'        => "Do not include surrounding square brackets,<br> maximum 3 characters",
    ),
    
  );

	function get( $f3 ) {

    // ------- common (GET/POST) template setup -------
    $this->_create_clans_template_setup( $f3 );

    // ------ GET specific template setup -------

    // 1. generate form fields HTML
    $form_helper = new \Helper\Form;
    $form_fields_html = '';
    for( $i = 0; $i < count( $this->form_fields ); $i++ ) {
      $form_fields_html .= "\n" . $form_helper->generate_html_for_input_text( array_slice( $this->form_fields, $i, 1 ) );
    }
    $f3->set( 'form_fields_html', $form_fields_html );

    // TODO: debugging infos
    $f3->set( 'errors', false );
    $f3->set( 'sanitized_fields', false );
    
	}

	function post( $f3 ) {

      $errors = array();
      $sanitized_fields = array();

    // validate form data
    $validated_ok = $this->validate_create_clan_request( $f3, $errors, $sanitized_fields );
    
    
        
    if( $validated_ok ) {

      // Validation succeeded, check insert allowed and do save if possible
      $save_ok = $this->check_and_save( $f3, $errors, $sanitized_fields );
    }

    
    if( $validated_ok == FALSE || $save_ok == FALSE )
    {
      // error occurred, redisplay template
      
      // ------common template setup----------
      $this->_create_clans_template_setup( $f3 );
      
      $this->redisplay_after_error( $f3, $errors, $sanitized_fields );
            
      // debugging infos TODO: remove
      $f3->set( 'errors', $errors );
      $f3->set( 'sanitized_fields', $sanitized_fields );
    }
    else
    {
      // successful, show success template
      $this->_create_clans_success_template_setup( $f3 );
    }

		
	}
	
	function check_and_save( $f3, &$errors, &$sanitized_fields ) {
	
	  // check if clan exists with same name or tag
	  $clan = new \DB\SQL\Mapper( $f3->get( 'DB_CLANS' ), 'clans_list' );
	  
	  // look for duplicate clan name
	  $clan->load( array( ' clan_name = ? ', $sanitized_fields['clan_name'] ) );
	  
	  if( !$clan->dry() ) {
	  
	    // error, field is duplicated
	    $errors['clan_name'] = 'A clan with that name already exists';
	  }
	  
	  // look for duplicate clan tag
	  $clan->load( array( ' clan_tag = ? ',  $sanitized_fields['clan_tag'] ) );
	  
	  if( !$clan->dry() ) {
	  
	    // error, field is duplicated
	    $errors['clan_tag'] = 'A clan with that tag already exists';
	  }	  
	  
	  if( count( $errors ) ) {
	  
	    return FALSE;
	  }
	  	  
	  // setup fields for new clans_list record
	  $clan->reset();
	  $clan->clan_name = $sanitized_fields['clan_name'];
	  $clan->clan_tag = $sanitized_fields['clan_tag'];
	  $clan->status = \Model\Clans_List::CLAN_STATUS_ACTIVE;
	  
	  // get the ID of the player founding the clan
	  $player = $f3->get( 'logged_in_player' );
	  
	  $clan->clan_founder_id = $player->player_id;
	  
	  $clan->save(); // object is auto reloaded by framework so autoincrement fields etc are populated
	  
	  // add player as clan member of new clan (removes any existing clan membership)
	  $clan_member = new \Model\Clan_Member( $f3->get( 'DB_CLANS' ));
	  $clan_member->player_join_clan( $player->player_id, $clan->clan_id, 'ACU' );
	  
	  // set player as leader of new clan (removes any existing leader role from player)	  	  
	  $clan_leader = new \Model\Clan_Leader( $f3->get( 'DB_CLANS' ) );
	  $clan_leader->set_clan_leader( $clan->clan_id, $player->player_id );
	  
	  return TRUE;
	}
	
	function redisplay_after_error( $f3, $errors, $sanitized_fields ) {
      // -------template variable setup specific to POST request ----------
      
      // 1. generate Javascript which will populate the error info into the form fields
      $form_helper = new \Helper\Form();
      $form_error_js = $form_helper->errors_array_to_javascript( 'Create_Clan', $errors );
      
      $f3->set( 'form_error_js', $form_error_js );


      // 2. generate form inputs HTML, including the POSTed data values, using sanitised value where available
      $form_fields_html = '';
      foreach( $this->form_fields as $field_name => $field_data_array_inner )
      {
        if( array_key_exists( $field_name, $sanitized_fields ) ) {
          $value = $sanitized_fields[ $field_name ];
        } 
        else {
          $value = $_POST[ $field_name ];
        }
        
        $field_data_array = array( $field_name => $field_data_array_inner);
        $field_data_array[ $field_name ][ 'value' ] = $value;
       
        $form_fields_html .= "\n" . $form_helper->generate_html_for_input_text( $field_data_array );
      }
      $f3->set( 'form_fields_html', $form_fields_html );    

	  
	}
	
	function _create_clans_template_setup( $f3 )
	{
    // set to nav menu shows correct selected item
    $f3->set( 'selected_page', 'create_clan' );

    // page content
    $f3->set('main_content_template', '_create_clan.htm'); 

    // check player is allowed to create a new clan
    $player = $f3->get( 'logged_in_player' );
    
    $clan_member = new \DB\SQL\Mapper(  $f3->get( 'DB_CLANS' ), 'clan_members' );
    
    $clan_member->load( array( 'player_id = ?', $player->player_id ) );
    
    if( !$clan_member->dry() ) // record found
    {
      $f3->set( 'allow_create_clan', false );
      $f3->set( 'disallowed_reason', 'You are already a member of an existing clan. You must resign from your current clan before you may create a new clan.' );
    }
    else
    {
      $f3->set( 'allow_create_clan', true );
    }	
	}

function _create_clans_success_template_setup( $f3 )
	{
    // set to nav menu shows correct selected item
    $f3->set( 'selected_page', 'create_clan' );

    // page content
    $f3->set('main_content_template', '_create_clan_success.htm'); 
  }

  function validate_create_clan_request( $f3, &$errors, &$sanitized_fields ) {
      
    $validator = new \Helper\Validation;
    
    $rules_array = array(
    
      'clan_name' => array( 'type' => 'string', 'required' => true, 'min' => 4, 'max' => 40, 'trim' => true ),
      'clan_tag'  => array( 'type' => 'string', 'required' => true, 'min' => 1, 'max' => 3, 'trim' => true ),
    
    );
    
    //_log("Post data:".print_r( $_POST,true));
    
    $validator->addSource( $f3->get( 'POST' ) );
    
    $validator->addRules( $rules_array );
    
    $validator->run();
    
    if(sizeof($validator->errors) > 0) {

      $errors = $validator->errors;
      $sanitized_fields = $validator->sanitized;
      return false;

    } else {

      $errors = array();
      $sanitized_fields = $validator->sanitized;     
      return true;

    }
  }

}