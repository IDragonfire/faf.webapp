<?php
namespace App\Component;

class _Membership_Request extends \App\Controller {
    
    function get($f3, $f3_request_info = null) {
        
        $db = $f3->get('DB_CLANS');
        
        $clan_id = $this->getClanId($f3);

        if (!$clan_id) {
            die();
        }
        
        $mapper = new \DB\SQL\Mapper($db, 'membership_request_page_view');
        $result = $mapper->find(array(
            ' clan_id = ? ',
            $clan_id
        ));
        $f3->set('membership_requests', $result);
        
        if ($f3_request_info) {
            // component called as AJAX    
            $template = new \Template();
            echo $template->render('_membership_request.htm');
            die();
        } else {
            // component called internally
            $f3->set('membership_request_template', '_membership_request.htm');
        }
    }
}