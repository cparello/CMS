<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class loadExpiredCount{

private $contractKey =  null;
private $serviceKey = null;
private $serviceEndDate = null;
private $dateRange = null;
private $expiredCount = null;
private $accountStatus = null;


function setDateRange($dateRange) {
       $this->dateRange = $dateRange;
       }


//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//==============================================================================
function checkAccountStatus()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT account_status FROM account_status WHERE contract_key = '$this->contractKey' AND service_key='$this->serviceKey'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($account_status);
$stmt->fetch();
 
 $this->accountStatus = $account_status;
 
    switch ($this->accountStatus) {
        case "HO":
               $this->expiredCount = $this->expiredCount - 1;
        break;
        case "CA":
               $this->expiredCount = $this->expiredCount - 1;
        break;
      }
  

 
    if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close();    

}
//-----------------------------------------------------------------------------------------------------------------------------------------
function loadRecordCount() {

$dateBetweenStart = date("Y-m-d"  ,mktime(0, 0, 0, date("m")  , date("d")- $this->dateRange, date("Y")));
$dateBetweenEnd = date("Y-m-d");

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT DISTINCT service_key, contract_key, service_name, end_date FROM paid_full_services WHERE end_date BETWEEN '$dateBetweenStart' AND  '$dateBetweenEnd' ORDER BY end_date DESC");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_key, $contract_key, $service_name, $end_date);
$this->expiredCount = $stmt->num_rows;

while ($stmt->fetch()) {  
           $stmt99 = $dbMain ->prepare("SELECT MAX(end_date) FROM paid_full_services WHERE contract_key = '$contract_key' AND service_key = '$service_key'");
            $stmt99->execute();      
            $stmt99->store_result();      
            $stmt99->bind_result($end_dateMax);
            $stmt99->fetch();
            $stmt99->close();
            
            $maxSecs = strtotime($end_dateMax);
            $endSecs = strtotime($end_date);
            
            if ($maxSecs <= $endSecs){
        
              $this->contractKey = $contract_key;
              $this->serviceKey = $service_key;
              $this->checkAccountStatus();
             }else{
                $this->expiredCount--;
             }
         }



if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close(); 



}
//----------------------------------------------------------------------------------------------------------------------------------------
function getExpiredCount() {
       return($this->expiredCount);
       }


}

//==============================================================================
$ajax_switch = $_REQUEST['ajax_switch'];
$date_range = $_REQUEST['date_range'];

if($ajax_switch == 1) {

$expired = new loadExpiredCount();
$expired-> setDateRange($date_range);
$expired-> loadRecordCount();
$exp_count = $expired-> getExpiredCount();

echo"$exp_count";

}







?>