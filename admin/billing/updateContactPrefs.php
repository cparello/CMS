<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class updateContactPrefs {

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
function  setValue($value){
              $this->value = $value;
              }
//---------------------------------------------------------------------------------------------------------------------              
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;              
}

//--------------------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------------------
function updateCallHome() {

     $dbMain = $this->dbconnect();
     $sql = "UPDATE contact_preferences SET do_not_call_home= ? WHERE contract_key = '$this->contractKey'";
     $stmt = $dbMain->prepare($sql);
     $stmt->bind_param('s', $this->value);
     $stmt->execute();
     $stmt->close(); 

}
//--------------------------------------------------------------------------------------------------------------------
function updateCallCell() {

     $dbMain = $this->dbconnect();
     $sql = "UPDATE contact_preferences SET do_not_call_cell= ? WHERE contract_key = '$this->contractKey'";
     $stmt = $dbMain->prepare($sql);
     $stmt->bind_param('s', $this->value);
     $stmt->execute();
     $stmt->close(); 

}
//--------------------------------------------------------------------------------------------------------------------
function updateText() {

     $dbMain = $this->dbconnect();
     $sql = "UPDATE contact_preferences SET do_not_text= ? WHERE contract_key = '$this->contractKey'";
     $stmt = $dbMain->prepare($sql);
     $stmt->bind_param('s', $this->value);
     $stmt->execute();
     $stmt->close(); 

}
//--------------------------------------------------------------------------------------------------------------------
function updateMail() {

     $dbMain = $this->dbconnect();
     $sql = "UPDATE contact_preferences SET do_not_mail= ? WHERE contract_key = '$this->contractKey'";
     $stmt = $dbMain->prepare($sql);
     $stmt->bind_param('s', $this->value);
     $stmt->execute();
     $stmt->close(); 

}
//--------------------------------------------------------------------------------------------------------------------
function updateEmail() {

     $dbMain = $this->dbconnect();
     $sql = "UPDATE contact_preferences SET do_not_email= ? WHERE contract_key = '$this->contractKey'";
     $stmt = $dbMain->prepare($sql);
     $stmt->bind_param('s', $this->value);
     $stmt->execute();
     $stmt->close(); 

}
//--------------------------------------------------------------------------------------------------------------------
function updatePreference() {

     $dbMain = $this->dbconnect();
     $sql = "UPDATE contact_preferences SET prefered_contact_method= ? WHERE contract_key = '$this->contractKey'";
     $stmt = $dbMain->prepare($sql);
     $stmt->bind_param('s', $this->value);
     $stmt->execute();
     $stmt->close(); 

}
//-------------------------------------------------------------------------------------------------------------------

}//end class
//----------------------------------------------------------------------
$contract_key = $_REQUEST['contractKey'];
$ajax_switch = $_REQUEST['ajaxSwitch'];
$value = $_REQUEST['checked'];

require"../dbConnect.php";
$stmt = $dbMain ->prepare("SELECT COUNT(*) as count FROM contact_preferences WHERE contract_key = '$contract_key'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($count);
 $stmt->fetch();
 $stmt->close();
 
 if($count == 0){
    $no = 'N';
    $none = 'none';
    $sql = "INSERT INTO contact_preferences VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('issssss', $contract_key, $no, $no, $no, $no, $no, $none); 
    $stmt->execute();
    $stmt->close(); 
 }
   
if($ajax_switch == 1) {
  $update = new updateContactPrefs();
  $update-> setContractKey($contract_key);
  $update-> setValue($value);
  $update-> updateCallHome();
  
  }
  
if($ajax_switch == 2) {
  $update = new updateContactPrefs();
  $update-> setContractKey($contract_key);
  $update-> setValue($value);
  $update-> updateCallCell();
  
  }
if($ajax_switch == 3) {
  $update = new updateContactPrefs();
  $update-> setContractKey($contract_key);
  $update-> setValue($value);
  $update-> updateText();
  
  }
if($ajax_switch == 4) {
  $update = new updateContactPrefs();
  $update-> setContractKey($contract_key);
  $update-> setValue($value);
  $update-> updateEmail();
  
  }
if($ajax_switch == 5) {
  $update = new updateContactPrefs();
  $update-> setContractKey($contract_key);
  $update-> setValue($value);
  $update-> updateMail();
  
  }
if($ajax_switch == 6) {
  $update = new updateContactPrefs();
  $update-> setContractKey($contract_key);
  $update-> setValue($value);
  $update-> updatePreference();
  
  }

echo '1';
exit;









?>