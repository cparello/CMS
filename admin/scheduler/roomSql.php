<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this class formats the dropdown menu for clubs and facilities
class  roomSql {

private  $typeId = null;
private  $roomName = null;
private  $roomId = null;
private  $deleteStatus = null;


function setTypeId($typeId) {
        $this->typeId = $typeId;
        }
        
function setRoomName($roomName) {
        $this->roomName = $roomName;
        }
        
function setRoomId($roomId) {
        $this->roomId = $roomId;
        }
 
 
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
} 
//------------------------------------------------------------------------------------------------------- 
function updateRoom() {

   $dbMain = $this->dbconnect();
   $sql = "UPDATE room_names SET room_name= ? WHERE room_id= '$this->roomId' ";
   $stmt = $dbMain->prepare($sql);
   $stmt->bind_param('s',  $roomName);
   
   $roomName = $this->roomName;
  
   if(!$stmt->execute())  {
      printf("Error: %s.\n", $stmt->error);
     }	
     
   $stmt->close(); 

}
//-------------------------------------------------------------------------------------------------------
function deleteRoom() {

 $dbMain = $this->dbconnect();
 $sql = "DELETE FROM room_names WHERE type_id = ? AND room_id = ?";
		
		if ($stmt = $dbMain->prepare($sql))   {
			$stmt->bind_param("ii", $this->typeId, $this->roomId);
			$stmt->execute();
			$stmt->close();
			$this->deleteStatus = 1;
           }else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql");
		   }


}
//-------------------------------------------------------------------------------------------------------
function getImageName() {
      return($this->imageName);
      }
 
function getDeleteStatus() {
      return($this->deleteStatus);
      }



 
}
//===============================================================







?>