<?php
namespace App\Component;

class _Edit_Action extends \App\Controller {
    
    function post($f3, $f3_request_info = null) {

   
    $pk = $f3->get( 'POST.pk');
    $name = $f3->get( 'POST.name');
    $value = $f3->get( 'POST.value');

	
	if($pk == 'clan_tag') {
		if(strlen($value) > 3) {
			header('HTTP 400 Bad Request', true, 400);
			echo "Max length is 3!";
			die();
		}
	}
    /*
     Check submitted value
    */
    if(!empty($value)) {
        /*
          If value is correct you process it (for example, save to db).
          In case of success your script should not return anything, standard HTTP response '200 OK' is enough.
          
          for example:
          $result = mysql_query('update users set '.mysql_escape_string($name).'="'.mysql_escape_string($value).'" where user_id = "'.mysql_escape_string($pk).'"');
        */
        
        //here, for debug reason we just return dump of $_POST, you will see result in browser console
        print_r($_POST);


    } else {
        /* 
        In case of incorrect value or error you should return HTTP status != 200. 
        Response body will be shown as error message in editable form.
        */

         header('HTTP 400 Bad Request', true, 400);
        echo "This field is required!";
		die();
    }
    }
}