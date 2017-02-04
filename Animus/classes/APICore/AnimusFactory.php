<?php
/**
 * Description of AnimusFactory
 *
 * @author bhaskarpramanik
 * AnimusFactory is the principal class of the API, which will provide access to coreAPI classes 
 */

require_once APICORE.'/AnimusSession.php';
require_once APICORE.'/AnimusDispatcher.php';
require_once APICORE.'/AnimusMVCD.php';
require_once APICORE.'/AnimusAssetHandler.php';
require_once APICORE.'/AnimusHeaderInfoHandler.php';
require_once APICORE.'/AnimusClassloader.php';
require_once APICORE.'/AnimusLogInfoHandler.php';
require_once APICORE.'/AnimusRequest.php';
require_once APICORE.'/AnimusResponse.php';

class AnimusFactory{
    
    private $_AnimusRequest;
    private $_AnimusResponse;
    private $_AnimusDispatcher;
    private $_AnimusMVCD;

    public function __construct() {
        $this->log("Class init ".__CLASS__);
        $this -> _AnimusRequest = new AnimusRequest();
        $this -> _AnimusResponse = new AnimusResponse();
        $this->_AnimusMVCD = new AnimusMVCD();
        return;
    }
    public function route(){
        /*
         * Populate the request object with
         * session.
         */
        $this->log("Entering method ".__METHOD__.". Input param = none");
        $this->injectSessionInRequest();
        /*
         * New constructor of the dispatcher requires the called URL
         */
        $this -> _AnimusDispatcher = new AnimusDispatcher($this->_AnimusRequest->getHttpRequestURI());
        $this->_AnimusDispatcher->setHttpProtocolType($this->_AnimusRequest->getHTTPProtocolType());
        /*
         * Start processing the route
         */
        $this->_AnimusDispatcher->routeInit();
        $statusCode = $this->_AnimusDispatcher->getStatusCode();
        if($statusCode == 202){
            $this->log(__METHOD__." - Route deployment OK - returned status = ".$statusCode);
            /*
             * This part handles the scenarios
             * when the URL being routed is 
             * configured perfectly
             */
            $this->log(__METHOD__." - Secondary routing - is begining. ");
            $statusCode = $this->processDeployedRoute();
            if($statusCode == 200){
                // Everything OK. Routing finished!
                $this->log(__METHOD__." - Secondary routing OK - processing further");
                $this->log(__METHOD__." - MVCD is already populated during routing");
                return;
            }
            /*
             * Handling redirections here
             */
            else{
                $this->log(__METHOD__." - Secondary routing resulted in new status code - status Code = ".$statusCode);
                $this->log(__METHOD__." - Processing further");
                $this->processError($statusCode);
                $view = $this->processErrorView();
                $this->_AnimusMVCD->setView($view);
            }            
        }
        /*
         * Handling unrecoverable errors here
         */
        else if($statusCode == 500){
            $this->log(__METHOD__." - Secondary routing resulted in unrecoverable error, status code changed - status Code = ".$statusCode);
            $this->processError($statusCode, true);
            $view = $this->processErrorView(); // For all status other than 200 redirectedView is returned
            $this->_AnimusMVCD->setView($view);
        }
        else {
            /* Vanilla 404
             * No route is planned for this incoming request !
             */
            $this->log(__METHOD__." - Route deployment NOK - requested route not planned - returned status = ".$statusCode);
            $this->processError($statusCode);
            $view = $this->processErrorView(); // For all status other than 200 redirectedView is returned
            $this->_AnimusMVCD->setView($view);
        }
        $this->log("Exiting method ".__METHOD__);
    }
    
    // Dispatch - Send the output to the browser
    
    public function dispatch(){
        $this->log("Entering method ".__METHOD__);
        // Handle dispatch
        $view = $this->_AnimusMVCD->getView();
        $this->log("Exiting method ".__METHOD__);
        $view->output();
        
    }
    
    public function processDeployedRoute(){
            $this->log("Entering method ".__METHOD__.". Input params = none");
            /*
             * Trigger property read
             */
            $this->_AnimusDispatcher->readViewProperty($this->_AnimusDispatcher->getMappedResourceName());
            /*
             * Property read OK
             */
            if($this->_AnimusDispatcher->getStatusCode() == 202){
                /*
                 * Check with Auth
                 */
                $AnimusSession = $this->_AnimusRequest->getSession();
                $existingUserInfo = $AnimusSession->getUserInfo();
                /*
                 * Set the existing user info
                 * from session var in the
                 * dispatcher
                 */
                $this->_AnimusDispatcher->setLoggedInUser($existingUserInfo);
                /*
                 * Check for redirection setup
                 */
                $redirection = $this->_AnimusDispatcher->resolveRedirection();
                /* 
                 * If redirection is required
                 */
                if($redirection == true){
                    /*
                     * Get a redirect handler
                     */
                    $this->log(__METHOD__." - Redirection is true!");
                    $redirectHandler = $this->_AnimusDispatcher->getRedirectHandler();
                    /*
                     * Set the location to redirect
                     * Set the cause HTTP code
                     * Set the URL which was called
                     */
                    $redirectHandler->setRedirectLocation($this->_AnimusDispatcher->getRedirectLocation());
                    
                    $redirectHandler->setCalledURL($this->_AnimusRequest->getHttpRequestURI());
                    /*
                     * Set this redirectHandler back in the dispatcher
                     */
                    $this->_AnimusDispatcher->setRedirectHandler($redirectHandler);
                    /*
                     * Also get the causeCode for this re-direction
                     */
                    $statusCode = $this->_AnimusDispatcher->getStatusCode();
                    $this->log(__METHOD__." - Redirecting with status code = ".$statusCode);
                }
                else{
                    /*
                    * Redirection is not required
                    * Proceed further
                    * Set up a status code to highlight
                    * the status of this request past this point.
                    */
                     $statusCode = 200; // Everything OK till this point
                    /* 
                     * Starting to process the request
                     * as per view properties
                     * 1. Check if view is dynamic, if yes,
                     * then load the components and models.
                     * 
                     * 2. If the view is static, then load the view.
                     */
                     $this->log(__METHOD__." - Secondary routing ended.");
                     $this->log(__METHOD__." - Populating MVCD");
                    $statusCode = $this->populateMVCD($this->_AnimusDispatcher->getMappedResourceName(), $this->_AnimusDispatcher->getMappedResourcePropertyArray());

                }
            }
            else{
                $this->log(__METHOD__." - Requested route is not deployed!");
                $statusCode = $this->_AnimusDispatcher->getStatusCode();
            }
            $this->log("Exiting method ".__METHOD__.". Returned = ".$statusCode);
            return $statusCode;
    }
    
    /*
     * Push the view / components / models - 200 OK case
     */
    public function populateMVCD($viewName, $viewPropertyArray){
        $this->log("Entering method ".__METHOD__);
        // Get instance of MVCD
        $resourcesArray = $this->_AnimusMVCD;
        $this->log(__METHOD__." Setting MVCD to instance.");

        /*
         * Check if the view is static / dynamic
         */
        if($viewPropertyArray->getViewType() == "static") $isViewDynamic = false;
        else if($viewPropertyArray->getViewType() == "dynamic") $isViewDynamic = true;             
        
        // if isViewDynamic then try to load the dependencies   
        if($isViewDynamic){
            // Getting the models to be injected
            $mappedModels = $viewPropertyArray->getMappedModels();
            // Getting the component to be injected
            $mappedComponents = $viewPropertyArray->getMappedComponent();
            //Getting the dataset to be injected
            $mappedDatasets = $viewPropertyArray->getMappedDataset();
            // Invoke models
            $statusCode = $this->invokeModels($mappedModels);
            // Invoke datasets
            $statusCode = $this->invokeDatasets($mappedDatasets);
            // Invoke view
            try{
                $statusCode = $this->invokeView($viewName); // Throws exception
            } catch (AnimusException $ex) {
                $ex->log();
                //Update status code for exception
                $statusCode = 500;
            }
            // Invoke Component(s)
            try{
                $statusCode = $this->invokeComponent($mappedComponents); // throws exception
            }
            catch (AnimusException $ex) {
                $ex->log();
                //Update status code for exception
                $statusCode = 500;
            }
        }
        else{ 
            // Static page loading is getting handled
            // Hence view to be set is StaticView
            // The static which is page requested in the browser
            $HTMLName = $this->_AnimusRequest->getURIEndSegment();
            $statusCode = $this->invokeHTML($HTMLName);
            
            // Invoke view
            //$viewName = "StaticView";
            try{
                $statusCode = $this->invokeView($viewName); // Throws exception
            } catch (AnimusException $ex) {
                $ex->log();
                //Update status code for exception
                $statusCode = 500;
            }
            //Dirty fix
            //Inject static content in the view.
            $view = $this->_AnimusMVCD->getView();
            $htmlContent = $this->_AnimusMVCD->getStaticContent();
            $view->setPageContent($htmlContent);
        }
        $this->log("Exiting method ".__METHOD__);
        return $statusCode;
    }
    
    /*
     * Error handling function during routing
     * Always save the redirectHandler back to Dispatcher
     * Return Bool
     */
    public function processError($statusCode, $isReRouteRequest = false){
        /*
         * Error code is available
         * Get the ErrorRedirectHandler
         */
        //Update status code
        $this->log("Entering method ".__METHOD__.". Input param1 = ".$statusCode." param2 = ".$isReRouteRequest);
        $this->_AnimusDispatcher->updateStatusCode($statusCode);
        
        // Set the re-route flag for requesting a re-route
        if($isReRouteRequest){
            $this->_AnimusDispatcher->setReRoute();
        }
        
        $redirectHandler = $this->_AnimusDispatcher->getRedirectHandler();
        /*
         * Set the redirection code
         */
        $redirectHandler->setCauseCode($statusCode);
        /*
         * Redirection = true / false is set in application settings for 404 and 500
         */
        $redirectHandler->setRedirectLocationFlag();    // Verify functionality here
        /*
         * Stack the header code
         */
        $redirectHandler->stackHTTPHeaders();
        /*
         * Set the location to redirect
         */
        $redirectHandler->setRedirectLocation($this->_AnimusDispatcher->getRedirectLocation());
        /*
         * Set the last requested URL
         */
        $redirectHandler->setCalledURL($this->_AnimusRequest->getHttpRequestURI());
        /*
         * Set this redirectHandler back to Dispatcher
         */
        $this->_AnimusDispatcher->setRedirectHandler($redirectHandler);

        $this->log("Exiting method ".__METHOD__);
        
    }
    
    public function processErrorView(){
        /*
         * Process the view after redirection.
         * Use the redirectHanlder stored inside Dispatcher
         */
        $this->log("Entering Method ".__METHOD__.". Input param = none");
        $this->log("Exiting Method ".__METHOD__.".");
        return $this->_AnimusDispatcher->executeErrorRedirection();
    }
    
    public function invokeComponent($mappedComponents){   // Mandatory asset for dynamic view type | throws AnimusException
        $this->log("Entering method ".__METHOD__);
        $assetHandler = new AnimusAssetHandler();
        if(!(bool)strlen($mappedComponents == 0)){
            throw new AnimusException("No AnimusComponent(s) have been mapped for this view - ".$this->_AnimusDispatcher->getMappedResourceName());
        }
        else{
            if(strpos($mappedComponents, ",") === true){ // When multiple components are planned
                $componentArray = explode(",",$mappedComponents);
                foreach($componentArray as$className){
                    try{
                        $classPath = $assetHandler->loadComponent($className); // This method throws exception
                        $classPath = COMPONENTS.$classPath;
                        $this->_AnimusMVCD->setComponent($className, AnimusClassLoader::loadClass($className, $classPath)); // Throws exception
                        $statusCode = 200;
                    } catch (AnimusException $ex) {
                        $ex->log();
                        $statusCode = 500;
                    }
                }
            }
            else{   // When single component is planned
                try{
                        $classPath = $assetHandler->loadComponent($mappedComponents); // This method throws exception
                        $classPath = COMPONENTS.$classPath;
                        $this->_AnimusMVCD->setComponent($mappedComponents, AnimusClassLoader::loadClass($mappedComponents, $classPath)); // Throws exception
                        $statusCode = 200;
                    } catch (AnimusException $ex) {
                        $ex->log();
                        $statusCode = 500;
                    }
            }
        }
        $this->log("Exiting method ".__METHOD__." returning statusCode =".$statusCode);
        unset($assetHandler);
        return $statusCode;
    }
    
    public function invokeModels($mappedModels){  // Optional asset for dynamic view type | write a debug entry about no model config.
        $this->log("Entering method ".__METHOD__);
        $assetHandler = new AnimusAssetHandler();
        if((bool)strlen($mappedModels) == 0){
            // No mapped models were provided by programmer - OK to proceed
            AnimusLogInfoHandler::logDevWarning("No AnimusModels have been mapped for this view - ".$this->_AnimusDispatcher->getMappedResourceName());
            $statusCode = 200;
        }
        else{
            if(strpos($mappedModels, ",") === true){ // When multiple models have been planned
                $modelArray = explode(",", $mappedModels);
                foreach($modelArray as $className){
                    try{
                        $classPath = $assetHandler->loadModel($className);
                        $classPath = MODELS.$classPath;
                        $this->_AnimusMVCD->setModel($className, AnimusClassLoader::loadClass($className, $classPath));
                        $statusCode = 200;
                    } catch (AnimusException $ex) {
                            $ex->log();
                            $statusCode = 500;
                    }
                }
            }
            else{   // When only a single model has been planned
                try{
                        $classPath = $assetHandler->loadModel($mappedModels);
                        $classPath = MODELS.$classPath;
                        $this->_AnimusMVCD->setModel($mappedModels, AnimusClassLoader::loadClass($mappedModels, $classPath));
                        $statusCode = 200;
                    } catch (AnimusException $ex) {
                            $ex->log();
                            $statusCode = 500;
                    }
            }
        }
        $this->log("Exiting method ".__METHOD__." returning statusCode =".$statusCode);
        unset($assetHandler);
        return $statusCode;
    }
    
    public function invokeDatasets($mappedDatasets){  // Return status code | write a debug entry about no dataset config.
        $this->log("Entering method ".__METHOD__);
        $assetHandler = new AnimusAssetHandler();
        if((bool)strlen($mappedDatasets) == 0){
            // No mapped datasets provided by the programmer - OK to proceed
            AnimusLogInfoHandler::logDevWarning("No AnimusDatasets have been mapped for this view - ".$this->_AnimusDispatcher->getMappedResourceName());
            $statusCode = 200;
        }
        else{
            if(strpos($mappedDatasets, ",") === true){
                $datasetArray = explode(",", $mappedDatasets);
                foreach($datasetArray as $className){
                    //Invoke the class using class loader and push it to MVCD
                    try{
                        $classPath = $assetHandler->loadDataset($className);
                        $classPath = DATASETS.$classPath;
                        $this->_AnimusMVCD->setDataset($className, AnimusClassLoader::loadClass($className, $classPath));
                        $statusCode = 200;
                    }
                    catch(AnimusException $ex){
                        $ex->log();
                        $statusCode = 500;
                    }
                }
            }
            else{   // When only a single model has been planned
                try{
                        $classPath = $assetHandler->loadModel($mappedDatasets);
                        $classPath = MODELS.$classPath;
                        $this->_AnimusMVCD->setModel($mappedDatasets, AnimusClassLoader::loadClass($mappedDatasets, $classPath));
                        $statusCode = 200;
                    } catch (AnimusException $ex) {
                            $ex->log();
                            $statusCode = 500;
                    }
            }
        }
        $this->log("Exiting method ".__METHOD__." returning statusCode =".$statusCode);
        unset($assetHandler);
        return $statusCode;
    }
    
    public function invokeView($mappedView){   // Throws AnimusException
        $this->log("Entering method ".__METHOD__);
        $assetHandler = new AnimusAssetHandler();
        try{
            $classPath = $assetHandler->loadView($mappedView);
            $classPath = VIEWS.$classPath;
            $this->_AnimusMVCD->setView(AnimusClassLoader::loadClass($mappedView, $classPath));
            $statusCode = 200;
            
        } catch (AnimusException $ex) {
            $ex->log();
            $statusCode = 500;
        }
        $this->log("Exiting method ".__METHOD__." returning statusCode =".$statusCode);
        unset($assetHandler);
        return $statusCode;
    }
    
    public function invokeHTML($HTMLName){ // Throws Exception
        $this->log("Entering method ".__METHOD__.". Loading ".$HTMLName." for this view." );
        $assetHandler = new AnimusAssetHandler();
        try{
            $htmlPath = $assetHandler->loadHTML($HTMLName);
            $htmlPath = HTML.$htmlPath;
            $this->_AnimusMVCD->setStaticContent(file_get_contents($htmlPath));
            $statusCode = 200;
        } catch (Exception $ex) {
            $ex->log();
            $statusCode = 500;
        }
        $this->log("Exiting method ".__METHOD__." returning statusCode =".$statusCode);
        unset($assetHandler);
        return $statusCode;
    }
    
    public function startComponent(){
        $flag = $this->_AnimusMVC -> runComponent();
        if($flag){
            $this ->handleSessionOnResponse();
        }
        $this ->injectDataInView();
        return;
    }
    public function handleSessionOnResponse(){
        $response_validity = $this -> _AnimusResponse ->isValid();
        //Handle the response after initiating a fresh session
        if($response_validity){// Response is valid
            $session_instance = $this -> _AnimusResponse -> getSession();
            $user_info = $session_instance -> getUserInfo();
            if(!is_null($user_info)){ // If user info is not null, then requesting a new session
                $session_instance ->manageExistingSession();
            }
            else {
                // If user info is null, then close the session, since it is a logout request
                $session_instance ->closeSession ();
            }
           return;
        }
    }
    
    public function injectSessionInRequest(){
        $session_instance = new AnimusSession();
        $existing_session = $session_instance ->getSession();
        if(!is_null($existing_session)){
            $this -> _AnimusRequest ->setSession ($existing_session);
        }
        else{
            $this -> _AnimusRequest ->setSession ($session_instance);
        }
        return true;
    }
    
    public function injectDataInView(){
        $_view = $this -> _AnimusResponse -> getView();
        $_model = $this -> _AnimusResponse ->getModel();
        if(!is_null($_model)){ // This means that the component is not configured with a model
            $_view_data = $_model -> getViewData();
            $_view -> setViewData($_view_data);
        }
        else {};
    }
    
    public function getNewSession(){
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__.". Returned InstanceOf AnimusSession.");
        return new AnimusSession();
    }
    
    public  function setDispatcher(AnimusDispatcher $Dispatcher){
        $this->log("Entering method ".__METHOD__.". Input params = InstanceOf AnimuseResponse");
        $this->log("Exiting method ".__METHOD__.". Setting object property _AnimusDispatcher = AnimusDispatcher");
        $this->_AnimusDispatcher = $Dispatcher;
        return;
    }
    
    public function setRequest(AnimusRequest $Request){
        $this->log("Entering method ".__METHOD__.". Input params = InstanceOf AnimuseResponse");
        $this->log("Exiting method ".__METHOD__.". Setting object property _AnimusRequest = AnimusRequest");
        $this->_AnimusRequest = $Request;
    }
    
    public function setResponse(AnimusResponse $Response){
        $this->log("Entering method ".__METHOD__.". Input params = InstanceOf AnimuseResponse");
        $this->log("Exiting method ".__METHOD__.". Setting object property _AnimusResponse = AnimusResponse");
        $this ->_AnimusResponse = $Response;
    }

    public function getRequest(){
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__.". Returned InstanceOf AnimusRequest");
        return $this -> _AnimusRequest;
    }
    
    public function getResponse(){
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__.". Returned InstanceOf AnimusResponse");
        return $this -> _AnimusResponse;
    }
    public function getDispatcher(){
        $this->log("Entering method ".__METHOD__.". Input params = none");
        $this->log("Exiting method ".__METHOD__.". Returned InstanceOf AnimusDispatcher");
        return $this->_AnimusDispatcher;
    }
    
    public function log($message){
        AnimusLogInfoHandler::logDevInfo($message);
    }
    
    public function __destruct(){
        $this->log("Class destruct ".__CLASS__);
    }
}
?>