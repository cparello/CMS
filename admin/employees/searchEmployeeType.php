<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];

//shows the copyright at bottom of page
$footer_admin = $_SESSION['footer_admin'];

include "../clubs/clubDrops.php";
$clubDrops = new clubDrops();
$drop_menu = $clubDrops -> loadMenu(); 


//If the the form has been submitted then do the search
if ($marker == 1)  {

$search_string = $_SESSION['search_string'];
$search_type = $_SESSION['submit_button'];

include "employeeTypeLists.php";
$getLists = new employeeTypeLists();
$getLists -> setSearchString($search_string);
$getLists -> setSearchType($search_type);
$getLists -> loadRecords(); 
$result1 = $getLists -> getDropList();
//$result2 = $getLists -> getUserForm();

//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(11);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";


//check tp see if there are multi results or not
if($result1 != "") {
include "../templates/employeeTypeListTemplate.php";
exit;
}


//echo"$result1";
//exit;



}

//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(10);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";

//print out the search form
include "../templates/searchEmployeeTypeTemplate.php";

?>