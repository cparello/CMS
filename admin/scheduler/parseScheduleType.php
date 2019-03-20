<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this class formats the dropdown menu for clubs and facilities
class  parseScheduleType{

private $typeId = null;
private $typeName = null;
private $typeDescription = null;
private $serviceLocation = null;
private $typeStatus = null;


function setServiceLocation($serviceLocation) {
        $this->serviceLocation = $serviceLocation;
        }

function setTypeName($typeName) {
        $this->typeName = $typeName;
        }

function setTypeDescription($typeDescription) {
        $this->typeDescription = $typeDescription;
        }

function setTypeId($typeId) {
        $this->typeId = $typeId;
        }
        
        
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//------------------------------------------------------------------------------
function saveScheduleType() {

  $this->checkScheduleType();  
  
if($this->typeStatus == null) {

    $dbMain = $this->dbconnect();
    $sql = "INSERT INTO schedule_type VALUES (?,?,?,?)";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('isis', $typeId, $typeName, $locationId, $typeDescription);

    $typeId = null;
    $typeName = $this->typeName;
    $locationId = $this->serviceLocation;
    $typeDescription = $this->typeDescription;

   if(!$stmt->execute())  {
   	  printf("Error: %s.\n", $stmt->error);
     }		

    $stmt->close(); 
  
    $this->typeStatus = "2|$this->typeName";   
   }



}
//-----------------------------------------------------------------------------
function updateScheduleType() {

  $this->checkScheduleType();
    
if($this->typeStatus == null) {  
   $dbMain = $this->dbconnect();
   $sql = "UPDATE schedule_type SET type_name= ?, location_id=?, type_description=? WHERE type_id= '$this->typeId' ";
   $stmt = $dbMain->prepare($sql);
   $stmt->bind_param('sis',  $typeName, $locationId, $typeDescription);
   
   $typeName = $this->typeName;
   $locationId = $this->serviceLocation;
   $typeDescription =  $this->typeDescription;
   
   if(!$stmt->execute())  {
      printf("Error: %s.\n", $stmt->error);
     }		
   $stmt->close(); 
   
   $this->typeStatus = "2|$this->typeName";
   }
}
//-----------------------------------------------------------------------------
function checkScheduleType() {

if($this->typeId == null) {
   $andSQL = "";
   }else{
   $andSQL = "AND type_id != '$this->typeId'";
   }
   
$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) AS count FROM schedule_type WHERE type_name= '$this->typeName'  AND location_id= '$this->serviceLocation'  $andSQL");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count); 
$stmt->fetch();

    if($count > 0) {
       $this->typeStatus = "1|$this->typeName";
       }else{
       $this->typeStatus = null;
       }
 $stmt->close();
 
}
//-----------------------------------------------------------------------------
function getTypeStatus() {
    return($this->typeStatus);
    }




}
//=================================
$ajax_switch = $_REQUEST['ajax_switch'];
$type_name = $_REQUEST['type_name'];
$service_location = $_REQUEST['service_location'];
$type_description = $_REQUEST['type_description'];
$type_id = $_REQUEST['type_id'];

if($ajax_switch == "1") {

$type_name = preg_replace("/[[:blank:]]+/"," ",$type_name);

$saveType = new parseScheduleType();
$saveType-> setServiceLocation($service_location);
$saveType-> setTypeName($type_name);
$saveType-> setTypeDescription($type_description);
$saveType-> saveScheduleType();

$type_status = $saveType-> getTypeStatus();

echo"$type_status";
exit;

}
//------------------------------------------------------------
if($ajax_switch == "2") {

$type_name = preg_replace("/[[:blank:]]+/"," ",$type_name);

$updateType = new parseScheduleType();
$updateType-> setServiceLocation($service_location);
$updateType-> setTypeName($type_name);
$updateType-> setTypeDescription($type_description);
$updateType-> setTypeId($type_id);
$updateType-> updateScheduleType();

$type_status = $updateType-> getTypeStatus();

echo"$type_status";
exit;

}


