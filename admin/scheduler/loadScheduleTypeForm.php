<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this class formats the dropdown menu for clubs and facilities
class  loadScheduleTypeForm{

private  $locationId = null;
private  $typeName = null;
private  $typeDescription = null;
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
function loadScheduleVars() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT type_name, location_id, type_description FROM schedule_type WHERE type_id = '$this->typeId' ");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($type_name, $location_id, $type_description); 
 $rowCount = $stmt->num_rows;
 $stmt->fetch();
    
 $this->typeName = $type_name;
 $this->locationId = $location_id;
 $this->typeDescription =  $type_description; 
           
}
//----------------------------------------------------------------------------------------
function getTypeName() {
     return($this->typeName);
     }

function getTypeDescription() {
     return($this->typeDescription);
     }
    
function getLocationId() {
     return($this->locationId);
     }
//======================================================
}
//--------------------------------------------------------------------------------



?>