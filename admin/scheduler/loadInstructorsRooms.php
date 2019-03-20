<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this class formats the dropdown menu for clubs and facilities
class  loadInstructorsRooms {

private  $typeId = null;
private  $instructorName = null;
private  $instructorId = null;
private  $roomName = null;
private  $roomId = null;
private  $instructorDrops = null;
private  $roomDrops = null;
private  $rowCountOne = null;
private  $rowCountTwo = null;


function setTypeId($typeId) {
        $this->typeId = $typeId;
        }


//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//-----------------------------------------------------------------------------------------------------
function loadInstructorMenu() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT instructor_id, instructor_name FROM instructor_info WHERE type_id = '$this->typeId' ");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($instructor_id, $instructor_name); 
 $rowCount = $stmt->num_rows;

 $this->rowCountOne = $rowCount;

if($rowCount > 0) {

    while ($stmt->fetch()) { 
    
               $type_select .= "<option value=\"$instructor_id\">$instructor_name</option>\n";         
            }

    }    
  
$stmt->close();
$choose_type = "<option value>Select Instructor</option>\n";
            
$this->instructorDrops = "$choose_type$type_select";            
  
}
//-----------------------------------------------------------------------------------------------------
function loadRoomMenu() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT room_id, room_name FROM room_names WHERE type_id = '$this->typeId' ");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($room_id, $room_name); 
 $rowCount = $stmt->num_rows;

 $this->rowCountTwo = $rowCount;

    if($rowCount > 0) {

       while ($stmt->fetch()) { 
                                    
               $type_select .= "<option value=\"$room_id\">$room_name</option>\n";         
            }

       }  
       
 $stmt->close();
 $choose_type = "<option value>Select Room</option>\n";
             
 $this->roomDrops = "$choose_type$type_select";            

}
//-----------------------------------------------------------------------------------------------------------
function getRowCountOne() {
         return($this->rowCountOne);
         }
         
function getRowCountTwo() {
         return($this->rowCountTwo);
         }     
         
function getInstructorDrops() {
         return($this->instructorDrops);
         }     
         
function getRoomDrops() {
         return($this->roomDrops);
         }               

}
//======================================================
$ajax_switch = $_REQUEST['ajax_switch'];
$schedule_type = $_REQUEST['schedule_type'];

if($ajax_switch == "1") {

$irDrops = new loadInstructorsRooms();
$irDrops-> setTypeId($schedule_type);
$irDrops-> loadInstructorMenu();
$irDrops-> loadRoomMenu();
$row_count1 = $irDrops-> getRowCountOne();
$row_count2 = $irDrops-> getRowCountTwo();

if($row_count1 == 0 || $row_count2 == 0) {
   $type_drops  = "1|bull|bull";
   }else{
   $instructor_drops = $irDrops-> getInstructorDrops();
   $room_drops = $irDrops-> getRoomDrops();
   $type_drops = "2|$instructor_drops|$room_drops"; 
   }
   
echo"$type_drops";
exit;

}
//-------------------------------------------------------------------------------











?>