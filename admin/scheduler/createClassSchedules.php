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
$bundleDrops-> setHeaderType(1);
$bundle_type_drops = $bundleDrops-> loadSelectedMenu();

//sets up the varibles for the form template
$page_title  = 'Create Class Schedules';

$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtCategory.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/loadBundleDrops2.js\"></script>";
$javaScript5="<script type=\"text/javascript\" src=\"../scripts/jquery.ui.core.js\"></script>";
$javaScript6 ="<script type=\"text/javascript\" src=\"../scripts/jquery.ui.widget.js\"></script>";
$javaScript7 ="<script type=\"text/javascript\" src=\"../scripts/jquery.ui.datepicker.js\"></script>";
$javaScript8 ="<script type=\"text/javascript\" src=\"../scripts/checkClassSchedules.js\"></script>";
$javaScript9 ="<script type=\"text/javascript\" src=\"../scripts/jquery.tablesorter.js\"></script>";
$javaScript10 ="<script type=\"text/javascript\" src=\"../scripts/jquery.tablesorter.scroller.js\"></script>";
$javaScript11 ="<script type=\"text/javascript\" src=\"../scripts/editDelete.js\"></script>";

//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(77);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";


include "../templates/createClassSchedulesTemplate.php";

?>