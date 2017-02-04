<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnimusException
 *
 * @author bhaskarpramanik
 */
require_once 'AnimusLogInfoHandler.php';
class AnimusException extends Exception {
    
    private $_logInfoHandler;
    
    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
        $this->_logInfoHandler = new AnimusLogInfoHandler();
    }
    public function log(){
        $this->_logInfoHandler->logException($this->getFile(), $this->getLine(), $this->getMessage());
        $this->_logInfoHandler->logDevError("Exception was thrown @".$this->getFile()." @".$this->getLine());
    }
}

?>
