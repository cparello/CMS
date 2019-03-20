<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


include "scheduleTypeDrops.php";
$typeDrops = new scheduleTypeDrops();
$schedule_type_drops = $typeDrops-> loadMenu();

include "bundleTypeDrops.php";
$type_id = null;
$bundleDrops = new bundleTypeDrops();
$bundleDrops-> setTypeId($type_id);
$bundle_type_drops = $bundleDrops-> loadSelectedMenu();

//sets up the varibles for the form template
$page_title  = 'Add Schedule Bundle';

$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtCategory.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript5 ="<script type=\"text/javascript\" src=\"../scripts/loadBundleDrops.js\"></script>";
$javaScript7 ="<script type=\"text/javascript\" src=\"../scripts/saveBundleDescription.js\"></script>";

//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(69);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";


include "../templates/addBundleDescriptionTemplate.php";

?>