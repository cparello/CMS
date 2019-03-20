<?php
$upgradeListTemplate = <<<UPGRADELIST
<!DOCTYPE html>
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/$upgrade_css">
<link rel="stylesheet" href="../css/headerButtons.css">
<link rel="stylesheet" href="../css/footerButtons.css">
<link rel="stylesheet" href="../css/notes.css">
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
$javaScript13
$javaScript14
$javaScript22

<title>Upgrade Lists</title>
</head>
<body onLoad="showMemNumber('$group_type');">

$searchButtonTemplate

<form name="form1" id="form1" action="upgradeMember.php" method="post" onSubmit="return checkServices(this.name,this.id)">

<div id="contractTypeHeader">
$form_header
</div>

<div id="colorKeyTab">
<span class="tabText1">1. Account Information</span>
</div>
<div id="accountCheck">
<span class="blackBold">Notes:</span>&nbsp;&nbsp;<a class="notes" href="javascript:void('')" onClick="openNotes(1);">Add/Edit</a>
<br>
<span class="blackBold">Update Account Info:</span><input type="checkbox" name="change_info" id="change_info" value="1" onClick="return editAccountInfo(this.name,this.id);"/>
</div>
<div id="accountInfo">
$account_info
</div>

<div id="resultKeyTab">
<span class="tabText1">2. Current Service(s)</span>
</div>
<div id="accountResults">
$current_services
</div>

<div id="resultKeyTab2">
<span class="tabText1">3. Available Upgrades</span>
</div>
<div id="accountResults2">
$available_upgrades 
</div>

<div id="paymentSummaryTab">
<span class="tabText1">4. Payment Summary</span>
</div>

<div id="fieldContainer">
<div id="commission">
<span class="black">Commission Credit: &nbsp;</span><input  name="commission_credit" type="text" id="commission_credit" value="$commission_credit" size="25" maxlength="30" onChange="return checkUser(this.value,this.id)"/>
</div>
<div id="overide">
<span class="black">Price Change Override: &nbsp;</span><input  name="overide_pin" type="password" id="overide_pin" value="" size="25" maxlength="4" onKeyUp="return validateOveridePin(this.value);"/> 
</div>
<div id="memNum">
      <span class="black">Add New Members:&nbsp;</span>
       <select  name="mem_num" id="mem_num" onchange="multiplyAllFields(this.value)" />
      <option value="">None</option>
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
      <option value="6">6</option>
      <option value="7">7</option>
      <option value="8">8</option>
      <option value="9">9</option>
      <option value="10">10</option>
      <option value="11">11</option>
      <option value="12">12</option>
      <option value="13">13</option>
      <option value="14">14</option>
      <option value="15">15</option>
      <option value="16">16</option>
      <option value="17">17</option>
      <option value="18">18</option>
      <option value="19">19</option>
      <option value="20">20</option>
      <option value="21">21</option>
      <option value="22">22</option>
      <option value="23">23</option>
      <option value="24">24</option>
      <option value="25">25</option>
      <option value="26">26</option>
      <option value="27">27</option>
      <option value="28">28</option>
      <option value="29">29</option>
      <option value="30">30</option>
      <option value="31">31</option>
      <option value="32">33</option>
      <option value="34">34</option>
      <option value="35">35</option>
      <option value="36">36</option>
      <option value="37">37</option>
      <option value="38">38</option>
      <option value="39">39</option>
      <option value="40">40</option>
      <option value="41">41</option>
      <option value="42">42</option>
      <option value="43">43</option>
      <option value="44">44</option>
      <option value="45">45</option>
      <option value="46">46</option>
      <option value="47">47</option>
      <option value="48">48</option>
      <option value="49">49</option>
      <option value="50">50</option>
</select>
</div>
</div>


<div id="payTerms">

<div id="payGoup1" class="payGoup1">
<table width="100%" class="groupBorder" cellspacing="2" cellpadding="2">
<tr>
<td colspan="2" bgcolor="#4A4B4C" class="keyHeader">
Service Status
</td>
</tr>
$status_type
$transfer_radio
</table>
</div>



<div id="payGoup2" class="payGoup2">
<table width="100%" class="groupBorder" cellspacing="2" cellpadding="2">
<tr>
<td colspan="2" bgcolor="#4A4B4C" class="keyHeader">
Month to Month Service(s)
</td>
</tr>
<tr>
<td class="black">
Current Pro Rate Fee:
</td>
<td>
<input name="month_prorate_total2" type="text" id="month_prorate_total2" value="" size="8" maxlength="8" disabled="disabled"/>
</td>
</tr>
<tr>
<td class="black">
New Pro Rate  Fee:
</td>
<td>
<input name="pro_rate_fee" type="text" id="pro_rate_fee" value="" size="8" maxlength="8" disabled="disabled"/>
</td>
</tr>
<tr>
<td class="black">
Processing Fee:
</td>
<td>
<input name="process_fee_eft" type="text" id="process_fee_eft" value="" size="8" maxlength="8" disabled="disabled"/>
</td>
</tr>
<tr>
<td class="black">
<b>TOTAL FEES:</b>
</td>
<td>
<input name="total_fees_monthly" type="text" id="total_fees_monthly" value="" size="8" maxlength="8" disabled="disabled"/>
</td>
</tr>

<tr>
<td class="black">
<b>Monthly Payment:</b>
</td>
<td>
<input name="monthly_payment" type="text" id="monthly_payment" value="" size="8" maxlength="8" disabled="disabled"/>
</td>
</tr>
<tr>
<td class="black">
<b>Open Ended:</b>
</td>
<td>
<input type="checkbox" name="open_end" id="open_end" value="1"onClick="setOpenEnd();"/>
</td>
</tr>
<tr>
<td class="black">
Initiation Fee:
</td>
<td>
<input name="init_fee" type="text" id="init_fee" value="$init_fee" size="8" maxlength="8" onKeyUp="return parseInitFee(this.value,this.name);" disabled="disabled"/>
</td>
</tr>
<tr>
<td class="black">
<b>Combined Monthly Payment:</b>
</td>
<td>
<input name="new_monthly_payment" type="text" id="new_monthly_payment" value="" size="8" maxlength="8" disabled="disabled"/>
</td>
</tr>
</table>
</div>


<div id="payGoup3" class="payGoup3">
<table width="100%" class="groupBorder" cellspacing="2" cellpadding="2">
<tr>
<td colspan="2" bgcolor="#4A4B4C" class="keyHeader">
Paid in Full  Service(s) 
</td>
</tr>
<tr>
<td class="black">
Pre Paid Service:
</td>
<td>
<input name="pre_paid_service" type="text" id="pre_paid_service" value="" size="8" maxlength="8" disabled="disabled"/>
</td>
</tr>
<tr>
<td class="black">
Processing Fee:
</td>
<td>
<input name="process_fee_pif" type="text" id="process_fee_pif" value="" size="8" maxlength="8" disabled="disabled"/>
</td>
</tr>
<tr>
<td class="black">
<b>NEW PIF TOTAL:</b>
</td>
<td>
<input name="grand_total_pif" type="text" id="grand_total_pif" value="" size="8" maxlength="8" disabled="disabled"/>
</td>
</tr>
<tr>
<td class="black">
<b>CURRENT PRO RATE:</b>
</td>
<td>
<input name="prorate_pif_total" type="text" id="prorate_pif_total" value="" size="8" maxlength="8" disabled="disabled"/>
</td>
</tr>
<tr>
<td class="black">
<b>GRAND TOTAL:</b>
</td>
<td>
<input name="grand_total_pif2" type="text" id="grand_total_pif2" value="" size="8" maxlength="8" disabled="disabled"/>
</td>
</tr>
<tr>
<td colspan="2"class="black">
&nbsp;
</td>
</tr>
</table>
</div>



<div id="payGoup4" class="payGoup4">
<table width="100%" align="left" class="groupBorder" cellspacing="2" cellpadding="2">
<tr>
<td colspan="2" bgcolor="#4A4B4C" class="keyHeader">
Service and Payment Summary
</td>
</tr>
</table>
<div id="payGoup4b" class="payGoup4b">
<table width="100%" align="left"  class="groupBorder" cellspacing="2" cellpadding="2">
<tr>
<td colspan="2">
$single_summary_divs
$family_summary_divs
$business_summary_divs
$organization_summary_divs
</td>
</tr>
<tr>
<td class="black">
<b>CURRENT RENEWAL RATE TOTAL:</b>
</td>
<td class="black" id="current_renew_total" align="right">
$total_renew_rate
</td>
</tr>
<tr>
<td class="black">
<b>CURRENT PIF PRO RATE TOTAL:</b>
</td>
<td class="black" id="pro_total" align="right">
0.00
</td>
</tr>
<tr>
<td class="black">
<b>CURRENT MONTH PRO RATE TOTAL:</b>
</td>
<td class="black" id="month_prorate_total" align="right">
0.00
</td>
</tr>
<tr>
<td class="black">
<b>CURRENT MONTHLY PAYMENT:</b>
</td>
<td class="black" id="current_month_payment" align="right">
$current_monthly_payments
</td>
</tr>
<tr>
<td class="black">
<b>NEW SERVICES TOTAL:</b>
</td>
<td class="black" id="serve_total" align="right">
0.00
</td>
</tr>
<tr>
<td class="black">
<b>NEW RENEWAL RATE TOTAL:</b>
</td>
<td class="black" id="ren_total" align="right">
0.00
</td>
</tr>
<tr>
<td class="black">
<b>Paid In Full Services:</b>
</td>
<td class="black" id="serve_pif" align="right">
0.00
</td>
</tr>
<tr>
<td class="black">
<b>Month to Month Services:</b>
</td>
<td class="black" id="serve_month" align="right">
0.00
</td>
</tr>
<tr>
<td class="black" >
<b>Processing Fee(s):</b>
</td>
<td class="black" id="process_fees" align="right">
0.00
</td>
</tr>
<tr>
<td class="black" >
<b>New Member Fee:</b>
</td>
<td class="black" id="new_member_fee" align="right">
0.00
</td>
</tr>
<tr>
<td class="black" >
<b>Initiation Fee:</b>
</td>
<td class="black" id="serve_init" align="right">
0.00
</td>
</tr>
<tr>
<td class="black">
<b>Pro Rate Fee:</b>
</td>
<td class="black" id="serve_pro_rate" align="right">
0.00
</td>
</tr>
<tr>
<td class="black">
<b>MINIMUM TOTAL DUE:</b>
</td>
<td class="black" id="serve_total_due" align="right">
0.00
</td>
</tr>
<tr>
<td class="black" >
<b>Todays Payment:</b>
</td>
<td class="black" id="serve_today_payment" align="right">
0.00
</td>
</tr>
<tr>
<td class="black">
<b>Balance Due:</b>
</td>
<td class="black" id="serve_ballance_due" align="right">
0.00
</td>
</tr>
</table>
</div>
</div>
</div>

<div id="payFields1">
<div id="todayPay">
<span class="black">Todays Payment:&nbsp;</span>
<input tabindex="80" name="today_payment" type="text" id="today_payment" value="" size="8" maxlength="8"  onKeyUp ="setTodaysPayment(this.value); return checkNan(this.value,this.name);" onFocus="return checkServices(this.name, this.id);"//>
</div>
<div id="upgradeFee">
<span class="black">New Member fee:&nbsp;</span>
<input name="member_fee" type="text" id="member_fee" value="" size="8" maxlength="8"  disabled="disabled"/>
</div>
<div id="balanceDue">
<span class="black">Balance Due:&nbsp;</span>
<input name="balance_due" type="text" id="balance_due" value="" size="8" maxlength="8"  disabled="disabled"/>
</div>
<div id="dueDate">
<span class="black">Balance Due Date:&nbsp;</span>
<select tabindex="90" name="rem_day" id="rem_day" onClick="setBalanceDueDate(this.value);"/>
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
</div>
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
<input tabindex="200" name="account_name" type="text" id="account_name" value="$account_name" size="25" maxlength="60" onFocus="return checkServices(this.name,this.id)"$ach_disabled1/>
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
<input tabindex="210" name="account_num" type="password" id="account_num" value="$account_number" size="25" maxlength="30" onFocus="return checkServices(this.name,this.id)"$ach_disabled1/>
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

<br><br><br><br><br>  
<br><br><br> <br> <br> <br> <br> <br> <br> <br> <br> <br> 
<br><br><br><br><br>  
<br><br><br> <br> <br> <br> <br> <br> <br> <br> <br> <br> 
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

<div id="printCont">

<input  tabindex="250" type="button" class="print_button" style="border: 0px; margin-right: 25px;  margin-left: 100px;" name="print_contract" id="print_contract"  onClick="return printRenewContract(this.name,this.id);"/>

<input tabindex="260"  type="button" class="submit_button" style="border: 0px;" name="save" id="save" value="" onClick="return checkServices(this.name,this.id);"/>

<input tabindex="270" type="button"  class="cancel_button" style="float: right; border: 0px;" name="cancel_contract" id="cancel_contract"  onClick="return cancelUpgradeContract();"/>

</div>



$notePopTemplate


<input type="hidden" name="print_switch"  id="print_switch" value=""/>
<input type="hidden" name="parse_switch" id="parse_switch" value="$parse_switch"/>
<input type="hidden" name="group_number"  id="group_number" value="$group_number"/>
<input type="hidden" name="group_type"  id="group_type" value="$group_type"/>
<input type="hidden" name="group_marker"  id="group_marker" value="$group_marker"/>
<input type="hidden" name="group_name"  id="group_name" value="$group_name"/>
<input type="hidden" name="single_rows" id="singe_rows" value="$single_rows"/>
<input type="hidden" name="family_rows" id="family_rows" value="$family_rows"/>
<input type="hidden" name="business_rows" id="business_rows" value="$business_rows"/>
<input type="hidden" name="organization_rows" id="organization_rows" value="$organization_rows"/>
<input type="hidden" name="month_service"  id="month_service" value="$month_service"/>
<input type="hidden" name="single_fees" id="singe_fees" value="$single_fees"/>
<input type="hidden" name="family_fees" id="family_fees" value="$family_fees"/>
<input type="hidden" name="business_fees" id="business_fees" value="$business_fees"/>
<input type="hidden" name="organization_fees" id="organization_fees" value="$organization_fees"/>
<input type="hidden" name="month_bit"  id="month_bit" value="$month_bit"/>
<input type="hidden" name="init_base"  id="init_base" value=""/>
<input type="hidden" name="month_exp_date"  id="month_exp_date" value="$month_end_date"/>
<input type="hidden" name="current_monthly_payments"  id="current_monthly_payments" value="$current_monthly_payments"/>
<input type="hidden" name="current_ren_rate" id="current_ren_rate" value=""/>
<input type="hidden" name="month_billing_type" id="month_billing_type" value="$month_billing_type"/>
<input type="hidden" name="original_billing_type" id="original_billing_type" value="$month_billing_type"/>
<input type="hidden" name="daily_rate_array" id="daily_rate_array" value="$daily_rate_array"/>
<input type="hidden" name="todays_date" id="todays_date" value="$todays_date"/>
<input type="hidden" name="field_count" id="field_count" value="$field_count"/>
<input type="hidden" name="remain_month_days" id="remain_month_days" value="$remain_month_days"/>
<input type="hidden" name="total_renew_rate" id="total_renew_rate" value="$total_renew_rate"/>
<input type="hidden" name="month_fee" id="month_fee" value=""/>
<input type="hidden" name="full_fee" id="full_fee" value=""/>
<input type="hidden" name="member_fee_hidden" id="member_fee_hidden" value=""/>
<input type="hidden" name="street_address2"  id="street_address2" value="$street_address2"/>
<input type="hidden" name="city2"  id="city2" value="$city2"/>
<input type="hidden" name="state2"  id="state2" value="$state2"/>
<input type="hidden" name="zip2"  id="zip2" value="$zip2"/>
<input type="hidden" name="primary_phone2"  id="primary_phone2" value="$primary_phone2"/>
<input type="hidden" name="cell_phone2"  id="cell_phone2" value="$cell_phone2"/>
<input type="hidden" name="email2"  id="email2" value="$email2"/>
<input type="hidden" name="group_address2"  id="group_address2" value="$group_address2"/>
<input type="hidden" name="group_phone2"  id="group_phone2" value="$group_phone2"/>
<input type="hidden" name="contract_key"  id="contract_key" value=""/>
<input type="hidden" name="upgrade_contract_key"  id="upgrade_contract_key" value="$contract_key"/>
<input type="hidden" name="monthly_billing_selected"  id="monthly_billing_selected" value=""/>
<input type="hidden" name="month_governor"  id="month_governor" value="$month_governor"/>
<input type="hidden" name="first_name"  id="first_name" value="$first_name"/>
<input type="hidden" name="middle_name"  id="middle_name" value="$middle_name"/>
<input type="hidden" name="last_name"  id="last_name" value="$last_name"/>
<input type="hidden" name="ren_percent"  id="ren_percent" value="$ren_percent"/>
<input type="hidden" name="license_number"  id="license_number" value="$license_number"/>
<input type="hidden" name="contract_bit"  id="contract_bit" value=""/>
<input type="hidden" name="new_upgrade_service_key"  id="new_upgrade_service_key" value="$new_upgrade_service_key"/>
<input type="hidden" name="billing_switch"  id="billing_switch" value="$billing_switch"/>
</form>

$javaScript21
$javaScript20
</body>
</html>
UPGRADELIST;

echo"$upgradeListTemplate";
?>