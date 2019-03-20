<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];
$service_location = $_REQUEST['service_location'];
$location_name = $_REQUEST['location_name'];




//sets up the varibles for the form template
$submit_link = 'editLocation.php';
$submit_name = 'update';
$page_title  = 'Edit Service Location';
$file_permissions = "";
$javaScript = "<script type=\"text/javascript\" src=\"../scripts/chooseLocation.js\"></script>";
//shows the copyright at bottom of page
$footer_admin = $_SESSION['footer_admin'];

if ($marker == 1) {
//-------------------------------------------------------------------------------------------------------------------------------------
if(isset($_REQUEST['delete']))  {
include "locationSql.php";
$deleteLocation = new locationSql();
$deleteLocation-> setLocationId($service_location);
$location_name = $deleteLocation->parseName(); 
$deleteLocation-> setLocationName($location_name);
$confirmation = $deleteLocation->deleteLocation();
}
//----------------------------------------------------------------------------------------------------------------------------------------
if(isset($_REQUEST['edit']))  {
include "locationSql.php";
$editLocation = new locationSql();
$editLocation-> setLocationId($service_location);
$editLocation-> loadLocation();

$location_id = $editLocation->getLocationId();
$location_name = $editLocation->getLocationName();
$location_address = $editLocation->getLocationAddress();
$location_phone = $editLocation->getLocationPhone();
$location_contact = $editLocation->getLocationContact();
$state = $editLocation->getState();
$location_id2 ="$location_id  (Cannot be Edited)";


$page_title  = "Edit $location_name Location";
$javaScript = "<script type=\"text/javascript\" src=\"../scripts/editLocation.js\"></script>";
 
 //this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(18);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";
 
 
 
include "../templates/locationTemplate2.php";
exit;
}
//------------------------------------------------------------------------------------------------------------------------------------------
if(isset($_REQUEST['update']))  {
include "locationSql.php";


$location_id = $_REQUEST['location_id'];
$location_name = $_REQUEST['location_name'];
$location_address = $_REQUEST['location_address'];
$location_phone = $_REQUEST['location_phone'];
$location_contact = $_REQUEST['location_contact'];
$state = $_REQUEST['state'];
//echo "$state";
$updateLocation = new locationSql();
$updateLocation-> setLocationId($location_id);
$updateLocation-> setLocationName($location_name);
$updateLocation-> setLocationAddress($location_address);
$updateLocation-> setLocationPhone($location_phone);
$updateLocation-> setLocationContact($location_contact);
$updateLocation-> setState($state);

$confirmation = $updateLocation->updateLocation(); 


$editLocation = new locationSql();
$editLocation-> setLocationId($location_id);
$editLocation-> loadLocation();

$location_id = $editLocation->getLocationId();
$location_name = $editLocation->getLocationName();
$location_address = $editLocation->getLocationAddress();
$location_phone = $editLocation->getLocationPhone();
$location_contact = $editLocation->getLocationContact();
$state = $editLocation->getState();

$location_id2 ="$location_id  (Cannot be Edited)";
$page_title  = "Edit $location_name Location";
$javaScript = "<script type=\"text/javascript\" src=\"../scripts/editLocation.js\"></script>";

 //this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(18);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";
 
include "../templates/locationTemplate2.php";
exit;
}



//save to the database
//include "locationSql.php";
//$addLocation = new locationSql();
//$addLocation-> setLocationId($location_id);
//$addLocation-> setLocationName($location_name);
///$addLocation-> setLocationAddress($location_address);
//$addLocation-> setLocationPhone($location_phone);
//$addLocation-> setLocationContact($location_contact);

//$confirmation = $addLocation->saveLocation();

//$location_id = "";
//$location_name ="";
//$location_address ="";
//$location_phone ="";
//$location_contact ="";
}

$all_select =1;
include "clubDrops.php";
$clubDrops = new clubDrops();
$clubDrops -> setAllSelect($all_select);
$drop_menu = $clubDrops -> loadMenu(); 

 //this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(19);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";

include "../templates/editLocationTemplate1.php";

?>