<?php
$loadQwcTemplate = <<<LOADQWCTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/loadQwc.css">
<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/pop_hint.css">
$javaScript1
$javaScript2
$javaScript3
$javaScript4

	<title>QuickBooks Web Connector</title>

</head>
<body>
$infoTemplate

<div id="userHeader">
Create QuickBooks<span class="tMark">&#0174;</span> Connection File
</div>

<div id="idContent1">   
&nbsp;
</div>

<div id="userForm1">
<form id="form1" name="form1">
<table border="0" align="center">
<tr>
<td  class="grey">
<u>Employee Status</u><a href="javascript: void" id="pos3" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos3', 3 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>
</td>
</tr>
<tr>
<td>
<select  name="qb_status" id="qb_status">
<option value>Select Status</option>
<option value="1">Yes</option>
<option value="0">No</option>
</select>
<br><br>
</td>
</tr>


<tr>
<td  class="grey">
<u>Create User Name</u><a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos1', 1 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>
</td>
</tr>
<tr>
<td>
<input type="text"  name="qb_user_name"id="qb_user_name" size="25" maxlength="10"/> 
</td>
</tr>


<tr>
<td  class="grey">
<u>Create Password</u><a href="javascript: void" id="pos4" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos4', 4 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>
</td>
</tr>
<tr>
<td>
<input type="text"  name="qb_password" id="qb_password" size="25" maxlength="10"/> 
</td>
</tr>



<tr>
<td>
<input type="button" name="create" id="create" value="Create Connection File"/>
</td>
</tr>
</table>
</div>




<div id="userForm2">
<table border="0" align="center">
<tr>
<td  class="grey">
<u>Download Connection FIle</u><a href="javascript: void" id="pos2" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos2', 2 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>
</td>
</tr>
<tr>
<td>
<input type="button" name="download" id="download" value="Download File"/>
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
LOADQWCTEMPLATE;


echo"$loadQwcTemplate";
?>