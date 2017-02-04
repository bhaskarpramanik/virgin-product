<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnimusResponse
 *
 * @author bhaskarpramanik
 */
class AnimusResponse {
               
    private $_view;
    
    private $_model;
    
    private $_session = null;
    
    private $_valid = false;
    
    private $_HTTPStatusCode;
    
    private $_HTTPStatusMessage;

    public function setModel($Model){
        
        $this->_model = $Model;
        
    }
    
    public function getModel(){
        
        return $this->_model;
        
    }
    
    public function setView($View){
        
        $this ->_view = $View;
        
    }
    
    public function getView(){
        
        return $this -> _view;
        
    }
    
    public function setSession(AnimusSession $session){
        
        $this->_session = $session;
        
    }
    
    public function getSession(){
        
        return $this->_session;
        
    }
    
    public function setHTTPStatusCode($code){
        
        $this->_HTTPStatusCode = $code;
    }
    
    public function getHTTPStatusCode(){
        return $this->_HTTPStatusCode;
    }
    
    public function getHTTPStatusMessage() {
        return $this->_HTTPStatusMessage;
    }

    public function setHTTPStatusMessage($HTTPStatusMessage) {
        $this->_HTTPStatusMessage = $HTTPStatusMessage;
    }

        public function setValid(){
        $this->_valid = true;
    }
    
    public function isValid(){
        return $this->_valid;
    }
}

?>