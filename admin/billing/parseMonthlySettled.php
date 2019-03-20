<?php


class parseMonthlySettled {

private $listSwitch = null;
private $clientEmail = null;


private $contractKey = null;
private $todaysPayment = null;
private $payType = null;
private $paymentDescription = null;
private $transactionDate = null;
private $dueDate = null;
private $transactionMessage = null;
private $historyKey = null;
private $creditPayment = "";
private $cashPayment = "";
private $checkPayment = "";
private $achPayment = "";
private $balanceDue = '0.00';
private $checkNumber = 0;
private $rejectFeeCheck = 0;
private $rejectFeeCredit = 0;
private $rejectFeeAch = 0;
private $rejectBit = 0;
private $lateFeeAll = 0;
private $pastDay = null;
private $cycleDay = null;
private $authNetHistoryKey = null;
private $nextPaymentDueDate = null;
private $bundled = 'N';
private $dateSwitch = null;
private $sqlLimitNumber = null;
private $sqlLimit = null;


function setDateSwitch($dateSwitch) {
           $this->dateSwitch = $dateSwitch;
           }
           
function setClientEmail($clientEmail) {
           $this->clientEmail = $clientEmail;
           }           
           
function setPaymentDescription($paymentDescription) {
           $this->paymentDescription= $paymentDescription;
           } 
           
function setTransactionDate($transactionDate) {
           $this->transactionDate = $transactionDate;
           }
           
function setSqlLimitNumber($sqlLimitNumber) {
           $this->sqlLimitNumber = $sqlLimitNumber;
           }
//---------------------------------------------------------------------------------------------------------------------              
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;              
}
//--------------------------------------------------------------------------------------------------------------------
function loadCycleDates() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT past_day, cycle_day FROM billing_cycle WHERE cycle_key ='1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($past_day, $cycle_day);
$stmt->fetch();
$stmt->close();

$this->pastDay = $past_day;
$this->cycleDay = $cycle_day;
$nextDueDaysPast = $this->pastDay + $this->cycleDay;

if($this->dateSwitch == 1) { 

   $this->transactionDate = date("Y-m-d"  ,mktime(0, 0, 0, date("m") -1  , $this->cycleDay, date("Y")));
   $this->nextPaymentDueDate =  date("Y-m-d"  ,mktime(0, 0, 0, date("m")  , $nextDueDaysPast, date("Y")));
   
   }elseif($this->dateSwitch == 2) {
   
             $this->transactionDate = date("Y-m-d");
             $nextMonthsBillingDate = date("Y-m-d"  ,mktime(0, 0, 0, date("m")+1  , $this->cycleDay, date("Y")));
             $nextMonthsBillingDateSecs = strtotime($nextMonthsBillingDate);
             $pastDaysDueSecs = $this->pastDay * 86400;
             $nextPaymentDueDateSecs = $nextMonthsBillingDateSecs + $pastDaysDueSecs;
             $this->nextPaymentDueDate = date("Y-m-d",  $nextPaymentDueDateSecs);
             
   }

$transDateSecs = strtotime($this->transactionDate);
$pastDaysSecs = $this->pastDay * 86400;
$dueDateSecs = $transDateSecs + $pastDaysSecs;
$this->dueDate = date("Y-m-d", $dueDateSecs);

if($this->sqlLimitNumber != null) {
   $this->sqlLimit  = "LIMIT $this->sqlLimitNumber";
  }else{
   $this->sqlLimit  = ""; 
  }


}
//--------------------------------------------------------------------------------------------------------------------
function updateClientEmail() {

$dbMain = $this->dbconnect();
$sql = "UPDATE contract_info SET email= ? WHERE contract_id != '0' ";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('s', $clientEmail);

$clientEmail = $this->clientEmail;

   if(!$stmt->execute())  {
	  printf("Error: %s.\n  contract_info  function updateClientEmail  upgrade", $stmt->error);
     }		
     $stmt->close(); 

}
//---------------------------------------------------------------------------------------------------------------------
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


$this->saveMonthlySettled();


}
//----------------------------------------------------------------------------------------------------------------------
function  saveMonthlySettled()  {

$dbMain = $this->dbconnect();

if($this->sqlLimitNumber != null)  {

   $sql = "UPDATE monthly_settled SET payment_amount= ?, trans_key= ?, payment_date= ?, next_payment_due_date=?  WHERE contract_key = '$this->contractKey'";
   $stmt = $dbMain->prepare($sql);
   $stmt->bind_param('diss',  $paymentAmount, $transKey, $paymentDate, $nextPaymentDueDate); 
   
   $transKey = $this->authNetHistoryKey;
   $paymentAmount = $this->todaysPayment;
   $paymentDate = $this->transactionDate;
   $nextPaymentDueDate = $this->nextPaymentDueDate;
    

   if(!$stmt->execute())  {
      printf("Error: %s.\n", $stmt->error);
     }		
   $stmt->close();  

}else{

   $sql = "INSERT INTO monthly_settled VALUES (?,?,?,?,?)";
   $stmt = $dbMain->prepare($sql);
   $stmt->bind_param('iidss', $contractKey, $transKey, $paymentAmount, $paymentDate, $nextPaymentDueDate);

   $contractKey = $this->contractKey;
   $transKey = $this->authNetHistoryKey;
   $paymentAmount = $this->todaysPayment;
   $paymentDate = $this->transactionDate;
   $nextPaymentDueDate = $this->nextPaymentDueDate;


   if(!$stmt->execute())  {
    	printf("Error: %s.\n function saveMonthlySettled table monthly_settled insert", $stmt->error);
      }		
   $stmt->close(); 

}

}

//----------------------------------------------------------------------------------------------------------------------
function insertPaymentSettled() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT contract_key, monthly_billing_type, billing_amount FROM monthly_payments WHERE billing_amount > '0.00' AND contract_key != '0' $this->sqlLimit");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($contractKey, $monthlyBillingType, $billingAmount);

 while ($stmt->fetch()) { 
 
          $this->contractKey = $contractKey;
          $this->todaysPayment = $billingAmount;
          
           switch($monthlyBillingType) {          
                       case"CR":
                       $this->creditPayment = $billingAmount;
                       $this->paymentDescription = 'Monthly Dues Credit';
                       break;
                       case"BA":
                       $this->achPayment = $billingAmount;
                       $this->paymentDescription = 'Monthly Dues ACH';
                       break;
                       case"CH":
                       $this->checkPayment = $billingAmount;
                       $this->paymentDescription = 'Monthly Dues Check';
                       break;
                       case"CA":
                       $this->cashPayment = $billingAmount;
                       $this->paymentDescription = 'Monthly Dues Cash';
                       break;
                       }
                       
$this->savePaymentHistory();

 
 echo"$this->contractKey $this->paymentDescription $this->todaysPayment $this->transactionDate $this->nextPaymentDueDate<br>";
 
 }





$stmt->close();

}
//----------------------------------------------------------------------------------------------------------------------

}

//uncomment the list switch to run this app
//$list_switch = 1;


//set the date switch to 1 to set a transaction for the previous month, set this to 2 to set as a current payment
$date_switch = 2;

$client_email = 'pete@burbankathleticclub.com';
$payment_description = 'Monthly Dues Cash';

//this sets the limit for records inserted or updated. If set to null then it will process all records as an insert.  If set to a number it will update
$sql_limit_number = "40";

$listParse = new parseMonthlySettled();
$listParse-> setClientEmail($client_email);
$listParse-> setDateSwitch($date_switch);
$listParse-> setSqlLimitNumber($sql_limit_number);
$listParse-> loadCycleDates();

if($list_switch == 1) {
  $listParse-> updateClientEmail();
  $listParse-> insertPaymentSettled();
  }













?>