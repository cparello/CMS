<?php
session_start();
include"../../dbConnect.php";
include"loadStuff.php";
include"loadWebsitePreferences.php";
include "loadCart.php";

include "webLogCheck.php";
$logCheck = new loginCheck();
$logCheck-> setButtonColor($middleButtons);
$logCheck-> checkLogin();
$logHtml = $logCheck-> getLogHtml();

/*include "../schedule/scheduleTypeDrops.php";
$typeDrops = new scheduleTypeDrops();
$schedule_type_drops = $typeDrops-> loadMenu();

//$dbMain = $this->dbconnect();
//echo "test";
 $stmt = $dbMain ->prepare("SELECT type_id, type_name, location_id FROM schedule_type WHERE type_id != '' ");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($type_id, $type_name, $location_id); 
 $rowCount = $stmt->num_rows;

    while ($stmt->fetch()) { 
    
               if($location_id == "0") {
                  $serviceLocation = 'All Locations';
                  }else{
                     $stmt9 = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id = '$location_id'");
                     $stmt9->execute();      
                     $stmt9->store_result();      
                     $stmt9->bind_result($club_name); 
                     $stmt9->fetch();
                  }
                              
               $type_select .= "<option value=\"$type_id\">$type_name $serviceLocation</option>\n";         
            }
    
   
   $choose_type = "<option value>Choose Schedule Category</option>\n";
             
$schedule_type_drops = "$choose_type$type_select";        */    

/*include "../schedule/bundleTypeDrops.php";
$type_id = null;
$bundleDrops = new bundleTypeDrops();
$bundleDrops-> setTypeId($type_id);
$bundle_type_drops = $bundleDrops-> loadSelectedMenu();*/

$clubDrop = "";

$stmt = $dbMain ->prepare("SELECT club_name, club_id FROM club_info WHERE club_id != ''");
echo($dbMain->error);
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($clubName, $club_id); 
while($stmt->fetch()){
    $clubName = trim($clubName);
    $clubDrop .="<option value=\"$club_id\">$clubName</option>";
     }


for($i=1;$i<=30;$i++){
    $todayDay = date('d');
    $displayDate = date('F j Y',mktime(0,0,0,date('m'),$todayDay+$i,date('Y')));
    $date = date('Y-m-d',mktime(0,0,0,date('m'),$todayDay+$i,date('Y')));
    $day_select .= "<option value=\"$date\">$displayDate</option>\n"; 
}



include "webTemplates/scheduleVisitPageTemplate.php";
?>