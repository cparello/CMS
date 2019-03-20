<?php
$idTemplate = <<<IDTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/pins.css">
<link rel="stylesheet" href="../css/pop_hint.css">
<link rel="stylesheet" href="../css/info.css">
$javaScript2
$javaScript3
<title>$page_title</title>

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

<table border="0" align="center">
<tr>
<td colspan="2" class="grey">
<u>Sales Schedule Hours Setup</u>
</td>
</tr>

<tr>
<td class="grey">
</td>
<td class="black">
<h3>Start</h3>
</td>
<td class="grey">
</td>
<td class="black">
<h3>End</h3>
</td>
</tr>
<form id="form10" name="form1" method="post" action="editSalesScheduleHours.php" onSubmit="return checkData()">
<tr>
<td class="black">
1st Shift:
</td>
<td class="black">
<select  name="shift_1_start" id="shift_1_start" onClick="killHeader()"/>
 <option value="$start1" selected>$shift_1_start_txt</option> 
      <option value="0">No Shift</option>
      <option value="1">1 AM</option>
      <option value="2">2 AM</option>
      <option value="3">3 AM</option>
      <option value="4">4 AM</option>
      <option value="5">5 AM</option>
      <option value="6">6 AM</option>
      <option value="7">7 AM</option>
      <option value="8">8 AM</option>
      <option value="9">9 AM</option>
      <option value="10">10 AM</option>
      <option value="11">11 AM</option>
      <option value="12">12 PM</option>
      <option value="13">1 PM</option>
      <option value="14">2 PM</option>
      <option value="15">3 PM</option>
      <option value="16">4 PM</option>
      <option value="17">5 PM</option>
      <option value="18">6 PM</option>
      <option value="19">7 PM</option>
      <option value="20">8 PM</option>
      <option value="21">9 PM</option>
      <option value="22">10 PM</option>
      <option value="23">11 PM</option>
      <option value="24">12 AM</option>
</select>
<a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos1', 1);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
<td class="black">
<select  name="shift_1_end" id="shift_1_end" onClick="killHeader()"/>
 <option value="$end1" selected>$shift_1_end_txt</option> 
      <option value="0">No Shift</option>
      <option value="1">1 AM</option>
      <option value="2">2 AM</option>
      <option value="3">3 AM</option>
      <option value="4">4 AM</option>
      <option value="5">5 AM</option>
      <option value="6">6 AM</option>
      <option value="7">7 AM</option>
      <option value="8">8 AM</option>
      <option value="9">9 AM</option>
      <option value="10">10 AM</option>
      <option value="11">11 AM</option>
      <option value="12">12 PM</option>
      <option value="13">1 PM</option>
      <option value="14">2 PM</option>
      <option value="15">3 PM</option>
      <option value="16">4 PM</option>
      <option value="17">5 PM</option>
      <option value="18">6 PM</option>
      <option value="19">7 PM</option>
      <option value="20">8 PM</option>
      <option value="21">9 PM</option>
      <option value="22">10 PM</option>
      <option value="23">11 PM</option>
      <option value="24">12 AM</option>
</select>
<a href="javascript: void" id="pos2" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos2', 2);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>

<tr>
<td class="black">
2nd Shift:
</td>
<td class="black">
<select  name="shift_2_start" id="shift_2_start" onClick="killHeader()"/>
 <option value="$start2" selected>$shift_2_start_txt</option> 
      <option value="0">No Shift</option>
      <option value="1">1 AM</option>
      <option value="2">2 AM</option>
      <option value="3">3 AM</option>
      <option value="4">4 AM</option>
      <option value="5">5 AM</option>
      <option value="6">6 AM</option>
      <option value="7">7 AM</option>
      <option value="8">8 AM</option>
      <option value="9">9 AM</option>
      <option value="10">10 AM</option>
      <option value="11">11 AM</option>
      <option value="12">12 PM</option>
      <option value="13">1 PM</option>
      <option value="14">2 PM</option>
      <option value="15">3 PM</option>
      <option value="16">4 PM</option>
      <option value="17">5 PM</option>
      <option value="18">6 PM</option>
      <option value="19">7 PM</option>
      <option value="20">8 PM</option>
      <option value="21">9 PM</option>
      <option value="22">10 PM</option>
      <option value="23">11 PM</option>
      <option value="24">12 AM</option>
</select>
<a href="javascript: void" id="pos3" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos3', 3);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
<td class="black">
<select  name="shift_2_end" id="shift_2_end" onClick="killHeader()"/>
 <option value="$end2" selected>$shift_2_end_txt</option> 
      <option value="0">No Shift</option>
      <option value="1">1 AM</option>
      <option value="2">2 AM</option>
      <option value="3">3 AM</option>
      <option value="4">4 AM</option>
      <option value="5">5 AM</option>
      <option value="6">6 AM</option>
      <option value="7">7 AM</option>
      <option value="8">8 AM</option>
      <option value="9">9 AM</option>
      <option value="10">10 AM</option>
      <option value="11">11 AM</option>
      <option value="12">12 PM</option>
      <option value="13">1 PM</option>
      <option value="14">2 PM</option>
      <option value="15">3 PM</option>
      <option value="16">4 PM</option>
      <option value="17">5 PM</option>
      <option value="18">6 PM</option>
      <option value="19">7 PM</option>
      <option value="20">8 PM</option>
      <option value="21">9 PM</option>
      <option value="22">10 PM</option>
      <option value="23">11 PM</option>
      <option value="24">12 AM</option>
</select>
<a href="javascript: void" id="pos4" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos42', 4);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>

<tr>
<td>
&nbsp;
</td>
<td>
<input type="submit" name="edit_hours" value="Update Schedule Hours" />
<input type="hidden" name="marker" value="1" />
</form>
</td>
</tr>



<tr>
<td colspan="2">
&nbsp;
</td>
</tr>


<div class="popHint"   id="popup" style="display: none;">
<div class="menu_form_header" id="popup_drag">
<img class="menu_form_exit"   id="popup_exit" src="../images/popx.png" alt="" />
<span id= "contHint">
</span>
</div>
</div>

  
</body>
</html>
IDTEMPLATE;


echo"$idTemplate";

?>


