<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnimusUserComponent
 *
 * @author Animus Inc.
 */
require_once ABSTRACTPATH.'AnimusComponent.php';

class AnimusComponentImpl extends AnimusComponent {
  
    private $_model_view;
    private $_http_response_code;
    private $_temp_redir_loc;
    private $_perma_redir_loc;
    private $_data_set;
    
    public function service(){} //  To be overridden
	
    public function execute(){
        return $this->service();
    }
    public function populateResponseDataset(){} // To be overridden
          
    public function setModelView(ModelView $_model_view){             
            $this -> _model_view = $_model_view;              
            return;
    }
    
    public function getModelView(){
        return $this->_model_view;
    }
    
    public function setHttpResponseCode($code){
        $this->_http_response_code = $code;
    }
    
    public function getHttpResponseCode() {
        return $this -> _http_response_code;
    }
    
    public function getDataset(){
        return $this->_data_set;
    }
    
    public function setDataset($data_set) {
        $this->_data_set = $data_set;
        return;
    }
    
    public function setSuccessHttpResponse(){
        $this->setHttpResponseCode(200);
    }
    
    public function setUnauthorizedHttpResponse(){
        $this->setHttpResponseCode(401);
    }
    
    public function setInternalServerErrorHttpResponse(){
        $this->setHttpResponseCode(500);
    }
    
    public function setTempRedirHttpResponse($tempRedirPath){
        $this ->setHttpResponseCode(301);
        $this ->_temp_redir_loc = "$tempRedirPath";
    }
    
    public function setPermaRedirHttpResponse($permaRedirPath){
        $this ->setHttpResponseCode(302);
        $this->_perma_redir_loc = $permaRedirPath;
    }
}
?>
