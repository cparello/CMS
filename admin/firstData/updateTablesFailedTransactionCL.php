<?php
//error_reporting(E_ALL);
class updateTablesFailedTransaction {

private $color = null;

function dbconnect()   {
require"/var/www/vhosts/ems/cmp.burbankathleticclub.com/admin/dbConnect.php";
return $dbMain;
}


//===================================================================================
function insertMemberEnhanceEft(){
    
    $dbMain = $this->dbconnect();
	
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
	$stmt->bind_param('issd',$this->contractKey, $this->enhanceCycle, $this->enhanceCycleDate, $this->enhanceFee);
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
  
	//$contractKey = $this->contractKey;
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
	$stmt->bind_param('issd',$this->contractKey, $this->guarenteeCycle, $this->guarenteeCycleDate, $this->guaranteeFee);
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
    
$stmt = $dbMain ->prepare("SELECT count(*) FROM rejected_payments WHERE contract_key = '$this->contractKey' AND MONTH(last_attempt_date) = '$this->cycleStartMonth' AND YEAR(last_attempt_date) = '$this->cycleStartYear' AND payment_amount = '$this->billingAmount'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();  

if($count == 0){
    //echo "1 $this->contractKey, $this->transactionTag, $this->billingAmount, $transactionType, $this->rejectMSG,  $this->attemptNumber, $this->transactionTag, $this->paymentDate, $reject_bit";
	$sql = "INSERT INTO rejected_payments VALUES (?,?,?,?,?,?,?,?,?)";
	$stmt = $dbMain->prepare($sql);
	$stmt->bind_param('iidssissi',$this->contractKey, $this->historyKey, $this->billingAmount, $transactionType, $this->responseMessage,  $this->attemptNumber, $this->historyKey, $paymentDate, $reject_bit);
	if(!$stmt->execute())  {
            	printf("Error:insertREJECT %s.\n", $stmt->error);
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
    $ccRequestID = $this->transactionTag;
    $achRequestID = 0;
    }elseif ($this->transactionType == 'ACH'){
        $creditPayment = 0;
        $achPayment = $this->billingAmount;
        $cashPayment = 0;
        $checkPayment = 0;
        $ccRequestID = 0;
        $achRequestID = $this->transactionTag;
        }
                     
       
$currentBalance = $this->billingAmount;
$balanceDueDate = $this->paymentDate;
$paymentFlag = 'RE';
$rejectFeeCheck = 0;
$lateFeeAll = $this->lateFee;

if ($this->transactionType == 'ACH'){
    $paymentDescription = $this->paymentDescription;
    $rejectFeeCredit = 0;
    $rejectFeeAch = $this->rejectionFee;
                         
    }elseif ($this->transactionType == 'CC'){
        $paymentDescription = $this->paymentDescription;
        $rejectFeeCredit = $this->rejectionFee;
        $rejectFeeAch = 0;
                     }
             
$historyKey = "";
$contractKey = $this->contractKey;
$paymentAmount = $this->billingAmount;                                            
$paymentDate = date('Y-m-d H:i:s',mktime(0,0,0,$this->cycleStartMonth, $this->cycleStartDay, $this->cycleStartYear)); //$this->paymentDate;
$transKey = $this->transactionTag;                                          
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
if(!$stmt->execute())  {
    printf("Error:insertPaymentHistory1 %s.\n", $stmt->error);
              } 
$this->historyKey = $stmt->insert_id;                       	
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
    
	
	if(!$stmt->execute())  {
            	printf("Error:insertAccountNotes2 %s.\n", $stmt->error);
                  }	
	$stmt->close();
	
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
   
/*$this->customerPhone = trim($this->customerPhone);
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
  
  
 
  
    
}
//==============================================================================================
function moveData(){

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

$stmt22 = $dbMain->prepare("SELECT contact_email, business_phone FROM business_info WHERE bus_id = '1000'");
$stmt22->execute();
$stmt22->store_result();
$stmt22->bind_result($contact_email, $business_phone);
$stmt22->fetch();
$stmt22->close();

$stmt22 = $dbMain->prepare("SELECT business_name FROM company_names WHERE business_name != ''");
$stmt22->execute();
$stmt22->store_result();
$stmt22->bind_result($business_name);
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
$stmt->bind_result($mainClubId); 
$stmt->fetch();
$stmt->close(); 

$stmt = $dbMain ->prepare("SELECT max_cycles_retry, max_retries, email_bool FROM billing_gateway_main_fields WHERE gateway_key= '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($max_cycles_retry, $max_retries, $email_bool);
$stmt->fetch();
$stmt->close();

$stmt = $dbMain-> prepare("SELECT enhance_fee, rate_fee, late_fee, rejection_fee, maintnence_fee FROM fees WHERE fee_num = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->enhanceFee, $this->guaranteeFee, $this->lateFee, $this->rejectionFee, $this->maintnenceFee);
$stmt->fetch();
$stmt->close();

$stmt = $dbMain->prepare("SELECT past_day FROM billing_cycle WHERE cycle_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->pastDays); 
$stmt->fetch();
$stmt->close();


$stmt999 = $dbMain->prepare("SELECT payment_id, contract_key, payment_type, transaction_type, authorization_id, attempt_number, billing_amount, response_message, response, transaction_tag, cycle_start_month, cycle_start_day, cycle_start_year FROM billing_scheduled_recuring_payments WHERE imported = 'N'  AND outstanding_balance = 'Y' AND processed = 'N'");
             if(!$stmt999->execute())  {
            	printf("Error:main loader %s.\n", $stmt999->error);
                  }	                                      // OR   first_name = '$this->firstName' AND last_name = '$this->lastName'
$stmt999->store_result();
$stmt999->bind_result($payment_id, $this->contractKey, $this->paymentType, $this->transactionType, $this->authorizationId, $this->attemptNumber, $this->billingAmount, $this->responseMessage, $this->response, $this->transactionTag, $this->cycleStartMonth, $this->cycleStartDay, $this->cycleStartYear);
while($stmt999->fetch()){
//$this->cycleEndDay = $this->cycleStartDay + $this->pastDays;

  $this->loadStuff();
  $this->paymentDate = date("Y-m-d H:i:s");
 //echo "fubar";
 
$failedCount++;

    
 
       // echo "$this->contractKey $this->attemptNumber<br>";
        if ($this->attemptNumber >= $max_retries){
            
            switch($this->paymentType){
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
             
             if($email_bool == "Yes"){
                $stmt = $dbMain->prepare("SELECT email FROM contract_info WHERE contract_key = '$this->contractKey'");
                $stmt->execute();      
                $stmt->store_result();      
                $stmt->bind_result($this->email); 
                $stmt->fetch();
                $stmt->close();
                
                $headers  = "From: $contact_email\r\n";
                $headers .= "Content-type: text/html\r\n";
                
                $message2 = "Your $this->paymentDescription Payment of $$this->billingAmount has failed for $business_name. Please contact us for more information. $contact_email or call us at $business_phone";  

                
                mail($this->email, 'Failed Payment', $message2, $headers);
             }
             
             
            $this->insertPaymentHistory();
            $this->insertRejectedPayments();
            
            $this->noteMessage = "The customers credit card was refused 3 times for their $this->paymentDescription on $this->paymentDate. Error code: $this->response Error Message: $this->responseMessage Please call and have the customer update there card.";
                $this->insertAccountNotes();
               
               $processed = 'Y';
               $imported = 'Y';
               $outstandingBalance = 'Y';
               $sql = "UPDATE billing_scheduled_recuring_payments SET imported = ?, outstanding_balance = ? WHERE contract_key = '$this->contractKey' AND payment_id = '$payment_id'";
                  $stmt = $dbMain->prepare($sql);
                  $stmt->bind_param('ss', $imported, $outstandingBalance);
                  if(!$stmt->execute())  {
                 	  printf("Error:updateEHFEE %s.\n", $stmt->error);
                     }	          
                  $stmt->close(); 
                
              }
              
              $stmt = $dbMain ->prepare("SELECT count(*) FROM billing_scheduled_recuring_payments WHERE payment_type = 'MS' AND outstanding_balance = 'Y' AND contract_key = '$this->contractKey'");
                $stmt->execute();      
                $stmt->store_result();      
                $stmt->bind_result($count);
                $stmt->fetch();
                $stmt->close();  
                
                if ($count >= $max_cycles_retry AND $max_cycles_retry != 0 AND $this->attemptNumber >= $max_retries){//0 means its off
                    $stmt = $dbMain ->prepare("SELECT SUM(billing_amount) FROM billing_scheduled_recuring_payments WHERE outstanding_balance = 'Y' AND contract_key = '$this->contractKey'");
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
                    	if(!$stmt->execute())  {
                                	printf("Error:insertRGFEE %s.\n", $stmt->error);
                                      }	
                        $this->batchId = $stmt->insert_id;
                    	$stmt->close();
                        
                        $status = "CO";
                        $sql = "UPDATE account_status SET account_status = ? WHERE contract_key = '$this->contractKey'";
                        $stmt = $dbMain->prepare($sql);
                        $stmt->bind_param('s', $status);
                        if(!$stmt->execute())  {
                         	  printf("Error:updateEHFEE %s.\n", $stmt->error);
                             }	          
                        $stmt->close(); 
                        
                        $this->noteMessage = "The customers account has failed to be billed for the last $max_cycles_retry cycles. They have been sent to collections. Please contact.";
                        $this->insertAccountNotes();
                    }
                    
                }
    
  $counter++; 
  $payment_id = "";
  $this->contractKey = "";
  $this->paymentType = "";
  $this->transactionType = "";
  $this->authorizationId = "";
  $this->attemptNumber = "";
  $this->billingAmount = "";
  $this->responseMessage = "";
  $this->response = "";
  $this->transactionTag = "";
  $this->email = "";
  $this->cycleStartMonth = "";
  $this->cycleStartDay = "";
  $this->cycleStartYear = "";
 }   
$stmt999->close();  

include"/var/www/vhosts/ems/cmp.burbankathleticclub.com/admin/firstData/batchSqlReportsCL.php";
$upload = new batchSqlReports();
$upload->fileMaker();

}
//============================================
function getSuccess(){
    return($this->success);
}
//===========================================================================================================
}
//
//$update = new updateTablesFailedTransaction();
//$update->moveData();


?>