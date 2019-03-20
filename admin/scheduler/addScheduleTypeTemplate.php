<?php
$locationTemplate = <<<LOCATIONTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
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
Type Name:
</td>
<td>
<input tabindex= "1" name="type_name" type="text" id="type_name" value="$type_name" size="30" maxlength="30" onFocus="killHeader()"/><a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -25, 0, 'pos1', 1);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>


<tr>
<td class="black">
Club Location:
</td>
<td>
<select name="service_location" id="service_location" class="black3"/>
$location_drop
</select>
</td>
</tr>


<tr>
<td class="black" valign="top">
Type Description:
</td>
<td>
<textarea cols="26" rows="5" name="type_description">$type_description</textarea><a href="javascript: void" id="pos2" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -25, -85, 'pos2', 2 );" /><img src="../images/question-mark.png" class="alignTop"></a>    
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
<input type="button" id="button1" name="button1" value="$page_title" />
&nbsp;&nbsp;<input type="reset" value="Reset">
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