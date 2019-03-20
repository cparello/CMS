<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$all_select = $_REQUEST['all_select'];
$marker = $_REQUEST['marker'];
$service_location = $_REQUEST['service_location'];
$employee_type = $_REQUEST['employee_type'];
$employee_description = $_REQUEST['employee_description'];

//sets up the varibles for the form template
$submit_link = 'addEmployeeType.php';
$submit_name = 'save';
$page_title  = 'Add Employee Type';
$file_permissions = "";
$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/employeeTypeCheck.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtEmployeeType.js\"></script>";
//shows the copyright at bottom of page
$footer_admin = $_SESSION['footer_admin'];


include "../clubs/clubDrops.php";
$clubDrops = new clubDrops();
$clubDrops -> setAllSelect($all_select);
$drop_menu = $clubDrops -> loadMenu(); 


if ($marker == 1) {
//echo"$employee_description";
//exit;
//save to the database
include "employeeTypeSql.php";
$addEmployeeType = new employeeTypeSql();
$addEmployeeType -> setLocationId($service_location);
$addEmployeeType -> setEmployeeType($employee_type);
$addEmployeeType -> setEmployeeDescription($employee_description);
$confirmation =  $addEmployeeType -> saveEmployeeType();

$employee_type ="";
$employee_description ="";
}

//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(9);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";


include "../templates/addEmployeeTypeTemplate.php";

?>