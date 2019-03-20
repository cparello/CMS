<?php
session_start();
class  clubSysUpdate {

//--------------------------------------------------------------------------------------------------------------------------------------------
function dbconnect()   {
require"dbConnect.php";
return $dbMain;
}
//===================================================================================
function insertMonthlySettled(){
    $dbMain = $this->dbconnect();
    
    $stmt = $dbMain ->prepare("SELECT count(*), next_payment_due_date FROM monthly_settled WHERE contract_key = '$this->contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($count, $next_payment_due_date);
    $stmt->fetch();
    $stmt->close();  
    
    $stmt = $dbMain ->prepare("SELECT past_day FROM billing_cycle WHERE cycle_key ='1'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($past_day);
    $stmt->fetch();
    $stmt->close();

    $dueMonth = date('m',strtotime($next_payment_due_date));
    $dueDay = date('d',strtotime($next_payment_due_date));
    $dueYear = date('Y',strtotime($next_payment_due_date));
    $dueDate = date('Y-m-d',mktime(0,0,0,$dueMonth,$dueDay-$past_day,$dueYear));
    
    $customerBillingDate = date('d',strtotime($dueDate));
                    
    if($customerBillingDate == 10){
        $nextBillingDate = date('Y-m-d H:i:s',mktime(23,59,59,3,16,15));
    }else if ($customerBillingDate == 25){
        $nextBillingDate = date('Y-m-d H:i:s',mktime(23,59,59,3,3,15));
    }
    
	//$nextBillingDate = date('Y-m-d H:i:s',mktime(23,59,59,$mStart,$customerBillingDate+$past_day,$yStart));//date("Y-m-d H:i:s"  ,strtotime($this->nextBillingDate));
    $this->nextBillDate = $nextBillingDate;
    
    
	$contractKey = $this->contractKey;
	$transKey = $this->auth;
	$nextBillingFee = $this->amount;
    $transType = 'CR';
    
   if($count == 0){
	$sql = "INSERT INTO monthly_settled VALUES (?,?,?,?,?,?)";
	$stmt = $dbMain->prepare($sql);
	$stmt->bind_param('iidsss',$contractKey,$transKey,$nextBillingFee,$this->paymentDate,$nextBillingDate,$transType);
	if(!$stmt->execute())  {
            	printf("Error:insertMonthlySettled %s.\n", $stmt->error);
                  }	
	$stmt->close();
    }else{
        
        $sql = "UPDATE monthly_settled SET payment_amount = ?, payment_date= ?, next_payment_due_date = ?  WHERE contract_key = '$this->contractKey'";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('dss', $nextBillingFee, $this->paymentDate, $nextBillingDate);
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

                
    $creditPayment = $this->amount;
    $cashPayment = 0;
    $achPayment = 0;
    $checkPayment = 0;
    $ccRequestID = $this->auth;
    $achRequestID = 0;
 
                     
$currentBalance = 0;
$balanceDueDate = $this->paymentDate;
$paymentFlag = 'PF';
$rejectFeeCheck = 0;
$rejectFeeCredit = 0;
$rejectFeeAch = 0;
$lateFeeAll = 0;
$paymentDescription = "Monthly Dues CC";
$historyKey = "";
$contractKey = $this->contractKey;
$paymentAmount = $this->amount;                                            
//$paymentDate = $this->paymentDate;   
$paymentDate = $this->paymentDate;                     
$transKey = $this->auth;                                          
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
//===================================================================================
function loadExitFile() {

//$this->paymentDate = date('Y-m-d H:i:s',mktime(0,0,0,1,25,15));// date("Y-m-d H:i:s"  , strtotime($this->paymentDate));
echo "fu";
$count = 1;
$lines = file("APPROVED.CSV");
foreach ($lines as $line) {
echo "$line<br>";
$pat = ",";
$recordDivision = explode($pat, $line);

//name
$this->fname = $recordDivision[0];
$this->lname = $recordDivision[1];
//$this->blank = $recordDivision[2];
$this->memNum = $recordDivision[2];

//address
$this->rate = $recordDivision[3];
$this->amount = $recordDivision[4];

$this->ccNum = $recordDivision[5];
$this->auth = $recordDivision[6];
$this->paymentDate = $recordDivision[7];
$this->contractKey = $recordDivision[8];

$this->contractKey = trim($this->contractKey);
if($this->contractKey !=""){
echo "$count F $this->fname L $this->lname B $this->blank $this->memNum $this->rate $this->amount $this->ccNum $this->auth $this->date $this->contractKey   $this->nextBillDate<br><br><br>";
$count++;
$this->insertMonthlySettled();
$this->insertPaymentHistory();
}
}
} 
//===================================================================================
}
//$exitParse = new clubSysUpdate();
//$exitParse-> loadExitFile();

?>