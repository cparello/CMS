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
//$_SESSION['footer_admin'] = $footer_admin;

//create the title of the admin pages
$header_admin = "$nick_name Member Interface";
//$_SESSION['header_admin'] = $header_admin;


//$location_id = $_SESSION['location_id'];
//$location_id = $_REQUEST['clubId'];
//$_SESSION['location_id'] = $location_id;

if(!isset($_REQUEST['clubId'])){
    $location_id = $_SESSION['location_id'];
}else{
    $location_id = $_REQUEST['clubId'];
    $_SESSION['location_id'] = $location_id;
}

//$footer_admin = $_SESSION['footer_admin']; 
//$header_admin = $_SESSION['header_admin'];

include "../helper_apps/parseClubName.php";
$load = new parseClubName();
$load-> setClubId($location_id);
$load-> loadClubName();
$club_name = $load-> getClubName();
//echo "club $location_id $club_name";
$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript2 = "<script type=\"text/javascript\" src=\"../scripts/switchMemTabs.js\"></script>";
$javaScript3 = "<script type=\"text/javascript\" src=\"../scripts/backToAccess.js\"></script>";

include  "../templates/memIntTemplate.php";


?>