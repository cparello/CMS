<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];
$date_start = $_REQUEST['datepicker1'];
$date_end = $_REQUEST['datepicker2'];
//If the the form has been submitted then do the search
if ($marker == 1)  {
//echo "d $date_start d $date_end";
$search_string = $_SESSION['search_string'];
$search_type = $_SESSION['submit_button'];

unset($_SESSION['search_string']);
unset($_SESSION['submit_button']);



$m1 = date('m',strtotime($date_start));
$m2 = date('m',strtotime($date_end));
$d1 = date('d',strtotime($date_start));
$d2 = date('d',strtotime($date_end));
$y1 = date('Y',strtotime($date_start));
$y2 = date('Y',strtotime($date_end));
    
$date_start = date('Y-m-d H:i:s',mktime(0,0,0,$m1,$d1,$y1));
$date_end = date('Y-m-d H:i:s',mktime(23,59,59,$m2,$d2,$y2));
$_SESSION['date_start'] = $date_start;
$_SESSION['date_end'] = $date_end;

include "indiPayrollLists.php";
$getLists = new indiPayrollLists();
$getLists -> setSearchString($search_string);
$getLists -> setSearchType($search_type);
$getLists -> loadRecords(); 
$result1 = $getLists -> getDropList();



//check tp see if there are multi results or not
if($result1 != "") {

//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(37);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";

$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/indiPayrollList.js\"></script>";

include "../templates/indiPayrollListTemplate.php";
exit;
}


//echo"$result1";
//exit;



}


//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(36);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";

$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/searchPayrollEmployee.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTextPayroll.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";

//print out the search form
include "../templates/searchIndiPayrollTemplate.php";

?>