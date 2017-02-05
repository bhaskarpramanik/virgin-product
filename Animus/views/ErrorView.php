<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ErrorView
 *
 * @author Animus Inc.
 */
require_once APICORE."/AnimusStaticView.php";
class ErrorView extends AnimusStaticView{
    public function __construct() {
        parent::__construct();
    }

    public function getPageContent() {
        return parent::getPageContent();
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

    public function output() {
        // Override this function here
        $headerArray = parent::getHeaders();
        foreach($headerArray as $header){
            header($header);
        }
        echo $this->getPageContent();
    }

    public function setHeaders($header) {
        parent::setHeaders($header);
    }

    public function setPageContent($pageContent) {
        parent::setPageContent($pageContent);
    }

    public function setTemplate() {
        parent::setTemplate();
    }

    public function setViewData($key, $value) {
        parent::setViewData($key, $value);
    }

}

?>