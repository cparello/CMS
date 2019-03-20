<?php

session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];
$ownerMessage = $_REQUEST['ownerMessage'];
$ownerAbout = $_REQUEST['ownerAbout'];
$ownerName = $_REQUEST['ownerName'];
$ownerPhoto = $_REQUEST['ownerPhoto'];

include "websiteOwnerInfoSql.php";


//if form is submitted save to database
if ($marker == 1) {

   $updateCycles = new websiteOwnerInfoSql();
   $updateCycles ->setOwnerMessage($ownerMessage);
   $updateCycles ->setOwnerAbout($ownerAbout);
   $updateCycles ->setOwnerName($ownerName);
   $updateCycles ->setOwnerPhoto($ownerPhoto);
   $confirmation = $updateCycles -> updateWebsiteOwnerInfoOptions();
   //echo"fubar222";
  
  
}

//echo "p tee p ee";
$loadSalesPay = new websiteOwnerInfoSql();
//echo"fubar 1";
$loadSalesPay -> loadWebsiteOwnerInfoOptions();

$ownerMessage = $loadSalesPay -> getOwnerMessage();
$ownerAbout = $loadSalesPay -> getOwnerAbout();
$ownerName = $loadSalesPay -> getOwnerName();
$ownerPhoto = $loadSalesPay -> getOwnerPhoto();
//sets up the varibles for the form template
$submit_link = 'editWebsiteOwnerInfo.php';
$submit_name = 'update';
$submit_title = "Update Website Owner Info Options";
$page_title  = 'Website Owner Info';
$javaScript1 = "<script type=\"text/javascript\" src=\"webScripts/websitePromo.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"webScripts/helpTxtWebsiteOwnerInfoPage.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"webScripts/helpPops.js\"></script>";


$dir = "pictures/";

$root = scandir($dir, 1);
    foreach($root as $value) {           
        if($value != "") {
            $dropOptions .= "<option value=\"$value\">$value</option>\n";
                           }
                 }
/*include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(26);
$info_text = $getText -> createTextInfo();

include "../templates/infoTemplate2.php";*/

//echo"fubar 2";
include "webTemplates/websiteOwnerInfoTemplate.php";

?>