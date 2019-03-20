<?php
//error_reporting(E_ALL);
class updateTablesSucessfulTransaction {

private $color = null;
    
function dbconnect()   {
require"/var/www/vhosts/ems/cmp.burbankathleticclub.com/admin/dbConnect.php";
return $dbMain;
}

//=============================================
function loadNextBillingDate(){
    $dbMain = $this->dbconnect();
    
    $this->nextPaymentDueDate = '';
    $stmt = $dbMain->prepare("SELECT count(*) as count, MAX(next_payment_due_date) FROM monthly_settled WHERE contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($count, $this->nextPaymentDueDate); 
    $stmt->fetch();
    $stmt->close();
    
    $stmt = $dbMain->prepare("SELECT cycle_date FROM monthly_payments WHERE contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->cycleDate); 
    $stmt->fetch();
    $stmt->close();
    
     $customerBillingDate = date('d',strtotime($this->cycleDate));
                    
     if(date('d') < $customerBillingDate){
        $mStart = date('m')-1;//8;
        $yStart = date('Y');
        $dStart = date('d');//25;
     }elseif(date('d') == $customerBillingDate){
        $mStart = date('m');//8;
        $yStart = date('Y');
        $dStart = date('d');//25;
     }elseif(date('d') > $customerBillingDate){
        $mStart = date('m');//8;
        $yStart = date('Y');
        $dStart = date('d');//25;
                    }
    
    $monthNow = date("m");//'12';
    $dayNow = date("d");
    $yearNow = date("Y");

    $billCycStart = date('Y-m-d H:i:s',mktime(23,59,59,date('m',strtotime($this->nextPaymentDueDate)),date('d',strtotime($this->nextPaymentDueDate))-$this->pastDays,date('Y',strtotime($this->nextPaymentDueDate))));
    
    $cycM = date('m',strtotime($billCycStart));
    $cycD = date('d',strtotime($billCycStart));
    $cycY = date('Y',strtotime($billCycStart));
    
    $this->nextPaymentDueDate = trim($this->nextPaymentDueDate);

    $this->cycleDay = date("d",strtotime($this->cycleDate));        
    
    if ($count == 0){
       $this->monthlySettledBool = 0;
        $month = date("m",strtotime($this->cycleDate));
        $year = date("Y", strtotime($this->cycleDate));
        
        
        
                    if ($dayNow <= $this->cycleDay  AND $monthNow != $mStart){
                        $this->nextBillingDate = date("Y-m-d H:i:s"  , mktime(0,0,0,$monthNow,$cycD,$yearNow));
                        $this->settledDate = date("Y-m-d H:i:s"  , mktime(23,59,59,$monthNow,$cycD+$this->pastDays,$yearNow));
                    }else if ($dayNow <= $this->cycleDay AND $monthNow == $mStart){
                        $this->nextBillingDate = date("Ymd"  , mktime(0,0,0,$monthNow+1,$cycD,$yearNow));
                        $this->settledDate = date("Y-m-d H:i:s"  , mktime(23,59,59,$monthNow+1,$cycD+$this->pastDays,$yearNow));
                    }else if ($dayNow > $this->cycleDay){// AND $monthNow == $mStart
                        $this->nextBillingDate = date("Ymd"  , mktime(0,0,0,$monthNow+1,$cycD,$yearNow));
                        $this->settledDate = date("Y-m-d H:i:s"  , mktime(23,59,59,$monthNow+1,$cycD+$this->pastDays,$yearNow));
                         }
        
    }elseif ($count != 0){
        $this->monthlySettledBool = 1;
        $day = $this->cycleDay;
        $month = date("m",strtotime($this->nextPaymentDueDate));
        $year = date("Y", strtotime($this->nextPaymentDueDate));
        //$day = $day - $this->pastDays;

              
                    if ($dayNow <= $this->cycleDay  AND $monthNow != $mStart){
                        $this->nextBillingDate = date("Y-m-d H:i:s"  , mktime(0,0,0,$monthNow,$day,$yearNow));
                        $this->settledDate = date("Y-m-d H:i:s"  , mktime(23,59,59,$monthNow,$day+$this->pastDays,$yearNow));
                    }else if ($dayNow <= $this->cycleDay AND $monthNow == $mStart){
                        $this->nextBillingDate = date("Ymd"  , mktime(0,0,0,$monthNow+1,$day,$yearNow));
                        $this->settledDate = date("Y-m-d H:i:s"  , mktime(23,59,59,$monthNow+1,$day+$this->pastDays,$yearNow));
                    }else if ($dayNow > $this->cycleDay){// AND $monthNow == $mStart
                        $this->nextBillingDate = date("Ymd"  , mktime(0,0,0,$monthNow+1,$day,$yearNow));
                        $this->settledDate = date("Y-m-d H:i:s"  , mktime(23,59,59,$monthNow+1,$day+$this->pastDays,$yearNow));
                         }
    }
  
}
//===================================================================================
function insertMemberEnhanceEft(){
    
    $dbMain = $this->dbconnect();
    
	$contractKey = $this->contractKey;
	
    $stmt = $dbMain->prepare("SELECT eft_cycle, eft_cycle_date FROM member_enhance_eft WHERE contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($eft_cycle, $pif_cycle_date); 
    $stmt->fetch();
    $stmt->close();
    
    $pif_cycle_date = trim($pif_cycle_date);
    
    
    if($pif_cycle_date == '' OR $pif_cycle_date == 0){
	$sql = "INSERT INTO member_enhance_eft VALUES (?,?,?,?)";
	$stmt = $dbMain->prepare($sql);
	$stmt->bind_param('issd',$contractKey, $this->enhanceCycle, $this->enhanceCycleDate, $this->enhanceFee);
	if(!$stmt->execute())  {
            	printf("Error:insertEHFEE %s.\n", $stmt->error);
                  }	
	$stmt->close();
    }elseif($pif_cycle_date != ''){
        
        switch($eft_cycle){
            case 'M':
                $eft_cycle_date = date('Y-m-d H:i:s',mktime(0,0,0,date('m',strtotime($pif_cycle_date))+1,date('d',strtotime($pif_cycle_date)),date('Y',strtotime($pif_cycle_date))));
            break;
            case 'Q':
            $eft_cycle_date = date('Y-m-d H:i:s',mktime(0,0,0,date('m',strtotime($pif_cycle_date))+3,date('d',strtotime($pif_cycle_date)),date('Y',strtotime($pif_cycle_date))));
            break;
            case 'B':
            $eft_cycle_date = date('Y-m-d H:i:s',mktime(0,0,0,date('m',strtotime($pif_cycle_date))+6,date('d',strtotime($pif_cycle_date)),date('Y',strtotime($pif_cycle_date))));
            break;
            case 'A':
            $eft_cycle_date = date('Y-m-d H:i:s',mktime(0,0,0,date('m',strtotime($pif_cycle_date)),date('d',strtotime($pif_cycle_date)),date('Y',strtotime($pif_cycle_date))+1));
            break;
        }
        
        $sql = "UPDATE member_enhance_eft SET eft_cycle_date = ?  WHERE contract_key = '$this->contractKey'";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('s', $eft_cycle_date);
        if(!$stmt->execute())  {
                    	printf("Error:updateEHFEE %s.\n", $stmt->error);
                          }	
        
        $stmt->close();
    }
    

}
//===================================================================================
function insertMemberGuaranteeEft(){
    //echo "test";
    $dbMain = $this->dbconnect();
  
	$contractKey = $this->contractKey;
	//$guarantee_fee = $this->RGnextBillingFee;

    $stmt = $dbMain->prepare("SELECT eft_cycle, eft_cycle_date FROM member_guarantee_eft WHERE contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($eft_cycle, $annual_cycle_date); 
    $stmt->fetch();
    $stmt->close();
    
    $annual_cycle_date = trim($annual_cycle_date);
    
    if($annual_cycle_date == ''){
	$sql = "INSERT INTO member_guarantee_eft VALUES (?,?,?,?)";
	$stmt = $dbMain->prepare($sql);
	$stmt->bind_param('issd',$contractKey, $this->guarenteeCycle, $this->guarenteeCycleDate, $this->rateFee);
	if(!$stmt->execute())  {
            	printf("Error:insertRGFEE %s.\n", $stmt->error);
                  }	
	$stmt->close();
    }elseif($annual_cycle_date != ''){
        
        switch($eft_cycle){
            case 'M':
                $eft_cycle_date = date('Y-m-d H:i:s',mktime(0,0,0,date('m',strtotime($annual_cycle_date))+1,date('d',strtotime($annual_cycle_date)),date('Y',strtotime($annual_cycle_date))));
            break;
            case 'Q':
            $eft_cycle_date = date('Y-m-d H:i:s',mktime(0,0,0,date('m',strtotime($annual_cycle_date))+3,date('d',strtotime($annual_cycle_date)),date('Y',strtotime($annual_cycle_date))));
            break;
            case 'B':
            $eft_cycle_date = date('Y-m-d H:i:s',mktime(0,0,0,date('m',strtotime($annual_cycle_date))+6,date('d',strtotime($annual_cycle_date)),date('Y',strtotime($annual_cycle_date))));
            break;
            case 'A':
            $eft_cycle_date = date('Y-m-d H:i:s',mktime(0,0,0,date('m',strtotime($annual_cycle_date)),date('d',strtotime($annual_cycle_date)),date('Y',strtotime($annual_cycle_date))+1));
            break;
        }
        
        $sql = "UPDATE member_guarantee_eft SET eft_cycle_date = ?  WHERE contract_key = '$this->contractKey'";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('s', $eft_cycle_date);
        if(!$stmt->execute())  {
                    	printf("Error:updateRGFEE %s.\n", $stmt->error);
                          }	
        
        $stmt->close();
    }
    

}
//===================================================================================
function insertMaintnenceFee(){
    //echo "test";
    $dbMain = $this->dbconnect();
  
	//$guarantee_fee = $this->RGnextBillingFee;

    $stmt = $dbMain->prepare("SELECT m_cycle, m_cycle_date FROM member_maintnence_eft WHERE contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($m_cycle, $m_cycle_date); 
    $stmt->fetch();
    $stmt->close();
    
    $m_cycle_date = trim($m_cycle_date);
    
    if($m_cycle_date == ""){
            $month = date('m');
            $day = date('d');
            $year = date('Y');
        
          switch($this->mCycle){
            case 'M':
                $mDate = date('Y-m-d H:i:s',mktime(23,59,59,$month+1,$day,$year));
            break;
            case 'Q':
                $mDate = date('Y-m-d H:i:s',mktime(23,59,59,$month+3,$day,$year));
            break;
            case 'B':
                $mDate = date('Y-m-d H:i:s',mktime(23,59,59,$month+6,$day,$year));
            break;
            case 'A':
                $mDate = date('Y-m-d H:i:s',mktime(23,59,59,$month+12,$day,$year));
            break;
            }
           	$sql = "INSERT INTO member_maintnence_eft VALUES (?,?,?,?)";
           	$stmt = $dbMain->prepare($sql);
           	$stmt->bind_param('issd',$this->contractKey, $this->mCycle, $mDate, $this->maintnenceFee);
        	if(!$stmt->execute())  {
                    	printf("Error:insertMaintFEE %s.\n", $stmt->error);
                          }	
        	$stmt->close();
    }elseif($m_cycle_date != ""){
        
        switch($m_cycle){
            case 'M':
                $eft_cycle_date = date('Y-m-d H:i:s',mktime(0,0,0,date('m',strtotime($m_cycle_date))+1,date('d',strtotime($m_cycle_date)),date('Y',strtotime($m_cycle_date))));
            break;
            case 'Q':
                $eft_cycle_date = date('Y-m-d H:i:s',mktime(0,0,0,date('m',strtotime($m_cycle_date))+3,date('d',strtotime($m_cycle_date)),date('Y',strtotime($m_cycle_date))));
            break;
            case 'B':
                $eft_cycle_date = date('Y-m-d H:i:s',mktime(0,0,0,date('m',strtotime($m_cycle_date))+6,date('d',strtotime($m_cycle_date)),date('Y',strtotime($m_cycle_date))));
            break;
            case 'A':
                $eft_cycle_date = date('Y-m-d H:i:s',mktime(0,0,0,date('m',strtotime($m_cycle_date)),date('d',strtotime($m_cycle_date)),date('Y',strtotime($m_cycle_date))+1));
            break;
        }
        
        $sql = "UPDATE member_maintnence_eft SET m_cycle_date = ?  WHERE contract_key = '$this->contractKey'";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('s', $eft_cycle_date);
        if(!$stmt->execute())  {
                    	printf("Error:updateMaintFEE %s.\n", $stmt->error);
                          }	
        
        $stmt->close();
    }
    

}
//===================================================================================
function insertMonthlySettled(){

    $paymentDate = $this->paymentDate;// date("Y-m-d H:i:s"  , strtotime($this->paymentDate));
	$nextBillingDate = $this->settledDate;//date("Y-m-d H:i:s"  ,strtotime($this->nextBillingDate));
    
	$contractKey = $this->contractKey;
	$transKey = $this->authorizationId;
	$nextBillingFee = $this->billingAmount;
    
    switch($this->transactionType){
        case 'CC':
            $transType = 'CR';
        break;
        case 'ACH':
            $transType = 'BA';
        break;
    }

    
	$dbMain = $this->dbconnect();
 
    if($this->monthlySettledBool == 0){
	$sql = "INSERT INTO monthly_settled VALUES (?,?,?,?,?,?)";
	$stmt = $dbMain->prepare($sql);
	$stmt->bind_param('iidsss',$contractKey,$transKey,$nextBillingFee,$paymentDate,$nextBillingDate,$transType);
	if(!$stmt->execute())  {
            	printf("Error:insertMonthlySettled %s.\n", $stmt->error);
                  }	
	$stmt->close();
    }elseif($this->monthlySettledBool == 1 AND $this->nextPaymentDueDate != $nextBillingDate){
        
        $sql = "UPDATE monthly_settled SET payment_amount = ?, payment_date= ?, next_payment_due_date = ?  WHERE contract_key = '$this->contractKey'";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('dss', $nextBillingFee, $paymentDate, $nextBillingDate);
        if(!$stmt->execute())  {
                    	printf("Error:updatemonthlysettled2 %s.\n", $stmt->error);
                          }	
        
        $stmt->close();
    }
    

}
//========================================================================================================================
function insertPaymentHistory(){
    
$dbMain = $this->dbconnect();
//echo"<BR>PAYMENT HSITORY TESTER%%%%%%%%%%%%%%%%%%%%%%%%%%%% this->switcher $this->switcher";

                
if ($this->transactionType == 'CC'){
    $creditPayment = $this->billingAmount;
    $cashPayment = 0;
    $achPayment = 0;
    $checkPayment = 0;
    $ccRequestID = $this->authorizationId;
    $achRequestID = 0;
    }elseif ($this->transactionType == 'ACH'){
        $creditPayment = 0;
        $achPayment = $this->billingAmount;
        $cashPayment = 0;
        $checkPayment = 0;
        $ccRequestID = 0;
        $achRequestID = $this->authorizationId;
        }
                     
$currentBalance = 0;
$balanceDueDate = $this->paymentDate;
$paymentFlag = 'PF';
$rejectFeeCheck = 0;
$rejectFeeCredit = 0;
$rejectFeeAch = 0;
$lateFeeAll = 0;
$paymentDescription = $this->paymentDescription;
$historyKey = "";
$contractKey = $this->contractKey;
$paymentAmount = $this->billingAmount;                                            
//$paymentDate = $this->paymentDate;   
$paymentDate = date('Y-m-d H:i:s',mktime(0,0,0,$this->cycleStartMonth, $this->cycleStartDay, $this->cycleStartYear)); //$this->paymentDate;                     
$transKey = $this->authorizationId;                                          
$checkNumber = '0';
$bundled = 'N';

$stmt = $dbMain ->prepare("SELECT count(*) FROM payment_history WHERE contract_key = '$this->contractKey' AND MONTH(payment_date) = '$this->cycleStartMonth' AND YEAR(payment_date) = '$this->cycleStartYear' AND payment_description = '$paymentDescription' AND payment_flag = 'PF'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();  

if($count == 0){
    $sql = "INSERT INTO payment_history VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

    $stmt = $dbMain->prepare($sql);
    
    $stmt->bind_param('iidisssssdiiiisiiiiss',$historyKey, $contractKey, $paymentAmount, $currentBalance, $balanceDueDate, $paymentDate, $paymentFlag, $paymentDescription, $transKey, $creditPayment, $achPayment, $cashPayment, $checkPayment, $checkNumber, $bundled, $rejectFeeCheck, $rejectFeeCredit, $rejectFeeAch, $lateFeeAll,$ccRequestID, $achRequestID);
    
    if(!$stmt->execute())  {
        printf("Error:insertPaymentHistory1 %s.\n", $stmt->error);
    }	
    
    $stmt->close();
}
                 
                

 
 
}
//==============================================================================================
function moveData(){

$counter = 0;
$settledCount = 0;
$RGCounter = 0;
$EFCounter = 0;
$settledTotal = 0;
$rgTotal = 0;
$efTotal = 0;


$BIGTotal = 0;



$dbMain = $this->dbconnect(); 

$stmt = $dbMain->prepare("SELECT eft_cycle, annual_cycle_date FROM guarantee_fee_cycles WHERE cycle_num = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->guarenteeCycle, $this->guarenteeCycleDate); 
$stmt->fetch();
$stmt->close();

$stmt = $dbMain->prepare("SELECT eft_cycle, pif_cycle_date FROM enhance_fee_cycles WHERE cycle_num = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->enhanceCycle, $this->enhanceCycleDate); 
$stmt->fetch();
$stmt->close();

$stmt = $dbMain->prepare("SELECT m_cycle FROM member_maintnence_cycle WHERE cycle_num = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->mCycle); 
$stmt->fetch();
$stmt->close();



$stmt = $dbMain-> prepare("SELECT rate_fee, enhance_fee, late_fee, rejection_fee, maintnence_fee FROM fees WHERE fee_num = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->rateFee, $this->enhanceFee, $this->lateFee, $this->rejectionFee, $this->maintnenceFee);
$stmt->fetch();
$stmt->close();

$stmt = $dbMain->prepare("SELECT past_day FROM billing_cycle WHERE cycle_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->pastDays); 
$stmt->fetch();
$stmt->close();


$stmt999 = $dbMain->prepare("SELECT payment_id, contract_key, payment_type, transaction_type, authorization_id, attempt_number, billing_amount, cycle_start_day, cycle_start_month, cycle_start_day, cycle_start_year FROM billing_scheduled_recuring_payments WHERE processed = 'Y' AND imported = 'N' AND outstanding_balance = 'N'");
             if(!$stmt999->execute())  {
            	printf("Error:main loader %s.\n", $stmt999->error);
                  }	                                      // OR   first_name = '$this->firstName' AND last_name = '$this->lastName'
$stmt999->store_result();
$stmt999->bind_result($payment_id, $this->contractKey, $this->paymentType, $this->transactionType, $this->authorizationId, $this->attemptNumber, $this->billingAmount, $this->cycleDay, $this->cycleStartMonth, $this->cycleStartDay, $this->cycleStartYear);
while($stmt999->fetch()){
//echo "fubar";
//$this->cycleEndDay = $this->cycleStartDay + $this->pastDays;

  $this->paymentDate = date("Y-m-d H:i:s");
  
  $this->loadNextBillingDate();
 
 switch($this->paymentType){
    case 'RF':
        $this->insertMemberGuaranteeEft();
        $RGCounter++;
        $rgTotal += $this->billingAmount;
        $this->paymentDescription = "Rate Guarentee $this->transactionType";
    break;
    case 'EF':
        $this->insertMemberEnhanceEft();
        $EFCounter++;
        $efTotal += $this->billingAmount;
        $this->paymentDescription = "Enhance Fee $this->transactionType";
    break;
    case 'MS':
        $this->insertMonthlySettled();
        $settledCount++;
        $settledTotal += $this->billingAmount;
        $this->paymentDescription = "Monthly Dues $this->transactionType";
    break;
     case 'MF':
        $this->insertMaintnenceFee();
        $this->paymentDescription = "Maintnence Fee $this->transactionType";
    break;
    case 'PD':
        $this->insertMonthlySettled();
        $settledCount++;
        $settledTotal += $this->billingAmount;
        $this->paymentDescription = "Past Monthly Dues $this->transactionType";
    break;
 }
 $this->insertPaymentHistory();
 
  $imported = 'Y';
  $sql = "UPDATE billing_scheduled_recuring_payments SET imported = ? WHERE contract_key = '$this->contractKey' AND payment_id = '$payment_id'";
  $stmt = $dbMain->prepare($sql);
  $stmt->bind_param('s', $imported);
  if(!$stmt->execute())  {
 	  printf("Error:updateEHFEE %s.\n", $stmt->error);
     }	          
  $stmt->close();
 
  $counter++; 
  $payment_id = "";
  $this->contractKey = "";
  $this->paymentType = "";
  $this->transactionType = "";
  $this->authorizationId = "";
  $this->attemptNumber = "";
  $this->billingAmount = "";
  $this->cycleDay = "";
  $this->cycleStartMonth = "";
  $this->cycleStartDay = "";
  $this->cycleStartYear = "";
 }   
$stmt999->close();  

include"/var/www/vhosts/ems/cmp.burbankathleticclub.com/admin/firstData/updateTablesFailedTransactionCL.php";
$update = new updateTablesFailedTransaction();
$update->moveData();

}
//============================================
function getSuccess(){
    return($this->success);
}
//===========================================================================================================
}
//
$update = new updateTablesSucessfulTransaction();
$update->moveData();


?>