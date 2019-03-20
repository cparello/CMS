<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class savePrePaymentsTwo {

private $contractKey = null;

//initial payment types
private $cashPayment = null;
private $creditPayment = null;
private $achPayment = null;
private $checkPayment = null;
private $checkNumber = 0;

//prepayment variables
private $monthlyPayment = null;
private $prepayRestartDate = null;
private $prepayNumMonths = null;
private $prepayTotal = null;
private $keyList = null;
private $prepayKey = null;


//history  payments
private $paymentDescription = null;
private $bundled = 'N';
private $rejectFeeCheck = 0;
private $rejectFeeCredit = 0;
private $rejectFeeAch = 0;
private $lateFeeAll = 0;
private $historyKey = null;
private $balanceDue = '0.00';
private $todaysPayment = null;
private $dueDate = null;
private $transKey = null;
private $pastDay = null;
private $cycleDay = null;
private $ccRequestId = 0;
private $achRequestId = 0;

//company info
private $businessName = null; 
private $clubName = null;
private $clubAddress = null;
private $clubPhone = null;


function setContractKey($contractKey) {
       $this->contractKey = $contractKey;
       }


//for payments on initial contract
function setCashPayment($cashPayment) {
       $this->cashPayment = $cashPayment;
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
function setCheckNumber($checkNumber) {
       $this->checkNumber = $checkNumber;
       }                


//prepayments
function setMonthlyPayment($monthlyPayment) {
       $this->monthlyPayment = $monthlyPayment;
       }
function setPrepayRestartDate($prepayRestartDate) {
       $this->prepayRestartDate = $prepayRestartDate;
       }
function setPrepayNumMonths($prepayNumMonths) {
       $this->prepayNumMonths = $prepayNumMonths;
       }
function setPrepayTotal($prepayTotal) {    
       $this->prepayTotal = $prepayTotal;
       }
function setKeyList($keyList) {
       $this->keyList = $keyList;
       }
       
//paymnet history
function setPaymentDescription($paymentDescription) {
       $this->paymentDescription = $paymentDescription;
       }
function setTodaysPayment($todaysPayment) {
       $this->todaysPayment = $todaysPayment;
       }
function setDueDate($dueDate) {
       $this->dueDate = $dueDate;
       }
function setCcRequestId($ccRequestId) {
       $this->ccRequestId = $ccRequestId;
       }                  
       
//---------------------------------------------------------------------------------------------------------------------              
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;              
}
//==================================================================
function loadBillingCycle() {

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

$cycle_day = date("d", strtotime($cycle_date));

$this->pastDay = $past_day;
$this->cycleDay = $cycle_day;


}
//==================================================================
function  loadBusinessInfo() {

$dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT  business_name FROM company_names WHERE business_name !='' "); 
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($business_name);      
 $stmt->fetch();
 
$this->businessName = $business_name;


$stmt->close();
}
//---------------------------------------------------------------------------------
function loadClubInfo() {

$dbMain = $this->dbconnect();


$this->clubId = $_SESSION['location_id'];

if ($this->clubId == 0){
        $stmt = $dbMain->prepare("SELECT MIN(club_id) FROM club_info  WHERE club_name != ''");//>=
        $stmt->execute();  
        $stmt->store_result();      
        $stmt->bind_result($clubId); 
        $stmt->fetch();
        $stmt->close();
    }else{
        $clubId = $this->clubId;
    }
    

   $stmt = $dbMain ->prepare("SELECT club_name, club_address, club_phone FROM club_info WHERE club_id ='$clubId'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($this->clubName, $this->clubAddress, $this->clubPhone);
   $stmt->fetch();

}
//--------------------------------------------------------------------------------------------------------------------
function insertPaymentHistory() {

   require('../helper_apps/paymentHistory.php');  
   
   $_SESSION['payment_date'] = date("m/d/Y H:i");
   unset($_SESSION['cc_request_id']);
}
//--------------------------------------------------------------------------------------------------------------------
function generateTransKey() {

$this->transKey = rand(100, 10000);

}
//--------------------------------------------------------------------------------------------------------------------
function processPrePayment() {

$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT count(*) as count, num_months, payment_amount, service_keys FROM pre_payments WHERE contract_key ='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count, $num_months, $payment_amount, $service_keys);
$stmt->fetch();
$stmt->close();

$d =  strtotime($this->prepayRestartDate);
$restartDate = date("Y-m-d", $d);
$paymentDate = date("Y-m-d");      
                      
if ($count == 0){
$sql = "INSERT INTO pre_payments VALUES (?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiidsssd', $this->prepayKey, $this->contractKey, $this->prepayNumMonths, $this->prepayTotal, $this->keyList, $paymentDate, $restartDate, $this->monthlyPayment);
if(!$stmt->execute())  {
	printf("Error: %s.\n  function processPrepayment table pre_payments insert", $stmt->error);
   }	
$stmt->close();

}else{
     $months = $this->prepayNumMonths+$num_months;
     $amount = $payment_amount+$this->prepayTotal;
     $service_keys .= ",$this->keyList";
    
     $sql = "UPDATE pre_payments SET num_months = ?, payment_amount = ?, service_keys = ?, payment_date = ?, restart_date = ? ,restart_payment = ? WHERE contract_key = '$this->contractKey'";
     $stmt = $dbMain->prepare($sql);
     $stmt->bind_param('idsssd', $months, $amount, $service_keys, $paymentDate, $restartDate, $this->monthlyPayment);
     if(!$stmt->execute())  {
    	printf("Error:updateEHFEE %s.\n", $stmt->error);
     }	
     $stmt->close();
}


$this->saveMonthlySettled();

}

//---------------------------------------------------------------------------------------------------------------
function  saveMonthlySettled()  {

$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT COUNT(*) as count FROM monthly_settled WHERE contract_key = '$this->contractKey' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);    
$stmt->fetch();
$stmt->close(); 

$paymentDate = date("Y-m-d");

 $prepayRestartDateSecs =  strtotime($this->prepayRestartDate);
 $pastDaysDueSecs = $this->pastDay * 86400;
 $nextPaymentDueDateSecs = $prepayRestartDateSecs + $pastDaysDueSecs + 86399;
 $nextPaymentDueDateOne = date("Y-m-d",  $nextPaymentDueDateSecs);
 $nextPaymentDueDate = "$nextPaymentDueDateOne 23:59:59";
 $transType = $this->transType;
$this->loadBillingCycle();

if ($count == 0){

$sql = "INSERT INTO monthly_settled VALUES (?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iidsss', $this->contractKey, $this->transKey, $this->prepayTotal, $paymentDate, $nextPaymentDueDate, $transType);
if(!$stmt->execute())  {
	printf("Error: %s.\n function saveMonthlySettled table monthly_settled insert", $stmt->error);
   }		
$stmt->close(); 

}else{
    
    $sql = "UPDATE monthly_settled SET next_payment_due_date =?,  payment_date =?  WHERE contract_key = '$this->contractKey' ";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('ss', $nextPaymentDueDate, $paymentDate);
    if(!$stmt->execute())  {
    	printf("Error: update prepay %s.\n", $stmt->error);
       }		
    
    $stmt->close(); 
}

}

//--------------------------------------------------------------------------------------------------------------
function parsePrePayment() {


$this->generateTransKey();
$this->loadSessionVariables();
$this->processPrePayment();

 $this->paymentDescription ='Monthly Service Prepaid';
 $_SESSION['confirmation_message'] = "Pre Payment For Account Number $this->contractKey Successfully Processed";
 
 $this->insertPaymentHistory();

$success_bit = 1; 
return $success_bit;

}
//--------------------------------------------------------------------------------------------------------------
function loadSessionVariables() {

$this->loadBusinessInfo();
$this->loadClubInfo();

            if($this->checkPayment != "") {
               $checkText = 'Check';
               $this->transType = 'CH';
              }
               
            if($this->cashPayment != "") {
               $cashText = 'Cash';
               $this->transType = 'CA';
              }           
           
            if($this->creditPayment != "") {               
               $creditText = 'Credit';
               $this->transType = 'CR';
              }       
           


             $_SESSION['payment_type'] = "$checkText $cashText $creditText $achText";


$_SESSION['title_text'] = 'Monthly Service(s) Pre Payment';
$_SESSION['item_text'] = "$this->prepayNumMonths Month(s) Pre Pay";
$_SESSION['item_amount'] = $this->prepayTotal;
$_SESSION['total_amount'] = $this->prepayTotal;
$_SESSION['contract_key_receipt'] = $this->contractKey;

$_SESSION['business_name'] = $this->businessName;
$_SESSION['club_name'] = $this->clubName;
$_SESSION['club_address'] = $this->clubAddress;
$_SESSION['club_phone'] = $this->clubPhone;


}
//---------------------------------------------------------------------------------------------------------------


}
//======================================================================
$credit_pay = $_REQUEST['credit_pay'];
$cash_pay = $_REQUEST['cash_pay'];
$check_pay = $_REQUEST['check_pay'];
$check_number = $_REQUEST['check_number'];
$contract_key = $_REQUEST['contract_key'];
$monthly_payment = $_REQUEST['monthly_payment'];
$prepay_restart_date = $_REQUEST['prepay_restart_date'];
$prepay_total = $_REQUEST['prepay_total'];
$num_months = $_REQUEST['num_months'];
$key_list = $_REQUEST['key_list'];
  
                 

$check_pay = trim($check_pay);
$cash_pay = trim($cash_pay);
//echo"fubar $cash_pay";
//exit;
$credit_pay = trim($credit_pay);
$ach_pay = trim($ach_pay);
$due_date = date("Y-m-d");
$cc_request_id = $_SESSION['cc_request_id'];

$save = new savePrePaymentsTwo();
$save-> setContractKey($contract_key);
$save-> setCreditPayment($credit_pay);
$save-> setAchPayment($ach_pay);
$save-> setCheckPayment($check_pay);
$save-> setCashPayment($cash_pay);
$save-> setCcRequestId($cc_request_id);
$save-> setDueDate($due_date);
$save-> setCheckPayment($check_pay);

   if($check_pay != "") {
      $save-> setCheckNumber($check_number);
      }

$save-> setMonthlyPayment($monthly_payment);
$save-> setPrepayRestartDate($prepay_restart_date);
$save-> setPrepayNumMonths($num_months);
$save-> setPrepayTotal($prepay_total);
$save-> setKeyList($key_list);
$save-> setTodaysPayment($prepay_total);

$success_bit = $save-> parsePrePayment();

echo"$success_bit";


?>