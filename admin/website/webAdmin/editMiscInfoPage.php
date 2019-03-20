<?php

session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];
$privacy = $_REQUEST['privacy'];
$terms = $_REQUEST['terms'];
//$favicon = $_REQUEST['favicon'];

include "websiteMiscInfoSql.php";


//if form is submitted save to database
if ($marker == 1) {

   $updateCycles = new websiteMiscInfoSql();
   $updateCycles ->setPrivacy($privacy);
   $updateCycles ->setTerms($terms);
  // $updateCycles ->setFavicon($favicon);
   $confirmation = $updateCycles -> updateWebsiteMiscInfoOptions();
   //echo"fubar222";
  
  
}

//echo "p tee p ee";
$loadSalesPay = new websiteMiscInfoSql();
//echo"fubar 1";
$loadSalesPay -> loadWebsiteMiscInfoOptions();

$privacy = $loadSalesPay -> getPrivacy();
$terms = $loadSalesPay -> getTerms();
//$favicon = $loadSalesPay -> getFavicon();
//sets up the varibles for the form template
$submit_link = 'editWebsiteMiscInfo.php';
$submit_name = 'update';
$submit_title = "Update Website Misc Info Options";
$page_title  = 'Website Misc Info';
//$javaScript1 = "<script type=\"text/javascript\" src=\"webScripts/websitePromo.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"webScripts/helpTxtWebsiteMiscInfoPage.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"webScripts/helpPops.js\"></script>";


include "webTemplates/websiteMiscInfoTemplate.php";

?>