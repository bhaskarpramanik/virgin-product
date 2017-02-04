<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnimusViewPropertyHandler
 *
 * @author bhaskarpramanik
 */
require_once "AnimusLogInfoHandler.php";
require_once "AnimusViewProperty.php";

class AnimusViewPropertyHandler{
    
    private $_viewName;
    private $_viewPropertyArray;
    private $_statusCode;
    
    /*
     *  @methodName - constructor
     *  @returns - void
     *  @throwsException - none
     *  @methodInputParams - string var viewName
     *  @description - 
     *  1. Reads view properties.
     *  2. Sets view properties.
     */
    public function __construct($viewName) {
        $this->log("Class init ".__CLASS__);
        $this->setViewName($viewName);
    }
    
    public function resolveViewProperties(){
    /*
     * Try to read the property config file of the view in question.
     * Else throw an exception and log the error
     */
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->_viewPropertyArray = new AnimusViewProperty();
        if($this->fileCheck($this->_viewName."_properties.xml", VIEW_PROPERTIES)){
           $readProperties = new SimpleXMLElement(file_get_contents(VIEW_PROPERTIES.$this->_viewName."_properties.xml"));
            if((string)$readProperties["name"] === $this->_viewName){
                    foreach($readProperties->children() as $properties){
                        $this->log("Looping through properties ...");
                        foreach($properties as $property){
                            $key = $property["name"];
                            $value = $property["value"];
                            /*
                             * Run the switch case
                             */
                            switch($key){
                            case "VIEW_PATH" : $this->_viewPropertyArray->setViewPath(strlen($value)>0? (string)$value:null);
                                break;
                            case "VIEW_TYPE" : $this->_viewPropertyArray->setViewType(strlen($value)>0? (string)$value:null);
                                break;
                            case "VIEW_ALLOW_URL_PARAMS" : $this->_viewPropertyArray->setViewAllowURLParams(strlen($value)>0? $this->stringToBoolean((string)$value):null);
                                break;
                            case "VIEW_PARAMS" : $this->_viewPropertyArray->setViewParams(strlen($value)>0? (string)$value:null);
                                break;
                            case "AUTH_REQUIRED" : $this->_viewPropertyArray->setAuthRequired(strlen($value)>0? $this->stringToBoolean((string)$value):null);
                                break;
                            case "AUTH_VIEW_URL" : $this->_viewPropertyArray->setAuthViewURL(strlen($value)>0? (string)$value:null);
                                break;
                            case "AUTH_SIGNATURE" : $this->_viewPropertyArray->setAuthSignature(strlen($value)>0? (string)$value:null);
                                break;
                            case "VIEW_REDIRECTED" : $this->_viewPropertyArray->setViewRedirected(strlen($value)>0? $this->stringToBoolean((string)$value):null);
                                break;
                            case "VIEW_REDIRECT_CODE" : $this->_viewPropertyArray->setViewRedirectCode(strlen($value)>0? (int)$value:null);
                                break;
                            case "VIEW_REDIRECT_RESC_URL" : $this->_viewPropertyArray->setViewRedirectRescURL(strlen($value)>0? (string)$value:null);
                                break;
                            case "PHASE_MAINT" : $this->_viewPropertyArray->setPhaseMaint(strlen($value)>0? $this->stringToBoolean((string)$value):null);
                                break;
                            case "PHASE_MAINT_START" : $this->_viewPropertyArray->setPhaseMaintStart(strlen($value)>0? (int)$value:null);
                                break;
                            case "PHASE_MAINT_STOP" : $this->_viewPropertyArray->setPhaseMaintStop(strlen($value)>0? (int)$value:null);
                                break;
                            case "MAPPED_COMPONENT" : $this->_viewPropertyArray->setMappedComponent(strlen($value)>0? (string)$value:null);
                                break;
                            case "MAPPED_MODELS" : $this->_viewPropertyArray->setMappedModels(strlen($value)>0? (string)$value:null);
                                break;
                            case "MAPPED_DATASET" : $this->_viewPropertyArray->setMappedDataset(strlen($value)>0? (string)$value:null);
                            }
                        }
                        break;
                    }
                $this->setHTTPStatusCode(202);
                $this->log("Exiting method ".__METHOD__.". Returned true.");
                return true;
            }
            else{
                $logErrorMessage = "Property file name @attribute incorrect >> ".$this->_viewName." at path >> ".VIEW_PROPERTIES.$this->_viewName."_properties.xml";
                try{
                    throw new AnimusException($logErrorMessage);
                }
                catch(AnimusException $ex){
                    $ex->log($ex->getMessage()." - ".__METHOD__." - ".$ex->getLine());
                    $this->setHTTPStatusCode(500);
                }
                $this->log("Exiting method ".__METHOD__.". Returned false.");
                return false;
            }
        }
        else{
            $logErrorMessage = "View property not found for >> ".$this->_viewName." at path >> ".VIEW_PROPERTIES.$this->_viewName."_properties.xml";
            try{
                throw new AnimusException($logErrorMessage);
            }
            catch(AnimusException $ex){
                $ex->log($ex->getMessage()." - ".__METHOD__." - ".$ex->getLine());
                $this->setHTTPStatusCode(500);
            }
            $this->log("Exiting method ".__METHOD__.". Returned false.");
            return false;
        }
    }
    
    public function checkAuthRedirect(AnimusUser $existingAnimusUser){
        /* This method checks if authentication
         * is required by a view. If it is
         * required, then this method also
         * compares the provided auth signature
         * with required auth signature.
         * Returns: true if redirect is required
         * or returns false if redirect is not required
         */
        
        $authRequired = $this->_viewPropertyArray->getAuthRequired();
        $requestedAuth = $this->_viewPropertyArray->getAuthSignature();
        /*
         * If authentication is required to proceed further
         * Check: The auth signature of the logged in user
         * In case the user is not in session, then the response
         * will be a null. Handle this condition as well.
         */
        $existingAuthSignature = $existingAnimusUser->getAuthSignature();
        if(isset($existingAuthSignature)){
            $sessionExists = true;
        }
        else {
            $sessionExists = false;
        }    
        /*
         * If authentication is required, process to check the
         * existing signature
         */
        if($authRequired){
            /*
             * Compare the auth signature from the session,
             * and the requied authSignature.
             * If match is successful, then proceed further with status
             * code 202
             * If the match is unsuccessful, then change the status code
             * to 401. Get the authHandler for the view from the properties
             * and do a security re-direct to that view.
             */
            if($sessionExists){
                if($existingAuthSignature === $requestedAuth){
                    /*
                     * This is the case where, the current user authentication
                     * is good to go, and there is no need to re-authenticate
                     * Status Code remains unchanged
                     */
                    return false;
                }
                else{
                    /*
                     * If the execution has reached this block, it means
                     * that the existing user is not valid to see the
                     * target view. In this case:
                     * Status Code = 403
                     * Next Step: Redirection
                     * Cause: Un - Authorized attempt to see view
                     */
                    $this->_statusCode = 403;
                    return true;
                }
                
            }
            /*
             * Session doesn't exist
             */
            else{
                $this->_statusCode = 401;
                return true;
            }
        }
        /*
         * Else, no checks required for
         * existing signature. 
         */
        else{
            return false;
        }
    }
    
    public function checkforcedRedirect(){
        /*
         * This method intends to check
         * if there is an intentional 
         * redirect instruction is
         * already set up, and then
         * proceeds further.
         * Returns: true if redirected
         * or false if not.
         */
        $isRedirected = $this->_viewPropertyArray->getViewRedirected();
        if($isRedirected){
            /*
             * Redirection is true
             * set the proper code
             */
            $this->_statusCode = $this->_viewPropertyArray->getViewRedirectCode();
            return true;
        }
        else{
            return false;
        }
    }
    
    public function checkMaintRedirect(){
        $this->log("Entering method ".__METHOD__.". Input params - None");
        /*
         * This method intends to check
         * if there is a maintenance
         * window set up on this view.
         * Yes! it can be done!
         * Returns: true if under maintenance
         * or false is not.
         * 
         * If maintenance window start is set
         * but no stop is set, then the
         * window shall immediately close in
         * "X" hours! - X is defined in 
         * application settings in Mins.
         * If maintenance window start is not
         * set, but maintenance window stop is
         * set, the view will not be under
         * maintenance!
         */
        $currentTimeStamp = time();
        $isMaintenanceSetUp = $this->_viewPropertyArray->getPhaseMaint();
        if($isMaintenanceSetUp){
         $maintStart =  $this->_viewPropertyArray->getPhaseMaintStart(); 
         $maintStop =   $this->_viewPropertyArray->getPhaseMaintStop();
         
            if(!is_null($maintStart)&&!is_null($maintStop)){
           /* Maintenance window is configured
            * correctly. Check for validity
            * of window and set status code = 503
            * if window is valid. Else set status code = 202
            */
               if(($currentTimeStamp>=$maintStart)&&($currentTimeStamp<=$maintStop)){
                   $this->_statusCode = 503;
                   return true;
               }
           }
           else if(!is_null($maintStart)&&is_null($maintStop)){
           /* Maintenance window isn't configured
            * correctly. It starts but doesn't stop
            * Duration 24 hrs or 
            * of window and set status code = 302
            * if window is valid. Else set status code = 202
            */
              $defaultMaintWindow = (MAINTENANCE_DUR / 24)." day";
              /*
               * Calculate the end time stamp with default window
               */
              $maintPeriod = strtotime($defaultMaintWindow,$maintStart);
              if($currentTimeStamp>=$maintPeriod){
                  
                   return false;
              }
              else if($currentTimeStamp<=$maintPeriod){
                  $this->_statusCode = 503;
                   return true;
              }
           }
           else if(is_null($maintStart)&&!is_null($maintStop)){
           /* Maintenance window isn't configured
            * correctly. It doesn't start but stops
            * Wrong setting here :( 
            * Status code remains same
            */
             return false;
           }
           else{
            /* The Maintenance was set
             * But window not defined
             * Wrong setup here.
             */
            
            return false;
        }
           
        }
        else{
            /* No Maintenance
             * Return False
             */
            return false;
        }
    }
    
    public function getForcedRedirectURL(){
        $this->log("Entering method ".__METHOD__.". Input param = none");
        $this->log("Exiting method ".__METHOD__.". Returned ".$this->_viewPropertyArray->getViewRedirectRescURL());
        return $this->_viewPropertyArray->getViewRedirectRescURL();
    }
    
    public function getAuthRedirectURL(){
        $this->log("Entering method ".__METHOD__.". Input param = none");
        $this->log("Exiting method ".__METHOD__.". Returned ".$this->_viewPropertyArray->getAuthViewURL());
        return $this->_viewPropertyArray->getAuthViewURL();
    }
    
    // Helper methods
    public function fileCheck($fileName, $filePath){
        $this->log("Entering method ".__METHOD__.". Input param1 = ".$fileName." param2 = ".$filePath);    
        $flag = file_exists($filePath.$fileName);
        if($flag) $this->log("Exiting method ".__METHOD__.". Returned true.");
        else $this->log("Exiting method ".__METHOD__.". Returned false");
        return $flag;
    }
   
    // Instance Setters    
    
    public function getViewClassPath(){
        $this->log("Entering method ".__METHOD__.". Input param = none");
        $this->log("Exiting method ".__METHOD__.". Returned ".$this->_viewPropertyArray->getViewPath());
        return $this->_viewPropertyArray->getViewPath();
    }
    
    // Instance Getters
    public function getViewPropertyArray() {
        $this->log("Entering method ".__METHOD__.". Input param = none");
        $this->log("Exiting method ".__METHOD__.". Returned _viewPropertyArray");
        return $this->_viewPropertyArray;
    }
    
    public function getStatusCode() {
        $this->log("Entering method ".__METHOD__.". Input param = none");
        $this->log("Exiting method ".__METHOD__.". Returned ".$this->_statusCode);
        return $this->_statusCode;
    }
    
    public function setHTTPStatusCode($statusCode){
        $this->log("Entering method ".__METHOD__.". Input param = ".$statusCode);
        $this->log("Exiting method ".__METHOD__.". Set object property _statusCode = ".$statusCode);
        $this->_statusCode = $statusCode;
    }
    
    public function setViewName($viewName){
        $this->log("Entering method ".__METHOD__.". Input param = ".$viewName);
        $this->log("Exiting method ".__METHOD__.". Setting object property _viewName = ".$viewName);
        $this->_viewName = $viewName;
    }
    
    public function stringToBoolean($var){
        if($var=== "true") return true;
        else if($var === "false") return false;
    }
    
    // Logging function
    public function log($message){
        AnimusLogInfoHandler::logDevInfo($message);
    }
    
    public function __destruct() {
        $this->log("Class destruct ".__CLASS__);
        return;
    }
}