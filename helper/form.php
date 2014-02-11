<?php

namespace Helper;

class Form {

  function errors_array_to_javascript( $form_name, $errors ) {
  
    $output = "<script type=\"text/javascript\">\n";
    
    foreach( $errors as $field_name => $error_msg) {
  
      // find the form input by name, store in temp var
      $output .= "var el = \$(\"form[name='{$form_name}'] input[name='{$field_name}']\");\n";
      
      // select its ancestor with class "control-group", add "error" to it classes
      $output .= "\$(el).closest('div.control-group').addClass('error');\n";
      
      // remove the sibling span element if present
      $output .= "\$(el).nextAll('span').remove();\n";
      
      // insert a new sibling span containing the error message
      $output .= "\$(el).after('<span class=\"help-inline\">{$error_msg}</span>');\n";
   
    }
    
     $output .= "</script>\n";
     
     return $output;
  }
  /*
    Expects an array of arrays with following structure, 
    where "field_name" is used as the input's name="XXX" attribute value
    
    array( 
      'field_name' => array(
        'id_prefix'   => '',
        'label'       => '',
        'placeholder' => '',
        'value'       => '',
        'help'        => '',
      )
    )
  
  */
  function generate_html_for_input_text( $field_data_array ) {
    
    _log( print_r( $field_data_array, true ) );
    
    $keys         = array_keys( $field_data_array );
    $field_name   = $keys[0];
    $id_prefix    = $field_data_array[ $field_name ][ 'id_prefix' ];
    $label        = $field_data_array[ $field_name ][ 'label' ];
    $placeholder  = $field_data_array[ $field_name ][ 'placeholder' ];
    $value        = $field_data_array[ $field_name ][ 'value' ];
    $help         = $field_data_array[ $field_name ][ 'help' ];
    
  
    $id = "{$id_prefix}_{$field_name}";
  
    $output    = "<div class=\"control-group\">\n";
    $output   .= "  <label class=\"control-label\" for=\"{$id}\">{$label}</label>\n";  
    $output   .= "  <div class=\"controls\">\n";
    $output   .= "    <input id=\"{$id}\" type=\"text\" name=\"{$field_name}\" placeholder=\"{$placeholder}\" value=\"{$value}\">\n";
    if( strlen( $help ) )
      $output .= "    <span class=\"help-inline\">{$help}</span>\n" ; 
    $output   .= "  </div>\n";
    $output   .= "</div>\n";
    
    return $output;
  }
  
}