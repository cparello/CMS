<?php
$locationTemplate = <<<LOCATIONTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/scheduleType.css">
<link rel="stylesheet" href="../css/pop_hint.css">
$javaScript1
$javaScript2
$javaScript3
$javaScript4
$javaScript5

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
<form>
<table border="0" align="center">

<tr>
<td class="black">
Schedule Category:&nbsp;
</td>
<td>
<select name="schedule_type"  id="schedule_type" class="black3"/>
$schedule_type_drops
</select>
</td>
</tr>

<tr>
<td>
</td>
<td id="error1">
</td>
</tr>

<tr>
<td>
</td>
<td class="black termSpace" colspan="2" align="left">
<input type="button" id="button1" name="button1" value="Edit Category" />
&nbsp;&nbsp;
<input type="button" id="button2" name="button2" value="Delete Category" />
<input name="marker" type="hidden" id="marker" value="1" /> 
$type_key_hidden
</form>
<td>
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
LOCATIONTEMPLATE;


echo"$locationTemplate";
?>