<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class paymentOptionsSql {

private $optionType;
private $optionPerms;
private $cashChecked;
private $checkChecked;
private $creditChecked;
private $achChecked;
private $cashDisabled;
private $checkDisabled;
private $creditDisabled;
private $achDisabled;
private $confirmationMessage;

function setOptionType($optionType) {
$this->optionType = $optionType;
}

function setOptionPerms($optionPerms) {
            if($optionPerms == "") {
               $optionPerms = '0000';
             }
        $this->optionPerms = $optionPerms;
}


//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}


//------------------------------------------------------------------------------------------------------------------
function loadOptionPerms()   {

//create a confirmation message for errors
$this->confirmation_message = "There was an error selecting these payment options";

$dbMain = $this->dbconnect();

 $stmt = $dbMain ->prepare("SELECT option_perms FROM payment_options WHERE option_type = '$this->optionType'");
   echo($dbMain->error);
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($optionPerms); 
   $stmt->fetch();

$this->optionPerms = $optionPerms;

}
//------------------------------------------------------------------------------------------------------------------
function loadOptionsChecked()  {

            $numResults = strlen($this->optionPerms);
            $bitArray = str_split($this->optionPerms);

             for($i=0; $i <= $numResults; $i++)  {

                        switch ($i) {
                              case 0:
                                  if ($bitArray[$i] == 1) {
	                        	     $this->cashChecked= 'checked';
                                     }else{
                                     $this->cashChecked="";
                                    }      
                              break;
                              case 1:
                                   if ($bitArray[$i] == 1) {
		                             $this->checkChecked= 'checked';
                                     }else{
                                     $this->checkChecked="";
                                    }      
                              break;    
                              case 2:
                                  if ($bitArray[$i] == 1) {
	                        	    $this->achChecked= 'checked';
                                    }else{
                                    $this->achChecked="";
                                    }      
                              break;        
                              case 3:
                                 if ($bitArray[$i] == 1) {
		                            $this->creditChecked= 'checked';
                                    }else{
                                    $this->creditChecked="";
                                    }      
                              break;                
                            }

                 }

}
//-------------------------------------------------------------------------------------------------------------------
function loadOptionsDisabled()  {

            $numResults = strlen($this->optionPerms);
            $bitArray = str_split($this->optionPerms);

             for($i=0; $i <= $numResults; $i++)  {

                        switch ($i) {
                              case 0:
                                  if ($bitArray[$i] == 1) {
	                        	     $this->cashDisabled= null;
                                     }else{
                                     $this->cashDisabled='disabled="disabled"';
                                    }      
                              break;
                              case 1:
                                   if ($bitArray[$i] == 1) {
		                             $this->checkDisabled= null;
                                     }else{
                                     $this->checkDisabled='disabled="disabled"';
                                    }      
                              break;    
                              case 2:
                                  if ($bitArray[$i] == 1) {
	                        	    $this->achDisabled= null;
                                    }else{
                                    $this->achDisabled= 'disabled="disabled"';
                                    }      
                              break;        
                              case 3:
                                 if ($bitArray[$i] == 1) {
		                            $this->creditDisabled=null;
                                    }else{
                                    $this->creditDisabled= 'disabled="disabled"';
                                    }      
                              break;                
                            }

                 }

}
//----------------------------------------------------------------------------------------------------------------
function updateOptionPerms()   {

$dbMain = $this->dbconnect();

$sql = "UPDATE payment_options SET option_perms=? WHERE option_type =?";
   $stmt = $dbMain->prepare($sql);
   $stmt->bind_param('ss' , $filePerms,$optionType);
   
   
   $filePerms = $this->optionPerms;
   $optionType = $this->optionType;
   
  if(!$stmt->execute())  {
    $this->confirmationMessage = 'There was an Error updating these Payment Options';
	printf("Error: %s.\n", $stmt->error);
   }else{
   $this->confirmationMessage = 'Payment Options Successfully Updated';
   }

}
//----------------------------------------------------------------------------------------------------------------
function getOptionPerms() {
return($this->optionPerms);
}

function getCashChecked() {
return($this->cashChecked);
}

function getCheckChecked() {
return($this->checkChecked);
}

function getCreditChecked() {
return($this->creditChecked);
}

function getAchChecked() {
return($this->achChecked);
}

function getCashDisabled() {
return($this->cashDisabled);
}

function getCheckDisabled() {
return($this->checkDisabled);
}

function getCreditDisabled() {
return($this->creditDisabled);
}

function getAchDisabled() {
return($this->achDisabled);
}


function getConfirmationMessage() {
return($this->confirmationMessage);
}



}
?>