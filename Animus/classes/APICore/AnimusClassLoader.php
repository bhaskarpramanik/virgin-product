<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnimusClassLoader
 * @author bhaskarpramanik
 */
require_once "AnimusLogInfoHandler.php";
class AnimusClassLoader {   // Throws AnimusException
    
    public static function loadClass($className, $classPath){
        self::log("Entering method ".__METHOD__);
        if(!file_exists($classPath)){
            self::log(__METHOD__." - Requested class not found at the path. Throwing exception!");
            throw new AnimusException("File not found! @ ".$classPath);
        }
        else{
            self::log(__METHOD__." - File found.");
            require_once $classPath;
            self::log("Exiting method ".__METHOD__." returning class instance");
            return new $className;
        }
    }
    
    public static function log($message){
        AnimusLogInfoHandler::logDevInfo($message);
        return;
    }

}
?>