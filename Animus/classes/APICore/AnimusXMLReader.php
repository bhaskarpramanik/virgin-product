<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * AnimusXMLReader extends XMLReader
 * Documentation: http://php.net/manual/en/class.xmlreader.php
 * @author bhaskarpramanik
 */
// define("ROOT",dirname(__FILE__));
class AnimusXMLReader extends XMLReader{
    /*
    * String
    */
   private $_XMLName;
   /*
    * String
    */
   private $_XMLPath;   
   /*
    * Boolean
    */
   private $_URLMode;
   
   /*
    * XML URL Path
    */
   private $_XMLURLPath;
   /*
    * XML Path - Internal
    */
    private $_filePath;
    
  /*
   * If XML has DTD declaration
   * set this flag
   */
    private $_isValid = false;
   
   public function setXMLParams($XMLPath=NULL, $XMLName=NULL, $isURL = false, $XMLURL = NULL){
       /*
        * If URL is provided
        * Set the program to run in URL
        * mode
        */
       if($isURL){
           $this->_URLMode = true;
           if(is_null($XMLURL)){
               echo $exceptionMessage = "No URL to read !";
               $exceptionFlag = true;
           }
           else{
               echo $exceptionFlag = false;
               $this->_XMLURL = $XMLURL;
           }
           
       }    
       else {
           $this->_URLMode = false;
           if(is_null($XMLPath)){
               echo $exceptionMessage = "No XMLName defined !";
               $exceptionFlag = true;
           }
           else if(is_null($XMLName)){
               echo $exceptionMessage = "No XMLPath defined !";
               $exceptionFlag = true;
           }
           else if(is_null($XMLName)&&is_null($XMLPath)){
               echo $exceptionMessage = "No XMLName and XMLPath defined !";
               $exceptionFlag = true;
           }
           else{
               $exceptionFlag = false;
               $this->_XMLName = $XMLName;
               $this->_XMLPath = $XMLPath;
           }
       }
    
        if($exceptionFlag){
            throw new AnimusException($exceptionMessage);
        }
   }
      
   public function fileCheck(){
       /*
        * Tries to find XML at the given path
        * if - false - throws exception.
        * else - sets the inputExists as true
        */
       if($this->_URLMode){
           $this->_filePath = $this->_XMLURLPath;
       }
       else{
           $this->_filePath = $this->_XMLPath."/".$this->_XMLName;
       }
       
       if(file_exists($this->_filePath)) {
           $this->_inputExists = true;
       }
       else{
           $this->_inputExists = false;
           
       }
      return $this->_inputExists;
   }
   
   /*
    * Loads xml
    */
   
   public function loadXML(){
       if($this->fileCheck()){
           // Check the file ext in case file exists
        $fileExt = "/.*(\.xml)/";
           // Check if input file has .xml extension
           if(preg_match($fileExt,$this->_XMLName)){
               parent::open($this->_filePath);
               parent::setParserProperty(XMLReader::SUBST_ENTITIES,true);
               // If the user has declared the xml as valid (Has a DTD declaration)
               if($this->_isValid){
                   // Set validate parser property to true
                   parent::setParserProperty(XMLReader::VALIDATE, true);
                   // Check if the loaded XML is valid
                   if(!$this->_XMLReader->isValid()){
                       $exceptionMessage = "Invalid XML provided";
                       throw new AnimusException($exceptionMessage);
                   }                   
               }
               else return true;
           }
           else{
               $exceptionMessage = "Provided file is not an XML !";
               throw new AnimusException($exceptionMessage);
           }
       }
       else{
           // Set exception message in case no XML is found.
           $exceptionMessage = "No file to load !";
           // Throw exception
           throw new AnimusException($exceptionMessage);
       }
   }

   public function setXMLValid(){
        $this->_isValid = true;
   }
    
   public function getElementName(){
       // public instance variable inherited from parent
       return $this->localName;
   }
    
   public function hasAttributes(){
       return $this->hasAttributes;
   }
    
    public function getAttributeByName($attributeName){
        return parent::getAttribute($attributeName);
    }
    
    public function readInnerXML(){
        return parent::readInnerXML();
    }
    
    public function readOuterXML(){
        return parent::readOuterXML();
    }
    
    public function readString(){
        return parent::readString();
    }
    
    public function expand(){
        return parent::expand();
    }
    
    // Parser events
    
    public function isTagNoNode(){
        if($this->nodeType == 0)
            return true;
        else return false;
    }
    
    public function isTagStartElement(){
        if($this->nodeType == 1){
            return true;
        }
        else return false;
    }
    
    public function isTagEndElement(){
        if($this->nodeType == 15)
            return true;
        else return false;
    }
    
    public function isTagAttribute(){
        if($this->nodeType == 2)
            return true;
        else return false;    
    }
    
    public function isTagWhitespace(){
        if($this->nodeType == 14){
            return true;
        }
        else return false;
    }
    
    public function isTagText(){
        if($this->nodeType == 3)
            return true;
        else return false;
    }
    
    public function isTagCDATA(){
        if($this->nodeType == 4) 
            return true;
        else return false;
    }
}
?>