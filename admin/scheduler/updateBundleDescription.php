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
function loadBundleDescription() {
    
$dbMain = $this->dbconnect();

 $stmt = $dbMain ->prepare("SELECT bundle_description FROM bundle_description WHERE bundle_id = '$this->bundleId' ");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($this->bundleDescription); 
 $stmt->fetch();
 $stmt->close();


}
//--------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------  
function updateBundleDescription() {
    
$dbMain = $this->dbconnect();

$dbMain = $this->dbconnect();
$sql = "UPDATE bundle_description SET bundle_description = ? WHERE bundle_id ='$this->bundleId'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('s' , $this->bundleDescription);
$stmt->execute();
$stmt->close();
}
//--------------------------------------------------------------------------------------
function getBundleDescription() {
         return($this->bundleDescription);
         }
}
//==================================================
$ajax_switch = $_REQUEST['ajax_switch'];
$bundle_id = $_REQUEST['bundle_id'];
$bundle_description = $_REQUEST['bundleDescription'];
//echo "$bundle_description  $bundle_id"; 
//exit;
                     
if($ajax_switch == 1) {

  $save = new saveBundle();
  $save-> setBundleDescription($bundle_description);
  $save-> setBundleId($bundle_id);
  $save-> updateBundleDescription();
  
  echo"2";
  exit;

  }

if($ajax_switch == 2) {
$bundle_id = $_REQUEST['bunId'];
//echo"$bundle_id";
//exit;
  $save = new saveBundle();
  $save-> setBundleId($bundle_id);
  $save-> loadBundleDescription();
  $bundle_description = $save-> getBundleDescription();
  
  echo"1|$bundle_description";
  exit;

  }

?>




