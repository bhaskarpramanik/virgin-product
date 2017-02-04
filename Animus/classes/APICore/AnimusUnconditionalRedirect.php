<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnimusUnconditionalRedirect:
 *
 * AnimusUnconditionRedirect handles redirection scenarios,
 * where the user is not allowed to access a requested resource - unconditionally
 * This type of redirection, doesn't require to preserve the user data array,
 * and exists simply to implement policies.
 * 
 * @author bhaskarpramanik
 */

require_once "AnimusRedirectImpl.php";
class AnimusUnconditionalRedirect extends AnimusRedirectImpl{
    
    public $_redirectCause;
    public $_redirectType;
    public $_redirectHeaderCode;
    public $_redirectLocation;
    public $_callingURL;
    public $_callbackURL;
    public $_callBackPath;
    
    public function __construct(){
        $this->log("Class init ".__CLASS__);
        $this->_redirectHeaderCode= array();
    }
    
    public function setRedirectCause($_redirectCause){
        $this->log("Entering method ".__METHOD__);
        $this->_redirectCause = $_redirectCause;
        $this->log("Exiting method ".__METHOD__.". Setting instance variable _redirectCause = ".$_redirectCause);
        
    }
    public function getRedirectCause(){
        $this->log("Entering method ".__METHOD__);
        return $this->_redirectCause;
        $this->log("Exiting method ".__METHOD__.". Returned _redirectCause = ".$this->_redirectCause);
    }
    public function setRedirectType($_redirectType){
        $this->log("Entering method ".__METHOD__);
        $this->_redirectType = $_redirectType;
        $this->log("Exiting method ".__METHOD__.". Setting instance variable _redirectType = ".$this->_redirectType);
    }
    public function getRedirectType(){
        $this->log("Entering method ".__METHOD__);
        return $this->_redirectType;
        $this->log("Exiting method ".__METHOD__.". Returned _redirectType = ".$this->_redirectType);
    }
    public function setRedirectHeaderCode($_redirectHeaderCode) {
        $this->log("Entering method ".__METHOD__);
        array_push($this->_redirectHeaderCode, $_redirectHeaderCode);
        $this->log("Exiting method ".__METHOD__.". Added header code = ".$_redirectHeaderCode);
    }
    public function getRedirectHeaderCode(){
        $this->log("Entering method ".__METHOD__);
        return $this->_redirectHeaderCode;
        $this->log("Exiting method ".__METHOD__.". Returned _redirectHeaderCode = ".$this->_redirectHeaderCode);
    }
    public function setRedirectLocation($_redirectLocation) {
        $this->log("Entering method ".__METHOD__);
        $this->_redirectLocation = $_redirectLocation;
        $this->log("Exiting method ".__METHOD__.". Setting instance variable _setRedirectLocation = ".$_redirectLocation);
    }
    public function getRedirectLocation(){
        $this->log("Entering method ".__METHOD__);
        return $this->_redirectLocation;
        $this->log("Exiting method ".__METHOD__." Returned = ".$this->_redirectLocation);
    }
    public function setCallingURL($URL){
        $this->log("Entering method ".__METHOD__);
        $this->_callingURL = $URL;
        $this->log("Exiting method ".__METHOD__.". Setting instance variable _callingURL = ".$URL);
    }
    public function setCallBackURL($callbackURL){
        $this->log("Entering method ".__METHOD__);
        $this -> _callbackURL = $callbackURL;
        $this->log("Exiting method ".__METHOD__.". Setting instance variable _callbackURL = ".$callbackURL);
    }
    public function __destruct() {
        $this->log("Class destruct ".__CLASS__);
    }
    
}