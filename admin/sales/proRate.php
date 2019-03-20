<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
//=======================================================
$monthly_amount = $_REQUEST['monthly_amount'];
$sid = $_REQUEST['sid']; 
//==============================================end timeout
//this will eventully be set to the users local time zone
//date_default_timezone_set('America/Los_Angeles');
//date_default_timezone_set('America/Los_Angeles');


$monthly_amount = trim($monthly_amount);

//get the current day number of the month and the numberof days in the month
$current_day_number = date('d');
$month_days_number = date('t');

//divide the month amount by the number of days
$daily_amount = $monthly_amount / $month_days_number;
//get the difference between the days
$date_difference = $month_days_number - $current_day_number;

//create the pro rate amount and format it
$pro_rate_amount = $date_difference * $daily_amount;
$pro_rate_amount = sprintf("%.2f", $pro_rate_amount);

if($pro_rate_amount == "" || $pro_rate_amount == 0) {
  $pro_rate_amount = '0.00';
}

echo"$pro_rate_amount";
exit;
?>
