<?php
//error_reporting(E_ALL);
class updateTablesSucessfulTransaction {

private $color = null;
    
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

function setLesserValue($value){
    $this->lesserValue = $value;
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
    
    $stmt = $dbMain->prepare("SELECT cycle_date FROM monthly_payments WHERE contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->cycleDate); 
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

$stmt = $dbMain-> prepare("SELECT rate_fee, enhance_fee, late_fee, rejection_fee FROM fees WHERE fee_num = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->rateFee, $this->enhanceFee, $this->lateFee, $this->rejectionFee);
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
    if ($this->billingAmount > $this->lesserValue) { 
            $origAmount = $this->billingAmount;
            $this->billingAmount = $this->lesserValue;
            $stillOwed =  $origAmount - $this->lesserValue;
            $processed = 'N';
            $imported = 'N';
            
            
            $sql = "UPDATE billing_scheduled_recuring_payments SET billing_amount = ?, processed = ?, imported = ?  WHERE contract_key = '$this->contractKey' AND payment_id = '$payment_id'";
            $stmt = $dbMain->prepare($sql);
            $stmt->bind_param('dss', $stillOwed, $processed, $imported);
            if(!$stmt->execute())  {
                        	printf("Error:updateBillingAmount %s.\n", $stmt->error);
                              }	
            
            $stmt->close();  
            $this->paymentDescription = "Partial Past Monthly Dues $this->transactionType";         
            }else{
                $this->paymentDescription = "Past Monthly Dues $this->transactionType";
            }

  $this->paymentDate = date("Y-m-d H:i:s");
  
  $this->loadNextBillingDate();
 
 
 $this->insertMonthlySettled();
 $settledCount++;
 $settledTotal += $this->billingAmount;
 //$this->paymentDescription = "Past Monthly Dues $this->transactionType";
 
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
 }   
$stmt999->close();  

include"batchSqlReports.php";
$upload = new batchSqlReports();
$upload->fileMaker();
}
//===========================================================================================================
}
//
//$update = new updateTablesSucessfulTransaction();
//$update->moveData();


?>