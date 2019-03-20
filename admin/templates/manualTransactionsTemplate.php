<?php
$manualTemplate = <<<MANUALTRANSACTIONS
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/pop_hint.css">
<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/manualTransactions.css">
$javaScript1
$javaScript2
$javaScript3
$javaScript4



	<title>Enter Manunul Transactions</title>

</head>
<body>

$infoTemplate

<div id="userHeader">
Manual Transactions 
</div>

<div id="manualForm">
  <form id="form1" name="form1" method="post" action="">

<div id="innerOne">
<span class="grey">
<u>Search Contract Holder</u><a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos1', 1);" /><img src="../images/question-mark.png" class="alignMiddle"></a> 
</span>
</div>

<div id="innerTwo">
<table border="0" align="left">
<tr>
<th align="left" bgcolor="#4A4B4C"class="keyHeader">Contract ID</th>
<th align="left"  bgcolor="#4A4B4C" class="keyHeader">Client Contact Information</th>
<th align="right"  bgcolor="#4A4B4C" class="keyHeader">View Account</th>
</tr>
<tr>
<td align="left" valign ="middle" class="keyText"><input name="search_id" type="text" id="search_id" size="9" maxlength="10"/></td>
<td id="contract_info" align="left" valign ="middle" class="keyText">Client contact information</td>
<td align="right"  valign ="middle" class="keyText"><input type="checkbox" id="access" name="access" value="1" ></td>
</tr> 
</table>
</div>

<div id="innerThree">
<span class="grey">
<u>Process Monthly Payments</u><a href="javascript: void" id="pos2" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos2', 2);" /><img src="../images/question-mark.png" class="alignMiddle"></a> 
</span>
</div>


<div id="innerFour">
<table border="0" align="left">
<tr>
<th align="left" bgcolor="#4A4B4C"class="keyHeader">Monthly Payment</th>
<th align="left"  bgcolor="#4A4B4C" class="keyHeader">Payment Amount</th>
<th align="left"  bgcolor="#4A4B4C" class="keyHeader">Check Number</th>
<th align="right"  bgcolor="#4A4B4C" class="keyHeader">Cash</th>
<th align="right"  bgcolor="#4A4B4C" class="keyHeader">Check</th>
<th align="right"  bgcolor="#4A4B4C" class="keyHeader">&nbsp;</th>
</tr>
<tr>
<td align="left" valign ="middle" class="keyText">
<input name="monthly_payment" type="text" id="monthly_payment" size="9" maxlength="10"/>
</td>
<td align="left" valign ="middle" class="keyText">
<input name="payment_amount" type="text" id="payment_amount" size="9" maxlength="10"/>
</td>
<td align="left"  valign ="middle" class="keyText">
<input name="check_number" type="text" id="check_number" size="9" maxlength="10"/>
</td>
<td align="right"  valign ="middle" class="keyText">
<input type="radio" id="cash"  name="p_type" value="cash">
</td>
<td align="right"  valign ="middle" class="keyText">
<input type="radio" id="check" name="p_type" value="check" checked>
</td>
<td align="right"  valign ="middle" class="keyText">
<input type="button" name="monthly"  id="monthly" class="button1" value="Process Payment"/>
</td>
</tr> 
</table>
</div>

<div id="innerFive">
<span class="grey">
<u>Process Initial Payments</u><a href="javascript: void" id="pos3" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -130, 'pos3', 3);" /><img src="../images/question-mark.png" class="alignMiddle"></a> 
</span>
</div>


<div id="innerSix">
<table border="0" align="left">
<tr>
<th align="left" bgcolor="#4A4B4C"class="keyHeader">Balance Due</th>
<th align="left"  bgcolor="#4A4B4C" class="keyHeader">Late Fee</th>
<th align="left"  bgcolor="#4A4B4C" class="keyHeader">Payment Amount</th>
<th align="left"  bgcolor="#4A4B4C" class="keyHeader">Check Number</th>
<th align="right"  bgcolor="#4A4B4C" class="keyHeader">Cash</th>
<th align="right"  bgcolor="#4A4B4C" class="keyHeader">Check</th>
<th align="right"  bgcolor="#4A4B4C" class="keyHeader">&nbsp;</th>
</tr>
<tr>
<td align="left" valign ="middle" class="keyText">
<input name="balance_due" type="text" id="balance_due" size="9" maxlength="10"/>
</td>
<td align="left" valign ="middle" class="keyText">
<input name="late_fee" type="text" id="late_fee" size="9" maxlength="10"/>
</td>
<td align="left" valign ="middle" class="keyText">
<input name="payment_amount2" type="text" id="payment_amount2" size="9" maxlength="10"/>
</td>
<td align="left"  valign ="middle" class="keyText">
<input name="check_number2" type="text" id="check_number2" size="9" maxlength="10"/>
</td>
<td align="right"  valign ="middle" class="keyText">
<input type="radio" id="cash2" name="p_type2" value="cash">
</td>
<td align="right"  valign ="middle" class="keyText">
<input type="radio" id="check2" name="p_type2" value="check" checked>
</td>
<td align="right"  valign ="middle" class="keyText">
<input type="button" name="initial"  id="initial" class="button1" value="Process Payment"/>
</td>
</tr> 
</table>
</div>

<div id="innerSeven">
<span class="grey">
<u>Process NSF Checks</u><a href="javascript: void" id="pos4" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -200, 'pos4', 4);" /><img src="../images/question-mark.png" class="alignMiddle"></a> 
</span>
</div>

<div id="innerEight">
<table border="0" align="left">
<tr>
<th align="left" bgcolor="#4A4B4C"class="keyHeader">Check Amount</th>
<th align="left"  bgcolor="#4A4B4C" class="keyHeader">Check Number</th>
<th align="left"  bgcolor="#4A4B4C" class="keyHeader">View Client Account</th>
<th align="right"  bgcolor="#4A4B4C" class="keyHeader">&nbsp;</th>
</tr>
<tr>
<td align="left" valign ="middle" class="keyText">
<input name="check_payment_nsf" type="text" id="check_payment_nsf" size="9" maxlength="10"/>
</td>
<td align="left" valign ="middle" class="keyText">
<input name="check_number_nsf" type="text" id="check_number_nsf" size="9" maxlength="10"/>
</td>
<td align="left" valign ="middle" class="keyText">
<input type="checkbox" name="view" value="1" >
</td>
<td align="right"  valign ="middle" class="keyText">
<input type="button" name="nsf"  id="nsf" class="button1" value="Process NSF"/>
</td>
</tr> 
</table>
</div>




</div>

<div class="popHint"   id="popup" style="display: none;">
<div class="menu_form_header" id="popup_drag">
<img class="menu_form_exit"   id="popup_exit" src="../images/popx.png" alt="" />
<span id= "contHint">
</span>
</div>

<input type="hidden" name="process_date"  id="process_date" value=""/>
<input type="hidden" name="signup_date"  id="signup_date" value=""/>
<input type="hidden" name="check_payment_orig"  id="check_payment_orig" value=""/>
<input type="hidden" name="cash_payment_orig"  id="cash_payment_orig" value=""/>
<input type="hidden" name="todays_payment_orig"  id="todays_payment_orig" value=""/>

</body>
</html>
MANUALTRANSACTIONS;


echo"$manualTemplate";
?>