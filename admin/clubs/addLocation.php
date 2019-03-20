<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];
$location_id = $_REQUEST['location_id'];
$location_name = $_REQUEST['location_name'];
$location_address = $_REQUEST['location_address'];
$location_phone = $_REQUEST['location_phone'];
$location_contact = $_REQUEST['location_contact'];
$state = $_REQUEST['state'];
//sets up the varibles for the form template
$submit_link = 'addLocation.php';
$submit_name = 'save';
$page_title  = 'Add Service Location';
$file_permissions = "";
$javaScript = "<script type=\"text/javascript\" src=\"../scripts/locationCheck.js\"></script>";
//shows the copyright at bottom of page
$footer_admin = $_SESSION['footer_admin'];

if ($marker == 1) {

//save to the database
include "locationSql.php";
$addLocation = new locationSql();
$addLocation-> setLocationId($location_id);
$addLocation-> setLocationName($location_name);
$addLocation-> setLocationAddress($location_address);
$addLocation-> setLocationPhone($location_phone);
$addLocation-> setLocationContact($location_contact);
$addLocation-> setState($state);

$confirmation = $addLocation->saveLocation();

$location_id = "";
$location_name ="";
$location_address ="";
$location_phone ="";
$location_contact ="";
$state ="";
}

//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(17);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";


include "../templates/locationTemplate.php";

?>