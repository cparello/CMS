<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class loadPromoCount{

private $contractKey =  null;
private $serviceKey = null;
private $serviceEndDate = null;
private $dateRange = null;
private $promoCount = null;
private $accountStatus = null;


function setDateRangeStart($dateRangeStart) {
       $this->dateRangeStart = $dateRangeStart;
       }
function setDateRangeEnd($dateRangeEnd) {
       $this->dateRangeEnd = $dateRangeEnd;
       }

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//==============================================================================
function checkAccountStatus()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT account_status FROM account_status WHERE contract_key = '$this->contractKey' AND service_key='$this->serviceKey' ORDER BY status_date DESC LIMIT 1");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($this->accountStatus);
$stmt->fetch();
$stmt->close();    

}
//-----------------------------------------------------------------------------------------------------------------------------------------
function loadRecordCount() {

    $this->promoCount = 1;
$dateBetweenStart = date("Y-m-d"  ,mktime(0, 0, 0, date("m")  , date("d")- $this->dateRangeStart, date("Y")));
$dateBetweenEnd = date("Y-m-d"  ,mktime(0, 0, 0, date("m")  , date("d")+ $this->dateRangeEnd, date("Y")));

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT DISTINCT contract_key, service_key,  service_name, end_date FROM paid_full_services WHERE end_date BETWEEN '$dateBetweenStart' AND  '$dateBetweenEnd' ORDER BY end_date DESC");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($contract_key, $service_key, $service_name, $end_date);

while ($stmt->fetch()) {  
           $stmt99 = $dbMain ->prepare("SELECT end_date FROM paid_full_services WHERE contract_key = '$contract_key' AND service_key = '$service_key' ORDER BY end_date DESC LIMIT 1");
            $stmt99->execute();      
            $stmt99->store_result();      
            $stmt99->bind_result($end_dateMax);
            $stmt99->fetch();
            $stmt99->close();


    $this->contractKey = $contract_key;
    $this->serviceKey = $service_key;
    $this->checkAccountStatus();
    if (strtotime($end_dateMax) == strtotime($end_date) AND $this->accountStatus == 'CU'){
              $this->promoCount++;
             }

    $service_key = "";
    $contract_key = "";
    $service_name = "";
    $end_date = "";
         }


   
$stmt->close(); 



}
//----------------------------------------------------------------------------------------------------------------------------------------
function getPromoCount() {
       return($this->promoCount);
       }


}

//==============================================================================
$ajax_switch = $_REQUEST['ajax_switch'];
$date_range_start = $_REQUEST['date_range_start'];
$date_range_end = $_REQUEST['date_range_end'];

if($ajax_switch == 1) {

$promo = new loadPromoCount();
$promo-> setDateRangeStart($date_range_start);
$promo-> setDateRangeEnd($date_range_end);
$promo-> loadRecordCount();
$exp_count = $promo-> getPromoCount();

echo"$exp_count";

}







?>