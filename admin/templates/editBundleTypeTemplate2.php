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
<table border="0" align="center" cellspacing="5" cellpadding="5">

<tr>
<td class="black">
1.  Edit Schedule Name:&nbsp;&nbsp;
</td>
<td>
<input type=text" name="bundle_name" id="bundle_name" size="30" maxlength="40" value="$bundle_name" />
</td>
</tr>


<tr>
<td class="black" valign="top">
2.  Delete Services:&nbsp;&nbsp;
</td>
<td>
<div id="listHouseTwo">
$service_table
</div>
</td>
</tr>



<tr>
<td>
</td>
<td class="black termSpace" colspan="2" align="left">
<input type="button" id="button1" class="button1" name="button1" value="Edit Bundle"/>
&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" id="button2" class="button1" name="button2" value="Delete Bundle"/>
<input type="hidden" name="bundle_name_orig" id="bundle_name_orig" value="$bundle_name"/>
<input type="hidden" name="bundle_id" id="bundle_id" value="$bundle_id"/>
<input type="hidden" name="location_id" id="location_id" value="$location_id"/>
<input type="hidden" name="schedule_type" id="schedule_type" value="$schedule_type"/>
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