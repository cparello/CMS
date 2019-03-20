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
<link rel="stylesheet" href="../css/base/jquery.ui.all.css">
<link rel="stylesheet" href="../css/demos.css">
$javaScript1
$javaScript2
$javaScript3
$javaScript4
$javaScript5
$javaScript6
$javaScript7
$javaScript8
$javaScript9
$javaScript10
$javaScript11

<script>
$(function() {
$( "#datepicker" ).datepicker();
});
</script>

<title>$page_title </title>

</head>
<body>
$infoTemplate

<div id="userHeader">
$page_title 
</div>


<div id="scheduleDrops">
<table border="0" align="left" cellspacing="0" cellpadding="0">
<tr>
<td class="black">
1.  Select Category:&nbsp;&nbsp;
</td>
<td>
<select name="schedule_type"  id="schedule_type" class="black3"/>
$schedule_type_drops
</select>
</td>
<td class="black">
&nbsp;&nbsp;&nbsp;
2.  Select Class Type:&nbsp;&nbsp;
</td>
<td>
<select name="bundle_type"  id="bundle_type" class="black3"/>
$bundle_type_drops
</select>
</td>
</tr>
<tr>
<td colspan="2" class="colSpace1">
All Sessions of this Class
<td>
</tr>
</table>
</div>

<div id="classList">

</div>

<div id="addEditHeader">
Add/Edit Class Session:
</div>

<div id="addEditContent">
<table id="tableBord" align="left" cellpadding="3" cellspacing= "0" width="100%">
<tr>
<td class="bordRight bColor" width="50%">

<table align="left" cellpadding="0" cellspacing= "0" width="100%">
<tr>
<td class="padOne blackTwo" colspan="2">
Time Slot
</td>
</tr>

<tr>
<td class="padTwo black">
Select days of class session
</td>
<td class="black">
<form id="form">
S<input type="checkbox" name="access_day" class="accessDay" value="1" />
M<input type="checkbox" name="access_day" class="accessDay" value="2" />
T<input type="checkbox" name="access_day" class="accessDay" value="3" />
W<input type="checkbox" name="access_day" class="accessDay" value="4" />
T<input type="checkbox" name="access_day" class="accessDay"value="5" />
F<input type="checkbox" name="access_day" class="accessDay" value="6" />
S<input type="checkbox" name="access_day" class="accessDay" value="7" />          
</td>
<tr>

<tr>
<td class="padTwo black">
Time
</td>
<td>
<select name="hour" id="hour"/>
<option value>Hour</option>
<option value="1:">1:</option>
<option value="2:">2:</option>
<option value="3:">3:</option>
<option value="4:">4:</option>
<option value="5:">5:</option>
<option value="6:">6:</option>
<option value="7:">7:</option>
<option value="8:">8:</option>
<option value="9:">9:</option>
<option value="10:">10:</option>
<option value="11:">11:</option>
<option value="12:">12:</option>
</select>
&nbsp;
<select name="minutes" id="minutes"/>
<option value>Min</option>
<option value="0">00</option>
<option value="5">05</option>
<option value="10">10</option>
<option value="15">15</option>
<option value="20">20</option>
<option value="25">25</option>
<option value="30">30</option>
<option value="35">35:</option>
<option value="40">40</option>
<option value="45">45</option>
<option value="50">50</option>
<option value="55">55</option>
</select>
&nbsp;
<select name="AP" id="AP"/>
<option value="AM" selected>AM</option>
<option value="PM">PM</option>
</select>
</td>
</tr>

<tr>
<td class="padTwo black">
Is this a reoccurring session?
</td>
</td>
<td class="black">
<input type="radio" name="recur" class="recursiveOne" value="Y" checked/>
Yes
&nbsp;&nbsp;&nbsp;
<input type="radio" name="recur" class="recursiveTwo" value="N" />
No
&nbsp;&nbsp;&nbsp;
<span id="datePick">
<input type="text" id="datepicker" size="10"/><a href="javascript: void" id="pos6" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -30, -200, 'pos6', 6);" /><img src="../images/question-mark.png" class="alignMiddle"></a> 
</span>
</td>
</tr>

<tr>
<td class="padTwo black">
Capacity
</td>
<td>
<input type="text" size="6" id="capacity" value=""/>
</td>
</tr>

<tr>
<td class="padTwo black">
Minutes of Class
</td>
<td>
<input type="text" size="6" id="classMinutes" value=""/>
</td>
</tr>

<tr>
<td class="padThree black" colspan="2">
</td>
</tr>

</td>
</tr>
</table>




</td>
<td class="bColor" width="50%" valign="top">

<table align="left" cellpadding="0" cellspacing= "0" width="70%">
<tr>
<td class="padOne blackTwo" colspan="2" >
Details
</td>
</tr>

<tr>
<td class="padTwo black">
Select Instructor
</td>
<td>
<select name="instructor" id="instructor"/>
<option value>Select Instructor</option>
</select>
</td>
</tr>

<tr>
<td class="padTwo black">
Room
</td>
<td>
<select name="room" id="room"/>
<option value>Select Room</option>
</select>
</td>
</tr>

<tr>
<td class="padTwo black">
Session is
</td>
<td class="black">
<input type="radio" name="active" id="active1" value="Y" checked/>
Active
&nbsp;&nbsp;&nbsp;
<input type="radio" name="active" id="active2" value="N" />
On Hold
</td>
</tr>

<tr>
<td class="padFour">
&nbsp;
</td>
<td class="padFour">
</form>
<input type="button" id="button1" class="button1" name="button1" value="Add Schedule" />
<input type="hidden" name="addEdit" id="addEdit" value=""/>
<input type="hidden" name="schedule_id" id="schedule_id" value=""/>
</td>
</tr>
</table>
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
LOCATIONTEMPLATE;


echo"$locationTemplate";
?>