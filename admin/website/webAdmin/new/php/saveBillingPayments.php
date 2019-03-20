<?php
session_start();


class saveBillingPayments {

private $contractKey = null;
private $authIdReference = null;
private $todaysPayment = null;
private $cycleDay = null;
private $pastDay = null;
private $monthlyBillingDay = null;
private $paymentDescription = null;
private $transactionKey = null;
private $creditPayment = null;
private $achPayment = null;
private $checkPayment = null;
private $cashPayment = null;
private $balanceDue = '0.00';
private $bundled = 'N';
private $rejectFeeCheck = 0;
private $rejectFeeCredit = 0;
private $rejectFeeAch = 0;
private $lateFeeAll = 0;
private $lateFee = null;
private $nsfRejectFee = null;
private $rejectedPaymentsFee = null;
private $historyKey = null;
private $transKey = null;
private $dueDate = null;
private $checkNumber = 0;
private $nsfCheckNumber = null;
private $transType = null;
private $ccRequestId = 0;
private $achRequestId = 0;


function setContractKey($contractKey) {
           $this->contractKey = $contractKey;
           }
function setPaymentDescription($paymentDescription) {
           $this->paymentDescription = $paymentDescription;
           }
function setTransKey($transKey) {
           $this->transKey = $transKey;
           }
function setTransactionKey($transactionKey) {
           $this->transactionKey = $transactionKey;
           }           
function setCreditPayment($creditPayment) {
           $this->creditPayment = $creditPayment;
           }
function setAchPayment($achPayment) {
           $this->achPayment = $achPayment;
           }
function setCheckPayment($checkPayment) {
           $this->checkPayment = $checkPayment;
           }
function setCashPayment($cashPayment) {
           $this->cashPayment = $cashPayment;
           } 
function setLateFee($lateFee) {
           $this->lateFee = $lateFee;
           }
function setDueDate($dueDate) {
           $this->dueDate = $dueDate;
           }      
function setCheckNumber($checkNumber) {
           $this->checkNumber = $checkNumber;
           }
function setNsfCheckNumber($nsfCheckNumber) {
           $this->nsfCheckNumber = $nsfCheckNumber;
           }
function setNsfRejectFee($nsfRejectFee) {
           $this->nsfRejectFee = $nsfRejectFee;
           }
function setRejectedPaymentsFee($rejectedPaymentsFee) {
           $this->rejectedPaymentsFee = $rejectedPaymentsFee;
           }
function setCcRequestId($ccRequestId) {
           $this->ccRequestId = $ccRequestId;
           }           
function setPayment($payment){
            $this->payment = $payment;
            }

//connect to database
function dbconnect()   {
require"../../../../dbConnect.php";
return $dbMain;              
}
//===============================================================
function insertPaymentHistory() {

 $dbMain = $this->dbconnect();
$sql = "INSERT INTO payment_history VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiddssssiddddisiiiiss', $historyKey, $contractKey, $todaysPayment, $balanceDue, $dueDate, $processDate, $historyDueStatus, $paymentDescription, $statusKey, $creditPayment, $achPayment, $cashPayment, $checkPayment, $checkNumber, $bundled, $rejectFeeCheck, $rejectFeeCredit, $rejectFeeAch, $lateFeeAll, $ccRequestId, $achRequestId);

$historyKey = $this->historyKey;
$contractKey = $this->contractKey;
$todaysPayment = $this->todaysPayment;
$balanceDue = $this->balanceDue;
$bundled = $this->bundled;
$rejectFeeCheck = 0;
$rejectFeeCredit = 0;
$rejectFeeAch = 0;
$lateFeeAll = 0;

//parse the due date
$dueDate = date("Y-m-d");
$processDate = date("Y-m-d");
$historyDueStatus = 'PF';
$paymentDescription = "Scheduler Class Purchase";
$statusKey = 0;
$creditPayment = $this->creditPayment;
$ccRequestId =  $_SESSION['cc_request_id'];
$achPayment = 0;
$achRequestId =  0;
$cashPayment = 0;
$checkPayment = 0;
$checkNumber = 0;


if(!$stmt->execute())  {
    $bit = 0;
	printf("Error: %s.\n  function paymentHistory table payment_history insert", $stmt->error);
   }else{
    $bit = 1;
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
    $bit = 0;
	printf("Error: %s.\n function paymentHistory table payment_history update", $stmt->error);
   }else{
    $bit = 1;
   }		
$stmt->close(); 

$this->authIdReference =  $adjustedStatusKey;

$_SESSION['payment_date'] = date("m/d/Y H:i");
unset($_SESSION['cc_request_id']);


return $bit;
}
//=============================================================
}
//==============================================================================
$credit_pay = $_REQUEST['credit_pay'];
$due_date = $_REQUEST['due_date'];
$transaction_key = $_REQUEST['transaction_key'];
$contract_key = $_REQUEST['contract_key'];
$fee_amount = $_REQUEST['fee_amount'];
$trans_key = $_REQUEST['trans_key'];

$credit_pay = trim($credit_pay);
$due_date = date("Y-m-d");
$cc_request_id = $_SESSION['cc_request_id'];

$billingPayments = new saveBillingPayments();
$billingPayments-> setContractKey($contract_key);
$billingPayments-> setTransactionKey($transaction_key);
$billingPayments-> setCreditPayment($credit_pay);
$billingPayments-> setDueDate($due_date);
$billingPayments-> setCcRequestId($cc_request_id);

 
$success_bit = $billingPayments-> insertPaymentHistory();
     
echo"$success_bit";          
 
?>




    








