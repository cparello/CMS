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
$javaScript6
$javaScript7



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
<table border="0" align="center" cellspacing="5" cellpadding="5">

<tr>
<td class="black">
1.  Select Schedule Category:&nbsp;&nbsp;
</td>
<td>
<select name="schedule_type"  id="schedule_type" class="black3"/>
$schedule_type_drops
</select>
</td>
</tr>

<tr>
<td class="black">
2.  Select /Create Name for schedule:&nbsp;&nbsp;
</td>
<td>
<select name="bundle_type"  id="bundle_type" class="black3"/>
$bundle_type_drops
</select>
&nbsp;&nbsp
<a class="black"  id="saveBut"  href = "javascript:void(0)">Create a Name</a>
</td>
</tr>



<tr>
<td class="black" valign="top">
3.  Assign Services:&nbsp;&nbsp;
</td>


<td>
<div id="listHouse">
</div>
</td>
</tr>



<tr>
<td>
</td>
<td class="black termSpace" colspan="2" align="left">
<input type="button" id="button1" class="button1" name="button1" value="Save Bundle" />
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


<div class="chartSave"  id="chartSave">
<img class="menu_exit"   id="menu_exit" src="../images/popx.png" alt="" />
<div id="saveForm">
<table cellpadding="2" border="0">
<tr>
<td>
Schedule Name  
</td>
<td>
<input type="text" id="bundle_name" name="bundle_name" size="30" maxlength="40"/>
</td>
</tr>
<tr>
<td>
&nbsp;
</td>
<td class="tPad" align="right">
<input  type="button" class="button1" id="button2" name="save" value="Save Name"/>
</td>
</tr>
</table>
</div>
</div>
</form>

</body>
</html>
LOCATIONTEMPLATE;


echo"$locationTemplate";
?>