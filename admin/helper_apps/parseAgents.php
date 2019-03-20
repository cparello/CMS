<?php
class parseAgents  {

private $userAgentArray = null;    
private $userAgent = null;
private $userAgentVersion = null;
private $versionSwitch = null;
    
function setUserAgentArray($userAgentArray)  {
        $this->userAgentArray = $userAgentArray;
        }

function setUserAgent($userAgent)  {
        $this->userAgent = $userAgent;
        }


//------------------------------------------------------------------------------------------------------------------------------------------------
function loadUserAgent()  {
        //check for most popular browsers first
        //unfortunately that's ie. We also ignore opera and netscape 8 
        //because they sometimes send msie agent
        if(strpos($this->userAgentArray,"MSIE") !== false && strpos($this->userAgentArray,"Opera") === false && strpos($this->userAgentArray,"Netscape") === false)  {
            //check for IE
            $found = preg_match("/MSIE ([0-9]{1,2}\.[0-9]{1,2})/",$this->userAgentArray, $versionNumber);
                           if($found) {
                              $this->userAgent = 'Internet Explorer';
                              $this->userAgentVersion = $versionNumber[1]; 
                                         if($this->userAgentVersion < 8) {
                                             $this->versionSwitch = 2;
                                            }elseif($this->userAgentVersion == 8) {
                                             $this->versionSwitch = 3;
                                            }else{
                                              $this->versionSwitch = 4;
                                            }
                              }
                        
        }elseif(strpos($this->userAgentArray,"Gecko"))  {
            //check for Gecko to see if Fire Fox
            $found = preg_match("/Firefox\/([0-9]{1,2}\.[0-9]{1}(\.[0-9])?)/",$this->userAgentArray, $versionNumber);
                          if($found == 1) {
                              $this->userAgent = 'Mozilla Fire Fox';
                              $this->userAgentVersion = $versionNumber[1];
                               if($this->userAgentVersion < 4) {
                                             $this->versionSwitch = 1;
                                            }else{
                                             $this->versionSwitch = 2;
                                            }                          
                              }
            
            //Check for Netscape based on Gecko Kernel
            $found = preg_match("/Netscape\/([0-9]{1,2}\.[0-9]{1}(\.[0-9])?)/",$this->userAgentArray, $versionNumber);
                          if($found)  {
                              $this->userAgent = 'Netscape';
                              $this->userAgentVersion = $versionNumber[1];
                              //will need to check different version and if needed add the switch number 2
                              $this->versionSwitch = 1;
                            }
            
             //if Safari (based on gecko)
            $found = preg_match("/Safari\/([0-9]{2,3}(\.[0-9])?)/",$this->userAgentArray, $versionNumber);
                          if($found)   {
                              $this->userAgent = 'Safari';
                              $this->userAgentVersion = $versionNumber[1];
                              $this->versionSwitch = 1;                              
                            }
            
            
            
            
            //check chrome before safari because chrome agent contains both
            $found = preg_match("/Chrome\/([^\s]+)/",$this->userAgentArray, $versionNumber);
                          if($found)   {
                              $this->userAgent = 'Google Chrome';
                              $this->userAgentVersion = $versionNumber[1];
                              //will need to check different version and if needed add the switch number 2
                              $this->versionSwitch = 3;                              
                            }
            
           
            
            //if Galeon (based on gecko)
            $found = preg_match("/Galeon\/([0-9]{1}\.[0-9]{1}(\.[0-9])?)/",$this->userAgentArray, $versionNumber);
                          if($found)   {
                              $this->userAgent = 'Galeon';
                              $this->userAgentVersion = $versionNumber[1];
                              $this->versionSwitch = 1;                              
                            }
            
            //if Konqueror (based on gecko)
            $found = preg_match("/Konqueror\/([0-9]{1}\.[0-9]{1}(\.[0-9])?)/",$this->userAgentArray, $versionNumber);
                          if($found)   {
                              $this->userAgent = 'Konqueror';
                              $this->userAgentVersion = $versionNumber[1];
                              $this->versionSwitch = 1;                              
                            }
                            
                            
        }elseif(strpos($this->userAgentArray,"Opera") !== false)  {
            //deal with Opera
            $found = preg_match("/Opera[\/ ]([0-9]{1}\.[0-9]{1}([0-9])?)/",$this->userAgentArray, $versionNumber);
                          if($found)   {
                              $this->userAgent = 'Opera';
                              $this->userAgentVersion = $versionNumber[1];
                              $this->versionSwitch = 1;                              
                            }
                      
        }elseif(strpos($this->userAgentArray,"Lynx") !== false)   {
           //deal with Lynx            
            $found = preg_match("/Lynx\/([0-9]{1}\.[0-9]{1}(\.[0-9])?)/",$this->userAgentArray, $versionNumber);
                          if($found)   {
                              $this->userAgent = 'Lynx';
                              $this->userAgentVersion = $versionNumber[1];
                              $this->versionSwitch = 1;                              
                            }
                        
        }elseif (strpos($this->userAgentArray,"Netscape") !== false)  {        
            //NN8 with IE string
            $found = preg_match("/Netscape\/([0-9]{1}\.[0-9]{1}(\.[0-9])?)/",$this->userAgentArray, $versionNumber);            
                          if($found)   {
                              $this->userAgent = 'Netscape';
                              $this->userAgentVersion = $versionNumber[1];
                              $this->versionSwitch = 1;                              
                            }
                   
        }else{ 
                 $this->userAgent = null;
                 $this->userAgentVersion = null;
                 $this->versionSwitch = 3;                 
        }
    }
    
//----------------------------------------------------------------------------------------------------------------------------------------------------
function getBrowserType() {
            return($this->userAgent);
            }        
function getBrowserVersion() {
            return($this->userAgentVersion);
            }
function getVersionSwitch() {
            return($this->versionSwitch);
            }
function getUserAgentArray() {
            return($this->userAgentArray);
            }



}    
?> 