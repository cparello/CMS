<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$employee_clockin_template= <<<CLOCKINTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/employeeClockIn.css">
$javaScript1
$javaScript2
$javaScript3
$javaScript4

<title>Clock In Out</title>

</head>
<body>


<div id="userHeader">
Clock In/ Out
</div>


<div id="userForm">
<table border="0" align="center" cellpadding="5">
<tr>
<td class="black tdHead">
Employee ID Number
</td>
<td>
<form id="form1">
<input  name="id_card" type="text" id="id_card" size="20" maxlength="30" value=""/>
</td>
<td class="tdInput">
<input  type="submit" class="button1" name="liability_form" value="Submit">
</td>
</tr>

<tr>
<td class="grey tdHead">
Time Clock Adjustment
</td>
<td colspan="2">
<input  name="overide_pin" type="text" class="fieldColor" id="overide_pin" value="Enter Manager Pin Number" size="20" maxlength="4" /> 
<input type="hidden" id="adjust_bool" name="adjust_bool" value="N">
<input type="hidden" name="confirmation_message"  id="confirmation_message" value="$confirmation_message"/>
</form>
</td>
</tr>
</table>
</div>

<div id="contentWindow">
<table id="secTab" align="center" cellpadding="2" border="0" class="tabBoard">
<tr class="tabHead">
<td colspan="3" class="oBtext">
Employee Information
</td>
</tr>

<tr>
<td id="employeeContent" class="pBot">

<table width="100%">
<tr>
<td rowspan="10" valign="top" class="padLft" id="empPhoto">
<img src="../memberphotos/no_photo.jpg" width="150" height="175" onClick="return loadCamera('1');" onError="this.src = '../memberphotos/no_photo.jpg'"> 
</td>
<td class="black pTopOne" valign="top">
Employee Name:
</td>
</tr>
<tr>
<td id="empName" class="empTxt" valign="top">
</td>
</tr>

<tr>
<td class="black pTopTwo" valign="top">
Employee Number:
</td>
</tr>
<tr>
<td id="empNumber" class="empTxt" valign="top">
</td>
</tr>

<tr>
<td class="black pTopTwo" valign="top">
Position:
</td>
</tr>
<tr>
<td id="jobDesc" class="empTxt" valign="top">
</td>
</tr>

<tr>
<td class="black pTopTwo" valign="top">
Clock In/ Out Status
</td>
</tr>
<tr>
<td id="clockStatus" class="empTxt" valign="top">
</td>
</tr>

<tr>
<td class="black pTopTwo" valign="top">
Clock In/ Out Time
</td>
</tr>
<tr>
<td id="clockTime" class="empTxt" valign="top">
</td>
</tr>

</table>

</td>
</tr>

</table>
</div>

</body>
</html>
CLOCKINTEMPLATE;
echo"$employee_clockin_template";
?>