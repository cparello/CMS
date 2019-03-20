<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this class formats the dropdown menu for clubs and facilities
class  clubDrops{

private  $clubId = null;
private  $serviceLocation;
private  $allSelect = null;

function setClubId($clubId) {
        $this->clubId = $clubId;
         }
 
function setServiceLocation($serviceLocation) {
        $this->serviceLocation = $serviceLocation;
        }
         
function setAllSelect($allSelect) {
        $this->allSelect = $allSelect;
        }


//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}


function loadMenu() {


if($this->clubId == null)  {
$choose_loc = "<option value>Choose Location</option>\n";
}else{
$choose_loc = "<option value=\"$this->clubId\" selected>$this->serviceLocation</option>\n";  
}

if($this->allSelect == null) {
$all_select = "<option value=\"0\">All</option>\n"; 
}

$dbMain = $this->dbconnect();
$clubId = $this->clubId; 

 $stmt = $dbMain ->prepare("SELECT club_id, club_name FROM club_info WHERE club_id != ''");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($club_id, $club_name);   

    while ($stmt->fetch()) {                  
               $product_select .= "<option value=\"$club_id\">$club_name</option>\n";         
            }
            
return "$choose_loc$all_select$product_select";            

}





}

?>