<?php

/*
* @author bhaskarpramanik
*/

require_once "AnimusLogInfoHandler.php";
class	AnimusRequest{
    
		//protected	$_httpAccept;
		protected	$_httpCharset;
		protected	$_encoding;
		protected	$_lang;
		protected	$_connection;
		protected	$_host;
		//protected	$_referrer;
		protected	$_userAgent;
		protected	$_requestURI;
                protected       $_requestIP;
                protected       $_session;
                protected       $_input_params;
                protected       $_httpProtocolType;
                protected       $_URIEndSegment;


        public function __construct() {
            $this->log("Class init ".__CLASS__);
            //$this->setHttpAccept();
            //$this->setHttpCharset();
            $this->setHttpConnection();
            $this->setRequestIP();
            $this->setHttpEncoding();
            $this->setHttpHost();
            $this->setHttpLanguage();
            //$this->setHttpReferrer();
            $this->setHttpRequestURI();
            $this->setHttpUserAgent();
            $this->setHTTPProtocolType();
            $this->setURIEndSegment();
        }
        
        public	function	setHttpAccept(){
                $this->log("Entering method ".__METHOD__.". Input param = none");
                $this->log("Exiting method ".__METHOD__.". Setting object property _userAgent = ".$_SERVER['HTTP_ACCEPT']);
		$this->_httpAccept	=	$_SERVER['HTTP_ACCEPT'];
	
	}
	
	public	function	setHttpCharset(){
                $this->log("Entering method ".__METHOD__.". Input param = none");
                $this->log("Exiting method ".__METHOD__.". Setting object property _userAgent = ".$_SERVER['HTTP_ACCEPT_CHARSET']);
		$this->_httpCharset	=	$_SERVER['HTTP_ACCEPT_CHARSET'];
		
	}
	
	public	function	setHttpEncoding(){
                $this->log("Entering method ".__METHOD__.". Input param = none");
                $this->log("Exiting method ".__METHOD__.". Setting object property _userAgent = ".$_SERVER['HTTP_ACCEPT_ENCODING']);
		$this->_encoding	=	$_SERVER['HTTP_ACCEPT_ENCODING'];	
	}
	
	public	function	setHttpLanguage(){
                $this->log("Entering method ".__METHOD__.". Input param = none");
                $this->log("Exiting method ".__METHOD__.". Setting object property _userAgent = ".$_SERVER['HTTP_ACCEPT_LANGUAGE']);
		$this->_lang	=	$_SERVER['HTTP_ACCEPT_LANGUAGE'];
	}
	
	public	function	setHttpConnection(){
                $this->log("Entering method ".__METHOD__.". Input param = none");
                $this->log("Exiting method ".__METHOD__.". Setting object property _userAgent = ".$_SERVER['HTTP_CONNECTION']);
		$this->_connection	=	$_SERVER['HTTP_CONNECTION'];
	
	}
	
	public	function	setHttpHost(){
                $this->log("Entering method ".__METHOD__.". Input param = none");
                $this->log("Exiting method ".__METHOD__.". Setting object property _userAgent = ".$_SERVER['HTTP_HOST']);
		$this->_host	=	$_SERVER['HTTP_HOST'];
	
	}
	
	public	function	setHttpReferrer(){
                $this->log("Entering method ".__METHOD__.". Input param = none");
                $this->log("Exiting method ".__METHOD__.". Setting object property _userAgent = ".$_SERVER['HTTP_REFERRER']);
		$this->_referrer	=	$_SERVER['HTTP_REFERRER'];
	
	}
	
	public	function	setHttpUserAgent(){
                $this->log("Entering method ".__METHOD__.". Input param = none");
                $this->log("Exiting method ".__METHOD__.". Setting object property _userAgent = ".$_SERVER['HTTP_USER_AGENT']);
		$this->_userAgent	=	$_SERVER['HTTP_USER_AGENT'];
	
	}
	
	public	function	setHttpRequestURI(){
          $this->log("Entering method ".__METHOD__.". Input param = none");
          $_requestURI  =   $_SERVER['REQUEST_URI'];
            
            if	(	strcmp	(	$_requestURI,	"/application/")	==	0)
			
				$_requestURI	=	$_requestURI."index.php";
          $this->log("Exiting method ".__METHOD__.". Setting object property _requestURI = ".$_requestURI);
          $this->_requestURI	=	$_requestURI;
	
	}
        
        public function setRequestIP() {
            $this->log("Entering method ".__METHOD__.". Input param = none");
            $this->_requestIP =  $_SERVER['REMOTE_ADDR'];
            $this->log("Exiting method ".__METHOD__.". Setting object property _requestIP = ".$this->_requestIP);
        }
	
	public function setSession(AnimusSession $session){
	 $this->log("Entering method ".__METHOD__.". Input param = InstanceOf AnimusSession");
         $this->log("Exiting method ".__METHOD__.". Setting object property _session to InstanceOf = AnimusSession");
	 $this -> _session =$session;
	}

        public function setInputParams($inputParams){
            $this->log("Entering method ".__METHOD__.". Input param = none");
            $this->log("Exiting method ".__METHOD__.". Setting object property _input_params = ".$inputParams);
            $this->_input_params = $inputParams;
        }
        
        public function setHTTPProtocolType(){
            $this->log("Entering method ".__METHOD__.". Input param = none");
            $this->_httpProtocolType = $_SERVER["SERVER_PROTOCOL"];
            $this->log("Exiting method ".__METHOD__.". Setting object property _requestURI = ".$this->_requestURI);
        }
        
        /*
         * Fix for delivering any static page using static view 
         */
        public function setURIEndSegment(){
            $this->log("Entering method ".__METHOD__);
            $regex = "/([^\/]+)\/?$/";
            $requestURI = $this->_requestURI;
            $match = array();
            preg_match($regex, $this->_requestURI, $match);
                if(strpos($match[0], "/")){
                    $requestURI = substr($match[0],0,-1);
                }
                else{
                    $requestURI = $match[0];
                }
            $this->log("Exiting method ".__METHOD__.". Setting instance variable _URIEndSegment = ".$requestURI);
            $this->_URIEndSegment = $requestURI;
        }
        
        public function getURIEndSegment(){
            $this->log("Entering method ".__METHOD__.". Input param = none");
            return $this->_URIEndSegment;
        }
        
        public function getHTTPProtocolType(){
            $this->log("Entering method ".__METHOD__.". Input param = none");
            $this->log("Exiting method ".__METHOD__.". Returned ".$this->_httpProtocolType);
            return $this->_httpProtocolType;
        }
        
	public function getModelPath(){
                $this->log("Entering method ".__METHOD__.". Input param = none");
                $this->log("Exiting method ".__METHOD__.". Returned ".$this->_model_path);
		return $this -> _model_path;
	}
		
        public function getSession(){
                $this->log("Entering method ".__METHOD__.". Input param = none");
                $this->log("Exiting method ".__METHOD__.". Returned InstanceOf AnimusSession");
                return $this -> _session;
        }
        
	public	function	getHttpAccept(){
		$this->log("Entering method ".__METHOD__.". Input param = none");
                $this->log("Exiting method ".__METHOD__.". Returned ".$this->_httpAccept);
		return	$this->_httpAccept;	
	
	}
	
	public	function	getHttpCharset(){
		$this->log("Entering method ".__METHOD__.". Input param = none");
                $this->log("Exiting method ".__METHOD__.". Returned ".$this->_httpCharset);
		return	$this->_httpCharset;	
	
	}
	
	public	function	getHttpEncoding(){
		$this->log("Entering method ".__METHOD__.". Input param = none");
                $this->log("Exiting method ".__METHOD__.". Returned ".$this->_encoding);
		return	$this->_encoding;	
	
	}
	
	public	function	getHttpLanguage(){
                $this->log("Entering method ".__METHOD__.". Input param = none");
                $this->log("Exiting method ".__METHOD__.". Returned ".$this->_lang);
		return	$this->_lang;	
	
	}
	
	public	function	getHttpConnection(){
		$this->log("Entering method ".__METHOD__.". Input param = none");
                $this->log("Exiting method ".__METHOD__.". Returned ".$this->_connection);
		return	$this->_connection;	
	
	}
	
	public	function	getHttpHost(){
		$this->log("Entering method ".__METHOD__.". Input param = none");
                $this->log("Exiting method ".__METHOD__.". Returned ".$this->_host);
		return	$this->_host;	
	
	}
	
	public	function	getHttpReferrer(){
		$this->log("Entering method ".__METHOD__.". Input param = none");
                $this->log("Exiting method ".__METHOD__.". Returned ".$this->_referrer);
		return	$this->_referrer;	
	
	}
	
	public	function	getHttpUserAgent(){
		$this->log("Entering method ".__METHOD__.". Input param = none");
                $this->log("Exiting method ".__METHOD__.". Returned ".$this->_userAgent);
		return	$this->_userAgent;	
	
	}
	
	public	function	getHttpRequestURI(){
                $this->log("Entering method ".__METHOD__.". Input param = none");
                $this->log("Exiting method ".__METHOD__.". Returned ".$this->_requestURI);
		return	$this->_requestURI;	
	
	}
        
        public function         getRequestIP(){
            $this->log("Entering method ".__METHOD__.". Input param = none");
            $this->log("Exiting method ".__METHOD__.". Returned ".$this->_requestIP);
            return $this->_requestIP;
        }
        
        public function         getInputParams(){
            $this->log("Entering method ".__METHOD__.". Input param = none");
            $this->log("Exiting method ".__METHOD__.". Returned ".$this->_input_params);
            return $this->_input_params;
        }
        
        public function log($message){
            AnimusLogInfoHandler::logDevInfo($message);
        }
        
        public function __destruct(){
            $this->log("Class destruct ".__CLASS__);
            return;
        }
}
?>