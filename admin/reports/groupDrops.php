<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  groupDrops {

private  $clubId = null;
private  $groupDrops = null;
private  $allSelect = null;


function setClubId($clubId) {
       $this->clubId = $clubId;
       }


//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//---------------------------------------------------------------------------------
function loadGroupDrops() {

if(($this->clubId == '0') || ($this->clubId == 'I')) {
  $sqlWhere = "club_id != ''";
  }else{
  $sqlWhere = "club_id = '$this->clubId'";
  }

  $dropHeader = "<option value>Select Group Type</option>\n";


$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT DISTINCT group_type FROM service_info WHERE $sqlWhere ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($groupType);
   $rowCount = $stmt->num_rows;
   
   if($rowCount > 1) {   
      $allSelect = "<option value=\"0\">All Groups</option>\n";
     }    
   
   while ($stmt->fetch()) {
   
   switch ($groupType) {
        case "S":
        $groupName = 'Single';
        break;
        case "F":
        $groupName = 'Family';
        break;        
        case "B":
        $groupName = 'Business';
        break;        
        case "O":
        $groupName = 'Organization';
        break;        
       }
   
   
   $groupDrops .= "<option value=\"$groupType\">$groupName</option>\n";
   
   
   
   }
  

$this->groupDrops = "$dropHeader$allSelect$groupDrops";


}
//---------------------------------------------------------------------------------
function getGroupDrops() {
           return($this->groupDrops);
           }




}
//---------------------------------------------------------------------------------
$ajax_switch = $_REQUEST['ajax_switch'];
$club_id = $_REQUEST['club_id'];

if($ajax_switch == 1) {

$group = new groupDrops();
$group-> setClubId($club_id);
$group-> loadGroupDrops();
$group_drops = $group-> getGroupDrops();

echo"$group_drops";
exit;


}