<?php
class  pastDueBalanceDue {


private $contractKey = null;
private $prePayCount = null;
private $monthlyCount = null;
private $currentMonthDueDate = null;
private $nextMonthDueDate = null;
private $lateFee = null;
private $nsfFee = null;
private $rejectionFee = null;
private $monthlyPayment = null;
private $nextPaymentDueDate = null;
private $todaysDate = null;
private $daysPastDue = null;
private $pastDueTotal = 0;
private $dueFlag = null;
private $todaysPayment = null;
private $balanceDue = null;
private $dueDate = null;
private $initialPaymentBalanceDue = 0;
private $nsfCheckPayment = 0;
private $checkNumber = null;
private $nsfDate = null;
private $declinedPayment = 0;
private $transactionType = null;
private $lastAttemptDate = null;
private $transKey = null;
private $statusTag = null;
private $reasonDescription = null;
private $reasonCode = null;



function setContractKey($contractKey) {
       $this->contractKey = $contractKey;
       }



//---------------------------------------------------------------------------------------------------------------------              
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;              
}
//----------------------------------------------------------------------------------------------------------------------------------------------
function checkDeclinedTransactions() {

$dbMain = $this->dbconnect();
/*$stmt = $dbMain ->prepare("SELECT SUM(billing_amount), transaction_type, authorization_id, response, response_message FROM billing_scheduled_recuring_payments WHERE outstanding_balance = 'Y' AND processed = 'N' AND contract_key = '$this->contractKey'"); //AND last_attempt_date = collections_bad_cards.fail_date
if(!$stmt->execute())  {
	printf("Error: %s.\n  DECLINED 1", $stmt->error);
      }     
$stmt->store_result();      
$stmt->bind_result($this->declinedPayment, $transaction_type, $this->transKey, $this->reasonCode, $this->reasonDescription);
$stmt->fetch();
$stmt->close();

if($this->reasonCode == ''){
    $stmt = $dbMain ->prepare("SELECT exact_code, exact_reponse FROM billing_scheduled_recuring_payments WHERE outstanding_balance = 'Y' AND contract_key = '$this->contractKey'"); //AND last_attempt_date = collections_bad_cards.fail_date
if(!$stmt->execute())  {
	printf("Error: %s.\n  DECLINED 2", $stmt->error);
      }     
$stmt->store_result();      
$stmt->bind_result($this->reasonCode, $this->reasonDescription);
$stmt->fetch();
$stmt->close();*/
/*}

if($payment_amount != 0 OR $payment_amount != '') {*/
//echo "test1";
$stmt = $dbMain ->prepare("SELECT SUM(payment_amount), transaction_type, history_key, reject_message FROM rejected_payments WHERE reject_bit = '0' AND contract_key = '$this->contractKey'"); //AND last_attempt_date = collections_bad_cards.fail_date
$stmt->execute();
$stmt->store_result();      
$stmt->bind_result($this->declinedPayment, $transaction_type, $this->transKey, $this->reasonDescription);
$stmt->fetch();
$stmt->close();

$this->reasonCode = 300;
  
  
  if($transaction_type == 'CC') {
     $this->transactionType = 'Credit Card';
     }
  if($transaction_type == 'ACH') {
     $this->transactionType = 'ACH';
     }
 // }
}
//----------------------------------------------------------------------------------------------------------------------------------------------
function checkNsfTransactions() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT check_number, check_payment, nsf_date FROM nsf_checks WHERE check_bit ='0' AND contract_key = '$this->contractKey' ORDER BY nsf_date DESC LIMIT 1");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($check_number, $check_payment, $nsf_date);
$stmt->fetch();
$rowCount = $stmt->num_rows;

if($rowCount != 0) {
   $this->checkNumber = $check_number;
   $this->nsfCheckPayment = $check_payment;
   $this->nsfDate = date('M j, Y', strtotime($nsf_date)); 
  }
  
$stmt->close();
}
//----------------------------------------------------------------------------------------------------------------------------------------------
function checkInitialPaymentBalanceDue() {

$dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT due_status, process_date, due_date, todays_payment, balance_due FROM initial_payments WHERE  contract_key = '$this->contractKey' ORDER BY due_date DESC LIMIT 1 ");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($due_status, $process_date, $due_date, $todays_payment, $balance_due);
 $stmt->fetch();
 $rowCount = $stmt->num_rows;

  if($rowCount != 0) {
  
     if($due_status != 'P') {
             
         $todays_date = date("Y-m-d");        
         $todaysDate = strtotime($todays_date);
         $dueDate = strtotime($due_date);
         $process_date = strtotime($process_date);
        
              if($todaysDate > $dueDate) {
                 $this->todaysPayment = $todays_payment;
                 $this->initialPaymentBalanceDue = $balance_due;
                 $this->dueDate = date('M j, Y', strtotime($due_date)); 
                 $this->statusTag = 'P';
                }elseif($todaysDate <= $dueDate) {
                 $this->todaysPayment = $todays_payment;
                 $this->initialPaymentBalanceDue = $balance_due;
                 $this->dueDate = date('M j, Y', strtotime($due_date));   
                 $this->statusTag = 'G';
                }
        
        }
   }

}
//-----------------------------------------------------------------------------------------------------------------------------------------------
function loadFees() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT late_fee, nsf_fee, rejection_fee FROM fees WHERE fee_num = '1'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($late_fee, $nsf_fee, $rejection_fee);
$stmt->fetch();

$this->lateFee = $late_fee;
$this->nsfFee = $nsf_fee;
$this->rejectionFee = $rejection_fee;


$stmt->close();  
}
//--------------------------------------------------------------------------------------------------------------------
function loadMonthlyPayment()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT billing_amount FROM monthly_payments WHERE contract_key = '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($billing_amount);
$stmt->fetch();

$this->nextPaymentDueDate = trim($this->nextPaymentDueDate);
//echo"sdfd $this->nextPaymentDueDate<br>";

$this->monthlyPayment = $billing_amount;
$this->todaysDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, date("m"), date("d"), date("Y")));
	
	       $datetime1 = new DateTime($this->nextPaymentDueDate);
           $datetime2 = new DateTime($this->todaysDate);
           $interval = $datetime1-> diff($datetime2);                    
           $this->daysPastDue = $interval-> format('%d');
           $this->monthsPastDue = $interval-> format('%m');
           $this->yearsPastDue = $interval-> format('%y');
           
           //echo"d $this->daysPastDue <br> m $this->monthsPastDue <br> y $this->yearsPastDue";
           
           if($this->monthsPastDue >= 1) {
           
               if($this->yearsPastDue >= 1) {
                  $months = $this->yearsPastDue * 12;  
                  $this->monthsPastDue = $this->monthsPastDue + $months;
                 }                     
           
             $this->monthlyPayment = $this->monthlyPayment * $this->monthsPastDue;
             }else{
                $this->monthlyPayment = 0;
             }
$this->loadFees();          

$this->pastDueTotal = $this->monthlyPayment; // + $this->lateFee;
$this->pastDueTotal = sprintf("%01.2f", $this->pastDueTotal);

 if(!$stmt->execute())  {
	printf("Error: %s.\n  monthly_payments function loadMonthlyPayment", $stmt->error);
      }
   
$stmt->close();  

}
//--------------------------------------------------------------------------------------------------------------------
function loadMonthly() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) AS count FROM monthly_payments WHERE contract_key='$this->contractKey' AND billing_amount != '0.00'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();


 $this->monthlyCount = $count;
   

$stmt->close();
}
//----------------------------------------------------------------------------------------------------------------------------------------------
function loadSettledPayments() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT MAX(next_payment_due_date) FROM monthly_settled WHERE contract_key='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($next_payment_due_date);
$stmt->fetch();

//echo " wjwjwjwjwjw $next_payment_due_date $this->nextMonthDueDate $this->currentMonthDueDate";
$todaysDateSecs = time();
$this->loadFees();
$this->nextPaymentDueDate = $next_payment_due_date;
 if($this->nextPaymentDueDate != "" && $this->prePayCount == 0) { 
        
          if($this->nextPaymentDueDate != $this->currentMonthDueDate ) {       //$this->nextMonthDueDate                                              //$this->currentMonthDueDate
                   //$this->loadFees();
                   $this->loadMonthlyPayment();                                   
             }
     } 
     
if($this->nextPaymentDueDate != "" && $this->prePayCount > 0) {   

    $prepayEndDate = strtotime($next_payment_due_date);
        
      if($todaysDateSecs > $prepayEndDate) {
       //  $this->loadFees();
         $this->loadMonthlyPayment();      
         }

   }
     
 //handles first payment if overdue
if($this->nextPaymentDueDate == "") {
   $this->nextPaymentDueDateSecs = strtotime($this->originalMonthlyCycleDatePast);
     
   if($todaysDateSecs >= $this->nextPaymentDueDateSecs) {
      $this->nextPaymentDueDate = $this->originalMonthlyCycleDatePast;
      $this->loadMonthlyPayment();   
     }
    
  }
 
 
 
$stmt->close();
}
//----------------------------------------------------------------------------------------------------------------------------------------------
function checkPrepay() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) AS count FROM pre_payments WHERE contract_key= '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();

$this->prePayCount = $count;


$stmt->close();
}
//----------------------------------------------------------------------------------------------------------------------------------------------
function loadRecordCount() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) FROM account_status WHERE account_status ='CU' AND contract_key='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($currentCount);
$stmt->fetch();

       if($currentCount > 0) {
         
           $this->loadMonthly();
           
               if($this->monthlyCount ==1 ) {   
                                        
                    $this->checkPrepay();
                     
                    //   if($this->prePayCount == 0) {                        
                           $this->loadSettledPayments();
                     //    }
                                         
                 } 
             }    
        
 
$stmt->close();

if($this->ajaxSwitch == 1) {
   echo"$this->settledCount";
   exit;
   }
   
}
//---------------------------------------------------------------------------------------------------------------------------------------
function loadCycleDate() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT past_day FROM billing_cycle WHERE cycle_key ='1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($past_day);
$stmt->fetch();
$stmt->close();

$stmt = $dbMain ->prepare("SELECT MAX(cycle_date) FROM monthly_payments WHERE contract_key ='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($cycle_date);
$stmt->fetch();
$stmt->close();

$stmt = $dbMain ->prepare("SELECT payment_date FROM monthly_settled WHERE contract_key='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($payment_date);
$stmt->fetch();

$cycle_day = date("d", strtotime($cycle_date));
$month = date("m",strtotime($payment_date));
$month++;

$nextDueDaysPast = $past_day + $cycle_day;

//create time for the original monthly cycle date in case a payment has never been made
$origCycleYear = date("Y", strtotime($cycle_date));
$origCycleMonth = date("m", strtotime($cycle_date));
$origPastDueDay = $nextDueDaysPast;
$this->originalMonthlyCycleDatePast = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $origCycleMonth, $origPastDueDay, $origCycleYear));

if(date('d') < $cycle_day){
    $this->currentMonthDueDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, date("m")  , $nextDueDaysPast, date("Y")));
}else{
   $this->currentMonthDueDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, date("m")+1  , $nextDueDaysPast, date("Y"))); 
}
$this->nextMonthDueDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, $month  , $nextDueDaysPast, date("Y")));
//echo "$this->nextMonthDueDate";

$this->currentStatementDate =  date("m/d/Y"  ,mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
$this->statementRangeEndDate = date("m/d/Y"  ,mktime(0, 0, 0, date("m"), $nextDueDaysPast, date("Y")));
$this->statementRangeStartDate = date("m/d/Y"  ,mktime(0, 0, 0, date("m")-1  , $cycle_day, date("Y")));

}
//===================================================================
function getPastDueTotal() {
             return($this->pastDueTotal);
             }
function getInitialPaymentBalanceDue() {
             return($this->initialPaymentBalanceDue);
             }
function getNsfCheckPayment() {
             return($this->nsfCheckPayment);
             } 
function getDeclinedPayment() {
             return($this->declinedPayment);
             }  
function getTransactionType() {
             return($this->transactionType);
             }
function getLateFee() {
             return($this->lateFee);
             }
 function getNsfFee() {
             return($this->nsfFee);
             }
function getNsfCheckNumber() {
             return($this->checkNumber);
             }             
function getRejectionFee() {
             return($this->rejectionFee);
             }
function getTransKey() {
             return($this->transKey);
             }      
function getStatusTag() {
             return($this->statusTag);
             }
function getReasonDescription() {
             return($this->reasonDescription);
             }
function getReasonCode() {
             return($this->reasonCode);
             }
//---------------------------------------------------------------------------------------------------------------------
}

/*
if($ajax_switch == 1) {
   $testPastDue = new  pastDueCount();
   $testPastDue-> loadCycleDate();
   $testPastDue-> setAjaxSwitch($ajax_switch);
   $testPastDue-> loadRecordCount();
   }
*/

?>