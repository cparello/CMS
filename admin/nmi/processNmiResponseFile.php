<?php
 //error_reporting(E_ALL);
class processResponseFile {

function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//==============================================
function fileExists($path){
    return (@fopen($path,"r")==true);
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
	$stmt->execute();
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
        $stmt->execute();
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
	$stmt->execute();
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
        $stmt->execute();
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
        	$stmt->execute();
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
        $stmt->execute();
        $stmt->close();
    }
    

}
//===================================================================================
function insertMonthlySettled(){

    $paymentDate = $this->paymentDate;// date("Y-m-d H:i:s"  , strtotime($this->paymentDate));
	$nextBillingDate = $this->settledDate;//date("Y-m-d H:i:s"  ,strtotime($this->nextBillingDate));
    
	$contractKey = $this->contractKey;
	$transKey = $this->authCode;
	$nextBillingFee = $this->amount;
    
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
	$stmt->execute();
	$stmt->close();
    }elseif($this->monthlySettledBool == 1 AND $this->nextPaymentDueDate != $nextBillingDate){
        
        $sql = "UPDATE monthly_settled SET payment_amount = ?, payment_date= ?, next_payment_due_date = ?  WHERE contract_key = '$this->contractKey'";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('dss', $nextBillingFee, $paymentDate, $nextBillingDate);
        $stmt->execute();
        
        $stmt->close();
    }
    

}
//========================================================================================================================
function insertPaymentHistory(){
    
$dbMain = $this->dbconnect();

if ($this->transactionType == 'CC'){
    $creditPayment = $this->amount;
    $cashPayment = 0;
    $achPayment = 0;
    $checkPayment = 0;
    $ccRequestID = $this->transID;
    $achRequestID = 0;
    }elseif ($this->transactionType == 'ACH'){
        $creditPayment = 0;
        $achPayment = $this->amount;
        $cashPayment = 0;
        $checkPayment = 0;
        $ccRequestID = 0;
        $achRequestID = $this->transID;
        }
                     
       


$rejectFeeCheck = 0;

                     
if($this->response == 1){
    $paymentFlag = 'PF';
    $rejectFeeCheck = 0;
    $rejectFeeCredit = 0;
    $rejectFeeAch = 0;
    $lateFeeAll = 0;
    $currentBalance = 0;
$balanceDueDate = $this->paymentDate;
    
}else if($this->response == 2){
    $paymentFlag = 'RE';
    $lateFeeAll = $this->lateFee;
    $currentBalance = $this->amount;
    $balanceDueDate = $this->paymentDate;
    
    if ($this->transactionType == 'ACH'){
        $rejectFeeCredit = 0;
        $rejectFeeAch = $this->rejectionFee;
                             
    }elseif ($this->transactionType == 'CC'){
        $rejectFeeCredit = $this->rejectionFee;
        $rejectFeeAch = 0;
                     }
}
$paymentDescription = $this->paymentDescription;             
$historyKey = "";
$contractKey = $this->contractKey;
$paymentAmount = $this->amount;                                            
$paymentDate = date('Y-m-d H:i:s',mktime(0,0,0,$this->cycleStartMonth, $this->cycleStartDay, $this->cycleStartYear)); //$this->paymentDate;
$transKey = $this->transID;                                          
$checkNumber = '0';
$bundled = 'N';
$month = date('m',strtotime($this->paymentDate));
$year = date('Y',strtotime($this->paymentDate));



$stmt = $dbMain ->prepare("SELECT count(*) FROM payment_history WHERE contract_key = '$this->contractKey' AND MONTH(payment_date) = '$this->cycleStartMonth' AND YEAR(payment_date) = '$this->cycleStartYear' AND payment_description = '$paymentDescription'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();  

if($count == 0){
                 
                
$sql = "INSERT INTO payment_history VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iidisssssdiiiisiiiiss',$historyKey, $contractKey, $paymentAmount, $currentBalance, $balanceDueDate, $paymentDate, $paymentFlag, $paymentDescription, $transKey, $creditPayment, $achPayment, $cashPayment, $checkPayment, $checkNumber, $bundled, $rejectFeeCheck, $rejectFeeCredit, $rejectFeeAch, $lateFeeAll,$ccRequestID, $achRequestID);
  $this->historyKey = $stmt->insert_id;                                          
$stmt->execute();
$stmt->close();

}
}
//================================================================================
function insertRejectedPayments(){
     
    $dbMain = $this->dbconnect();
   // echo "$this->transactionType<br>";
    if ($this->transactionType == 'CC'){
        $transactionType = 'CR';
    }elseif ($this->transactionType == 'ACH'){
        $transactionType = 'BA';
        }
        if($this->responseMessage == ''){
            $this->responseMessage = "No message";
        }
    $reject_bit = 0;
    
$paymentDate = date('Y-m-d H:i:s',mktime(0,0,0,$this->cycleStartMonth, $this->cycleStartDay, $this->cycleStartYear)); //$this->paymentDate;    
    
$stmt = $dbMain ->prepare("SELECT count(*) FROM rejected_payments WHERE contract_key = '$this->contractKey' AND MONTH(last_attempt_date) = '$this->cycleStartMonth' AND YEAR(last_attempt_date) = '$this->cycleStartYear' AND payment_amount = '$this->amount'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();  

if($count == 0){
    //echo "1 $this->contractKey, $this->transactionTag, $this->billingAmount, $transactionType, $this->rejectMSG,  $this->attemptNumber, $this->transactionTag, $this->paymentDate, $reject_bit";
	$sql = "INSERT INTO rejected_payments VALUES (?,?,?,?,?,?,?,?,?)";
	$stmt = $dbMain->prepare($sql);
	$stmt->bind_param('iidssissi',$this->contractKey, $this->historyKey, $this->amount, $transactionType, $this->responseMessage,  $this->attemptNumber, $this->historyKey, $paymentDate, $reject_bit);
	$stmt->execute();
	$stmt->close(); 
    
    } 
}

//=====================================================================================
function insertAccountNotes(){
	//$dbMainTwo = $this->notesConnection;
	$dbMain = $this->dbconnect();
    
	$sql = "INSERT INTO account_notes VALUES (?,?,?,?,?,?,?,?,?,?)";
	$stmt = $dbMain->prepare($sql);
	$stmt->bind_param('iisssssiss',$contractKey,$userId,$noteDate,$amPm,$noteTopic,$noteMessage,$noteCategory,$memberId,$priority,$targetApp);
	
	$contractKey = $this->contractKey;
	$userId = '55';
	$noteDate = $this->paymentDate;
	$amPm = 'PM';
	$noteTopic = 'Credit Card needs Updating';
	$noteMessage = $this->noteMessage;
	$noteCategory = 'BL';
	$memberId = $this->memberID;
	$priority = 'H';
	$targetApp = 'BL';
    
	
	if(!$stmt->execute())  {
            	printf("Error:insertAccountNotes2 %s.\n", $stmt->error);
                  }	
	$stmt->close();
    
     $sql = "INSERT INTO account_notes VALUES (?,?,?,?,?,?,?,?,?,?)";
	$stmt = $dbMain->prepare($sql);
	$stmt->bind_param('iisssssiss',$contractKey,$userId,$noteDate,$amPm,$noteTopic,$noteMessage,$noteCategory,$memberId,$priority,$targetApp);
	
	$contractKey = $this->contractKey;
	$userId = '55';
	$noteDate = $this->paymentDate;
	$amPm = 'PM';
	$noteTopic = 'Credit Card needs Updating';
	$noteMessage = $this->noteMessage;
	$noteCategory = 'BL';
	$memberId = $this->memberID;
	$priority = 'H';
	$targetApp = 'MI';
    
	
	$stmt->execute();
	$stmt->close();
	
	}
//=================================================
function loadStuff(){
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
    
    $stmt = $dbMain->prepare("SELECT member_id FROM member_info WHERE contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->memberID);   
    $stmt->fetch();
    $stmt->close();
      
    $this->monthlyBillingType = '';
    $stmt = $dbMain->prepare("SELECT monthly_billing_type, cycle_date FROM monthly_payments WHERE contract_key = '$this->contractKey'");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($this->monthlyBillingType, $this->cycleDate);
    $stmt->fetch();
    $stmt->close();
       
       /*
    $this->customerPhone = trim($this->customerPhone);
      if ($this->customerPhone == ''){
          $this->primaryPhone = '';
          $stmt = $dbMain->prepare("SELECT primary_phone, cell_phone FROM contract_info WHERE contract_key = '$this->contractKey'");
          $stmt->execute();
          $stmt->store_result();
          $stmt->bind_result($this->primaryPhone, $this->cellPhone);
          $stmt->fetch();
          $stmt->close();
          
          $this->primaryPhone == trim($this->primaryPhone);
          if ($this->primaryPhone == ''){
            $this->primaryPhone = $this->cellPhone;
          }
  }*/
  
  
 
  $stmt22 = $dbMain->prepare("SELECT contact_email, business_phone FROM business_info WHERE bus_id = '1000'");
$stmt22->execute();
$stmt22->store_result();
$stmt22->bind_result($this->contactEmail, $this->businessPhone);
$stmt22->fetch();
$stmt22->close();

$stmt22 = $dbMain->prepare("SELECT business_name FROM company_names WHERE business_name != ''");
$stmt22->execute();
$stmt22->store_result();
$stmt22->bind_result($this->businessName);
$stmt22->fetch();
$stmt22->close();

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

$stmt = $dbMain->prepare("SELECT MIN(club_id) FROM club_info  WHERE club_name != ''");//>=
$stmt->execute();  
$stmt->store_result();      
$stmt->bind_result($this->mainClubId); 
$stmt->fetch();
$stmt->close(); 

$stmt = $dbMain ->prepare("SELECT max_cycles_retry, max_retries, email_bool FROM billing_gateway_main_fields WHERE gateway_key= '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->maxCyclesRetry, $this->maxRetries, $this->emailBool);
$stmt->fetch();
$stmt->close();





}
//==============================================================================================
function moveDataTrans(){

$dbMain = $this->dbconnect();
$this->loadStuff(); 
  
$stmt = $dbMain->prepare("SELECT MIN(club_id) FROM club_info  WHERE club_name != ''");//>=
$stmt->execute();  
$stmt->store_result();      
$stmt->bind_result($clubId); 
$stmt->fetch();
$stmt->close();

$stmt = $dbMain ->prepare("SELECT gateway_id, passwordfd FROM billing_gateway_fields WHERE club_id= '$clubId'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($userName, $password);
$stmt->fetch();                                      
$stmt->close();
  
$stmt99 = $dbMain->prepare("SELECT filename FROM billing_batch_filename WHERE file_key !=''");
$stmt99->execute();      
$stmt99->store_result();      
$stmt99->bind_result($filename); 
while($stmt99->fetch()){
     $reponseFile = "../nmiBatchFiles/response-$filename";
    $fp = fopen("$reponseFile", "w+");
    $remoteFile = "response-$filename";
    $ftp_server = "batch-ftp.safewebservices.com";
    $conn_id = ftp_ssl_connect( $ftp_server, 5920);//ftp_connect($ftp_server);
        
        // login with username and password
    $login_result = ftp_login($conn_id, $userName, $password);
    ftp_chdir($conn_id, "/response");
    ftp_pasv($conn_id, true);   
      
        // upload a file
    if (ftp_fget($conn_id, $fp, $remoteFile, FTP_ASCII, 0)) { // ftp_get($conn_id, $reponseFile, $remoteFile, FTP_ASCII)) {
        // echo "successfully downloaded $ourFileName\n";
       // echo "success";  //
      } else {
       //  echo "There was a problem while downloading $remoteFile\n";
    }
    
        // close the connection
    ftp_close($conn_id);
    fclose($fp);
    
    
   
    $this->lines = file("$reponseFile");
    foreach ($this->lines as $line) {
                
                $pat = ",";
               $line = preg_replace('/"/','',$line);
                //$line = str_replace('/"/',"",$line);
                $recordDivision = explode($pat, $line);
                
                $this->transID = $recordDivision[0];
                $this->response = $recordDivision[1];
                $this->processorResponse = $recordDivision[2];
                $this->avsResponse = $recordDivision[3];
                $this->cvvResponse = $recordDivision[4];
                $this->authCode = $recordDivision[5];
                $this->amount = $recordDivision[6];
                $this->orderID = $recordDivision[8];
                $this->tax = $recordDivision[12];
                $this->type = $recordDivision[36];
                $this->responseCode  = $recordDivision[37];
                $this->processorID = $recordDivision[38];
                $this->paymentType = $recordDivision[39];
                $this->paymentID = $recordDivision[40];
                $this->paymentID = preg_replace('/"/',"",$this->paymentID);
                //$this->username = $recordDivision[60];
                //$this->customerVaultAction = $recordDivision[61];
               // $this->customerVaultID = $recordDivision[62];
                
                $dbMain = $this->dbconnect(); 
    
                $stmt = $dbMain->prepare("SELECT contract_key, payment_type, transaction_type, attempt_number, cycle_start_month, cycle_start_day, cycle_start_year FROM batch_recurring_records WHERE payment_id = '$this->paymentID'");
                $stmt->execute();      
                $stmt->store_result();      
                $stmt->bind_result($this->contractKey,$this->feeType,$this->transactionType, $this->attemptNumber, $this->cycleStartMonth, $this->cycleStartDay, $this->cycleStartYear); 
                $stmt->fetch();
                $stmt->close();
                
                //echo "PAYID $this->paymentID a $this->contractKey,b $this->feeType,c $this->transactionType, c $this->attemptNumber c $this->response c $this->processorResponse<br>";
                
                
                $this->paymentDate = date("Y-m-d H:i:s");
       
      $this->loadNextBillingDate();
      
      if($this->response == 1){
                     switch($this->feeType){
                        case 'RF':
                            $this->insertMemberGuaranteeEft();
                            $this->paymentDescription = "Rate Guarentee $this->transactionType";
                        break;
                        case 'EF':
                            $this->insertMemberEnhanceEft();
                            $this->paymentDescription = "Enhance Fee $this->transactionType";
                        break;
                        case 'MS':
                            $this->insertMonthlySettled();
                            $this->paymentDescription = "Monthly Dues $this->transactionType";
                        break;
                         case 'MF':
                            $this->insertMaintnenceFee();
                            $this->paymentDescription = "Maintnence Fee $this->transactionType";
                        break;
                        case 'PD':
                            $this->insertMonthlySettled();
                            $this->paymentDescription = "Past Monthly Dues $this->transactionType";
                        break;
                         }
                         $this->insertPaymentHistory();
                         
                          $imported = 'Y';
                          $processed = 'Y';
                          $sql = "UPDATE batch_recurring_records SET imported = ?, processed = ?, authorization_id = ?, transaction_id = ?, response = ?, processor_response = ?, avs_response = ?, cvv_response = ?  WHERE contract_key = '$this->contractKey' AND payment_id = '$this->paymentID'";
                          $stmt = $dbMain->prepare($sql);
                          $stmt->bind_param('ssssssss', $imported, $processed, $this->authCode, $this->transID, $this->responseCode, $this->processorResponse, $this->avsResponse, $this->cvvResponse);
                          $stmt->execute();
                          $stmt->close();
                          
              
              
              
              
              
      }else if($this->response >= 2){
                
                            
     
                       // echo "$this->contractKey $this->attemptNumber<br>";
                        if ($this->attemptNumber > $this->maxRetries){
                            
                            switch($this->feeType){
                                case 'RF':
                                    $this->paymentDescription = "Rate Guarentee $this->transactionType";
                                    $this->insertMemberGuaranteeEft();
                                break;
                                case 'EF':
                                    $this->paymentDescription = "Enhance Fee $this->transactionType";
                                    $this->insertMemberEnhanceEft();
                                break;
                                case 'MS':
                                    $this->paymentDescription = "Monthly Dues $this->transactionType";
                                break;
                                 case 'MF':
                                    $this->insertMaintnenceFee();
                                    $this->paymentDescription = "Maintnence Fee $this->transactionType";
                                break;
                                case 'PD':
                                    $this->paymentDescription = "Past Monthly Dues $this->transactionType";
                                break;
                             } 
                             
                             if($this->emailBool == "Yes"){
                                $stmt = $dbMain->prepare("SELECT email FROM contract_info WHERE contract_key = '$this->contractKey'");
                                $stmt->execute();      
                                $stmt->store_result();      
                                $stmt->bind_result($this->email); 
                                $stmt->fetch();
                                $stmt->close();
                                
                                $headers  = "From: $this->contactEmail\r\n";
                                $headers .= "Content-type: text/html\r\n";
                                
                                $message2 = "Your $this->paymentDescription Payment of $$this->amount has failed for $this->businessName. Please contact us for more information. $this->contactEmail or call us at $this->businessPhone";  
                
                                
                                mail($this->email, 'Failed Payment', $message2, $headers);
                             }
                             
                             
                                $this->insertPaymentHistory();
                                $this->insertRejectedPayments();
                            
                                $this->noteMessage = "The customers credit card was refused 3 times for their $this->paymentDescription on $this->paymentDate. Error code: $this->response Error Message: $this->responseMessage Please call and have the customer update there card.";
                                $this->insertAccountNotes();
                               
                                $imported = 'Y';
                                $outstandingBalance = 'Y';
                                $sql = "UPDATE batch_recurring_records SET imported = ?, outstanding_balance = ?, authorization_id = ?, transaction_id = ?, response = ?, processor_response = ?, avs_response = ?, cvv_response = ?  WHERE contract_key = '$this->contractKey' AND payment_id = '$this->paymentID'";
                                $stmt = $dbMain->prepare($sql);
                                $stmt->bind_param('ssssssss', $imported, $outstandingBalance, $this->authCode, $this->transID, $this->responseCode, $this->processorResponse, $this->avsResponse, $this->cvvResponse);
                                $stmt->execute();
                                $stmt->close(); 
                                
                              }else{
                                     $batched = 'N';
                                    $sql = "UPDATE batch_recurring_records SET record_batched = ?, authorization_id = ?, transaction_id = ?, response = ?, processor_response = ?, avs_response = ?, cvv_response = ?  WHERE contract_key = '$this->contractKey' AND payment_id = '$this->paymentID'";
                                    $stmt = $dbMain->prepare($sql);
                                    $stmt->bind_param('sssssss', $batched, $this->authCode, $this->transID, $this->responseCode, $this->processorResponse, $this->avsResponse, $this->cvvResponse);
                                    $stmt->execute();
                                    $stmt->close();
                              }
                              
                                $stmt = $dbMain ->prepare("SELECT count(*) FROM batch_recurring_records WHERE payment_type = 'MS' AND outstanding_balance = 'Y' AND contract_key = '$this->contractKey'");
                                $stmt->execute();      
                                $stmt->store_result();      
                                $stmt->bind_result($count);
                                $stmt->fetch();
                                $stmt->close();  
                                
                                if ($count >= $this->maxCyclesRetry AND $this->maxCyclesRetry != 0 AND $this->attemptNumber >= $this->maxRetries){//0 means its off
                                    $stmt = $dbMain ->prepare("SELECT SUM(billing_amount) FROM batch_recurring_records WHERE outstanding_balance = 'Y' AND contract_key = '$this->contractKey'");
                                    $stmt->execute();      
                                    $stmt->store_result();      
                                    $stmt->bind_result($amount);
                                    $stmt->fetch();
                                    $stmt->close(); 
                                    
                                    
                                    $stmt = $dbMain ->prepare("SELECT count(*) FROM billing_collections WHERE contract_key = '$this->contractKey'");
                                    $stmt->execute();      
                                    $stmt->store_result();      
                                    $stmt->bind_result($count2);
                                    $stmt->fetch();
                                    $stmt->close();  
                                    
                                    if($count2 == 0){
                                        $collectionsDate = date('Y-m-d H:i:s');
                                        $sql = "INSERT INTO billing_collections VALUES (?,?,?,?)";
                                    	$stmt = $dbMain->prepare($sql);
                                    	$stmt->bind_param('idis',$this->contractKey, $amount, $count, $collectionsDate);
                                    	$stmt->execute();
                                        $this->batchId = $stmt->insert_id;
                                    	$stmt->close();
                                        
                                        $status = "CO";
                                        $sql = "UPDATE account_status SET account_status = ? WHERE contract_key = '$this->contractKey'";
                                        $stmt = $dbMain->prepare($sql);
                                        $stmt->bind_param('s', $status);
                                        $stmt->execute();  
                                        $stmt->close(); 
                                        
                                        $this->noteMessage = "The customers account has failed to be billed for the last $this->maxCyclesRetry cycles. They have been sent to collections. Please contact.";
                                        $this->insertAccountNotes();
                                    }
                                    
                                }
                          }
     
    
                }
        
        
         $sql13 = "DELETE FROM billing_batch_filename WHERE filename = '$filename'";
         $stmt13 = $dbMain->prepare($sql13);  
         $stmt13->execute();
         $stmt13->close();
    $filename = "";
}
$stmt99->close();
    
   
    
    


    

 

}

//===========================================================================================================
}
$ajaxSwitch = $_REQUEST['ajaxSwitch'];

if($ajaxSwitch == 1){
    $update = new  processResponseFile();
    $update->moveDataTrans();

    include"batchSqlReports.php";
    $upload = new batchSqlReports();
    $upload->fileMaker();
}

echo "1";
exit;
?>