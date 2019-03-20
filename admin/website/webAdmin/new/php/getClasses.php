<?php
session_start();


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
include "../../../../dbConnect.php";
return $dbMain;
}

//-----------------------------------------------------------------------------------------------------
function loadClubName() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id = '$this->clubId'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($club_name); 
 $rowCount = $stmt->num_rows;
 $stmt->fetch();
 
 $this->serviceLocation = $club_name;
 

}
//-----------------------------------------------------------------------------------------------------
function loadMenu() {
 //echo "test11 $this->clubId";
//exit;  
 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT type_name, type_id FROM schedule_type WHERE location_id = '$this->clubId' ");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($type_name, $type_id); 
 //$rowCount = $stmt->num_rows;

    while ($stmt->fetch()) { 
        
               $type_select .= "<option value=\"$type_id\">$type_name</option>\n";         
            }
    
   
  // $choose_type = "<option value>Choose Schedule Category</option>\n";
          
//return "$type_select";            
$this->typeMenu = $type_select;
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
          
            
   
   //$choose_type = "<option value>Choose Schedule Category</option>\n";
             
//return "$choose_type$type_select";         

//$this->typeMenu = $type_select;
}
//======================================================
function getMenu(){
    return($this->typeMenu);
}
}
//--------------------------------------------------------------------------------
$ajax_switch = $_REQUEST['ajax_switch'];
$clubId = $_REQUEST['clubId'];
//echo "test";
//exit;
if($ajax_switch == "1") {

$all_select =1;
$typeDrops = new scheduleTypeDrops();
$typeDrops-> setClubId($clubId);
$typeDrops-> loadMenu();
$schedule_type_drops = $typeDrops-> getMenu();

echo"$schedule_type_drops";
exit;


}



?>