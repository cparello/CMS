<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  scheduleCategoryDrops {

private  $clubId = null;
private  $scheduleDrops = null;

function setClubId($clubId) {
       $this->clubId = $clubId;
       }

       
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//---------------------------------------------------------------------------------
function loadScheduleDrops() {

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT type_id, type_name  FROM schedule_type WHERE location_id ='$this->clubId' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($categoryId, $category_name);
   $rowCount = $stmt->num_rows;
  
  if($rowCount > 0) {
  
      while ($stmt->fetch()) {                          
                  $retailCategories .= "<option value=\"$categoryId\">$category_name</option>\n";                 
               }
           
              $dropHeader = "<option value>Select Schedule Type</option>\n<option value=\"0\">All Schedule Types</option>\n"; 
              $this->scheduleDrops = "$dropHeader$retailCategories";
              
    }else{    
    $this->scheduleDrops = '0';
    }
  

}
//---------------------------------------------------------------------------------
function getScheduleDrops() {
           return($this->scheduleDrops);
           }




}
//---------------------------------------------------------------------------------
$ajax_switch = $_REQUEST['ajax_switch'];
$club_id = $_REQUEST['club_id'];

if($ajax_switch == 1) {

$schedule = new scheduleCategoryDrops();
$schedule-> setClubId($club_id);
$schedule-> loadScheduleDrops();
$schedule_drops = $schedule-> getScheduleDrops();

echo"$schedule_drops";
exit;


}