<?php
$searchTemplate = <<<SEARCHTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/search_employee.css">
<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/pop_hint.css">
<link rel="stylesheet" href="../css/base/jquery.ui.all.css">
<script type="text/javascript" src="../scripts/jqueryNew.js"></script>
<script type="text/javascript" src="../scripts/jquery.ui.core.js"></script>
<script type="text/javascript" src="../scripts/jquery.ui.widget.js"></script>
<script type="text/javascript" src="../scripts/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../scripts/jquery.tablesorter.js"></script>
<script type="text/javascript" src="../scripts/jquery.tablesorter.scroller.js"></script>
$javaScript1
$javaScript2
$javaScript3


	<title>Search Club Payroll</title>
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
<body onLoad="comfirmSale();">
$infoTemplate

<div id="userHeader">
Search Club Payroll  
</div>

<div id="idContent1">   
&nbsp;
</div>

<div id="userForm1">
<form id="form1" name="form1" method="post" action="payrollClubSearch.php" >
<table border="0" align="center">
<tr>
<td  class="grey">
<u>Choose Club Location</u>
</td>
</tr>
<tr>
<td>
<select  name="club_location" id="club_location"/>
$drop_menu 
</select>
</td>
</tr>
</table>
</div>


<div id="userForm2a">
<table border="0" align="center"> 
<tr>
<td  class="grey">
<u>Choose Payroll Cycle</u> 
</td>
</tr>
<tr>
<td>
<select  name="payroll_cycle" id="payroll_cycle"/>
<option value>Choose Cycle</option>
<option value="D">Daily</option>
<option value="W">Weekly</option>
<option value="B">Bi-Monthly</option>
<option value="M">Monthly</option>
</select>
</td>
</tr>
<tr>
<td  class="grey">
<u>Choose Date Range</u> 
</td>
</tr>
<tr>
<td>
FROM:&nbsp;<input type="text" id="datepicker1" name="datepicker1" size="10" value="" />
TO:&nbsp;<input type="text" id="datepicker2" name="datepicker2" size="10" value="" />
</td>
</tr>
<tr>
<td class="padTop">
<input type="submit" name="view" value="View Club Payroll Results" onClick="return checkSelections();"/>
<input name="marker" type="hidden" id="marker" value="1"/>
<input name="confirmation_message" type="hidden" id="confirmation_message" value="$confirmation_message"/>
</form>
</td>
</tr>
</table>
</div>




<div class="popHint"   id="popup" style="display: none;">
<div class="menu_form_header" id="popup_drag">
<img class="menu_form_exit"   id="popup_exit" src="../images/popx.png" alt="" />
<span id= "contHint">
</span>
</div>
</div>



</body>
</html>
SEARCHTEMPLATE;


echo"$searchTemplate";
?>