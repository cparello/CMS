<?php
$otOptionsTemplate = <<<OTOPTIONSTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/memIntPasswords.css">
<link rel="stylesheet" href="../css/pop_hint.css">
$javaScript1
$javaScript2
$javaScript3
$javaScript4

<title>Set Non-Member Class Options</title>

</head>
<body>
$infoTemplate


<div id="userHeader">
Set Non-Member Class Options
</div>

<div id="conf" class="conf">
&nbsp;
</div>


<div id="userForm">

<table border="0" align="center">
<tr>
<td class="grey">
<u>Overtime State </u>
</td>
</tr>


<tr>
<td class="grey">
<u>Option 1</u>
</td>
</tr>

<tr>
<td>
<input name="quan1" type="text" id="quan1" size="15" maxlength="2" value="$quan1"/><input name="price1" type="text" id="price1" size="15" maxlength="2" value="$price1"/><a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos1', 1);" /><img src="../images/question-mark.png" class="alignMiddle"></a>
</td>
</tr>

<tr>
<td class="grey spacePad">
<u>Option 2</u>
</td>
</tr>

<tr>
<td>
<input name="quan2" type="text" id="quan2" size="15" maxlength="2" value="$quan2"/><input name="price2" type="text" id="price2" size="15" maxlength="2" value="$price2"/><a href="javascript: void" id="pos2" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos2', 2);" /><img src="../images/question-mark.png" class="alignMiddle"></a>
</td>
</tr>

<tr>
<td class="grey spacePad">
<u>Option 3</u>
</td>
</tr>

<tr>
<td>
<input name="quan3" type="text" id="quan3" size="15" maxlength="2" value="$quan3"/><input name="price3" type="text" id="price3" size="15" maxlength="2" value="$price3"/><a href="javascript: void" id="pos3" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos3', 3);" /><img src="../images/question-mark.png" class="alignMiddle"></a>
</td>
</tr>

<tr>
<td>
<input name="quan4" type="text" id="quan4" size="15" maxlength="2" value="$quan4"/><input name="price4" type="text" id="price4" size="15" maxlength="2" value="$price4"/><a href="javascript: void" id="pos4" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos4', 4);" /><img src="../images/question-mark.png" class="alignMiddle"></a>
</td>
</tr>


<input name="ajax_switch" type="hidden" id="ajax_switch" value="2" /> 
<tr>
<td class="termSpace">
<input type="button" name="set_prices" id="set_prices" value="Set Prices"/>
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
OTOPTIONSTEMPLATE;


echo"$otOptionsTemplate";
?>