<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this class formats the dropdown menu for clubs and facilities
class  deleteScheduleType{

private  $typeId = null;


function setTypeId($typeId) {
        $this->typeId = $typeId;
         }
 

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//-----------------------------------------------------------------------------------------------------
function deleteServices() {

//this will eventually delete from the table of services associated with this schedule type
 $dbMain = $this->dbconnect();
 
 $sql1 = "DELETE FROM bundle_lists WHERE type_id = ?";		
		if ($stmt1 = $dbMain->prepare($sql1))   {
			$stmt1->bind_param("i", $this->typeId);
			$stmt1->execute();
			$stmt1->close();
           }else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql1");
		   }

 $sql2 = "DELETE FROM bundle_type WHERE type_id = ?";		
		if ($stmt2 = $dbMain->prepare($sql2))   {
			$stmt2->bind_param("i", $this->typeId);
			$stmt2->execute();
			$stmt2->close();
           }else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql2");
		   }


}
//-----------------------------------------------------------------------------------------------------
function deleteType() {

 $dbMain = $this->dbconnect();
 $sql = "DELETE FROM schedule_type WHERE type_id = ?";
		
		if ($stmt = $dbMain->prepare($sql))   {
			$stmt->bind_param("i", $this->typeId);
			$stmt->execute();
			$stmt->close();
			$this->deleteServices();
			$typeSuccess = 1;
			return "$typeSuccess";
           }else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql");
		   }

}
//-----------------------------------------------------------------------------------------------------


}
//==========================================================
if($ajax_switch == "1") {

$delete = new deleteScheduleType();
$delete-> setTypeId($schedule_type);
$type_success = $delete-> deleteType();

     if($type_success == 1)  {   
         include "scheduleTypeDrops.php";
         $typeDrops = new scheduleTypeDrops();
         $schedule_type_drops = $typeDrops-> loadMenu();
         $drop_array = "$schedule_type_drops";
         echo"$drop_array";
         exit;
      }

}



?>