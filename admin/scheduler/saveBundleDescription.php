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


function setBundleId($bundleId) {
       $this->bundleId = $bundleId;
       } 
 
function setBundleDescription($bundle_description) {
       $this->bundleDescription = $bundle_description;
       }
       
 
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//--------------------------------------------------------------------------------------  
function saveBundleDescription() {
    
$dbMain = $this->dbconnect();

$sql = "INSERT INTO bundle_description VALUES (?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('is', $this->bundleId, $this->bundleDescription);
if(!$stmt->execute())  {
    // aver strange error her where it spits out a false error that report name can't be null but the var is saved
	printf("Error: %s. save bundle description\n", $stmt->error);
   }else{
   $this->bundleStatus = 2;
   }

$stmt->close(); 


}
//--------------------------------------------------------------------------------------
function getBundleStatus() {
         return($this->bundleStatus);
         }


}
//==================================================
$ajax_switch = $_REQUEST['ajax_switch'];
$bundle_id = $_REQUEST['bundle_id'];
$bundle_description = $_REQUEST['bundleDescription'];
//echo $bundle_description; 
//exit;
                     
if($ajax_switch == 1) {

  $save = new saveBundle();
  $save-> setBundleDescription($bundle_description);
  $save-> setBundleId($bundle_id);
  $save-> saveBundleDescription();
  $bundle_status = $save-> getBundleStatus();
  
  echo"$bundle_status";
  exit;

  }


?>




