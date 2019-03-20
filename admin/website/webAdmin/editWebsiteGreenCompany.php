<?php
//echo"fubar0";
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];
$green1 = $_REQUEST['green1'];
$green2 = $_REQUEST['green2'];
$green3 = $_REQUEST['green3'];
include "websiteGreenCompanySql.php";


//if form is submitted save to database
if ($marker == 1) {

   $updateCycles = new websiteGreenCompanySql();
   $updateCycles ->setGreen1($green1);
   $updateCycles ->setGreen2($green2);
   $updateCycles ->setGreen3($green3);
   $confirmation = $updateCycles -> updateWebsiteGreenCompanyOptions();
   //echo"fubar222";
  
  
}


//echo "p tee p ee";
$loadSalesPay = new websiteGreenCompanySql();
//echo"fubar 1";
$loadSalesPay -> loadWebsiteGreenCompanyOptions();

$green1 = $loadSalesPay -> getGreen1();
$green2 = $loadSalesPay -> getGreen2();
$green3 = $loadSalesPay -> getGreen3();
//sets up the varibles for the form template
$submit_link = 'editWebsiteGreenCompany.php';
$submit_name = 'update';
$submit_title = "Update Website Green Company Options";
$page_title  = 'Website Green Company';
$javaScript1 = "<script type=\"text/javascript\" src=\"webScripts/websitePromo.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"webScripts/helpTxtWebsiteGreenCompany.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"webScripts/helpPops.js\"></script>";



/*include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(26);
$info_text = $getText -> createTextInfo();

include "../templates/infoTemplate2.php";*/

//echo"fubar 2";
include "webTemplates/websiteGreenCompanyTemplate.php";

?>