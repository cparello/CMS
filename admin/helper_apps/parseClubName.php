<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  parseClubName {

private  $clubId = null;


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
 $stmt = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id = '$this->clubId'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($club_name); 
 $stmt->fetch();
 $stmt->close();
 
 $this->clubName = $club_name;

 }
//----------------------------------------------------------------------------------------------------
function getClubName() {
        return($this->clubName);
        }



}
//=================================================================

?>