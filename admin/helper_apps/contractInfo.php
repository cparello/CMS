<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class contractInfo {

private $contractKey = null;
private $rowCount = null;
private $paymentDescription = null;
private $todaysPayment = null;
private $checkNumber = null;
private $historyKey = null;
private $balanceDue = null;
private $balanceDueOrig = null;
private $monthlyPayment = null;
private $creditPayment = "";
private $cashPayment = "";
private $checkPayment = "";
private $achPayment = "";
private $todaysPaymentOrig = null;
private $creditPaymentOrig = "";
private $cashPaymentOrig = "";
private $checkPaymentOrig = "";
private $achPaymentOrig = "";
private $dueDate = null;
private $payType = null;
private $lateFee = null;
private $paymentAmount =null;
private $dueDateSeconds = null;
private $signupDate = null;
private $processDate = null;
private $transKey = null;
private $bundled = 'N';
private $rejectFeeCheck = 0;
private $rejectFeeCredit = 0;
private $rejectFeeAch = 0;
private $lateFeeAll = 0;
private $rejectBit = 0;
private $checkBit = 0;
private $authIdReference = null; 
private $pastDay = null;
private $cycleDay = null;
private $transType = null;



function setTransType($transType) {
             $this->transType = $transType;
             }

function setContractKey($contractKey) {
              $this->contractKey = $contractKey;
              }

function setPaymentDescription($paymentDescription) {
              $this->paymentDescription = $paymentDescription;
              }
              
function setTodaysPayment($todaysPayment) {
              $this->todaysPayment = $todaysPayment;
              } 
              
function setTodaysPaymentOrig($todaysPaymentOrig) {
              $this->todaysPaymentOrig = $todaysPaymentOrig;
              }                     

function setCheckNumber($checkNumber) {
              $this->checkNumber = $checkNumber;
             }  
             
function setMonthlyPayment($monthlyPayment) {
              $this->monthlyPayment = $monthlyPayment;
              }  
              
function setDueDate($dueDate) {
              $this->dueDate = $dueDate;
              }
              
function setPayType($payType) {
              $this->payType = $payType;
              }      
              
function setBalanceDue($balanceDue) {
              $this->balanceDue = $balanceDue;
              }

function setBalanceDueOrig($balanceDueOrig) {
              $this->balanceDueOrig = $balanceDueOrig;
              }
              
function setLateFee($lateFee) {
              $this->lateFee = $lateFee;
              }
              
function setSignupDate($signupDate) {
              $this->signupDate = $signupDate;
              }

function setProcessDate($processDate) {
              $this->processDate = $processDate;
              }
              
function setCheckPayment($checkPayment) {
              $this->checkPayment = $checkPayment;
              }    
              
function setCheckPaymentOrig($checkPaymentOrig) {
              $this->checkPaymentOrig = $checkPaymentOrig;
              }
              
function setCashPaymentOrig($cashPaymentOrig) {
              $this->cashPaymentOrig = $cashPaymentOrig;
              }
              
function setAchPaymentOrig($achPaymentOrig) {
              $this->achPaymentOrig = $achPaymentOrig;
              }    
              
function setCreditPaymentOrig($creditPaymentOrig) {
              $this->creditPaymentOrig = $creditPaymentOrig;
              }                           
//---------------------------------------------------------------------------------------------------------------------              
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;              
}
//--------------------------------------------------------------------------------------------------------------------
function loadBillingCycle() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT past_day FROM billing_cycle WHERE cycle_key ='1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($past_day);
$stmt->fetch();
$stmt->close();

$stmt = $dbMain ->prepare("SELECT cycle_date FROM monthly_payments WHERE contract_key = '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($cycle_date);
$stmt->fetch();
$stmt->close();   
 
$this->pastDay = $past_day;
$this->cycleDay = date("d",strtotime($cycle_date));


}
//--------------------------------------------------------------------------------------------------------------------
function loadLateFee() {

   $dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT late_fee FROM fees WHERE fee_num = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($late_fee);
   $stmt->fetch();

   $this->lateFee = $late_fee;
   
  if(!$stmt->execute())  {
	printf("Error: %s.\n  fees  function loadLateFee", $stmt->error);
      }
   
$stmt->close(); 

}
//--------------------------------------------------------------------------------------------------------------------
function checkLateFee() {

$today = date("Y-m-d");
$todaysDateSecs = strtotime($today);

if($todaysDateSecs > $this->dueDateSeconds) {
  $this->loadLatefee();
  }else{
  $this->lateFee = 0;
  }
}
//--------------------------------------------------------------------------------------------------------------------
function parseBalanceDueMonthly() {

if($this->todaysPayment < $this->monthlyPayment) {
   $this->balanceDue = $this->monthlyPayment - $this->todaysPayment;
   }else{
   $this->balanceDue = '0.00';
   }

}
//---------------------------------------------------------------------------------------------------------------------
function parseBalanceDueInitial() {

if($this->lateFee == "" || $this->lateFee == 0)  {
  
           if($this->todaysPayment < $this->balanceDue) {
             $this->balanceDue = $this->balanceDue - $this->todaysPayment;
             }else{
             $this->balanceDue = '0.00';
             }
   }

if($this->lateFee != "" && $this->lateFee > 0 )  {
            $this->todaysPayment = $this->todaysPayment - $this->lateFee;
            
            if($this->todaysPayment < $this->balanceDue) {
               $this->balanceDue = $this->balanceDue - $this->todaysPayment;
               }else{
               $this->balanceDue = '0.00';
               }
   }
  
}
//----------------------------------------------------------------------------------------------------------------------
function parsePayType() {

  switch ($this->payType) {
        case "cash":
               $this->cashPayment = $this->todaysPayment;
               $this->checkPayment = "";
        break;
        case "check":
               $this->checkPayment = $this->todaysPayment;
               $this->cashPayment = "";
        break;
        }

}
//---------------------------------------------------------------------------------------------------------------------
function loadContractInfo() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT user_id, first_name, middle_name, last_name, street, city, state, zip, primary_phone, cell_phone, email, transfer, dob, license_number FROM contract_info WHERE  contract_key = '$this->contractKey' ORDER BY contract_date DESC LIMIT 1");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($user_id, $first_name, $middle_name, $last_name, $street, $city, $state, $zip, $primary_phone, $cell_phone, $email, $tran, $dob, $license);
 $this->rowCount = $stmt->num_rows;

             if($this->rowCount != 0) {
                  $stmt->fetch();
                  $result = "$first_name $middle_name $last_name &nbsp;&nbsp; $city, $state $zip &nbsp;&nbsp;$primary_phone &nbsp;&nbsp$email";
                  
               }else{
               
                  $result = 1;
                       
               }


return $result;

  if(!$stmt->execute())  {
	printf("Error: %s.\n   contract_info  function loadContractInfo", $stmt->error);
      }
   
$stmt->close(); 

}
//--------------------------------------------------------------------------------------------------------------------
function loadMonthlyPayment()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT billing_amount FROM monthly_payments WHERE  contract_key = '$this->contractKey'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($billing_amount);
 $this->rowCount = $stmt->num_rows;

             if($this->rowCount != 0) {
                  $stmt->fetch();
                  $result = $billing_amount;                  
               }else{               
                  $result = "NA";                       
               }

$this->monthlyPayment = $result;

  if(!$stmt->execute())  {
	printf("Error: %s.\n   monthly_payment  function loadMonthlyPayment", $stmt->error);
      }
   
$stmt->close(); 

}
//--------------------------------------------------------------------------------------------------------------------
function loadInitialPayment() {

//one thing to check now is the initial payment table
$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT due_status, due_date, balance_due,  process_fee_monthly, process_fee_full,  new_member_fee, todays_payment, signup_date, cash_payment, check_payment, ach_payment, credit_payment, process_date FROM initial_payments WHERE contract_key ='$this->contractKey' ORDER BY signup_date ASC LIMIT 1");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($due_status, $due_date, $balance_due, $process_fee_monthly, $process_fee_full, $new_member_fee, $todays_payment, $signup_date, $cash_payment, $check_payment, $ach_payment, $credit_payment, $process_date);
$stmt->fetch();

$this->dueDateSeconds = strtotime($due_date);
$this->signupDate = $signup_date;
$this->processDate = $process_date;
$this->cashPayment = $cash_payment;
$this->checkPayment = $check_payment;
$this->achPayment = $ach_payment;
$this->creditPayment = $credit_payment;
$this->todaysPayment = $todays_payment;

switch ($due_status) {
        case "G":
        $this->checkLateFee();
        $this->balanceDue = $balance_due;
        $this->paymentAmount = $balance_due  + $this->lateFee;
                   if($this->lateFee == 0) {
                     $this->lateFee = "";
                     }
       
        break;
        case "D":        
        $this->loadLateFee();
        $this->balanceDue = $balance_due;
        $this->paymentAmount = $this->balanceDue + $this->lateFee;
        break;
        case "P":
        $this->balanceDue = 'NA';
        $this->lateFee = 'NA';
        $this->paymentAmount = 'NA';
        break;
        }

 if(!$stmt->execute())  {
	printf("Error: %s.\n   initial_payments function loadInitialPayment", $stmt->error);
      }
   
$stmt->close();

}
//--------------------------------------------------------------------------------------------------------------------
function parsePaymentArray() {

$paymentArray ="$this->monthlyPayment|$this->balanceDue|$this->lateFee|$this->paymentAmount|$this->processDate|$this->cashPayment|$this->checkPayment|$this->todaysPayment|$this->signupDate";


return $paymentArray;


}
//--------------------------------------------------------------------------------------------------------------------
function insertPaymentHistory() {

 require('paymentHistory.php'); 

//$test = "History Key:  $historyKey \n Contract Key:  $this->contractKey \n Todays Payment:  $this->todaysPayment \n Balance Due: $this->balanceDue \n Due Date: $this->dueDate \n Process Date: $processDate \n History Status: $historyDueStatus \n Payment Description: $this->paymentDescription \n Status Key: $statusKey \n Credit Payment: $creditPayment \n Ach Payment: $achPayment \n Cash Payment: $cashPayment \n Check Payment: $checkPayment \n Check Number:  $checkNumber";

$success = 1;

return $success;
}
//--------------------------------------------------------------------------------------------------------------------
function loadPaymentHistoryTransKey() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT trans_key FROM payment_history WHERE contract_key = '$this->contractKey' AND payment_date = '$this->processDate' AND balance_due= '$this->balanceDueOrig' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($trans_key);
$stmt->fetch();

$this->transKey = $trans_key;
 if(!$stmt->execute())  {
	printf("Error: %s.\n   payment_history function loadPaymentHistoryTransKey", $stmt->error);
      }
   
$stmt->close();
}
//--------------------------------------------------------------------------------------------------------------------
function updateInitialPayments() {

$todaysPayment = $this->todaysPaymentOrig + $this->todaysPayment;

//checks to see if the payment is less than the balance due and if there is no late fee it means the account is still under the grace period. If not it sets the account to deliquint
if($todaysPayment < $this->balanceDue) {
   if($this->lateFee == "" || $this->lateFee == 0) {
      $dueStatus = 'G';
      }else{
      $dueStatus = 'D';     
      }   
  }else{
  $dueStatus = 'P';
  }

$balanceDue = $this->balanceDue;
$minTotalDue = $this->balanceDue;


if($this->payType == "cash") {
   $sqlField = "cash_payment= ?";  
   $typePayment = $this->todaysPayment;
   $this->cashPayment = $this->todaysPayment;
  }  
if($this->payType == "check") {
   $sqlField = "check_payment= ?";
   $typePayment = $this->todaysPayment; 
   $this->checkPayment = $this->todaysPayment;
  }

//echo"Todays Payment:  $todaysPayment \n Due Status: $dueStatus \n Balance Due: $balanceDue \n Minimum Due: $minTotalDue \n Type Payment: $typePayment \n Original Todays Payment: $this->todaysPayment  \n\n Contract Key: $this->contractKey \n Process Date: $this->processDate \n Signup Date: $this->signupDate";
//exit;


$dbMain = $this->dbconnect();
$sql = "UPDATE initial_payments SET todays_payment= ?, due_status= ?, balance_due= ?, min_total_due= ?, $sqlField WHERE contract_key = '$this->contractKey' AND process_date = '$this->processDate' AND signup_date = '$this->signupDate' ";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('dsddd',  $todaysPayment, $dueStatus, $balanceDue, $minTotalDue, $typePayment);


if(!$stmt->execute())  {
	printf("Error: %s.\n function updateInitialPayment table initial_payments update", $stmt->error);
   }		
$stmt->close(); 

$this->loadPaymentHistoryTransKey();

$success = $this->insertPaymentHistory();

//if there is a late fee we set it up to be inserted into the data base payment history
if($this->lateFee != "" && $this->lateFee > 0) {
   $this->paymentDescription = 'Late Fee';
   $this->todaysPayment = $this->lateFee;
   $this->bundled = 'Y';
              if($this->payType == "cash") {
                 $this->cashPayment = $this->lateFee;
                 }
              if($this->payType == "check") {
               $this->checkPayment = $this->lateFee;
               }
    $this->balanceDue = 0;
    $success = $this->insertPaymentHistory();                     
  }

return $success;

}
//-----------------------------------------------------------------------------------------------------------------------
function  insertNsfRecord() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) AS count FROM payment_history WHERE contract_key = '$this->contractKey' AND check_payment = '$this->checkPayment' AND check_number= '$this->checkNumber' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();

 if(!$stmt->execute())  {
	printf("Error: %s.\n   payment_history function insertNsfRecord", $stmt->error);
      }   
$stmt->close();

if($count == 0) {
   $success = 1;
   return $success;
  }

$stmt = $dbMain ->prepare("SELECT count(*) AS count FROM nsf_checks WHERE contract_key = '$this->contractKey' AND check_payment = '$this->checkPayment' AND check_number= '$this->checkNumber' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();

if(!$stmt->execute())  {
	printf("Error: %s.\n   payment_history function insertNsfRecord select", $stmt->error);
      }   
$stmt->close();

if($count != 0) {
   $success = 2;
   return $success;   
  }else{  
   $sql = "INSERT INTO nsf_checks VALUES (?,?,?,?,?)";
   $stmt = $dbMain->prepare($sql);
   $stmt->bind_param('iidis', $contractKey, $checkNumber, $checkPayment, $checkBit, $nsfDate);
    
    $contractKey = $this->contractKey;
    $checkNumber = $this->checkNumber;
    $checkPayment = $this->checkPayment;
    $checkBit = $this->checkBit;
    $nsfDate = date("Y-m-d");
    
    
  if(!$stmt->execute())  {
	printf("Error: %s.\n  function paymentHistory table nef_checks insert", $stmt->error);
   }	
   
  $stmt->close(); 
  $success = 3;
  return $success;
   
   }


}
//-----------------------------------------------------------------------------------------------------------------------
function  saveMonthlySettled()  {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO monthly_settled VALUES (?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iidsss', $contractKey, $transKey, $paymentAmount, $paymentDate, $nextPaymentDueDate, $transType);

$contractKey = $this->contractKey;
$transKey =  $this->authIdReference;
$paymentAmount = $this->todaysPayment;
$paymentDate = date("Y-m-d H:i:s");

$this->loadBillingCycle();
 
 $nextMonthsBillingDate = date("Y-m-d H:i:s"  ,mktime(23, 59, 59, date("m")+1  , $this->cycleDay, date("Y")));
 $nextMonthsBillingDateSecs = strtotime($nextMonthsBillingDate);
 $pastDaysDueSecs = $this->pastDay * 86400;
 $nextPaymentDueDateSecs = $nextMonthsBillingDateSecs + $pastDaysDueSecs;
 $nextPaymentDueDate = date("Y-m-d H:i:s",  $nextPaymentDueDateSecs);

 $transType = $this->transType;

if(!$stmt->execute())  {
	printf("Error: %s.\n function saveMonthlySettled table monthly_settled insert", $stmt->error);
   }		
$stmt->close(); 


}

//-----------------------------------------------------------------------------------------------------------------------


}



$monthly_payment = $_REQUEST['monthly_payment'];
$trans_type = $_REQUEST['trans_type'];        
$contract_key = $_REQUEST['contract_key'];
$month_switch = $_REQUEST['month_switch'];
$todays_payment = $_REQUEST['todays_payment'];
$payment_description = $_REQUEST['payment_description'];
$check_number = $_REQUEST['check_number'];
$balance_due = $_REQUEST['balance_due'];
$pay_type = $_REQUEST['pay_type'];
$late_fee = $_REQUEST['late_fee'];
$process_date = $_REQUEST['process_date'];
$cash_payment_orig = $_REQUEST['cash_payment_orig'];
$check_payment_orig = $_REQUEST['check_payment_orig'];
$todays_payment_orig = $_REQUEST['todays_payment_orig'];
$signup_date = $_REQUEST['signup_date'];
$check_payment_nsf = $_REQUEST['check_payment_nsf'];
$check_number_nsf = $_REQUEST['check_number_nsf'];
$redirect_switch = $_REQUEST['redirect_switch'];
                                

$accountInformation = new contractInfo();
$accountInformation-> setContractKey($contract_key);

if($month_switch == "") {
   $success = $accountInformation-> loadContractInfo();
   }

if($month_switch == "1") {
   //we check the monthly settled table to see if the account is past due
  include "../billing/pastDueMonthly.php";
  $testPastDue = new  pastDueMonthly();
  $testPastDue-> setContractKey($contract_key);
  $testPastDue-> loadRecordCount();
  $past_due_balance = $testPastDue-> getPastDueTotal();

     if($past_due_balance == '0.00')  {  
       $accountInformation-> loadMonthlyPayment();
       $accountInformation-> loadInitialPayment();
       $success = $accountInformation-> parsePaymentArray();
       }else{
       $success = $past_due_balance;
       }
   }

//takes care of monthly payments
if($month_switch == "2") {
   $accountInformation-> setPaymentDescription($payment_description);
   $accountInformation-> setTodaysPayment($todays_payment);
   $accountInformation-> setPayType($pay_type);
   $accountInformation-> parsePayType();
   $accountInformation-> setMonthlyPayment($monthly_payment);
   $accountInformation-> parseBalanceDueMonthly();    
       if($check_number == "") {
         $check_number = 0;
         }            
   $due_date = date("Y-m-d");  
   $accountInformation-> setDueDate($due_date);  
   $accountInformation-> setCheckNumber($check_number);  
   $accountInformation-> setTransType($trans_type);
   $success = $accountInformation-> insertPaymentHistory();
   $accountInformation-> saveMonthlySettled();
   }
  
  //takes care of initial payments
if($month_switch == "3") {   
   $accountInformation-> setPaymentDescription($payment_description);
   $accountInformation-> setTodaysPayment($todays_payment);
   $accountInformation-> setTodaysPaymentOrig($todays_payment_orig);
   $accountInformation-> setCashPaymentOrig($cash_payment_orig);
   $accountInformation-> setCheckPaymentOrig($check_payment_orig);  
   $accountInformation-> setPayType($pay_type);
   $accountInformation-> parsePayType(); 
   $accountInformation-> setBalanceDue($balance_due);
   $accountInformation-> setBalanceDueOrig($balance_due);
   $accountInformation-> setLateFee($late_fee);
   $accountInformation-> parseBalanceDueInitial();    
        if($check_number == "") {
         $check_number = 0;
         }            
   $due_date = date("Y-m-d");  
   $accountInformation-> setDueDate($due_date);  
   $accountInformation-> setProcessDate($process_date);
   $accountInformation-> setSignupDate($signup_date);
   $accountInformation-> setCheckNumber($check_number);  
   $success = $accountInformation-> updateInitialPayments();
  }
   
   
//takes care of bounced checks   
if($month_switch == "4") { 
    if($redirect_switch == 1) {
      $_SESSION['contract_key'] = $contract_key;
      }else{      
      unset($_SESSION['contract_key']);
      }
   $accountInformation-> setCheckNumber($check_number_nsf); 
   $accountInformation-> setCheckPayment($check_payment_nsf);
   $success = $accountInformation-> insertNsfRecord();
   
  }
   
echo"$success";



?>