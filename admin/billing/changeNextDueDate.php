<?php
session_start();


class  changeDueDate{

function setDueDate($dueDate) {
          $this->dueDate = $dueDate;
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
function changeDate() {
$dbMain = $this->dbconnect();

$this->result = 1;

$date = date('Y-m-d H:i:s',strtotime($this->dueDate));

$sql = "UPDATE monthly_settled SET next_payment_due_date = ? WHERE contract_key = '$this->contractKey'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('s', $date);
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
$date_month = $_REQUEST['date_month'];
$date_day = $_REQUEST['date_day'];
$date_year = $_REQUEST['date_year'];
$contract_key = $_REQUEST['contract_key'];
$past_days = $_REQUEST['past_days'];

$due_date = date('Y-m-d H:i:s',mktime(23,59,59,$date_month,$date_day+$past_days,$date_year));
//echo "$service_key hhh $contract_key ";
//exit;
if($ajax_switch == 1) {

$loadPricing = new changeDueDate();
$loadPricing-> setDueDate($due_date);
$loadPricing-> setContractKey($contract_key); 
$loadPricing-> changeDate();
$result = $loadPricing->getResult();
echo"$result";
exit;
}





?>