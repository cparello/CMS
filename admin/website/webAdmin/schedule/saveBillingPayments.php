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
require"../../../dbConnect.php";
return $dbMain;              
}
//===============================================================
function insertPaymentHistory() {

   require('../../../helper_apps/paymentHistory.php');  


$_SESSION['payment_date'] = date("m/d/Y H:i");
unset($_SESSION['cc_request_id']);

}
//--------------------------------------------------------------------------------------------------------------
function generateTransKey() {

$this->transKey = rand(100, 10000);
$this->authIdReference = rand(100, 10000);

}
//--------------------------------------------------------------------------------------------------------------
function  saveMonthlySettled()  {

$dbMain = $this->dbconnect();
$contractKey = $this->contractKey;
$contract_keyTWO = '';

$stmt = $dbMain ->prepare("SELECT contract_key FROM monthly_settled WHERE contract_key = '$contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($contract_keyTWO);
$stmt->fetch();

$contract_keyTWO = trim($contract_keyTWO);
//echo"fubar $contract_keyTWO";


$transKey =  $this->authIdReference;
$paymentAmount = $this->todaysPayment;
$paymentDate = date("Y-m-d H:i:s");
         
$this->loadBillingDay();
         
         //current billing date
$currentBillingDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, date("m"), $this->cycleDay, date("Y")));
$currentBillingDateSecs = strtotime($currentBillingDate);
$todaysDateSeconds = strtotime($paymentDate);
         
if($todaysDateSeconds <= $currentBillingDateSecs) {
           $billingDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, date("m"), $this->cycleDay, date("Y")));
           }else{
           $billingDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, date("m")+1  , $this->cycleDay, date("Y")));   
           }
         
$billingDateSecs = strtotime($billingDate);
$pastDaysDueSecs = $this->pastDay * 86400;
$nextPaymentDueDateSecs = $billingDateSecs + $pastDaysDueSecs;
$nextPaymentDueDate = date("Y-m-d H:i:s",mktime(23,59,59,date('m',$nextPaymentDueDateSecs),date('d',$nextPaymentDueDateSecs),date('Y',$nextPaymentDueDateSecs)));
//echo"$nextPaymentDueDate $this->pastDay $this->cycleDay";
         $transType = $this->transType;


if ($contract_keyTWO == '' OR $contract_keyTWO == 0){
        $sql = "INSERT INTO monthly_settled VALUES (?,?,?,?,?,?)";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('iidsss', $contractKey, $transKey, $paymentAmount, $paymentDate, $nextPaymentDueDate, $transType);
        if(!$stmt->execute())  {
        	printf("Error: %s.\n function saveMonthlySettled table monthly_settled insert", $stmt->error);
           }		
        $stmt->close(); 

}else{    
    $sql = "UPDATE monthly_settled SET payment_date =?, next_payment_due_date = ?, trans_key = ?, payment_amount = ?, trans_type = ? WHERE contract_key = '$contractKey'";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('ssids',$paymentDate,$nextPaymentDueDate, $transKey, $paymentAmount, $transType);   
     if(!$stmt->execute())  {
    	printf("Error: %s.\n  monthly_payments  function updateMonthlySETTLED", $stmt->error);
       }
             
    $stmt->close(); 
}


//update monthly payments table


}
//--------------------------------------------------------------------------------------------------------------------------------
function deletePastDueAttempts()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("DELETE FROM past_due_attempts WHERE contract_key = '$this->contractKey' ");
$stmt->execute();  


if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		 
$stmt->close(); 

}
//---------------------------------------------------------------------------------------------------------------------------------
function loadBillingDay() {

$dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT past_day FROM billing_cycle WHERE cycle_key = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($past_day);
   $stmt->fetch();
   
   $this->pastDay = $past_day;
   
if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
$stmt->close();

   $stmt = $dbMain ->prepare("SELECT cycle_date FROM monthly_payments WHERE contract_key = '$this->contractKey'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($cycle_date);
   $stmt->fetch();
   
   $cycleDaySeconds = date("j",strtotime($cycle_date));
   $cycle_day = date('d',strtotime($cycle_date));
   
   $this->monthlyBillingDay = $cycle_day;
   $this->cycleDay = $cycle_day;
   
if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
$stmt->close();


}
//----------------------------------------------------------------------------------------------------------------------------------------
function updateInitialPayments() {

$dbMain = $this->dbconnect();
$sql = "UPDATE initial_payments SET due_status =? WHERE contract_key = '$this->contractKey' ORDER BY due_date DESC LIMIT 1";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('s', $dueStatus);

$dueStatus = 'P';

 if(!$stmt->execute())  {
	printf("Error: %s.\n  monthly_payments  function updateMonthlyBillingType", $stmt->error);
   }
             
$stmt->close(); 

}
//----------------------------------------------------------------------------------------------------------------------------------------
function updateNsfChecks() {

$dbMain = $this->dbconnect();
 $sql = "UPDATE nsf_checks SET check_bit= ? WHERE contract_key = '$this->contractKey' AND check_number= '$this->nsfCheckNumber'";
 $stmt = $dbMain->prepare($sql);
 $stmt->bind_param('i',  $checkBit); 
 $checkBit = 1;

   if(!$stmt->execute())  {
      printf("Error: %s.\n", $stmt->error);
     }		
   $stmt->close(); 

}
//---------------------------------------------------------------------------------------------------------------------------------------
function updateRejectionStatus() {
  
   $dbMain = $this->dbconnect();
   $sql = "UPDATE rejected_payments SET reject_bit= ? WHERE contract_key = '$this->contractKey'"; // AND history_key= '$this->transKey' 
   $stmt = $dbMain->prepare($sql);
   $stmt->bind_param('i',  $rejectBit); 
   $rejectBit = 1;

   if(!$stmt->execute())  {
      printf("Error: %s.\n", $stmt->error);
     }		
   $stmt->close();  

}
//---------------------------------------------------------------------------------------------------------------------------------------
function parsePastDue() {

            $this->generateTransKey();
            
  if($this->lateFee != null) {
    $this->lateFeeAll = 1;
     }
           
           
           
           if($this->checkPayment != "") {
               $this->paymentDescription = 'Past Due Check';  
               
                if($this->lateFeeAll == 1) {
                  $this->checkPayment = $this->checkPayment - $this->lateFee;
                  $this->todaysPayment = $this->checkPayment;
                  }
                  
               $checkText = 'Check';
               $this->transType = 'CH';
               $this->saveMonthlySettled();
               $this->insertPaymentHistory();
              }


           
            if($this->cashPayment != "") {
               $this->paymentDescription = 'Past Due Cash';  
               
                if($this->lateFeeAll == 1) {
                  $this->cashPayment = $this->cashPayment - $this->lateFee;
                  $this->todaysPayment = $this->cashPayment;
                  }
                  
               $cashText = 'Cash';
               $this->transType = 'CA';
               $this->saveMonthlySettled();
               $this->insertPaymentHistory();
              }           


           
            if($this->creditPayment != "") {               
               $this->paymentDescription = 'Past Due CC'; 
               
                if($this->lateFeeAll == 1) {
                  $this->creditPayment = $this->creditPayment - $this->lateFee;
                  $this->todaysPayment = $this->creditPayment;
                  }               
                              
               $creditText = 'Credit';
               $this->transType = 'CR';
               $this->saveMonthlySettled();
               $this->insertPaymentHistory();
              }       


           
            if($this->achPayment != "") {
               $this->paymentDescription = 'Past Due ACH'; 
               
                if($this->lateFeeAll == 1) {
                  $this->achPayment = $this->achPayment - $this->lateFee;
                  $this->todaysPayment = $this->achPayment;
                  }                   
               
               $achText = 'ACH';
               $this->transType = 'BA';
               $this->saveMonthlySettled();
               $this->insertPaymentHistory();
              }           



          
             if($this->lateFeeAll > 0) {
                $this->paymentDescription = 'Past Due Fee';
                $this->todaysPayment = $this->lateFee;
                $this->insertPaymentHistory();
                }
          
          
             $_SESSION['payment_type'] = "$checkText $cashText $creditText $achText";
          
          //insert into the monthly settled table          
          $this->deletePastDueAttempts();
          
          $success_bit = 1;
          
          return $success_bit;

}
//----------------------------------------------------------------------------------------------------------------------------------------
function parseInitialBalanceDue() {

            $this->generateTransKey();

           if($this->checkPayment != "") {
               $this->paymentDescription = 'Initial Balance Due Check';  
               $this->todaysPayment = $this->checkPayment;
               $checkText = 'Check';
               $this->insertPaymentHistory();
              }
           
            if($this->cashPayment != "") {
               $this->paymentDescription = 'Initial Balance Due Cash';                 
               $this->todaysPayment = $this->cashPayment;
               $cashText = 'Cash';
               $this->insertPaymentHistory();
              }           
           
            if($this->creditPayment != "") {               
               $this->paymentDescription = 'Initial Balance Due CC'; 
               $this->todaysPayment = $this->creditPayment;
               $creditText = 'Credit';
               $this->insertPaymentHistory();
              }       
           
            if($this->achPayment != "") {
               $this->paymentDescription = 'Initial Balance Due ACH'; 
               $this->todaysPayment = $this->achPayment;
               $achText = 'ACH';
               $this->insertPaymentHistory();
              } 
              
          
             $_SESSION['payment_type'] = "$checkText $cashText $creditText $achText";
          
          //insert into the monthly settled table
          $this->updateInitialPayments();
          
          $success_bit = 1;
          
          return $success_bit;

}
//----------------------------------------------------------------------------------------------------------------------------------------
function parseNsfCheckPayment() {

            $this->generateTransKey();
            
  if($this->nsfRejectFee != null) {
     $this->rejectFeeCheck = 1;
     }            

           if($this->checkPayment != "") {
               $this->paymentDescription = 'NSF Balance Due Check';  
               $this->todaysPayment = $this->checkPayment;
               $checkText = 'Check';
               $this->insertPaymentHistory();
              }
           
            if($this->cashPayment != "") {
               $this->paymentDescription = 'NSF Balance Due Cash';                 
               $this->todaysPayment = $this->cashPayment;
               $cashText = 'Cash';
               $this->insertPaymentHistory();
              }           
           
            if($this->creditPayment != "") {               
               $this->paymentDescription = 'NSF Balance Due CC'; 
               $this->todaysPayment = $this->creditPayment;
               $creditText = 'Credit';
               $this->insertPaymentHistory();
              }       
           
             if($this->achPayment != "") {
               $this->paymentDescription = 'NSF Balance Due ACH'; 
               $this->todaysPayment = $this->achPayment; 
               $achText = 'ACH';
               $this->insertPaymentHistory();
              }           
          
             if($this->rejectFeeCheck > 0) {
                $this->paymentDescription = 'NSF Bank Fee';
                $this->todaysPayment = $this->nsfRejectFee;
                $this->insertPaymentHistory();
                }          
                
                
             $_SESSION['payment_type'] = "$checkText $cashText $creditText $achText";
          
          //insert into the monthly settled table
          $this->updateNsfChecks();
          
          $success_bit = 1;
          
          return $success_bit;

}
//----------------------------------------------------------------------------------------------------------------------------------------
function parseRejectedPayments() {


  if($this->rejectedPaymentsFee != null) {
     $this->rejectFeeCredit = 1;
     $this->rejectFeeAch = 1;
     }            

           if($this->checkPayment != "") {
               $this->paymentDescription = 'Declined  Settled Check';  
               $this->todaysPayment = $this->checkPayment;
               $checkText = 'Check';
               $this->insertPaymentHistory();
              }
           
            if($this->cashPayment != "") {
               $this->paymentDescription = 'Declined Settled Cash';                 
               $this->todaysPayment = $this->cashPayment;
               $cashText = 'Cash';
               $this->insertPaymentHistory();
              }           
           
            if($this->creditPayment != "") {               
               $this->paymentDescription = 'Declined Settled CC'; 
               $this->todaysPayment = $this->creditPayment;
               $creditText = 'Credit';
               $this->insertPaymentHistory();
              }       
           
             if($this->achPayment != "") {
               $this->paymentDescription = 'Declined Settled ACH'; 
               $this->todaysPayment = $this->achPayment; 
               $achText = 'ACH';
               $this->insertPaymentHistory();
              }           
          
             if($this->rejectFeeCredit > 0 && $this->rejectFeeAch > 0) {
                $this->paymentDescription = 'Declined Rejection Fee';
                $this->todaysPayment = $this->rejectedPaymentsFee;
                $this->insertPaymentHistory();
                }          
                
                
             $_SESSION['payment_type'] = "$checkText $cashText $creditText $achText";
          
          //insert into the monthly settled table
          $this->updateRejectionStatus();
          
          $success_bit = 1;
          
          return $success_bit;



}
//----------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------
function parsePayment() {

$this->generateTransKey();
            

           if($this->checkPayment != "") {
               $this->paymentDescription = 'Payment Due Check';  
               $this->todaysPayment = $this->payment;
               $checkText = 'Check';
               $this->insertPaymentHistory();
              }
           
            if($this->cashPayment != "") {
               $this->paymentDescription = 'Payment Due Cash';                 
               $this->todaysPayment = $this->cashPayment;
               $cashText = 'Cash';
               $this->insertPaymentHistory();
              }           
           
            if($this->creditPayment != "" AND $this->creditPayment != 0) {               
               $this->paymentDescription = 'Payment Due CC'; 
               $this->todaysPayment = $this->creditPayment;
               $creditText = 'Credit';
               $this->insertPaymentHistory();
              }       
           
             if($this->achPayment != "") {
               $this->paymentDescription = 'Payment Due ACH'; 
               $this->todaysPayment = $this->achPayment; 
               $achText = 'ACH';
               $this->insertPaymentHistory();
              }           
           
                
                
             $_SESSION['payment_type'] = "$checkText $cashText $creditText $achText";
          
          //insert into the monthly settled table
          
          $success_bit = 1;
          
          return $success_bit;

}
//=============================================================================================

}
//==============================================================================
$check_pay = $_REQUEST['check_pay'];
$cash_pay = $_REQUEST['cash_pay'];
$credit_pay = $_REQUEST['credit_pay'];
$ach_pay = $_REQUEST['ach_pay'];
$due_date = $_REQUEST['due_date'];
$transaction_key = $_REQUEST['transaction_key'];
$contract_key = $_REQUEST['contract_key'];
$check_number = $_REQUEST['check_number'];
$fee_amount = $_REQUEST['fee_amount'];
$nsf_check_number = $_REQUEST['nsf_check_number'];
$trans_key = $_REQUEST['trans_key'];

$check_pay = trim($check_pay);
$cash_pay = trim($cash_pay);
$credit_pay = trim($credit_pay);
$ach_pay = trim($ach_pay);
$due_date = date("Y-m-d");
$cc_request_id = $_SESSION['cc_request_id'];





$billingPayments = new saveBillingPayments();
$billingPayments-> setContractKey($contract_key);
$billingPayments-> setTransactionKey($transaction_key);
$billingPayments-> setCreditPayment($credit_pay);
$billingPayments-> setAchPayment($ach_pay);
$billingPayments-> setCheckPayment($check_pay);
$billingPayments-> setCashPayment($cash_pay);
$billingPayments-> setDueDate($due_date);
$billingPayments-> setCheckPayment($check_pay);
$billingPayments-> setCcRequestId($cc_request_id);

   if($check_pay != "") {
      $billingPayments-> setCheckNumber($check_number);
      }

 switch ($transaction_key) {
        case "PD":
         $billingPayments-> setLateFee($fee_amount);
         $success_bit = $billingPayments-> parsePastDue();
        break;
        case "ID":
         $success_bit = $billingPayments-> parseInitialBalanceDue();      
        break;
        case "IF":
         $billingPayments-> setNsfCheckNumber($nsf_check_number);
         $billingPayments-> setNsfRejectFee($fee_amount);
         $success_bit = $billingPayments-> parseNsfCheckPayment();
        break;
        case "EF":
         $billingPayments-> setRejectedPaymentsFee($fee_amount);
         $billingPayments-> setTransKey($trans_key);
         $success_bit = $billingPayments-> parseRejectedPayments();
        break;
        case "XX":
         //$billingPayments-> setPayment($payment);
         $success_bit = $billingPayments-> parsePayment();
         //$success_bit = 1;
        break;
       }

     
echo"$success_bit";          
 
?>




    








