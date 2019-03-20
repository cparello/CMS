<?php
class  monthlyStatementCount {


private $contractKey = null;
private $prePayCount = null;
private $monthlyCount = null;
private $currentMonthDueDate = null;
private $nextMonthDueDate = null;
private $invoiceCount = 0;
private $testCount = 1;
private $ajaxSwitch = 0;

function setContractKey($contractKey) {
       $this->contractKey = $contractKey;
       }

function setAjaxSwitch($ajaxSwitch) {
       $this->ajaxSwitch= $ajaxSwitch;
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
$stmt = $dbMain ->prepare("SELECT count(*) AS count FROM monthly_payments WHERE contract_key='$this->contractKey' AND billing_amount != '0.00' AND monthly_billing_type !='CR' AND monthly_billing_type !='BA' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();


 $this->monthlyCount = $count;
   

$stmt->close();
}
//----------------------------------------------------------------------------------------------------------------------------------------------
function checkPrepay() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) AS count FROM pre_payments WHERE contract_key= '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();

$this->prePayCount = $count;


$stmt->close();
}
//----------------------------------------------------------------------------------------------------------------------------------------------
function loadRecordCount() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT DISTINCT monthly_payments.contract_key FROM monthly_payments JOIN account_status ON monthly_payments.contract_key = account_status.contract_key WHERE account_status = 'CU'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($contract_key);

 while ($stmt->fetch()) { 
 
           $this->contractKey = $contract_key;
           $this->checkPrepay();
                                        
                if($this->prePayCount == 0) {     
                   $this->loadMonthly();
                   
                   if($this->monthlyCount == 1) { 
                      $this->invoiceCount++;                                     
                      }
                  }                       
                 
           }
 
 
$stmt->close();

if($this->ajaxSwitch == 1) {
   echo"$this->invoiceCount";
   exit;
   }
   
}
//---------------------------------------------------------------------------------------------------------------------------------------
function loadCycleDate() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT past_day, cycle_day FROM billing_cycle WHERE cycle_key ='1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($past_day, $cycle_day);
$stmt->fetch();
$stmt->close();


$nextDueDaysPast = $past_day + $cycle_day;

$this->currentMonthDueDate = date("Y-m-d"  ,mktime(0, 0, 0, date("m")  , $nextDueDaysPast, date("Y")));
$this->nextMonthDueDate = date("Y-m-d"  ,mktime(0, 0, 0, date("m")+1  , $nextDueDaysPast, date("Y")));


$this->currentStatementDate =  date("m/d/Y"  ,mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
$this->statementRangeEndDate = date("m/d/Y"  ,mktime(0, 0, 0, date("m"), $nextDueDaysPast, date("Y")));
$this->statementRangeStartDate = date("m/d/Y"  ,mktime(0, 0, 0, date("m")-1  , $cycle_day, date("Y")));

}
//---------------------------------------------------------------------------------------------------------------------


}
 $ajax_switch =$_REQUEST['ajax_switch'];

if($ajax_switch == 1) {
   $checkMonthlyCount = new  monthlyStatementCount();
   $checkMonthlyCount-> loadCycleDate();
   $checkMonthlyCount-> setAjaxSwitch($ajax_switch);
   $checkMonthlyCount-> loadRecordCount();
   }


?>