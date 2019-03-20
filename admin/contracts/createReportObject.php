<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$month = $_REQUEST['month'];
$report = $_REQUEST['report'];
$year = $_REQUEST['year'];


$month = urldecode($month);
$report = urldecode($report);
$year = urldecode($year);

//create the sales sql object to store the sales info for the contract forms
//include "attendanceListReport.php";

//$_SESSION['reportSql'] = new generateAttendenceReport();
//$reportSql = $_SESSION['reportSql']; 
//$reportSql = new generateAttendenceReport();
//$reportSql-> setMonth($month);
//$reportSql-> setBarCode($barCode);

$_SESSION['report'] = $report;
$_SESSION['month'] = $month;
$_SESSION['year'] = $year;




$value = "1";

echo"$value";// $month $barcode";
exit;

?>