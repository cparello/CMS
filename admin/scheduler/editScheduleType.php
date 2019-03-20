<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


include "scheduleTypeDrops.php";
$typeDrops = new scheduleTypeDrops();
$schedule_type_drops = $typeDrops-> loadMenu();

//sets up the varibles for the form template
$page_title  = 'Edit Schedule Category';

$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtCategory.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/scheduleTypeTwo.js\"></script>";

//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(67);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";


include "../templates/editScheduleTypeTemplate.php";

?>