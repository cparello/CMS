<?php
session_start();

if (!isset($_SESSION['admin_access']))  {
exit;
}

class updateLocations {

private $contractKey = null;
private $currentMonthDueDate = null;
private $nextPaymentDueDate = null;
private $monthsPastDue = null;
private $nextMonthDueDate = null;
private $settledCount = 0;
private $prePayCount = null;
private $monthlyCount = null;
private $todaysDate = null;
private $listType = null;
private $counter = 1;
private $color = null;
private $firstName = null;
private $middleName = null;
private $lastName = null;
private $primaryPhone = null;
private $cellPhone = null;
private $emailAddress = null;
private $clientStreet = null;
private $clientCity = null;
private $clientState = null;
private $clientZip = null;
private $daysPastDue = null;
private $monthlyPayment = null;
private $monthlyBillingType = null;
private $billingTotal = null;
private $lateFee = null;
private $pastDueHeader = null;
private $pastDueText = null;
private $defaultAttempts = null;
private $pastDueFreq = null;
private $attemptDate = null;
private $attemptNum = null;
private $finalNum = '10';
private $invoiceHeader = null;
private $finalHeader = null;
private $finalText = null;
private $currentStatementDate = null;
private $statementRangeEndDate = null;
private $statementRangeStartDate =  null;
private $businessName = null;
private $businessStreet = null;
private $businessCity = null;
private $businessState = null;
private $businessZip = null;
private $parseLength = 0;
private $invoice = null;
private $mailHeader = null;
private $mailFooter = null;
private $printableInvoice = null;
private $amendKey = null;
private $imageName = null;
private $pastDay = null;
private $nextDueDaysPast = null;
private $cycleDay = null;

function setContractKey($contractKey) {
              $this->contractKey = $contractKey;
              }
function  setTermText($text){
              $this->termText = $text;
              }
function  setServName($servName){
              $this->servName = $servName;
              }
function  setLocId($locId){
              $this->locId = $locId;
              }
function  setServiceKey($service_key){
              $this->serviceKey = $service_key;
              }
//---------------------------------------------------------------------------------------------------------------------              
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;              
}

//--------------------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------------------
function updateLocation() {
$termArr = explode(' ',$this->termText);
$service_quantity = $termArr[0];
$service_term = substr($termArr[1],0,1);
     $dbMain = $this->dbconnect();
     if(preg_match('/Monthly/',$this->servName)){
     $sql = "UPDATE monthly_services SET club_id= ? WHERE contract_key = '$this->contractKey' AND service_name = '$this->servName' AND number_months = '$service_quantity'";
     $stmt = $dbMain->prepare($sql);
     $stmt->bind_param('s', $this->locId);
     $stmt->execute();
     $stmt->close(); 
     
     $stmt = $dbMain ->prepare("SELECT service_id FROM monthly_services  WHERE contract_key= '$this->contractKey'  AND service_name = '$this->servName' AND number_months = '$service_quantity'");
    $stmt->execute();      
    $stmt->store_result();  
    $stmt->bind_result($service_id);
    $stmt->fetch();
     $stmt->close();
      
     }else{
      //  echo "$this->contractKey' AND service_name = '$this->servName' AND service_quantity = '$service_quantity' AND service_term = '$service_term'";
      // exit;
        $sql = "UPDATE paid_full_services SET club_id= ? WHERE contract_key = '$this->contractKey' AND service_name = '$this->servName' AND service_quantity = '$service_quantity' AND service_term = '$service_term'";
     $stmt = $dbMain->prepare($sql);
     $stmt->bind_param('s', $this->locId);
     $stmt->execute();
     $stmt->close(); 
     
     $stmt = $dbMain ->prepare("SELECT service_id FROM paid_full_services  WHERE contract_key= '$this->contractKey'  AND service_name = '$this->servName' AND service_quantity = '$service_quantity' AND service_term = '$service_term'");
    $stmt->execute();      
    $stmt->store_result();  
    $stmt->bind_result($service_id);
    $stmt->fetch();
     $stmt->close(); 
     }
     
     
      $sql = "UPDATE account_status SET club_id= ? WHERE service_id = '$service_id'";
     $stmt = $dbMain->prepare($sql);
     $stmt->bind_param('s', $this->locId);
     $stmt->execute();
     $stmt->close(); 
//echo "fubar";
//exit;
}
//===========================================================================
//--------------------------------------------------------------------------------------------------------------------
function updateMembership() {
    
$termArr = explode(' ',$this->termText);
$service_quantity = $termArr[0];
$service_term = substr($termArr[1],0,1);
     $dbMain = $this->dbconnect();
     if(preg_match('/Monthly/',$this->servName)){
     $sql = "UPDATE monthly_services SET service_name= ?, service_key=? WHERE contract_key = '$this->contractKey' AND number_months = '$service_quantity'";
     $stmt = $dbMain->prepare($sql);
     $stmt->bind_param('ss', $this->servName , $this->serviceKey);
     $stmt->execute();
     $stmt->close(); 
     
     $stmt = $dbMain ->prepare("SELECT service_id FROM monthly_services  WHERE contract_key= '$this->contractKey'  AND service_name = '$this->servName' AND number_months = '$service_quantity' AND service_key = '$this->serviceKey'");
    $stmt->execute();      
    $stmt->store_result();  
    $stmt->bind_result($service_id);
    $stmt->fetch();
     $stmt->close();
      
     }else{
      //  echo "$this->contractKey' AND service_name = '$this->servName' AND service_quantity = '$service_quantity' AND service_term = '$service_term'";
      // exit;
        $sql = "UPDATE paid_full_services SET service_name= ?, service_key=? WHERE contract_key = '$this->contractKey' AND service_quantity = '$service_quantity' AND service_term = '$service_term'";
     $stmt = $dbMain->prepare($sql);
     $stmt->bind_param('ss',$this->servName , $this->serviceKey);
     $stmt->execute();
     $stmt->close(); 
     
     $stmt = $dbMain ->prepare("SELECT service_id FROM paid_full_services  WHERE contract_key= '$this->contractKey'  AND service_name = '$this->servName' AND service_quantity = '$service_quantity' AND service_term = '$service_term'");
    $stmt->execute();      
    $stmt->store_result();  
    $stmt->bind_result($service_id);
    $stmt->fetch();
     $stmt->close(); 
     }
     
     
      $sql = "UPDATE account_status SET service_key= ? WHERE service_id = '$service_id'";
     $stmt = $dbMain->prepare($sql);
     $stmt->bind_param('s', $this->serviceKey);
     $stmt->execute();
     $stmt->close(); 
//echo "fubar";
//exit;
}
//===================================================================================
}//end class
//----------------------------------------------------------------------
$contract_key = $_REQUEST['contractKey'];
$ajax_switch = $_REQUEST['ajaxSwitch'];
$termText = $_REQUEST['termText'];
$servName = $_REQUEST['servName'];
$locationId = $_REQUEST['locationId'];
$serviceKey = $_REQUEST['serviceKey'];
   //echo " $contract_key  $termText  $servName $locationId";
 //  exit;
if($ajax_switch == 1) {
  $update = new updateLocations();
  $update-> setContractKey($contract_key);
  $update-> setTermText($termText);
  $update-> setServName($servName);
  $update-> setLocId($locationId);
  $update-> updateLocation();
  
  }
  
  if($ajax_switch == 2) {
  $update = new updateLocations();
  $update-> setContractKey($contract_key);
  $update-> setTermText($termText);
  $update-> setServName($servName);
  $update-> setLocId($locationId);
  $update-> setServiceKey($serviceKey);
  $update-> updateMembership();
  
  }

echo '1';
exit;









?>