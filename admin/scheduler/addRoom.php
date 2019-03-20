<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this class formats the dropdown menu for clubs and facilities
class  addRoom {

private  $typeId = null;
private  $roomName = null;
private  $roomBit = null;


function setTypeId($typeId) {
        $this->typeId = $typeId;
        }
        
function setRoomName($roomName) {
        $this->roomName = $roomName;
        }
 
 
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
} 
//------------------------------------------------------------------------------------------------------- 
function checkRoomName() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) AS count FROM room_names WHERE room_name= '$this->roomName'  AND type_id= '$this->typeId' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count); 
$stmt->fetch();

if($count > 0) {
  $this->roomBit = 1;
  }else{
  $this->roomBit = null;
  }


}
//-------------------------------------------------------------------------------------------------------
 function addRoomName() {
  
     $this->checkRoomName();
  
if($this->roomBit == null) {

    $dbMain = $this->dbconnect();
    $sql = "INSERT INTO room_names VALUES (?, ?, ?)";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('iis', $roomId, $typeId, $roomName);

    $roomId = null;    
    $typeId = $this->typeId;
    $roomName = $this->roomName;

      if(!$stmt->execute())  {
          // aver strange error her where it spits out a false error that report name can't be null but the var is saved
          printf("Error: %s. save name\n", $stmt->error);
        }
        
   $this->roomBit = 2;    
   $stmt->close(); 
   
  }    

 }
//-------------------------------------------------------------------------------------------------------
function getRoomBit() {
      return($this->roomBit);
      }
 
 
}
//===============================================================
$ajax_switch = $_REQUEST['ajax_switch'];
$room_name = $_REQUEST['room_name'];
$schedule_type = $_REQUEST['schedule_type'];

if($ajax_switch == 1) {

$room_name = preg_replace("/[[:blank:]]+/"," ",$room_name);

$saveName = new addRoom();
$saveName-> setTypeId($schedule_type);
$saveName-> setRoomName($room_name);
$saveName-> addRoomName();
$room_bit = $saveName-> getRoomBit();

echo"$room_bit";
exit;

 }






?>