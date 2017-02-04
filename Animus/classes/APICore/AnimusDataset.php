<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnimusDataset
 * AnimusDataset is a simple class, which stores values from different data sources as key-value pairs
 * Direction - Input
 * @author bhaskarpramanik
 */
 
require_once "AnimusException.php";
require_once "AnimusLogInfoHandler.php";

class AnimusDataset {
    
    private $_dataset_name;
    private $_animus_dataset;
    private $_dataset_keys;
    private $_dataset_has_keys;
    private $_dataset_is_empty;
    
    public function __construct($dataSetName){
        $this->_dataset_name = $dataSetName;
    }
    
    public function addKey(Array $keys){	// throws AnimusException
        if(is_null($this->_animus_dataset)){
            /*
             * Check if the user provided key array has duplicates
             * if yes, then throw AnimusException
             */
            $dup_flag = false;
            if(count(array_unique($keys)) != count($keys)){
                $dup_flag = true;
                throw new AnimusException(__METHOD__."() > "."Dataset keys can't be duplicated !");
            }
            else{
                $this->_dataset_keys = $keys;
                foreach($keys as $key) $this->_animus_dataset[$key] = null;
                $this->_dataset_is_empty = true;
                $this->_dataset_has_keys = true;
            }
        }
        else throw new AnimusException(__METHOD__."() > "."AnimusDataset already created !");
        return true;
    }
    
    public function createRequestDataset(){
        if(is_null($this->_animus_dataset))
            $this->_animus_dataset = array();
        else
            throw new AnimusException(__METHOD__."() > "."AnimusDataset is already created !");
        return true;
    }
    
    public function fillDatasetByKey($key,$value){
        $this->_animus_dataset[$key] = $value;
    }
    
    public function getDataset($dataSetName){
        return $this->_animus_dataset;
    }
    /*
     * In case where it is required to create "associative" dataset,
     * a structure needs to be created. To enable this, current key
     * is needed to be "forked" create extra keys, which are component
     * of the main key. This kind of functionality is required, when
     * the input source is a JSON or XML etc
     * Edit-date: 02 Sept 2016
     * Author: bhaskarpramanik
     */
    
    public function forkExistingKey($existing_key, $forked_key, $fork_add_single_key = true, $fork_add_key_array = false){
        // Check if $key exists before forking
        $key_exists_flag = false;
        if(key_exists($existing_key,  $this->_dataset_keys)){
            $key_exists_flag = true;
        }
        elseif($key_exists_flag){
            
        }
        else throw new AnimusException(__METHOD__."() > "."Forked key doesn't exist !");
    }
}
?>