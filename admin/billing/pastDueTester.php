<?php
session_start();

class loadPastDue {

private $contractKey = null;
private $currentMonthDueDate = null;
private $nextPaymentDueDate = null;
private $monthsPastDue = null;
private $nextMonthDueDate = null;
private $settledCount = 0;
private $prePayCount = null;
private $monthlyCount = null;
private $todaysDate = null;
private $listType = null;
private $counter = 1;
private $color = null;
private $firstName = null;
private $middleName = null;
private $lastName = null;
private $primaryPhone = null;
private $cellPhone = null;
private $emailAddress = null;
private $clientStreet = null;
private $clientCity = null;
private $clientState = null;
private $clientZip = null;
private $daysPastDue = null;
private $monthlyPayment = null;
private $monthlyBillingType = null;
private $billingTotal = null;
private $lateFee = null;
private $pastDueHeader = null;
private $pastDueText = null;
private $defaultAttempts = null;
private $pastDueFreq = null;
private $attemptDate = null;
private $attemptNum = null;
private $finalNum = '10';
private $invoiceHeader = null;
private $finalHeader = null;
private $finalText = null;
private $currentStatementDate = null;
private $statementRangeEndDate = null;
private $statementRangeStartDate =  null;
private $businessName = null;
private $businessStreet = null;
private $businessCity = null;
private $businessState = null;
private $businessZip = null;
private $parseLength = 0;
private $invoice = null;
private $mailHeader = null;
private $mailFooter = null;
private $printableInvoice = null;
private $amendKey = null;
private $imageName = null;
private $pastDay = null;
private $nextDueDaysPast = null;
private $cycleDay = null;



function setAmendKey($amendKey) {
              $this->amendKey = $amendKey;
              }

function setContractKey($contractKey) {
              $this->contractKey = $contractKey;
              }

function setTodaysDate($todaysDate) {
              $this->todaysDate = $todaysDate;
              }

function setListType($listType) {
              $this->listType = $listType;
              }

function setImageName($imageName) {
              $this->imageName = $imageName;
              }
              
function  setPastMonth($pastMonth){
              $this->pastMonth = $pastMonth;
              }
function  setPastYear($pastYear){
              $this->pastYear = $pastYear;
              }
              
//---------------------------------------------------------------------------------------------------------------------              
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;              
}

//--------------------------------------------------------------------------------------------------------------------
function filterPrepayments() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) AS count FROM pre_payments WHERE contract_key= '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();

$this->prePayCount = $count;


$stmt->close();
}
//--------------------------------------------------------------------------------------------------------------------
function filterCredits() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) AS count FROM service_credits WHERE contract_key= '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();

$this->creditCount = $count;


$stmt->close();
}
//--------------------------------------------------------------------------------------------------------------------
function filterMonthlyPayments() {

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
function loadStatusCount() {

$dbMain = $this->dbconnect();
$stmt = $dbMain->prepare("SELECT service_id FROM monthly_services  WHERE contract_key = '$this->contractKey'");//>=
$stmt->execute();  
$stmt->store_result();      
$stmt->bind_result($service_id); 
while($stmt->fetch()){
    $stmt = $dbMain ->prepare("SELECT count(*) FROM account_status WHERE account_status ='CU' AND contract_key='$this->contractKey' AND service_id = '$service_id'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    $totalCount += $count;
    }
$stmt->close();

 
$this->statusCount = $totalCount;


}
//---------------------------------------------
//--------------------------------------------------------------------------------------------------------------------
function loadRecordCount() {


$this->pastYear = "2014";
$dbMain = $this->dbconnect();

$this->loadPastDay();
$this->loadFees();

$monthArray = array(1,2,3,4,5,6,7,8,9,10,11,12);

foreach($monthArray as $billMonth){

$this->pastMonth = "$billMonth";

$stmt = $dbMain ->prepare("SELECT DISTINCT contract_key, next_payment_due_date FROM monthly_settled WHERE contract_key != ''");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($contract_key, $next_payment_due_date);

 while ($stmt->fetch()) { 
    $this->contractKey = $contract_key;
    $stmt1 = $dbMain ->prepare("SELECT MAX(contract_date) FROM contract_info WHERE contract_key ='$this->contractKey'");
    $stmt1->execute();      
    $stmt1->store_result();      
    $stmt1->bind_result($contract_date);
    $stmt1->fetch();
    $stmt1->close();
    
    $contractDateSecs = strtotime($contract_date);
    $twentyFourteenStartSecs = strtotime('2014/01/01');
    //echo "test";
    $dueMonth = date('m',strtotime($next_payment_due_date));
    $dueDay = date('d',strtotime($next_payment_due_date));
    $dueYear = date('Y',strtotime($next_payment_due_date));
    $dueDate = date('Y-m-d',mktime(0,0,0,$dueMonth,$dueDay-$this->pastDay,$dueYear));
    $dueDateSecs = strtotime($dueDate);
    
    $startMonthSecs =  strtotime(date('Y-m-d',mktime(0,0,0,$this->pastMonth,1,$this->pastYear)));
    $endMonthSecs =  strtotime(date('Y-m-d',mktime(0,0,0,$this->pastMonth,date('t'),$this->pastYear)));
    
    if($dueDateSecs > $startMonthSecs AND $dueDateSecs < $endMonthSecs AND $twentyFourteenStartSecs < $contractDateSecs){
          
           
                    $this->loadStatusCount();                  
                    $this->filterPrepayments();
                    $this->filterCredits();
                     
                       if($this->prePayCount == 0 AND $this->creditCount == 0 AND $this->statusCount != 0) { 
                            $customerBillingDate = date('d',strtotime($dueDate));
                    
                            if(date('d') < $customerBillingDate){
                                $mStart = date('m')-1;//8;
                                $yStart = date('Y');
                                $billingDate = date('d');//25;
                            }elseif(date('d') == $customerBillingDate){
                                $mStart = date('m');//8;
                                $yStart = date('Y');
                                $billingDate = date('d');//25;
                            }elseif(date('d') > $customerBillingDate){
                                $mStart = date('m');//8;
                                $yStart = date('Y');
                                $billingDate = date('d');//25;
                            }
                            $currentDueDate = date("Y-m-d H:i:s",mktime(23,59,59,$mStart,$customerBillingDate,$yStart));
                            if($next_payment_due_date != "") {
                                
                                $stmt1 = $dbMain ->prepare("SELECT MAX(payment_id), response_message FROM billing_scheduled_recuring_payments WHERE contract_key ='$this->contractKey'  AND response != '100'");
                                $stmt1->execute();      
                                $stmt1->store_result();      
                                $stmt1->bind_result($payment_id, $this->responseMessage);
                                $stmt1->fetch();
                                $stmt1->close();
                                
                               
                               $datetime1 = new DateTime($dueDate);
                               $datetime2 = new DateTime($currentDueDate);
                               $interval = $datetime1-> diff($datetime2);                    
                               $this->daysPastDue = $interval-> format('%d'); 
                               $this->monthsPastDue = $interval-> format('%m'); 
                               $this->monthsPastDue++;
                               if ($this->monthsPastDue > 0){
                                  $this->loadMonthlyPayment();
                                  //echo "test 1 d $this->daysPastDue m $this->monthsPastDue cd $currentDueDate dd $dueDate<br>";
                               }
                               }elseif($next_payment_due_date == "") {
                                
                                $stmt1 = $dbMain ->prepare("SELECT cycle_date FROM monthly_payments WHERE contract_key ='$this->contractKey'");
                                $stmt1->execute();      
                                $stmt1->store_result();      
                                $stmt1->bind_result($cycle_date);
                                $stmt1->fetch();
                                $stmt1->close();
   
                                 //create the past due day and monthly cycle date from monthly payment
                                 $cycle_day = date("d", strtotime($cycle_date));
                                 $pastDueDay = $this->pastDay + $cycle_day;
                                 $cycleMonth = date("m", strtotime($cycle_date));
                                 $cycleYear = date("Y", strtotime($cycle_date));
                                 $monthlyPaymentsDueDate= date("Y-m-d H:i:s"  ,mktime(0, 0, 0, $cycleMonth, $pastDueDay, $cycleYear));
                                 $monthlyPaymentsDueDateSecs = strtotime($monthlyPaymentsDueDate);
                                 $todaysDateSecs = time();
                                 
                                  if($todaysDateSecs >= $monthlyPaymentsDueDateSecs) {      
                                       $datetime1 = new DateTime($monthlyPaymentsDueDate);
                                       $datetime2 = new DateTime($currentDueDate);
                                       $interval = $datetime1-> diff($datetime2);                    
                                       $this->daysPastDue = $interval-> format('%d'); 
                                       $this->monthsPastDue = $interval-> format('%m'); 
                                       $this->monthsPastDue++;
                                       if ($this->monthsPastDue > 0){
                                        $this->loadMonthlyPayment();
                                        //echo "test2 d $this->daysPastDue m $this->monthsPastDue $this->contractKey<br>";
                                       }
                                     }     
                                 
                               }
                          
                         }
                  } 
                  $contract_key = "";
                  $next_payment_due_date = "";   
                  $this->responseMessage = "";               
              }
 
 
$stmt->close();
}

$fileHeader = "contractKey, balance \r\n";
        
$this->outFile = "$fileHeader$this->outFile";
    //echo "$this->outFile";
    
$ourFileName = "accountBalances.csv";
$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
fwrite($ourFileHandle, $this->outFile);  
fclose($ourFileHandle);

echo $this->totAmoutmn;
//echo $this->outFile;
}
//--------------------------------------------------------------------------------------------------------------------
function loadPastDay() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT past_day FROM billing_cycle WHERE cycle_key ='1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($past_day);
$stmt->fetch();
$stmt->close();

$this->pastDay = $past_day;

}
//---------------------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------------------
function loadFees() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT late_fee, nsf_fee, rejection_fee FROM fees WHERE fee_num = '1'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($late_fee, $nsf_fee, $rejection_fee);
$stmt->fetch();

$this->lateFee = $late_fee;

$stmt->close();  
}
//--------------------------------------------------------------------------------------------------------------------
function loadMonthlyPayment()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT billing_amount,  monthly_billing_type FROM monthly_payments WHERE contract_key = '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($billing_amount, $billing_type);
$stmt->fetch();


$this->monthlyPayment = $billing_amount;
$this->monthlyBillingType = $billing_type;

  if($this->monthsPastDue >= 1) {
     $this->monthlyPayment = ($this->monthlyPayment * $this->monthsPastDue) + $this->lateFee;     
    }else{
         $this->monthlyPayment = 0;
    }


$this->billingTotal = $this->monthlyPayment;
$this->billingTotal = number_format("$this->billingTotal",2);

$this->totAmoutmn += $this->billingTotal;

$this->monthlyPayment = number_format("$this->monthlyPayment",2);

$this->outFile .= "$this->contractKey,$this->billingTotal \r\n";

 if(!$stmt->execute())  {
	printf("Error: %s.\n  monthly_payments function loadMonthlyPayment", $stmt->error);
      }
   
$stmt->close();  

}
//------------------------------------------------------------------------------------------------------------------




//-------------------------------------------------------------------------------------------------------------------
function getPrintableInvoice() {
             return($this->printableInvoice);
             }


}//end class
//----------------------------------------------------------------------
//echo "test";
$checkPast = new loadPastDue();
$checkPast-> loadRecordCount();












?>