<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];
$employee_type = $_REQUEST['employee_type'];
$service_location = $_REQUEST['service_location'];
$type_key = $_REQUEST['type_key'];
$employee_description = $_REQUEST['employee_description'];


include "employeeTypeSql.php";

//shows the copyright at bottom of page
$footer_admin = $_SESSION['footer_admin'];


if($marker == 1)  {

$accesslevel = $_SESSION['access_level'];

$updateEmployeeType = new employeeTypeSql();
$updateEmployeeType -> setEmployeeType($employee_type);
$updateEmployeeType -> setLocationId($service_location);
$updateEmployeeType -> setTypeKey($type_key);
$updateEmployeeType -> setEmployeeDescription($employee_description);
$club_name = $updateEmployeeType ->parseName();
$confirmation = $updateEmployeeType ->updateEmployeeType() ;


include "../clubs/clubDrops.php";
$clubDrops = new clubDrops();
$clubDrops -> setClubId($service_location);
$clubDrops -> setServiceLocation($club_name);
$drop_menu = $clubDrops -> loadMenu();

//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(12);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";


//sets up the varibles for the form template
$submit_link = 'editEmployeeType.php';
$submit_name = 'update';
$page_title  = "Edit Employee Type $employee_type";
$file_permissions = "";
$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/employeeTypeCheck.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtEmployeeType.js\"></script>";
$type_key_hidden = "<input type=\"hidden\" name=\"type_key\" value=\"$type_key\" />";

include "../templates/addEmployeeTypeTemplate.php";

}

//===============================================================
//check to see if this is an edit or a delete
if (isset($_POST['edit']))       {


include "../clubs/clubDrops.php";
$clubDrops = new clubDrops();
$clubDrops -> setClubId($club_id);
$clubDrops -> setServiceLocation($service_location);

$drop_menu = $clubDrops -> loadMenu();

//sets up the varibles for the form template
$submit_link = 'editEmployeeType.php';
$submit_name = 'update';
$page_title  = "Edit Employee Type $employee_type";
$file_permissions = "";
$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/employeeTypeCheck.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtEmployeeType.js\"></script>";
$type_key_hidden = "<input type=\"hidden\" name=\"type_key\" value=\"$type_key\" />";

//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(12);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";

include "../templates/addEmployeeTypeTemplate.php";

}

//===================================================================================
if (isset($_POST['delete']))       {

$deleteEmployeeType = new employeeTypeSql();
$deleteEmployeeType -> setEmployeeType($employee_type);
$deleteEmployeeType -> setLocationId($club_id);
$deleteEmployeeType -> setTypeKey($type_key);

$confirmation = $deleteEmployeeType -> deleteEmployeeType();



//set the search type to three which is all
$search_type = "3";

include "employeeTypeLists.php";
$getLists = new employeeTypeLists();
$getLists -> setSearchString($search_string);
$getLists -> setSearchType($search_type);
$getLists -> loadRecords(); 
$result1 = $getLists -> getDropList();

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


}




?>