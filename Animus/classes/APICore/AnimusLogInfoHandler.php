<?php
/**
 * Description of AnimusLogInfoHandler
 *
 * @author bhaskarpramanik
 */
require_once 'EventLogger.php';

class AnimusLogInfoHandler {
    
    /*
     * DEBUG log functions
     */
    public static function logDevWarning($message){
        $EventLogger = new EventLogger(DEBUG_LOGPATH);
        $EventType = "[WARNING]: ";
        $EventLogger -> logMessage($EventType." ".$message);
    }
    public static function logDevInfo($message){
        $EventLogger = new EventLogger(DEBUG_LOGPATH);
        $EventType = "[INFO]: ";
        $EventLogger -> logMessage($EventType." ".$message);
    }
    public static function logDevError($message){
        $EventLogger = new EventLogger(DEBUG_LOGPATH);
        $EventType = "[ERROR]: ";
        $EventLogger -> logMessage($EventType." ".$message);
    }
    
    /*
     * DEPLOYMENT log function
     */
    public static function logDeploymentError($message){
        $EventLogger = new EventLogger(DEPLOYMENT_ERROR_LOGPATH);
        $EventType = "[ERROR]: ";
        $EventLogger -> logMessage($EventType." ".$message);
    }
    public static function logDeploymentWarning($message){
        $EventLogger = new EventLogger(DEPLOYMENT_ERROR_LOGPATH);
        $EventType = "[WARNING]: ";
        $EventLogger -> logMessage($EventType." ".$message);
    }
    public static function logDeploymentInfo(Array $message){
        $EventLogger = new EventLogger(DEPLOYMENT_ERROR_LOGPATH);
        foreach($message as $additionalInfo) {
            $EventType = "[INFO]: ";
            $EventLogger -> logMessage($EventType." ".$additionalInfo);
        }
     }
    
    /*
     * GENERAL PURPOSE FATAL error log function
     */
    public static function logException($file, $line, $message){
        $EventLogger = new EventLogger(ANIMUS_ERROR_LOGPATH);
        $EventType = "[EXCEPTION]";
        $fileLine = $file."|"."Line:".$line."|";
        $EventLogger -> logMessage($EventType." @ ".$fileLine.$message);
    }
}
?>