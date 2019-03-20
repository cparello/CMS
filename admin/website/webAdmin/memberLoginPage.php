<?php
session_start();
include"../../dbConnect.php";
include"loadStuff.php";
include"loadWebsitePreferences.php";

include "webLogCheck.php";
$logCheck = new loginCheck();
$logCheck-> setButtonColor($middleButtons);
$logCheck-> checkLogin();
$logHtml = $logCheck-> getLogHtml();

$memberFlag = $_REQUEST['member'];

if($memberFlag == 0){
    
  include "webTemplates/memberCreateAccountTemplate.php";
  exit;
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
   
include "webTemplates/memberLoginTemplate.php";

?>