<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


$location_id = $_SESSION['location_id'];


$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript2 = "<script type=\"text/javascript\" src=\"../scripts/employeeClockIn.js\"></script>";
$javaScript3 = "<script type=\"text/javascript\" src=\"../scripts/loadCamera.js\"></script>";
$javaScript4 = "<script type=\"text/javascript\" src=\"../scripts/checkTimeClockTwo.js\"></script>";

include  "../templates/employeeClockInTemplate.php";


?>