<?php
session_start();
//if (!isset($_SESSION['admin_access']))  {
//exit;
//}
$month = $_REQUEST['month'];
$contractKey = $_REQUEST['contractKey'];
$year = $_REQUEST['year'];
$emailBool = $_REQUEST['emailBool'];


$month = urldecode($month);
$contractKey = urldecode($contractKey);
$year = urldecode($year);

//create the sales sql object to store the sales info for the contract forms
//include "attendanceListReport.php";

//$_SESSION['reportSql'] = new generateAttendenceReport();
//$reportSql = $_SESSION['reportSql']; 
//$reportSql = new generateAttendenceReport();
//$reportSql-> setMonth($month);
//$reportSql-> setBarCode($barCode);

$_SESSION['contractKey'] = $contractKey;
$_SESSION['month'] = $month;
$_SESSION['year'] = $year;
$_SESSION['emailBool'] = $emailBool;



$value = "1";

echo"$value";// $month $barcode";
exit;

?>