<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnimusRAD
 *
 * @author bhaskarpramanik
 */

/*
**	Restrict direct access
*/

defined("_dispatch") or die("Access Denied !");
define('CLASSPATH', DOMROOT.'/classes');
define('APICORE',  CLASSPATH.'/APICore');
define("ABSTRACTPATH", CLASSPATH.'/abstract/');
/*
 * Include Bootstrap for
 * initializing
 */
require_once 'AnimusBootstrap.php';    
require_once 'AnimusFactory.php';
require_once 'AnimusRequest.php';
require_once 'AnimusResponse.php';
require_once 'AnimusException.php';
require_once "AnimusLogInfoHandler.php";
class AnimusRAD {
    public static function startAnimusApp() {
        //Initialize the envionment
        AnimusBootstrap::setEnvironmentVariables();
        
        //Create instances of request and response objects
        //$Request = new AnimusRequest();
        //$Response = new AnimusResponse();
        
        //Invoke the factory
        $AnimusFactory = new AnimusFactory();
        //Start processing
        $AnimusFactory ->route();
        
        //Dispatch the output to the browser
        $AnimusFactory ->dispatch();
        return;
    }
}
?>