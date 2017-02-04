<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnimusRedirectImpl:
 *
 * A class which implements the AnimusRedirect interface.
 * All methods are to be overridden in any class which extends this class
 * 
 * @author bhaskarpramanik
 */

require_once CLASSPATH."/abstract/AnimusRedirect.php";
require_once APICORE."/AnimusLogInfoHandler.php";

class AnimusRedirectImpl implements AnimusRedirect{
    public function setRedirectCause($REDIRECT_CAUSE) {}
    
    public function setRedirectType($REDIRECT_TYPE) {}
    
    public function setRedirectHeaderCode($REDIRECT_HEADER_CODE) {}
    
    public function setRedirectLocation($REDIRECT_LOCATION){}
    
    public function setCalledURL($CALLED_URL){}
    
    public function log($message){
        AnimusLogInfoHandler::logDevInfo($message);
    }
}
