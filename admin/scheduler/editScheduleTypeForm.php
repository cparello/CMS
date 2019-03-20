<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$type_id = $_REQUEST['type_id'];

include "loadScheduleTypeForm.php";
$typeForm = new loadScheduleTypeForm();
$typeForm-> setTypeId($type_id);
$typeForm-> loadScheduleVars();
$type_name = $typeForm-> getTypeName();
$type_description = $typeForm-> getTypeDescription();
$location_id = $typeForm-> getLocationId();

include "../helper_apps/clubDrops.php";
$clubDrops = new clubDrops();
$clubDrops-> setClubId($location_id);
$location_drop = $clubDrops-> loadSelectedMenu(); 

//sets up the varibles for the form template
$page_title  = 'Edit Schedule Category';
$file_permissions = "";
$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/employeeTypeCheck.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtCategory.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript5 ="<script type=\"text/javascript\" src=\"../scripts/scheduleTypeThree.js\"></script>";

//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(68);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";


include "../templates/addScheduleTypeTemplate.php";

?>