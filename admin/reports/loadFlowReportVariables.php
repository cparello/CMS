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
$flow_name = $_REQUEST['flow_name'];
$sales_type = $_REQUEST['sales_type'];
$summary_rows = $_REQUEST['summary_rows'];
$print_chart = $_REQUEST['print_chart'];
              
                     
if($ajax_switch == "1")  {

$_SESSION['report_name'] = $report_name;
$_SESSION['from_date'] = $from_date;
$_SESSION['to_date'] = $to_date;
$_SESSION['club_name'] = $club_name;
$_SESSION['flow_name'] = $flow_name;
$_SESSION['sales_type'] = $sales_type;
$_SESSION['summary_rows'] = $summary_rows;
$_SESSION['print_chart'] = $print_chart;


$success_bit = "1";
echo"$success_bit ";
exit;

}

?>























}