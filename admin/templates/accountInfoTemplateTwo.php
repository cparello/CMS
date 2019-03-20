<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$firstYearName = date("Y");
$firstYearValue = date("y");
$secondYearName = date("Y")-1;
$secondYearValue = date("y")-1;
$thirdYearName = date("Y")-2;
$thirdYearValue = date("y")-2;
$fourthYearName = date("Y")-3;
$fourthYearValue = date("y")-3;
$fifthYearName = date("Y")-4;
$fifthYearValue = date("y")-4;
$sixthYearName = date("Y")-5;
$sixthYearValue = date("y")-5;
$seventhYearName = date("Y")-6;
$seventhYearValue = date("y")-6;


//$javascript14
$account_info_template= <<<ACCOUNTINFOTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/paymentFormOne.css">
<link rel="stylesheet" href="../css/notesThree.css">
<link rel="stylesheet" href="../css/memberRecords.css">
<link rel="stylesheet" href="../css/pop_hint.css">
$styleSheet1
$styleSheet2

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
$javascript12
$javascript13

$javascript15
$javascript16
<script type="text/javascript" src="../scripts/checkPrePayTwo.js"></script>

<title>Account Information</title>

</head>
<body>
<div id="masking">
</div>

<div id="masking2">
</div>

$account_notes_one

<div id="paymentWindow">
$payment_form
</div>
<div id="paymentWindow2">
$payment_form2
</div>

<div id="holdWindow">
<table id="secTab" align="left" cellspacing="3" cellpadding="3" width="100%" >
<form id="form3">
<tr>
<td class="black" valign="top">
Member Name:
</td>
<td id="memHoldName" class="blackTwo" valign="top">
&nbsp;
</td>
</tr>
<tr>
<td class="black">
Member Id:
</td>
<td id="memHoldId" class="blackTwo">
&nbsp;
</td>
</tr>
<tr>
<td class="black" valign="top">
Hold Reason:
</td>
<td>
<textarea cols="30" rows="7" name="hold_message" id="hold_message"></textarea>
</td>
</tr>
<tr>
<td class="black">
Manager Pin:
</td>
<td>
<input  name="overide_pin" type="text" class="fieldColor" id="overide_pin" value="Enter Manager Pin Number" size="20" maxlength="4" /> 
</td>
</tr>
<tr>
<td>
&nbsp;
</td>
<td id="padTopMem" >
<input type="submit" name="hold_member" id="hold_member" value="Hold Member" class="button1"/>
<input type="hidden" id="mem_member_key" name="mem_member_key" value=""/>
<input type="hidden" id="mem_member_id" name="mem_member_id" value=""/>
<input type="hidden" id="mem_member_name" name="mem_member_name" value=""/>
<input type="hidden" id="mem_contract_key" name="mem_contract_key" value=""/>
<input type="hidden" id="adjust_bool" name="adjust_bool" value="N">
</td>
</tr>
</table>
</form>
</div>

<div id="userBackBut">
<input id="goBack" name="goBack" value="Go Back" class="button1" type="submit">
</div>
<div id="userHeader">
Account Information
</div>

<div id="userForm">
<table border="0" align="center" cellpadding="5">
<tr>
<td class="black tdHead">
Contract ID Number
</td>
<td class="blackTwo">
$contract_key
</td>
</tr>
<tr>
<td class="black tdHead">
Contract Holder Name
</td>
<td class="blackTwo">
$holder_name
</td>
</tr>
<tr>
<td class="black tdHead">
Associations
</td>
<td class="blackTwo">
$association
</td>
</tr>
<tr>
<td class="black tdHead">
Account Status
</td>
<td class="blackTwo">
$account_status
</td>
</tr>
$monthlyPaymentInfo
<tr>
<td class="black tdHead" valign="top">
Services
</td>
<td class="blackTwo" valign="top">
$service_list
</td>
</tr>
<tr>
<td class="pTopThree tdHeadTwo" valign="top">
<input type="button" name="account_notes" id="account_notes" value="Account Notes &nbsp;($account_note_count)" class="button1"/>
</td>
<td class="pTopThree" valign="top">
<input type="button" name="payment_options" id="payment_options" value="Billing and Payments" class="button1"  $disabled/>
</td>
<td class="pTopThree Pre" valign="left">
<input type="button" name="pre_payments" id="pre_payments" value="Pre Payments" class="button1"  $disabled/>
</td>
</tr>
</table>
</div>


<br>
<p class=\"bbackheader\"><Center><H3><strong>Attendance</strong></Center></H3></p>
<tr>
<td align="bottom" width="100">
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<strong>Select Date:</strong> 
</td>
<td>
<select name="cexp_date1" id="cexp_date1">
<option value="01">January</option>
<option value="02">February</option>
<option value="03">March</option>
<option value="04">April</option>
<option value="05">May</option>
<option value="06">June</option>
<option value="07">July</option>
<option value="08">August</option>
<option value="09">September</option>
<option value="10">October</option>
<option value="11">November</option>
<option value="12">December</option>
</select> 
</td>
<td>
<select  name="year" id="year"/>
<option value="">Year</option>
<option value="$firstYearValue">$firstYearName</option>
<option value="$secondYearValue">$secondYearName</option>
<option value="$thirdYearValue">$thirdYearName</option>
<option value="$fourthYearValue">$fourthYearName</option>
<option value="$fifthYearValue">$fifthYearName</option>
<option value="$sixthYearValue">$sixthYearName</option>
<option value="$seventhYearValue">$seventhYearName</option>
</select>
</td>
<td align="left">
<input type="button" id="pop_window" name="pop_window" value="Load Attendance" class="button1" onClick="openContract();"/>
</td>
</tr>

<br>

<div id="memberWindow">
$member_content
</div>

<div id="memberNotes">
</div>


<form>
<input type="hidden" id="bp_available" name="bp_available" value="$bp_available"/>
<input type="hidden" id="confirmation_message" name="confirmation_message" value="$confirmation_message"/>
<input type="hidden" id="data_bool" name="data_bool" value=""/>
<input type="hidden" id="contract_key_notes" name="contract_key_notes" value="$contract_key_notes"/>
<input type="hidden" id="contract_key" name="contract_key" value="$contract_key"/>
<input type="hidden" id="whichBackBut" name="whichBackBut" value="$whichBackBut"/>
$reason_decline
</form>
$pop_div 
</body>
</html>
ACCOUNTINFOTEMPLATE;
echo"$account_info_template";
?>