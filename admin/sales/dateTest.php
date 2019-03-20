<?php

//this will eventully be set to the users local time zone
date_default_timezone_set('America/Los_Angeles');

//$monthly_amount = trim($monthly_amount);

//get the current day number of the month and the numberof days in the month
//$current_day_number = date(d);
//$month_days_number = date(t);

//$theDate = date('g i');

//divide the month amount by the number of days
//$daily_amount = $monthly_amount / $month_days_number;
//get the difference between the days
//$date_difference = $month_days_number - $current_day_number;

//create the pro rate amount and format it
//$pro_rate_amount = $date_difference * $daily_amount;
//$pro_rate_amount = sprintf("%.2f", $pro_rate_amount);

//echo date('D,F j, Y, h:i:s A');
//$groupPrice = 4000.00;
//$numberMonths = 12;

//$monthlyDues = $groupPrice / $numberMonths;


//$monthlyDues = sprintf("%.2f", $groupPrice / $numberMonths);

$current_month = date(m);
$month_days_number = date(t);
$current_year = date(Y);
$proDateEnd = "$current_year-$current_month-$month_days_number";

$numberMonths  = 2;
$termMonths = $numberMonths + 1;


 $startDate= date("Y-m-d"  ,mktime(0, 0, 0, date("m")+1  ,1, date("Y")));
 
 $endDate = date("Y-m-d"  ,mktime(0, 0, 0, date("m")+$termMonths  ,1, date("Y")));
 

//date("Y-m-t", strtotime($dob));

$timeString = "Fri, July 1, 2011";

$h =  strtotime($timeString);
$new_time = date("Y-m-d", $h);

$noteDate = date("Y-m-d H:i:s", mktime(date("H"), date("i"), date("s"), date("m")  ,date("d"), date("Y")));
$am_pm = date("a");





echo"$noteDate   $am_pm ";



?>
