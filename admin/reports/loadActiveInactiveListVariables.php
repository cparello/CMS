<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$ajax_switch = $_REQUEST['ajax_switch'];
$category_type = $_REQUEST['category_type'];
$service_location = $_REQUEST['service_location'];
$date_range = $_REQUEST['date_range'];
$report_name = $_REQUEST['report_name'];
$report_type = $_REQUEST['report_type'];
                
                  
if($ajax_switch == "1")  {

$_SESSION['category_type'] = $category_type;
$_SESSION['service_location'] = $service_location;
$_SESSION['date_range'] = $date_range;
$_SESSION['report_name'] = $report_name;
$_SESSION['report_type'] = $report_type;


$success_bit = "1";
echo"$success_bit ";
exit;

}

?>
