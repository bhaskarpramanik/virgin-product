<?php
/**
 * Description of IndexComponent
 *
 * @author Animus Inc.
 */

// Restrict Unrestricted Access

defined("_dispatch") or	die("Access Denied !");
// Imports
require_once APICORE.'/AnimusComponentImpl.php';

class IndexComponent extends AnimusComponentImpl{
    public function service(){
        // Assuming everything went well. Sending a success message
        $this->setSuccessHttpResponse();
        return true;
    }
}
?>
