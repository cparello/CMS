<?php
$roomTemplate = <<<ROOMTEMPLATE
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
&nbsp;
</div>


<div id="userForm">

<form>

<table border="0" align="center">
<tr>
<td class="black">
1. Class Room Name:
&nbsp;&nbsp;
</td>
<td>
<input tabindex= "1" name="room_name" type="text" id="room_name" value="$room_name" size="30" maxlength="30"/><a href="javascript: void" id="pos5" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  25, 0, 'pos5', 5 );" /><img src="../images/question-mark.png" class="alignTop"></a>    
<td>
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
<input type="submit" id="button1" name="button1" class="button1" value="$page_title" />
&nbsp;&nbsp;<input type="reset" class="button1" value="Reset">
<input name="type_id" type="hidden" id="type_id" value="$type_id"/>
<input type="hidden" name="type_name" id="type_name" value="$type_name"/>
<input type="hidden" name="schedule_type" id="schedule_type" value="$schedule_type"/>
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
ROOMTEMPLATE;


echo"$roomTemplate";
?>