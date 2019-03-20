<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
                 
$ajax_switch = $_REQUEST['ajax_switch'];
$report_name = $_REQUEST['report_name'];
$from_date = $_REQUEST['from_date'];
$to_date = $_REQUEST['to_date'];
$schedule_type = $_REQUEST['schedule_type'];
$service_location = $_REQUEST['service_location'];
$class_name = $_REQUEST['class_name'];
$summary_rows = $_REQUEST['summary_rows'];
$print_chart = $_REQUEST['print_chart'];          
$attendance_type = $_REQUEST['attendance_type'];  
                    
if($ajax_switch == "1")  {

$_SESSION['report_name'] = $report_name;
$_SESSION['report_type'] = $report_type;
$_SESSION['from_date'] = $from_date;
$_SESSION['to_date'] = $to_date;
$_SESSION['schedule_type'] = $schedule_type;
$_SESSION['class_name'] = $class_name;
$_SESSION['service_location'] = $service_location;
$_SESSION['summary_rows'] = $summary_rows;
$_SESSION['print_chart'] = $print_chart;

$success_bit = "1";
echo"$success_bit ";
exit;

}

?>
