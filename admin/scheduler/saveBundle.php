<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this class formats the dropdown menu for clubs and facilities
class  saveBundle {

private  $locationId = null;
private  $bundleId = null;
private  $typeId = null;
private  $bundleStatus = null;
private  $serviceArray = null;
private  $serviceKey = null;


function setTypeId($typeId) {
        $this->typeId = $typeId;
        }

function setLocationId($locationId) {
        $this->locationId = $locationId;
         }
       
function setBundleId($bundleId) {
       $this->bundleId = $bundleId;
       } 
 
function setServiceArray($serviceArray) {
       $this->serviceArray = $serviceArray;
       }
       
 
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//--------------------------------------------------------------------------------------
function insertBundleList() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO bundle_lists VALUES (?, ?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiiii', $listId, $bundleId, $typeId, $locationId, $serviceKey);

$listId = null;
$bundleId = $this->bundleId;
$typeId = $this->typeId;
$locationId = $this->locationId;
$serviceKey = $this->serviceKey;

if(!$stmt->execute())  {
    // aver strange error her where it spits out a false error that report name can't be null but the var is saved
	printf("Error: %s. save name\n", $stmt->error);
   }else{
   $this->bundleStatus = 2;
   }

$stmt->close(); 

}
//--------------------------------------------------------------------------------------  
function saveBundleList() {

$serviceArray = explode(',', $this->serviceArray);

foreach ($serviceArray as $serviceKey) {      
              if($serviceKey != "") {
                   $this->serviceKey = $serviceKey;
                   $this->insertBundleList();
                }    
           }
}
//--------------------------------------------------------------------------------------
function getBundleStatus() {
         return($this->bundleStatus);
         }


}
//==================================================
$ajax_switch = $_REQUEST['ajax_switch'];
$schedule_type = $_REQUEST['schedule_type'];
$bundle_id = $_REQUEST['bundle_id'];
$location_id = $_REQUEST['location_id'];
$service_array = $_REQUEST['service_array'];
               
                     
if($ajax_switch == 1) {

  $save = new saveBundle();
  $save-> setTypeId($schedule_type);
  $save-> setLocationId($location_id);
  $save-> setBundleId($bundle_id);
  $save-> setServiceArray($service_array);
  $save-> saveBundleList();
  $bundle_status = $save-> getBundleStatus();
  
  echo"$bundle_status";
  exit;

  }


?>




