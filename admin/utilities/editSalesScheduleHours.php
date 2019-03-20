<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$shift_1_start = $_REQUEST['shift_1_start'];
$shift_1_end = $_REQUEST['shift_1_end'];
$shift_2_start = $_REQUEST['shift_2_start'];
$shift_2_end = $_REQUEST['shift_2_end'];
$marker = $_REQUEST['marker'];
include "salesScheduleSql.php";




//sets up the varibles for the form template
$submit_link = 'editSalesScheduleHours.php';
$submit_name = 'update';
$submit_title = "Update Options";
$page_title  = 'Edit Sales Schedule';
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtSalesSchedule.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";

//echo "m $marker";

//if form is submitted save to database
if ($marker == 1) {
$updateInfo = new salesScheduleSql();
$updateInfo-> setShiftStart1($shift_1_start);
$updateInfo-> setShiftEnd1($shift_1_end);
$updateInfo-> setShiftStart2($shift_2_start);
$updateInfo-> setShiftEnd2($shift_2_end);
$confirmation = $updateInfo-> updateSalesScheduleHours();
}

//echo"fubar22";

//load the form content
$loadInfo = new salesScheduleSql();
$loadInfo-> loadSalesScheduleHours();
$start1 = $loadInfo-> getStart1();
$end1 = $loadInfo-> getEnd1();
$start2 = $loadInfo-> getStart2();
$end2 = $loadInfo-> getEnd2();

//echo"fubar  $end2 v $start1";
switch($start1) {
    case '0':
        $shift_1_start_txt = "No Shift";
    break;
    case '1':
        $shift_1_start_txt = "1 AM";
    break;
    case '2':
        $shift_1_start_txt = "2 AM";
    break;
    case '3':
        $shift_1_start_txt = "3 AM";
    break;
    case '4':
        $shift_1_start_txt = "4 AM";
    break;
    case '5':
        $shift_1_start_txt = "5 AM";
    break;
    case '6':
        $shift_1_start_txt = "6 AM";
    break;
    case '7':
        $shift_1_start_txt = "7 AM";
    break;
    case '8':
        $shift_1_start_txt = "8 AM";
    break;
    case '9':
        $shift_1_start_txt = "9 AM";
    break;
    case '10':
        $shift_1_start_txt = "10 AM";
    break;
    case '11':
        $shift_1_start_txt = "11 AM";
    break;
    case '12':
        $shift_1_start_txt = "12 PM";
    break;
    case '13':
        $shift_1_start_txt = "1 PM";
    break;
    case '14':
        $shift_1_start_txt = "2 PM";
    break;
    case '15':
        $shift_1_start_txt = "3 PM";
    break;
    case '16':
        $shift_1_start_txt = "4 PM";
    break;
    case '17':
        $shift_1_start_txt = "5 PM";
    break;
    case '18':
        $shift_1_start_txt = "6 PM";
    break;
    case '19':
        $shift_1_start_txt = "7 PM";
    break;
    case '20':
        $shift_1_start_txt = "8 PM";
    break;
    case '21':
        $shift_1_start_txt = "9 PM";
    break;
    case '22':
        $shift_1_start_txt = "10 PM";
    break;
    case '23':
        $shift_1_start_txt = "11 PM";
    break;
    case '24':
        $shift_1_start_txt = "12 AM";
    break;
    default:
        $shift_1_start_txt = "No Shift";
    break;
    
}

switch($end1) {
    case '0':
        $shift_1_end_txt = "No Shift";
    break;
    case '1':
        $shift_1_end_txt = "1 AM";
    break;
    case '2':
        $shift_1_end_txt = "2 AM";
    break;
    case '3':
        $shift_1_end_txt = "3 AM";
    break;
    case '4':
        $shift_1_end_txt = "4 AM";
    break;
    case '5':
        $shift_1_end_txt = "5 AM";
    break;
    case '6':
        $shift_1_end_txt = "6 AM";
    break;
    case '7':
        $shift_1_end_txt = "7 AM";
    break;
    case '8':
        $shift_1_end_txt = "8 AM";
    break;
    case '9':
        $shift_1_end_txt = "9 AM";
    break;
    case '10':
        $shift_1_end_txt = "10 AM";
    break;
    case '11':
        $shift_1_end_txt = "11 AM";
    break;
    case '12':
        $shift_1_end_txt = "12 PM";
    break;
    case '13':
        $shift_1_end_txt = "1 PM";
    break;
    case '14':
        $shift_1_end_txt = "2 PM";
    break;
    case '15':
        $shift_1_end_txt = "3 PM";
    break;
    case '16':
        $shift_1_end_txt = "4 PM";
    break;
    case '17':
        $shift_1_end_txt = "5 PM";
    break;
    case '18':
        $shift_1_end_txt = "6 PM";
    break;
    case '19':
        $shift_1_end_txt = "7 PM";
    break;
    case '20':
        $shift_1_end_txt = "8 PM";
    break;
    case '21':
        $shift_1_end_txt = "9 PM";
    break;
    case '22':
        $shift_1_end_txt = "10 PM";
    break;
    case '23':
        $shift_1_end_txt = "11 PM";
    break;
    case '24':
        $shift_1_end_txt = "12 AM";
    break;
    default:
        $shift_1_end_txt = "No Shift";
    break;
    
}

switch($start2) {
    case '0':
        $shift_2_start_txt = "No Shift";
    break;
    case '1':
        $shift_2_start_txt = "1 AM";
    break;
    case '2':
        $shift_2_start_txt = "2 AM";
    break;
    case '3':
        $shift_2_start_txt = "3 AM";
    break;
    case '4':
        $shift_2_start_txt = "4 AM";
    break;
    case '5':
        $shift_2_start_txt = "5 AM";
    break;
    case '6':
        $shift_2_start_txt = "6 AM";
    break;
    case '7':
        $shift_2_start_txt = "7 AM";
    break;
    case '8':
        $shift_2_start_txt = "8 AM";
    break;
    case '9':
        $shift_2_start_txt = "9 AM";
    break;
    case '10':
        $shift_2_start_txt = "10 AM";
    break;
    case '11':
        $shift_2_start_txt = "11 AM";
    break;
    case '12':
        $shift_2_start_txt = "12 PM";
    break;
    case '13':
        $shift_2_start_txt = "1 PM";
    break;
    case '14':
        $shift_2_start_txt = "2 PM";
    break;
    case '15':
        $shift_2_start_txt = "3 PM";
    break;
    case '16':
        $shift_2_start_txt = "4 PM";
    break;
    case '17':
        $shift_2_start_txt = "5 PM";
    break;
    case '18':
        $shift_2_start_txt = "6 PM";
    break;
    case '19':
        $shift_2_start_txt = "7 PM";
    break;
    case '20':
        $shift_2_start_txt = "8 PM";
    break;
    case '21':
        $shift_2_start_txt = "9 PM";
    break;
    case '22':
        $shift_2_start_txt = "10 PM";
    break;
    case '23':
        $shift_2_start_txt = "11 PM";
    break;
    case '24':
        $shift_2_start_txt = "12 AM";
    break;
    default:
        $shift_2_start_txt = "No Shift";
    break;
    
}

switch($end2) {
    case '0':
        $shift_2_end_txt = "No Shift";
    break;
    case '1':
        $shift_2_end_txt = "1 AM";
    break;
    case '2':
        $shift_2_end_txt = "2 AM";
    break;
    case '3':
        $shift_2_end_txt = "3 AM";
    break;
    case '4':
        $shift_2_end_txt = "4 AM";
    break;
    case '5':
        $shift_2_end_txt = "5 AM";
    break;
    case '6':
        $shift_2_end_txt = "6 AM";
    break;
    case '7':
        $shift_2_end_txt = "7 AM";
    break;
    case '8':
        $shift_2_end_txt = "8 AM";
    break;
    case '9':
        $shift_2_end_txt = "9 AM";
    break;
    case '10':
        $shift_2_end_txt = "10 AM";
    break;
    case '11':
        $shift_2_end_txt = "11 AM";
    break;
    case '12':
        $shift_2_end_txt = "12 PM";
    break;
    case '13':
        $shift_2_end_txt = "1 PM";
    break;
    case '14':
        $shift_2_end_txt = "2 PM";
    break;
    case '15':
        $shift_2_end_txt = "3 PM";
    break;
    case '16':
        $shift_2_end_txt = "4 PM";
    break;
    case '17':
        $shift_2_end_txt = "5 PM";
    break;
    case '18':
        $shift_2_end_txt = "6 PM";
    break;
    case '19':
        $shift_2_end_txt = "7 PM";
    break;
    case '20':
        $shift_2_end_txt = "8 PM";
    break;
    case '21':
        $shift_2_end_txt = "9 PM";
    break;
    case '22':
        $shift_2_end_txt = "10 PM";
    break;
    case '23':
        $shift_2_end_txt = "11 PM";
    break;
    case '24':
        $shift_2_end_txt = "12 AM";
    break;
    default:
        $shift_2_end_txt = "No Shift";
    break;
    
}
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(83);
$info_text = $getText -> createTextInfo();

include "../templates/infoTemplate2.php";
include "../templates/salesScheduleHoursTemplate.php";




?>
