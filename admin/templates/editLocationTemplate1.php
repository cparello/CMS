<?php
$locationTemplate = <<<LOCATIONTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/service_locations.css">
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
<form id="form1" name="form1" method="post" action="$submit_link"/>

<table border="0" align="center">
<tr>
<td class="grey">
<u>Location Information</u>
</td>
</tr>

<tr>
<td>
<select tabindex= "4" name="service_location" id="service_location"/>
  $drop_menu
</select>      
<td>
</tr>

<tr>
<td id="error1">
</td>
</tr>



<tr>
<td class="black termSpace" colspan="2" align="left">
<input type="submit" name="edit" value="Edit" onClick="return chooseLocation();"/>
&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="delete" value="Delete" onClick="return confirmDelete();" />
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