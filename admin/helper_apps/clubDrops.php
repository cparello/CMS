<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this class formats the dropdown menu for clubs and facilities
class  clubDrops{

private  $clubId = null;
private  $serviceLocation = null;
private  $allSelect = null;
private  $allAccess = null;

function setClubId($clubId) {
        $this->clubId = $clubId;
         }
 
function setServiceLocation($serviceLocation) {
        $this->serviceLocation = $serviceLocation;
        }
         
function setAllSelect($allSelect) {
        $this->allSelect = $allSelect;
        }
        
function setAllAccess($allAccess) {
        $this->allAccess = $allAccess;
        }        


//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//---------------------------------------------------------------------------------------------------------------------------------------
function loadMenu() {

if($this->clubId == null)  {
$choose_loc = "<option value>Choose Location</option>\n";
}else{
$choose_loc = "<option value=\"$this->clubId\" selected>$this->serviceLocation</option>\n";  
}

if($this->allSelect == null) {
$all_select = "<option value=\"0\">All Locations</option>\n"; 
}

if($this->allAccess != null) {
  $all_access = "<option value=\"1\">All Access</option>\n"; 

 }

$dbMain = $this->dbconnect();

 $stmt = $dbMain ->prepare("SELECT club_id, club_name FROM club_info WHERE club_id != ''");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($club_id, $club_name); 
 $rowCount = $stmt->num_rows;
 
 if($rowCount > 1) {
   $all_select = "<option value=\"0\">All Locations</option>\n"; 
   }
 

    while ($stmt->fetch()) {                  
               
               $type_select .= "<option value=\"$club_id\">$club_name</option>\n";   
                              
            }
            
return "$choose_loc$all_select$all_access$type_select";            

}
//---------------------------------------------------------------------------------------
function loadSelectedMenu() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT club_id, club_name FROM club_info WHERE club_id != ''");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($club_id, $club_name); 
 $rowCount = $stmt->num_rows;

    while ($stmt->fetch()) { 
    
             if($this->clubId == $club_id) {
                $selected = 'selected';
                }else{
                $selected = "";
                }
    
               $type_select .= "<option value=\"$club_id\" $selected>$club_name</option>\n";                                 
              }

  if($this->clubId == 0) {
     $all_select = "<option value=\"0\" selected>All Locations</option>\n"; 
     }else{
     $all_select = "<option value=\"0\">All Locations</option>\n";
     }

return "$all_select$type_select";  


}
//---------------------------------------------------------------------------------------
}
//--------------------------------------------------------------------------------
if($ajax_switch == "1") {

$all_select =1;
$clubDrops = new clubDrops();
$clubDrops-> setAllSelect($all_select);
$location_drop = $clubDrops-> loadMenu();

echo"$location_drop";
exit;


}



?>