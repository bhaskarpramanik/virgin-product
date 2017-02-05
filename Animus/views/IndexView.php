<?php
/**
 * Description of IndexView
 *
 * @author Animus Inc.
 */
// Restrict Unrestricted Access

defined("_dispatch") or	die("Access Denied !");

// Imports
require_once APICORE.'/AnimusViewImpl.php';

class IndexView extends AnimusViewImpl{
    public function __construct() {
        parent::__construct();
    }

    public function getHeaderByName($headerName) {
        parent::getHeaderByName($headerName);
    }

    public function getHeaders() {
        return parent::getHeaders();
    }

    public function getTemplate() {
        parent::getTemplate();
    }

    public function getViewData() {
        return parent::getViewData();
    }

    public function getViewDataByName($key) {
        return parent::getViewDataByName($key);
    }

    public function log($message) {
        parent::log($message);
    }

    public function output() {
        $headers = $this->getHeaders();
        foreach($headers as $header){
            header($header);
        }    
    }

    public function setHeaders($header) {
        parent::setHeaders($header);
    }

    public function setTemplate() {
        parent::setTemplate();
    }

    public function setViewData($key, $value) {
        parent::setViewData($key, $value);
    }

}

?>
