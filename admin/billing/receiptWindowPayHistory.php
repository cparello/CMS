<?php
//include "contractSql.php";
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


$html = $_SESSION['html'];

//$html  =  $_SESSION['html'];
$image_name = $_SESSION['image_name'];
$logo = $_SESSION['logo'];
$bus_name = $_SESSION['bus_name'];
$club_name = $_SESSION['club_name'];
$club_address = $_SESSION['club_address'];
$club_phone = $_SESSION['club_phone'];
$receiptItems = $_SESSION['receiptItems'];
$retailCost = $_SESSION['retailCost'];
$salesTax = $_SESSION['salesTax'];
$totCost = $_SESSION['totCost'];
$invType = $_SESSION['invType'] ;
//$html  =  $_SESSION['html'];
//$contractHtml = $contractSql-> loadContract();
unset($_SESSION['html']);

echo"$html";
exit;
?>