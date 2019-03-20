<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$schedule_list_template= <<<SCHEDULELIST
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/scheduleList.css">
<link rel="stylesheet" href="../css/pop_hint.css">
<link rel="stylesheet" href="../css/base/jquery.ui.all.css">
<link rel="stylesheet" href="../css/demos.css">
<link rel="stylesheet" href="../css/bookForm.css">

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
$javaScript12
$javaScript13
$javaScript14
$javaScript15

<script>
$(function() {
$( "#datepicker" ).datepicker();
});
</script>

<title>Class Scheduler</title>
</head>
<body>
<div id="masking">
</div>

<div id="typeHeader">
Class Schedules
</div>


<div id="scheduleOptions">
<table border="0" align="left" cellspacing="0" cellpadding="0">
<tr>
<td align="left" class="black">
Date: &nbsp;
</td>
<td>
<input type="text" id="datepicker" size="10" value="$class_date" /><a href="javascript: void" id="pos7" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -30, 0, 'pos7', 7);" /><img src="../images/question-mark.png" class="alignMiddle"></a> 
</td>
<td align="left" class="black spacer1">
Filter by Category: &nbsp;
</td>
<td align="left" class="black">
<select name="schedule_type"  id="schedule_type"/>
$schedule_type_drops
</select>
</td>
<td align="left" colspan="2" class="black spacer1">
<input type="button" name="view_classes" id="viewClasses" value="View Classes">
</td>
</tr>
</table>
</div>

<div id="classList">
</div>



<div class="popHint"   id="popup" style="display: none;">
<div class="menu_form_header" id="popup_drag">
<img class="menu_form_exit"   id="popup_exit" src="../images/popx.png" alt="" />
<span id= "contHint">
</span>
</div>
</div>

<div id="bookWindow">
<table id="secTab" align="left" cellspacing="3" cellpadding="3" width="650" >
<tr>
<td class="black3" colspan="3">
<form id="form1">
<span id="bookCancel">Book Class: </span><span class="empTxt2" id="classType"></span>
</td>
<td class="closeX">
<span class="close">X</span>
</td>
</tr>
<tr>
<td class="black tabPad4" valign="baseline" id="radioMN">
Member:  <input type="radio" name="active" id="active1" value="M" checked/>
&nbsp;&nbsp;&nbsp;
Non Member:  <input type="radio" name="active" id="active2" value="N" />
</td>
<td class="black tabPad4" valign="baseline">
Member ID:  &nbsp; <input type="text" size="20" id="memberId" value=""/>
<span id="memField">
&nbsp;&nbsp;
<input type="submit" name="bookClass" id="bookClass" value="Book Class" class="button1" />
</span>
<input type="hidden" id="class_name" name="class_name" value=""/>
</form>
</td>
</tr>


<tr>
<td colspan="2">
<div id="classOptions">
</div>
</td>
</tr>


<tr>
<td colspan="2">
<div id="paymentWindow">
<table id="secTab" align="center" cellspacing="3" cellpadding="3" width="650" >
<tr>
<td colspan="2" bgcolor="#4A4B4C" class="oBtext tile3" width="50%">
Credit Card Payment
</td>
<td colspan="2" bgcolor="#4A4B4C" class="oBtext tile4" width="50%">
&nbsp;
</td>
</tr>

<tr>
<td class="black2 tile3">
Name on Card:
</td>
<td class="rightBorder">
<input name="card_name" type="text" id="card_name" value="" size="25" maxlength="300"/>
</td>
<td class="black2">
Card Type:
</td>
<td class="tile4">
<select name="card_type" id="card_type"/>
  <option value>Card Type</option>
  <option value="Visa">Visa</option>
  <option value="MC">MasterCard</option>
  <option value="Amex">American Express</option>
  <option value="Disc">Discover</option>
</select>
</td>
</tr>

<tr>
<td class="black2 tile3">
Card Number:
</td>
<td class="rightBorder">
<input  name="card_number" type="text" id="card_number" value="" size="25" maxlength="25"/>
</td>
<td class="black2">
Security Code:
</td>
<td class="tile4">
<input name="card_cvv" type="text" id="card_cvv" value="" size="25" maxlength="4"/>
</td>
</tr>

<tr>
<td class="black2 tile3">
Expiration Date:
</td>
<td class="rightBorder">
$month_drop
$year_drop
</td>
<td class="black2">
Credit Payment:
</td>
<td class="tile4">
<input name="credit_pay" type="text" id="credit_pay" value="" size="25" maxlength="10"/>
</td>
</tr>


<tr>
<td colspan="2" bgcolor="#4A4B4C" class="oBtext tile3" width="50%">
Cash Payment
</td>
<td colspan="2" bgcolor="#4A4B4C" class="oBtext tile4" width="50%">
Check Payment
</td>
</tr>
<tr>
<td class="black2 tile3 tile5">
Cash Payment:
</td>
<td class="rightBorder tile5">
<input name="cash_pay" type="text" id="cash_pay" value="" size="25" maxlength="10"/>
</td>
<td class="black2 tile5">
Check Payment / Number:
</td>
<td class="tile4 tile5">
<input  name="check_pay" type="text" id="check_pay" value="" size="12" maxlength="10"/>
&nbsp;
<input name="check_number" type="text" id="check_number" value="" size="9" maxlength="10"/>
</td>
</tr>


<tr>
<td colspan="4">
<div id="nmInfo" class="black2">
<table align="left" cellspacing="3" cellpadding="3" width="100%">
<tr>
<td>
First Name: 
</td>
<td>
<input type="text" size="20" id="sm_fname" value=""/>
</td>
<td>
Last Name:
</td>
<td>
<input type="text" size="20" id="sm_lname" value=""/>
</td>
</tr>
<tr>
<td>
Email: 
</td>
<td>
<input type="text" size="20" id="sm_email" value=""/>
</td>
<td>
Phone:
</td>
<td>
<input type="text" size="20" id="sm_phone" value=""/>
</td>
</tr>
</table>
</div>
</td>
</tr>


<tr>
<td class="tabPad3">
</td>
<td class="tabPad3" align="left">
<input type="button" name="purchase_class" id="purchase_class" value="Process Class Payment" class="button1" />
</td>
<td class="tabPad3" align="center" colspan="2">
<input type="button" name="print_receipt" id="print_receipt" value="Print Receipt" class="button1" />
 &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
 <input type="button" name="waiver" id="waiver" value="Print Waiver" class="button1"/>
</td>
</tr>
</table>
</div>
</td>
</tr>
</table>
</div>

<input type="hidden" name="schedule_id" id="schedule_id" value=""/>
<input type="hidden" name="bundle_id" id="bundle_id" value=""/>
<input type="hidden" name="class_text" id="class_text" value=""/>
<input type="hidden" name="type_id" id="type_id" value=""/>
<input type="hidden" name="location_id" id="location_id" value=""/>
<input type="hidden" name="time_slot" id="time_slot" value=""/>
<input type="hidden" name="booking_count" id="booking_count" value=""/>
<input type="hidden" id="purchase_marker" name="purchase_marker" value=""/>

</body>
</html>
SCHEDULELIST;
echo"$schedule_list_template";
?>