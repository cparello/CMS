<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$ajax_switch = $_REQUEST['ajax_switch'];
$report_name = $_REQUEST['report_name'];
$date_range = $_REQUEST['date_range'];
$category_type = $_REQUEST['category_type'];
$service_location = $_REQUEST['service_location'];
$summary_rows = $_REQUEST['summary_rows'];
$print_chart = $_REQUEST['print_chart'];
  
if($ajax_switch == "1")  {

$_SESSION['report_name'] = $report_name;
$_SESSION['date_range'] = $date_range;
$_SESSION['category_type'] = $category_type;
$_SESSION['service_location'] = $service_location;
$_SESSION['summary_rows'] = $summary_rows;
$_SESSION['print_chart'] = $print_chart;


$success_bit = "1";
echo"$success_bit ";
exit;

}

?>























}