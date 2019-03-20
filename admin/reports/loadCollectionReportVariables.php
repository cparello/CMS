<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$collection_type_index = $_REQUEST['collection_type_index'];
$summary_rows = $_REQUEST['summary_rows'];
$print_chart = $_REQUEST['print_chart'];              
$ajax_switch = $_REQUEST['ajax_switch'];
$collection_category = $_REQUEST['collection_category'];
$collection_type = $_REQUEST['collection_type'];
$from_date = $_REQUEST['from_date'];
$to_date = $_REQUEST['to_date'];
$report_name = $_REQUEST['report_name'];
$report_type = $_REQUEST['report_type'];
                                    
if($ajax_switch == "1")  {

$_SESSION['report_name'] = $report_name;
$_SESSION['from_date'] = $from_date;
$_SESSION['to_date'] = $to_date;
$_SESSION['collection_type'] = $collection_type;
$_SESSION['collection_type_index'] = $collection_type_index;
$_SESSION['collection_category'] = $collection_category;
$_SESSION['summary_rows'] = $summary_rows;
$_SESSION['print_chart'] = $print_chart;


$success_bit = "1";
echo"$success_bit ";
exit;

}

?>























}