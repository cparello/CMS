<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  billingSetupSql{

private $merchantId = null;
private $accountMode = null;
private $csUserName = null;
private $csPassword = null;
private $settleMode = null;


function setNewSetup($billing_setup) {
        $this->billingSetup = $billing_setup;
         }
 
        

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//==================================================================================================
function updateBillingSetup()     {

//create a confirmation message for errors


$dbMain = $this->dbconnect();
$sql = "UPDATE billing_setup SET billing_setup= ? WHERE setup_id = '1'";
						
		$stmt = $dbMain->prepare($sql);
		echo($dbMain->error);
		$stmt->bind_param('s', $this->billingSetup);						


if(!$stmt->execute())  {
    return($this->confirmationMessage);
	printf("Error: %s.\n", $stmt->error);
   }else{
   $this->confirmationMessage = "Setup Options Successfully Updated";
   return($this->confirmationMessage);
   }
}
//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------
function loadCurrentSetup() {

//create a confirmation message for errors
$this->confirmation_message = "There was an error retrieving this Merchant Information";

$dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT billing_setup FROM billing_setup WHERE setup_id = '1'");
   echo($dbMain->error);
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($this->currentSetup); 
   $stmt->fetch();

if(!$stmt->execute())  {
    return($this->confirmationMessage);
	printf("Error: %s.\n", $stmt->error);
   }
   $stmt->close();



}
//==================================================================================================

function getCurrentSetup() {
    return($this->currentSetup);
   }





}
?>