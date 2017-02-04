<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnimusTempErrorRedirect
 * Case of status code 500
 * @author bhaskarpramanik
 */
require_once "AnimusTemporaryRedirect.php";
class AnimusTempErrorRedirect extends AnimusTemporaryRedirect{
    
    private $_redirectLocationFlag;
    
    public function __construct() {
        $this->log("Class init ".__CLASS__);
        parent::__construct();
    }
    
    public function getCallbackPath() {
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__);
        return parent::getCallbackPath();
    }

    public function getCallbackURL() {
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__);
        return parent::getCallbackURL();
    }

    public function getCalledURL() {
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__);
        return parent::getCalledURL();
    }

    public function getRedirectCause() {
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__);
        return parent::getRedirectCause();
    }

    public function getRedirectHeaderCode() {
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__);
        return parent::getRedirectHeaderCode();
    }

    public function getRedirectLocation() {
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__);
        return parent::getRedirectLocation();
    }

    public function getRedirectType() {
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__);
        return parent::getRedirectType();
    }

    public function getUserDataArray() {
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__);
        return parent::getUserDataArray();
    }

    public function setCallbackPath($callbackPath) {
        $this->log("Entering method ".__METHOD__.". Input params = ".$callbackPath);
        $this->log("Exiting method ".__METHOD__);
        parent::setCallbackPath($callbackPath);
    }

    public function setCallbackURL($callbackURL) {
        $this->log("Entering method ".__METHOD__.". Input params = ".$callbackURL);
        $this->log("Exiting method ".__METHOD__);
        parent::setCallbackURL($callbackURL);
    }

    public function setCalledURL($calledURL) {
        $this->log("Entering method ".__METHOD__.". Input params = ".$calledURL);
        $this->log("Exiting method ".__METHOD__);
        parent::setCalledURL($calledURL);
    }

    public function setRedirectCause($redirectCause) {
        $this->log("Entering method ".__METHOD__.". Input params = ".$redirectCause);
        $this->log("Exiting method ".__METHOD__);
        parent::setRedirectCause($redirectCause);
    }

    public function setRedirectHeaderCode($redirectHeaderCode) {
        $this->log("Entering method ".__METHOD__.". Input params = ".$redirectHeaderCode);
        parent::setRedirectHeaderCode($redirectHeaderCode);
        $this->log("Exiting method ".__METHOD__);
    }

    public function setRedirectLocation($redirectLocation) {
        $this->log("Entering method ".__METHOD__.". Input params = ");
        if(REDIRECT_500){
            parent::setRedirectLocation($redirectLocation);
            $this->log("Redirection is set to true for statusCode = 500");
        }
        else $this->log("Redirection is set to false for statusCode = 500");
        $this->log("Exiting method ".__METHOD__);
        return;
    }

    public function setRedirectType($redirectType) {
        $this->log("Entering method ".__METHOD__.". Input params = ".$redirectType);
        $this->log("Exiting method ".__METHOD__);
        parent::setRedirectType($redirectType);
    }

    public function setUserDataArray($userDataArray) {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        parent::setUserDataArray($userDataArray);
    }

    public function stackHTTPHeaders() {
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__.". Returned bool");
        parent::stackHTTPHeaders();
    }
    
    public function setCauseCode($_causeCode) {
        $this->log("Entering method ".__METHOD__.". Input params = ".$_causeCode);
        $this->log("Exiting method ".__METHOD__.". Returned bool ".$_causeCode);
        parent::setCauseCode($_causeCode);
    }
    
    public function setRedirectLocationFlag(){
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__.". Returned bool ".REDIRECT_500);
        $this->_redirectLocationFlag = REDIRECT_500;
    }
        
    public function getRedirectLocationFlag(){
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__.". Returned bool ".$this->_redirectLocationFlag);
        return $this->_redirectLocationFlag;
    }
    
    public function log($message){
        AnimusLogInfoHandler::logDevInfo($message);
    }
    
    public function __destruct(){
        $this->log("Class destruct ".__CLASS__);
    }
}
