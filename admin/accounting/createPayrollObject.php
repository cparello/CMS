<?php
session_start();
//if (!isset($_SESSION['admin_access']))  {
//exit;
//}
$start = $_REQUEST['start'];
$end = $_REQUEST['end'];



$start = urldecode($start);
$end = urldecode($end);

$_SESSION['start'] = $start;
$_SESSION['end'] = $end;

$value = 1;

//echo"fubar";

echo"$value";// $month $barcode";
exit;

?>