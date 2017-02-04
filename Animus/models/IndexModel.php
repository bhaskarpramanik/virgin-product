<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminLoginModel
 *
 * @author Animus Inc.
 */
// imports
require_once DOMROOT.'/classes/abstract/AnimusModel.php';

class IndexModel extends AnimusModel{
    public function getDataSinkName() {
        return parent::getDataSinkName();
    }

    public function getDataSinkPath() {
        return parent::getDataSinkPath();
    }

    public function getDataSourceName() {
        return parent::getDataSourceName();
    }

    public function getDataSourcePath() {
        return parent::getDataSourcePath();
    }

    public function pullDataFromSource() {
        parent::pullDataFromSource();
    }

    public function pushDataToSink() {
        parent::pushDataToSink();
    }

    public function setDataSinkName($dataSinkName) {
        parent::setDataSinkName($dataSinkName);
    }

    public function setDataSinkPath($dataSinkPath) {
        parent::setDataSinkPath($dataSinkPath);
    }

    public function setDataSourceName($dataSourceName) {
        parent::setDataSourceName($dataSourceName);
    }

    public function setDataSourcePath($dataSourcePath) {
        parent::setDataSourcePath($dataSourcePath);
    }

}
?>
