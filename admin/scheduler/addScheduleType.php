<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$all_select =1;
include "../helper_apps/clubDrops.php";
$clubDrops = new clubDrops();
$clubDrops-> setAllSelect($all_select);
$location_drop = $clubDrops-> loadMenu(); 

//sets up the varibles for the form template
$page_title  = 'Add Schedule Category';
$file_permissions = "";
$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/employeeTypeCheck.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtCategory.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript5 ="<script type=\"text/javascript\" src=\"../scripts/scheduleType.js\"></script>";

//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(66);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";


include "../templates/addScheduleTypeTemplate.php";

?>