<?php
session_start();


class  loadMembershipPricing{

function setServiceName($serviceName) {
          $this->serviceName = $serviceName;
          }
function setServiceQuantity($serviceQuantity) {
          $this->serviceQuantity = $serviceQuantity;
          }
function  setClubName($clubName) {
          $this->clubName = $clubName;
          }
//connect to database
function dbconnect()   {
require"../../dbConnect.php";
return $dbMain;
}

//-------------------------------------------------------------------------------------------------------------------
function loadPrices() {
$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT process_fee_single_two FROM fees WHERE fee_num = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($pif_process_fee);
$stmt->fetch();
$stmt->close();
//echo "$this->clubName";
//exit;
if(preg_match('/All/i',$this->clubName)){
    $clubId = "0";
}else{
    $stmt = $dbMain ->prepare("SELECT club_id FROM club_info WHERE club_name = '$this->clubName'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($clubId);
    $stmt->fetch();
    $stmt->close();
}

//echo "$this->serviceName  $this->serviceQuantity   $clubId";
//exit;

$stmt = $dbMain ->prepare("SELECT service_cost FROM service_cost JOIN service_info ON service_info.service_key = service_cost.service_key WHERE service_type = '$this->serviceName' AND service_quantity = '$this->serviceQuantity' AND club_id= '$clubId'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_cost);
$stmt->fetch();
$stmt->close();

$totPrice = sprintf("%.2f", $service_cost+$pif_process_fee);

$bit = 1;
$passBack = "$bit|$service_cost|$totPrice";
return $passBack;

}
//======================================================================================


    
}
//--------------------------------------------------------------------------------------
$ajax_switch = $_REQUEST['ajax_switch'];
$service_name = $_REQUEST['service_name'];
$nameTempArray = explode('&',$service_name);
$service_name = trim($nameTempArray[0]);
$clubNameArray = explode(';',$nameTempArray[2]);
$clubName = trim($clubNameArray[1]);
$service_quantity = $_REQUEST['service_quantity'];
$service_quantity = trim($service_quantity);

//echo "$service_name hhh $service_quantity club $clubName";
//exit;
if($ajax_switch == 1) {

$loadPricing = new loadMembershipPricing();
$loadPricing-> setServiceName($service_name);
$loadPricing-> setServiceQuantity($service_quantity);
$loadPricing-> setClubName($clubName);
$result1 = $loadPricing-> loadPrices();

echo"$result1";
exit;
}





?>