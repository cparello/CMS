<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$location_id = $_SESSION['location_id'];

$class_date = date("m/d/Y");

include "../scheduler/scheduleTypeDrops.php";
$typeDrops = new scheduleTypeDrops();
$typeDrops-> setClubId($location_id);
$schedule_type_drops = $typeDrops-> loadSelectedMenu();

include"accountPaymentForms.php";
$loadForm = new accountPaymentForms();
$loadForm-> loadMonthYearDrops();
$year_drop = $loadForm-> getYearDrop();
$month_drop = $loadForm-> getMonthDrop();


$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript2 = "<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript3 = "<script type=\"text/javascript\" src=\"../scripts/helpTxtCategory.js\"></script>";
$javaScript4 = "<script type=\"text/javascript\" src=\"../scripts/jquery.ui.core.js\"></script>";
$javaScript5 = "<script type=\"text/javascript\" src=\"../scripts/jquery.ui.widget.js\"></script>";
$javaScript6 = "<script type=\"text/javascript\" src=\"../scripts/jquery.ui.datepicker.js\"></script>";
$javaScript7 = "<script type=\"text/javascript\" src=\"../scripts/jquery.tablesorter.js\"></script>";
$javaScript8 = "<script type=\"text/javascript\" src=\"../scripts/jquery.tablesorter.scroller.js\"></script>";
$javaScript9 = "<script type=\"text/javascript\" src=\"../scripts/viewScheduler.js\"></script>";
$javaScript10 = "<script type=\"text/javascript\" src=\"../scripts/loadBookScreen.js\"></script>";
$javaScript11 = "<script type=\"text/javascript\" src=\"../scripts/bookClass.js\"></script>";
$javaScript12 = "<script type=\"text/javascript\" src=\"../scripts/processClassPurchase.js\"></script>";
$javaScript13 = "<script type=\"text/javascript\" src=\"../scripts/cardSwipe.js\"></script>";
$javaScript14 = "<script type=\"text/javascript\" src=\"../scripts/printClassReceipt.js\"></script>";
$javaScript15 = "<script type=\"text/javascript\" src=\"../scripts/schedulerWaiver.js\"></script>";

include  "../templates/scheduleListTemplate.php";


?>