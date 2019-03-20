<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this class formats the dropdown menu for clubs and facilities
class  clubDropsTwo{

private  $clubId = null;
private  $serviceLocation = null;
private  $allSelect = null;
private  $allAccess = null;
private  $internetAccess = null;

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

function setInternetAccess($internetAccess) {
        $this->internetAccess = $internetAccess;
        }      
        
        
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//------------------------------------------------------------------------------------------------------------
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
 
if($this->internetAccess != null) { 
 $internet_access = "<option value=\"I\">Internet</option>\n";
 }

$dbMain = $this->dbconnect();
$clubId = $this->clubId; 

 $stmt = $dbMain ->prepare("SELECT club_id, club_name FROM club_info WHERE club_id != ''");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($club_id, $club_name); 
 $rowCount = $stmt->num_rows;
 
 if($rowCount > 1) {
   $all_select = "<option value=\"0\">All Locations</option>\n"; 
   }
 

    while ($stmt->fetch()) {                  
               $product_select .= "<option value=\"$club_id\">$club_name</option>\n";         
            }


 

            
return "$choose_loc$all_select$all_access$internet_access$product_select";            

}

}
//--------------------------------------------------------------------------------
$ajax_switch = $_REQUEST['ajax_switch'];

if($ajax_switch == "1") {

$all_select =1;
$clubDrops = new clubDropsTwo();
$clubDrops-> setAllSelect($all_select);
$location_drop = $clubDrops-> loadMenu();

echo"$location_drop";
exit;


}



?>