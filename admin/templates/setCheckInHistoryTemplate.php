<?php
$setCheckInHistoryTemplate = <<<SETCHECKINHISTORYTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/memIntPasswords.css">
$javaScript1
$javaScript2

<title>Set Check In History</title>

</head>
<body>
$infoTemplate


<div id="userHeader">
Set Check In History
</div>

<div id="conf" class="conf">
&nbsp;
</div>


<div id="userForm">

<table border="0" align="center">
<tr>
<td class="grey">
<u>Interface Location</u>
</td>
</tr>

<tr>
<td>
<select name="service_location" id="service_location"/>
 $drop_menu
</select>      
</td>
</tr>

<tr>
<td class="grey spacePad">
<u>Number of Listings</u>
</td>
</tr>

<tr>
<td>
<input name="list_number" type="text" id="list_number" size="15" maxlength="3"/>
</td>
</tr>


<tr>
<td class="termSpace">
<input type="button" name="set_clist" id="set_clist" value="Set Listings Number"/>
</td>
</tr>

</table>
</div>

 

</body>
</html>
SETCHECKINHISTORYTEMPLATE;


echo"$setCheckInHistoryTemplate";
?>