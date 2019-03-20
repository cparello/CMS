<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

if($ajax_switch == "1")  {

$_SESSION['report_name'] = $report_name;
$_SESSION['from_date'] = $from_date;
$_SESSION['to_date'] = $to_date;
$_SESSION['attendance_type'] = $attendance_type;
$_SESSION['service_location'] = $service_location;
$_SESSION['summary_rows'] = $summary_rows;
$_SESSION['print_chart'] = $print_chart;


$success_bit = "1";
echo"$success_bit ";
exit;

}

?>























}