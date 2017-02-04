<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnimusPermanentRedirect
 *
 * @author bhaskarpramanik
 */
require_once "AnimusUnconditionalRedirect.php";
class AnimusPermanentRedirect extends AnimusUnconditionalRedirect{
    private $_causeCode;
    private $_redirectLocationFlag;
    
    public function __construct() {
        $this->log("Class init ".__CLASS__);
        parent::__construct();
    }
    public function stackHTTPHeaders(){
        $this->log("Entering method ".__METHOD__);
        parent::setRedirectHeaderCode($this->_causeCode);
        $this->log("Exiting method ".__METHOD__);
    }
    
    public function setCauseCode($causeCode){
        $this->log("Entering method ".__METHOD__);
        $this->_causeCode = $causeCode;
        $this->log("Exiting method ".__METHOD__.". Setting instance variable _causeCode = ".$causeCode);
    }
    
    public function getCauseCode(){
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__.". returned _causeCode = ".$this->_causeCode);
        return $this->_causeCode;
    }
    
    public function getRedirectCause() {
        $this->log("Entering method ".__METHOD__);
        return parent::getRedirectCause();
        $this->log("Exiting method ".__METHOD__);
    }

    public function getRedirectHeaderCode() {
        $this->log("Entering method ".__METHOD__);
        return parent::getRedirectHeaderCode();
        $this->log("Exiting method ".__METHOD__);
    }

    public function getRedirectLocation() {
        $this->log("Entering method ".__METHOD__);
        return parent::getRedirectLocation();
        $this->log("Exiting method ".__METHOD__);
    }

    public function getRedirectType() {
        $this->log("Entering method ".__METHOD__);
        return parent::getRedirectType();
        $this->log("Exiting method ".__METHOD__);
    }

    public function setCallBackURL($callbackURL) {
        $this->log("Entering method ".__METHOD__);
        parent::setCallBackURL($callbackURL);
        $this->log("Exiting method ".__METHOD__);
    }

    public function setCallingURL($URL) {
        $this->log("Entering method ".__METHOD__);
        parent::setCallingURL($URL);
    }

    public function setRedirectCause($_redirectCause) {
        $this->log("Entering method ".__METHOD__);
        parent::setRedirectCause($_redirectCause);
        $this->log("Exiting method ".__METHOD__);
    }

    public function setRedirectHeaderCode($_redirectHeaderCode) {
        $this->log("Entering method ".__METHOD__);
        parent::setRedirectHeaderCode($_redirectHeaderCode);
        $this->log("Exiting method ".__METHOD__);
    }

    public function setRedirectLocation($_redirectLocation) {
        $this->log("Entering method ".__METHOD__);
        parent::setRedirectLocation($_redirectLocation);
        $this->log("Exiting method ".__METHOD__);
    }

    public function setRedirectType($_redirectType) {
        $this->log("Entering method ".__METHOD__);
        parent::setRedirectType($_redirectType);
        $this->log("Exiting method ".__METHOD__);
    }
    
    public function getRedirectLocationFlag() {
        $this->log("Entering method ".__METHOD__);
        return $this->_redirectLocationFlag;
        $this->log("Exiting method ".__METHOD__);
    }
    /*
     * This flag:
     * if
     *      true >> Re-directs the user to a fancy error page
     *      false >> Just generates the headers with error code
     */
    public function setRedirectLocationFlag() {
        $this->log("Entering method ".__METHOD__);
        $this->_redirectLocationFlag = true;
        $this->log("Exiting method ".__METHOD__);
    }
    
    public function __destruct() {
        $this->log("Class destruct ".__CLASS__);
    }

}
