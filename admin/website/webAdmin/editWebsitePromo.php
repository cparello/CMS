<?php
//echo"fubar0";
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];
$headerTxt = $_REQUEST['headerTxt'];
$headerTxt2 = $_REQUEST['headerTxt2'];
$headerTxt3 = $_REQUEST['headerTxt3'];
$headerTxtSize = $_REQUEST['headerTxtSize'];
$headerTxt2Size = $_REQUEST['headerTxt2Size'];
$headerTxt3Size = $_REQUEST['headerTxt3Size'];
$headerColor = $_REQUEST['headerColor'];
$backColor = $_REQUEST['backColor'];
$headerSize = $_REQUEST['headerSize'];
$boxSize = $_REQUEST['boxSize'];
$textTrans = $_REQUEST['textTrans'];
$promoLink = $_REQUEST['promoLink'];
$photo1 = $_REQUEST['photo1'];
$photo2 = $_REQUEST['photo2'];
$photo3 = $_REQUEST['photo3'];
$photo4 = $_REQUEST['photo4'];
$photo5 = $_REQUEST['photo5'];
$opacity = $_REQUEST['opacity'];
//exit;
include "websitePromoSql.php";


//if form is submitted save to database
if ($marker == 1) {

   $updateCycles = new websitePromoSql();
   $updateCycles ->setHeaderTxt($headerTxt);
   $updateCycles ->setHeaderTxt2($headerTxt2);
   $updateCycles ->setHeaderTxt3($headerTxt3);
   $updateCycles ->setHeaderTxtSize($headerTxtSize);
   $updateCycles ->setHeaderTxt2Size($headerTxt2Size);
   $updateCycles ->setHeaderTxt3Size($headerTxt3Size);
   $updateCycles ->setBoxSize($boxSize);
   $updateCycles ->setTextTrans($textTrans);
   $updateCycles ->setHeaderColor($headerColor);
   $updateCycles ->setBackColor($backColor);
   $updateCycles ->setPromoLink($promoLink);
   $updateCycles ->setPhoto1($photo1);
   $updateCycles ->setPhoto2($photo2);
   $updateCycles ->setPhoto3($photo3);
   $updateCycles ->setPhoto4($photo4);
   $updateCycles ->setPhoto5($photo5);
   $updateCycles ->setOpacity($opacity);
   $confirmation = $updateCycles -> updateWebsitePromoOptions();
   //echo"fubar222";
  
  
}


//echo "p tee p ee";
$loadSalesPay = new websitePromoSql();
//echo"fubar 1";
$loadSalesPay -> loadWebsitePromoOptions();


$headerTxt = $loadSalesPay -> getHeaderTxt();
$headerTxt2 = $loadSalesPay -> getHeaderTxt2();
$headerTxt3 = $loadSalesPay -> getHeaderTxt3();
$headerTxtSize = $loadSalesPay -> getHeaderTxtSize();
$headerTxt2Size = $loadSalesPay -> getHeaderTxt2Size();
$headerTxt3Size = $loadSalesPay -> getHeaderTxt3Size();
$boxSize = $loadSalesPay -> getBoxSize();
$textTrans = $loadSalesPay -> getTextTrans();
$headerColor = $loadSalesPay -> getHeaderColor();
$backColor = $loadSalesPay -> getBackColor();
$promoLink = $loadSalesPay -> getPromoLink();
$photo1 = $loadSalesPay -> getPhoto1();
$photo2 = $loadSalesPay -> getPhoto2();
$photo3 = $loadSalesPay -> getPhoto3();
$photo4 = $loadSalesPay -> getPhoto4();
$photo5 = $loadSalesPay -> getPhoto5();
$opacity = $loadSalesPay -> getOpacity();
//sets up the varibles for the form template
$submit_link = 'editWebsitePromo.php';
$submit_name = 'update';
$submit_title = "Update Website Promo Options";
$page_title  = 'Website Promo Options';
$javaScript1 = "<script type=\"text/javascript\" src=\"webScripts/websitePromo.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"webScripts/helpTxtWebsitePromo.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"webScripts/helpPops.js\"></script>";

include "../../dbConnect.php";
/*$stmt = $dbMain ->prepare("SELECT MIN(club_id) FROM club_info WHERE club_id != ''");
echo($dbMain->error);
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($club_id); 
$stmt->fetch();
$stmt->close();*/

$club_id = 0;

switch($promoLink){
    case'training-packages.php':
        $promoText = "Personal Training";
    break;
   
    case'yoga.php':
        $promoText = "Yoga";
    break;
    case'spin.php':
        $promoText = "Spin";
    break;
     default:
        $promoText = "Membership Sales";
    break;
}


$dir = "new/img/";

$root = scandir($dir, 1);
    foreach($root as $value) {           
        if($value != "") {
            $dropOptions1 .= "<option value=\"$value\">$value</option>\n";
                           }
                 }
                 
                 
$dir = "new/img/";

$root = scandir($dir, 1);
    foreach($root as $value) {           
        if($value != "") {
            $dropOptions2 .= "<option value=\"$value\">$value</option>\n";
                           }
                 }
$dir = "new/img/";

$root = scandir($dir, 1);
    foreach($root as $value) {           
        if($value != "") {
            $dropOptions3 .= "<option value=\"$value\">$value</option>\n";
                           }
                 }
                 
                 
$dir = "new/img/";

$root = scandir($dir, 1);
    foreach($root as $value) {           
        if($value != "") {
            $dropOptions4 .= "<option value=\"$value\">$value</option>\n";
                           }
                 }
                 
$dir = "new/img/";

$root = scandir($dir, 1);
    foreach($root as $value) {           
        if($value != "") {
            $dropOptions5 .= "<option value=\"$value\">$value</option>\n";
                           }
                 }
/*include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(26);
$info_text = $getText -> createTextInfo();

include "../templates/infoTemplate2.php";*/

//echo"fubar 2";
include "webTemplates/websitePromoTemplate.php";

?>