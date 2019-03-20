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
function  setStartDate($starDate) {
          $this->startDate = $starDate;
          }
function  setDiscount($discount) {
          $this->discount = $discount;
          }
//connect to database
function dbconnect()   {
require"../../../../dbConnect.php";
return $dbMain;
}

//-------------------------------------------------------------------------------------------------------------------
function loadPrices() {
$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT renewal_fee_single FROM fees WHERE fee_num = '1'");
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

$stmt = $dbMain ->prepare("SELECT service_cost, service_term FROM service_cost JOIN service_info ON service_info.service_key = service_cost.service_key WHERE service_type = '$this->serviceName' AND service_quantity = '$this->serviceQuantity' AND club_id= '$clubId'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_cost, $service_term);
$stmt->fetch();
$stmt->close();

switch($service_term){
    case 'C':
        if ($this->serviceQuantity == 1){
            $service_term_text = "Class";
        }else{
            $service_term_text = "Classes";
        }
        $newEndDateFormatted = "No Expiration";
    break;
    case 'D':
        if ($this->serviceQuantity == 1){
            $service_term_text = "Day";
        }else{
            $service_term_text = "Days";
        }
        $newEndDateFormatted = date('F j Y',mktime(23,59,59,date('m',strtotime($this->startDate)),date('d',strtotime($this->startDate))+$this->serviceQuantity,date('Y',strtotime($this->startDate))));
        
    break;
    case 'W':
        if ($this->serviceQuantity == 1){
            $service_term_text = "Week";
        }else{
            $service_term_text = "Weeks";
        }
        $days = $this->serviceQuantity *7;
        $newEndDateFormatted = date('F j Y',mktime(23,59,59,date('m',strtotime($this->startDate)),date('d',strtotime($this->startDate))+$days,date('Y',strtotime($this->startDate))));
        
    break;
    case 'Y':
        if ($this->serviceQuantity == 1){
            $service_term_text = "Year";
        }else{
            $service_term_text = "Years";
        }
        $newEndDateFormatted = date('F j Y',mktime(23,59,59,date('m',strtotime($this->startDate)),date('d',strtotime($this->startDate))+$service_quantity,date('Y',strtotime($this->startDate))+$this->serviceQuantity));
        
    break;
}

$discount = sprintf("%.2f", (($this->discount/100)*$service_cost));
$service_cost = $service_cost - $discount;
$totPrice = sprintf("%.2f", $service_cost+$pif_process_fee);

$bit = 1;
$passBack = "$bit|$service_cost|$totPrice|$service_term_text|$newEndDateFormatted|$discount";
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
$starDate = $_REQUEST['starDate'];
$discount = $_REQUEST['discount'];

//echo "$service_name hhh $service_quantity club $clubName";
//exit;
if($ajax_switch == 1) {

$loadPricing = new loadMembershipPricing();
$loadPricing-> setServiceName($service_name);
$loadPricing-> setServiceQuantity($service_quantity);
$loadPricing-> setClubName($clubName);
$loadPricing-> setStartDate($starDate);
$loadPricing-> setDiscount($discount);
$result1 = $loadPricing-> loadPrices();

echo"$result1";
exit;
}





?>