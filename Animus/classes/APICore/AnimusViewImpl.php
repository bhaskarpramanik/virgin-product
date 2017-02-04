<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnimusViewImpl
 *
 * @author bhaskarpramanik
 */
require_once ABSTRACTPATH.'/AnimusView.php';
require_once APICORE."/AnimusLogInfoHandler.php";

class AnimusViewImpl implements AnimusView{
     
    private $_header;
    private $_viewData;
    //private $_template;   To be implemented after AnimusUX
    
    public function __construct(){
        $this->log("Class init ".__CLASS__);
        $this->_header = array();
        $this->_viewData = array();
    }
    
    public function output() {
        // Output all headers to the browser
    }

    public function setHeaders($header) {
        $this->_header = $header;
    }

    public function setViewData($key,$value) {
        $this->_viewData[$key] = $value;
    }
    
    public function setTemplate(){
        // To be developed later with AnimusUX
    }
    
    public function getViewData(){ //Returns viewData array
        return $this->_viewData;
    }
    
    public function getViewDataByName($key){
        return $this->_viewData[$key];
    }
    
    public function getHeaders(){
        return $this->_header;
    }
    
    public function getHeaderByName($headerName){
        // Re write this method
    }
    
    public function getTemplate(){
        // To be developed later with AnimusUX
    }
    
    public function log($message){
        AnimusLogInfoHandler::logDevInfo($message);
    }
}
