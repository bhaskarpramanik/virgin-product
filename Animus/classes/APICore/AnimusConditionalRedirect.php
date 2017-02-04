<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnimusConditionalRedirect:
 * AnimusConditionalRedirect handles redirection scenarios, where
 * the user is allowed / denied the access to the requested
 * resource based upon conditions.
 * This redirect implements a user data array, which has to hold the
 * user data during redirection and pass on to the previous view,
 * once the purpose of the redirection is met.
 * 
 * @author bbhask1x
 */
require_once "AnimusRedirectImpl.php";
class AnimusConditionalRedirect extends AnimusRedirectImpl {
    public $_redirectCause;
    public $_redirectType;
    public $_redirectHeaderCode;
    public $_redirectLocation;
    public $_calledURL;
    public $_callbackURL;
    public $_callbackPath;
    public $_userDataArray;
    public $_callback;
    
    public function __construct(){
        $this->log("Class init ".__CLASS__);
        $this->_redirectHeaderCode = array();
    }
    
    public function getRedirectCause() {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        return $this->_redirectCause;
    }

    public function getRedirectType() {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        return $this->_redirectType;
    }

    public function getRedirectHeaderCode() {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        return $this->_redirectHeaderCode;
    }

    public function getRedirectLocation() {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        return $this->_redirectLocation;
    }

    public function getCalledURL() {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        return $this->_calledURL;
    }

    public function getCallbackURL() {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        return $this->_callbackURL;
    }

    public function getCallbackPath() {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        return $this->_callbackPath;
    }

    public function getUserDataArray() {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        return $this->_userDataArray;
    }
    
    public function getCauseCode(){
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        return $this->_causeCode;
    }

    public function setRedirectCause($redirectCause) {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        $this->_redirectCause = $redirectCause;
    }

    public function setRedirectType($redirectType) {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        $this->_redirectType = $redirectType;
    }

    public function setRedirectHeaderCode($redirectHeaderCode) {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        array_push($this->_redirectHeaderCode, $redirectHeaderCode);
    }

    public function setRedirectLocation($redirectLocation) {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        $this->_redirectLocation = $redirectLocation;
    }

    public function setCalledURL($calledURL) {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        $this->_calledURL = $calledURL;
    }

    public function setCallbackURL($callbackURL) {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        $this->_callbackURL = $callbackURL;
    }

    public function setCallbackPath($callbackPath) {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        $this->_callbackPath = $callbackPath;
    }

    public function setUserDataArray($userDataArray) {
        $this->log("Entering method ".__METHOD__);
        $this->_userDataArray = $userDataArray;
        $this->log("Exiting method ".__METHOD__);
    }
    
    public function __destruct() {
       $this->log("Class destruct ".__CLASS__);
    }
}
