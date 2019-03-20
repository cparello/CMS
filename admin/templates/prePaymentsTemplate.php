<?php
$prePayTemplate = <<<PREPAYMENTS
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/pop_hint.css">
<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/prePayment.css">
<style>
.totalBox{
    font-weight: 900;
     text-align: center;
}
</style>
$javaScript1
$javaScript2
$javaScript3
$javaScript4
$javaScript5
$javaScript6


<title>Process Prepaid Transactions</title>

</head>
<body onLoad="$prepay_confirm">
$infoTemplate

<br>
<input id="goBack" name="goBack" value="Go Back" class="button1" type="submit">
<div id="userHeader">
Process Prepaid Transactions  
</div>


<div id="accountInfo">
$account_info
</div>


<div id="innerOne">
<span class="grey">
<u>Current Monthly Services</u>
</span>
</div>


<div id="accountResults">
$current_services
</div>


<div id="innerTwo">
<span class="grey">
<u>Pre Payment Duration</u>
</span>
</div>


<div id="preForm">
<form name="form1" id="form1" action="parsePrePayments.php" method="post" onSubmit="return checkServices(this.name,this.id)">
<table align="left"  border="0" cellspacing="2" cellpadding="2" width="100%" >
$pre_pay_form<br>
$prepay_rate_form<br>
$prepay_enhance_form<br>
$prepay_m_form
</table>
<div class=totalBox>
Total Owed:<input name="prepay_total_combined" type="text" id="prepay_total_combined" size="9" maxlength="10" readonly="readonly"/>
</div>
</div>


<div id="innerThree">
<span class="grey">
<u>Payment Options</u>
</span>
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
<div id="setMonth1"></div>
</td>
<td  class="rightBorder">
<div id="setMonthCredit"></div>
</td>
<td class="black">
<div id="setMonth2"></div>
</td>
<td>
<div id="setMonthBank"></div>
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
<input tabindex="110" name="card_name" type="text" id="card_name" value="$card_name" size="25" maxlength="30" onFocus="return checkServices(this.name,this.id)"$credit_disabled1/>
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
<input tabindex="120" name="card_number_masked" type="text" id="card_number_masked" value="$card_number_masked" size="25" maxlength="22"onFocus="return checkServices(this.name,this.id)"$credit_disabled1/>
</td>
<td class="black">
Name on Account:
</td>
<td>
<input tabindex="200" name="account_name" type="text" id="account_name" value="$account_name" size="25" maxlength="60" onFocus="return checkServices(this.name,this.id)"$ach_disabled1/>
</td>
</tr>

<tr>
<td class="black">
Security Code:
</td>
<td class="rightBorder">
<input tabindex="130" name="card_cvv" type="text" id="card_cvv" value="$card_cvv" size="25" maxlength="4" onFocus="return checkServices(this.name,this.id)"$credit_disabled1/>
</td>
<td class="black">
Account Number:
</td>
<td>
<input tabindex="210" name="account_num_masked" type="text" id="account_num_masked" value="$account_number_masked" size="25" maxlength="30" onFocus="return checkServices(this.name,this.id)"$ach_disabled1/>
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
<input tabindex="220" name="aba_num" type="text" id="aba_num" value="$routing_number" size="25" maxlength="9" onFocus="return checkServices(this.name,this.id)"$ach_disabled1/>
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
<input tabindex="230" name="ach_pay" type="text" id="ach_pay" value="" size="25" maxlength="10" onFocus="return checkServices(this.name,this.id)"$ach_disabled1/>
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
<div id="setMonth3"></div>
</td>
<td class="rightBorder">
<div id="setMonthCash"></div>
</td>
<td class="black">
<div id="setMonth4"></div>
</td>
<td>
<div id="setMonthCheck"></div>
</td>
</tr>


<tr>
<td class="black">
Cash Payment:
</td>
<td class="rightBorder">
<input texindex="170" name="cash_pay" type="text" id="cash_pay" value="" size="25" maxlength="10" onFocus="return checkServices(this.name,this.id)"/>
</td>
<td class="black">
Check Payment / Number:
</td>
<td>
<input tabindex="240" name="check_pay" type="text" id="check_pay" value="" size="12" maxlength="10" onFocus="return checkServices(this.name,this.id)"$check_disabled1/>
&nbsp;
<input name="check_number" type="text" id="check_number" value="" size="9" maxlength="10" onClick="return checkServices(this.name,this.id)"$check_disabled1/>
</td>
</tr>
</table>
</div>

<div id="innerFour">
<input type="submit" name="process" value="Process Pre Payment" class="button1" />
</div>

<input type="hidden" name="month_bit"  id="month_bit" value="$month_bit"/>
<input type="hidden" name="month_billing_type" id="month_billing_type" value="$monthly_billing_type"/>
<input type="hidden" name="monthly_payment"  id="monthly_payment" value="$monthly_payment"/>
<input type="hidden" name="billing_date_array"  id="billing_date_array" value="$billing_date_array"/>
<input type="hidden" name="prepay_restart_date"  id="prepay_restart_date" value=""/>
<input type="hidden" name="key_list"  id="key_list" value="$key_list"/>
<input type="hidden" name="contract_key"  id="contract_key" value="$contract_key"/>
<input type="hidden" name="bool"  id="bool" value="0"/>
<input type="hidden" name="street_address"  id="street_address" value="$street_address"/>
<input type="hidden" name="city"  id="city" value="$city"/>
<input type="hidden" name="state"  id="state" value="$state"/>
<input type="hidden" name="zip"  id="zip" value="$zip"/>
<input type="hidden" name="primary_phone"  id="primary_phone" value="$primary_phone"/>
<input type="hidden" name="license_number"  id="license_number" value="$license_number"/>
<input type="hidden" name="email_address"  id="email_address" value="$email_address"/>
<input type="hidden" name="card_number"  id="card_number" value="$card_number"/>
<input type="hidden" name="account_num"  id="account_num" value="$account_num"/>

<input type="hidden" name="rate_fee"  id="rate_fee" value="$rate_fee"/>
<input type="hidden" name="rate_date_array"  id="rate_date_array" value="$rate_date_array"/>
<input type="hidden" name="prepay_restart_date_rate"  id="prepay_restart_date_rate" value=""/>

<input type="hidden" name="m_fee"  id="m_fee" value="$m_fee"/>
<input type="hidden" name="m_date_array"  id="m_date_array" value="$m_date_array"/>
<input type="hidden" name="prepay_restart_date_m"  id="prepay_restart_date_m" value=""/>

<input type="hidden" name="enhance_fee"  id="enhance_fee" value="$enhance_fee"/>
<input type="hidden" name="enhance_date_array"  id="enhance_date_array" value="$enhance_date_array"/>
<input type="hidden" name="prepay_restart_date_enhance"  id="prepay_restart_date_enhance" value=""/>
<input type="hidden" name="past_due_flag"  id="past_due_flag" value="$pastFlag"/>


</form>



</body>
</html>
PREPAYMENTS;


echo"$prePayTemplate";
?>