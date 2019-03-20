<?php
session_start();

$dbMain = $this->dbconnect();
$sql = "INSERT INTO payment_history VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiddssssiddddisiiiiss', $historyKey, $contractKey, $todaysPayment, $balanceDue, $dueDate, $processDate, $historyDueStatus, $paymentDescription, $statusKey, $creditPayment, $achPayment, $cashPayment, $checkPayment, $checkNumber, $bundled, $rejectFeeCheck, $rejectFeeCredit, $rejectFeeAch, $lateFeeAll, $ccRequestId, $achRequestId);

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
$processDate = date("Y-m-d");

//check if ballance due paid in full
if($balanceDue == "0.00")  {
   $historyDueStatus = 'PF';
   }else{
   $historyDueStatus = 'BD';
   }

$paymentDescription = $this->paymentDescription;

//create a temporary key marker that we may update later
$statusKey = 0;

//here we check for null vals in the payment types and convert them to 0 for insert
if($this->creditPayment == "") {
   $creditPayment = 0;
   $ccRequestId =  $_SESSION['cc_request_id'];
  }else{
   $creditPayment = $this->creditPayment;
   $ccRequestId =  $_SESSION['cc_request_id'];
  }
  
if($this->achPayment == "") {
  $achPayment = 0;
  $achRequestId =  $_SESSION['ach_request_id'];
  }else{
  $achPayment = $this->achPayment;
  $achRequestId =  $_SESSION['ach_request_id'];
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
//$this->authIdReference = $newStatusKey;
   
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

$this->authIdReference =  $adjustedStatusKey;

//==========================================================================================
//here is where we setup the call to auth.net.  We send the unique ID and payment types suche as ACH and CC.









//==========================================================================================
?>