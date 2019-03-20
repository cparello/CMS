<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  merchantSql{

private $merchantId = null;
private $accountMode = null;
private $csUserName = null;
private $csPassword = null;
private $settleMode = null;


function setMerchantId($merchantId) {
        $this->merchantId = $merchantId;
         }
function setAccountMode($accountMode) {
        $this->accountMode = $accountMode;
         }               
function setCsUserName($csUserName) {
        $this->csUserName = $csUserName;
         }
function setCsPassword($csPassword) {
        $this->csPassword = $csPassword;
         }
function  setSettleMode($settleMode) {
        $this->settleMode = $settleMode;
        }
         
        

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//==================================================================================================
function updateProcessorOptions()     {

//create a confirmation message for errors
$this->confirmationMessage = "There was an error updating the Transaction Processor Options";

$dbMain = $this->dbconnect();
$sql = "UPDATE gateway_info SET merchant_id= ?, account_mode= ? WHERE transaction_key_test != ''";
						
		$stmt = $dbMain->prepare($sql);
		echo($dbMain->error);
		$stmt->bind_param('si', $merchantId, $accountMode);						

$merchantId = $this->merchantId; 
$accountMode = $this->accountMode;

if(!$stmt->execute())  {
    return($this->confirmationMessage);
	printf("Error: %s.\n", $stmt->error);
   }else{
   $this->confirmationMessage = "CyberSource Processor Options Successfully Updated";
   return($this->confirmationMessage);
   }
}
//----------------------------------------------------------------------------------------------------------------------------------------------------
function updateSettlementOptions()     {

//create a confirmation message for errors
$this->confirmationMessage = "There was an error updating the Transaction Settlement Options";

$dbMain = $this->dbconnect();
$sql = "UPDATE cs_report_info SET user_name= ?, password= ?, passkey= ? WHERE live_link != ''";
						
		$stmt = $dbMain->prepare($sql);
		echo($dbMain->error);
		$stmt->bind_param('ssi', $csUserName, $csPassword, $settleMode);						

$csUserName = $this->csUserName; 
$csPassword = $this->csPassword;
$settleMode = $this->settleMode;


if(!$stmt->execute())  {
    return($this->confirmationMessage);
	printf("Error: %s.\n", $stmt->error);
   }else{
   $this->confirmationMessage = "CyberSource Settlement Options Successfully Updated";
   return($this->confirmationMessage);
   }
}
//----------------------------------------------------------------------------------------------------------------------------------------------------
function loadMerchantOptions() {

//create a confirmation message for errors
$this->confirmation_message = "There was an error retrieving this Merchant Information";

$dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT merchant_id, account_mode FROM gateway_info WHERE transaction_key_test != ''");
   echo($dbMain->error);
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($merchantId, $accountMode); 
   $stmt->fetch();

   $this->merchantId = $merchantId; 
   $this->accountMode = $accountMode;

if(!$stmt->execute())  {
    return($this->confirmationMessage);
	printf("Error: %s.\n", $stmt->error);
   }
   $stmt->close();


   $stmt = $dbMain ->prepare("SELECT user_name, password, passkey FROM cs_report_info WHERE live_link != ''");
   echo($dbMain->error);
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($csUserName, $csPassword, $settleMode); 
   $stmt->fetch();

   $this->csUserName = $csUserName;
   $this->csPassword = $csPassword;
   $this->settleMode = $settleMode;

if(!$stmt->execute())  {
    return($this->confirmationMessage);
	printf("Error: %s.\n", $stmt->error);
   }
   $stmt->close();

}
//==================================================================================================
function getMerchantId() {
    return($this->merchantId);
   }
function getAccountMode() {
    return($this->accountMode);
   }
function getSettleMode() {
    return($this->settleMode);
   }
function getCsUserName() {
    return($this->csUserName);
   }
function getCsPassword() {
    return($this->csPassword);
   }





}
?>