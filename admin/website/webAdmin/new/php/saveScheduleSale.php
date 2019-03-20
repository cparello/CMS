<?php
session_start();

//this class formats the dropdown menu for clubs and facilities
class  saveScheduleSale {

private  $smSalesKey = null;
private  $smLocationId = null;
private  $smClubId = null;
private  $smMemberId = null;
private  $smServiceKey = null;
private  $smServiceQuantity = null;
private  $smServiceName = null;
private  $smServicePrice = null;
private  $smServiceDate = null;
private  $purchaseId = null;
private  $purchaseBit = null;


function setSmMemberId($smMemberId) {
        $this->memberId = $smMemberId;
        }

function setSmServiceKey($smServiceKey) {
        $this->smServiceKey = $smServiceKey;
        }
        
function setSmServiceQuantity($smServiceQuantity) {
        $this->smServiceQuantity = $smServiceQuantity;
        }        
        
function setSmServicePrice($smServicePrice) {
        $this->smServicePrice = $smServicePrice;
        }          
        
function setSmLocationId($smLocationId) {
        $this->smLocationId = $smLocationId;
        }       
        
function setSmClubId($smClubId) {
        $this->smClubId = $smClubId;
        }   
function  setContractKey($contractKey)   {
        $this->contractKey = $contractKey;
        }              
        
        
//connect to database
function dbconnect()   {
require"../../../../dbConnect.php";
return $dbMain;
} 

//------------------------------------------------------------------------------------------------------
function saveSchedulerSale() {

   $dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT service_type FROM service_info WHERE service_key = '$this->smServiceKey'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($serviceType); 
   $stmt->fetch();
   $stmt->close();
   
     $this->smServiceName = $serviceType;
     $salesKey = null;
     $locationId = $this->smClubId;
     $contractLocation = $this->smClubId;
     $userId = 0; 
     $groupType = 'S';
     $groupNumber = 1;
     $clubId = $this->smLocationId;
     $serviceKey = $this->smServiceKey;
     $serviceName = $this->smServiceName;
     $serviceQuantity = $this->smServiceQuantity;
     $serviceTerm = 'SC';
     $serviceTermReg = 'C';
     $serviceType = 'P';
     $unitPrice = $this->smServicePrice;
     $groupPrice = $this->smServicePrice;
     $overidePin = 'N'; 
     $overideUnitPrice = $this->smServicePrice;
     $overideGroupPrice = $this->smServicePrice;
     $termType = 'T';
     $renewal = 'N';
     $upgrade = 'N'; 
     $internet = 'N'; 
     $saleDateTime = date("Y-m-d H:i:s");
     $amPm =  date("a");
     $earlyRenewalBoon = 'N'; 
     $salesNew = 'Y';
     $smSalesKey = null;
     $smLocationId = $this->smLocationId;
     $smClubId = $this->smClubId;
     $smMemberId = $this->memberId;
     $smServiceKey = $this->smServiceKey;
     $smServiceQuantity = $this->smServiceQuantity;
     $smServiceName = $this->smServiceName;
     $smServicePrice = $this->smServicePrice;
     $smPurchaseDate = date("Y-m-d H:i:s");
     $internet = 'N';
     $endDate = '0000-00-00 00:00:00';
     $trans = 'N';
     $accountStatus = 'CU';

     $sql = "INSERT INTO schedular_member_sales VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
     $stmt = $dbMain->prepare($sql);
     $stmt->bind_param('iiiiiisdss', $smSalesKey, $smLocationId, $smClubId, $smMemberId, $smServiceKey, $smServiceQuantity, $smServiceName, $smServicePrice, $smPurchaseDate, $internet);
     if(!$stmt->execute())  {
    	printf("Error: %s.\n", $stmt->error);
       }else{
        $this->purchaseId = $stmt->insert_id; 
        $this->purchaseBit = 1;
       }
    $stmt->close();
   
   
    $serviceId = "";
    $sql = "INSERT INTO paid_full_services VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('iisiissisddddssiss', $serviceId, $this->contractKey, $groupType, $groupNumber, $serviceKey, $clubId, $serviceName, $serviceQuantity, $serviceTermReg, $unitPrice, $unitPrice, $groupPrice, $groupPrice, $smPurchaseDate, $endDate, $userId, $smPurchaseDate, $trans);
    //$stmt->execute();
    if(!$stmt->execute())  {
    	printf("Error: PIF %s.\n", $stmt->error);
       }		
       
    $this->statusId = $stmt->insert_id;
    $stmt->close(); 
    
    $sql = "INSERT INTO account_status VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('iiissid', $this->statusId, $this->contractKey, $serviceKey , $accountStatus, $smPurchaseDate, $clubId, $unitPrice);
    if(!$stmt->execute())  {
    	printf("Error: %s.\n", $stmt->error);
       }		
    
    $stmt->close(); 
   
    $sql = "INSERT INTO sales_info VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('iisisiiisissddsddissssssss', $salesKey, $locationId, $contractLocation, $userId, $groupType, $groupNumber, $clubId, $serviceKey, $serviceName, $serviceQuantity, $serviceTerm, $serviceType, $unitPrice, $groupPrice, $overidePin, $overideUnitPrice, $overideGroupPrice, $this->contractKey, $termType, $renewal, $upgrade, $internet, $saleDateTime, $amPm, $earlyRenewalBoon, $salesNew);
      if(!$stmt->execute())  {
    	printf("Error: %s.\n", $stmt->error);
       }		
    
    $stmt->close();    
}
//------------------------------------------------------------------------------------------------------

function getPurchaseId() {
        return($this->purchaseId);
        }
        
function getPurchaseBit() {
        return($this->purchaseBit);
        }        
        


}
//==========================================================
$ajax_switch = $_REQUEST['ajax_switch'];
$member_id = $_REQUEST['member_id'];
$service_key = $_REQUEST['service_key'];
$class_number = $_REQUEST['class_number'];
$service_cost = $_REQUEST['service_cost'];
$location = $_REQUEST['location'];
$contractKey = $_REQUEST['contractKey'];   
//$newNonMemBool = $_REQUEST['newNonMemBool'];              
                     
if($ajax_switch == 1) {

//$club_id = $_SESSION['location_id'];

$sale = new saveScheduleSale();
$sale-> setSmMemberId($member_id);
$sale-> setSmServiceKey($service_key);
$sale-> setSmServiceQuantity($class_number);
$sale-> setSmServicePrice($service_cost);
$sale-> setSmLocationId($location);
$sale-> setSmClubId($location);
$sale-> setContractKey($contractKey);
//$save-> setBool($newNonMemBool);
$sale-> saveSchedulerSale();
$purchase_id = $sale-> getPurchaseId();
$purchase_bit = $sale-> getPurchaseBit();

echo"$purchase_bit|$purchase_id";
exit;

}


?>

























