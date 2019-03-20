<?php
session_start();


class  changeBillAmount{

function setBillAmount($billAmount) {
          $this->billAmount = $billAmount;
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
function changeAmount() {
$dbMain = $this->dbconnect();

$this->result = 1;

$sql = "UPDATE monthly_payments SET billing_amount = ? WHERE contract_key = '$this->contractKey'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('d', $this->billAmount);
if(!$stmt->execute())  {
    printf("Error:updateStatus %s.\n", $stmt->error);
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
$bill_amount = $_REQUEST['bill_amount'];
$contract_key = $_REQUEST['contract_key'];

//echo "$service_key hhh $contract_key ";
//exit;
if($ajax_switch == 1) {

$loadPricing = new changeBillAmount();
$loadPricing-> setBillAmount($bill_amount);
$loadPricing-> setContractKey($contract_key); 
$loadPricing-> changeAmount();
$result = $loadPricing->getResult();
echo"$result";
exit;
}





?>