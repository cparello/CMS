<?php
session_start();
$_SESSION['admin_access'] = "Kenny";
$_SESSION['file_permissions'];
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

include  "../templates/snapshotLoginTemplate.php";


?>

