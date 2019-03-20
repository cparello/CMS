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


	<title>Search Salespeople</title>

</head>
<body>
$infoTemplate

<div id="userHeader">
Search Salespeople
</div>

<div id="idContent1">   
&nbsp;
</div>

<div id="userForm1">
<form id="form1" name="form1" method="post" action="salespersonSearch3.php" >
<table border="0" align="center">
<tr>
<td  class="grey">
<u>Search by Salesperson's Name</u>
</td>
</tr>
<tr>
<td>
<input name="employee_name" type="text" id="employee_name" size="25" maxlength="30"/> <a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos1', 1 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>
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
<u>Search by Employee ID Number</u>
</td>
</tr>
<tr>
<td>
<input  name="id_card" type="text" id="id_card" size="25" maxlength="30"/> <a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 110, 'pos1', 2 );" /><img src="../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>
<tr>
<td>
<input type="submit" name="name" value="Search ID" onClick="return send_id(2)"/>
</td>
</tr>
</table>
</div>
<input name="marker" type="hidden" id="marker" value="1" />
</form>



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