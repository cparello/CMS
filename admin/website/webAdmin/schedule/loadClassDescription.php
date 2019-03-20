<?php
session_start();

//this class formats the dropdown menu for clubs and facilities
class  bundleTypeDrops{

private  $locationId = null;
private  $bundleId = null;
private  $typeId = null;
private  $bundleName = null;
private  $rowCount = null;
private  $headerType = null;


function setBundleId($bunId) {
        $this->bundleId = $bunId;
         }
function  setTypeId($typeId) {
        $this->TypeId = $typeId;
         }


//connect to database
function dbconnect()   {
require"../../../dbConnect.php";
return $dbMain;
}


//-----------------------------------------------------------------------------------------------------
function loadDescription() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT bundle_description FROM bundle_description WHERE bundle_id = '$this->bundleId'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($this->bundleDescription); 
 $stmt->fetch();
 $stmt->close();
 
 $stmt = $dbMain ->prepare("SELECT bundle_name, type_id FROM bundle_type WHERE bundle_id = '$this->bundleId'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($this->bundleName, $typeId); 
 $stmt->fetch();
 $stmt->close();
 
 $stmt = $dbMain ->prepare("SELECT type_name FROM schedule_type WHERE type_id = '$typeId'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($this->typeName); 
 $stmt->fetch();
 $stmt->close();
 
 
}
//-----------------------------------------------------------------------------------------------------
function loadDescriptionList() {
$this->bundleList = "";
 $dbMain = $this->dbconnect();
 
 $stmt = $dbMain ->prepare("SELECT type_name FROM schedule_type WHERE type_id = '$this->TypeId'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($this->typeName); 
 $stmt->fetch();
 $stmt->close();
 
 $stmt = $dbMain ->prepare("SELECT bundle_name, bundle_id FROM bundle_type WHERE type_id = '$this->TypeId'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($bundleName, $bundle_id); 
 while($stmt->fetch()){
    $stmt9 = $dbMain ->prepare("SELECT bundle_description FROM bundle_description WHERE bundle_id = '$bundle_id'");
     $stmt9->execute();      
     $stmt9->store_result();      
     $stmt9->bind_result($bundleDescription); 
     $stmt9->fetch();
     $stmt9->close();
     
     $this->bundleList .= "$bundleName,$bundleDescription,$bundle_id@";
     $bundleName = "";
     $bundle_id = "";
     $bundleDescription = "";
 }
 $stmt->close();
 
 
 
 
}
//-----------------------------------------------------------------------------------------------------------
function getDescription() {
         return($this->bundleDescription);
         }
function getName() {
         return($this->bundleName);
         }
function getCategoryName() {
         return($this->typeName);
         }         
         
function getBundleList() {
         return($this->bundleList);
         }

}
//======================================================
$ajax_switch = $_REQUEST['ajax_switch'];
$bunId = $_REQUEST['bunId'];
$typeId = $_REQUEST['typeId'];
//echo "id $bunId";
//exit;
if($ajax_switch == "1") {
//echo "$schedule_type";
//exit;
$bundleDrops = new bundleTypeDrops();
$bundleDrops-> setBundleId($bunId);
$bundleDrops-> loadDescription();
$description = $bundleDrops-> getDescription();
$name = $bundleDrops-> getName();
$catName = $bundleDrops-> getCategoryName();

$bundle_type_drops = "1|$description|$name|$catName"; 
   
   
echo"$bundle_type_drops";
exit;

}

if($ajax_switch == "2") {
//echo "$schedule_type";
//exit;
$bundleDrops = new bundleTypeDrops();
$bundleDrops-> setTypeId($typeId);
$bundleDrops-> loadDescriptionList();
$description = $bundleDrops-> getDescription();
$catName = $bundleDrops-> getCategoryName();
$names = $bundleDrops-> getBundleList();

$bundle_type_drops = "2|$names|$catName"; 
   
   
echo"$bundle_type_drops";
exit;

}
//-------------------------------------------------------------------------------










?>