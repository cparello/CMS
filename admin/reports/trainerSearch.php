<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];

//If the the form has been submitted then do the search
if ($marker == 1)  {
//echo "fybar";
$search_string = $_SESSION['search_string'];
$search_type = $_SESSION['submit_button'];

unset($_SESSION['search_string']);
unset($_SESSION['submit_button']);


include "trainerList.php";
$getLists = new trainerLists();
$getLists -> setSearchString($search_string);
$getLists -> setSearchType($search_type);
$getLists -> loadRecords(); 
$result1 = $getLists -> getDropList();
//$result2 = $getLists -> getUserForm();


//check tp see if there are multi results or not
if($result1 != "") {

//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(34);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";

include "../templates/trainerListTemplate.php";
exit;
}


//echo"$result1";
//exit;



}


//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(33);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";

$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/searchTrainerEmployee.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTextTimeClock.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";



//print out the search form
include "../templates/searchTrainerTemplate.php";

?>