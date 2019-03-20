<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  typeDrops {

private  $clubId = null;
private  $typeDrops = null;
private  $allSelect = null;
private  $groupType = null;
private  $paidFull = null;
private  $monthy = null;
private  $serviceKey = null;


function setClubId($clubId) {
       $this->clubId = $clubId;
       }

function setGroupType($groupType) {
       $this->groupType = $groupType;
       }
       
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//---------------------------------------------------------------------------------
function loadServiceTypes() {

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT DISTINCT service_term  FROM service_cost WHERE service_key='$this->serviceKey' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($serviceTerm);

  while ($stmt->fetch()) {
  
     switch ($serviceTerm) {
        case "C":
        $typeNameFull = 'Paid In Full Accounts';
        $this->paidFull = "<option value=\"P\">Paid In Full Accounts</option>\n";
        break;
        case "D":
        $typeNameFull = 'Paid In Full Accounts';
        $this->paidFull = "<option value=\"P\">Paid In Full Accounts</option>\n";
        break;        
        case "W":
        $typeNameFull = 'Paid In Full Accounts';
        $this->paidFull = "<option value=\"P\">Paid In Full Accounts</option>\n"; 
        break;        
        case "M":
        $typeNameMonth = 'Monthly Accounts';
        $this->monthly = "<option value=\"E\">Monthly Accounts</option>\n";
        break;  
        case "Y":
        $typeNameFull = 'Paid In Full Accounts';
        $this->paidFull = "<option value=\"P\">Paid In Full Accounts</option>\n";
        break;             
       }
  
  
  }
   
 
}
//---------------------------------------------------------------------------------
function loadTypeDrops() {

if(($this->clubId == '0') || ($this->clubId == 'I')) {
  $sqlClub = "club_id != ''";
  }else{
  $sqlClub = "club_id = '$this->clubId'";
  }

if($this->groupType == '0') {
  $sqlGroup = "group_type != ''";
  }else{
  $sqlGroup = "group_type = '$this->groupType'";
  }

  $sqlWhere = "$sqlGroup AND $sqlClub";

 
$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT DISTINCT service_key  FROM service_info WHERE $sqlWhere ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($serviceKey);
   $rowCount = $stmt->num_rows;
  
   while ($stmt->fetch()) {
           $this->serviceKey = $serviceKey;
           $this->loadServiceTypes();
      
           }
           
$dropHeader = "<option value>Select Service Type</option>\n"; 

   if($this->paidFull != null && $this->monthly != null) {   
      $this->allSelect = "<option value=\"0\">All Service Types</option>\n";
     }    


$this->typeDrops = "$dropHeader$this->allSelect$this->monthly$this->paidFull";


}
//---------------------------------------------------------------------------------
function getTypeDrops() {
           return($this->typeDrops);
           }




}
//---------------------------------------------------------------------------------
$ajax_switch = $_REQUEST['ajax_switch'];
$club_id = $_REQUEST['club_id'];
$group_type = $_REQUEST['group_type'];


if($ajax_switch == 1) {

$type = new typeDrops();
$type-> setClubId($club_id);
$type-> setGroupType($group_type);
$type-> loadTypeDrops();
$type_drops = $type-> getTypeDrops();

echo"$type_drops";
exit;


}