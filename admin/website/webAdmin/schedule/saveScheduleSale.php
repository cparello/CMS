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
        $this->smMemberId = $smMemberId;
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
        
        
//connect to database
function dbconnect()   {
require"../../../dbConnect.php";
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

   $sql = "INSERT INTO schedular_member_sales VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
   $stmt = $dbMain->prepare($sql);
   $stmt->bind_param('iiiiiisdss', $smSalesKey, $smLocationId, $smClubId, $smMemberId, $smServiceKey, $smServiceQuantity, $smServiceName, $smServicePrice, $smPurchaseDate, $internet);
  
   $smSalesKey = null;
   $smLocationId = $this->smLocationId;
   $smClubId = $this->smClubId;
   $smMemberId = $this->smMemberId;
   $smServiceKey = $this->smServiceKey;
   $smServiceQuantity = $this->smServiceQuantity;
   $smServiceName = $this->smServiceName;
   $smServicePrice = $this->smServicePrice;
   $smPurchaseDate = date("Y-m-d H:i:s");
   $internet = 'N';
  
     if(!$stmt->execute())  {
    	printf("Error: %s.\n", $stmt->error);
       }else{
        $this->purchaseId = $stmt->insert_id; 
        $this->purchaseBit = 1;
       }

   $stmt->close();
   
   

$sql = "INSERT INTO sales_info VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iisisiiisissddsddissssssss', $salesKey, $locationId, $contractLocation, $userId, $groupType, $groupNumber, $clubId, $serviceKey, $serviceName, $serviceQuantity, $serviceTerm, $serviceType, $unitPrice, $groupPrice, $overidePin, $overideUnitPrice, $overideGroupPrice, $contractKey, $termType, $renewal, $upgrade, $internet, $saleDateTime, $amPm, $earlyRenewalBoon, $salesNew);
 
   
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
 $serviceType = 'P';
 $unitPrice = $this->smServicePrice;
 $groupPrice = $this->smServicePrice;
 $overidePin = 'N'; 
 $overideUnitPrice = $this->smServicePrice;
 $overideGroupPrice = $this->smServicePrice;
 $contractKey = 0;
 $termType = 'T';
 $renewal = 'N';
 $upgrade = 'N'; 
 $internet = 'N'; 
 $saleDateTime = date("Y-m-d H:i:s");
 $amPm =  date("a");
 $earlyRenewalBoon = 'N'; 
 $salesNew = 'Y'; 
 
   
  if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

$stmt->close();    
   
   
/*   
 sales_key           | int(11)                                  | NO   | PRI | NULL    | auto_increment |
| location_id         | int(10)                                  | NO   |     | NULL    |                |
| contract_location   | char(30)                                 | NO   |     | NULL    |                |
| user_id             | int(10)                                  | NO   |     | NULL    |                |
| group_type          | enum('S','F','B','O')                    | NO   |     | NULL    |                |
| group_number        | int(10)                                  | NO   |     | NULL    |                |
| club_id             | int(10)                                  | NO   |     | NULL    |                |
| service_key         | int(10)                                  | NO   |     | NULL    |                |
| service_name        | char(60)                                 | NO   |     | NULL    |                |
| service_quantity    | int(10)                                  | NO   |     | NULL    |                |
| service_term        | enum('C','D','W','M','Y','PF','PM','SC') | NO   |     | NULL    |                |
| service_type        | enum('E','P')                            | NO   |     | NULL    |                |
| unit_price          | decimal(10,2)                            | NO   |     | NULL    |                |
| group_price         | decimal(10,2)                            | NO   |     | NULL    |                |
| overide_pin         | enum('Y','N')                            | NO   |     | NULL    |                |
| overide_unit_price  | decimal(10,2)                            | NO   |     | NULL    |                |
| overide_group_price | decimal(10,2)                            | NO   |     | NULL    |                |
| contract_key        | int(20)                                  | NO   |     | NULL    |                |
| term_type           | enum('T','O')                            | NO   |     | NULL    |                |
| renewal             | enum('Y','N')                            | YES  |     | NULL    |                |
| upgrade             | enum('Y','N')                            | YES  |     | NULL    |                |
| internet            | enum('Y','N')                            | YES  |     | NULL    |                |
| sale_date_time      | datetime                                 | NO   |     | NULL    |                |
| am_pm               | char(2)                                  | NO   |     | NULL    |                |
| early_renewal       | enum('Y','N')                            | NO   |     | NULL    |                |
| new_sale            | enum('Y','N')                            | NO   |     | NULL    |                |
  
   
 sm_sales_key  INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
sm_location_id INT(20) NOT NULL,
sm_club_id INT(20) NOT NULL,
sm_member_id INT(20) NOT NULL,
sm_service_key INT(10) NOT NULL,
sm_service_quantity INT(10) NOT NULL,
sm_service_name CHAR(60) NOT NULL,
sm_service_price DECIMAL(10,2) NOT NULL,
sm_purchase_date DATETIME NOT NULL
*/
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
               
                     
if($ajax_switch == 1) {

$club_id = $_SESSION['location_id'];

$sale = new saveScheduleSale();
$sale-> setSmMemberId($member_id);
$sale-> setSmServiceKey($service_key);
$sale-> setSmServiceQuantity($class_number);
$sale-> setSmServicePrice($service_cost);
$sale-> setSmLocationId($location);
$sale-> setSmClubId($club_id);
$sale-> saveSchedulerSale();
$purchase_id = $sale-> getPurchaseId();
$purchase_bit = $sale-> getPurchaseBit();

echo"$purchase_bit|$purchase_id";
exit;

}


?>

























