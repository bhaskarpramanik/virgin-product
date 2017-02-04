<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnimusDataSet
 * This bean class shall hold only the dataset
 * which is requested by the view
 * Setter method >> Called by component
 * Getter method >> called by AnimusFactory
 * @author bhaskarpramanik
 */
require_once ABSTRACTPATH."AnimusModel.php";

class AnimusModelImpl extends AnimusModel{
    
    private $_dataSourceName;
    private $_dataSinkName;
    private $_dataSourcePath;
    private $_dataSinkPath;
    
    public function setDataSinkName($dataSinkName) {
        $this->_dataSinkName = $dataSinkName;
        return;
    }
    
    public function getDataSinkName(){
        return $this->_dataSinkName;     
    }
    public function setDataSinkPath($dataSinkPath) {
        $this->_dataSinkPath = $dataSinkPath;
        return;
    }
    
    public function getDataSinkPath(){
        return $this->_dataSinkPath;
    }

    public function setDataSourceName($dataSourceName) {
        $this->_dataSourceName = $dataSourceName;
        return;
    }
    
    public function getDataSourceName(){
        return $this->_dataSourceName;
    }

    public function setDataSourcePath($dataSourcePath) {
        $this->_dataSourcePath = $dataSourcePath;
        return;
    }
    
    public function getDataSourcePath(){
        return $this->_dataSourcePath;
    }
    
    public function pullDataFromSource() {
        
    }

    public function pushDataToSink() {
        
    }
}