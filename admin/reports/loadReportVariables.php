<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$ajax_switch = $_REQUEST['ajax_switch'];
$report_name = $_REQUEST['report_name'];
$from_date = $_REQUEST['from_date'];
$to_date = $_REQUEST['to_date'];
$club_name = $_REQUEST['club_name'];
$group_name = $_REQUEST['group_name'];
$service_type_name = $_REQUEST['service_type_name'];
$service_type_options_name = $_REQUEST['service_type_options_name'];
$sales_type = $_REQUEST['sales_type'];
$sales_name = $_REQUEST['sales_name'];
$summary_rows = $_REQUEST['summary_rows'];
$print_chart = $_REQUEST['print_chart'];
               
                     
if($ajax_switch == "1")  {

$_SESSION['report_name'] = $report_name;
$_SESSION['from_date'] = $from_date;
$_SESSION['to_date'] = $to_date;
$_SESSION['club_name'] = $club_name;
$_SESSION['group_name'] = $group_name;
$_SESSION['service_type_name'] = $service_type_name;
$_SESSION['service_type_options_name'] = $service_type_options_name;
$_SESSION['sales_type'] = $sales_type;
$_SESSION['sales_name'] = $sales_name;
$_SESSION['summary_rows'] = $summary_rows;
$_SESSION['print_chart'] = $print_chart;


$success_bit = "1";
echo"$success_bit ";
exit;

}

?>























}