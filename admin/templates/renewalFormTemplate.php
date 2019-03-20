<?php
$renewalFormTemplate = <<<RENEWFORM
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/$renew_css">
<link rel="stylesheet" href="../css/notes.css">
<link rel="stylesheet" href="../css/headerButtons.css">
<link rel="stylesheet" href="../css/footerButtons.css">
<link rel="stylesheet" href="../css/signature_pad.css">
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

<title>$form_header</title>
</head>
<body onLoad="primarySelectColor('$early_type');">

$searchButtonTemplate

<form name="form1" id="form1" action="renewMember.php" method="post" onSubmit="return checkServices(this.name,this.id)">

<div id="contractTypeHeader">
$form_header
</div>

<div id="colorKeyTab">
<span class="tabText1">1. Account Information</span>
</div>
<div id="accountCheck">
<span class="blackBold">Notes:</span>&nbsp;&nbsp;<a class="notes" href="javascript:void('')"onClick="openNotes(1);">Add/Edit</a>
<br>
<span class="blackBold">Update Account Info:</span><input type="checkbox" name="change_info" id="change_info" value="1" onClick="return editAccountInfo(this.name,this.id);"/>
</div>
<div id="accountInfo">
$account_info
</div>

<div id="resultKeyTab">
<span class="tabText1">2. Renewal Selected</span><font size="2">$pif_out_text<br> <b>Past Due Amount:</b> &nbsp; $past_due_amount</font>
</div>

<div id="accountResults">
$primary_renewal  
</div>

<div id="resultKeyTab2">
<span class="tabText1">3. Renewal(s) Available</span>
</div>
<div id="accountResults2">
$available_renewal  
</div>

<div id="paymentSummaryTab">
<span class="tabText1">4. Payment Summary</span>
</div>

<div id="overRide">
<span class="black">Price Change Override: &nbsp;</span><input  name="overide_pin" type="password" id="overide_pin" value="" size="25" maxlength="4" onKeyUp="return validateOveridePin(this.value);"/> 
</div>


<div id="sumFields">
<table width="100%" cellpadding="2" cellspacing="2">
<tr>
<td class="black top" align="left">
Service(s) Total:
</td>
<td class="black top" align="left">
<input  name="service_total" type="text" id="service_total" value="$selected_renew_rate" size="10" maxlength="10" disabled="disabled"/>  
</td>
<td class="black top" align="left">
Renewal Fee:
</td>
<td class="black top" align="left">
<input  name="renewal_fee" type="text" id="renewal_fee" value="$renewal_fee" size="10" maxlength="10" disabled="disabled"/> 
</td>
<td class="black top" align="left">
Grand Total: 
</td>
<td class="black top" align="left">
<input  name="grand_total" type="text" id="grand_total" value="$selected_grand_total" size="10" maxlength="10" disabled="disabled"/> 
</td>
</tr>
<tr>
<td class="black bottom" align="left">
Todays Payment:
</td>
<td class="black bottom" align="left">
<input tabindex="80" name="today_payment" type="text" id="today_payment" value="" size="10" maxlength="10"   onKeyUp ="setTodaysPayment(this.value); return checkNan(this.value,this.name);" onFocus="return checkServices(this.name, this.id);"/>
</td>
<td class="black bottom" align="left">
Balance Due:
</td>
<td class="black bottom" align="left">
<input name="balance_due" type="text" id="balance_due" value="" size="10" maxlength="10"  disabled="disabled"/>
</td>
<td class="black bottom" align="left">
Balance Due Date:
</td>
<td class="black bottom" align="left">
<select tabindex="90" name="rem_day" id="rem_day" onClick="setBalanceDueDate(this.value);" onFocus="return checkServices(this.name, this.id);"/>
      <option value="">Select Day</option>
      <option value="0" selected>Today</option>
      <option value="1">One Day</option>
      <option value="2">Two Days</option>
      <option value="3">Three Days</option>
      <option value="4">Four Days</option>
      <option value="5">Five Days</option>
      <option value="6">Six Days</option>
      <option value="7">Seven Days</option>
      <option value="8">Eight Days</option>
      <option value="9">Nine Days</option>
      <option value="10">Ten Days</option>
      <option value="11">Eleven Days</option>
      <option value="12">Twelve Days</option>
      <option value="13">Thirteen Days</option>
      <option value="14">Fourteen Days</option>
    </select>
<input name="due_date" type="text" id="due_date" value="$balance_due_date" size="22" maxlength="22" disabled="disabled" />
</td>
</tr>
</table>
</div>

<div id="paymentOptionsTab">
<span class="tabText1">5. Payment Information</span>
</div>



<div id="payHouse">
<table id="secTab" align="left" cellpadding="3" cellspacing= "3" width="100%">
<tr>
<td colspan="2" bgcolor="#4A4B4C" class="keyHeader" width="50%">
Credit Card Payment
</td>
<td colspan="2" bgcolor="#4A4B4C" class="keyHeader" width="50%">
Payment Through Bank
</td>
</tr>

<tr>
<td class="black">
Card Type:
</td>
<td class="rightBorder">
$type_drop
</td>
<td class="black">
Bank Name:
</td>
<td>
<input tabindex="180" name="bank_name" type="text" id="bank_name"  value="$bank_name" size="25" maxlength="40" onFocus="return checkServices(this.name,this.id)"$ach_disabled1/>
</td>
</tr>

<tr>
<td class="black">
Name on Card:
</td>
<td class="rightBorder">
<input tabindex="110" name="card_name" type="text" id="card_name" value="$card_name" size="25" maxlength="300" onFocus="return checkServices(this.name,this.id)"$credit_disabled1/>
</td>
<td class="black">
Account Type:
</td>
<td>
$account_drop
</td>
</tr>

<tr>
<td class="black">
Card Number:
</td>
<td class="rightBorder">
<input tabindex="120" name="card_number" type="password" id="card_number" value="$card_number" size="25" maxlength="22"onFocus="return checkServices(this.name,this.id)"$credit_disabled1/>
</td>
<td class="black">
Name on Account:
</td>
<td>
<input tabindex="190" name="account_name" type="text" id="account_name" value="$account_name" size="25" maxlength="60" onFocus="return checkServices(this.name,this.id)"$ach_disabled1/>
</td>
</tr>

<tr>
<td class="black">
Security Code:
</td>
<td class="rightBorder">
<input tabindex="130" name="card_cvv" type="password" id="card_cvv" value="$card_cvv" size="25" maxlength="4" onFocus="return checkServices(this.name,this.id)"$credit_disabled1/>
</td>
<td class="black">
Account Number:
</td>
<td>
<input tabindex="200" name="account_num" type="password" id="account_num" value="$account_number" size="25" maxlength="30" onFocus="return checkServices(this.name,this.id)"$ach_disabled1/>
</td>
</tr>

<tr>
<td class="black">
Expiration Date:
</td>
<td class="rightBorder">
$month_drop
$year_drop
</td>
<td class="black">
Routing Number:
</td>
<td>
<input tabindex="210" name="aba_num" type="text" id="aba_num" value="$routing_number" size="25" maxlength="9" onFocus="return checkServices(this.name,this.id)"$ach_disabled1/>
</td>
</tr>

<tr>
<td class="black">
Credit Payment:
</td>
<td class="rightBorder">
<input tabindex="160" name="credit_pay" type="text" id="credit_pay" value="" size="25" maxlength="10" onFocus="return checkServices(this.name,this.id)"$credit_disabled1/>
</td>
<td class="black">
ACH Payment:
</td>
<td>
<input tabindex="220" name="ach_pay" type="text" id="ach_pay" value="" size="25" maxlength="10" onFocus="return checkServices(this.name,this.id)"$ach_disabled1/>
</td>
</tr>

<tr>
<td colspan="2" bgcolor="#4A4B4C" class="keyHeader" width="50%">
Cash Payment
</td>
<td colspan="2" bgcolor="#4A4B4C" class="keyHeader" width="50%">
Check Payment
</td>
</tr>

<tr>
<td class="black">
Cash Payment:
</td>
<td class="rightBorder">
<input tabindex="170" name="cash_pay" type="text" id="cash_pay" value="" size="25" maxlength="10" onFocus="return checkServices(this.name,this.id)"/>
</td>
<td class="black">
Check Payment / Number:
</td>
<td>
<input tabindex="230" name="check_pay" type="text" id="check_pay" value="" size="12" maxlength="10" onFocus="return checkServices(this.name,this.id)"$check_disabled1/>
&nbsp;
<input name="check_number" type="text" id="check_number" value="" size="9" maxlength="10" onClick="return checkServices(this.name,this.id)"$check_disabled1/>
</td>
</tr>
</table>
</div>


<br><br> 
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<div id="signature-pad" class="m-signature-pad">
    <div class="m-signature-pad--body">
      <canvas></canvas>
    </div>
    <div class="m-signature-pad--footer">
      <div class="description"><b>Sign above</b></div>
      <a class="button clear" data-action="clear" href="#">Clear</a>
      <a class="button save" data-action="save" href="#">Save</a>
      <input type="hidden" name="input_name" value="" />
    </div>
  </div>
  <br> 
 
<div id="printCont">

<input tabindex="240"  type="button" class="print_button" style="border: 0px; margin-right: 25px;  margin-left: 100px;" name="print_contract" id="print_contract"  onClick="return printRenewContract(this.name,this.id);"/>

<input tabindex="250" type="button" class="submit_button" style="border: 0px;" name="save" id="save" value="" onClick="return checkServices(this.name,this.id)"/>

<input tabindex="260" type="button"  class="cancel_button" style="float: right; border: 0px;" name="cancel_contract" id="cancel_contract"  onClick="return cancelRenewalContract();"/>

</div>


$notePopTemplate

<input type="hidden" name="current_ren_rate" id="current_ren_rate" value=""/>
<input type="hidden" name="row_count"  id="row_count" value="$row_count"/>
<input type="hidden" name="street_address2"  id="street_address2" value="$street_address2"/>
<input type="hidden" name="city2"  id="city2" value="$city2"/>
<input type="hidden" name="state2"  id="state2" value="$state2"/>
<input type="hidden" name="zip2"  id="zip2" value="$zip2"/>
<input type="hidden" name="primary_phone2"  id="primary_phone2" value="$primary_phone2"/>
<input type="hidden" name="cell_phone2"  id="cell_phone2" value="$cell_phone2"/>
<input type="hidden" name="email2"  id="email2" value="$email2"/>
<input type="hidden" name="group_address2"  id="group_address2" value="$group_address2"/>
<input type="hidden" name="group_phone2"  id="group_phone2" value="$group_phone2"/>
<input type="hidden" name="group_name"  id="group_name" value="$group_name"/>
<input type="hidden" name="group_marker"  id="group_marker" value="$group_marker"/>
<input type="hidden" name="group_type"  id="group_type" value="$group_type"/>
<input type="hidden" name="ren_fee_hidden"  id="ren_fee_hidden" value="$renewal_fee"/>
<input type="hidden" name="early_percent"  id="early_percent" value="$early_percent"/>
<input type="hidden" name="renewal_contract_key"  id="renewal_contract_key" value="$renewal_contract_key"/>
<input type="hidden" name="first_name"  id="first_name" value="$first_name"/>
<input type="hidden" name="middle_name"  id="middle_name" value="$middle_name"/>
<input type="hidden" name="last_name"  id="last_name" value="$last_name"/>
<input type="hidden" name="print_switch"  id="print_switch" value=""/>
<input type="hidden" name="license_number"  id="license_number" value="$license_number"/>
<input type="hidden" name="contract_bit"  id="contract_bit" value=""/>
<input type="hidden" name="pif_out_bool"  id="pif_out_bool" value="$pif_out_bool"/>
<input type="hidden" name="pif_out_time"  id="pif_out_time" value="$pif_out_time"/>
<input type="hidden" name="pif_out_money_owed"  id="pif_out_money_owed" value="$pif_out_money_owed"/>
<input type="hidden" name="early_test"  id="early_test" value="$early_test"/>
<input type="hidden" name="past_due_amount"  id="past_due_amount" value="$past_due_amount"/>
</form>




$javaScript21
$javaScript20
</body>
</html>
RENEWFORM;

echo"$renewalFormTemplate";
?>