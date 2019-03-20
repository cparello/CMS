<?php
$locationTemplate = <<<LOCATIONTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/services.css">
$javaScript
<title>$page_title </title>

</head>
<body>

$infoTemplate

<div id="userHeader">
$page_title 
</div>

<div id="conf" class="conf">
$confirmation &nbsp;
</div>


<div id="userForm">
  <form id="form1" name="form1" method="post" action="$submit_link" onSubmit="return send_id()">

<table border="0" align="center">
<tr>
<td colspan="2" class="grey">
<u>Location Information</u>
</td>
</tr>

<tr>
<td class="black">
Location ID:
</td>
<td>
<input tabindex= "1" name="location_id" type="text" id="location_id" value="$location_id" size="40" maxlength="30" onFocus="killHeader()"/>    
<td>
</tr>

<tr>
<td class="black" valign="top">
Location Name:
</td>
<td>
<input tabindex= "1" name="location_name" type="text" id="location_name" value="$location_name" size="40" maxlength="50"/>
<td>
</tr>


<tr>
<td class="black">
Location Address:
</td>
<td>
 <input tabindex= "1" name="location_address" type="text" id="location_address" value="$location_address" size="40" maxlength="100"/>
<td>
</tr>


<tr>
<td class="black">
Location Phone:
</td>
<td>
 <input tabindex= "1" name="location_phone" type="text" id="location_phone" value="$location_phone" size="40" maxlength="100"/>
<td>
</tr>

<tr>
<td class="black">
Location Contact:
</td>
<td>
 <input tabindex= "1" name="location_contact" type="text" id="location_contact" value="$location_contact" size="40" maxlength="100"/>
<td>
</tr>

<tr>
<td class="black">
Location State:
</td>
<td>
 <input tabindex= "1" name="state" type="text" id="state" value="$location_state" size="40" maxlength="100"/>
<td>
</tr>

<tr>
<td class="black">
Select Time Zone:
</td>
<td>
 <input tabindex= "1" name="time_zone" type="text" id="time_zone" value="time_zone" size="40" maxlength="100"/>
<td>
</tr>


<tr>
<td>
</td>
<td id="error1">
</td>
</tr>



<tr>
<td class="black termSpace" />
</td>

<td class="black termSpace" align="left"/>
<input type="submit" name="$submit_name" value="$page_title" />
&nbsp;&nbsp;<input type="reset" value="Reset">
<input name="marker" type="hidden" id="marker" value="1" /> 
<td>
</tr>

</table>
</div>



</body>
</html>
LOCATIONTEMPLATE;


echo"$locationTemplate";
?>