<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StaticViewDemo
 *
 * @author bhaskarpramanik
 */
require_once APICORE."/AnimusStaticView.php";
class StaticView extends AnimusStaticView{
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
        $headers = $this->getHeaders();
        foreach($headers as $header){
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
