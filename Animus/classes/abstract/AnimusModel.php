<?php
    /*
    **	Abstract class Model
    */

    abstract	class	AnimusModel{
        
        /** Changed on 2nd May 2016
         *  Model can now push - pull data from
         *  multiple sources. This includes XML
         *  JSON and RDBMS in this implementation.
         */
        abstract public function setDataSourceName($dataSourceName);
        abstract public function setDataSourcePath($dataSourcePath);
        abstract public function setDataSinkName($dataSinkName);
        abstract public function setDataSinkPath($dataSinkPath);
        abstract public function pullDataFromSource();
        abstract public function pushDataToSink();

    }

?>