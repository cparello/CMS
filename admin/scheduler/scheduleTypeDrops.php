<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this class formats the dropdown menu for clubs and facilities
class  scheduleTypeDrops{

private  $locationId = null;
private  $serviceLocation = null;
private  $typeId = null;
private  $clubId = null;


function setLocationId($locationId) {
        $this->locationId = $locationId;
         }
 
function setServiceLocation($serviceLocation) {
        $this->serviceLocation = $serviceLocation;
        }
             
function setClubId($clubId) {
        $this->clubId = $clubId;
         }

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//-----------------------------------------------------------------------------------------------------
function loadClubName() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id = '$this->locationId'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($club_name); 
 $rowCount = $stmt->num_rows;
 $stmt->fetch();
 
 $this->serviceLocation = $club_name;
 

}
//-----------------------------------------------------------------------------------------------------
function loadMenu() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT type_id, type_name, location_id FROM schedule_type WHERE type_id != '' ");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($type_id, $type_name, $location_id); 
 $rowCount = $stmt->num_rows;

    while ($stmt->fetch()) { 
    
             $this->locationId = $location_id;
    
               if($this->locationId == "0") {
                  $this->serviceLocation = 'All Locations';
                  }else{
                  $this->loadClubName();
                  }
                              
               $type_select .= "<option value=\"$type_id\">$type_name $this->serviceLocation</option>\n";         
            }
    
   
   $choose_type = "<option value>Choose Schedule Category</option>\n";
             
return "$choose_type$type_select";            

}
//-------------------------------------------------------------------------------------------------
function loadSelectedMenu() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT type_id, type_name, location_id FROM schedule_type WHERE location_id = '$this->clubId' OR location_id ='0' ORDER BY location_id DESC ");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($type_id, $type_name, $location_id); 
 $rowCount = $stmt->num_rows;

    while ($stmt->fetch()) { 
    
             $this->locationId = $location_id;
    
               if($this->locationId == "0") {
                  $this->serviceLocation = 'All Locations';
                  }else{
                  $this->loadClubName();
                  }
                              
               $type_select .= "<option value=\"$type_id,$this->locationId\">$type_name $this->serviceLocation</option>\n";         
            }
          
            
   
   $choose_type = "<option value>Choose Schedule Category</option>\n";
             
return "$choose_type$type_select";         


}
//======================================================
}
//--------------------------------------------------------------------------------
$ajax_switch = $_REQUEST['ajax_switch'];

if($ajax_switch == "1") {

$all_select =1;
$typeDrops = new scheduleTypeDrops();
$schedule_type_drops = $typeDrops-> loadMenu();

echo"$schedule_type_drops";
exit;


}



?>