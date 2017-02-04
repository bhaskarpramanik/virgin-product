<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnimusMVC
 * @author bhaskarpramanik
 */
require_once "AnimusLogInfoHandler.php";
class AnimusMVCD {
    
    /*
     * Store model objects in array
     */
    private $_models;
    
    /*
     * Store view object in array
     */
    private $_view;
    
    /*
     * Store component objects in array
     */
    private $_components;
    
    /*
     * Store dataset objects in array
     */
    
    private $_datasets;
    
    /*
     * Store status code
     */
    private $_statusCode;
    
    
    /*
     * Store static content
     */
    private $_staticContent;
    
    public function __construct(){
        $this->log("Class init ".__CLASS__);
        /*
         * Initialize the instance variables
         * which will hold the components, models and datasets
         */
        $this->_components = array();
        $this->_datasets = array();
        $this->_models = array();
    }
    
    public function setStaticViewFlag(){
        $this->log("Entering method ".__METHOD__);
        $this->_setStaticViewFlag = true;
        $this->log("Exiting method ".__METHOD__);
    }
    
    public function getModels() {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        return $this->_models;
    }
    
    public function getModelByName($_modelName){
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        return $this->_models[$_modelName];
    }

    public function getView() {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        return $this->_view;
    }

    public function getComponents() {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        return $this->_components;
    }
    
    public function getComponentByName($_componentName){
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        return $this->_components[$_componentName];
    }
    
    public function getStatusCode() {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        return $this->_statusCode;
    }
    
    public function getDatasets(){
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        return $this->_datasets;
    }

    public function getDatasetByName($_datasetName){
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        return $this->_datasets[$_datasetName];
    }
    
    public function getStaticContent(){
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        return $this->_staticContent;
    }
    
    public function setStatusCode($statusCode) {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        $this->_statusCode = $statusCode;
    }
    /*
     * Support multiple models here
     */
    public function setModel($modelName, AnimusModel $model) {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        $this->_models[$modelName] = $model;
    }

    /*
     * Single view instance supported as of now.
     */
    public function setView(AnimusView $view) {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        $this->_view = $view;
    }
    
    /*
     * Support multiple components here
     */
    
    public function setComponent($componentName, AnimusComponent $component) {
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        $this->_components[$componentName] = $component;
    }
    
    public function setStaticContent($staticContent){
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        $this->_staticContent = $staticContent;
    }
    
    /*
     * Support multiple datasets here
     */
    
    public function setDataset($datasetName, Dataset $dataset){
        $this->log("Entering method ".__METHOD__);
        $this->log("Exiting method ".__METHOD__);
        $this->_datasets[$datasetName] = $dataset;
    }
    
    public function __destruct() {
        $this->log("Class destruct ".__CLASS__);
    }
    
    public function log($message){
        AnimusLogInfoHandler::logDevInfo($message);
        return;
    }
}
?>