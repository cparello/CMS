<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$service_location = $_REQUEST['service_location'];

include "../clubs/clubDrops.php";
$clubDrops = new clubDrops();
$clubDrops-> setServiceLocation($service_location);
$drop_menu = $clubDrops -> loadMenu(); 



$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript2 = "<script type=\"text/javascript\" src=\"../scripts/guestRegistration_v1.js\"></script>";
$javaScript3 = "<script type=\"text/javascript\" src=\"../scripts/guestPassWaiver_v1.js\"></script>";

include "../templates/guestRegistrationTemplate.php";
exit;

?>