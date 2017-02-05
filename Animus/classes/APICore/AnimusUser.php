<?php
/**
 * Description of AnimusUser
 *
 * @author bbhask1x
 */
require_once "AnimusLogInfoHandler.php";
class AnimusUser {
    protected $_userName;
    protected $_alias;
    protected $_lastLoggedIn;
    protected $_authSignature; // Signature from the class file, which authenticated the user
    protected $_OAuthToken;
    protected $_userInSession;
    
    public function __construct() {
        $this->log("Class init ".__CLASS__);
        $this->setUserOutOfSession();
    }
    
    public function getUserName() {
        return $this->_userName;
    }

    public function getAlias() {
        return $this->_alias;
    }

    public function getLastLoggedIn() {
        return $this->_lastLoggedIn;
    }

    public function getAuthSignature() {
        return $this->_authSignature;
    }

    public function getOAuthToken() {
        return $this->_OAuthToken;
    }

    public function setUserName($userName) {
        $this->_userName = $userName;
    }

    public function setAlias($alias) {
        $this->_alias = $alias;
    }

    public function setLastLoggedIn($lastLoggedIn) {
        $this->_lastLoggedIn = $lastLoggedIn;
    }

    public function setAuthSignature($authSignature) {
        $this->_authSignature = $authSignature;
    }

    public function setOAuthToken($OAuthToken) {
        $this->_OAuthToken = $OAuthToken;
    }
    
    public function setUserOutOfSession() {
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__.". Set object property _userInSession = false.");
        $this->_userInSession = false;
    }
        
    public function setUserInSession() {
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__.". Set object property _userInSession = true.");
        $this->_userInSession = true;
    }
    
    public function isUserInSession(){
        $this->log("Entering method ".__METHOD__.". Input params = none");
        if($this->_userInSession){
            $this->log("Exiting method ".__METHOD__.". Returned true.");
        }
        else{
            $this->log("Exiting method ".__METHOD__.". Returned false.");
        }
        return $this->_userInSession;
    }
    
    public function log($message){
        AnimusLogInfoHandler::logDevInfo($message);
    }
    
    public function __destruct() {
        $this->log("Class destruct ".__CLASS__);
        return;
    }

}
