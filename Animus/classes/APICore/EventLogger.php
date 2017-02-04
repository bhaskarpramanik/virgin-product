<?php
/**
 * Description of EventLogger
 *
 * @author bhaskarpramanik
 */
class EventLogger {
   
    private $_log_path;
    
    private $_log_handle;


    public function  __construct($path){
        
        $this ->setLogPath($path);

        $this ->getLogHandle();
        
        return;
    }
    
    public function setLogPath($path){
        
        $this->_log_path = $path;
        
        return;
        
    }
    
    public function getLogHandle(){
        
        $this->_log_handle = fopen($this->_log_path,"a+");
       
        return;
    }
    
    public function logMessage($message){

        $date = date("d/m/Y H:i:s");
        
        $log_string = $date." ".$message."\r\n";
        
        fwrite($this->_log_handle, $log_string);
        
        return;
    }
    
}

?>
