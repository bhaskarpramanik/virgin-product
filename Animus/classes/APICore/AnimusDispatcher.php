<?php
/*
* @author bhaskarpramanik
**	Restrict direct access
*/
defined("_dispatch") or die("Access Denied !");

/*
 * Modified version of the dispatcher.
 */
require_once "AnimusURLRouter.php";
require_once "AnimusViewPropertyHandler.php";

/*
 * Import log class
 */
require_once "AnimusLogInfoHandler.php";

// import all the redirectHandlers
require_once "AnimusAuthRedirect.php";
require_once "AnimusErrorRedirect.php";
require_once "AnimusMaintRedirect.php";
require_once "AnimusSecurityRedirect.php";
require_once "AnimusPermanentRedirect.php";
require_once "AnimusTemporaryRedirect.php";
require_once "AnimusTempErrorRedirect.php";

// Import RedirectionView
require_once 'AnimusRedirectionView.php';

class AnimusDispatcher{
    private $_lookupURL;
    private $_statusCode;
    private $_httpProtocolType;
    private $_mappedResourceName;
    private $_mappedResourcePropertyArray;
    private $_viewProperties;
    private $_viewPropertyHandler;
    private $_loggedInUser;
    private $_redirectionHandler;
    private $_redirectURL;
    private $_isReRouteRequest = false;
    
    /*
     *  @methodName - constructor
     *  @returns - void
     *  @throwsException - none
     *  @methodInputParams - string var lookupURL
     *  @description - 
     *  1. Initializes the class.
     *  2. Sets instance variable _lookupURL
     */
    public function __construct($lookupURL){
        $this->log("Class init ".__CLASS__);
        $this->setLookupURL($lookupURL);
    }
    
    /*
     *  @methodName - routeInit
     *  @returns - void
     *  @throwsException - none
     *  @methodInputParams - none
     *  @description - 
     *  1. Using instance of AnimusURLRouter, determines if a route is deployed or not.
     *  2. Sets object property _statusCode = 500, in case deploymentXML couldn't be read.
     */
    public function routeInit(){
         /* Instantiate the AnimusURLRouter class.
          * It does the heavy lifting of finding the deployment
          * and validating the same.
          * ROUTEDEPLOYMENTXML and ROUTEDEPLOYMENT are defined in application-settings.xml
          */
        $this->log("Entering method ".__METHOD__." Input params - None"); 
        $URLRouter = new AnimusURLRouter(ROUTEDEPLOYMENTXML, DOMROOT.ROUTEDEPLOYMENTXMLPATH."/");
         /*
          * Create the URLMap and collect the statusCode
          */            
         $URLMapFlag = $URLRouter ->createURLMap();
         /* If the URLRouter reports that the deployment XML is in place
          * Then its time to lookup if the requested URL is deployed or not
          * If statusCode = 202, then it is OK to proceed further
          * If statusCode = 500, the deployment XML was not found
          */
         
         if($URLMapFlag){
         /*  
          *  Next task for the URLRouter is to figure out if
          *  the requested URL is deployed.
          */
          $URLRouter -> lookupRequestURI($this->_lookupURL);
          /*
           * Check the status code to determine the result of the lookup function
           */
          $this->_statusCode = $URLRouter->getHTTPstatusCode();
            if($this->_statusCode == 202){
              /*
               * Response available
               */
              $this->_mappedResourceName = $URLRouter->getMappedResourceName();
            }
            else if($this->_statusCode == 404){
                /*
                 * Requested URL not programmed
                 * Do some fact-finding here !
                 */
                
            }
        }
        else{
            $this->_statusCode = 500;
        }
        $this->log("Exiting method ".__METHOD__);
    }
    
    /*
     *  @methodName - readViewProperty
     *  @returns - void
     *  @throwsException - none
     *  @methodInputParams - string var viewName
     *  @description - 
     *  1. Loads the view properties instance of AnimusViewProperty
     */
    public function readViewProperty($viewName){
        
        /*
         * Create an instance of the view property reader
         * It should read the property INI file of the view in question
         */
        $this->log("Entering method ".__METHOD__.". Input param = ".$viewName);
        $this->_viewPropertyHandler = new AnimusViewPropertyHandler($viewName);
        
        /*
         * In case the XML file in question is present, it has to be read
         * and properties have to be loaded in property array.
         * Returns true if everything is ok.
         * Else the method throws an exception and returns a false and logs
         * an exception in the log.
         */
        
        if(!is_null($this->_viewPropertyHandler->resolveViewProperties())){
            $this->_statusCode = $this->_viewPropertyHandler->getStatusCode();
            $this->_mappedResourcePropertyArray = $this->_viewPropertyHandler->getViewPropertyArray();
        }
        else{
            /*
             * An exception has been thrown and a log entry has been
             * created. The status code should now change to 5xx,
             * signalling internal error.
             */
            $this->_statusCode = $this->_viewPropertyHandler->getStatusCode();
        }
        $this->log("Exiting method ".__METHOD__);
    }
    /*
     *  @methodName - resolveRedirection
     *  @returns - bool
     *  @throwsException - none
     *  @methodInputParams - none
     *  @description - 
     *  1. Resolves if re-direction is required based on properties of configured view.
     */
    public function resolveRedirection(){
        $this->log("Entering method ".__METHOD__.". Input params = none");
        /*
         * This method intends to resolve
         * all types of redirections
         * applicable on the view to
         * render.
         * 
         * Before this method finishes
         * it triggers desired redirection
         * handling class as required.
         * 
         * Order of Priority
         * PRIO_1 >> Reroute requests are on top !
         * PRIO_2 >> Forced redirection - Overriding Redirect (Can be temporary or permanent)
         * PRIO_3 >> Maintenance Redirect Override
         * PRIO_4 >> Authorization Redirect
         */
        
        $isRedirectOverridden = $this->_viewPropertyHandler->getViewPropertyArray()->getViewRedirected();
         
        $isMaintRequired = $this->_viewPropertyHandler->getViewPropertyArray()->getPhaseMaint();
        
        $isAuthRequired = $this->_viewPropertyHandler->getViewPropertyArray()->getAuthRequired();
        
        $isReRouteRequired = $this->_isReRouteRequest;
        
        if($isRedirectOverridden){
            $isRedirected = $this->resolveForcedRedirect();
            if($isRedirected){
                unset($this->_viewPropertyHandler);
                $this->log(__METHOD__." - Forced redirect was triggered.");
                $this->log("Exiting method ".__METHOD__.". Returned true.");
                return $isRedirected;
            }
        }
        else if($isMaintRequired){
            $isRedirected = $this->resolveMaintRedirect();
            if($isRedirected){
                unset($this->_viewPropertyHandler);
                $this->log(__METHOD__." - Maintenance redirect was triggered.");
                $this->log("Exiting method ".__METHOD__.". Returned true.");
                return $isRedirected;
            }
        }
        else if($isAuthRequired){
            $isRedirected = $this->resolveAuthRedirect($this->_loggedInUser);
            if($isRedirected){
                unset($this->_viewPropertyHandler);
                $this->log(__METHOD__." - Auth redirect was triggered.");
                $this->log("Exiting method ".__METHOD__.". Returned true.");
                return $isRedirected;
            }
        }
        else if($isReRouteRequired){
            $isRedirected = $this->resolveErrorRedirect();
            AnimusLogInfoHandler::logDeploymentError("Deployment error occured while processing URL ".$this->lookUpURL);
            unset($this->_viewPropertyHandler);
            $this->log(__METHOD__." - redirect was triggered.");
            $this->log("Exiting method ".__METHOD__.". Returned true.");
            return $isRedirected;
        }

            $isRedirected = false;
            $this->log(__METHOD__." - No redirection.");
            $this->log("Exiting method ".__METHOD__.". Returned false.");
            return $isRedirected;
    }
    
    public function resolveAuthRedirect(AnimusUser $existingUserInfo){
        $this->log("Entering method ".__METHOD__.". Input params1 = InstanceOf AnimusUser");
        $hasAuthRedirect = $this->_viewPropertyHandler->checkAuthRedirect($existingUserInfo);
        if($hasAuthRedirect){
            /*
             * Return 401 or 403 as applicable
             */      
            $this->_statusCode = $this->_viewPropertyHandler->getStatusCode();
            $this->_redirectURL = $this->_viewPropertyHandler->getAuthRedirectURL();
            $this->log("Exiting method ".__METHOD__.". Returned true.");
            return true;
        }
        else {
            $this->log("Exiting method ".__METHOD__.". Returned false.");
            return false;
        }    
    }
    
    public function resolveForcedRedirect(){
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $hasForcedRedirect = $this->_viewPropertyHandler->checkforcedRedirect();
        if($hasForcedRedirect){
            $this->_statusCode = $this->_viewPropertyHandler->getStatusCode();
            /*
             * Handle the case of a manual redirect
             * 301 / 302 as applicable
             */
            $this->_redirectURL = $this->_viewPropertyHandler->getForcedRedirectURL();
            $this->log(__METHOD__." Redirecting with status code = ".$this->_statusCode);
            $this->log("Exiting method ".__METHOD__.". Returned true.");
            return true;
        }
        else{
            $this->log("Exiting method ".__METHOD__.". Returned false.");
            return false;
        }
    }
    
    public function resolveMaintRedirect(){
        /*  
         *  Case 1: $statusCode = 503
         */
        $this->log("Entering method ".__METHOD__.". Input params = none.");
        $hasMaintRedirect = $this->_viewPropertyHandler->checkMaintRedirect();
        if($hasMaintRedirect){
            $this->_statusCode = $this->_viewPropertyHandler->getStatusCode();
            $this->log("Redirecting with status code = ".$this->_statusCode);
            $this->log("Exiting method ".__METHOD__.". Returned true.");
            return true;        
        }
        /*  
         *  Case 2: $statusCode = 202
         */
        else{
            $this->_statusCode = $this->_viewPropertyHandler->getStatusCode();
            $this->log("Redirecting with status code = ".$this->_statusCode);
            $this->log("Exiting method ".__METHOD__.". Returned false.");
            return false;
        }
    }
    
    public function resolveErrorRedirect(){
        /*
         * Case Generic: $statusCode = 500
         * return true;
         */
        $this->_statusCode = 500;
        $this->log("Entering method ".__METHOD__.". Input params = none.");
        $this->log("Redirecting with status code = ".$this->_statusCode);
        $this->log("Exiting method ".__METHOD__.". Returned true.");
        return true;
    }
    
    public function getRedirectHandler(){
        /*
         * Return redirect handler
         */
        $this->log("Entering method ".__METHOD__.". Input params = none");
        switch ($this->_statusCode){
            case 301: $redirectHandler =  "AnimusPermanentRedirect";
                break;
            case 302: $redirectHandler =  "AnimusTemporaryRedirect";
                break;
            case 401: $redirectHandler =  "AnimusAuthRedirect";
                break;
            case 403: $redirectHandler =  "AnimusAuthRedirect";
                break;
            case 404: $redirectHandler =  "AnimusErrorRedirect";
                break;
            case 500; $redirectHandler =  "AnimusTempErrorRedirect";
                break;
            case 503: $redirectHandler =  "AnimusMaintRedirect";
                break;
        }
        $this->log("Exiting method ".__METHOD__.". Returning = ".$redirectHandler);
        return new $redirectHandler;
    }
    
    public function getRedirectLocation(){
        $this->log("Entering method ".__METHOD__.". Input params = none");
        switch ($this->_statusCode){
           /*
            * The case of Forced (Permanent) redirect
            * Return redirectURL if not null else return ERROR_500
            * Redirect incorrectly configured
            */
            case 301: $redirectURL =  !is_null($this->_redirectURL)?$this->_redirectURL:URL_500;
                break;
           /*
            * The case of Forced (Temporary) redirect
            * Return redirectURL if not null else return ERROR_500
            * Redirect incorrectly configured
            */
            case 302: $redirectURL =  !is_null($this->_redirectURL)?$this->_redirectURL:URL_500;
                break;
           /*
            * The case of Auth (Un-authenticated) redirect
            */
            case 401: $redirectURL =  !is_null($this->_redirectURL)?$this->_redirectURL:URL_401;
                break;
           /*
            * The case of Auth (Un-authorized) redirect
            */
            case 403: $redirectURL =  !is_null($this->_redirectURL)?$this->_redirectURL:URL_403;
                break;
           /*
            * The case of unavailable route
            */
            case 404: $redirectURL =  URL_404;
                break;
           /*
            * The case of Maintenance redirect
            */
            case 503: $redirectURL =  URL_503;
                break;
            /*
             * The case of generic server error redirect
             */
            case 500; $redirectURL =  URL_500;
                break;
        }
        $this->log("Exiting method ".__METHOD__.". Returned = ".$redirectURL);
        return $redirectURL;
    }
    
    /*
     * Function to process a view to redirect succesfully
     */
    
    public function executeErrorRedirection(){
        $this->log("Entering method ".__METHOD__.". Input params = none");
        // Need an instance of AnimusRedirectionView
        $redirectionView = new AnimusRedirectionView();
        $AnimusHeaderInfoHandler = new AnimusHeaderInfoHandler();
        /*
         * Get all the status codes
         */
        $statusCodes = $this->_redirectionHandler->getRedirectHeaderCode();        
        /*
         * Create HTTP headers for the status codes
         */
        foreach($statusCodes as $statusCode){
            $AnimusHeaderInfoHandler->generateStatusHeaders($this->_httpProtocolType, $statusCode);
        }
        /*
         * Create HTTP header for redirect location
         */
        $AnimusHeaderInfoHandler->setLocationPath($this->_redirectionHandler->getRedirectLocation());

        $AnimusHeaderInfoHandler->generateLocationHeader($this->_httpProtocolType, $this->_redirectionHandler->getRedirectLocationFlag());
        
        $headerArray = $AnimusHeaderInfoHandler->getHeaderArray();

        /*
         * Insert the generated headers in AnimusRedirectedView
         */
        $redirectionView->setHeaders($headerArray);
        $this->log("Exiting method ".__METHOD__);
        return $redirectionView;
    }
    
    // Setters
    public function setLoggedInUser(AnimusUser $loggedInUser) {
        $this->log("Entering method ".__METHOD__.". Input params = Instance of AnimusSession");
        $this->log("Exiting method ".__METHOD__.". Returned = InstanceOf AnimusRedirectHandler");
        $this->_loggedInUser = $loggedInUser;
        return;
    }
    
    public function setRedirectHandler(AnimusRedirect $redirectionHandler) {
        $this->log("Entering method ".__METHOD__.". Input params = Instance of AnimusRedirectHandler");
        $this->log("Exiting method ".__METHOD__.". Returned = InstanceOf AnimusRedirectHandler");
        $this->_redirectionHandler = $redirectionHandler;
    }
    
    public function getProcessedRedirect(){
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__.". Returned = InstanceOf AnimusRedirectHandler");
        return $this->_redirectionHandler;
    }
    
    /* In case re-routing is required due to an error
     * at a later stage, after giving out 200 / 202 initially
     * Set this flag to tell the dispatcher its a re-route
     */
    
    public function setReRoute(){
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__.". Setting object property _isReRouteRequest = true");
        $this->_isReRouteRequest = true;
    }
    
    /*
     * Setting the status code here.
     * This is required to change the status code
     * if the request processing fails at a later
     * time in the cycle.
     * @bhaskarpramanik - 24th September 2016 17:39 EDT
     */
    public function updateStatusCode($statusCode){
        $this->log("Entering method ".__METHOD__.". Input params = ".$statusCode);
        $this->log("Exiting method ".__METHOD__.". Setting object property _statusCode = ".$statusCode);
        $this->_statusCode = $statusCode;
    }
    // Getters
    public function getStatusCode() {
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__.". Returned = ".$this->_statusCode);
        return $this->_statusCode;
    }
    
    public function getViewProperties() {
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__);
        return $this->_viewProperties;
    }

    public function getMappedResourceName() {
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__.". Returned = ".$this->_mappedResourceName);
        return $this->_mappedResourceName;
    }

    public function getMappedResourcePropertyArray() {
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__.". Returned = InstanceOf AnimusViewPropertyArray");
        return $this->_mappedResourcePropertyArray;
    }
    
    public function getLoggedInUser() {
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__.". Returned = ".$this->_loggedInUser || "none");
        return $this->_loggedInUser;
    }
    
    public function getRedirectURL() {
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__.". Returned = ".$this->_redirectURL || "none");
        return $this->_redirectURL;
    }

    public function setRedirectURL($redirectURL) {
        $this->log("Entering method ".__METHOD__.". Input params = ".$redirectURL);
        $this->log("Exiting method ".__METHOD__.". Setting object property _redirectURL = ".$redirectURL);
        $this->_redirectURL = $redirectURL;
        return;
    }
    
    public function setHttpProtocolType($protocolType){
        $this->log("Entering method ".__METHOD__.". Input params = ".$protocolType);
        $this->log("Exiting method ".__METHOD__.". Setting object property _httpProtocolType = ".$protocolType);
        $this->_httpProtocolType = $protocolType;
        return;
    }
    
    public function getHttpProtocolType(){
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method .".__METHOD__.". Returned ".$this->_httpProtocolType);
        return $this->_httpProtocolType;
    }
    
    public function setLookupURL($lookupURL){
        $this->log("Entering method ".__METHOD__." Input param = ".$lookupURL);
        $this->log("Exiting method ".__METHOD__.". Setting object property _lookupURL = ".$lookupURL);
        $this->_lookupURL = $lookupURL;
        return;
    }
    
    // Logging method
    public function log($message){
        AnimusLogInfoHandler::logDevInfo($message);
        return;
    }
    
    public function __destruct() {
        $this->log("Class destruct ".__CLASS__);
        return;
    }

}