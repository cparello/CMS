<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$location_id = $_SESSION['location_id'];
include "viewCheckInSql.php";

$viewHistory = new viewCheckInSql();
$viewHistory-> setLocationId($location_id);
$viewHistory-> loadHistoryList();
$history_list = $viewHistory-> getCheckInList();


$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";

include  "../templates/viewCheckInTemplate.php";


?>