<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this class formats the dropdown menu for clubs and facilities
class  editBundle2 {

private  $locationId = null;
private  $bundleId = null;
private  $typeId = null;
private  $bundleStatus = null;
private  $bundleName = null;
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

function setBundleName($bundleName) {
       $this->bundleName = $bundleName;
       }
 
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//--------------------------------------------------------------------------------------


//--------------------------------------------------------------------------------------
function updateBundleName() {
    
   $dbMain = $this->dbconnect();
   $sql = "UPDATE bundle_type SET bundle_name= ? WHERE type_id= '$this->typeId' AND bundle_id='$this->bundleId'";
   $stmt = $dbMain->prepare($sql);
   $stmt->bind_param('s',  $bundleName);
   
   $bundleName = $this->bundleName;
   
   if(!$stmt->execute())  {
      printf("Error: %s.\n", $stmt->error);
     }		
   $stmt->close(); 
   
   $this->bundleStatus = 1;
   

}
//--------------------------------------------------------------------------------------
function deleteListings() {

 $dbMain = $this->dbconnect();
 $sql = "DELETE FROM bundle_lists WHERE type_id = ? AND bundle_id = ? AND service_key = ?";
		
		if ($stmt = $dbMain->prepare($sql))   {
			$stmt->bind_param("iii", $this->typeId, $this->bundleId, $this->serviceKey);
			$stmt->execute();
			$stmt->close();
			$this->bundleStatus = 1;
           }else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql");
		   }
		   
}
//--------------------------------------------------------------------------------------  
function deleteBundleListings() {

$serviceArray = explode(',', $this->serviceArray);

foreach ($serviceArray as $serviceKey) {      
              if($serviceKey != "") {
                   $this->serviceKey = $serviceKey;
                   $this->deleteListings();
                }    
           }
}
//--------------------------------------------------------------------------------------
function getBundleStatus() {
         return($this->bundleStatus);
         }


}
$ajax_switch = $_REQUEST['ajax_switch'];
$schedule_type = $_REQUEST['schedule_type'];
$bundle_id = $_REQUEST['bundle_id'];
$bundle_name = $_REQUEST['bundle_name'];
$service_array = $_REQUEST['service_array'];

           
                     
//==================================================
if($ajax_switch == 1) {

  $edit1 = new editBundle2();
  $edit1-> setTypeId($schedule_type);
  $edit1-> setLocationId($location_id);
  $edit1-> setBundleId($bundle_id);
  $edit1-> setBundleName($bundle_name);
  $edit1-> updateBundleName();
  $bundle_status = $edit1-> getBundleStatus();
  
  echo"$bundle_status";
  exit;
  }
//-------------------------------------------------------------------
if($ajax_switch == 2) {

  $edit2 = new editBundle2();
  $edit2-> setTypeId($schedule_type);
  $edit2-> setLocationId($location_id);
  $edit2-> setBundleId($bundle_id);
  $edit2-> setServiceArray($service_array);
  $edit2-> deleteBundleListings();
  $bundle_status = $edit2-> getBundleStatus();

  echo"$bundle_status";
  exit;
}

?>




