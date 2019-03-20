<?php
$accountInfoTemplate = <<<ACCOUNTINFOTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/accountInfo.css"/>
<link rel="stylesheet" href="../css/notesTwo.css"/>
<link rel="stylesheet" href="../css/base/jquery.ui.all.css">
<style>
div.ui-datepicker{
 font-size:10px;
}
</style>
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
$javaScript16
$javaScript17
$javaScript18
$javaScript19
$javaScript20
$javaScript21
$javaScript22

<title>Untitled</title>
</head>
<body onLoad="showMemNumber('$group_type'); checkServiceHold();">
<div id="payCont"></div>

<div id="infoHouse">
<div id="contractHeader"><input id="goBack" name="goBack" value="Go Back" class="button1" type="submit">$monthlyBillingStuff $corpFlag <br /> $collections
<br />
<br />
<div class="userHeader">Reactivatable Service(s):&nbsp;&nbsp;$reactivateServiceList</div>
<br />
<br />
<form name="form1" id="form1" action="parseAccountInfo.php" method="post" onSubmit="return checkServices(this.name,this.id)">
<span class="contractNumberHeader">Contract Number:&nbsp;&nbsp;</span>
<span class="contractNumber">$contract_key </span>
</div>

<div id="keyContent">
<div id="white">
</div>
<div id="current">
<span class="black">= Current</span>
</div>
<div id="green">
</div>
<div id="expired">
<span class="black">= Expired</span>
</div>
<div id="blue">
</div>
<div id="canceled">
<span class="black">= Canceled</span>
</div>
<div id="red">
</div>
<div id="hold">
<span class="black">= On Hold</span>
</div>
<div id="yellow">
</div>
<div id="bundle">
<span class="black">= Bundled Fee</span>
</div>
<div id="pink">
</div>
<div id="indi">
<span class="black">= Individual Fee</span>
</div>

<div id="gray">
</div>
<div id="refund">
<span class="black">= Refundable</span>
</div>

<div id="black">
</div>
<div id="collections">
<span class="black">= Collections</span>
</div>

</div>




<!-- this is for member contact information -->
<div id="userForm1">
$groupForm

<table id="secTab" align="center" cellpadding="2" border="0" class="tabBoard1">
<tr class="tabHead">
<td colspan="3" class="oBtext">
Contract Holder Information
</td>
<td align="right" class="checkText">
<div id="addSet1"></div>
</td>

</tr>
<tr>
<td class="black">
First Name:
</td>
<td class="black">
Middle Name: <span class="dob">(Optional)</span>
</td>
<td class="black" colspan="2">
Last Name:
</td>
</tr>
<tr>
<td>
<input  name="first_name" type="text" id="first_name" value="$first_name" size="25" maxlength="60" onFocus="return checkServices(this.name,this.id);" onChange="return disableFields(this);" $name_disabled/>     

</td>
<td>
<input name="middle_name" type="text" id="middle_name" value="$middle_name" size="25" maxlength="100" onFocus="return checkServices(this.name,this.id)" onChange="return disableFields(this);" $name_disabled />
</td>
<td>
<input  name="last_name" type="text" id="last_name" value="$last_name" size="25" maxlength="30" onFocus="return checkServices(this.name,this.id);" onChange="return disableFields(this);" $name_disabled />
</td>
<td rowspan="7" valign="top">
&nbsp;
</td>



</tr>
<tr>
<td class="black">
Street Address:

</td>
<td class="black">
City:
</td>
<td class="black">
State:
</td>
</tr>
<tr>
<td>
<input name="street_address" type="text" id="street_address" value="$street_address" size="25" maxlength="100" onFocus="return checkServices(this.name,this.id);"/>
</td>
<td>
<input name="city" type="text" id="city" value="$city" size="25" maxlength="30" onFocus="return checkServices(this.name,this.id);"/>
</td>
<td>
$state_list
</td>
</tr>
<tr>
<td class="black">
Zipcode:
</td>
<td class="black">
Primary Phone:
</td>
<td class="black">
Cell Phone:
</td>
</tr>
<tr>
<td>
<input name="zip_code" type="text" id="zip_code" value="$zip_code" size="25" maxlength="5"  onFocus="return checkServices(this.name,this.id)"/>
</td>
<td>
<input name="home_phone" type="text" id="home_phone" value="$primary_phone" size="25" maxlength="15"  onFocus="return checkServices(this.name,this.id)"/>
</td>
<td>

<input  name="cell_phone" type="text" id="cell_phone" value="$cell_phone" size="25" maxlength="15"  onFocus="return checkServices(this.name,this.id)"/>
</td>
</tr>
<tr>
<td class="black">
Email Address:
</td>
<td class="black">
Date of Birth: <span class="dob">(mm/dd/yyyy)</span>
</td>
<td class="black">
Drivers License:
</td>
</tr>
<tr>

<td class="pad">
<input  name="email" type="text" id="email" value="$email_address" size="25" maxlength="30" onFocus="return checkServices(this.name,this.id)"/>
</td>
<td class="pad">
<input  name="dob" type="text" id="dob" value="$dob" size="25" maxlength="30"  onFocus="return checkServices(this.name,this.id);"/>
</td>
<td class="pad">
<input  name="lic_num" type="text" id="lic_num" value="$lic_num" size="25" maxlength="30"  onFocus="return checkServices(this.name,this.id)"/>
</td>
</tr>
</table>
</div>

<div class="serviceList">
<p class="header2">Service(s) Details<span class="plus">+</span></p>
<div class="listContent">
$service_summary
</div>
</div>

<div id="clubFees">
<table id="secTab2" align="center"  class="tabBoard3">
<tr class="tabHead">
<td colspan="4" class="oBtext tile3 padding">
Club Fees
</td>
</tr>
<tr class="tabHead">
<td class="oBtext3 tile6 tile3">Enhance Fee:</td>
<td class="oBtext3 tile6">Enhance Cycle:</td>
<td class="oBtext3 tile6">Guarantee Fee:</td>
<td class="oBtext3 tile6 tile4">Guarantee Cycle:</td>
</tr>
<tr>
<td class="black2 tile2">$enhance_fee</td>
<td class="black2 tile2">$enhance_cycle</td>
<td class="black2 tile2">$guarantee_fee</td>
<td class="black2 tile2">$guarantee_cycle</td>
</tr>

<tr>
<td colspan= "4" class="tabPad">&nbsp;</td>
</tr>

<tr class="tabHead">
<td colspan="4" class="oBtext tile5">
Available Refunds
</td>
</tr>
<tr>
<td colspan="4" >
<table id="secTab3"  cellpadding="2" class="tabBoard4 tablesorter"> 
<thead>
<tr class="tabHead">
<th  id="contract_type" class="oBtext3 tile6 tile3">   
 Contract Type
</th>
<th  id="refund_type" class="oBtext3 tile6 header">
Refund Type
</th>
<th id="service_name" class="oBtext3 tile6 header">
 Service Name
</th>
<th class="oBtext3 tile6">
 Refund Total
</th> 
<th class="oBtext3 tile6 tile4">
Select Refund
 </th>                    
 </tr> 
</thead>
<tbody> 
$bundled_refunds
$single_refunds
$available_refunds
$partial_payment_refund
$no_refund
</tbody> 
</table> 
</td>
</tr>
$refund_summary   
<tr>
<td colspan= "4" class="tabPad">&nbsp;</td>
</tr>

$service_credits


<tr>
<td colspan="4" >
<table id="secTab4"  cellpadding="2" class="tabBoard4"> 
<tr class="tabHead">
<td colspan="9" class="oBtext tile3 tile4">
Available Holds / Cancelations / Credit Terms
</td>
</tr>


<tr class="tabHead">
<td class="oBtext3 tile6 tile3">   
Service Name
</td>
<td class="oBtext3 tile6">
Service Type
</td>
<td class="oBtext3 tile6">
Service Term
</td>
<td class="oBtext3 tile6">
Quantity
</td> 
<td class="oBtext3 tile6">
Current Rate
</td> 
<td class="oBtext3 tile6">
Renew Date
</td> 
<td class="oBtext3 tile6">
Credit Service Term &nbsp;&nbsp;  -&nbsp; &nbsp;    Subtract
</td> 
<td class="oBtext3 tile6">
Cancel / Fee
</td>
<td class="oBtext3 tile6 tile4">
Hold
 </td>                    
 </tr> 

$summary_records

</table>

</td>
</tr>
</table>
</div>

$rejection_list

$group_listings



<div id="balanceSummary">
<span class="black6 monthPay">Monthly Payment:
<input  name="month" type="text" id="month" value="$current_monthly_payments" size="6" maxlength="8" disabled="disabled"/>
</span>

<span class="black6 dueBalance">Past Due Balance:
<input  name="past_due_balance" type="text" id="past_due_balance" value="$past_due_balance" size="6" maxlength="8" readonly="readonly"/>
</span>

<span class="black6 cancelBalance">Cancel Balance:
<input  name="cancelation_balance" type="text" id="cancelation_balance" value="0.00" size="6" maxlength="8" />
</span>

<span class="black6 holdBalance">Hold Balance:
<input  name="hold_balance" type="text" id="hold_balance" value="0.00" size="6" maxlength="8" />
</span>

<span class="black6 totalBalance">Total Balance:
<input  name="total_balance_due" type="text" id="total_balance_due" value="$total_balance_due" size="6" maxlength="8" />
</span>

<span class="black6 combinedBalance">Combined Total Balance:
<input  name="combined_total_balance_due" type="text" id="combined_total_balance_due" value="0.00" size="6" maxlength="8" />
</span>
</div>

<div id="payHouse">
<table id="secTab" align="left" >
<tr>
<td colspan="2" bgcolor="#4A4B4C" class="oBtext tile3" width="50%">
Credit Card Payment
</td>
<td colspan="2" bgcolor="#4A4B4C" class="oBtext tile4" width="50%">
Payment Through Bank
</td>
</tr>

<tr>
<td class="black tile3">
<div id="setMonth1"></div>
</td>
<td  class="black rightBorder">
<div id="setMonthCredit"></div>
</td>
<td class="black">
<div id="setMonth2"></div>
</td>
<td class="black tile4">
<div id="setMonthBank"></div>
</td>
</tr>

$checkBoxes1

<tr>
<td class="black tile3">
Card Type:
</td>
<td class="rightBorder">
$type_drop
</td>
<td class="black">
Bank Name:
</td>
<td class="tile4">
<input tabindex="180" name="bank_name" type="text" id="bank_name"  value="$bank_name" size="25" maxlength="40" onFocus="return checkServices(this.name,this.id)"$ach_disabled1/>
</td>
</tr>

<tr>
<td class="black tile3">
Name on Card:
</td>
<td class="rightBorder">
<input tabindex="110" name="card_name" type="text" id="card_name" value="$card_name" size="25" maxlength="30" onFocus="return checkServices(this.name,this.id)"$credit_disabled1/>
</td>
<td class="black">
Account Type:
</td>
<td class="tile4">
$account_drop
</td>
</tr>

<tr>
<td class="black tile3">
Card Number:
</td>
<td class="rightBorder">
<input tabindex="120" name="card_number_masked" type="text" id="card_number_masked" value="$card_number_masked" size="25" maxlength="22"onFocus="return checkServices(this.name,this.id)"$credit_disabled1/>
</td>
<td class="black">
Name on Account:
</td>
<td class="tile4">
<input tabindex="200" name="account_name" type="text" id="account_name" value="$account_name" size="25" maxlength="60" onFocus="return checkServices(this.name,this.id)"$ach_disabled1/>
</td>
</tr>

<tr>
<td class="black tile3">
Security Code:
</td>
<td class="rightBorder">
<input tabindex="130" name="card_cvv" type="password" id="card_cvv" value="$card_cvv" size="25" maxlength="4" onFocus="return checkServices(this.name,this.id)"$credit_disabled1/>
</td>
<td class="black">
Account Number:
</td>
<td class="tile4">
<input tabindex="210" name="account_num_masked" type="text" id="account_num_masked" value="$account_number_masked" size="25" maxlength="30" onFocus="return checkServices(this.name,this.id)"$ach_disabled1/>
</td>
</tr>

<tr>
<td class="black tile3">
Expiration Date:
</td>
<td class="rightBorder">
$month_drop
$year_drop
</td>
<td class="black">
Routing Number:
</td>
<td class="tile4">
<input tabindex="220" name="aba_num" type="text" id="aba_num" value="$routing_number" size="25" maxlength="9" onFocus="return checkServices(this.name,this.id)"$ach_disabled1/>
</td>
</tr>

<tr>
<td class="black tile3">
Credit Payment:
</td>
<td class="rightBorder">
<input tabindex="160" name="credit_pay" type="text" id="credit_pay" value="" size="25" maxlength="10" onFocus="return checkServices(this.name,this.id)"$credit_disabled1/>
</td>
<td class="black">
ACH Payment:
</td>
<td class="tile4">
<input tabindex="230" name="ach_pay" type="text" id="ach_pay" value="" size="25" maxlength="10" onFocus="return checkServices(this.name,this.id)"$ach_disabled1/>
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
<td class="black tile3">
<div id="setMonth3"></div>
</td>
<td class="rightBorder">
<div id="setMonthCash"></div>
</td>
<td class="black">
<div id="setMonth4"></div>
</td>
<td class="black tile4">
<div id="setMonthCheck"></div>
</td>
</tr>



<tr>
<td class="black tile3 tile5">
Cash Payment:
</td>
<td class="rightBorder tile5">
<input texindex="170" name="cash_pay" type="text" id="cash_pay" value="" size="25" maxlength="10" onFocus="return checkServices(this.name,this.id)"/>
</td>
<td class="black tile5">
Check Payment / Number:
</td>
<td class="tile4 tile5">
<input tabindex="240" name="check_pay" type="text" id="check_pay" value="" size="12" maxlength="10" onFocus="return checkServices(this.name,this.id)"$check_disabled1/>
&nbsp;
<input name="check_number" type="text" id="check_number" value="" size="9" maxlength="10" onClick="return checkServices(this.name,this.id)"$check_disabled1/>
</td>
</tr>

<tr>
<td colspan= "4" class="tabPad3">&nbsp;</td>
</tr>

<tr>
<td colspan= "4"><input type="submit" name="update" value="Update Account" class="button1" /></td>
</tr>

</table>




<input type="hidden" name="billing_field_count"  id="billing_field_count" value="$billing_field_count"/>
<input type="hidden" name="test"  id="test" value="$refund_disable_keys"/>
<input type="hidden" name="month_bit"  id="month_bit" value="$month_bit"/>
<input type="hidden" name="month_billing_type" id="month_billing_type" value="$month_billing_type"/>
<input type="hidden" name="update_billing_type" id="update_billing_type" value=""/>
<input type="hidden" name="current_monthly_payments" id="current_monthly_payments" value="$current_monthly_payments"/>
<input type="hidden" name="past_due_orig"  id="past_due_orig" value="$past_due_balance"/>
<input type="hidden" name="hold_fee"  id="hold_fee" value="$hold_fee"/>
<input type="hidden" name="member_hold_fee"  id="member_hold_fee" value="$member_hold_fee"/>
<input type="hidden" name="cancelation_fee"  id="cancelation_fee" value="$cancelation_fee"/>
<input type="hidden" name="nsf_fee"  id="nsf_fee" value="$nsf_fee"/>
<input type="hidden" name="cc_reject_fee"  id="cc_reject_fee" value="$cc_reject_fee"/>
<input type="hidden" name="late_fee"  id="late_fee" value="$late_fee"/>
<input type="hidden" name="group_price_array"  id="group_price_array" value="$group_price_array"/>
<input type="hidden" name="acc_flag"  id="acc_flag" value="$acc_flag"/>
<input type="hidden" name="group_type"  id="group_type" value="$group_type"/>
<input type="hidden" name="monthly_service_count"  id="monthly_service_count" value="$monthly_service_count"/>
<input type="hidden" name="key_list_billing"  id="key_list_billing" value="$key_list_billing"/>
<input type="hidden" name="hold_bit_array"  id="hold_bit_array" value="0|"/>
<input type="hidden" name="member_hold_bit_array"  id="member_hold_bit_array" value="0|"/>
<input type="hidden" name="funds_available"  id="funds_available" value="0"/>

<input type="hidden" name="first_name_orig"  id="first_name_orig" value="$first_name_orig"/>
<input type="hidden" name="middle_name_orig"  id="middle_name_orig" value="$middle_name_orig"/>
<input type="hidden" name="last_name_orig"  id="last_name_orig" value="$last_name_orig"/>
<input type="hidden" name="type_name_orig"  id="type_name_orig" value="$type_name_orig"/>
<input type="hidden" name="transfer_bit"  id="transfer_bit" value="$transfer_bit"/>
<input type="hidden" name="transfer_fee"  id="transfer_fee" value="$transfer_fee"/>
<input type="hidden" name="transfer_fee_confirmed"  id="transfer_fee_confirmed" value="0"/>
<input type="hidden" name="past_due_grace"  id="past_due_grace" value="$past_due_grace"/>
<input type="hidden" name="update_monthly"  id="update_monthly" value=""/>
<input type="hidden" name="contact_list"  id="contact_list" value="$contact_list"/>
<input type="hidden" name="contact_bit"  id="contact_bit" value=""/>
<input type="hidden" name="hold_grace"  id="hold_grace" value="$hold_grace"/>
<input type="hidden" name="last_day"  id="last_day" value="$last_day"/>
<input type="hidden" name="member_refund_bit"  id="member_refund_bit" value=""/>
<input type="hidden" name="upgrade_service_bit"  id="upgrade_service_bit" value=""/>
<input type="hidden" name="cancel_bit"  id="cancel_bit" value=""/>
<input type="hidden" name="contract_key_pre"  id="contract_key_pre" value="$contract_key"/>
<input type="hidden" name="pre_pay_bool"  id="pre_pay_bool" value=""/>
<input type="hidden" name="refund_array"  id="refund_array" value=""/>
<input type="hidden" name="card_number"  id="card_number" value="$card_number"/>
<input type="hidden" name="account_num"  id="account_num" value="$account_num"/>
<input type="hidden" name="flag_bool"  id="flag_bool" value="$corp_flag"/>
<input type="hidden" name="collect_bool"  id="collect_bool" value="$collections_flag"/>
$invoice_bit

</form>
</div>

</div>
</body>
</html>
ACCOUNTINFOTEMPLATE;
$accountInfoTemplate = trim($accountInfoTemplate);
echo"$accountInfoTemplate";
?>