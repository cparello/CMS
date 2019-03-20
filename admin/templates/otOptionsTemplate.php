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

<title>Set Overtime Options</title>

</head>
<body>
$infoTemplate


<div id="userHeader">
Set Overtime Options
</div>

<div id="conf" class="conf">
&nbsp;
</div>


<div id="userForm">

<table border="0" align="center">
$html
<input name="ajax_switch" type="hidden" id="ajax_switch" value="2" /> 
<tr>
<td class="termSpace">
<input type="button" name="set_overtime" id="set_overtime" value="Set Overtime Rules"/>
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