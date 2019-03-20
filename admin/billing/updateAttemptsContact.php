<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class updateContactAttempts {

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
function setReport($report){
              $this->reportType = $report;
              }
function setMonth($month){
              $this->month = $month;
              }
function setYear($year){
              $this->year = $year;
              }
//---------------------------------------------------------------------------------------------------------------------              
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;              
}

//--------------------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------------------
function updatePSMS() {

     $dbMain = $this->dbconnect();
     $sql = "UPDATE account_phone_spam_check SET num_text_primary= ? WHERE contract_key = '$this->contractKey' AND report_type = '$this->reportType' AND month = '$this->month' AND year = '$this->year'";
     $stmt = $dbMain->prepare($sql);
     $stmt->bind_param('s', $this->value);
     $stmt->execute();
     $stmt->close(); 

}
//--------------------------------------------------------------------------------------------------------------------
function updatePCALL() {

     $dbMain = $this->dbconnect();
     $sql = "UPDATE account_phone_spam_check SET num_calls_primary= ? WHERE contract_key = '$this->contractKey'  AND report_type = '$this->reportType' AND month = '$this->month' AND year = '$this->year'";
     $stmt = $dbMain->prepare($sql);
     $stmt->bind_param('s', $this->value);
     $stmt->execute();
     $stmt->close(); 
   //  echo "$this->contractKey    $this->reportType  $this->month  $this->year";
 // exit;

}
//--------------------------------------------------------------------------------------------------------------------
function updateCSMS() {

     $dbMain = $this->dbconnect();
     $sql = "UPDATE account_phone_spam_check SET num_text_cell= ? WHERE contract_key = '$this->contractKey'  AND report_type = '$this->reportType' AND month = '$this->month' AND year = '$this->year'";
     $stmt = $dbMain->prepare($sql);
     $stmt->bind_param('s', $this->value);
     $stmt->execute();
     $stmt->close(); 

}
//--------------------------------------------------------------------------------------------------------------------
function updateCCALL() {

     $dbMain = $this->dbconnect();
     $sql = "UPDATE account_phone_spam_check SET num_calls_cell= ? WHERE contract_key = '$this->contractKey'  AND report_type = '$this->reportType' AND month = '$this->month' AND year = '$this->year'";
     $stmt = $dbMain->prepare($sql);
     $stmt->bind_param('s', $this->value);
     $stmt->execute();
     $stmt->close(); 

}
//--------------------------------------------------------------------------------------------------------------------
function updateEMAIL() {

     $dbMain = $this->dbconnect();
     $sql = "UPDATE account_phone_spam_check SET num_emails= ? WHERE contract_key = '$this->contractKey'  AND report_type = '$this->reportType' AND month = '$this->month' AND year = '$this->year'";
     $stmt = $dbMain->prepare($sql);
     $stmt->bind_param('s', $this->value);
     $stmt->execute();
     $stmt->close(); 

}
//--------------------------------------------------------------------------------------------------------------------

}//end class
//----------------------------------------------------------------------
$contract_key = $_REQUEST['contractKey'];
$ajax_switch = $_REQUEST['ajaxSwitch'];
$report = $_REQUEST['reportType'];
$month = $_REQUEST['month'];
$year = $_REQUEST['year'];
$value = $_REQUEST['attempts'];

require"../dbConnect.php";
$stmt = $dbMain ->prepare("SELECT COUNT(*) as count FROM account_phone_spam_check WHERE contract_key = '$contract_key' AND report_type = '$report' AND month = '$month' AND year = '$year'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($count);
 $stmt->fetch();
 $stmt->close();
 
 if($count == 0){
    $no = '0';
    $sql = "INSERT INTO account_phone_spam_check VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('isiiiiiii', $contract_key, $report, $month, $year, $no, $no, $no, $no, $no); 
    $stmt->execute();
    $stmt->close(); 
 }
   
if($ajax_switch == 1) {
  $update = new updateContactAttempts();
  $update-> setContractKey($contract_key);
  $update-> setValue($value);
  $update-> setReport($report);
  $update-> setMonth($month);
  $update-> setYear($year);
  $update-> updatePSMS();
  
  }
  
if($ajax_switch == 2) {
  $update = new updateContactAttempts();
  $update-> setContractKey($contract_key);
  $update-> setValue($value);
  $update-> setReport($report);
  $update-> setMonth($month);
  $update-> setYear($year);
  $update-> updatePCALL();
  
  
  }
if($ajax_switch == 3) {
  $update = new updateContactAttempts();
  $update-> setContractKey($contract_key);
  $update-> setValue($value);
  $update-> setReport($report);
  $update-> setMonth($month);
  $update-> setYear($year);
  $update-> updateCSMS();
  
  }
if($ajax_switch == 4) {
  $update = new updateContactAttempts();
  $update-> setContractKey($contract_key);
  $update-> setValue($value);
  $update-> setReport($report);
  $update-> setMonth($month);
  $update-> setYear($year);
  $update-> updateCCALL();
  
  }
if($ajax_switch == 5) {
  $update = new updateContactAttempts();
  $update-> setContractKey($contract_key);
  $update-> setValue($value);
  $update-> setReport($report);
  $update-> setMonth($month);
  $update-> setYear($year);
  $update-> updateEMAIL();
  
  }


echo '1';
exit;









?>