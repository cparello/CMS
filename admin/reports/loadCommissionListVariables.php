<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$service_location = $_REQUEST['service_location'];
$employee_type = $_REQUEST['employee_type'];
$employee_name = $_REQUEST['employee_name'];
$service_type_name = $_REQUEST['service_type_name'];      
$report_type = $_REQUEST['report_type'];
$service_type = $_REQUEST['service_type'];              
$ajax_switch = $_REQUEST['ajax_switch'];
$from_date = $_REQUEST['from_date'];
$to_date = $_REQUEST['to_date'];
$report_name = $_REQUEST['report_name'];



if($ajax_switch == "1")  {

$_SESSION['report_name'] = $report_name;
$_SESSION['report_type'] = $report_type;
$_SESSION['from_date'] = $from_date;
$_SESSION['to_date'] = $to_date;
$_SESSION['service_location'] = $service_location;
$_SESSION['employee_type'] = $employee_type;
$_SESSION['employee_name'] = $employee_name;
$_SESSION['service_type'] = $service_type;

$success_bit = "1";
echo"$success_bit ";
exit;

}

?>
