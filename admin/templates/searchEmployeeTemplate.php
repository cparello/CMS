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
$javaScript1
$javaScript2
$javaScript3


	<title>Search Edit Employee</title>

</head>
<body>
$infoTemplate

<div id="userHeader">
Search / Edit Employee  
</div>

<div id="idContent1">   
&nbsp;
</div>

<div id="userForm1">
<form id="form1" name="form1" method="post" action="searchEmployee.php" >
<table border="0" align="center">
<tr>
<td  class="grey">
<u>Search by Employee Name</u>
</td>
</tr>
<tr>
<td>
<input tabindex= "1" name="employee_name" type="text" id="employee_name" size="25" maxlength="30"/> <a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos1', 5 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>


</td>
</tr>
<tr>
<td>
<input type="submit" name="name" value="Search Name" onClick="return send_id(1)"/>
</td>
</tr>
</table>
</div>




<div id="userForm2">
<table border="0" align="center">
<tr>
<td  class="grey">
<u>Search by Employee Type</u>
</td>
</tr>
<tr>
<td>
<select tabindex= "4" name="employee_type" id="employee_type">
$drop_menu_emp
</select>  
</td>
</tr>
<tr>
<td>
<input type="submit" name="name" value="Search Type" onClick="return send_id(2)"/>
</td>
</tr>
</table>
</div>




<div id="userForm3">
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
<input type="submit" name="name" value="Search Service Location" onClick="return send_id(3)"/>
</td>
</tr>
</table>
</div>

<div id="userForm4">
<table border="0" align="center">
<tr>
<td  class="grey">
<u>Search all Employees</u>
</td>
</tr>
<tr>
<td>
<input type="submit" name="all" value="Search All" onClick="return send_id(4)"/>
<input type="hidden" name="marker" value="1" />
</td>
</tr>
</table>
</form>
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