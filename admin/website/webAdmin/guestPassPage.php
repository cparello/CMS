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



$stmt = $dbMain ->prepare("SELECT business_name FROM company_names WHERE business_name != ''");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($gymName); 
$stmt->fetch(); 


   
$tempGName = explode(' ',$gymName);
   
   
   $g1 = strtolower($tempGName[0]);
   $g1 = ucfirst($g1);
   $g2 = strtolower($tempGName[1]);
   $g2 = ucfirst($g2);
   $g3 = strtolower($tempGName[2]);
   $g3 = ucfirst($g3);
   $g4 = strtolower($tempGName[3]);
   $g4 = ucfirst($g4);
   
   $gymName = "$g1 $g2 $g3 $g4";

$_SESSION['admin_access'] = "yes";



include "webTemplates/guestPassPageTemplate.php";
?>