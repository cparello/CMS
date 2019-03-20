<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this class formats the dropdown menu for clubs and facilities
class  deleteBundle{

private  $typeId = null;
private  $bundleId = null;


function setTypeId($typeId) {
        $this->typeId = $typeId;
         }
         
function setBundleId($bundleId) {
        $this->bundleId = $bundleId;
        } 

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//-----------------------------------------------------------------------------------------------------
function deleteListings() {

 $dbMain = $this->dbconnect();
 $sql = "DELETE FROM bundle_lists WHERE type_id = ? AND bundle_id = ?";
		
		if ($stmt = $dbMain->prepare($sql))   {
			$stmt->bind_param("ii", $this->typeId, $this->bundleId);
			$stmt->execute();
			$stmt->close();
			$this->bundleStatus = 1;
           }else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql");
		   }

}
//-----------------------------------------------------------------------------------------------------
function deleteBundleType() {

 $dbMain = $this->dbconnect();
 $sql = "DELETE FROM bundle_type WHERE type_id = ? AND bundle_id = ? ";
		
		if ($stmt = $dbMain->prepare($sql))   {
			$stmt->bind_param("ii", $this->typeId, $this->bundleId);
			$stmt->execute();
			$stmt->close();
			$this->deleteListings();
			$this->bundleStatus = 1;
           }else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql");
		   }

}
//-----------------------------------------------------------------------------------------------------
function getBundleStatus() {
         return($this->bundleStatus);
         }

}
//==========================================================
$ajax_switch = $_REQUEST['ajax_switch'];
$schedule_type = $_REQUEST['schedule_type'];
$bundle_id = $_REQUEST['bundle_id'];



if($ajax_switch == "1") {

$delete = new deleteBundle();
$delete-> setTypeId($schedule_type);
$delete-> setBundleId($bundle_id);
$delete-> deleteBundleType();
$bundle_status = $delete-> getBundleStatus();

$bundle_status = 1;
echo"$bundle_status";
exit;

}



?>