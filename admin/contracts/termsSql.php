<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  termsSql{

private $termsConditions;
private $contractQuit;
private $confirmation;
private $errorMessage;
private $liabilityTerms;


function setTermsConditions($termsConditions) {
        $this->termsConditions = $termsConditions;
         }

function setContractQuit($contractQuit)  {
		$this->contractQuit= $contractQuit;
		  }

function setLiabilityTerms($liabilityTerms)  {
		$this->liabilityTerms= $liabilityTerms;
		  }
		  	  
		  

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//----------------------------------------------------------------------------------------------------------------------------------------------------
function updateLiabilityTerms()     {

//create a confirmation message for errors
$this->errorMessage = "There was an error saving this information";
$this->confirmationMessage = "Liability Terms successfully Updated";

$dbMain = $this->dbconnect();


$sql = "UPDATE contract_defaults SET liability_terms= ? WHERE contract_key = '1'";
						
		$stmt = $dbMain->prepare($sql);
		echo($dbMain->error);
		$stmt->bind_param('s',$liabilityTerms);						

 $liabilityTerms = $this->liabilityTerms;

if(!$stmt->execute())  {
    return($this->errorMessage);
    printf("Error: %s.\n", $stmt->error);
	exit;
   }
   
  }

//==================================================================================================
function updateTerms()     {

//create a confirmation message for errors
$this->errorMessage = "There was an error saving this information";
$this->confirmationMessage = "Terms successfully Updated";

$dbMain = $this->dbconnect();


$sql = "UPDATE contract_defaults SET contract_terms= ?, contract_quit=? WHERE contract_key = '1'";
						
		$stmt = $dbMain->prepare($sql);
		echo($dbMain->error);
		$stmt->bind_param('si',$termsConditions, $contractQuit);						

 $termsConditions = $this->termsConditions;
 $contractQuit = $this->contractQuit;



if(!$stmt->execute())  {
    return($this->errorMessage);
    printf("Error: %s.\n", $stmt->error);
	exit;
   }
   
  }
//----------------------------------------------------------------------------------------------------------------------------------------------------
function loadTerms() {

//create a confirmation message for errors
$this->errorMessage = "There was an error retrieving this information";

$dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT contract_terms, contract_quit, liability_terms  FROM contract_defaults WHERE contract_key = '1'");
   echo($dbMain->error);
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($termsConditions, $contractQuit, $liabilityTerms); 
   $stmt->fetch();

$this->contractQuit = $contractQuit; 
$this->termsConditions = $termsConditions;
$this->liabilityTerms = $liabilityTerms;


if(!$stmt->execute())  {
    return($this->errorMessage);
	printf("Error: %s.\n", $stmt->error);
	exit;
   }

}

//==================================================================================================
function getTermsConditions() {
 return($this->termsConditions);
}

function getContractQuit() {
 return($this->contractQuit);
}

function getLiabilityTerms() {
 return($this->liabilityTerms);
}

function getConfirmation() {
 return($this->confirmationMessage);
}





}
?>