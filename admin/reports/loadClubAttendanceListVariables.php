<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$ajax_switch = $_REQUEST['ajax_switch'];
$attendance_type = $_REQUEST['attendance_type'];
$service_location = $_REQUEST['service_location'];
$from_date = $_REQUEST['from_date'];
$to_date = $_REQUEST['to_date'];
$report_name = $_REQUEST['report_name'];
$report_type = $_REQUEST['report_type'];
              
                     
if($ajax_switch == "1")  {

$_SESSION['report_name'] = $report_name;
$_SESSION['report_type'] = $report_type;
$_SESSION['from_date'] = $from_date;
$_SESSION['to_date'] = $to_date;
$_SESSION['attendance_type'] = $attendance_type;
$_SESSION['service_location'] = $service_location;


$success_bit = "1";
echo"$success_bit ";
exit;

}

?>
