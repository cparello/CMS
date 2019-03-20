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
<form name="form1" method="post" action="editScheduleBundle2.php">
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
2.  Select Schedule Name:&nbsp;&nbsp;
</td>
<td>
<select name="bundle_type"  id="bundle_type" class="black3"/>
$bundle_type_drops
</select>
</td>
</tr>

<tr>
<td>
</td>
<td class="black termSpace" colspan="2" align="left">
<input type="submit" id="button1" class="button1" name="button1" value="View Edit Options" />
<input type="hidden" name="bundle_name" id="bundle_name" value=""/>
<input type="hidden" name="bundle_id" id="bundle_id" value=""/>
<input type="hidden" name="location_id" id="location_id" value=""/>
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


</form>

</body>
</html>
LOCATIONTEMPLATE;


echo"$locationTemplate";
?>