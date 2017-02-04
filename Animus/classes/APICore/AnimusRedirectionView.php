<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnimusRedirectionView
 *
 * @author bhaskarpramanik
 */
require_once 'AnimusStaticView.php';
class AnimusRedirectionView extends AnimusStaticView{
    public function __construct() {
        $this->log("Class init ".__CLASS__);
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
        // Output headers and exit
    
        $headerArray = $this->getHeaders();
        foreach($headerArray as $header){
            header($header);
        }
        return;
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
    
    public function __destruct() {
        $this->log("Class destruct ".__CLASS__);
    }

}
