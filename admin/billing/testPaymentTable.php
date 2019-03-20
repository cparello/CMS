<?php
//this will eventually access auth.net and create a payment record for either successful or rejected ach and credit cards

class testPaymentTable {

private $contractKey = null;
private $todaysPayment = null;
private $payType = null;
private $paymentDescription = null;
private $transactionId = null;
private $processAttempts = null;
private $transactionDate = null;
private $transactionMessage = null;
private $historyKey = null;
private $creditPayment = "";
private $cashPayment = "";
private $checkPayment = "";
private $achPayment = "";
private $checkNumber = 0;
private $balanceDue = null;
private $transKey =null;
private $authNetHistoryKey = null;
private $transactionType = null;
private $dueDate = null;
private $bundled = 'N';
private $rejectFeeCheck = 0;
private $rejectFeeCredit = 0;
private $rejectFeeAch = 0;
private $rejectBit = 0;
private $lateFeeAll = 0;
private $pastDay = null;
private $cycleDay = null;



function setContractKey($contractKey) {
              $this->contractKey = $contractKey;
              }
function setTodaysPayment($todaysPayment) {
              $this->todaysPayment = $todaysPayment;
              } 
function setPayType($payType) {
               $this->payType = $payType;
              }
function setPaymentDescription($paymentDescription) {
              $this->paymentDescription = $paymentDescription;
              }
function setDueDate($dueDate) {
              $this->dueDate = $dueDate;
              }              
function setBalanceDue($balanceDue) {
              $this->balanceDue = $balanceDue;
              }              
              
              
function setTransactionId($transactionId) {
                 $this->transactionId = $transactionId;
                 }
function setProcessAttempts($processAttempts) {
                 $this->processAttempts = $processAttempts;
                 }
function setTransactionDate($transactionDate) {
                 $this->transactionDate = $transactionDate;
                 }
function setTransactionMessage($transactionMessage) {
                 $this->transactionMessage = $transactionMessage;
                 }


//---------------------------------------------------------------------------------------------------------------------              
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;              
}
//--------------------------------------------------------------------------------------------------------------------
function deletePastDueAttempts()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("DELETE FROM past_due_attempts WHERE contract_key = '$this->contractKey' ");
$stmt->execute();  


if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		 
$stmt->close(); 

}
//--------------------------------------------------------------------------------------------------------------------
function parseBalanceDue() {

if($this->transactionMessage == 'OK') {
   $this->balanceDue = '0.00';
   }else{
   $this->balanceDue = $this->todaysPayment;
   }

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT past_day, cycle_day FROM billing_cycle WHERE cycle_key ='1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($past_day, $cycle_day);
$stmt->fetch();
$stmt->close();

$this->pastDay = $past_day;
$this->cycleDay = $cycle_day;

$transDateSecs = strtotime($this->transactionDate);
$pastDaysSecs = $past_day * 86400;
$dueDateSecs = $transDateSecs + $pastDaysSecs;
$this->dueDate = date("Y-m-d", $dueDateSecs);


}
//--------------------------------------------------------------------------------------------------------------------
function parsePayType() {

  switch ($this->payType) {
        case "ach":
               $this->achPayment = $this->todaysPayment;
               $this->creditPayment = "";
               $this->transactionType = 'A';
               $this->paymentDescription = 'Monthly Dues ACH';
        break;
        case "credit":
               $this->creditPayment = $this->todaysPayment;
               $this->achPayment = "";
               $this->transactionType = 'C';
               $this->paymentDescription = 'Monthly Dues Credit';
        break;
        }

}
//--------------------------------------------------------------------------------------------------------------------
function savePaymentHistory() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO payment_history VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiddssssiddddisiiii', $historyKey, $contractKey, $todaysPayment, $balanceDue, $dueDate, $processDate, $historyDueStatus, $paymentDescription, $statusKey, $creditPayment, $achPayment, $cashPayment, $checkPayment, $checkNumber, $bundled, $rejectFeeCheck, $rejectFeeCredit, $rejectFeeAch, $lateFeeAll);

$historyKey = $this->historyKey;
$contractKey = $this->contractKey;
$todaysPayment = $this->todaysPayment;
$balanceDue = $this->balanceDue;
$bundled = $this->bundled;
$rejectFeeCheck = $this->rejectFeeCheck;
$rejectFeeCredit = $this->rejectFeeCredit;
$rejectFeeAch = $this->rejectFeeAch;
$lateFeeAll = $this->lateFeeAll;

//parse the due date
$d =  strtotime($this->dueDate);
$dueDate = date("Y-m-d", $d);
$processDate = $this->transactionDate;

//check if ballance due paid in full
if($balanceDue == "0.00")  {
   $historyDueStatus = 'PF';
   }else{
   $historyDueStatus = 'RE';
   }

$paymentDescription = $this->paymentDescription;

//create a temporary key marker that we may update later
$statusKey = 0;

//here we check for null vals in the payment types and convert them to 0 for insert
if($this->creditPayment == "") {
   $creditPayment = 0;
  }else{
  $creditPayment = $this->creditPayment;
  }
  
if($this->achPayment == "") {
   $achPayment = 0;
  }else{
  $achPayment = $this->achPayment;
  }
    
if($this->cashPayment == "") {
   $cashPayment = 0;
  }else{
  $cashPayment = $this->cashPayment;
  }
  
if($this->checkPayment == "") {
  $checkPayment = 0;
  }else{
  $checkPayment = $this->checkPayment;
  }

$checkNumber = $this->checkNumber;


if(!$stmt->execute())  {
	printf("Error: %s.\n  function paymentHistory table payment_history insert", $stmt->error);
   }	
$newStatusKey = $stmt->insert_id;   
$this->authNetHistoryKey = $newStatusKey;
   
$stmt->close(); 

if($this->transKey != null) {
  $adjustedStatusKey = $this->transKey;
  }else{
  $adjustedStatusKey = $newStatusKey;
  }

//here we update the table with the newHistory key.  if there is a problem with the transaction at a later date we will adapt this key as a common key.
$sql = "UPDATE payment_history SET trans_key= ? WHERE history_key = '$newStatusKey'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('i',  $adjustedStatusKey);


if(!$stmt->execute())  {
	printf("Error: %s.\n function paymentHistory table payment_history update", $stmt->error);
   }		
$stmt->close(); 


}
//-------------------------------------------------------------------------------------------------------------------
function saveRejectedPayments()  {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO rejected_payments VALUES (?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iidssiisi', $contractKey, $historyKey, $paymentAmount, $transactionType, $rejectMessage, $processAttempts, $transactionId, $lastAttemptDate, $rejectBit);

$contractKey = $this->contractKey;
$historyKey = $this->authNetHistoryKey;
$paymentAmount = $this->todaysPayment;
$transactionType = $this->transactionType;
$rejectMessage = $this->transactionMessage;
$processAttempts = $this->processAttempts;
$transactionId = $this->transactionId;
$lastAttemptDate = $this->transactionDate;
$rejectBit = $this->rejectBit;


if(!$stmt->execute())  {
	printf("Error: %s.\n function saveRejectedPayments table rejected_payments insert", $stmt->error);
   }		
$stmt->close(); 

}
//--------------------------------------------------------------------------------------------------------------------
function  saveMonthlySettled()  {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO monthly_settled VALUES (?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iidss', $contractKey, $transKey, $paymentAmount, $paymentDate, $nextPaymentDueDate);

$contractKey = $this->contractKey;
$transKey = $this->authNetHistoryKey;
$paymentAmount = $this->todaysPayment;
$paymentDate = $this->transactionDate;
 
 $nextMonthsBillingDate = date("Y-m-d"  ,mktime(0, 0, 0, date("m")+1  , $this->cycleDay, date("Y")));
 $nextMonthsBillingDateSecs = strtotime($nextMonthsBillingDate);
 $pastDaysDueSecs = $this->pastDay * 86400;
 $nextPaymentDueDateSecs = $nextMonthsBillingDateSecs + $pastDaysDueSecs;
 $nextPaymentDueDate = date("Y-m-d",  $nextPaymentDueDateSecs);


if(!$stmt->execute())  {
	printf("Error: %s.\n function saveMonthlySettled table monthly_settled insert", $stmt->error);
   }		
$stmt->close(); 

echo"Done";
}
//-------------------------------------------------------------------------------------------------------------------


}

//============================================================================

$contract_key = '1705';
$todays_payment = '23.33';
$pay_type = 'ach';

//$due_date = date("Y-m-d"); 

$transaction_message = 'declined';
$tranasaction_id = '3467';
$process_attempts = 3;
$transaction_date = date("Y-m-d");


$testPayment = new testPaymentTable();
$testPayment-> setContractKey($contract_key);
$testPayment-> setTodaysPayment($todays_payment);
$testPayment-> setPayType($pay_type);
//$testPayment-> setDueDate($due_date);
$testPayment-> setTransactionMessage($transaction_message);
$testPayment-> setTransactionDate($transaction_date);

$testPayment-> parsePayType();
$testPayment-> parseBalanceDue();
$testPayment-> savePaymentHistory();

if($transaction_message != 'OK') {
   $testPayment-> setProcessAttempts($process_attempts);
   $testPayment-> setTransactionId($tranasaction_id);   
   $testPayment-> saveRejectedPayments();
 }else{
   $testPayment-> saveMonthlySettled(); 
   $testPayment-> deletePastDueAttempts();
 }

/*
DROP TABLE IF EXISTS rejected_payments;
CREATE TABLE rejected_payments (
contract_key   INT(20) NOT NULL,
history_key INT(10) NOT NULL,
payment_amount  DECIMAL(10,2) NOT NULL, 
transaction_type ENUM("C","A") NOT NULL,
reject_message CHAR(60) NOT NULL,
process_attempts  INT(10) NOT NULL,
transaction_id INT(10) NOT NULL,
last_attempt_date DATE NOT NULL
);


DROP TABLE IF EXISTS payment_history;
CREATE TABLE  payment_history (
history_key  INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
contract_key   INT(20) NOT NULL,
payment_amount  DECIMAL(10,2)  NOT NULL,
balance_due DECIMAL(10,2) NOT NULL,
payment_due_date DATE NOT NULL,
payment_date DATE NOT NULL,
payment_flag ENUM('PF','BD') NOT NULL,
payment_description CHAR(30) NOT NULL,
trans_key INT(20) NOT NULL,
credit_payment DECIMAL(10,2) NOT NULL,
ach_payment DECIMAL(10,2) NOT NULL,
cash_payment DECIMAL(10,2) NOT NULL,
check_payment DECIMAL(10,2) NOT NULL,
check_number INT(1) NOT NULL
);
*/













?>