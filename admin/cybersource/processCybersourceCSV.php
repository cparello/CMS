<?php
//error_reporting(E_ALL);
require "gatewayAuth.php";
require "cybersourceSoapClient.php";

class processCybersourceCSVFile {

private $color = null;
    
function dbconnectOne()   {
require"../dbConnectOne.php";
return $dbMainOne;
}    

function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
function setSuccess($success){
    $this->success = $success;
}
//========================================================================================================================================
function rateCycleDay(){
    
$dbMain = $this->dbconnect();    
$stmt = $dbMain->prepare("SELECT $this->var1, $this->var2 FROM $this->tableName WHERE cycle_num = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($guaranteeCycleDate, $eftGuaranteeCycle);   
$stmt->fetch();   

$stmt->close();   

    //break up the guarentee cycle date
$day = date("d", strtotime($guaranteeCycleDate));
$month = date("m", strtotime($guaranteeCycleDate));
$year = date("Y");
$guaranteeCycleDateString = "$month-$day-$year";
$guaranteeCycleDateSecs = strtotime($guaranteeCycleDateString);

//fro semi annual dates
$guaranteeCycleDateSecsAnnual = $guaranteeCycleDateSecs + 15724800;

//for quarterly dates
$guaranteeCycleDateQuarter2 = date("Ymd", mktime(0, 0, 0, $month + 3, $day, $year));
$guaranteeCycleDateQuarter3 = date("Ymd", mktime(0, 0, 0, $month + 6, $day, $year));
$guaranteeCycleDateQuarter4 = date("Ymd", mktime(0, 0, 0, $month + 9, $day, $year));
$guaranteeCycleDateSecsQuarter2 = strtotime($guaranteeCycleDateQuarter2);
$guaranteeCycleDateSecsQuarter3 = strtotime($guaranteeCycleDateQuarter3);
$guaranteeCycleDateSecsQuarter4 = strtotime($guaranteeCycleDateQuarter4);



$todaysDateSecs = time();


    switch ($eftGuaranteeCycle) {
        case "A":
        $divisor = 1;
        $frequency = 'annually';
            if($todaysDateSecs <= $guaranteeCycleDateSecs) {
                $scStartDate = date("Ymd", $guaranteeCycleDateSecs);
                $guaranteeCycleDate = date("Y-m-d H:i:s", $guaranteeCycleDateSecs);
               }elseif($todaysDateSecs > $guaranteeCycleDateSecs) {
                $scStartDate = date("Ymd", mktime(0, 0, 0, $month, $day, $year + 1));
                $guaranteeCycleDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $month, $day, $year + 1));
               }

        break;
        case "B":
        $divisor = 2;
        $frequency = 'semi-annually';
            if($todaysDateSecs <= $guaranteeCycleDateSecs) {
                $scStartDate = date("Ymd", $guaranteeCycleDateSecs);
                $guaranteeCycleDate = date("Y-m-d H:i:s", $guaranteeCycleDateSecs);
                }elseif($todaysDateSecs <= $guaranteeCycleDateSecsAnnual) {
                $scStartDate = date("Ymd", $guaranteeCycleDateSecsAnnual);
                $guaranteeCycleDate = date("Y-m-d H:i:s", $guaranteeCycleDateSecsAnnual);
                }else{
                $scStartDate = date("Ymd", mktime(0, 0, 0, $month, $day, $year + 1));
                $guaranteeCycleDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $month, $day, $year + 1));
                }

        break;
        case "Q":
        $divisor = 4;
        $frequency = 'quarterly';
            if($todaysDateSecs <= $guaranteeCycleDateSecs) {
                $scStartDate = date("Ymd", $guaranteeCycleDateSecs);
                $guaranteeCycleDate = date("Y-m-d H:i:s", $guaranteeCycleDateSecs);
               }elseif($todaysDateSecs <= $guaranteeCycleDateQuarter2) {
                $scStartDate = date("Ymd", $guaranteeCycleDateQuarter2);
                $guaranteeCycleDate = date("Y-m-d H:i:s", $guaranteeCycleDateQuarter2);
               }elseif($todaysDateSecs <= $guaranteeCycleDateQuarter3) {
                $scStartDate = date("Ymd", $guaranteeCycleDateQuarter3);
                $guaranteeCycleDate = date("Y-m-d H:i:s", $guaranteeCycleDateQuarter3);
               }elseif($todaysDateSecs <= $guaranteeCycleDateQuarter4) {
                $scStartDate = date("Ymd", $guaranteeCycleDateQuarter4);
                $guaranteeCycleDate = date("Y-m-d H:i:s", $guaranteeCycleDateQuarter4);
               }else{
                $scStartDate = date("Ymd", mktime(0, 0, 0, $month, $day, $year + 1));
                $guaranteeCycleDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $month, $day, $year + 1));
               }

        break;
        
       }
       
       
   $this->RGeftCycle = $eftGuaranteeCycle;
   $this->RGnextBillingDate = $guaranteeCycleDate;  
   $this->EFeftCycle = $eftGuaranteeCycle;
   $this->EFnextBillingDate  = $guaranteeCycleDate;
}
//=============================================
function loadNextBillingDate(){
    $dbMain = $this->dbconnect();
    
    $this->nextPaymentDueDate = '';
    $stmt = $dbMain->prepare("SELECT MAX(next_payment_due_date) FROM monthly_settled WHERE contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->nextPaymentDueDate); 
    $stmt->fetch();
    $stmt->close();
    
    $this->nextPaymentDueDate = trim($this->nextPaymentDueDate);

    $this->cycleDay = date("d",strtotime($this->cycleDate));        
    
    if ($this->nextPaymentDueDate == '' OR $this->nextPaymentDueDate == 0){
       $this->monthlySettledBool = 0;
        $day = $this->cycleDay;
        $month = date("m",strtotime($this->cycleDate));
        $year = date("Y", strtotime($this->cycleDate));
        
        $monthNow = date("m");//'12';
        $dayNow = date("d");
        $yearNow = date("Y");
        
                    if ($day > $dayNow){
                        $this->nextBillingDate = date("Y-m-d H:i:s"  , mktime(0,0,0,$monthNow,$day,$yearNow));
                        $this->settledDate = date("Y-m-d H:i:s"  , mktime(23,59,59,$monthNow,$day+$this->pastDays,$yearNow));
                    }else{
                        $this->nextBillingDate = date("Ymd"  , mktime(0,0,0,$monthNow+1,$day,$yearNow));
                        $this->settledDate = date("Y-m-d H:i:s"  , mktime(23,59,59,$monthNow+1,$day+$this->pastDays,$yearNow));
                    }
        
    }elseif ($this->nextPaymentDueDate != '' OR $this->nextPaymentDueDate != 0){
        $this->monthlySettledBool = 1;
        $day = $this->cycleDay;
        $month = date("m",strtotime($this->nextPaymentDueDate));
        $year = date("Y", strtotime($this->nextPaymentDueDate));
        //$day = $day - $this->pastDays;
        
        $monthNow = date("m");//'12';
        $dayNow = date("d");
        $yearNow = date("Y");

              
                    if ($day > $dayNow){
                        $this->nextBillingDate = date("Ymd"  , mktime(0,0,0,$monthNow,$day,$yearNow));
                        $this->settledDate = date("Y-m-d H:i:s"  , mktime(23,59,59,$monthNow,$day+$this->pastDays,$yearNow));
                    }else{
                        $this->nextBillingDate = date("Ymd"  , mktime(0,0,0,$monthNow+1,$day,$yearNow));
                        $this->settledDate = date("Y-m-d H:i:s"  , mktime(23,59,59,$monthNow+1,$day+$this->pastDays,$yearNow));
                    }
    }
  
}
//================================================================================
function insertRejectedPayments(){
     
    $dbMain = $this->dbconnect();
    
    $reject_bit = 0;
    //echo "1 $this->subscriptionID, $this->paymentAmount, $this->transactionType, $this->rejectMSG,  $this->processAttempts, $this->transKey, $this->lastAttemptDate, $reject_bit";
	$sql = "INSERT INTO rejected_payments VALUES (?,?,?,?,?,?,?,?,?)";
	$stmt = $dbMain->prepare($sql);
	$stmt->bind_param('iidssissi',$this->contractKey, $this->subscriptionID, $this->paymentAmount, $this->transactionType, $this->rejectMSG,  $this->processAttempts, $this->transKey, $this->lastAttemptDate, $reject_bit);
	if(!$stmt->execute())  {
            	printf("Error:insertREJECT %s.\n", $stmt->error);
                  }	
	$stmt->close();  
}
//================================================================================
function insertfailedSettleReport(){
     
    $dbMainOne = $this->dbconnectOne();
    $dbMain = $this->dbconnect();
    
    $hours =date("G");
    $mins =date("i");
    $secs =date("s");
    $year = date("Y");//'2013';
    $month = date("m");//'12';
    $day = date("j");//'10';
    $day -= 1;
    if ($day < '10'){
        $day = "0$day";
    }


//echo "$year $month $day";
    
    $failed_date = date("Y-m-d H:i:s"  , mktime($hours,$mins,$secs,$month,$day+1,$year));
    $report_date = date("Y-m-d H:i:s"  , mktime($hours,$mins,$secs,$month,$day,$year));
    $report_flag = 0;
    $error_type = $this->errorType;
    
	$sql = "INSERT INTO failed_settle_report VALUES (?,?,?,?,?)";
	$stmt = $dbMainOne->prepare($sql);
	$stmt->bind_param('ssssi',$this->databaseName, $failed_date, $error_type, $report_date, $report_flag);
	if(!$stmt->execute())  {
            	printf("Error:insertFAILEDSETTLEREPOrt %s.\n", $stmt->error);
                  }	
	$stmt->close();  
}
//===================================================================================
function insertMemberEnhanceEft(){
    
    $dbMain = $this->dbconnect();
    
	$eft_cycle_date = $this->EFnextBillingDate;//date("Y-m-d H:i:s"  ,strtotime($this->nextBillingDate));
	$contractKey = $this->contractKey;
	$eft_cycle = $this->EFeftCycle;
	//$guarantee_fee = $this->RGnextBillingFee;
    
	
    
    $stmt = $dbMain->prepare("SELECT eft_cycle_date FROM member_enhance_eft WHERE contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($pif_cycle_date); 
    $stmt->fetch();
    $stmt->close();
    
    $pif_cycle_date = trim($pif_cycle_date);
    
    if($pif_cycle_date == '' OR $pif_cycle_date == 0){
	$sql = "INSERT INTO member_enhance_eft VALUES (?,?,?,?)";
	$stmt = $dbMain->prepare($sql);
	$stmt->bind_param('issd',$contractKey, $eft_cycle, $eft_cycle_date, $this->enhanceFee);
	if(!$stmt->execute())  {
            	printf("Error:insertEHFEE %s.\n", $stmt->error);
                  }	
	$stmt->close();
    }elseif($pif_cycle_date != '' AND $pif_cycle_date != $eft_cycle_date){
        
        $sql = "UPDATE member_enhance_eft SET enhance_fee = ?, eft_cycle_date = ?  WHERE contract_key = '$this->contractKey'";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('ds', $this->enhanceFee, $eft_cycle_date);
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
  
	$eft_cycle_date = $this->RGnextBillingDate;//date("Y-m-d H:i:s"  ,strtotime($this->nextBillingDate));
	$contractKey = $this->contractKey;
	$eft_cycle = $this->RGeftCycle;
	//$guarantee_fee = $this->RGnextBillingFee;

    $stmt = $dbMain->prepare("SELECT eft_cycle_date FROM member_guarantee_eft WHERE contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($annual_cycle_date); 
    $stmt->fetch();
    $stmt->close();
    
    $annual_cycle_date = trim($annual_cycle_date);
    
    if($annual_cycle_date == ''){
	$sql = "INSERT INTO member_guarantee_eft VALUES (?,?,?,?)";
	$stmt = $dbMain->prepare($sql);
	$stmt->bind_param('issd',$contractKey, $eft_cycle, $eft_cycle_date, $this->guaranteeFee);
	if(!$stmt->execute())  {
            	printf("Error:insertRGFEE %s.\n", $stmt->error);
                  }	
	$stmt->close();
    }elseif($annual_cycle_date != '' AND $annual_cycle_date != $eft_cycle_date){
        
        $sql = "UPDATE member_guarantee_eft SET guarantee_fee = ?, eft_cycle_date = ?  WHERE contract_key = '$this->contractKey'";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('ds', $this->guaranteeFee, $eft_cycle_date);
        if(!$stmt->execute())  {
                    	printf("Error:updateRGFEE %s.\n", $stmt->error);
                          }	
        
        $stmt->close();
    }
    

}
//===================================================================================
function insertMonthlySettled(){

    $paymentDate = $this->paymentDate;// date("Y-m-d H:i:s"  , strtotime($this->paymentDate));
	$nextBillingDate = $this->settledDate;//date("Y-m-d H:i:s"  ,strtotime($this->nextBillingDate));
    
	$contractKey = $this->contractKey;
	$transKey = $this->transKey;
	$nextBillingFee = $this->nextBillingFee;
    $transType = $this->transactionType;
    
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

 $stmt = $dbMain->prepare("SELECT COUNT(*) FROM payment_history WHERE payment_date = '$this->paymentDate' AND payment_description = '$this->paymentDescription' AND contract_key = '$this->contractKey'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($count);   
 $stmt->fetch();
 $stmt->close();
 
 if($count < 1){
                
                if ($this->transactionType == 'CR'){
                
                     $creditPayment = $this->paymentAmount;
                     $cashPayment = 0;
                     $achPayment = 0;
                     $checkPayment = 0;
                     $ccRequestID = $this->subscriptionID;
                     $achRequestID = 0;
                  }elseif ($this->transactionType == 'BA'){
                     $creditPayment = 0;
                     $achPayment = $this->paymentAmount;
                     $cashPayment = 0;
                     $checkPayment = 0;
                     $ccRequestID = 0;
                     $achRequestID = $this->subscriptionID;
                     }
                     
                
                 switch ($this->switcher){
                 case '1':
                     $currentBalance = 0;
                     $balanceDueDate = $this->paymentDate;
                     $paymentFlag = 'PF';
                     $rejectFeeCheck = 0;
                     $rejectFeeCredit = 0;
                     $rejectFeeAch = 0;
                     $lateFeeAll = 0;
                     $paymentDescription = $this->paymentDescription;
                     break;
                                    
                 case '2':
                     $currentBalance = 0;
                     $balanceDueDate = $this->paymentDate;
                     $paymentFlag = 'PF';
                     $rejectFeeCheck = 0;
                     $rejectFeeCredit = 0;
                     $rejectFeeAch = 0;
                     $lateFeeAll = 0;
                     $paymentDescription = $this->paymentDescription;
                     break;
                 case '3':
                     $currentBalance = 0;
                     $balanceDueDate = $this->paymentDate;
                     $paymentFlag = 'PF';
                     $rejectFeeCheck = 0;
                     $rejectFeeCredit = 0;
                     $rejectFeeAch = 0;
                     $lateFeeAll = 0;
                     if ($this->transactionType == 'BA'){
                         $paymentDescription = $this->paymentDescription;
                     }elseif ($this->transactionType == 'CR'){
                         $paymentDescription = $this->paymentDescription;
                     }
                     break;
                  case '4':
                     $currentBalance = $this->paymentAmount;
                     $balanceDueDate = $this->paymentDate;
                     $paymentFlag = 'RE';
                     $rejectFeeCheck = 0;
                    
                     $lateFeeAll = $late_fee;
                     if ($this->transactionType == 'BA'){
                        
                         $paymentDescription = $this->paymentDescription;
                         $rejectFeeCredit = 0;
                         $rejectFeeAch = $rejection_fee;
                         
                     }elseif ($this->transactionType == 'CR'){
                        
                         $paymentDescription = $this->paymentDescription;
                         $rejectFeeCredit = $rejection_fee;
                         $rejectFeeAch = 0;
                     }
                     break;
                     }
                                        
                 $historyKey = "";
                 $contractKey = $this->contractKey;
                 $paymentAmount = $this->paymentAmount;                                            
                 $paymentDate = $this->paymentDate;                        
                 $transKey = $this->transKey;                                          
                 $checkNumber = '0';
                 $bundled = 'N';
                 
                
                     $sql = "INSERT INTO payment_history VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                     $stmt = $dbMain->prepare($sql);
                     $stmt->bind_param('iidisssssdiiiisiiiiss',$historyKey, $contractKey, $paymentAmount, $currentBalance, $balanceDueDate, $paymentDate, $paymentFlag, $paymentDescription, $transKey, $creditPayment, $achPayment, $cashPayment, $checkPayment, $checkNumber, $bundled, $rejectFeeCheck, $rejectFeeCredit, $rejectFeeAch, $lateFeeAll,$ccRequestID, $achRequestID);
                                            
                    if(!$stmt->execute())  {
                                	printf("Error:insertPaymentHistory1 %s.\n", $stmt->error);
                                      }	
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
	$noteDate = $this->lastAttemptDate;
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
	$noteDate = $this->lastAttemptDate;
	$amPm = 'PM';
	$noteTopic = 'Credit Card needs Updating';
	$noteMessage = $this->noteMessage;
	$noteCategory = 'BL';
	$memberId = $this->memberID;
	$priority = 'H';
	$targetApp = 'MI';
    
	
	if(!$stmt->execute())  {
            	printf("Error:insertAccountNotes2 %s.\n", $stmt->error);
                  }	
	$stmt->close();
	
	}
//==============================================================================================
 function insertCardsNeedApproval(){
$dbMain = $this->dbconnect();
        
 $stmt = $dbMain->prepare("SELECT COUNT(*) FROM collections_cards_need_approval WHERE fail_date = '$this->lastAttemptDate' AND contract_key = '$this->contractKey' AND trans_title = '$this->paymentDescription'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($count);   
 $stmt->fetch();
 $stmt->close();
 
 if($count < 1){
        
        
        $text = "Declines

You have the option of settling all transactions that fail. You can call the bank and receive a verbal authorization from the bank.

You can:

    capture it by clicking on the specific transaction.
    settle it by entering the authorization code.

NOTE: If you do not have your Merchant ID# or your Amex/Discover MID# (supplied on your bank statements), please contact chargemit-help@mit.edu.

To retrieve a verbal authorization, you will need to contact the Verbal authorization line for Visa and Mastercard or Amex, Discover; and you must have the following information available.

MasterCard and Visa
800-944-1111
Bank#: 036600
Merchant ID#:
Customer's Credit Card #:

American Express
800-528-2121
American Express SE(MID)#:
Merchant ID#:
Customer's Credit Card #:

Discover
800-347-1111
Discover SE (MID)#:
Merchant ID#:
Customer's Credit Card #: ";   

        
 
        $stmt = $dbMain->prepare("SELECT card_number, card_exp_date, card_fname, card_lname, card_type  FROM credit_info WHERE contract_key = '$this->contractKey'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($card_number, $card_exp_date, $card_fname, $card_lname, $card_type); 
        $stmt->fetch();
        $stmt->close();
        
        $card_name = "$card_fname $card_lname";
        
        $sql = "INSERT INTO collections_cards_need_approval VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        
    	$stmt = $dbMain->prepare($sql);
    	$stmt->bind_param('isssdsissss',$this->contractKey,$card_number,$card_exp_date,$card_name,$this->nextBillingFee,$card_type,$this->reasonCode,$this->rejectMSG,$this->lastAttemptDate, $this->paymentDescription, $this->primaryPhone);
    	if(!$stmt->execute())  {
                	printf("Error:insertCOLLECTIONSCARDSAPPROVAL %s.\n", $stmt->error);
                      }	
    	$stmt->close();
         
        
    }
    }
 //==============================================================================================
 function insertGoodCards(){
$dbMain = $this->dbconnect(); 

$stmt = $dbMain->prepare("SELECT COUNT(*) FROM collections_good_cards WHERE fail_date = '$this->lastAttemptDate' AND contract_key = '$this->contractKey' AND trans_title = '$this->paymentDescription'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($count);   
 $stmt->fetch();
 $stmt->close();
 
 if($count < 1){  
 
        $stmt = $dbMain->prepare("SELECT card_number, card_exp_date, card_fname, card_lname, card_type  FROM credit_info WHERE contract_key = '$this->contractKey'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($card_number, $card_exp_date, $card_fname, $card_lname, $card_type); 
        $stmt->fetch();
        $stmt->close();
        
        $card_name = "$card_fname $card_lname";        
        
        $sql = "INSERT INTO collections_good_cards VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        
    	$stmt = $dbMain->prepare($sql);
    	$stmt->bind_param('isssdsissss',$this->contractKey,$card_number,$card_exp_date,$card_name,$this->nextBillingFee,$card_type,$this->reasonCode,$this->rejectMSG,$this->lastAttemptDate, $this->paymentDescription, $this->primaryPhone);
    	if(!$stmt->execute())  {
                	printf("Error:insertCOLLECTIONSGOODCARDS %s.\n", $stmt->error);
                      }	
    	$stmt->close();
        }
 }
   //==============================================================================================
 function insertBadCards(){
    
$dbMain = $this->dbconnect(); 

$stmt = $dbMain->prepare("SELECT COUNT(*) FROM collections_bad_cards WHERE fail_date = '$this->lastAttemptDate' AND contract_key = '$this->contractKey' AND trans_title = '$this->paymentDescription'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($count);   
 $stmt->fetch();
 $stmt->close();
 
 if($count < 1){  
        
 
        $stmt = $dbMain->prepare("SELECT card_number, card_exp_date, card_fname, card_lname, card_type  FROM credit_info WHERE contract_key = '$this->contractKey'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($card_number, $card_exp_date, $card_fname, $card_lname, $card_type); 
        $stmt->fetch();
        $stmt->close();
        
        $card_name = "$card_fname $card_lname";
        
        
        $sql = "INSERT INTO collections_bad_cards VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        
    	$stmt = $dbMain->prepare($sql);
    	$stmt->bind_param('isssdsissss',$this->contractKey,$card_number,$card_exp_date,$card_name,$this->nextBillingFee,$card_type,$this->reasonCode,$this->rejectMSG,$this->lastAttemptDate, $this->paymentDescription, $this->primaryPhone);
    	if(!$stmt->execute())  {
                	printf("Error:insertCOLLECTIONSBADCARDS %s.\n", $stmt->error);
                      }	
    	$stmt->close();
         }  
 }   
//==============================================================================================
function insertAcceptedCards(){
    
$dbMain = $this->dbconnect(); 

$stmt = $dbMain->prepare("SELECT COUNT(*) FROM collections_accepted_cards WHERE fail_date = '$this->lastAttemptDate' AND contract_key = '$this->contractKey' AND trans_title = '$this->paymentDescription'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($count);   
 $stmt->fetch();
 $stmt->close();
 
 if($count < 1){  

        if ($this->transactionType = 'CR'){
             $stmt = $dbMain->prepare("SELECT card_number, card_exp_date, card_fname, card_lname, card_type  FROM credit_info WHERE contract_key = '$this->contractKey'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($card_number, $card_exp_date, $card_fname, $card_lname, $card_type); 
            $stmt->fetch();
            $stmt->close();
            
            $card_name = "$card_fname $card_lname";
        }else{
            $stmt = $dbMain->prepare("SELECT account_number, account_fname, account_lname, account_type  FROM banking_info WHERE contract_key = '$this->contractKey'");
            $stmt->execute();      
            $stmt->store_result();     
            $stmt->bind_result($card_number, $card_fname, $card_lname, $card_type); 
            $stmt->fetch();
            $stmt->close();
            
            $card_exp_date = 'NA';
            $card_name = "$card_fname $card_lname"; 
        }
        
        
        
        
        $sql = "INSERT INTO collections_accepted_cards VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        
    	$stmt = $dbMain->prepare($sql);
    	$stmt->bind_param('isssdsissss',$this->contractKey,$card_number,$card_exp_date,$card_name,$this->nextBillingFee,$card_type,$this->reasonCode,$this->rejectMSG,$this->lastAttemptDate, $this->paymentDescription, $this->primaryPhone);
    	if(!$stmt->execute())  {
                	printf("Error:insertCOLLECTIONSacceptedCARDS %s.\n", $stmt->error);
                      }	
    	$stmt->close();
         } 
 }          
//===============================================================================================  
function insertRetryTransCount(){
    $dbMain = $this->dbconnect();
   
    
   
   $startMonth = date('m',strtotime($this->nextBillingDate))-1;
   $startYear = date('Y',strtotime($this->nextBillingDate));
  
                
    $today = date('Y-m-d');
    $process_attemptsRG = 0;
    $process_attemptsEF = 0;
    $process_attempts = 0;
    
    //echo "start month $startMonth start year $startYear payment descrip $this->paymentDescription today $today ckey$this->contractKey last $this->lastAttemptDate  ";
   
    //===================================================================Guarentee   
    if (preg_match('/Guarantee/i',$this->paymentDescription)){
        $stmt = $dbMain->prepare("SELECT contract_key, process_attempts FROM cs_failed_trans_count WHERE contract_key = '$this->contractKey' AND start_cycle_month = '$startMonth'  AND start_cycle_year = '$startYear' AND last_trans_date < '$today' AND trans_title LIKE '%$this->paymentDescription%'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($contract_key, $process_attemptsRG); 
        $stmt->fetch();
        $stmt->close();
        
        //echo "<br>ckey 2 $contract_key<br>";
        
        $contract_key = trim($contract_key);
        
        if ($contract_key == '' OR $contract_key == '0'){
                
                $sql = "INSERT INTO cs_failed_trans_count VALUES (?,?,?,?,?,?,?)";
                $RGnewProcAttempts = 1;
            	$stmt = $dbMain->prepare($sql);
            	$stmt->bind_param('iisisss',$key,$this->contractKey,$this->paymentDescription,$RGnewProcAttempts,$startMonth,$startYear,$this->lastAttemptDate);
            	if(!$stmt->execute())  {
                        	printf("Error:insertTransRG1 %s.\n", $stmt->error);
                              }	
            	$stmt->close();
                
             }else{
                    $process_attemptsRG++;
            
                    $sql = "UPDATE cs_failed_trans_count  SET process_attempts = ?, last_trans_date = ?  WHERE contract_key = '$this->contractKey' AND start_cycle_month = '$startMonth'  AND start_cycle_year = '$startYear' AND trans_title LIKE '%$this->paymentDescription%' AND last_trans_date < '$today'";
                    $stmt = $dbMain->prepare($sql);
                    $stmt->bind_param('is', $process_attemptsRG, $this->lastAttemptDate);
                    if (!$stmt->execute()) {
                                printf("Error: %s.UPDATE RG tranns proc count2 \n", $stmt->error);
                            }
            
                    $stmt->close();
            
             }
            
        
        
   //===================================================================Enhance              
        }elseif (preg_match('/Enhance/i',$this->paymentDescription)){
        $stmt = $dbMain->prepare("SELECT contract_key, process_attempts FROM cs_failed_trans_count WHERE contract_key = '$this->contractKey' AND start_cycle_month = '$startMonth'  AND start_cycle_year = '$startYear' AND last_trans_date < '$today' AND trans_title LIKE '%$this->paymentDescription%'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($contract_key, $process_attemptsEF); 
        $stmt->fetch();
        $stmt->close();
        
        $contract_key = trim($contract_key);
        
        if ($contract_key == '' OR $contract_key == '0'){
            
                
                $sql = "INSERT INTO cs_failed_trans_count VALUES (?,?,?,?,?,?,?)";
                $EFnewProcAttempts = 1;
            	$stmt = $dbMain->prepare($sql);
            	$stmt->bind_param('iisisss',$key,$this->contractKey,$this->paymentDescription,$EFnewProcAttempts,$startMonth,$startYear,$this->lastAttemptDate);
            	if(!$stmt->execute())  {
                        	printf("Error:insertTransEF1 %s.\n", $stmt->error);
                              }	
            	$stmt->close();
            }else{
                $process_attemptsEF++;
            
                $sql = "UPDATE cs_failed_trans_count  SET process_attempts = ?, last_trans_date = ?   WHERE contract_key = '$this->contractKey' AND start_cycle_month = '$startMonth'  AND start_cycle_year = '$startYear' AND trans_title LIKE '%$this->paymentDescription%' AND last_trans_date < '$today'";
                $stmt = $dbMain->prepare($sql);
                $stmt->bind_param('is', $process_attemptsEF, $this->lastAttemptDate);
                if (!$stmt->execute()) {
                            printf("Error: %s.UPDATE tarns proc count2 EF \n", $stmt->error);
                        }
        
                $stmt->close();
            }
            
            
            
            
                
        }else{
            $stmt = $dbMain->prepare("SELECT contract_key, process_attempts FROM cs_failed_trans_count WHERE contract_key = '$this->contractKey' AND start_cycle_month = '$startMonth'  AND start_cycle_year = '$startYear' AND last_trans_date < '$today' AND trans_title LIKE '%$this->paymentDescription%'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($contract_key, $process_attempts); 
            $stmt->fetch();
            $stmt->close();
            
            $contract_key = trim($contract_key);
            
            if ($contract_key == '' OR $contract_key == '0'){
                 
                $sql = "INSERT INTO cs_failed_trans_count VALUES (?,?,?,?,?,?,?)";
                $MnewProcAttempts = 1;
            	$stmt = $dbMain->prepare($sql);
            	$stmt->bind_param('iisisss',$key,$this->contractKey,$this->paymentDescription,$MnewProcAttempts,$startMonth,$startYear, $this->lastAttemptDate);
            	if(!$stmt->execute())  {
                        	printf("Error:insertTransEF1 %s.\n", $stmt->error);
                              }	
            	$stmt->close();
                
                } else{
                   $process_attempts++; 
                   
                    $sql = "UPDATE cs_failed_trans_count  SET process_attempts = ?, last_trans_date = ?   WHERE contract_key = '$this->contractKey' AND start_cycle_month = '$startMonth'  AND start_cycle_year = '$startYear' AND trans_title LIKE '%$this->paymentDescription%' AND last_trans_date < '$today'";
                    $stmt = $dbMain->prepare($sql);
                    $stmt->bind_param('is', $process_attempts, $this->lastAttemptDate);
                    if (!$stmt->execute()) {
                                printf("Error: %s.UPDATE tarns proc count2 Monthly \n", $stmt->error);
                            }
            
                    $stmt->close();
            
            }                 
        } 
    //echo "<br>contract_key = '$this->contractKey' start_cycle_month = '$startMonth'  start_cycle_year = '$startYear' trans_title LIKE '%$this->paymentDescription% last_trans_date < '$today'<br>"  ;  
    $this->processAttempts = $process_attemptsRG + $process_attemptsEF + $process_attempts;              
}
//==================================================================================================
function loadStuff(){
    
$dbMain = $this->dbconnect(); 
  
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
  }
  
  
  if ($this->monthlyBillingType == 'CR'){
            $this->transactionType = 'CR';
  }elseif ($this->monthlyBillingType == 'BA'){
            $this->transactionType = 'BA';
  }
  
    
}
//==============================================================================================
function moveData(){
//echo "fubar";
$counter = 0;
$settledCount = 0;
$failedCount = 0; 
$RGCounter = 0;
$EFCounter = 0;
$ignoredRecords = 0;
$settledTotal = 0;
$rgTotal = 0;
$efTotal = 0;
$RateFailedCount = 0;
$RateFaileTotal = 0;
$EnhanceFailedCount = 0;
$EnahnceFailedTotal = 0;
$MonthlyFailedCount = 0;
$MonthlyFailedTotal = 0;

$BIGTotal = 0;



$dbMain = $this->dbconnect(); 

$stmt = $dbMain->prepare("SELECT COUNT(*) as COUNT FROM temp_cs_insert WHERE row_descriptor LIKE '%Request%'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($errorCheck1); 
$stmt->fetch();
$stmt->close();

$stmt = $dbMain->prepare("SELECT COUNT(*) as COUNT FROM temp_cs_insert_sub WHERE merchant_id != ''");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($errorCheck2); 
$stmt->fetch();
$stmt->close();

$stmt = $dbMain->prepare("SELECT DATABASE() AS database_name");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->databaseName); 
$stmt->fetch();
$stmt->close();

if ($errorCheck1 == 0 OR $errorCheck2 == 0){
    $this->errorType = 'SE';
    $this->insertfailedSettleReport();
    $this->success = 0;
      
    $message = "The Subscription Detail Report or Transaction Detail Report has failed for Database $this->databaseName.";
    $message = wordwrap($message, 70, "\r\n"); 
    mail('christopherparello@gmail.com', 'Report Failure', $message);
    //exit;
    goto end;
}




$stmt = $dbMain-> prepare("SELECT enhance_fee, rate_fee, late_fee, rejection_fee FROM fees WHERE fee_num = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->enhanceFee, $this->guaranteeFee, $this->lateFee, $this->rejectionFee);
$stmt->fetch();
$stmt->close();

$stmt = $dbMain->prepare("SELECT past_day FROM billing_cycle WHERE cycle_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->pastDays); 
$stmt->fetch();
$stmt->close();


$stmt999 = $dbMain->prepare("SELECT * FROM temp_cs_insert_sub WHERE transaction_date != ''");
             if(!$stmt999->execute())  {
            	printf("Error:main loader %s.\n", $stmt999->error);
                  }	                                      // OR   first_name = '$this->firstName' AND last_name = '$this->lastName'
$stmt999->store_result();
$stmt999->bind_result($merchant_id,	$transaction_date, $ics_applications,	$payment_request_id,	$recurring_payment_event_amount,	$recurring_payment_amount,	$currency_code,	$subscription_id,	$this->contractKey ,	$customer_account_id,	$subscription_type,	$this->paymentDescription,	$last_subscription_status,	$subscription_status,	$subscription_payment_method,	$recurring_start_date,	$next_scheduled_date,	$event_retry_count,	$recurring_number_of_payments,	$payments_success,	$payment_success_amount,	$installment_sequence,	$installment_total_count,	$recurring_frequency,	$recurring_approval_required, $recurring_payment_event_approved_by,	$recurring_automatic_renew,	$comments,	$setup_fee,	$setup_fee_currency,	$tax_amount,	$customer_firstname,	$customer_lastname,	$bill_address1,	$bill_address2,	$bill_city,	$bill_state,	$bill_zip,	$bill_country,	$ship_to_address1,	$ship_to_address2,	$ship_to_city,	$ship_to_state,	$ship_to_company_name,	$ship_to_country,	$ship_to_firstname,	$ship_to_lastname,	$ship_to_zip,	$company_name,	$customer_email,	$this->customerPhone,	$customer_ipaddress,	$card_type,	$customer_cc_expmo,	$customer_cc_expyr,	$customer_cc_startmo,	$customer_cc_startyr,	$customer_cc_issue_number,	$account_suffix,	$ecp_account_type,	$ecp_rdfi,	$this->reasonCode,	$auth_rcode,	$auth_code,	$auth_type,	$auth_auth_avs,	$auth_auth_response,	$auth_cavv_response,	$ics_rcode,	$ics_rflag,	$this->rejectMSG,	$request_token,	$payment_processor,	$e_commerce_indicator,	$transaction_ref_number,	$merchant_defined_data1,	$merchant_defined_data2,	$merchant_defined_data3,	$merchant_defined_data4,	$merchant_secure_data1,	$merchant_secure_data2,	$merchant_secure_data3,	$merchant_secure_data4);
while($stmt999->fetch()){
$this->switcher = 0;  

 $this->loadStuff();
  $this->paymentDate = date("Y-m-d H:i:s"  , strtotime($transaction_date));
  
  $this->loadNextBillingDate();
  $this->transKey = $payment_request_id;
  $this->lastAttemptDate = $transaction_date;
  $date = date('Y-m-d',strtotime($transaction_date));
  
  
  if (preg_match('/Guarantee/i',$this->paymentDescription) OR preg_match('/Enhance/i',$this->paymentDescription)){
    $this->nextBillingFee = $recurring_payment_amount;
    $this->paymentAmount = $recurring_payment_amount;
      }else{
        $amount = "";
          $stmt = $dbMain->prepare("SELECT amount FROM temp_cs_insert WHERE request_id = '$payment_request_id'");
          $stmt->execute();
          $stmt->store_result();
          $stmt->bind_result($amount);
          $stmt->fetch();
          $stmt->close();
    
          $this->nextBillingFee = $amount;
          $this->paymentAmount = $amount;
      }
  
    $BIGTotal += $this->paymentAmount;
 //echo "<br><br>counter:  $counter  %% rescode$this->reasonCode  mercrefnum  $this->contractKey  sub title $this->paymentDescription  payDATE $this->paymentDate  AMOUNT $this->paymentAmount subscription status $subscription_status<br>";
    
  $this->lastAttemptDate = $transaction_date;
  //$this->paymentAmount = $payment_success_amount;
  $this->subscriptionID = $subscription_id;
  $this->paymentDescription = $this->paymentDescription;
  $this->recuringStart = $recurring_start_date;
  $this->recurringEnd = $next_scheduled_date;
  
 
  

  //echo "<br>counter $counter ckey $this->contractKey reson code$this->reasonCode";
  
      if ($this->reasonCode == 100){
       $bigTotApp += $this->paymentAmount;
        $this->insertAcceptedCards();
        if (preg_match('/Guarantee/i',$this->paymentDescription)){
           //echo "Guarantee<br>";
                $this->switcher = 1;
                $this->insertPaymentHistory();
                $this->var1 = 'annual_cycle_date';
                $this->var2 = 'eft_cycle';
                $this->tableName = 'guarantee_fee_cycles';   
                $this->rateCycleDay();
                $this->insertMemberGuaranteeEft();
                $RGCounter++;
                $rgTotal += $this->paymentAmount;
            }elseif (preg_match('/Enhance/i',$this->paymentDescription)){
               //echo "Enhance<br>";
                $this->switcher = 2;
                $this->insertPaymentHistory();
                $this->var1 = 'pif_cycle_date';
                $this->var2 = 'eft_cycle';
                $this->tableName = 'enhance_fee_cycles';     
                $this->rateCycleDay();
                $this->insertMemberEnhanceEft();
                $EFCounter++;
                $efTotal += $this->paymentAmount;
            }elseif (preg_match('/Monthly/i',$this->paymentDescription) OR preg_match('/EFT Credit/i',$this->paymentDescription) OR preg_match('/EFT Bank/i',$this->paymentDescription)){ 
               //echo "Monthly<br>";
                $this->switcher = 3;
                $this->insertPaymentHistory();
                $this->insertMonthlySettled();
                $settledCount++;
                $settledTotal += $this->paymentAmount;
                  }
             
    }else{
     //echo "readon code fail $this->reasonCode<br>";
        $this->insertRetryTransCount();
        
        if (preg_match('/Guarantee/i',$this->paymentDescription)){
            $RateFailedCount++;
            $RateFaileTotal += $this->paymentAmount;
            }elseif (preg_match('/Enhance/i',$this->paymentDescription)){
                $EnhanceFailedCount++;
                 $EnahnceFailedTotal += $this->paymentAmount;
            }elseif (preg_match('/Monthly/i',$this->paymentDescription) OR preg_match('/EFT Credit/i',$this->paymentDescription) OR preg_match('/EFT Bank/i',$this->paymentDescription)){ 
                $MonthlyFailedCount++;
                $MonthlyFailedTotal +=  $this->paymentAmount;
                  }
                
             
         $failedCount++;
         
         switch($this->reasonCode){
            case 201://need approval
                   //echo "201 readon code fail $this->reasonCode<br>";
                        $this->insertCardsNeedApproval();
                        $this->switcher = 4;
                        if ($subscription_status != 'CURRENT'){
                            //echo "test";
                            $this->insertPaymentHistory();
                            $this->insertRejectedPayments();
                            $this->noteMessage = "The customers credit card was refused for their $this->paymentDescription on $this->lastAttemptDate. Error code: $this->reasonCode Error Message: $ics_rmsg Please call and have the customer update there card";
                            $this->insertAccountNotes();
                          }
            break;
            case 204://gen dec
           //echo "204 readon code fail $this->reasonCode<br>";
                    $this->switcher = 4;
                    $this->insertGoodCards();
            break;
            case 203://nsf
           //echo "203 readon code fail $this->reasonCode<br>";
                    $this->switcher = 4;
                    $this->insertGoodCards();
            break;
            case 202://exp
           //echo "202 readon code fail $this->reasonCode<br>";
                   $this->insertBadCards();
                   $this->switcher = 4;
                  if ($subscription_status != 'CURRENT'){
                    //echo "test";
                   $this->insertPaymentHistory();
                   $this->insertRejectedPayments();
                   $this->noteMessage = "The customers credit card was refused for their $this->paymentDescription on $this->lastAttemptDate. Error code: $this->reasonCode Error Message: $ics_rmsg Please call and have the customer update there card";
                        $this->insertAccountNotes();
                   }
            break;
            case 205://lost 
           //echo "205 readon code fail $this->reasonCode<br>";  
                   $this->insertBadCards();
                   $this->switcher = 4;
                  if ($subscription_status != 'CURRENT'){
                    //echo "test";
                   $this->insertPaymentHistory();
                   $this->insertRejectedPayments();
                   $this->noteMessage = "The customers credit card was refused for their $this->paymentDescription on $this->lastAttemptDate. Error code: $this->reasonCode Error Message: $ics_rmsg Please call and have the customer update there card";
                        $this->insertAccountNotes();
                   }
            break;
            case 231://invalid
           //echo "231 readon code fail $this->reasonCode<br>";
                   $this->insertBadCards();
                   $this->switcher = 4;
                  if ($subscription_status != 'CURRENT'){
                    //echo "test";
                   $this->insertPaymentHistory();
                   $this->insertRejectedPayments();
                   $this->noteMessage = "The customers credit card was refused for their $this->paymentDescription on $this->lastAttemptDate. Error code: $this->reasonCode Error Message: $ics_rmsg Please call and have the customer update there card";
                        $this->insertAccountNotes();
                   }
            break;
         }
        
         
        
        if ($this->processAttempts >= 3 AND $subscription_status != 'CURRENT'){
           //echo "process attempts <br>";
            //echo "<br> PROCEESC ATTEMPTS TESRTER";
            $this->switcher = 4;
            $this->insertPaymentHistory();
            $this->insertRejectedPayments();
            $this->noteMessage = "The customers credit card was refused 3 times for their $this->paymentDescription on $this->lastAttemptDate. Error code: $this->reasonCode Error Message: $ics_rmsg Please call and have the customer update there card.";
                $this->insertAccountNotes();
              }
             }
             
             
             if ($this->switcher == 0){
                 $ignoredRecords += 1;
                 $sql = "INSERT INTO cs_settled_ignored_transaction VALUES (?,?,?)";
                 $stmt = $dbMain->prepare($sql);
                 $stmt->bind_param('isd',$this->contractKey, $this->paymentDescription, $this->paymentAmount);                       
                 if(!$stmt->execute())  {
                            	printf("Error:insertcs_settled_ignored_transaction %s.\n", $stmt->error);
                                  }	
                $stmt->close();
                 }
    
            
  
  $counter++; 
  
$merchant_id = '';
$transaction_date = '';
$ics_applications = '';
$payment_request_id = '';
$recurring_payment_event_amount = '';
$recurring_payment_amount = '';
$currency_code = '';
$subscription_id = '';
$this->contractKey  = '';
$customer_account_id = '';
$subscription_type = '';
$this->paymentDescription = '';
$last_subscription_status = '';
$subscription_status = '';
$subscription_payment_method = '';
$recurring_start_date = '';	
$next_scheduled_date = '';
$event_retry_count = '';
$recurring_number_of_payments = '';
$payments_success = '';
$payment_success_amount = '';
$installment_sequence = '';
$installment_total_count = '';
$recurring_frequency = '';
$recurring_approval_required = ''; 
$recurring_payment_event_approved_by = '';
$recurring_automatic_renew = '';
$comments = '';	
$setup_fee = '';
$setup_fee_currency = '';
$tax_amount = '';
$customer_firstname = '';
$customer_lastname = '';
$bill_address1 = '';	
$bill_address2 = '';	
$bill_city = '';
$bill_state = '';
$bill_zip = '';
$bill_country = '';
$ship_to_address1 = '';	
$ship_to_address2 = '';	
$ship_to_city = '';
$ship_to_state = '';
$ship_to_company_name = '';
$ship_to_country = '';
$ship_to_firstname = '';
$ship_to_lastname = '';
$ship_to_zip = '';
$company_name = '';
$customer_email = '';
$this->customerPhone = '';
$customer_ipaddress = '';
$card_type = '';	
$customer_cc_expmo = '';
$customer_cc_expyr = '';	
$customer_cc_startmo = '';
$customer_cc_startyr = '';
$customer_cc_issue_number = '';
$account_suffix = '';
$ecp_account_type = '';
$ecp_rdfi = '';
$this->reasonCode = '';
$auth_rcode = '';
$auth_code = '';
$auth_type = '';
$auth_auth_avs = '';
$auth_auth_response = '';
$auth_cavv_response = '';
$ics_rcode = '';	
$ics_rflag = '';	
$ics_rmsg = '';	
$request_token = '';
$payment_processor = '';
$e_commerce_indicator = '';
$transaction_ref_number = '';
$merchant_defined_data1 = '';
$merchant_defined_data2 = '';	
$merchant_defined_data3 = '';
$merchant_defined_data4 = '';
$merchant_secure_data1 = '';
$merchant_secure_data2 = '';
$merchant_secure_data3 = '';
$merchant_secure_data4 = '';
  
  
  
  
  
 //echo "SWIRCHER     $this->switcher";  
 }   
$stmt999->close();  

$todaysDate =  date("Y-m-d H:i:s");
$sql13 = "DELETE FROM pre_payments WHERE restart_date <= '$todaysDate'";
$stmt13 = $dbMain->prepare($sql13);  
$stmt13->execute();
$stmt13->close();
        
$sql13 = "DELETE FROM service_credits WHERE credit_end <= '$todaysDate'";
$stmt13 = $dbMain->prepare($sql13);  
$stmt13->execute();
$stmt13->close();

//echo "<br>tot  $BIGTotal app $bigTotApp<br>";

$this->success = 1;


 $sql = "INSERT INTO cs_reporting_results VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
 $stmt = $dbMain->prepare($sql);
 $stmt->bind_param('siiiiiidddididid',$date,$counter, $settledCount, $failedCount, $RGCounter, $EFCounter, $ignoredRecords, $settledTotal, $rgTotal, $efTotal,$RateFailedCount, $RateFaileTotal, $EnhanceFailedCount, $EnahnceFailedTotal, $MonthlyFailedCount, $MonthlyFailedTotal);
 if(!$stmt->execute())  {
            	printf("Error:insertREPORTINGRESULTS %s.\n", $stmt->error);
                  }	
$stmt->close();
  
 $message = "<!DOCTYPE html PUBLIC \"\-//W3C//DTD XHTML 1.0 Transitional//EN\"\ \"\http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"\>
<html xmlns=\"\http://www.w3.org/1999/xhtml\"\>
 <head>
  <meta http-equiv=\"\\Content-Type\"\ content=\"\text/html; charset=UTF-8\"\ />";
//echo "Contract_key  <>    Credit_card   <>  Exp   <>    Name   <>    Amount   <>  Card_type    <>   Reason_code  <>   Reason_descrip   <>   Fail_date   <>     Trans_title<br>";
$message .= "<p class=\"bbackheader\"><Center><H1><strong>Club Manager Pro</strong></Center></H1></p>";
$message .= "<p class=\"bbackheader\"><Center><H1><strong>Yesterdays Batch Report</strong></Center></H1></p><br><br>";
$message .=" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Date</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Records Processed</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly EFT Records Processed</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Value</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Rate Guarentee Fee Records Processed</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Value</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Enhance Fee Records Processed</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Value</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Number of Failed Transactions</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">RG Failed Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Value</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">EF Failed Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Value</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Failed Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Value</font></th>
  </tr>\n"; 
 
 $message .=    "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$date</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$counter</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$settledCount</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$settledTotal</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$RGCounter</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$rgTotal</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$EFCounter</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$efTotal</b></font>
</td>
<td align=\"right\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$failedCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$RateFailedCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$RateFaileTotal</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$EnhanceFailedCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$EnahnceFailedTotal</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$MonthlyFailedCount</b></font>
</td>
<td align=\"right\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$MonthlyFailedTotal</b></font>
</td>
</tr>\n";
 
 //$message = "Date: $transaction_date Records Processed: $counter \r\n Monthly EFT Records Processed: $settledCount Value: $$settledTotal \r\n Rate Guarentee Fee Records Processed: $RGCounter Value: $$rgTotal \r\n Enhance Fee Records Processed: $EFCounter  Value: $$efTotal \r\n  Number of Failed Transactions: $failedCount";
 $idArray = explode('_',$this->databaseName);
 
 $stmt22 = $dbMain->prepare("SELECT contact_email FROM business_info WHERE bus_id = '$idArray[1]'");
 $stmt22->execute();
 $stmt22->store_result();
 $stmt22->bind_result($contact_email);
 $stmt22->fetch();
 $stmt22->close();
            
            
 $headers  = "From: ClubManagerPro@cmp.com\r\n";
 $headers .= "Content-type: text/html\r\n";   
mail('$contact_email', 'CMP - Yesterdays Batch Report', $message, $headers);
 
 

mail('christopherparello@gmail.com', 'Yesterdays Batch Report', $message, $headers);
mail('greg@burbankathleticclub.com', 'Yesterdays Batch Report', $message, $headers);
mail('sandi@burbankathleticclub.com', 'Yesterdays Batch Report', $message, $headers);
                        

//echo "<br>counter $counter monthly $settledCount failedCount  $failedCount  RG $RGCounter  EF $EFCounter ignored $ignoredRecords<br>";

end:
}
//============================================
function getSuccess(){
    return($this->success);
}
//===========================================================================================================
}
//
//$update = new processCybersourceCSVFile();
//$update->moveData();


?>