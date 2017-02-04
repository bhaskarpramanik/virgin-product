<?php

/*
**	Restrict direct access
*   @author bhaskarpramanik
*/
defined("_dispatch") or die("Access Denied !");
require_once "AnimusLogInfoHandler.php";
//require_once "AnimusMasterBaseClass.php";

class AnimusURLRouter{
    public $_routePath; // Path of the route deployment XML
    public $_routeFileName; // Name of the route deployment XML
    public $_mappedResourceName; // Name of the deployed resource / view
    public $_mappedResourcePath; // Path of the deployed resource / view
    public $_URLMap;
    public $_HTTPstatusCode;
    //public $_HTTPstatusMessage;
    public $_HTTPstatusType;
    
    /*
     * @methodName - constructor
     * @return - void
     * @methodInputParams - string var routeFileName, string var routeFilePath
     * @description - 
     * 1. Constructor for AnimusURLRoute
     * 2. Sets deployment XML path
     * 3. Sets deployment XML name
     */
    public function __construct($_routeFileName, $_routeFilePath){
        $this->log("Class init ".__CLASS__);
        $this->setDeploymentXMLPath($_routeFilePath);
        $this->setDeploymentXMLName($_routeFileName);
    }
    /*
     * @methodName - createURLMap
     * @return - bool
     * @methodInputParams - void
     * @methodDescription:
     * 1. Check for deployment URL.
     * 2. Set the deployment as SimpleXMLElement object if deployment file exists. Else throw exception.
     * 3. Set the status code as 200.
     * 4. Set status code code as 500
     */
    public function createURLMap(){ //  return void
        $this->log("Entering method ".__METHOD__." Input params - None");
        //Check for the deployment URL here

        $flag = $this->readXML($this->_routeFileName, $this->_routePath);
        
        if($flag){
            $this->log("Returned true.");
            $this->log("Exiting method ".__METHOD__);
             return true;
        }
        else{
            $this->log("Returned false.");
            $this->log("Exiting method ".__METHOD__);
            return false;
        }    
    }
    /*
     *  @methodName - lookupRequestURI
     *  @returns - void
     *  @throwsException - none
     *  @methodInputParams - string var requestedURI
     *  @description - 
     *  1. Does a pattern match for the requestedURI against deployed URLs
     *  2. Sets a statusCode - 202 (OK. Proceed) / 500 (Internal server error) / 404 Page not found.
     *  3. Sets the viewName to object property _mappedResourceName
     */
    public function lookupRequestURI($requestedURI){ // Will need to optimize this function if performance issue seen
        $deployedViewName = null;
        $this->log("Entering method ".__METHOD__);
        $this->log("Entering foreach loop to match requested URI.");
        foreach($this->_URLMap->children()->{"view"} as $deployedRoutes){  
            $this->log("Looping through deployed routes ...");
            $patternToMatch = (String)$deployedRoutes["url-pattern"];
            $requestURIMatch = preg_match($patternToMatch, $requestedURI);
            if($requestURIMatch){
            
            /* If preg_match returns true, then the route is in deployed state
             * Next step is to check, if a view name and view path are present
             * with the entry in the deployed route. If yes, then statusCode
             * remains 202, else it becomes 500. statusMessage changes accordingly
             */
             $deployedViewName = (string)$deployedRoutes["name"];
             
             break;
            }
            else {
            /* If nothing matches, it means the requestedURI has not been
             * deployed. In this case status code becomes 404
             */
             
             continue;
             
            }
        }
        if(!is_null($deployedViewName)){
            //$this->_HTTPstatusCode = 202;
            //$this->_HTTPstatusMessage = "OK. Further processing required.";
            $this->log("Requested URI exists in deployment XML.");
            
            $this->setMappedResourceName($deployedViewName);
            $this->log("Requested viewName to trigger - ".$deployedViewName);
            
            $this->setHTTPStatusCode(202);
        }
        else{
            $this->log("Requested URI doesn't exist in deployment XML.");
            $this->setHTTPStatusCode(404);
        }
        $this->log("Exiting method ".__METHOD__);
    }
    /*
     *  @methodName - readXML
     *  @returns - bool
     *  @throws - (caught)AnimusException
     *  @methodInputParams - 
     *  @description - 
     */
    public function readXML($XMLfileName, $XMLfilePath){
        $this->log("Entering method ".__METHOD__.". Input param1 = ".$XMLfileName." param2 = ".$XMLfilePath);
            if($this->fileCheck($XMLfileName, $XMLfilePath)){
                try { 
                        $simpleXMLObject = new SimpleXMLElement(file_get_contents($XMLfilePath."/".$XMLfileName)); // This throws exception so need to try catch it
                        $this->_URLMap = $simpleXMLObject;
                        $this->log("Deployment XML was successfully read. Returned true");
                        $this->log("Exiting method ".__METHOD__);
                        return true;
                }
                catch(Exception $e){
                        try{
                            throw new AnimusException($e->getMessage());
                        } catch (AnimusException $ex) {
                            $ex->log($ex->getMessage()." - ".__METHOD__." - ".$ex->getLine());
                            $this->log("Deployment XML couldn't be read. Exception was thrown. See exception log. Returned false.");
                            $this->log("Exiting method ".__METHOD__);
                            return false;
                        }
                }
            }
            else{
                $this->log("Deployment XML couldn't be found !");
                return false;
            }
        }
    /*
     *  @methodName - fileCheck
     *  @returns - bool var flag
     *  @throwsException - none
     *  @methodInputParams - string var fileName, string var filePath
     *  @description - Checks if fileName exists at filePath
     */      
    public function fileCheck($fileName, $filePath){
            $this->log("Entering method ".__METHOD__.". Input params - param1 = ".$fileName." param2 = ".$filePath);
            $flag =  file_exists($filePath.$fileName);
            if($flag)$this->log("File found. Returned true.");
            else $this->log("File not found. Returned false.");
            $this->log("Exiting method ".__METHOD__);
            return $flag;
        }
        
    // Getter-Setter Methods
        
    public function getHTTPstatusCode() {
        $this->log("Entering method ".__METHOD__.". Input param - None");
        $this->log("Returned ".$this->_HTTPstatusCode);
        $this->log("Exiting method ".__METHOD__);
        return $this->_HTTPstatusCode;
    }

    public function getHTTPstatusMessage() {
        $this->log("Entering method ".__METHOD__.". Input params - None");
        $this->log("Exiting method ".__METHOD__.". Returned ". $this->_HTTPstatusMessage);
        return $this->_HTTPstatusMessage;
    }

    public function getHTTPstatusType() {
        $this->log("Entering method ".__METHOD__.". Input params - None");
        $this->log("Exiting method ".__METHOD__.". Returned ". $this->_HTTPstatusType);
        return $this->_HTTPstatusType;
    }
    public function getMappedResourceName() {
        $this->log("Entering method ".__METHOD__.". Input params - None");
        $this->log("Exiting method ".__METHOD__.". Returned ". $this->_mappedResourceName);
        return $this->_mappedResourceName;
    }

    public function getMappedResourcePath() {
        $this->log("Entering method ".__METHOD__.". Input params - None");
        $this->log("Exiting method ".__METHOD__.". Returned ". $this->_mappedResourcePath);
        return $this->_mappedResourcePath;
    }
    
    public function setDeploymentXMLName($deploymentXMLName){
        $this->log("Entering method ".__METHOD__.". Input param -".$deploymentXMLName);
        $this->log("Exiting method ".__METHOD__.". Setting object property routeFileName = ".$deploymentXMLName);
        $this->_routeFileName = $deploymentXMLName;
    }
    
    public function getDeploymentXMLName(){
        $this->log("Entering method ".__METHOD__.". Input param - None");
        $this->log("Exiting method ".__METHOD__.". Returned ".$this->_routeFileName);
        return $this->_routeFileName;
    }

    public function getDeploymentXMLPath(){
        $this->log("Entering method ".__METHOD__.". Input param = None");
        $this->log("Exiting method ".__METHOD__.". Returned ".$this->_routePath);
        return $this->_routePath;
    }
    
    public function setDeploymentXMLPath($deploymentXMLPath){
        $this->log("Entering method ".__METHOD__.". Input param = ".$deploymentXMLPath);
        $this->log("Exiting method ".__METHOD__."Setting object property routePath ".$deploymentXMLPath);
        $this->_routePath = $deploymentXMLPath;
    }
    
    public function setHTTPStatusCode($statusCode){
        $this->log("Entering method ".__METHOD__.". Input param = ".$statusCode);
        $this->log("Exiting method".__METHOD__.". Setting object property _statusCode = ".$statusCode);
        $this->_HTTPstatusCode = $statusCode;
    }
    
    public function setMappedResourceName($mappedResourceName){
        $this->log("Entering method ".__METHOD__.". Input param = ".$mappedResourceName);
        $this->log("Exiting method ".__METHOD__.". Setting object property _mappedResourceName = ".$mappedResourceName);
        $this->_mappedResourceName = $mappedResourceName;
    }

    
    public function setMappedResourcePath($mappedResourcePath){
        $this->log("Entering method ".__METHOD__.". Input param = ".$mappedResourcePath);
        $this->log("Exiting method ".__METHOD__.". Setting object property _mappedResourcePath = ".$mappedResourcePath);
        $this->_mappedResourcePath = $mappedResourcePath;
    }
    // Logging method
    public function log($message){
        AnimusLogInfoHandler::logDevInfo($message);
    }
    
    /*
     *  @methodName - destructor
     *  @returns - void
     *  @throwsException - none
     *  @methodInputParams - none
     *  @description - 
     *  1. Cleanup method called during teardown.
     */
    public function __destruct() {
        $this->log("Class destruct ".__CLASS__);
    }
}
?>
