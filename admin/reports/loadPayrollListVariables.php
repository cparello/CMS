<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

if($ajax_switch == "1")  {

$_SESSION['report_name'] = $report_name;
$_SESSION['report_type'] = $report_type;
$_SESSION['from_date'] = $from_date;
$_SESSION['to_date'] = $to_date;
$_SESSION['service_location'] = $service_location;
$_SESSION['payment_cycle'] = $payment_cycle;
$_SESSION['compensation_type'] = $compensation_type;
$_SESSION['employee_type'] = $employee_type;
$_SESSION['ot_type'] = $ot_type;

$success_bit = "1";
echo"$success_bit ";
exit;

}

?>
