<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Bootstrap
 * @author bhaskarpramanik
 */

class AnimusBootstrap{
    
    static public function setEnvironmentVariables(){
        
        /* All the values seen here are programmed in the application-settings.xml
         * The values are then read and created as constants so that they can be
         * accessed within the context of the application.
         */
        $application_settings_map = new SimpleXMLElement(file_get_contents(DOMROOT.'/config/application-settings.xml'));
        $settings = $application_settings_map->children();
        define("APPMODE",(string)$settings->{"application-mode"}["name"]);
        define("ROUTEDEPLOYMENTXML",(string)$settings->{"route-description"}["name"]);
        define("ROUTEDEPLOYMENTXMLPATH",(string)$settings->{"route-description"}["path"]);
        
        // Default system path settings
        define("DEBUG_LOGPATH",DOMROOT.(String)$settings->{"logpath"}->{"debug"});
        define("DEPLOYMENT_ERROR_LOGPATH", DOMROOT.(String) $settings->{"logpath"}->{"deployment-errors"});
        define("ANIMUS_ERROR_LOGPATH", DOMROOT.(String) $settings->{"logpath"}->{"errors"});
        define("VIEW_PROPERTIES", DOMROOT.(String) $settings->{"view-properties"}["path"]);
        define("VIEWS", DOMROOT. (String)$settings->{"views"}["path"]);
        define("COMPONENTS", DOMROOT. (String)$settings->{"components"}["path"]);
        define("MODELS", DOMROOT. (String)$settings->{"models"}["path"]);
        define("ASSETS", DOMROOT. (String)$settings->{"assets"}["path"]);
        define("DATASETS", DOMROOT. (String)$settings->{"datasets"}["path"]);
        define ("HTML", DOMROOT. (String)$settings->{"html"}["path"]);
        
        // Maintenance page location and duration setting
        //define("MAINTENANCE_PAGE", DOMROOT.(String)$settings->{"maintenance"}["path"]);
        define("MAINTENANCE_DUR", (int)$settings->{"maintenance"}["duration"]);
        
        // Default session duration
        define("SESSION_TIMEOUT", (int)$settings->{"session"}["timeout"]);

        // Define default error pages
        $errorPages = $settings->{"error-pages"};
        foreach($errorPages->children() as $errorPage){
        $name = (String)$errorPage["name"];
            switch($name){
                case "401" : {
                        define("ERROR_401", DOMROOT.(String)$errorPage["path"]);
                        define("URL_401", (String)$errorPage["url"]);
                        define("REDIRECT_401", (String)$errorPage["redirect"]=="true"?true:false);
                    }
                    break;
                case "403" : {
                        define("ERROR_403", DOMROOT.(String)$errorPage["path"]);
                        define("URL_403", (String)$errorPage["url"]);
                        define("REDIRECT_403", (String)$errorPage["redirect"]=="true"?true:false);
                    }
                    break;
                case "404" : {
                                define("ERROR_404", DOMROOT.(String)$errorPage["path"]);
                                define("URL_404", (String)$errorPage["url"]);
                                define("REDIRECT_404", (String)$errorPage["redirect"]=="true"?true:false);
                    }   
                    break;
                case "500" :{
                        define("ERROR_500", DOMROOT.(String)$errorPage["path"]);
                        define("URL_500", (String)$errorPage["url"]);
                        define("REDIRECT_500", (String)$errorPage["redirect"]=="true"?true:false);
                    }
                    break;
                case "503" : {
                        define("ERROR_503", DOMROOT.(String)$errorPage["path"]);
                        define("URL_503", (String)$errorPage["url"]);
                        define("REDIRECT_503", (String)$errorPage["redirect"]=="true"?true:false);
                    }
                    break;
            }
            continue;
        }
        AnimusLogInfoHandler::logDevInfo(__METHOD__." >> Completed loading environment.");
    }
    
}
?>