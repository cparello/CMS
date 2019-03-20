<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];
$overide_pin_one = $_REQUEST['overide_pin_one'];

include "pinsSql.php";

$overide_pin_one = trim($overide_pin_one);


$overide_pin_one = preg_replace("/[^0-9]+/", "" ,$overide_pin_one);



//sets up the varibles for the form template
$submit_link = 'editPins.php';
$submit_name = 'update';
$submit_title = "Update Pin";
$page_title  = 'Edit Contract Overide PIN';
$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/pins.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtPins.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";


$file_permissions = "";
//$javaScript1 = "<script type=\"text/javascript\" src=\"scripts/fees.js\"></script>";
//$info_text
//shows the copyright at bottom of page
$footer_admin = $_SESSION['footer_admin'];

//if form is submitted save to database
if ($marker == 1) {
$updatePins = new pinsSql();
$updatePins -> setOveridePinOne($overide_pin_one);
$confirmation = $updatePins -> updatePins();
}


//load the form content
$loadPins = new pinsSql();
$loadPins -> loadPins();
$overide_pin_one = $loadPins -> getOveridePinOne();


include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(23);
$info_text = $getText -> createTextInfo();

include "../templates/infoTemplate2.php";
include "../templates/pinsTemplate.php";




?>
