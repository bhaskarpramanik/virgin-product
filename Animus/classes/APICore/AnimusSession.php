<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * @author bhaskarpramanik
 */
require_once "AnimusUser.php";
require_once "AnimusLogInfoHandler.php";

class AnimusSession{
    
    protected $_sessId;
    protected $_userInfo;
    protected $_valid;
    protected $_lastRequest;
    protected $_sessionTime;
    protected $_timeout;
    
    public function __construct() {
        $this->log("Class init ".__CLASS__);
        $this->_userInfo = new AnimusUser();
        $this->valid = false;
    }

    public function setSession(){
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $random = rand(0,999999);
        $this->_sessId =   hash(md5,$this->_lastRequest.$random);
        $this->_valid  =   true;
        $this->_lastRequest = $_SERVER['REQUEST_TIME'];
        $this->_sessionTime = $this->_lastRequest;
        $this->log("Exiting method ".__METHOD__);
    }
    
    public function setLastRequestTime(){
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__.". Setting object property _lastRequest = ".$_SERVER['REQUEST_TIME']);
        $this->_lastRequest = $_SERVER['REQUEST_TIME'];
        
    }

    public function getLastRequestTime(){
        $this->log("Entering method ".__METHOD__.". Input params = none");
        return $this->_lastRequest;
        
    }
    
    public function getSessionId(){
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__.". Returned ".$this->_sessId);
        return $this->_sessId;
        
    }

    public function setUserInfo(AnimusUser $AnimusUser){
        $this->log("Entering method ".__METHOD__.". Input params - InstanceOf AnimusUser");
        $this->log("Exiting method ".__METHOD__.". Setting object property _userInfo to - InstanceOf AnimusUser");
        $this->_userInfo    =   $AnimusUser;
    }
    
     public function getUserInfo(){
        $this->log("Entering method ".__METHOD__.". Input params - none");
        $this->log("Exiting method ".__METHOD__.". Returned object property - _userInfo");
        return $this->_userInfo;
    }
    
    public function isValid(){
        $this->log("Entering method ".__METHOD__.". Input params = none");
        if($this->_lastRequest - $this->_sessionTime > $this->_timeout){
            
            $this->invalidate();                  
        }
        $this->log("Exiting method ".__METHOD__.". Returned ".$this->_valid);
        return  $this->_valid;
    }

    public function invalidate(){
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->_sessId =   NULL;
        $this->_valid = false;
        $this->_userInfo->setUserOutOfSession();
        $this->_lastRequest = null;
        $this->_timeout = 0;
        $this->_sessionTime = 0;
        unset($this->_userInfo);
        $this->log("Exiting method ".__METHOD__);
    }
    
    public function setTimeout($timeout){
        $this->log("Entering method ".__METHOD__.". Input params = ".$timeout);
        $this->log("Exiting method ".__METHOD__.". Setting object property _timeout = ".$timeout);
        $this->_timeout = $timeout;
        
    }
    public function manageExistingSession(){
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $settings   =   SESSION_TIMEOUT; // Constant defined in application-settings.xml | Implemented in AnimusBootstrap.php
        $timeout = ($settings->session->timeout)*60;
        @session_start();
        $session =  $this -> _AnimusResponse -> getSession();
        $session->setSession();
        $session->setTimeOut($timeout);
        $this->log("Exiting method ".__METHOD__);
        $_SESSION['ASESSION'] = $session;
        $this->log("Exiting method ".__METHOD__);
    }
    public  function getSession(){
        $this->log("Entering method ".__METHOD__.". Input params = none");
        @session_start();
        if(isset($_SESSION['ASESSION'])){
            if($_SESSION['ASESSION']->isValid()){
                $_SESSION['ASESSION']->setLastRequestTime();
                $this->log("Exiting method ".__METHOD__.". Returned ".$_SESSION['ASESSION']);
                return  $_SESSION['ASESSION'];
            }
            else{
                $this->log("Exiting method ".__METHOD__.". Returned NULL");
                return null;
            }
        }
        else {
            $this->log("Exiting method ".__METHOD__.". Returned NULL");
            return null;
        }    
    }
    public function closeSession(){ 
        $this->log("Entering method ".__METHOD__.". Input params = none");
       @session_start(); 
        if(isset($_SESSION['ASESSION'])){
            if($_SESSION['ASESSION']->isValid()){
                $_SESSION['ASESSION']->invalidate();
            }
        }
        $this->log("Exiting method ".__METHOD__);
    }
    
    public function log($message){
        AnimusLogInfoHandler::logDevInfo($message);
    }
    
    public function __destruct(){
        $this->log("Class destruct ".__CLASS__);
    }
}
?>