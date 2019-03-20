<?php
$employeeClockListTemplate = <<<EMPLOYEECLOCKLIST
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>


<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/service_lists.css">
$javaScript1
<title>Edit Employee Timeclock</title>
</head>
<body>

$infoTemplate

<div id="userHeader">
Edit Employee  $employee_name Timeclock  
</div>

<div id="conf" class="conf">
$confirmation 
</div>

<div id="userForm1">
<form name="form1" action="editTimeClock.php" method="post" onSubmit="return checkData()" >
$listings

<tr>
<td colspan="7">
&nbsp;
</td>
</tr>
<tr>
<td align="left" id="sub1" colspan="7">
<input  type="submit" name="save" value="Update Timeclock For $employee_name" />
&nbsp;&nbsp;<input type="reset" value="Reset"/>
<input name="id_card" type="hidden" id="id_card" value="$id_card"/>
<input name="user_id" type="hidden" id="user_id" value="$user_id"/>
<input name="time_line" type="hidden" id="time_line" value="$time_line"/>
<input name="datepicker1" type="hidden" id="datepicker1" value="$time_line_start"/>
<input name="datepicker2" type="hidden" id="datepicker2" value="$time_line_end"/>
<input name="employee_name" type="hidden" id="employee_name" value="$employee_name"/>
</td>
</tr>
<tr>
<td colspan="7">
&nbsp;
</td>
</tr>
</form>
</table>
</div>


</body>
</html>
EMPLOYEECLOCKLIST;

echo"$employeeClockListTemplate";

?>