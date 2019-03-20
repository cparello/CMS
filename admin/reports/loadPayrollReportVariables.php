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
$payment_cycle_name = $_REQUEST['payment_cycle_name'];
$compensation_name = $_REQUEST['compensation_name'];
$employee_type_name = $_REQUEST['employee_type_name'];
$ot_type_name = $_REQUEST['ot_type_name'];
$summary_rows = $_REQUEST['summary_rows'];
$print_chart = $_REQUEST['print_chart'];
              
                    
if($ajax_switch == "1")  {

$_SESSION['report_name'] = $report_name;
$_SESSION['from_date'] = $from_date;
$_SESSION['to_date'] = $to_date;
$_SESSION['club_name'] = $club_name;
$_SESSION['payment_cycle_name'] = $payment_cycle_name;
$_SESSION['compensation_name'] = $compensation_name;
$_SESSION['employee_type_name'] = $employee_type_name;
$_SESSION['ot_type_name'] = $ot_type_name;
$_SESSION['summary_rows'] = $summary_rows;
$_SESSION['print_chart'] = $print_chart;


$success_bit = "1";
echo"$success_bit ";
exit;

}

?>























}