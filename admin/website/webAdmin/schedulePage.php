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

$class_date = date("m/d/Y");

/*include "schedule/scheduleTypeDrops.php";
$typeDrops = new scheduleTypeDrops();
$typeDrops-> setClubId($location_id);
$schedule_type_drops = $typeDrops-> loadSelectedMenu();*/

include"schedule/accountPaymentForms.php";
$loadForm = new accountPaymentForms();
$loadForm-> loadMonthYearDrops();
$year_drop = $loadForm-> getYearDrop();
$month_drop = $loadForm-> getMonthDrop();


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

$_SESSION['admin_access'] = "yes";

include "webTemplates/viewScheduleTemplate.php";
?>