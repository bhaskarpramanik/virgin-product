<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnimusErrorView
 *
 * @author bhaskarpramanik
 */

require_once "AnimusViewImpl.php";

class AnimusStaticView extends AnimusViewImpl{
    
    private $_pageContent;  // External "static" HTML content to be loaded here
    
    public function __construct() {
        parent::__construct();
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
    
    public function getPageContent(){
        return $this->_pageContent;
    }

    public function output() {
        // Overridden in child class
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
    
    public function setPageContent($pageContent){
        $this->_pageContent = $pageContent;
    }

}
