<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$user_id = $_POST["user_id"];
$id_card = $_POST["id_card"];
$employee_name = $_REQUEST['employee_name'];
$time_line_start = $_REQUEST['datepicker1'];
$time_line_end = $_REQUEST['datepicker2'];

include "timeClockSql.php";

if(isset($_POST['save']))  {

    foreach($_POST['update'] as $value) {
                  
                 $valueArray = explode("|", $value);
                 $salt = $valueArray[0];
                 $time_clock_key = $valueArray[1];
                 
                 $clock_in_date = $_POST["clock_in_date$salt"];
                 $clock_in_time = $_POST["clock_in_time$salt"];
                 $clock_out_date = $_POST["clock_out_date$salt"];
                 $clock_out_time = $_POST["clock_out_time$salt"];
                 //echo"tt $clock_out_date $clock_out_time";
                // exit;
                 $update = new timeClockSql();                 
                 $update-> setClockInDate($clock_in_date);
                 $update-> setClockInTime($clock_in_time);
                 $update-> setClockOutDate($clock_out_date);
                 $update-> setClockOutTime($clock_out_time);
                 $update-> setTimeClockKey($time_clock_key);
                 $update-> setUserId($user_id);
                 $update-> setIdCard($id_card);
                 $update-> updateTimeClock();                 
                 }
                  
               $update-> setEmployeeName($employee_name);   
               $confirmation = $update-> getConfirmation();      
 }


$load = new timeClockSql();
$load-> setTimeLineStart($time_line_start);
$load-> setTimeLineEnd($time_line_end);
//echo " $time_line_start $time_line_end";
$load-> setIdCard($id_card);
$load-> setUserId($user_id);
$load-> loadTimeClock();
$listings = $load-> getTimeClockListings();


include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(35);
$info_text = $getText -> createTextInfo();

$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/checkTimeClock.js\"></script>";

include "../templates/infoTemplate2.php";
include "../templates/employeeClockListTemplate.php";
exit;



?>