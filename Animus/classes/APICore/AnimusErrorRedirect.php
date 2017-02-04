<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnimusErrorHandlingRedirect
 *
 * @author bhaskarpramanik
 */
require_once "AnimusPermanentRedirect.php";
class AnimusErrorRedirect extends AnimusPermanentRedirect{
    
    /*
     * This redirect class is
     * to be called for 404
     * errors
     */
    
    private $_redirectLocationFlag;
    
    public function __construct(){
        $this->log("Class init ".__CLASS__);
        parent::__construct();
    }
    
    public function getRedirectCause() {
        $redirectCause = parent::getRedirectCause();
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__.". Returned = ".$redirectCause);
        return $redirectCause;
    }

    public function getRedirectHeaderCode() {
        $headerCode = parent::getRedirectHeaderCode();
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__.". Returned = headerCode (array)");
        return $headerCode;
    }

    public function getRedirectLocation() {
        $redirectLocation = parent::getRedirectLocation();
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__.". Returned = ".$redirectLocation);
        return $redirectLocation;
    }

    public function getRedirectType() {
        $redirectType = parent::getRedirectType();
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__.". Returned = ".$redirectType);
        return $redirectType;
    }

    public function setCallBackURL($callbackURL) {
        $this->log("Entering method ".__METHOD__.". Input params = ".$callbackURL);
        $this->log("Exiting method ".__METHOD__.". Setting callbackURL = ".$callbackURL);
        parent::setCallBackURL($callbackURL);
    }

    public function setCallingURL($URL) {
        $this->log("Entering method ".__METHOD__.". Input params = ".$URL);
        $this->log("Exiting method ".__METHOD__.". Setting callingURL = ".$URL);
        parent::setCallingURL($URL);
    }

    public function setCauseCode($causeCode) {
        $this->log("Entering method ".__METHOD__.". Input params = ".$causeCode);
        $this->log("Exiting method ".__METHOD__.". Setting causeCode = ".$causeCode);
        parent::setCauseCode($causeCode);
    }

    public function setRedirectCause($redirectCause) {
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__.". Setting redirectCause = ".$redirectCause);
        parent::setRedirectCause($redirectCause);
    }

    public function setRedirectHeaderCode($redirectHeaderCode) {
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__.". Setting redirectHeaderCode = ".$redirectHeaderCode);
        parent::setRedirectHeaderCode($redirectHeaderCode);
    }

    public function setRedirectLocation($redirectLocation) {
        $this->log("Entering method ".__METHOD__.". Input params = none");
        if(REDIRECT_404){
            parent::setRedirectLocation($redirectLocation);
            $this->log("Redirection is set to true for statusCode = 404");
        }
        else $this->log("Redirection is set to false for statusCode = 404"); 
        $this->log("Exiting method ".__METHOD__);
        return;
    }

    public function setRedirectType($_redirectType) {
        $this->log("Entering method ".__METHOD__.". Input params = ".$_redirectType);
        parent::setRedirectType($_redirectType);
        $this->log("Exiting method ".__METHOD__);
    }

    public function stackHTTPHeaders() {
        $this->log("Entering method ".__METHOD__.". Input params = none");
        parent::stackHTTPHeaders();
        $this->log("Exiting method ".__METHOD__);
    }
    
    public function setRedirectLocationFlag(){
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->_redirectLocationFlag = REDIRECT_404;
        $this->log("Exiting method ".__METHOD__);
    }
    
    public function getRedirectLocationFlag(){
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__);
        return $this->_redirectLocationFlag;
    }
    
    public function getCauseCode(){
 
    }
    
    public function log($message){
        AnimusLogInfoHandler::logDevInfo($message);
    }
    
    public function __destruct(){
        $this->log("Class destruct ".__CLASS__);
    }

}
?>