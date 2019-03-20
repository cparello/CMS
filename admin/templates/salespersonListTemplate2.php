<?php
$timeClockListTemplate = <<<TIMECLOCKLIST
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>


<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/service_lists.css">
<link rel="stylesheet" href="../css/base/jquery.ui.all.css">
<script type="text/javascript" src="../scripts/jqueryNew.js"></script>
<script type="text/javascript" src="../scripts/jquery.ui.core.js"></script>
<script type="text/javascript" src="../scripts/jquery.ui.widget.js"></script>
<script type="text/javascript" src="../scripts/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../scripts/jquery.tablesorter.js"></script>
<script type="text/javascript" src="../scripts/jquery.tablesorter.scroller.js"></script>
$javaScript1
<title>Search Sales Appt Stats</title>
<script>
$(function() {
$( "#datepicker1" ).datepicker();
});
</script>
<script>
$(function() {
$( "#datepicker2" ).datepicker();
});
</script>
</head>
<body>

$infoTemplate

<div id="userHeader">
View Search Sales Appointment Stats  
</div>

<div id="conf" class="conf">
$confirmation &nbsp;
</div>

<div id="userForm1">
<tr>
<td>
<h3><p align="center">Please select a date range.</p></h3>
</td>
</tr>
<tr>
<td align="middle"  valign ="middle" bgcolor="$color">
<form style="display:inline;" method="post" action="scheduleApptStats.php">
<p align="center"><input type="text" id="datepicker1" name="datepicker1" size="10" value="" />
<input type="text" id="datepicker2" name="datepicker2" size="10" value="" />
</td>

<td align="left"  valign ="top" bgcolor="$color"/>
<input type="submit" name="edit" value="Edit"></p>
</form>
</td>
</tr> 
</table>
</div>


</body>
</html>
TIMECLOCKLIST;

echo"$timeClockListTemplate";

?>