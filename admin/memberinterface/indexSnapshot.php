<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
include  "../dbConnect.php";
include "../headFoot.php";

$getHeadFoot = new headFoot();
$getHeadFoot -> loadNames();


//get the date
$year = $getHeadFoot -> getFooterDate();
//get the Nick name for the busines
$nick_name = $getHeadFoot -> getBusinessNickName();
//get the full name for the business
$full_name = $getHeadFoot -> getBusinessName(); 
//for the copywrite name
$copy_name = $getHeadFoot -> getCopyWriteName();

//create the fotter to pass on to subsequent pages
$footer_admin = "&copy; $year  $copy_name";
$_SESSION['footer_admin'] = $footer_admin;

//create the title of the admin pages
$header_admin = "$nick_name Member Check In";
$_SESSION['header_admin2'] = $header_admin;
//echo "head $header_admin";

if(!isset($_REQUEST['clubId'])){
    $location_id = $_SESSION['location_id'];
}else{
    $location_id = $_REQUEST['clubId'];
    $_SESSION['location_id'] = $location_id;
}

//$location_id = $_SESSION['location_id'];
//$footer_admin = $_SESSION['footer_admin']; 
//$header_admin = $_SESSION['header_admin2'];

$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript2 = "<script type=\"text/javascript\" src=\"../scripts/snapshotIndex.js\"></script>";
$javaScript3 = "<script type=\"text/javascript\" src=\"../scripts/backToAccess.js\"></script>";
include  "../templates/snapshotIndexTemplate.php";


?>