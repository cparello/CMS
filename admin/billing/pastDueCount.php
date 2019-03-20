<?php
class  pastDueCount {


private $contractKey = null;
private $prePayCount = null;
private $monthlyCount = null;
private $currentMonthDueDate = null;
private $nextMonthDueDate = null;
private $settledCount = 0;
private $testCount = 1;
private $ajaxSwitch = 0;
private $pastDay = null;

function setContractKey($contractKey) {
       $this->contractKey = $contractKey;
       }

function setAjaxSwitch($ajaxSwitch) {
       $this->ajaxSwitch= $ajaxSwitch;
       }
function setPastYear($year) {
       $this->pastYear = $year;
       }
function setPastMonth($month) {
       $this->pastMonth = $month;
       }

//---------------------------------------------------------------------------------------------------------------------              
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;              
}
//----------------------------------------------------------------------------------------------------------------------------------------------
function loadMonthly() {

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
    $totalCount = 0;
$dbMain = $this->dbconnect();
$stmt99 = $dbMain->prepare("SELECT service_id FROM monthly_services  WHERE contract_key = '$this->contractKey'");//>=
$stmt99->execute();
$stmt99->store_result();
$stmt99->bind_result($service_id);
while($stmt99->fetch()){
    $stmt = $dbMain ->prepare("SELECT count(*) as count FROM account_status WHERE account_status ='CU' AND contract_key='$this->contractKey' AND service_id = '$service_id'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    $totalCount += $count;
    }
$stmt99->close();

 
$this->statusCount = $totalCount;


}
//----------------------------------------------------------------------------------------------------------------------------------------------
function checkPrepay() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(contract_key) AS count FROM pre_payments WHERE contract_key= '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();

$this->prePayCount = $count;


$stmt->close();
}
//===============================================
function checkCredit() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(contract_key) AS count FROM service_credits WHERE contract_key= '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();

$this->creditCount = $count;


$stmt->close();
}
//--------------------
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
//----------------------------------------------------------------------------------------------------------------------------------------------
function loadRecordCount() {//SELECT DISTINCT monthly_payments.contract_key FROM monthly_payments JOIN account_status ON monthly_payments.contract_key = account_status.contract_key WHERE account_status = 'CU'

$dbMain = $this->dbconnect();

$this->loadPastDay();

$stmt = $dbMain ->prepare("SELECT DISTINCT contract_key, next_payment_due_date FROM monthly_settled WHERE contract_key != ''");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->contractKey, $next_payment_due_date);

 while ($stmt->fetch()) { 
    $dueMonth = date('m',strtotime($next_payment_due_date));
    $dueDay = date('d',strtotime($next_payment_due_date));
    $dueYear = date('Y',strtotime($next_payment_due_date));
    $dueDate = date('Y-m-d',mktime(0,0,0,$dueMonth,$dueDay,$dueYear));
    $dueDateSecs = strtotime($dueDate);
    
    $startMonthSecs =  strtotime(date('Y-m-d',mktime(0,0,0,$this->pastMonth,1,$this->pastYear)));
    $endMonthSecs =  strtotime(date('Y-m-d',mktime(0,0,0,$this->pastMonth,date('t'),$this->pastYear)));
    
    if($dueDateSecs > $startMonthSecs AND $dueDateSecs < $endMonthSecs){

           
                    $this->loadStatusCount();                  
                    $this->checkPrepay();
                    $this->checkCredit();
                     
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
                               
                               $datetime1 = new DateTime($dueDate);
                               $datetime2 = new DateTime($currentDueDate);
                               $interval = $datetime1-> diff($datetime2);                    
                               $this->daysPastDue = $interval-> format('%d'); 
                               $this->monthsPastDue = $interval-> format('%m'); 
                               $this->monthsPastDue++;
                               if ($this->monthsPastDue > 0){
                                   $this->settledCount++; 
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
                                        $this->settledCount++; 
                                       }
                                     }     
                                 
                               }
                          
                         }
                  } 
                  $contract_key = "";
                  $next_payment_due_date = "";                  
              }
 
 
$stmt->close();

if($this->ajaxSwitch == 1) {
   echo"$this->settledCount";
   exit;
   }
   
}
//---------------------------------------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------------------


}
 $ajax_switch =$_REQUEST['ajax_switch'];
 $pastMonth =$_REQUEST['pastMonth'];
 $pastYear =$_REQUEST['pastYear'];

if($ajax_switch == 1) {
   $testPastDue = new  pastDueCount();
   $testPastDue-> loadPastDay();
   $testPastDue-> setAjaxSwitch($ajax_switch);
   $testPastDue-> setPastYear($pastYear);
   $testPastDue-> setPastMonth($pastMonth);
   $testPastDue-> loadRecordCount();
   }


?>