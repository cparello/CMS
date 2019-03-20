<?php
session_start();


class  reactivateService{

function setServiceKey($serviceKey) {
          $this->serviceKey = $serviceKey;
          }
function setContractKey($contractKey) {
          $this->contractKey = $contractKey;
          }
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//-------------------------------------------------------------------------------------------------------------------
function reactivate() {
$dbMain = $this->dbconnect();

$this->result = 1;

$accountStatus = "CU";
$sql = "UPDATE account_status SET account_status = ? WHERE contract_key = '$this->contractKey' AND service_key = '$this->serviceKey'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('s', $accountStatus);
if(!$stmt->execute())  {
    printf("Error:updateStatus %s.\n", $stmt->error);
    $this->result = 2;
}	
$stmt->close();

$stmt = $dbMain ->prepare("SELECT monthly_dues, unit_price, number_months FROM monthly_services WHERE contract_key = '$this->contractKey' AND service_key = '$this->serviceKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($monthly_dues, $unit_price, $number_months );
$stmt->fetch();
$stmt->close();

if($monthly_dues == 0){
    $monthly_dues = sprintf("%.2f", $unit_price/$number_months);
}

$stmt = $dbMain ->prepare("SELECT billing_amount FROM monthly_payments WHERE contract_key = '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($billing_amount);
$stmt->fetch();
$stmt->close();

$newBillAmount = $billing_amount + $monthly_dues;

$sql = "UPDATE monthly_payments SET billing_amount = ? WHERE contract_key = '$this->contractKey'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('d', $newBillAmount);
if(!$stmt->execute())  {
    printf("Error:updateMonthPay %s.\n", $stmt->error);
    $this->result = 2;
}	
$stmt->close();
}
//======================================================================================
function getResult() {
          return($this->result);
          }

    
}
//--------------------------------------------------------------------------------------
$ajax_switch = $_REQUEST['ajax_switch'];
$service_key = $_REQUEST['service_key'];
$contract_key = $_REQUEST['contract_key'];

//echo "$service_key hhh $contract_key ";
//exit;
if($ajax_switch == 1) {

$loadPricing = new reactivateService();
$loadPricing-> setServiceKey($service_key);
$loadPricing-> setContractKey($contract_key); 
$loadPricing-> reactivate();
$result = $loadPricing->getResult();
echo"$result";
exit;
}





?>