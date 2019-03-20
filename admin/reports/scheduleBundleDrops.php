<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  scheduleBundleDrops {

private  $clubId = null;
private  $scheduleType = null;
private  $bundleDrops = null;

function setClubId($clubId) {
       $this->clubId = $clubId;
       }
       
function setScheduleType($scheduleType) {
       $this->scheduleType = $scheduleType;
       }       

       
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//---------------------------------------------------------------------------------
function loadBundleDrops() {

if($this->scheduleType == 0) {
   $andSQL = "type_id != '' ";
   }else{
   $andSQL = "type_id='$this->scheduleType' ";
   }

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT bundle_id, bundle_name  FROM bundle_type WHERE location_id ='$this->clubId' AND $andSQL ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($categoryId, $category_name);
   $rowCount = $stmt->num_rows;
  
  if($rowCount > 0) {
  
      while ($stmt->fetch()) {                          
                  $retailCategories .= "<option value=\"$categoryId\">$category_name</option>\n";                 
               }
           
           if($rowCount == 1) {
              $dropHeader = "<option value>Select Class Name</option>\n"; 
              }else{
              $dropHeader = "<option value>Select Class Name</option>\n<option value=\"0\">All Class Types</option>\n";
              }
              
              $this->bundleDrops = "$dropHeader$retailCategories";
              
              
                           
    }else{    
    $this->bundleDrops = '0';
    }


}
//---------------------------------------------------------------------------------
function getBundleDrops() {
           return($this->bundleDrops);
           }




}
//---------------------------------------------------------------------------------

$ajax_switch = $_REQUEST['ajax_switch'];
$schedule_type = $_REQUEST['schedule_type'];
$club_id = $_REQUEST['club_id'];

if($ajax_switch == 1) {

$bundle = new scheduleBundleDrops();
$bundle-> setClubId($club_id);
$bundle-> setScheduleType($schedule_type);
$bundle-> loadBundleDrops();
$bundle_drops = $bundle-> getBundleDrops();

echo"$bundle_drops";
exit;


}