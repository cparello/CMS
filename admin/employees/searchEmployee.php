<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
include "../clubs/clubDrops.php";
include "employeeTypeDrops.php";
$marker = $_REQUEST['marker'];

//shows the copyright at bottom of page
$footer_admin = $_SESSION['footer_admin'];

$clubDrops = new clubDrops();
$drop_menu = $clubDrops -> loadMenu(); 

$employeeDrops = new employeeTypeDrops();
$employeeDrops-> setTypeKey($employee_type1);
$drop_menu_emp = $employeeDrops-> loadTypeMenu(); 


//If the the form has been submitted then do the search
if ($marker == 1)  {

$search_string = $_SESSION['search_string'];
$search_type = $_SESSION['submit_button'];
$drop_description = $_SESSION['drop_description'];


include "employeeLists.php";
$getLists = new employeeLists();
$getLists -> setSearchString($search_string);
$getLists -> setSearchType($search_type);
$getLists ->setDropDescription($drop_description);
$getLists -> loadRecords(); 
$result1 = $getLists -> getDropList();
//$result2 = $getLists -> getUserForm();


//check tp see if there are multi results or not
if($result1 != "") {

//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(6);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";

include "../templates/employeeListTemplate.php";
exit;
}


//echo"$result1";
//exit;



}


//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(5);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";

$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/searchEmployee.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtEmployee.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";



//print out the search form
include "../templates/searchEmployeeTemplate.php";

?>