<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$type_id = $_REQUEST['type_id'];
$location_id = $_REQUEST['location_id'];
$bundle_id = $_REQUEST['bundle_id'];

include "serviceListTwo.php";
$serviceList = new serviceListTwo;
$serviceList-> setTypeId($type_id);
$serviceList-> setLocationId($location_id);
$serviceList-> setBundleId($bundle_id);
$serviceList-> loadServiceList();
$service_table = $serviceList-> getTableContent();

//sets up the varibles for the form template
$page_title  = 'Edit Schedule Bundle';

$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtCategory.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/editBundle2.js\"></script>";
$javaScript5 ="<script type=\"text/javascript\" src=\"../scripts/deleteBundle.js\"></script>";

//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(70);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";


include "../templates/editBundleTypeTemplate2.php";

?>