<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnimusAuthRedirect
 *
 * @author bhaskarpramanik
 */
require_once "AnimusTemporaryRedirect.php";

class AnimusAuthRedirect extends AnimusTemporaryRedirect{
    
    private $_redirectLocationFlag;
    
    public function getCallbackPath() {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        return parent::getCallbackPath();
    }

    public function getCallbackURL() {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        return parent::getCallbackURL();
    }

    public function getCalledURL() {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        return parent::getCalledURL();
    }

    public function getRedirectCause() {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        return parent::getRedirectCause();
    }

    public function getRedirectHeaderCode() {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        return parent::getRedirectHeaderCode();
    }

    public function getRedirectLocation() {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        return parent::getRedirectLocation();
    }

    public function getRedirectType() {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        return parent::getRedirectType();
    }

    public function getUserDataArray() {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        return parent::getUserDataArray();
    }
    
    public function getCauseCode() {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        return parent::getCauseCode();
    }
    
    public function getRedirectLocationFlag(){
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        return $this->_redirectLocationFlag;
    }

    public function setCallbackPath($callbackPath) {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        parent::setCallbackPath($callbackPath);
    }

    public function setCallbackURL($callbackURL) {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        parent::setCallbackURL($callbackURL);
    }

    public function setCalledURL($calledURL) {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        parent::setCalledURL($calledURL);
    }

    public function setRedirectCause($redirectCause) {
        $this->log("Entering method ".__METHOD__);
        parent::setRedirectCause($redirectCause);
    }

    public function setRedirectHeaderCode($redirectHeaderCode) {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        parent::setRedirectHeaderCode($redirectHeaderCode);
    }

    public function setRedirectLocation($redirectLocation) {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        parent::setRedirectLocation($redirectLocation);
    }

    public function setRedirectType($redirectType) {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        parent::setRedirectType($redirectType);
    }

    public function setUserDataArray($userDataArray) {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        parent::setUserDataArray($userDataArray);
    }

    public function stackHTTPHeaders() {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        parent::stackHTTPHeaders();
    }
    
    public function setRedirectLocationFlag(){
        $this->log("Entering method ".__METHOD__);
        $causeCode = parent::getCauseCode();
        if($causeCode == 401){
            $this->log(__METHOD__." - Processing 401 redirection.");
            $this->_redirectLocationFlag = REDIRECT_401;
        }
        else if($causeCode == 403){
            $this->log(__METHOD__." - Processing 403 redirection.");
            $this->_redirectLocationFlag = REDIRECT_403;
        }
        $this->log("Exiting method ".__METHOD__);
    }
    
    public function setCauseCode($_causeCode) {
        $this->log("Entering method ".__METHOD__.". Input param = ".$_causeCode);
        parent::setCauseCode($_causeCode);
    }
    
}
