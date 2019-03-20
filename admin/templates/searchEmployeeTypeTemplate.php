<?php
$searchTemplate = <<<SEARCHTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/search_services.css">
<script type="text/javascript" src="../scripts/searchEmployeeType.js"></script>

	<title>Search Edit Employee Type</title>

</head>
<body>

$infoTemplate

<div id="userHeader">
Search / Edit Employee Type 
</div>

<div id="userForm1">
<form id="form1" name="form1" method="post" action="searchEmployeeType.php" >
<table border="0" align="center">
<tr>
<td  class="grey">
<u>Search by Employee Type Name</u>
</td>
</tr>
<tr>
<td>
<input tabindex= "1" name="employee_type" type="text" id="employee_type" size="25" maxlength="30"/>
</td>
</tr>
<tr>
<td>
<input type="submit" name="name" value="Search Type Name" onClick="return send_id(1)"/>
</td>
</tr>
</table>
</div>

<div id="userForm2">
<table border="0" align="center">
<tr>
<td  class="grey">
<u>Search by Service Location</u>
</td>
</tr>
<tr>
<td>
<select tabindex= "4" name="service_location" id="service_location">
 $drop_menu
</select>  
</td>
</tr>
<tr>
<td>
<input type="submit" name="name" value="Search Service Location" onClick="return send_id(2)"/>
</td>
</tr>
</table>
</div>

<div id="userForm3">
<table border="0" align="center">
<tr>
<td  class="grey">
<u>Search all Employee Types</u>
</td>
</tr>
<tr>
<td>
<input type="submit" name="all" value="Search All" onClick="return send_id(3)"/>
<input type="hidden" name="marker" value="1" />
</td>
</tr>
</table>
</form>
</div>

<div id="idContent1">   
</div>


</body>
</html>
SEARCHTEMPLATE;


echo"$searchTemplate";
?>