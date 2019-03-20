<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  accountInfoSql {

private $contractKey = null;
private $groupType = null;
private $groupName = null;
private $groupAddress = null;
private $groupPhone = null;
private $groupForm = null;
private $commissionCredit = null;


//bank info and cc
private $bankName = null;
private $accountType = null;
private $accountName = null;
private $accountNumber = null;
private $routingNumber = null;
private $cardName = null;
private $cardType = null;
private $cardNumber = null;
private $cardCvv = null;
private $cardExpDate = null;
private $monthlyBillingType = null;

//contract holder info
private $firstName = null;
private $middleName = null;
private $lastName = null;
private $streetAddress = null;
private $city = null;
private $state = null;
private $zipCode = null;
private $primaryPhone = null;
private $cellPhone = null;
private $emailAddress =null;
private $dob = null;
private $licenseNumber = null;

private $stateList =null;
private $disabled = null;
private $nameDisabled = null;
private $refundDisabledKeys = null;
private $cancelShow = null;

//product info
private $serviceKey = null;
private $serviceDuration = null;
private $serviceTerm = null;
private $serviceName = null; 
private $groupPrice = null;
private $monthlyDues = null;
private $unitPrice = null;
private $startDate = null;
private $endDate = null;
private $signupDate = null;
private $clubId = null;
private $transfer = null;
private $serviceLocation = null;                             
private $paymentTerm = null;                               
private $groupNumber = null;                               
private $termType = null;                               
private $userId = null;                               
private $downPayment = null;
private $initiationFee = null;
private $proRateMonth = null;
private $cellCount = 1;
private $serviceTableHeader = '<table id="secTab2" align="center" cellpadding="2" class="tabBoard4">';
private $serviceTableFooter ='</table>';
private $serviceSummary = null;
private $serviceRecords = null;
private $memberSince = null;
private $serviceTableSql = null;
private $serviceId = null;

//color scemes
private $newCellColor = null;
private $renewalCellColor = null;
private $upgradeCellColor = null;
private $memberCellColor = null;
private $newRefundColor = null;
private $upgradeRefundColor = null;
private $renewRefundColor = null;
private $proratePriceCellColor = null;
private $serviceCostPriceColor = null;
private $memberRefundColor = null;
private $prorateMonthRefundColor = null;
private $initiationFeeRefundColor = null;
private $downPaymentRefundColor = null;

private $rowCount = null;
private $cellCountMember = null;

//payment info
private $lastPaymentDate = null;
private $monthlyPayment = null;
private $pastDueBalance = 0;
private $initialPaymentsBalanceDue = null;
private $balanceDue = null;
private $totalBalanceDue = null;
private $todaysPayment = null;
private $processFeeMonthly = null;
private $processFeePif = null;


//club fees
private $enhanceCycle = null;
private $enhanceFee = null;
private $guaranteeCycle = 'NA';
private $guaranteeFee = 'NA';
private $cancelationFee = null;
private $holdFee = null;
private $nsfFee = null;
private $ccRejectFee = null;
private $lateFee = null;
private $memberHoldFee =null;
private $transferFee = null;


//contract elements
private $contractType = null;
private $contractLink = null;
private $contractDate = null;
private $newContractFee = null;
private $renewalFee = null;
private $upgradeFee = null;
private $newMemberFee = null;
private $newMembers = null;
private $proRateTerm = null;
private $proRatePrice = null;
private $proRateDues = null;
private $originalTermPrice = null;
private $payQuit = null;
private $contractTypeText = null;
private $holdGrace = null;

//summarys
private $availableRefunds = null;
private $bundledTotal = null;
private $newBundledRefund = null;
private $renewalBundledRefund = null;
private $upgradeBundledRefund = null;
private $singleRefund = null;
private $singleFeeTotal = null;
private $feeText = null;
private $memberListings = null;
private $groupListings = null;
private $feesDisabled = null;
private $partialPaymentRefund = null;
private $refundCellCount = 0;
private $refundServiceTotal = 0;
private $cancelBalance = null;
private $monthBit = null;
private $refundType = null;     
private $refundAmount = 0;
private $refundTableTotal = 0;
private $serviceCount;
private $cancelCount;
private $groupRefund;
private $refundMemberAmount = 0;
private $dateField = 'start_date';
private $dateFieldValue = null;
private $serviceCredits = null;
private $endDateSeconds = null;
private $creditDurationSeconds = null;
private $rejectListings = null;
private $paymentDescription = null;
private $historyKey = null;
private $checkPayment = null;
private $creditPayment = null;
private $achPayment = null;
private $cashPayment = null;
private $rejectionPayment = null;
private $rejectionFee = null;
private $checkNumber = null;
private $transactionType = null;
private $dueDateSeconds = null;
private $rejectionCount = 1;
private $rejectionTotal = 0;
private $rejectionRecord = null;
private $rejectionStatus = null;
private $pastDueGrace = null;
private $rejectionFeeType = null;
private $clickSafe = null;

//member info
private $memberId = null;
private $generalId = null;
private $memberHoldBit = null;

//form elements
private $refundCheckBoxes = null;

function setContractKey($contractKey) {
                 $this->contractKey = $contractKey;
                 }
              
function setCancelBalance($cancelBalance) {
                 $this->cancelBalance = $cancelBalance;
                 }
              
 function setServiceCount($serviceCount) {
                 $this->serviceCount = $serviceCount;
                }
                
 function setCancelCount($cancelCount) {
                 $this->cancelCount =$cancelCount;
                }  
                
function setGroupRefund($groupRefund) {
                 $this->groupRefund = $groupRefund;
                }
                
function setPastDueBalance($pastDueBalance) {
                 $this->pastDueBalance = $pastDueBalance;
                }                
//---------------------------------------------------------------------------------------------------------------------              
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;              
}
//--------------------------------------------------------------------------------------------------------------------
function checkLateFee() {

$today = date("Y-m-d");
$todaysDateSecs = strtotime($today);

if($todaysDateSecs > $this->dueDateSeconds) {
  $this->lateFee = $this->lateFee;
  }else{
  $this->lateFee = 0;
  }
}

//--------------------------------------------------------------------------------------------------------------------
function loadRefundCheckBoxes()  {

$refund = "
<td  class=\"black tile7\">
Set Refund Credit:
<input type=\"checkbox\" name=\"refund_check\" id=\"refund_check\" value=\"CH\" onClick=\"return checkRefunds(this);\"/>
&nbsp;&nbsp;
<input type=\"button\" name=\"refund_invoice\" id=\"refund_invoice\" value=\"Print Refund Invoice\" class=\"button2\"/>
</td>";


$this->refundCheckBoxes = "$refund";


return $this->refundCheckBoxes;

}
//--------------------------------------------------------------------------------------------------------------------

 function dateDiff($time1, $time2, $precision = 6) {
 
 // If not numeric then convert texts to unix timestamps
    if (!is_int($time1)) {
      $time1 = strtotime($time1);
    }
    if (!is_int($time2)) {
      $time2 = strtotime($time2);
    }
 
    // If time1 is bigger than time2
    // Then swap time1 and time2
    if ($time1 > $time2) {
      $ttime = $time1;
      $time1 = $time2;
      $time2 = $ttime;
    }
 
    // Set up intervals and diffs arrays
    $intervals = array('Year','Month','Day','hour','minute','second');
    $diffs = array();
 
    // Loop thru all intervals
    foreach ($intervals as $interval) {
      // Set default diff to 0
      $diffs[$interval] = 0;
      // Create temp time from time1 and interval
      $ttime = strtotime("+1 " . $interval, $time1);
      // Loop until temp time is smaller than time2
      while ($time2 >= $ttime) {
	$time1 = $ttime;
	$diffs[$interval]++;
	// Create new temp time from time1 and interval
	$ttime = strtotime("+1 " . $interval, $time1);
      }
    }
 
    $count = 0;
    $times = array();
    // Loop thru all diffs
    foreach ($diffs as $interval => $value) {
      // Break if we have needed precission
      if ($count >= $precision) {
	break;
      }
      // Add value and interval 
      // if value is bigger than 0
      if ($value > 0) {
	// Add s if value is not 1
	if ($value != 1) {
	  $interval .= "s";
	}
	// Add value and interval to times array
	$times[] = $value . " " . $interval;
	$count++;
      }
    }
 
    // Return string with times
    return implode(", ", $times);
  }
 

//----------------------------------------------------------------------------------------------------------------------
function  loadStatusDisable() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT account_status FROM account_status WHERE contract_key = '$this->contractKey' AND service_key='$this->serviceKey' AND service_id = '$this->serviceId' ");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($account_status);
$stmt->fetch();
  
    if(!$stmt->execute())  {
	printf("Error: %s.\n  account_status function loadStatusDisable", $stmt->error);
      }
   
$stmt->close();    

if($account_status == 'CA') {
   $this->cancelRowColor = 'bgcolor="#06C"';
   $this->checkDisabled = 'disabled="disabled"';
   $this->cancelShow = 1;
   }else{
   $this->cancelRowColor = 'bgcolor="#FFF"';
   $this->checkDisabled = ""; 
   $this->cancelShow = "";
   }



}
//----------------------------------------------------------------------------------------------------------------------
function loadPastDueGrace() {

   $dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT past_day  FROM billing_cycle WHERE cycle_key = '1'");
   echo($dbMain->error);
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($past_day);
   $stmt->fetch();

   $this->pastDueGrace = $past_day;

$stmt->close();

}
//-----------------------------------------------------------------------------------------------------------------------
function loadGeneralFees() {

 $dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT cancel_fee, hold_fee, member_hold_fee, transfer_fee, nsf_fee, late_fee, rejection_fee, hold_grace  FROM fees WHERE fee_num = '1'");
   echo($dbMain->error);
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($cancel_fee, $hold_fee, $member_hold_fee, $transfer_fee, $nsf_fee, $late_fee, $rejection_fee, $hold_grace);
   $stmt->fetch();
      
      $this->cancelationFee = $cancel_fee;
      $this->holdFee = $hold_fee;
      $this->memberHoldFee = $member_hold_fee;
      $this->transferFee = $transfer_fee;
      $this->nsfFee = $nsf_fee; 
      $this->lateFee = $late_fee; 
      $this->ccRejectFee = $rejection_fee;
      $this->holdGrace = $hold_grace;
      
      $this->loadPastDueGrace();
      
$stmt->close();                                                        

}
//----------------------------------------------------------------------------------------------------------------------
function loadGuaranteeFee() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT eft_cycle, guarantee_fee FROM member_guarantee_eft WHERE contract_key ='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($eft_cycle, $guarantee_fee);
$rowCount = $stmt->num_rows;
$stmt->fetch();
$stmt->close();

if($rowCount > 0)  {
  switch($eft_cycle) {          
             case"A":
             $this->guaranteeCycle = 'Annual';
             break;
             case"B":
             $this->guaranteeCycle = 'Bi-Annual';
             break;
             case"Q":
             $this->guaranteeCycle = 'Quarterly';
             break;
             case"M":
             $this->guaranteeCycle = 'Monthly';
             break;             
           }           
$this->guaranteeFee = $guarantee_fee;

}



}
//---------------------------------------------------------------------------------------------------------------------
function loadEnhanceFees() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT eft_cycle, enhance_fee FROM member_enhance_eft WHERE contract_key ='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($eft_cycle, $enhance_fee);
$rowCount = $stmt->num_rows;
$stmt->fetch();
$stmt->close();

if($rowCount > 0)  {
  switch($eft_cycle) {          
             case"A":
             $this->enhanceCycle = 'Annual';
             break;
             case"B":
             $this->enhanceCycle = 'Bi-Annual';
             break;
             case"Q":
             $this->enhanceCycle = 'Quarterly';
             break;
             case"M":
             $this->enhanceCycle = 'Monthly';
             break;             
           }           
$this->enhanceFee = $enhance_fee;

}else{

$stmt = $dbMain ->prepare("SELECT enhance_fee FROM member_enhance_pif WHERE contract_key ='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($enhance_fee);
$rowCount = $stmt->num_rows;
$stmt->fetch();
$stmt->close();

if($rowCount > 0) {
  $this->enhanceFee = $enhance_fee;
  $this->enhanceCycle = 'Annual';
  }


}

//set to NA if not avalable
if($this->enhanceFee == null) {
   $this->enhanceFee = 'NA';
   }
if($this->enhanceCycle == null) {
   $this->enhanceCycle = 'NA';
   }


}
//---------------------------------------------------------------------------------------------------------------------
function loadMemberHold()  {

if($this->memberId == 0) {
   $sql_switch = "general_id = '$this->generalId'";
   }else{
   $sql_switch = "member_id = '$this->memberId'";   
   }

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT COUNT(*) AS count FROM member_hold WHERE contract_key ='$this->contractKey'  AND $sql_switch");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close(); 

 if($count == 0) {
    $this->memberHoldBit = 0;
    }else{
    $this->memberHoldBit = 1;
    }


}
//---------------------------------------------------------------------------------------------------------------------
function loadStartDate()  {

$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT MAX(service_id) FROM $this->serviceTableSql WHERE contract_key ='$this->contractKey'  AND  service_key= '$this->serviceKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_id);
$stmt->fetch();
$stmt->close(); 



$stmt = $dbMain ->prepare("SELECT MAX($this->dateField) FROM $this->serviceTableSql WHERE service_id ='$service_id'  AND  service_key= '$this->serviceKey' AND contract_key ='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($dateFieldValue);
$rowCount = $stmt->num_rows;
$stmt->fetch();
$stmt->close(); 


$this->startDate = $dateFieldValue;

$this->dateFieldValue =  $dateFieldValue;
// echo"$this->dateFieldValue<br>";
}
//--------------------------------------------------------------------------------------------------------------------
function loadMemberSince()  {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT signup_date FROM contract_info WHERE  contract_key = '$this->contractKey' ORDER BY contract_date ASC LIMIT 1");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($signup_date);
 $stmt->fetch();
 
 
 $this->memberSince =  date('F j, Y', strtotime($signup_date));
 
 $stmt->close();  
 
 }
//--------------------------------------------------------------------------------------------------------------------
function loadContractLink()  {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT COUNT(*) AS contract_match FROM contract_info WHERE  contract_key = '$this->contractKey' AND signup_date = '$this->contractDate' AND contract_html IS NOT NULL");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($contract_match);
 $stmt->fetch();

if($contract_match == 0) {
   $this->contractLink = 'NA';
   }else{
   $contract_time =  strtotime($this->contractDate);   
   $this->contractLink = "<a class=\"notes\" href=\"javascript:void('')\"onClick=\"openContract('$contract_time', '$this->contractKey');\">View Contract</a>";
   }

 $stmt->close();
 
}
//---------------------------------------------------------------------------------------------------------------------
function loadContractType()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT contract_type, pay_quit FROM contract_info WHERE  contract_key = '$this->contractKey' AND signup_date = '$this->contractDate'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($contract_type, $pay_quit);
 $stmt->fetch();
 $stmt->close();
 
 
 $this->contractType = $contract_type;
 $this->payQuit = $pay_quit;

  
}
//==============================================================================
function loadMonthlyProrate()  {

//one thing to check now is the initial payment table
$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT new_members, pro_rate_quantity, pro_rate_term,  pro_rate_price, pro_rate_dues FROM current_monthly_upgrades WHERE contract_key ='$this->contractKey' AND signup_date = '$this->contractDate' AND service_key='$this->serviceKey'");
$stmt->execute();      
$stmt->store_result(); 
$rowCount = $stmt->num_rows;
$stmt->bind_result($new_members, $pro_rate_quantity, $pro_rate_term,  $pro_rate_price, $pro_rate_dues);
$stmt->fetch();
$stmt->close();


//if there are no records for the current element look for a new prorate
if($rowCount == 0)  {
$stmt = $dbMain ->prepare("SELECT new_members, pro_rate_quantity, pro_rate_term,  pro_rate_price, pro_rate_dues FROM new_monthly_upgrades WHERE contract_key ='$this->contractKey' AND signup_date = '$this->contractDate' AND service_key='$this->serviceKey'");
$stmt->execute();      
$stmt->store_result(); 
$rowCount = $stmt->num_rows;
$stmt->bind_result($new_members, $pro_rate_quantity, $pro_rate_term,  $pro_rate_price, $pro_rate_dues);
$stmt->fetch();
$stmt->close();
}

$this->newMembers = $new_members;
$this->prorateTerm = "$pro_rate_quantity Month(s)";
$this->proratePrice = $pro_rate_price;
$this->prorateDues = $pro_rate_dues;

//calc the service upgrade adjustment
//$cal_group_number = $this->groupNumber - $this->newMembers;
//$original_group_price = $cal_group_number * $this->unitPrice;
//$this->serviceProrateAdjust = $original_group_price + $pro_rate_price;

$this->originalTermPrice = sprintf("%.2f",$this->unitPrice * $this->newMembers);

//if no new membersthen set new members to NA for display
if($this->newMemberFee == 0.00) {
   $this->newMembers = 'NA';
}


}

//------------------------------------------------------------------------------------------------------------------------------------------
function loadPifProrate() {

//one thing to check now is the initial payment table
$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT new_members, pro_rate_price, start_date, end_date FROM current_pif_upgrades WHERE contract_key ='$this->contractKey' AND signup_date = '$this->contractDate' AND service_key='$this->serviceKey'");
$stmt->execute();      
$stmt->store_result(); 
$rowCount = $stmt->num_rows;
$stmt->bind_result($new_members, $pro_rate_price, $start_date, $end_date);
$stmt->fetch();

If($rowCount != 0) {
    $this->newMembers = $new_members;
    $this->proratePrice = $pro_rate_price;
    $this->originalTermPrice = sprintf("%.2f",$this->unitPrice * $this->newMembers);
    
    $start_date  = strtotime("$start_date");
    $end_date = strtotime("$end_date");
    
    //check to see if this a class if not get the pro term
    if($this->serviceTerm != 'C') {
      $pro_string =  $this->dateDiff($start_date, $end_date);
      }else{
      $pro_string = 'NA';
      }
     
    $this->prorateTerm = $pro_string;
    }else{
    $this->originalTermPrice = "";   
    }

 $stmt->close();
}
//------------------------------------------------------------------------------------------------------------------------------------------
function loadColorCodes()  {


$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT COUNT(signup_date) FROM $this->serviceTableSql WHERE signup_date ='$this->contractDate' ");
$stmt->execute();      
$stmt->store_result();
$stmt->bind_result($sign_date_count);
$stmt->fetch();


if($this->contractType == 'N') {
     if($sign_date_count > 1 && $this->newContractFee != '0.00') {
          $this->newCellColor = 'tcolor';
        }else if($sign_date_count == 1 && $this->newContractFee != '0.00') {
          $this->newCellColor = 'indi';
        }else{
          $this->newCellColor = null;
        }   
  $this->memberCellColor = null;      
        
  }

if($this->contractType == 'U') {
     if($sign_date_count > 1  &&  $this->upgradeFee != '0.00') {
          $this->upgradeCellColor = 'tcolor';
        }else if($sign_date_count == 1 && $this->upgradeFee != '0.00') {
          $this->upgradeCellColor = 'indi';
        }else{
          $this->upgradeCellColor = null;
        } 
        
                //take care of new member cell color
                if($sign_date_count > 1 && $this->newMemberFee != '0.00') {
                   $this->memberCellColor = 'tcolor';
                   }else if($sign_date_count == 1 && $this->newMemberFee != '0.00') {
                   $this->memberCellColor = 'indi';
                   }else{
                   $this->memberCellColor = null;
                   }
                      
                
  }

if($this->contractType == 'R') {
     if($sign_date_count > 1  && $this->renewalFee != '0.00') {
          $this->renewalCellColor = 'tcolor';
        }else if($sign_date_count == 1 && $this->renewalFee != '0.00') {
          $this->renewalCellColor = 'indi';
        }else{
          $this->renewalCellColor = null;
        }
  $this->memberCellColor = null;      
  }



if($this->newContractFee == '0.00')  {
   $this->newCellColor = null;
   }else if($this->renewalFee == '0.00') {
   $this->renewalCellColor = null;
   }else if($this->upgradeFee == '0.00') {
   $this->upgradeCellColor = null;
   }


 $stmt->close();

}
//-----------------------------------------------------------------------------------------------------------------------------------------
function loadLastPayment()  {

//this method will eventually check for the last payment through merge with authnet
//$this->lastPaymentDate = 'December 3, 2011';

//one thing to check now is the initial payment table
$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT due_status, due_date, balance_due,  process_fee_monthly, process_fee_full,  new_member_fee, todays_payment FROM initial_payments WHERE contract_key ='$this->contractKey' AND signup_date = '$this->contractDate'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($due_status, $due_date, $balance_due, $process_fee_monthly, $process_fee_full, $new_member_fee, $todays_payment);
$stmt->fetch();

$this->newMemberFee = $new_member_fee;
$this->todaysPayment = $todays_payment;
$this->processFeeMonthly = $process_fee_monthly;
$this->processFeePif = $process_fee_full;

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT MAX(next_payment_due_date) FROM monthly_settled WHERE contract_key ='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($next_payment_due_date);
$stmt->fetch();

$stmt = $dbMain ->prepare("SELECT past_day FROM billing_cycle WHERE cycle_key ='1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($past_day);
$stmt->fetch();

$month = date('m',strtotime($next_payment_due_date));
$day = date('d',strtotime($next_payment_due_date));
$year = date('y',strtotime($next_payment_due_date));

$lastPaymentDate = date('Y-m-d',mktime(0,0,0,$month,$day-$past_day,$year));

$this->pastDays = $past_day;

switch($due_status) {          
             case"P":
             $this->initialPaymentsBalanceDue = '0.00';
             $this->lastPaymentDate = date('F j, Y', strtotime($lastPaymentDate));
             break;
             case"G":
             $this->initialPaymentsBalanceDue = $balance_due;
             $this->lastPaymentDate = date('F j, Y', strtotime($lastPaymentDate));
             break;
             case"D":
             $this->initialPaymentsBalanceDue = $balance_due;
             $this->lastPaymentDate = date('F j, Y', strtotime($lastPaymentDate));
             break;
             default:
                $this->lastPaymentDate = date('F j, Y', strtotime($lastPaymentDate));
             break;
           }
$next_payment_due_date = trim($next_payment_due_date);
if ($next_payment_due_date == ''){
    $this->lastPaymentDate = "Not Available";
}

                           //set the default for prorate for everything but upgrades
                           $this->newMembers = 'NA';
                           $this->prorateTerm = 'NA';
                           $this->proratePrice = 'NA';
                           $this->prorateDues = 'NA';           
           

switch($this->contractType) { 
             case"N":             
                        if($this->serviceTerm == 'M')  {
                           $this->newContractFee = $process_fee_monthly;
                           }else{
                           $this->newContractFee  =  $process_fee_full;
                           }  
                           $this->renewalFee = '0.00';           
                           $this->upgradeFee ='0.00';                           
                           //set the color codes for displaying single or bundled
                           $this->loadColorCodes();
                           
             break;
             
             case"R":
                         if($this->serviceTerm == 'M')  {
                           $this->renewalFee = $process_fee_monthly;
                           }else{
                           $this->renewalFee  =  $process_fee_full;            
                           }  
                           $this->newContractFee = '0.00';           
                           $this->upgradeFee ='0.00';
                            //set the color codes for displaying single or bundled
                           $this->loadColorCodes();
             break;
             
             case"U":
                          if($this->serviceTerm == 'M')  {
                           $this->upgradeFee = $process_fee_monthly;
                           $this->loadMonthlyProrate(); 
                           }else{
                           $this->upgradeFee  =  $process_fee_full; 
                           //being an upgrade we need to find out if this is an existing service that has a new prorate amount for 
                           $this->loadPifProrate();                          
                           }  
                           $this->newContractFee = '0.00';           
                           $this->renewalFee ='0.00';
                           $this->loadColorCodes();                     
                           
             break;
           }
           
//loads the total past due balance
//$this->pastDueBalance = sprintf("%.2f", $this->initialPaymentsBalanceDue);
//$this->totalBalanceDue = $this->pastDueBalance;
 
}
//===================================================================
function loadCommissionCredit()  {

$dbMain = $this->dbconnect();
$result = $dbMain ->query("SELECT * FROM admin_passwords WHERE user_id ='$this->userId'"); 
$row_count = $result->num_rows;
$row = mysqli_fetch_array($result, MYSQLI_NUM);

if($row_count == 0) {
   $this->commissionCredit = 'NA';
  }else{
   $this->commissionCredit = $row[1];
  }
  
}
//---------------------------------------------------------------------------------------------------------------------
function formatBundledFees() {

$this->refundCellCount++;

switch($this->contractType) {          
             case"N":
            if($this->cancelShow == 1) {
              $this->newBundledRefund  = "";
              }else{
              
                  if($this->initialPaymentsBalanceDue > 0)  { 
                     $checkBox = 'NA'; 
                     }else{
                     $checkBox = "<input type=\"checkbox\" name=\"refund[]\" id=\"service_refund$this->refundCellCount\" value=\"$this->bundledTotal|$this->contractKey|$this->serviceKey|BNN|$this->contractDate|$this->serviceId\" onClick=\"  changeColor1(this, 'a$this->refundCellCount','$this->bundledTotal','0');\" $this->checkDisabled/>";                                                        
                     }                  
              
             $this->newBundledRefund = "
             <tr id=\"a$this->refundCellCount\" $this->cancelRowColor class=\"whiteBg\">
             <td class=\"black7 tile2\">
              $this->contractTypeText
             </td>
             <td class=\"black7 tile2\">
              Bundled Fees
             </td>          
             <td class=\"black2 tile2\">
             Various
             </td>              
             <td class=\"black7 tile2\">
              $this->bundledTotal
             </td>
             <td class=\"black7 tile2\">
              $checkBox
             </td>
             </tr>";
             }
             break;
             
             case"R":
              if($this->cancelShow == 1) {
              $this->renewalBundledRefund  = "";
              }else{
              
                  if($this->initialPaymentsBalanceDue > 0)  { 
                     $checkBox = 'NA';
                     }else{
                     $checkBox = "<input type=\"checkbox\" name=\"refund[]\"  id=\"service_refund$this->refundCellCount\" value=\"$this->bundledTotal|$this->contractKey|$this->serviceKey|BNR|$this->contractDate|$this->serviceId\" onClick=\" changeColor1(this, 'a$this->refundCellCount','$this->bundledTotal','0');\"$this->checkDisabled/>";               
                     }                 
              
             $this->renewalBundledRefund = "
             <tr id=\"a$this->refundCellCount\" $this->cancelRowColor class=\"whiteBg\">
             <td class=\"black7 tile2\">
              $this->contractTypeText
             </td>
             <td class=\"black7 tile2\">
              Bundled Fees
             </td>             
             <td class=\"black7 tile2\">
             Various
             </td>             
             <td class=\"black7 tile2\">
              $this->bundledTotal
             </td>
             <td class=\"black7 tile2\">
             $checkBox
             </td>
             </tr>";
             }
             break;
             
             case"U";
              if($this->cancelShow == 1) {
              $this->upgradeBundledRefund  = "";
              }else{
              
                  if($this->initialPaymentsBalanceDue > 0)  { 
                      $checkBox = 'NA';
                     }else{
                     $checkBox = "<input type=\"checkbox\" name=\"refund[]\"  id=\"service_refund$this->refundCellCount\" value=\"$this->bundledTotal|$this->contractKey|$this->serviceKey|BNU|$this->contractDate|$this->serviceId\" onClick=\" changeColor1(this, 'a$this->refundCellCount','$this->bundledTotal','0');\"$this->checkDisabled/>";                     
                                    
                     }              
              
              
             $this->upgradeBundledRefund = "
             <tr id=\"a$this->refundCellCount\" $this->cancelRowColor class=\"whiteBg\">
             <td class=\"black7 tile2\">
              $this->contractTypeText
             </td>
             <td class=\"black7 tile2\">
              Bundled Fees
             </td>          
             <td class=\"black7 tile2\">
             Various
             </td>             
             <td class=\"black7 tile2\">
              $this->bundledTotal
             </td>
             <td class=\"black7 tile2\">
             $checkBox
             </td>
             </tr>";
             }
             break;
             
    }         
             
             
$this->bundleRefund = "$this->newBundledRefund  $this->renewalBundledRefund $this->upgradeBundledRefund";          
             
}
//---------------------------------------------------------------------------------------------------------------------
function formatSingleFees() {

$this->refundCellCount++;

           if($this->cancelShow == 1) {
              $this->singleRefund .= "";
            }else{

                    //sets to NA if ther was a partial payment
                  if($this->initialPaymentsBalanceDue > 0)  { 
                     $checkBox = "NA <input type=\"hidden\" name=\"refund[]\"  id=\"service_refund$this->refundCellCount\" value=\"0.00|$this->contractKey|$this->serviceKey|$this->refundType|$this->contractDate|$this->serviceId\" />";  
                     }else{
                     $checkBox = "<input type=\"checkbox\" name=\"refund[]\"  id=\"service_refund$this->refundCellCount\" value=\"$this->singleFeeTotal|$this->contractKey|$this->serviceKey|$this->refundType|$this->contractDate|$this->serviceId\" onClick=\"changeColor1(this, 'a$this->refundCellCount','$this->singleFeeTotal','$this->monthBit');\"$this->checkDisabled />";                     
                                    
                     }



$this->singleRefund .= "
             <tr id=\"a$this->refundCellCount\" $this->cancelRowColor class=\"whiteBg\">
             <td class=\"black7 tile2\">
              $this->contractTypeText
             </td>
             <td class=\"black7 tile2\">
              $this->feeText
             </td>
             <td class=\"black7 tile2\">
              $this->serviceName
             </td>             
             <td class=\"black7 tile2\">
              $this->singleFeeTotal
             </td>
             <td class=\"black7 tile2\">
             $checkBox
             </td>
             </tr>";
             }
}
//---------------------------------------------------------------------------------------------------------------------
function partialPaymentRefund() {

    //here we setup if a patial payment was made
        if($this->initialPaymentsBalanceDue > 0)  {      
        
        $this->refundCellCount++;
              
                                       
              switch($this->feeText) {          
                        case"New Contract Fee":
                        $minus_fees = $this->processFeeMonthly + $this->processFeePif;
                        $this->feesDisabled = null;
                        break;
                        case"Renewal Fee":
                        $minus_fees = $this->processFeeMonthly + $this->processFeePif;
                        $this->feesDisabled = null;
                        break;
                        case"Upgrade Fee":
                        $minus_fees = $this->processFeeMonthly + $this->processFeePif;
                        $this->feesDisabled = null;
                        break;
                        case"New Member Fee":
                        $minus_fees = $this->processFeeMonthly + $this->processFeePif;
                        $this->feesDisabled = null;
                        break;
                        default:
                        $this->feesDisabled = 'disabled';
                        }             
              
              $prorate_refund = sprintf("%.2f", $this->todaysPayment - $minus_fees);
              

             $this->partialPaymentRefund = "
             <tr id=\"a$this->refundCellCount\" $this->cancelRowColor class=\"whiteBg\">
             <td class=\"black7 tile2\">
              $this->contractTypeText
             </td>
             <td class=\"black7 tile2\">
              Partial Payment
             </td>
             <td class=\"black7 tile2\">
              Partial Service Costs
             </td>             
             <td class=\"black7 tile2\">
              $prorate_refund
             </td>
             <td class=\"black7 tile2\">
             <input  type=\"checkbox\" name=\"refund[]\"  id=\"service_refund$this->refundCellCount\" value=\"$prorate_refund|$this->contractKey|1|AS|$this->contractDate|$this->serviceId\" onClick=\"changeColor1(this, 'a$this->refundCellCount','$prorate_refund','2');\" $this->checkDisabled/>
             </td>
             </tr>"; 
              
              
              
              
              
             }else{             
               $this->feesDisabled = null;
             }



}
//-----------------------------------------------------------------------------------------------------------------------
function loadAvailableRefunds()  {
 
$this->loadStatusDisable();

//echo"$this->serviceId";

//get the current time stamp to compare with the payquit date
$current_date = time();

//now compare the pay quit option to see if it is within the time frame to give a refund
if($current_date < $this->payQuit)  {

//this is set to disable the cancel function in the Available Holds / Cancelations / Credit Terms  section
$this->refundDisabledKeys .= "$this->serviceKey ";
        
     //set the color codes for the refund color for service fees
    switch($this->contractType) {          
             case"N":
             $this->newRefundColor = 'refColor';
             $this->contractTypeText = 'New';
                         
                 //here we set up the html for bundled fees
                 if($this->newCellColor == 'tcolor')  {  
                    $this->bundledTotal = $this->newContractFee;
                    $this->partialPaymentRefund();
                    $this->formatBundledFees();                                       
                   }
                   
                 //now we set p the individual fees
                 if($this->newCellColor == 'indi')  {                  
                    $this->feeText = "New Contract Fee";
                    $this->singleFeeTotal = $this->newContractFee;
                    $this->partialPaymentRefund();
                    $this->refundType = 'NCF';
                    $this->formatSingleFees();             
                    }             
             break;
             
             
             case"A":
             $this->newRefundColor = 'refColor';
             $this->contractTypeText = 'Adjusted New';
                         
                 //here we set up the html for bundled fees
                 if($this->newCellColor == 'tcolor')  {  
                    $this->bundledTotal = $this->newContractFee;
                    $this->partialPaymentRefund();
                    $this->formatBundledFees();                                       
                   }
                   
                 //now we set p the individual fees
                 if($this->newCellColor == 'indi')  {                  
                    $this->feeText = "New Contract Fee";
                    $this->singleFeeTotal = $this->newContractFee;
                    $this->partialPaymentRefund();
                    $this->refundType = 'NCF';
                    $this->formatSingleFees();             
                    }             
             break;             
             
             
             
             case"R":
             $this->renewRefundColor = 'refColor';  
             $this->contractTypeText = 'Renewal';
             
                 //here we set up the html for bundled fees
                 if($this->renewalCellColor == 'tcolor')  {               
                    $this->bundledTotal = $this->renewalFee;
                    $this->formatBundledFees();                                       
                   }
             
                 //now we set p the individual fees
                 if($this->renewalCellColor == 'indi')  { 
                    $this->feeText = "Renewal Fee";
                    $this->singleFeeTotal = $this->renewalFee;
                    $this->refundType = 'RNF';
                    $this->formatSingleFees();             
                    }             
             
             break;
             
             
             case"U":             
             $this->contractTypeText = 'Upgrade';
             
                if($this->upgradeFee != '0.00') {
                   $this->upgradeRefundColor = 'refColor';
                   }else{
                   $this->upgradeRefundColor = null;
                   }
             
              //set up the new member fee refund color
               if($this->newMemberFee != '0.00') {
                   $this->memberRefundColor = 'refColor';
                  }else{
                   $this->memberRefundColor = null;           
                  }
             
                //here we set up the html for bundled fees
                 if($this->upgradeCellColor == 'tcolor' && $this->memberCellColor == 'tcolor')  {               
                    $this->bundledTotal = sprintf("%.2f", $this->upgradeFee + $this->newMemberFee);
                    $this->formatBundledFees();                                       
                   }else if($this->upgradeCellColor == 'tcolor' && $this->memberCellColor != 'tcolor')  {                 
                               $this->bundledTotal = $this->upgradeFee;
                               $this->formatBundledFees();                                  
                   }else if($this->memberCellColor == 'tcolor' && $this->upgradeCellColor != 'tcolor')  {                   
                               $this->bundledTotal = $this->newMemberFee;
                               $this->formatBundledFees();                   
                   }
                   
                 //now we set up the individual fees
                 if($this->upgradeCellColor == 'indi') {
                    $this->feeText = "Upgrade Fee";
                    $this->singleFeeTotal = $this->upgradeFee;
                    $this->refundType = 'UPF';
                    $this->formatSingleFees();                    
                   }
                   
                 if($this->memberCellColor == 'indi') {
                    $this->feeText = "New Member Fee";
                    $this->singleFeeTotal = $this->newMemberFee;
                    $this->refundType = 'NMF';
                    $this->formatSingleFees();                    
                   }                                      
             break; 
             }


     if($this->serviceTerm == 'M') {
         $this->serviceCostPriceColor = null;
         //$this->prorateMonthRefundColor = 'refColor';
                 
                 //sets up a partial payment refund if exists
                 //$this->partialPaymentRefund();
        
           
           if($this->initiationFee != '0.00'  &&  $this->initiationFee != 'NA') {
              $this->monthBit = 0;
              $this->initiationFeeRefundColor = 'refColor';
              $this->feeText = "Initiation Down";
              $this->singleFeeTotal = $this->initiationFee;
              //$this->refundServiceTotal = $this->refundServiceTotal + $this->initiationFee;
              $this->partialPaymentRefund();
              $this->refundType = 'INF';
              $this->formatSingleFees();                              
              }else{
              $this->initiationFeeRefundColor = null;
              }
              
           if($this->downPayment != '0.00'  &&  $this->downPayment != 'NA') {
              $this->monthBit = 0;
              $this->downPaymentRefundColor = 'refColor';
              $this->feeText = "Down Payment";
              $this->singleFeeTotal = $this->downPayment;
              //$this->refundServiceTotal = $this->refundServiceTotal + $this->downPayment;
              $this->partialPaymentRefund();
              $this->refundType = 'DNP';
              $this->formatSingleFees();                  
              }else{
              $this->downPaymentRefundColor = null;
              }   
              
           if($this->proRateMonth != 'NA')  {
              $this->monthBit = 1;
              $this->prorateMonthRefundColor = 'refColor';
              $this->feeText = "Prorate Cost";
              $this->singleFeeTotal = $this->proRateMonth;
              
              $this->refundServiceTotal = $this->refundServiceTotal + $this->proRateMonth;
              $this->partialPaymentRefund();
              $this->refundType = 'SMP';
              
            
                  $this->formatSingleFees();      
                
              
              
              }else{
              $this->prorateMonthRefundColor = null;
              }
              
         
        }else{
        
       
             //take care of prorate cell color or service cost
             if($this->proratePrice == 'NA')  {
                $this->monthBit = 0;
                $this->proratePriceCellColor = null;
                $this->serviceCostPriceColor = 'refColor';
                $this->feeText = "Service Cost";
                $this->singleFeeTotal = $this->groupPrice;
                $this->refundServiceTotal = $this->refundServiceTotal + $this->groupPrice;
                $this->partialPaymentRefund();
                $this->refundType = 'SPF';
                $this->formatSingleFees(); 
                }else{
                $this->monthBit = 0;
                $this->proratePriceCellColor = 'refColor';
                $this->serviceCostPriceColor = null;
                $this->feeText = "Prorate Term Price";
                $this->singleFeeTotal = $this->proratePrice;
                $this->refundServiceTotal = $this->refundServiceTotal + $this->proratePrice;
                $this->partialPaymentRefund();
                $this->refundType = 'SPP';
                $this->formatSingleFees();
                }
             
                    
        }


/*
$this->availableRefunds .= "
<tr>
<td class=\"black2 tile2\">
$this->contractTypeText
</td>
<td class=\"black2 tile2\">

</td>
<td class=\"black2 tile2\">

</td>
<td class=\"black2 tile2\">

</td>
<td class=\"black2 tile2\">

</td>
</tr>";
*/

}



}
//---------------------------------------------------------------------------------------------------------------------
function loadGroupInfo() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT group_type, group_name, group_address, group_phone FROM member_groups WHERE contract_key ='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($group_type, $group_name, $group_address, $group_phone);
$stmt->fetch();

$this->groupAddress = $group_address;
$this->groupPhone = $group_phone;
$this->groupName = $group_name;

switch($group_type) {          
             case"S":
             $this->groupType = 'Single';
             break;
             case"F":
             $this->groupType = 'Family';
             break;
             case"B":
             $this->groupType = 'Business';
             break;
             case"O":
             $this->groupType = 'Organization';
             break;
             }
             
             
$this->groupForm = "
<table id=\"secTab\" align=\"center\" cellpadding=\"2\" class=\"tabBoard2\">
<tr class=\"tabHead\">
<td colspan=\"3\" class=\"oBtext\">$this->groupType Information </td>
</tr>
<tr>
<td class=\"black\">$this->groupType Name:</td>
<td class=\"black\">$this->groupType Address:</td>
<td class=\"black\">$this->groupType Phone:</td>
</tr>
<tr>
<td class=\"pad\"><input  name=\"type_name\" type=\"text\" id=\"type_name\" value=\"$this->groupName\" size=\"30\" maxlength=\"30\" onFocus=\"return checkServices(this.name,this.id);\" onChange=\"return disableFields(this);\" $this->nameDisabled/></td>
<td class=\"pad\"><input  name=\"type_address\" type=\"text\" id=\"type_address\" value=\"$this->groupAddress\" size=\"50\" maxlength=\"50\"  onFocus=\"return checkServices(this.name,this.id)\"/></td>
<td class=\"pad\"><input  name=\"type_phone\" type=\"text\" id=\"type_phone\" value=\"$this->groupPhone\" size=\"25\" maxlength=\"30\"  onFocus=\"return checkServices(this.name,this.id)\"/></td>
</tr>
</table>";

switch($group_type) {          
             case"S":
             $this->groupForm = null;
             break;
             case"F":
             $this->groupForm = null;
             break;
             }
                      
}
//--------------------------------------------------------------------------------------------------------------------------------
function stateSelect() {
require "../helper_apps/stateSelect.php";

}
//=============================================================================
function createProductRecord()  {

 switch($this->serviceTerm) {
        case "C":
        $termText = 'Class(s)';
        $this->endDate = 'NA';
        break;
        case "D":
        $termText = 'Day(s)';
        break;
        case "W":
        $termText = 'Week(s)';
        break;
        case "M":
        $termText = 'Month(s)';
        break;
        case "Y":
        $termText = 'Year(s)';
        break;  
      }

switch($this->termType)  {
        case "T":
        $renewOptionText = 'Term';
        break;
        case "O":
        $renewOptionText = 'Open Ended';
        break;
      }

switch($this->transfer)  {
        case "N":
        $transferOptionText = 'No';
        break;
        case "Y":
        $transferOptionText = 'Yes';
        break;
      }

$this->serviceRecords .= "
<tr class=\"tabHead\">
<td colspan=\"5\" class=\"oBtext tile3\">
Service Info $this->cellCount: &nbsp;  $this->serviceName
</td> 
</tr>
<tr>
<td class=\"black tile1\">Location:</td>
<td class=\"black tile1 \">Name:</td>
<td class=\"black tile1\">Type:</td>
<td class=\"black tile1 \">Term:</td>
<td class=\"black tile1\">Total Quantity:</td>
</tr>
<tr>
<td class=\"black2 tile2\">
<select name=\"serv_locations\" id=\"serv_locations\">
$this->locDrop
</select></td>
<td class=\"black2 tile2\">$this->memDrop</td>
<input type=\"hidden\" name=\"user_id\"  id=\"user_id\" value=\"$this->userId\"/>
<td class=\"black2 tile2\">$this->paymentTerm</td>
<td class=\"black2 tile2\"><span id=\"termText\">$this->serviceDuration $termText</span></td>
<td class=\"black2 tile2\">$this->groupNumber</td>
</tr>

<tr>
<td class=\"black tile1\">Group Type:</td>
<td class=\"black tile1\">Renewal Option:</td>
<td class=\"black tile1\">Transferable:</td>
<td class=\"black tile1\">View Contract:</td>
<td class=\"black tile1\">Commission Credit:</td>
</tr>
<tr>
<td class=\"black2 tile2\">$this->groupType</td>
<td class=\"black2 tile2\">$renewOptionText</td>
<td class=\"black2 tile2\">$transferOptionText</td>
<td class=\"black2 tile2\">$this->contractLink</td>
<td class=\"black2 tile2\">$this->commissionCredit</td>
</tr>

<tr>
<td class=\"black tile1\">Member Since:</td>
<td class=\"black tile1\">Signup Date:</td>
<td class=\"black tile1\">Start Date:</td>
<td class=\"black tile1\">End Date:</td>
<td class=\"black tile1\">Next Payment Date:</td>
</tr>
<tr>
<td class=\"black2 tile2\">$this->memberSince</td>
<td class=\"black2 tile2\">$this->signupDate</td>
<td class=\"black2 tile2\">$this->startDate</td>
<td class=\"black2 tile2\">$this->endDate</td>
<td class=\"black2 tile2\">$this->lastPaymentDate</td>
</tr>

<tr>
<td class=\"black tile1\">Down Payment:</td>
<td class=\"black tile1\">Initiation Down:</td>
<td class=\"black tile1\">Service Cost:</td>
<td class=\"black tile1\">Monthly Payment:</td>
<td class=\"black tile1\">Balance Due:</td>
</tr>
<tr>
<td class=\"black2 tile2 $this->downPaymentRefundColor\">$this->downPayment</td>
<td class=\"black2 tile2 $this->initiationFeeRefundColor\">$this->initiationFee</td>
<td class=\"black2 tile2 $this->serviceCostPriceColor\">$this->groupPrice</td>
<td class=\"black2 tile2\">$this->monthlyDues</td>
<td class=\"black2 tile2\">$this->initialPaymentsBalanceDue</td>
</tr>

<tr>
<td class=\"black tile1 $this->newCellColor\">New Contract Fee:</td>
<td class=\"black tile1 $this->upgradeCellColor\">Upgrade Fee:</td>
<td class=\"black tile1 $this->renewalCellColor\">Renewal Fee:</td>
<td class=\"black tile1 $this->memberCellColor\">Member Fee:</td>
<td class=\"black tile1\">Prorate Cost(Signup Month):</td>
</tr>
<tr>
<td class=\"black2 tile2 $this->newRefundColor\">$this->newContractFee</td>
<td class=\"black2 tile2 $this->upgradeRefundColor\">$this->upgradeFee</td>
<td class=\"black2 tile2 $this->renewRefundColor\">$this->renewalFee</td>
<td class=\"black2 tile2 $this->memberRefundColor\">$this->newMemberFee</td>
<td class=\"black2 tile2 $this->prorateMonthRefundColor\">$this->proRateMonth</td>
</tr>

<tr>
<td class=\"black tile1\">New members:</td>
<td class=\"black tile1\">Prorate Term:</td>
<td class=\"black tile1\">Prorate Term Price:</td>
<td class=\"black tile1\">Prorate Dues:</td>
<td class=\"black tile1\">Original Term Price:</td>
</tr>
<tr>
<td class=\"black2 tile2\">$this->newMembers</td>
<td class=\"black2 tile2\">$this->prorateTerm</td>
<td class=\"black2 tile2 $this->proratePriceCellColor\">$this->proratePrice</td>
<td class=\"black2 tile2\">$this->prorateDues</td>
<td class=\"black2 tile2\">$this->originalTermPrice</td>
</tr>




<tr>
<td colspan= \"5\" class=\"tabPad\">&nbsp;</td>
</tr>";

$this->cellCount++;



}
//=============================================================================
function loadMonthlyPayment()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT billing_amount,  monthly_billing_type FROM monthly_payments WHERE contract_key = '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($billing_amount, $billing_type);
$stmt->fetch();


$this->monthlyPayment = $billing_amount;
$this->monthlyBillingType = $billing_type;

 if(!$stmt->execute())  {
	printf("Error: %s.\n  monthly_payments function loadMonthlyPayment", $stmt->error);
      }
   
$stmt->close();  

}
//---------------------------------------------------------------------------------------------------------------------------------------
function loadPaymentTypes() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT bank_name, account_type, account_fname, account_mname,  account_lname, account_number,  routing_number FROM banking_info WHERE contract_key ='$this->contractKey'");
 echo($dbMain->error);
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($bank_name, $account_type, $account_fname, $account_mname, $account_lname, $account_number, $routing_number);
 $stmt->fetch();
 $stmt->close();
 
 $stmt = $dbMain ->prepare("SELECT card_fname,   card_mname,  card_lname, card_type, card_number,  card_cvv,  card_exp_date FROM  credit_info WHERE contract_key ='$this->contractKey'");
 echo($dbMain->error);
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($card_fname, $card_mname, $card_lname, $card_type, $card_number, $card_cvv, $card_exp_date);
 $stmt->fetch();
 $stmt->close();
//change zeros to null for form fields
if($routing_number == 0) {
   $routing_number = null;
   }
if($card_cvv == 0) {
   $card_cvv = null;
   }


$this->bankName = $bank_name;
$this->accountType = $account_type;
$this->accountName = "$account_fname $account_mname $account_lname";
$this->accountNumber = $account_number;
$this->routingNumber = $routing_number;
$this->cardName = "$card_fname $card_mname $card_lname";
$this->cardType = $card_type;
$this->cardNumber = $card_number;
$this->cardCvv = $card_cvv;
$this->cardExpDate = $card_exp_date;


$stmt->close();     


}
//==========================================================================
function loadMonthlyServices() {

$this->serviceTableSql = 'monthly_services';
$this->loadStartDate();

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT service_id, club_id, service_name,  number_months, group_number, term_type, transfer, signup_date, user_id, start_date, end_date, down_payment, initiation_fee, group_price, unit_price, monthly_dues, pro_rate_dues, group_type FROM monthly_services WHERE contract_key ='$this->contractKey'  AND  service_key= '$this->serviceKey' AND $this->dateField='$this->dateFieldValue' ORDER BY service_id ASC");

$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_id, $club_id, $service_name, $number_months, $group_number, $term_type, $tran, $signup_date, $user_id, $start_date, $end_date, $down_payment, $initiation_fee, $group_price, $unit_price, $monthly_dues, $pro_rate_dues, $group_type);
$rowCount = $stmt->num_rows;

             if($rowCount != 0) {
                              
                 //get the monthly payment type
                 $this->loadMonthlyPayment();
               
                            
                    while ($stmt->fetch()) {  
                         if(preg_match('/Membership/',$service_name)){
                            $stmt99 = $dbMain->prepare("SELECT service_type, service_key FROM service_info WHERE service_type LIKE '%Membership%' AND group_type = '$group_type'");
                            $stmt99->execute();
                            $stmt99->store_result();
                            $stmt99->bind_result($service_type, $service_key);
                            while($stmt99->fetch()){
                                 if ($service_type == $service_name){
                                    $select = "selected";
                                 }else{
                                     $select = "";
                                 }
                                $drop .= "<option value=\"$service_key|$service_type\" $select>$service_type</option>";
                            }
                            $stmt99->close();
                            $this->memDrop = "<select name=\"mem_drop\" id=\"mem_drop\">$drop</select>";
                            
                         }else{
                            $stmt99 = $dbMain->prepare("SELECT service_type, service_key FROM service_info WHERE service_type NOT LIKE '%Membership%' AND group_type = '$group_type'");
                            $stmt99->execute();
                            $stmt99->store_result();
                            $stmt99->bind_result($service_type, $service_key);
                            while($stmt99->fetch()){
                                 if ($service_type == $service_name){
                                    $select = "selected";
                                 }else{
                                     $select = "";
                                 }
                                $drop .= "<option value=\"$service_key|$service_type\" $select>$service_type</option>";
                            }
                            $stmt99->close();
                            $this->memDrop = "<select name=\"mem_drop\" id=\"mem_drop\">$drop</select>";
                         }
                            
                    
                            $stmt99 = $dbMain->prepare("SELECT club_name, club_id FROM club_info WHERE club_id != ''");
                            $stmt99->execute();
                            $stmt99->store_result();
                            $stmt99->bind_result($club_name, $club_id_drop);
                            while($stmt99->fetch()){
                                 if ($club_id == $club_id_drop){
                                    $select = "selected";
                                 }else{
                                     $select = "";
                                 }
                                $this->locDrop .= "<option value=\"$club_id_drop\" $select>$club_name</option>";
                            }
                            $stmt99->close();
                             // $this->serviceKey = $service_key; 
                            
                              
                    //get the club name
                     $result  =  $dbMain -> query("SELECT club_name FROM club_info WHERE club_id = '$club_id'");
                                      $row = mysqli_fetch_array($result, MYSQLI_NUM);
                                      $this->serviceLocation = $row[0];
                                                                    
                                  if($club_id == "0")  {
                                      $this->serviceLocation  = 'All Locations';
                                      $this->locDrop .= "<option value=\"0\" selected>All Locations</option>";
                                    }else{
                                        $this->locDrop .= "<option value=\"0\">All Locations</option>";
                                    }
                                      $this->serviceName = $service_name;
                                      $this->paymentTerm = 'Month to Month'; 
                                      
                                      //set up the english for the number of months                                
                                      $this->serviceDuration =  $number_months;
                                      $this->serviceTerm = 'M';
                                                                           
                                      $this->groupNumber =  $group_number;        
                                      $this->termType = $term_type;
                                      $this->transfer = $tran;
                                      
                                      //will use this for the html contract pop up and the member since date as well as the signup date for this service.  Also initiation fee or down payment
                                      $this->signupDate = date('F j, Y', strtotime($signup_date));
                                      
                                      //this sets up a date to compare with a contract date
                                      $this->contractDate = $signup_date;
                                       
                                      $this->userId = $user_id;
                                      $this->startDate = date('F j, Y', strtotime($start_date));
                                      $this->endDate =  date('F j, Y', strtotime($end_date));
                                      $this->downPayment = $down_payment;
                                      $this->initiationFee = $initiation_fee;
                                      $this->unitPrice = $unit_price;
                                      $this->groupPrice = $group_price;
                                      $this->monthlyDues = $monthly_dues;
                                      $this->proRateMonth  = $pro_rate_dues;
                                      
                                 
                                      
                                      //misc methods for contract info
                                      $this->loadContractLink();
                                      $this->loadContractType();
                                      
                                      //eventually make this a function that looks in the monthly payment table yet to be created
                                      $this->loadLastPayment();
                                
                                      //create the list of available refunds based on the date type                             
                                        $this->serviceId = $service_id;
                                        $this->loadAvailableRefunds();
                                                                    
                                      $this->loadCommissionCredit();
                                      
                                      //shows the product records if the date type is 'start date'
                                      if($this->dateField == 'start_date')  {
                                         $this->createProductRecord(); 
                                         }
                                      
                               
                             }         
                             
              }
              
   if(!$stmt->execute())  {
	printf("Error: %s.\n  monthly_services function loadMonthlyServices", $stmt->error);
      }
   
$stmt->close();      

//return $monthlyServices;

//echo "test2";  
}
//========================================================================
function loadPifServices() {

$this->serviceTableSql = 'paid_full_services';
$this->loadStartDate(); 

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT service_id, service_name,  service_quantity, service_term, group_price, unit_price, start_date, end_date, signup_date, user_id, club_id, group_number, transfer, group_type FROM paid_full_services WHERE contract_key ='$this->contractKey' AND  service_key= '$this->serviceKey' AND $this->dateField='$this->dateFieldValue' ORDER BY service_id ASC");

$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_id, $service_name, $service_quantity, $service_term, $group_price, $unit_price, $start_date, $end_date, $signup_date, $user_id, $club_id, $group_number, $tran, $group_type);
$this->rowCount = $stmt->num_rows;

             if($this->rowCount != 0) {
                                           
                    while ($stmt->fetch()) { 
                        
                        if(preg_match('/Membership/',$service_name)){
                            $stmt99 = $dbMain->prepare("SELECT service_type, service_key FROM service_info WHERE service_type LIKE '%Membership%' AND group_type = '$group_type'");
                            $stmt99->execute();
                            $stmt99->store_result();
                            $stmt99->bind_result($service_type, $service_key);
                            while($stmt99->fetch()){
                                 if ($service_type == $service_name){
                                    $select = "selected";
                                 }else{
                                     $select = "";
                                 }
                                $drop .= "<option value=\"$service_key|$service_type\" $select>$service_type</option>";
                            }
                            $stmt99->close();
                            $this->memDrop = "<select name=\"mem_drop\" id=\"mem_drop\">$drop</select>";
                            
                         }else{
                            $stmt99 = $dbMain->prepare("SELECT service_type, service_key FROM service_info WHERE service_type NOT LIKE '%Membership%' AND group_type = '$group_type'");
                            $stmt99->execute();
                            $stmt99->store_result();
                            $stmt99->bind_result($service_type, $service_key);
                            while($stmt99->fetch()){
                                 if ($service_type == $service_name){
                                    $select = "selected";
                                 }else{
                                     $select = "";
                                 }
                                $drop .= "<option value=\"$service_key|$service_type\" $select>$service_type</option>";
                            }
                            $stmt99->close();
                            $this->memDrop = "<select name=\"mem_drop\" id=\"mem_drop\">$drop</select>";
                         }
                        
                         $stmt99 = $dbMain->prepare("SELECT club_name, club_id FROM club_info WHERE club_id != ''");
                            $stmt99->execute();
                            $stmt99->store_result();
                            $stmt99->bind_result($club_name, $club_id_drop);
                            while($stmt99->fetch()){
                                 if ($club_id == $club_id_drop){
                                    $select = "selected";
                                 }else{
                                     $select = "";
                                 }
                                $this->locDrop .= "<option value=\"$club_id_drop\" $select>$club_name</option>";
                            }
                            $stmt99->close();
                                                                                                      
                               //get the club name
              $result  =  $dbMain -> query("SELECT club_name FROM club_info WHERE club_id = '$club_id'");
                               $row = mysqli_fetch_array($result, MYSQLI_NUM);
                               $this->serviceLocation = $row[0];
                                                                    
                            if($club_id == "0")  {
                               $this->serviceLocation  = 'All Locations';
                               $this->locDrop .= "<option value=\"0\" selected>All Locations</option>";
                               }else{
                                        $this->locDrop .= "<option value=\"0\">All Locations</option>";
                                    }
                                                                 
                               $this->serviceName = $service_name;
                               $this->paymentTerm = 'Paid in Full'; 
                                                              
                               //set up the english for the number of months
                               $this->serviceDuration = $service_quantity;
                               $this->serviceTerm = $service_term;

                               $this->groupNumber =  $group_number;
                               $this->termType = 'T';
                               $this->transfer = $tran;
                               
                             //will use this for the html contract pop up and the member since date as well as the signup date for this service.  Also initiation fee or down payment
                               $this->signupDate = date('F j, Y', strtotime($signup_date)); 
                               
                             //this sets up a date to compare with a contract date
                               $this->contractDate = $signup_date;
        
                               $this->userId = $user_id;
                               $this->startDate = date('F j, Y', strtotime($start_date));
                               $this->endDate = date('F j, Y', strtotime($end_date));     
                               $this->downPayment = 'NA';
                               $this->initiationFee = 'NA'; 
                               $this->unitPrice = $unit_price;
                               $this->groupPrice = $group_price;
                               $this->monthlyDues = 'NA';
                               $this->proRateMonth  = 'NA';
                                                                                                                                               
                              //misc methods  for contract info
                               $this->loadContractLink();
                               $this->loadContractType();
                               
                              //eventually make this a function that looks in the monthly payment table yet to be created
                              $this->loadLastPayment();
                               
                               
                              //create the list of available refunds based on the date type
                         //    if($this->dateField == 'signup_date') {
                              $this->serviceId = $service_id;
                              $this->loadAvailableRefunds();
                          //    }
                               
                               $this->loadCommissionCredit();
                               
                            //shows the product records if the date type is 'start date'
                             if($this->dateField == 'start_date')  {                               
                               $this->createProductRecord();
                               }
                               
                                     
                             } 
                            
             }

   if(!$stmt->execute())  {
	printf("Error: %s.\n   paid_full_services  function loadPifServices", $stmt->error);
      }
   
$stmt->close(); 

}
//==========================================================================
function loadAccountHolder()   {

$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT count(*) AS count FROM corporate_flag WHERE contract_key='$this->contractKey'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($this->corpFlag);
 $stmt->fetch();
 $stmt->close();
 
 $stmt = $dbMain ->prepare("SELECT count(*) AS count FROM billing_collections WHERE contract_key='$this->contractKey'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($this->collectionsFlag);
 $stmt->fetch();
 $stmt->close();
 

$stmt = $dbMain ->prepare("SELECT user_id, first_name, middle_name, last_name, street, city, state, zip, primary_phone, cell_phone, email, transfer, dob, license_number FROM contract_info WHERE  contract_key = '$this->contractKey' ORDER BY contract_date DESC LIMIT 1");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($user_id, $first_name, $middle_name, $last_name, $street, $city, $state, $zip, $primary_phone, $cell_phone, $email, $tran, $dob, $license);
 $stmt->fetch();


$this->firstName = $first_name;
$this->middleName = $middle_name;
$this->lastName = $last_name;
$this->streetAddress = $street;
$this->city = $city;
$this->state = $state;
$this->zipCode = $zip; 
$this->primaryPhone = $primary_phone;
$this->cellPhone = $cell_phone;
$this->emailAddress = $email;
$this->dob =  date('m/d/Y', strtotime($dob));
$this->licenseNumber = $license;

//this gets any prvious payment types like cc info and ach
$this->loadPaymentTypes();

//disable fields if not transferable
if($tran == 'N') {
$this->nameDisabled = 'readonly="readonly" style="color: #666"';
}


$this->stateSelect();
$this->loadGroupInfo();
$this->loadMemberSince();
$this->loadPaymentTypes();

$stmt->close();
}
//==========================================================================
function loadCurrentListings()  {

$dbMain = $this->dbconnect();      //ORDER BY start_date DESC

//first we start with pif services
$stmt = $dbMain ->prepare("SELECT DISTINCT service_key  FROM monthly_services WHERE contract_key = '$this->contractKey'  UNION ALL SELECT DISTINCT service_key FROM paid_full_services WHERE contract_key = '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($service_key);
$rowCount = $stmt->num_rows;


             if($rowCount != 0) {

                    while ($stmt->fetch()) {  
                             $this->serviceKey = $service_key;
                             $this->keyList .= "$service_key,";                             
                             $this->loadMonthlyServices(); 
                             $this->loadPifServices(); 
                             $this->fieldCount++;
                             } 
                                             
               }

   if(!$stmt->execute())  {
	printf("Error: %s.\n paid_full_services   function loadCurrentListings", $stmt->error);
      }
   
$stmt->close(); 

//$this->loadAvailableRefunds();
$this->loadEnhanceFees();
$this->loadGeneralFees();

$this->serviceSummary = "$this->serviceTableHeader $this->serviceRecords $this->serviceTableFooter";
}

//==========================================================================
function loadMemberRefunds() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT SUM(refund_amount) AS refund_amount FROM member_refund_records WHERE contract_key ='$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($refund_amount);
$stmt->fetch();

$this->refundMemberAmount = $refund_amount;

   if(!$stmt->execute())  {
	printf("Error: %s.\n  member_refund_records  function loadMemberRefunds", $stmt->error);
      }
   
$stmt->close(); 


}
//==========================================================================
function loadMemberListings() {

//gets the existing cancelations from the refund table
$this->loadCancelRefund();
$this->refundServiceTotal = $this->refundServiceTotal - $this->refundTableTotal;
$refundAll = $this->refundServiceTotal - $this->refundTableTotal;

//echo"$this->refundServiceTotal <br> $refundAll"; 

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT general_id, contract_key, member_id, first_name, middle_name, last_name, street, city, state, zip, dob FROM member_info WHERE contract_key ='$this->contractKey'");

$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($general_id, $contract_key, $member_id, $first_name, $middle_name, $last_name, $street, $city, $state, $zip, $dob);
$this->rowCount = $stmt->num_rows;


 if($this->rowCount != 0) {
 
                                
    while ($stmt->fetch()) { 
       
             //get the general and member id for holds if available
             $this->generalId = $general_id;
             $this->memberId = $member_id;
             $this->loadMemberHold();

                    //create color rows
                     static $cell_count = 1;
                      if($cell_count == 2) {
                         $color = "#D8D8D8";
                         $color2 = "D8D8D8";
                         $cell_count = "";
                         }else{
                         $color = "#FFFFFF";
                         $color2 = "FFFFFF";
                         }
                         $cell_count = $cell_count + 1;
                         
                         
          //make dob into english
          switch($dob) {          
             case"1970-01-01 00:00:00":
             $dob_text = 'NA';
             break;
             case"0000-00-00 00:00:00":
             $dob_text = 'NA';
             break;
             case"1969-12-31 00:00:00":
             $dob_text = 'NA';
             break;
             default:
             $dob_text = date('F j, Y', strtotime($dob));
             }
                         
           //setup listings in english              
             if($member_id == 0) {
               $member_id = 'Unassigned';
               }
              
             $member_name = "$first_name $middle_name $last_name"; 
              if($first_name == "" &&  $last_name == "") {
                 $member_name = 'NA';
                 }
                 
              $member_address = "$street $city $state $zip";  
                if($street == "" && $state == "" && $zip == "") {
                  $member_address = 'NA';
                  }
                  
             //sets up the street if not available for submitted array
               if($street == "") {
                  $street = 'NA';
                  }
       
            $this->cellCountMember++;
            
                   //sets up the header and fields for group refunds or service due for each group member
                    // if($this->refundServiceTotal == 0 &&  $refundAll == 0)  { 
                      if($this->cancelCount == $this->serviceCount)  {   
                          $color = '#06C';
                         }
                         
                      if($this->groupRefund == 0) {
                            $type_bit = 0;
                            $cancel_header_text = 'Cancel / Fee';                            
                            $member_credit  = sprintf("%.2f",$this->cancelBalance / $this->rowCount);
                            
                                          If($member_credit == '0.00') {
                                            $member_credit = 'NA';
                                            $disabled = 'disabled="disabled"';
                                            }else{
                                            $disabled = "";
                                            }
                                            
                                           if($this->memberHoldBit == 1) {
                                              $disabled = 'disabled="disabled"';
                                              }

                            $cancel_member_field = "<input name=\"cancel_member$this->cellCountMember\" type=\"text\" id=\"cancel_member$this->cellCountMember\" value=\"$member_credit\" size=\"7\" maxlength=\"8\" $disabled/>";
                         
                            
                        }else{
                        
                            $type_bit = 1;
                            $cancel_header_text = 'Cancel / Refund';  
                                                      
                                $this->loadMemberRefunds();
                           
                                             
                              if($this->refundMemberAmount != 0) {                             
                                // $member_credit = sprintf("%.2f",$this->refundServiceTotal - $this->refundMemberAmount);
                                $member_credit = sprintf("%.2f",$this->refundServiceTotal / $this->rowCount);
                                 }else{
                                 $member_credit = sprintf("%.2f",$this->refundServiceTotal / $this->rowCount);
                                 }
                            
                            
                            
                                        If($member_credit == '0.00') {
                                            $disabled = 'disabled="disabled"';  
                                            $disabledHold = 'disabled="disabled"'; 
                                            }else{
                                            $disabled = 'disabled="disabled"'; 
                                            $disabledHold =""; 
                                            }    
                                            
                              //this sets cancel to disabled if there is only one member left              
                              if($this->rowCount == 1) {
                                 $disabled = 'disabled="disabled"';
                                 }
                                 
                             if($this->memberHoldBit == 1) {
                              $disabled = 'disabled="disabled"';
                               }
                                                       
                            $cancel_member_field = "<input name=\"cancel_member$this->cellCountMember\" type=\"text\" id=\"cancel_member$this->cellCountMember\" value=\"$member_credit\" size=\"7\" maxlength=\"8\" readonly/>";
                        }
                        
               //takes care of background row color if member is on hold         
                 if($this->memberHoldBit == 1) {
                    $origColor = $color;
                    $color = "#900";
                    $checked = 'checked';
                    $disabled = 'disabled="disabled"';
                    }else{
                    $checked = "";
                    $origColor = $color;
                    }


             if($this->groupType == 'Single') {
                $cancel_member_field = "<input name=\"cancel_member$this->cellCountMember\" type=\"text\" id=\"cancel_member$this->cellCountMember\" value=\"$member_credit\" size=\"7\" maxlength=\"8\" disabled=disabled/>"; 
                $disabled = 'disabled="disabled"';
                $type_bit = 1;
                }


              if($this->cellCountMember == 1) {
                $memberCancel = 'NA';                
                }else{                
                $memberCancel ="<input type=\"checkbox\" name=\"cancel_mem[]\" id=\"cancel_mem$this->cellCountMember\" value=\"$member_id|$general_id|$this->contractKey|$member_credit\"onClick=\"prorateMembers(this,'c$this->cellCountMember','$member_credit','$color','cancel_member$this->cellCountMember', 'hold_mem$this->cellCountMember');\"/> $cancel_member_field";                           
                }
            

            $this->memberListings .="<tr id=\"c$this->cellCountMember\" style=\"background-color: $color\">
            <td align=\"left\" valign =\"top\" class=\"black\">$this->cellCountMember</td>
            <td align=\"left\" valign =\"top\" class=\"black\">$member_id</td>
            <td align=\"left\" valign =\"top\" class=\"black\">$member_name</td>
            <td align=\"left\" valign =\"top\" class=\"black\">$member_address</td>
            <td align=\"left\" valign =\"top\" class=\"black\">$dob_text</td>
            <td align=\"left\" valign =\"top\" class=\"black\">$memberCancel</td>
            <td align=\"left\" valign =\"top\" class=\"black\">
             <input type=\"checkbox\" name=\"hold_mem[]\" id=\"hold_mem$this->cellCountMember\"     value=\"$member_id|$general_id|$this->contractKey\" onClick=\"return changeColor4(this, 'c$this->cellCountMember', '$origColor', 'cancel_mem$this->cellCountMember', 'cancel_member$this->cellCountMember', '$this->memberHoldBit','$type_bit');\" $disabledHold $checked/>
            </td>
            </tr>";

           }

$this->groupListings = "                  
<div class=\"container\">
<p class=\"header\">Subtract Service Quantity (Members)<span class=\"plus\">+</span></p>
<div class=\"content\">
<table align=\"left\" border=\"1\" rules=\"none\" frame=\"box\" cellspacing=\"0\" cellpadding=\"1\" width=\"100%\" id=\"groupList\">
<tr class=\"tabHead\">
<td class=\"oBtext3 tile3\">   
#
</td>
<td class=\"oBtext3\">
Member Number
</td>
<td class=\"oBtext3\">
Member Name
</td>
<td class=\"oBtext3\">
Member Address
</td>
<td class=\"oBtext3\">
Date of Birth
</td>
<td class=\"oBtext3\">
$cancel_header_text
</td>
<td class=\"oBtext3 tile4\">
Hold
</td>
</tr>
$this->memberListings
</table>
</div>
</div>";
                   
                   


              }

$stmt->close(); 
}
//==========================================================================
function cancelRefundSum()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT SUM(refund_amount) AS refund_amount FROM refund_records WHERE contract_key ='$this->contractKey' AND refund_type = '$this->refundType'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($refund_amount);
$stmt->fetch();

$this->refundAmount = $refund_amount;

   if(!$stmt->execute())  {
	printf("Error: %s.\n  refund_records  function cancelRefundSum", $stmt->error);
      }
   
$stmt->close(); 

}
//=========================================================================
function loadCancelRefund()  {

//create the refund type array
$refundArray = 'SPP|SPF|SMP';
$refundArray = explode('|',$refundArray);

$this->refundType = $refundArray[0];
$this->cancelRefundSum();
$this->refundTableTotal = $this->refundTableTotal + $this->refundAmount;

$this->refundType = $refundArray[1];
$this->cancelRefundSum();
$this->refundTableTotal = $this->refundTableTotal + $this->refundAmount;

$this->refundType = $refundArray[2];
$this->cancelRefundSum();
$this->refundTableTotal = $this->refundTableTotal + $this->refundAmount;

}
//=========================================================================
function createAvailableRefunds()  {

//$this->dateField = 'signup_date';
//$this->loadCurrentListings();

}
//=========================================================================
function loadEndDate() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT end_date  FROM paid_full_services WHERE service_id = '$this->serviceId'  AND service_key = '$this->serviceKey' UNION SELECT  end_date FROM monthly_services WHERE service_id = '$this->serviceId' AND service_key='$this->serviceKey' ");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($end_date);
$stmt->fetch(); 

$this->endDateSeconds = strtotime($end_date); 
$this->endDate = $end_date;

$stmt->close();

}
//=========================================================================
function loadServiceName() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT service_type FROM service_info WHERE service_key='$this->serviceKey' ");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($service_type);
$stmt->fetch(); 

$this->serviceName = $service_type;

$stmt->close();
}
//=========================================================================
function loadServiceCredits()  {

//check for an existing record
$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT service_key, credit_sec_num, credit_term, credit_date, service_id FROM service_credits WHERE contract_key='$this->contractKey' ");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($service_key, $credit_sec_num, $credit_term, $credit_date, $service_id);
$rowCount = $stmt->num_rows;  

if($rowCount != 0)  {

      while ($stmt->fetch()) {  
                $this->serviceKey = $service_key;
                $this->loadServiceName();
                
                //format the date into english
                $date_secs = strtotime($credit_date); 
                $credit_date = date("F j, Y", $date_secs);
                $this->creditDurationSeconds = $credit_sec_num;
                
                if($credit_term == 'C') {
                    $class_num = $this->creditDurationSeconds;
                    $year_num = "";
                    $month_num = "";
                    $week_num = "";
                    $day_num = "";
                   }else{
                    $this->serviceKey = $service_key;
                    $this->serviceId = $service_id;
                    $this->loadEndDate();
                    
                    //we add the end date of the service to the extra credit duration in seconds then we convert it ty m d format for the diff function
                    $creditEndDateSeconds = $this->endDateSeconds + $this->creditDurationSeconds;
                    $creditEndDate = date("Y-m-d", $creditEndDateSeconds);
                    
                    //now we calc the dates                 
                    $datetime1 = new DateTime($this->endDate);
                    $datetime2 = new DateTime($creditEndDate);
                    $interval = $datetime1-> diff($datetime2);
                    $year_num = $interval-> format('%y');
                    if($year_num == 0) {
                      $year_num = "";
                      }
                    
                    $month_num = $interval-> format('%m');
                    if($month_num == 0) {
                      $month_num = "";
                      }
                      
                    $day_num = $interval-> format('%d'); 
                    if($day_num == 0) {
                      $day_num = "";
                      }
                      
                    $class_num = "";
                    
                  
                   
                   
                   }
                

$service_rows .= "<tr>
             <td class=\"black7 tile2\">
              $this->serviceName
             </td>
             <td class=\"black7 tile2\">
              $year_num
             </td>
             <td class=\"black7 tile2\">
              $month_num
             </td>             
             <td class=\"black7 tile2\">
              $day_num
             </td>
             <td class=\"black7 tile2\">
              $class_num
             </td>  
             <td class=\"black7 tile2\">
              $credit_date  
             </td>                   
             </tr>"; 

            }
            
$this->serviceCredits ="
<tr>
<td colspan=\"5\" >
    <table id=\"secTab7\"  cellpadding=\"2\" class=\"tabBoard4\"> 
    <tr class=\"tabHead\">
    <td colspan=\"7\" class=\"oBtext tile3 tile4\">
      Current Service Credits
    </td>
    </tr>    
    <tr class=\"tabHead\">
    <td class=\"oBtext3 tile6 tile3\">   
     Service Name
     </td>
     <td class=\"oBtext3 tile6\">
     Years(s)
    </td>
     <td class=\"oBtext3 tile6\">
     Month(s)
    </td>
    <td class=\"oBtext3 tile6\">
     Days(s)
    </td> 
    <td class=\"oBtext3 tile6\">
     Class(s)
    </td>     
    <td class=\"oBtext3 tile6 tile4\">
    Date
    </td>                    
    </tr> 
    $service_rows
    </table>
</td>
</tr>
<tr>
<td colspan= \"4\" class=\"tabPad\">&nbsp;</td>
</tr>";            
                        
}

$stmt->close(); 


}

//=========================================================================
function loadRejectionRecord() {

if($this->rejectionFee > 0 ) {
   $rejectChecked = 'checked';
   }
if($this->lateFee > 0 ) {
   $lateChecked = 'checked';
   }   
   

$this->rejectionRecord .="<tr id=\"rej\" bgcolor=\"#fff\" class=\"whiteBg\">
 <td class=\"keyText tile2\">
   $this->paymentDescription $this->monthRejected
 </td>
 <td class=\"keyText tile2\">
   $this->transactionType
 </td> 
 <td class=\"keyText tile2\">
  $this->rejectionPayment
 </td>
 <td class=\"keyText tile2\">
  $this->rejectionStatus
</td> 
 <td class=\"keyText tile2\" >
 <input type=\"checkbox\" name=\"reject$this->rejectionCount\" id=\"reject$this->rejectionCount\" value=\"$this->rejectionFee\" onClick=\"changeRejectFee(this, $this->rejectionCount);\" $rejectChecked/>
 <input  name=\"rejection_fee$this->rejectionCount\" type=\"text\" id=\"rejection_fee$this->rejectionCount\" value=\"$this->rejectionFee\" size=\"7\" maxlength=\"8\" readonly=\"readonly\"/>
 </td>  
  <td class=\"keyText tile2\" >
 <input type=\"checkbox\" name=\"late$this->rejectionCount\" id=\"late$this->rejectionCount\" value=\"$this->lateFee\" onClick=\"changeLateFee(this, $this->rejectionCount);\" $lateChecked/>
 <input  name=\"late_fee$this->rejectionCount\" type=\"text\" id=\"late_fee$this->rejectionCount\" value=\"$this->lateFee\" size=\"7\" maxlength=\"8\" readonly=\"readonly\"/>
 </td>  
 <td class=\"keyText tile2\" >
<input  name=\"rejection_total$this->rejectionCount\" type=\"text\" id=\"rejection_total$this->rejectionCount\" value=\"$this->rejectionTotal\" size=\"7\" maxlength=\"8\" readonly=\"readonly\"/>
 </td>   
 <td class=\"keyText tile2\">
  <input type=\"checkbox\" name=\"pay_dues[]\" id=\"pay_dues$this->rejectionCount\" value=\"$this->rejectionPayment|$this->contractKey|$this->historyKey|$this->rejectionCount|$this->paymentDescription|$this->rejectionFeeType|$this->checkNumber|$this->rejectionDate\" onClick=\"setRejectionDues(this, $this->rejectionCount);\"/>
 </td>
 <td class=\"keyText tile2\">
  <input type=\"checkbox\" name=\"delete_dues[]\" id=\"delete_dues$this->rejectionCount\" value=\"$this->contractKey|$this->historyKey|$this->rejectionCount\" onClick=\"deleteRejectionDues(this, $this->rejectionCount, $this->contractKey, $this->historyKey, $this->userId);\"/>
 </td>
 </tr>";


$this->rejectionCount++;
}
//--------------------------------------------------------------------------------------------------------------------------------
function loadRejectedPayments() {

//check for an existing record if it is a check
$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT check_number, check_payment FROM nsf_checks WHERE contract_key='$this->contractKey' AND check_bit='0'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($check_number, $check_payment);
$rowCount = $stmt->num_rows;  


//now we look in the payment history for tthe check record
if($rowCount != 0)  {

while ($stmt->fetch()) {  
     
 $stmt2 = $dbMain ->prepare("SELECT payment_description, history_key, payment_due_date FROM payment_history WHERE contract_key='$this->contractKey' AND check_payment='$check_payment' AND check_number='$check_number' ");
 $stmt2->execute();       
 $stmt2->store_result();   
 $stmt2->bind_result($payment_description, $history_key, $payment_due_date);
 $stmt2->fetch();
 $stmt2->close(); 
 
 $this->monthRejected = date('M',strtotime($payment_due_date));
 $this->paymentDescription = $payment_description;
 $this->historyKey = $history_key;
 $this->checkNumber = $check_number;
 $this->rejectionPayment = $check_payment;
 $this->rejectionFee = $this->nsfFee;
 $this->rejectionFeeType = 'NSFC';
 $this->transactionType = "Check #$check_number" ;
 $this->rejectionStatus = "Non Sufficient Funds";
 $this->dueDateSeconds = strtotime($payment_due_date);  
 $this->checkLateFee();  
 
 $this->rejectionTotal = $this->lateFee + $this->rejectionFee +  $this->rejectionPayment;
 $this->loadRejectionRecord();
 
}   
$stmt->close(); 
}

//here we check the rejections for recursive payments
$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT history_key, transaction_type, reject_message, payment_amount, last_attempt_date FROM rejected_payments WHERE contract_key='$this->contractKey' AND reject_bit = '0' ");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($history_key, $transaction_type, $reject_message, $payment_amount, $last_attempt_date);
$rowCount = $stmt->num_rows; 

if($rowCount != 0)  {

while ($stmt->fetch()) {  

$this->rejectionDate = $last_attempt_date;
if($transaction_type == 'CR') {
   $this->transactionType = 'Credit Card';
   $whereSql = 'credit_payment';
   $this->rejectionFee = $this->ccRejectFee; 
   $this->rejectionFeeType = 'CC';
   $this->checkNumber = 0;
   }
if($transaction_type == 'BA') {
   $this->transactionType = 'ACH Withdrawal';
   $whereSql = 'ach_payment';
   $this->rejectionFee = $this->nsfFee;
   $this->rejectionFeeType = 'NSFA';
   $this->checkNumber = 0;
   }
      
 $stmt2 = $dbMain ->prepare("SELECT payment_description, payment_due_date, trans_key FROM payment_history WHERE contract_key='$this->contractKey' AND $whereSql='$payment_amount' AND history_key='$history_key' ");
 $stmt2->execute();       
 $stmt2->store_result();   
 $stmt2->bind_result($payment_description, $payment_due_date, $trans_key);
 $stmt2->fetch();
 $stmt2->close(); 

 $this->monthRejected = date('M',strtotime($payment_due_date));
 $this->paymentDescription = $payment_description;
 $this->historyKey = $history_key;
 $this->rejectionPayment = $payment_amount; 
 $this->rejectionStatus = $reject_message;
 $this->dueDateSeconds = strtotime($payment_due_date);  
 $this->checkLateFee();  
 
 //if there is a past due balance then we negate the rejection payment since it will be covered in the past due balance field when displayed
 if($this->pastDueBalance == '0.00') {
    $this->rejectionTotal = $this->lateFee + $this->rejectionFee +  $this->rejectionPayment;
    $this->rejectionTotal = number_format($this->rejectionTotal, 2, '.', '');
    }else{
    
      if($this->paymentDescription == 'Monthly Dues CC' ||  $this->paymentDescription == 'Monthly Dues ACH') {
         $this->rejectionTotal = $this->lateFee + $this->rejectionFee;
         $this->rejectionTotal = number_format($this->rejectionTotal, 2, '.', '');
         }else{         
         $this->rejectionTotal = $this->lateFee + $this->rejectionFee +  $this->rejectionPayment;
         $this->rejectionTotal = number_format($this->rejectionTotal, 2, '.', '');         
         }
    
    }
    
 $this->loadRejectionRecord();

}
$stmt->close(); 
}


if($this->rejectionRecord != null) {

$this->rejectListings = "                  
<div class=\"container2\">
<table id=\"secTab8\"  cellpadding=\"2\" class=\"tabBoard4\"> 
<tr class=\"tabHead\">
<td colspan=\"9\" class=\"oBtext tile3 tile4\">
Rejected Transactions
</td>
</tr>
<tr class=\"tabHead\">
<td class=\"oBtext3 tile6 tile3\">   
Transaction Name
</td>
<td class=\"oBtext3 tile6\">
Transaction Type
</td>
<td class=\"oBtext3 tile6\">
Trans Amount
</td>
<td class=\"oBtext3 tile6\">
Rejection Status
</td> 
<td class=\"oBtext3 tile6\">
Rejection Fee
</td> 
<td class=\"oBtext3 tile6\">
Late Fee
</td> 
<td class=\"oBtext3 tile6\">
Payment Total
</td>
<td class=\"oBtext3 tile6\">
Select 
</td>
<td class=\"oBtext3 tile6\">
Delete 
</td>
</tr>

<tr class=\"tabHead\">
<td class=\"oBtext3 tile6 tile3\">   
</td>
<td class=\"oBtext3 tile6\">
</td>
<td class=\"oBtext3 tile6\">
</td>
<td class=\"oBtext3 tile6\">
</td> 
<td class=\"oBtext3 tile6\">
</td> 
<td class=\"oBtext3 tile6\">
</td> 
<td class=\"oBtext3 tile6\">
</td>
<td class=\"oBtext3 tile6\">
Check All<input type=\"checkbox\" name=\"select_all\" id=\"select_all\" value=\"$this->rejectionCount\" onClick=\"checkAll(this, $this->rejectionCount);\"/>UnCheck All<input type=\"checkbox\" name=\"un_select_all\" id=\"un_select_all\" value=\"$this->rejectionCount\" onClick=\"unCheckAll(this, $this->rejectionCount);\"/>
</td>
<td class=\"oBtext3 tile6\">
</td>
</tr>

$this->rejectionRecord 

</table>
</div>";

}else{
$this->rejectListings = "";
}

return $this->rejectListings;

}
//=========================================================================

//group info if exists
function getGroupForm() {
             return($this->groupForm);
             }

function getGroupName() {
             return($this->groupName);
             }
             

//if not transferable contract
function getNameDisabled() {
             return($this->nameDisabled);
             }

function getServiceSummary() {
             return($this->serviceSummary);
             }
function getCancelationFee() {
             return($this->cancelationFee);
             }
function getPastDueBalance() {
             return($this->pastDueBalance);
             }
function getTotalBalanceDue() {
             return($this->totalBalanceDue);
             }


//contract holder information
function getFirstName() {
             return($this->firstName);
             }
function getMiddleName() {
             return($this->middleName);
             }         
function getLastName() {
             return($this->lastName);
             }
function getStreetAddress() {
             return($this->streetAddress);
             }
function getCity() {
             return($this->city);
             }
function getStateList() {
             return($this->stateList);
             }  
 function getState() {
             return($this->state);
             }   
 function getZipCode() {
             return($this->zipCode);
             }            
 function getPrimaryPhone() {
             return($this->primaryPhone);
             }            
 function getCellPhone() {
             return($this->cellPhone);
             }            
function getEmailAddress() {
             return($this->emailAddress);
             }
function getDob() {
             return($this->dob);
             }
function getGroupType() {
             return($this->groupType);
             }      
function getLicenseNumber() {
             return($this->licenseNumber);
             }

//banking and cc info
function getBankName() {
          return($this->bankName);
          }
function getAccountType() {          
          return($this->accountType);
          }
function getAccountName() {          
          return($this->accountName);
          }
function getAccountNumber() {          
          return($this->accountNumber);
          }
function getRoutingNumber() {          
          return($this->routingNumber);
          }
function getCardName() {          
          return($this->cardName);
          }
function getCardType() {
         return($this->cardType);
         }
function getCardNumber() {         
         return($this->cardNumber);
         }
function getCardCvv() {         
         return($this->cardCvv);
         }
function getCardExpDate() {         
         return($this->cardExpDate);
         }


function getEnhanceCycle() {
         return($this->enhanceCycle);
         }
function getEnhanceFee() {
         return($this->enhanceFee);
         }
function getGuaranteeCycle() {
         return($this->guaranteeCycle);
         }
function getGuaranteeFee() {
         return($this->guaranteeFee);
         }
function getHoldFee() {
         return($this->holdFee);
         }
function getNsfFee() {
         return($this->nsfFee);
         }   
function getCcRejectFee() {
         return($this->ccRejectFee);
         }             
function getLateFee() {
         return($this->lateFee);
         }              
function getMemberHoldFee()  {
         return($this->memberHoldFee);
         }
function getMonthlyPayment()  {
         return($this->monthlyPayment);   //this is for new services selected
         }
function getMonthlyBillingType()  {
         return($this->monthlyBillingType);   //this is for new services selected
         }
function getTransferFee() {
         return($this->transferFee);
         }
function getPastDueGrace() {
         return($this->pastDueGrace);
         }
function getHoldGrace() {
         return($this->holdGrace);
         }         
         
function getAvailableRefunds()  {
         return($this->availableRefunds);
         }
function getBundledRefund()  {
         return($this->bundleRefund);
         }         
function getSingleRefund()  {
         return($this->singleRefund);
         }
function getPartialPaymentRefund()  {
         return($this->partialPaymentRefund);
         }
function getRefundServiceTotal()  {
         return($this->refundServiceTotal);
         }
function getRefundTableTotal()  {
         return($this->refundTableTotal);
         }         
  
function getGroupListings() {
         return($this->groupListings);
         }
         
 function getDisabledKeyList() {
         return($this->refundDisabledKeys);
         }

function getServiceCredits() {
         return($this->serviceCredits);
         }
function getNextDueDate() {
         return($this->lastPaymentDate);
         }
function getPastDays() {
         return($this->pastDays);
         }  
function getCorpFlag() {
         return($this->corpFlag);
         }        
function getCollectionsFlag() {
         return($this->collectionsFlag);
         } 
}

?>