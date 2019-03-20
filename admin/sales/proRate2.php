<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
//=======================================================
$monthly_amount = $_REQUEST['monthly_amount'];
$end_date = $_REQUEST['end_date'];
$current_number_months = $_REQUEST['current_number_months'];
$original_monthly_amount = $_REQUEST['original_monthly_amount'];
$sid = $_REQUEST['sid']; 
//==============================================end timeout
//this will eventully be set to the users local time zone
//date_default_timezone_set('America/Los_Angeles');
//date_default_timezone_set('America/Los_Angeles');

$todays_date = strtotime('now');

$monthly_amount = trim($monthly_amount);
$original_monthly_amount = trim($original_monthly_amount);

function yearsBetween($dateStart, $dateEnd) {
   return date('Y', $dateEnd) - date('Y', $dateStart);
}





if($end_date != "") {
//sets the first of next month  gets the prorate total for remaining months
$start_date = mktime(0,0,0,date('m')+1,1,date('Y'));
$number_months = date('n', $end_date) + (yearsBetween($start_date, $end_date) * 12) - date('n', $start_date);
$static_pro_rate_total = $original_monthly_amount * $number_months;
$pro_rate_total = $monthly_amount * $number_months;
$pro_rate_total = sprintf("%.2f", $pro_rate_total);
$static_pro_rate_total = sprintf("%.2f", $static_pro_rate_total);
}else{
$pro_rate_total = 0;
$static_pro_rate_total = 0;
$pro_rate_total = sprintf("%.2f", $pro_rate_total);
$static_pro_rate_total = sprintf("%.2f", $static_pro_rate_total);
}

//get the current day number of the month and the numberof days in the month
$current_day_number = date(d);
$month_days_number = date(t);

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

if($current_number_months == $number_months) {
   $pro_rate_total = '0.00';
}

if($todays_date > $end_date) {
   $pro_rate_total = '0.00';
}

echo"$pro_rate_amount|$pro_rate_total|$number_months|$static_pro_rate_total";
exit;
?>
