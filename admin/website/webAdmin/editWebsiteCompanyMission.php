<?php
//echo"fubar0";
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];
$motto = $_REQUEST['motto'];
$missionStatement = $_REQUEST['missionStatement'];
//exit;
include "websiteCompanyMissionSql.php";


//if form is submitted save to database
if ($marker == 1) {

   $updateCycles = new websiteCompanyMissionSql();
   $updateCycles ->setMissionStatement($missionStatement);
   $updateCycles ->setMotto($motto);
   $confirmation = $updateCycles -> updateWebsiteCompanyMissionOptions();
   //echo"fubar222";
  
  
}


//echo "p tee p ee";
$loadSalesPay = new websiteCompanyMissionSql();
//echo"fubar 1";
$loadSalesPay -> loadWebsiteCompanyMissionOptions();

$missionStatement = $loadSalesPay -> getMissionStatement();
$motto = $loadSalesPay -> getMotto();
//sets up the varibles for the form template
$submit_link = 'editWebsiteCompanyMission.php';
$submit_name = 'update';
$submit_title = "Update Website Company Mission";
$page_title  = 'Website Company Mission';
$javaScript1 = "<script type=\"text/javascript\" src=\"webScripts/websitePromo.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"webScripts/helpTxtWebsiteCompanyMission.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"webScripts/helpPops.js\"></script>";



/*include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(26);
$info_text = $getText -> createTextInfo();

include "../templates/infoTemplate2.php";*/

//echo"fubar 2";
include "webTemplates/websiteCompanyMissionTemplate.php";

?>