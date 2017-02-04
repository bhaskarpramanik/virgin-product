<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once "AnimusLogInfoHandler.php";
/**
 * Description of AnimusViewProperty
 *
 * @author bhaskarpramanik
 */
class AnimusViewProperty {
    private $_viewPath;
    private $_viewType;
    private $_viewAllowURLParams;
    private $_authRequired;
    private $_viewParams;
    private $_authViewURL;
    private $_authSignature;
    private $_viewRedirected;
    private $_viewRedirectCode;
    private $_viewRedirectRescURL;
    private $_phaseMaint;
    private $_phaseMaintStart;
    private $_phaseMaintStop;
    private $_mappedComponent;
    private $_mappedModels;
    private $_mappedDataset;
    
    public function __construct(){
        $this->log("Class init ".__CLASS__);
    }
    
    public function getViewPath() {
        $this->log("Entering method ".__METHOD__.". Input params - None");
        $this->log("Exiting method ".__METHOD__.". Returned ".$this->_viewPath);
        return $this->_viewPath;
    }

    public function getViewType() {
        $this->log("Entering method ".__METHOD__.". Input params - None");
        $this->log("Exiting method ".__METHOD__.". Returned ".$this->_viewType);
        return $this->_viewType;
    }

    public function getViewAllowURLParams() {
        $this->log("Entering method ".__METHOD__.". Input params - None");
        $this->log("Exiting method ".__METHOD__.". Returned ".$this->_viewAllowURLParams);
        return $this->_viewAllowURLParams;
    }

    public function getAuthRequired() {
        $this->log("Entering method ".__METHOD__.". Input params - None");
        $this->log("Exiting method ".__METHOD__.". Returned ".$this->_authRequired);
        return $this->_authRequired;
    }

    public function getViewParams() {
        $this->log("Entering method ".__METHOD__.". Input params - None");
        $this->log("Exiting method ".__METHOD__.". Returned ".$this->_viewParams);
        return $this->_viewParams;
    }

    public function getAuthViewURL() {
        $this->log("Entering method ".__METHOD__.". Input params - None");
        $this->log("Exiting method ".__METHOD__.". Returned ".$this->_authViewURL);
        return $this->_authViewURL;
    }

    public function getAuthSignature() {
        $this->log("Entering method ".__METHOD__.". Input params - None");
        $this->log("Exiting method ".__METHOD__.". Returned ".$this->_authSignature);
        return $this->_authSignature;
    }

    public function getViewRedirected() {
        $this->log("Entering method ".__METHOD__.". Input params - None");
        $this->log("Exiting method ".__METHOD__.". Returned ".$this->_viewRedirected);
        return $this->_viewRedirected;
    }

    public function getViewRedirectCode() {
        $this->log("Entering method ".__METHOD__.". Input params - None");
        $this->log("Exiting method ".__METHOD__.". Returned ".$this->_viewRedirectCode);
        return $this->_viewRedirectCode;
    }

    public function getViewRedirectRescURL() {
        $this->log("Entering method ".__METHOD__.". Input params - None");
        $this->log("Exiting method ".__METHOD__.". Returned ".$this->_viewRedirectRescURL);
        return $this->_viewRedirectRescURL;
    }

    public function getPhaseMaint() {
        $this->log("Entering method ".__METHOD__.". Input params - None");
        $this->log("Exiting method ".__METHOD__.". Returned ".$this->_phaseMaint);
        return $this->_phaseMaint;
    }

    public function getPhaseMaintStart() {
        $this->log("Entering method ".__METHOD__.". Input params - None");
        $this->log("Exiting method ".__METHOD__.". Returned ".$this->_phaseMaintStart);
        return $this->_phaseMaintStart;
    }

    public function getPhaseMaintStop() {
        $this->log("Entering method ".__METHOD__.". Input params - None");
        $this->log("Exiting method ".__METHOD__.". Returned ".$this->_phaseMaintStop);
        return $this->_phaseMaintStop;
    }

    public function getMappedComponent() {
        $this->log("Entering method ".__METHOD__.". Input params - None");
        $this->log("Exiting method ".__METHOD__.". Returned ".$this->_mappedComponent);
        return $this->_mappedComponent;
    }

    public function getMappedModels() {
        $this->log("Entering method ".__METHOD__.". Input params - None");
        $this->log("Exiting method ".__METHOD__.". Returned ".$this->_mappedModels);
        return $this->_mappedModels;
    }
    
    public function getMappedDataset(){
        $this->log("Entering method ".__METHOD__.". Input params - None");
        $this->log("Exiting method ".__METHOD__.". Returned ".$this->_mappedDataset);
        return $this->_mappedDataset;
    }
    
    public function setMappedDataset($mappedDataset){
        $this->log("Entering method ".__METHOD__.". Input params = ".$mappedDataset);
        $this->log("Exiting method ".__METHOD__.". Setting object property _mappedDataset = ".$mappedDataset);
        $this->_mappedDataset = $mappedDataset;
    }

    public function setMappedComponent($mappedComponent) {
        $this->log("Entering method ".__METHOD__.". Input params = ".$mappedComponent);
        $this->log("Exiting method ".__METHOD__.". Setting object property _mappedComponent = ".$mappedComponent);
        $this->_mappedComponent = $mappedComponent;
    }

    public function setMappedModels($mappedModel) {
        $this->log("Entering method ".__METHOD__.". Input params = ".$mappedModel);
        $this->log("Exiting method ".__METHOD__.". Setting object property _mappedModel = ".$mappedModel);
        $this->_mappedModels = $mappedModel;
    }    
    
    public function setViewPath($viewPath) {
        $this->log("Entering method ".__METHOD__.". Input params = ".$viewPath);
        $this->log("Exiting method ".__METHOD__.". Setting object property _viewPath = ".$viewPath);
        $this->_viewPath = $viewPath;
    }

    public function setViewType($viewType) {
        $this->log("Entering method ".__METHOD__.". Input params = ".$viewType);
        $this->log("Exiting method ".__METHOD__.". Setting object property _viewType = ".$viewType);
        $this->_viewType = $viewType;
    }

    public function setViewAllowURLParams($viewAllowURLParams) {
        $this->log("Entering method ".__METHOD__.". Input params = ".$viewAllowURLParams);
        $this->log("Exiting method ".__METHOD__.". Setting object property _viewAllowedURLParams = ".$viewAllowURLParams);
        $this->_viewAllowURLParams = $viewAllowURLParams;
    }

    public function setAuthRequired($authRequired) {
        $this->log("Entering method ".__METHOD__.". Input params = ".$authRequired);
        $this->log("Exiting method ".__METHOD__.". Setting object property _authRequired = ".$authRequired);
        $this->_authRequired = $authRequired;
    }

    public function setViewParams($viewParams) {
        $this->log("Entering method ".__METHOD__.". Input params = ".$viewParams);
        $this->log("Exiting method ".__METHOD__.". Setting object property _viewParams = ".$viewParams);
        $this->_viewParams = $viewParams;
    }

    public function setAuthViewURL($authViewURL) {
        $this->log("Entering method ".__METHOD__.". Input params = ".$authViewURL);
        $this->log("Exiting method ".__METHOD__.". Setting object property _authViewURL = ".$authViewURL);
        $this->_authViewURL = $authViewURL;
    }

    public function setAuthSignature($authSignature) {
        $this->log("Entering method ".__METHOD__.". Input params = ".$authSignature);
        $this->log("Exiting method ".__METHOD__.". Setting object property _authSignature = ".$authSignature);
        $this->_authSignature = $authSignature;
    }

    public function setViewRedirected($viewRedirected) {
        $this->log("Entering method ".__METHOD__.". Input params = ".$viewRedirected);
        $this->log("Exiting method ".__METHOD__.". Setting object property _viewRedirected = ".$viewRedirected);
        $this->_viewRedirected = $viewRedirected;
    }

    public function setViewRedirectCode($viewRedirectCode) {
        $this->log("Entering method ".__METHOD__.". Input params = ".$viewRedirectCode);
        $this->log("Exiting method ".__METHOD__.". Setting object property _viewRedirectCode = ".$viewRedirectCode);
        $this->_viewRedirectCode = $viewRedirectCode;
    }

    public function setViewRedirectRescURL($viewRedirectRescURL) {
        $this->log("Entering method ".__METHOD__.". Input params = ".$viewRedirectRescURL);
        $this->log("Exiting method ".__METHOD__.". Setting object property _viewRedirectRescURL = ".$viewRedirectRescURL);
        $this->_viewRedirectRescURL = $viewRedirectRescURL;
    }

    public function setPhaseMaint($phaseMaint) {
        $this->log("Entering method ".__METHOD__.". Input params = ".$phaseMaint);
        $this->log("Exiting method ".__METHOD__.". Setting object property _phaseMaint = ".$phaseMaint);
        $this->_phaseMaint = $phaseMaint;
    }

    public function setPhaseMaintStart($phaseMaintStart) {
        $this->log("Entering method ".__METHOD__.". Input params = ".$phaseMaintStart);
        $this->log("Exiting method ".__METHOD__.". Setting object property _phaseMaintStart = ".$phaseMaintStart);
        $this->_phaseMaintStart = $phaseMaintStart;
    }

    public function setPhaseMaintStop($phaseMaintStop) {
        $this->log("Entering method ".__METHOD__.". Input params = ".$phaseMaintStop);
        $this->log("Exiting method ".__METHOD__.". Setting object property _phaseMaintStop =".$phaseMaintStop);
        $this->_phaseMaintStop = $phaseMaintStop;
    }
    
    public function log($message){
        AnimusLogInfoHandler::logDevInfo($message);
    }

}
