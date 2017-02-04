<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnimusHeaderInfoHandler
 *
 * @author bhaskarpramanik
 */


class AnimusHeaderInfoHandler {
    
    const HTTP_200 = "Ok";
    const HTTP_301 = "Moved Permanently";
    const HTTP_302 = "Found";
    const HTTP_400 = "Bad Request";
    const HTTP_401 = "Unauthorized";
    const HTTP_403 = "Forbidden";
    const HTTP_404 = "Not Found";
    const HTTP_500 = "Internal Server Error";
    const HTTP_503 = "Service Available";
    private $_locationHeaderPath;
    private $_headerArray;
    
    public function __construct() {
        $this->log("Class init ".__METHOD__);
        $this->_headerArray = array();
    }
    
    public function getResponseText($responseHeaderCode){
        $this->log("Entering method ".__METHOD__.". Input param1 = ".$responseHeaderCode);
        switch($responseHeaderCode){
            case 200: return self::HTTP_200;
                break;
            case 301: return self::HTTP_301;
                break;
            case 302: return self::HTTP_302;
                break;
            case 400: return self::HTTP_400;
                break;
            case 401: return self::HTTP_401;
                break;
            case 403; return self::HTTP_403;
                break;
            case 404; return self::HTTP_404;
                break;
            case 500; return self::HTTP_500;
                break;
            case 503; return self::HTTP_503;
        }
        $this->log("Exiting method ".__METHOD__);
    }
    
    public function setLocationPath($locationHeaderPath){
        $this->log("Entering function ".__METHOD__.". Input param = ".$locationHeaderPath);
        $this->_locationHeaderPath = $locationHeaderPath;
        return true;
        $this->log("Exiting method ".__METHOD__);
    }
    
    public function getLocationPath(){
        $this->log("Entering function ".__METHOD__);
        return $this->_locationHeaderPath;
        $this->log("Exiting method ".__METHOD__."Returned _locationHeaderPath = ".$_locationHeaderPath);
    }
    
    public function generateLocationHeader($serverProtocol, $locationHeaderOverrideFlag){
        $this->log("Entering function ".__METHOD__.". Input param1 = ".$serverProtocol." param2 = ".$locationHeaderOverrideFlag);
        $redirectPath = $this->getLocationPath();
        if(!is_null($redirectPath)&&$locationHeaderOverrideFlag){
            $locationHeaderString = "Location: ".$redirectPath;
            $this->log(__METHOD__." - Error redirection is enabled to custom error page in application-settings.xml");
            $this->log(__METHOD__." - Redirecting user to ".$redirectPath);
            $this->log(__METHOD__." - Pushing location header to header array");
            array_push($this->_headerArray, $locationHeaderString);
        }
        else {
            
           /*
            * If    locationHeaderOverrideFlag == false : Don't generate location header
            *       locationHeaderOverrideFlag == true  : Generate location header
            */ 

        }
        $this->log("Exiting method ".__METHOD__);
        return;
    }
    
    public function generateStatusHeaders($serverProtocol, $statusCode){
        $this->log("Entering method ".__METHOD__.". Input param1 = ".$serverProtocol." param2 =".$statusCode);
        $headerString = $serverProtocol." ".$statusCode." ".$this->getResponseText($statusCode);
        array_push($this->_headerArray, $headerString);
        $this->log("Exiting method ".__METHOD__);
        return true;
    }
    
    public function getHeaderArray(){
        $this->log("Entering method ".__METHOD__);
        return $this->_headerArray;
        $this->log("Exiting method ".__METHOD__."Returned _headerArray");
    }
    
    public function __destruct() {
        $this->log("Class destruct ".__CLASS__);
    }
    
    public function log($message){
        AnimusLogInfoHandler::logDevInfo($message);
    }
}
?>
