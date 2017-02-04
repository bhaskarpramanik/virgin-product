<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnimusAssetHandler
 * AnimusAssetsHandler - Write to assets.xml / read assets.xml
 * @author bhaskarpramanik
 */

require_once "AnimusXMLReader.php";
require_once "AnimusLogInfoHandler.php";

class AnimusAssetHandler{
    
    /*
     * Method to check:
     * 1. if assets.xml exists
     * 2. All the files and classes mentioned in the assets exist.
     * 3. Classes mentioned can be invoked
     */
    public function verifyAssets(){
        /*
         * Check if the file assets.xml exists - Use AnimusXMLReader
         * Also check if the file is an XML file.
         */
        $this->log("Entering method ".__METHOD__);
        $XMLReader = new AnimusXMLReader();
        $XMLReader->setXMLParams(ASSETS, "assets.xml");
        $XMLReader->loadXML();
        unset($XMLReader);
        $this->log("Exiting method ".__METHOD__);
    }
    
    /*
     * Load the component class 
     */
    public function loadComponent($className){
        /*
         * Try to load the requested component class
         * Step 1: Go to assets.xml and check if the requested component class exits.
         * Step 2: Get the path of the class to be evoked.
         * Step 3: Require once the file and create the object - Handled separately in AnimusClassLoader
         * Step 4: Return the object
         */
        $this->log("Entering method ".__METHOD__);
        $assetType = "component";
        $classPath = $this->loadAsset($assetType, $className);
        if($classPath == null){
            $this->log("Exiting method ".__METHOD__." with exception!");
            throw new AnimusException("Requested asset ".$className." not found in assets.xml !");
        }
        else{
            $this->log("Exiting method ".__METHOD__);
            return $classPath;
        }
    }
    
    /*
     * Load the model class
     */
    public function loadModel($className){
        $this->log("Entering method ".__METHOD__);
        $assetType = "model";
        $classPath = $this->loadAsset($assetType, $className);
        if($classPath == null){
            $this->log("Exiting method ".__METHOD__." with exception!");
            throw new AnimusException("Requested asset ".$className." not found in assets.xml !");
        }    
        else{
            $this->log("Exiting method ".__METHOD__);
            return $classPath;
        }
    }
    
    /*
     * Load the view class
     */
    public function loadView($className){
        $this->log("Entering method ".__METHOD__);
        $assetType = "view";
        $classPath = $this->loadAsset($assetType, $className);
        if($classPath == null){
            $this->log("Exiting method ".__METHOD__." with exception!");
            throw new AnimusException("Requested asset ".$className." not found in assets.xml !");
        }
        else{
            $this->log("Exiting method ".__METHOD__);
            return $classPath;
        }
    }
    
    /*
     * Load the dataset class
     */
    public function loadDataset($className){
        $this->log("Entering method ".__METHOD__);
        $assetType = "dataset";
        $classPath = $this->loadAsset($assetType, $className);
        if($classPath == null){
            $this->log("Exiting method ".__METHOD__." with exception!");
            throw new AnimusException("Requested asset ".$className." not found in assets.xml !");
        }
        else{
            $this->log("Exiting method ".__METHOD__);
            return $classPath;
        }
    }
    
    public function loadHTML($name){
        $this->log("Entering method ".__METHOD__);
        $assetType = "html";
        $classPath = $this->loadAsset($assetType, $name);
        if($classPath == null){
            $this->log("Exiting method ".__METHOD__." with exception!");
            throw new AnimusException("Requested asset ".$name." not found in assets.xml !");
        }
        else{
            $this->log("Exiting method ".__METHOD__);
            return $classPath;
        }
    }
    
    /*
     * Register a new component
     */
    public function registerComponent($className, $classPath){
        $this->log("Entering method ".__METHOD__);
        
    }
    
    /*
     * Register a new model
     */
    public function registerModel($className, $classPath){
        $this->log("Entering method ".__METHOD__);
        
    }
    
    /*
     * Register a new view
     */
    public function registerView($className, $classPath){
        $this->log("Entering method ".__METHOD__);
        
    }
    
    /*
     * Register a new dataset
     */
    public function registerDataset($className, $classPath){
        $this->log("Entering method ".__METHOD__);
        
    }
    
    public function loadAsset($assetType, $className){ // throws AnimusException
        $this->log("Entering function ".__METHOD__);
        $this->log(__METHOD__." - Trying to load asset = ".$className." assetType = ".$assetType);
        $XML = new AnimusXMLReader();
        $XML->setXMLParams(ASSETS, "assets.xml");
        $XML->loadXML();
        while($XML->read()){
            $this->log("Looping through assets ...");
            if($XML->isTagStartElement()){
                $localName = $XML->localName;
                switch($localName){
                    case $assetType : {
                        if($XML->getAttributeByName("name") == $className && strlen($XML->getAttributeByName("path"))!=0){
                            /*
                             * Best effort hack:
                             * Trigger return as soon as a match is found.
                             * Once returned, GC will clean off everything.
                             */
                            $classPath = $XML->getAttributeByName("path");
                             unset($XML);
                             $this->log("Exiting method ".__METHOD__);
                             return $classPath;
                        }
                        else {
                            $this->log(__METHOD__." - Couldn't find requested asset in assets.xml - ".$className);
                            $classPath = null;
                        }    
                    }
                }
                continue;
            }
        }
    }
    
    public function log($message){
        AnimusLogInfoHandler::logDevInfo($message);
        return;
    }
    
}
