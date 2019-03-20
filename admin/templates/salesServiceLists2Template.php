<?php
$salesServiceListsTemplate = <<<SERVICELIST
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/pop_hint.css">
<link rel="stylesheet" href="../css/$sales_form_css">
<link rel="stylesheet" href="../css/notes.css">
<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/headerButtons.css">
<link rel="stylesheet" href="../css/footerButtons.css">
<link rel="stylesheet" href="../css/pop_hint.css">
<link rel="stylesheet" href="../css/base/jquery.ui.all.css">
<link rel="stylesheet" href="../css/$sig_pad_css">
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
$javaScript22

$javaScript23
$javaScript24
<title>Sales Form</title>
<script>
$(function() {
$( "#datepicker" ).datepicker();
});
</script>
</head>
<body onLoad="showMemNumber('$group_type'); comfirmSale(); ">
<div id="masking">
</div>
<div id="headerButThree">
<form id="form9" name="form9" method="post" action="scheduleUpdate.php" onSubmit="return newMemberFormSchedule()">
        <br /><br /><br /><br />
  <button class="buttonSched" name="schedule" value="Sales Schedule" type="buttonSched">Sales Schedule</button>
  <input type="hidden" id="start_range" name="start_range" value="$monDate" />
  <input type="hidden" id="end_range" name="end_range" value="$sunDate" />
  <input type="hidden" id="user_id" name="user_id" value="$userId" />
</form>
</div>
<form name="form1" id="form1" action="saveMember.php" method="post" onSubmit="return checkServices(this.name,this.id)">

$searchButtonTemplate

      <!--
<div id="contractTypeHeader">
$form_header
</div>
      -->
      <br /><br /><br />
      <div id="userHeader">
        $form_header
      </div>
      <br />

      <div id="selectServiceTab" class="tabText2_div">
<span class="tabText2">1. Select Services</span>
</div>


<div class="container">
$single_list_header
 <div class="content">$string_list_single</table></div>
$family_list_header
 <div class="content">$string_list_family</table></div>
$business_list_header
 <div class="content">$string_list_business</table></div>
$organization_list_header
 <div class="content">$string_list_organization</table></div>
 </div>


<div class="clear"><br /></div>

      <div id="paymentSummaryTab" class="tabText2_div">
<span class="tabText2">2. Payment Summary</span>
      </div>

<div id="overFields" class="black">
<table width="100%">
<tr>
<td class="black" align="left">
Commission Credit: &nbsp;<input  name="commission_credit" type="text" id="commission_credit" value="$commission_credit" size="25" maxlength="30" onChange="return checkUser(this.value,this.id)"/>
</td>
<td class="black" align="left">
 Price Change Override: &nbsp;<input  name="overide_pin" type="password" id="overide_pin" value="" size="25" maxlength="4" onKeyUp="return validateOveridePin(this.value);"/> 
 </td>
 <td align="left" class="black">
Contract Start Date: &nbsp;<input type="text" id="datepicker" size="10" value="$class_date" />
</td>
 <td align="right" class="black">
 <div id="memNum">
       Number of Members:&nbsp;
                <select  name="mem_num" id="mem_num" onchange="multiplyAllFields(this.value)">
      <option value="">Select Number</option>
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
 </td>
 </tr>
 </table>
</div>

<div id="payTerms">
<div id="status" class="status">
<div id="status1" class="status1">
<div id="oBtext" class="servtxt">
Service Status
</div>
</div>
<div id="status2" class="status2">
<table width="100%">
$status_type
<tr>
<td class="black">
Non Transferable:
</td>
<td>
<input name="trans" type="radio"  value="N" checked/>
</td>
</tr>
<tr>
<td class="black">
Transferable:
</td>
<td>
<input name="trans" type="radio"  value="Y"/>
</td>
</tr>
</table>
</div>
</div>

<!-- this is for the month tomonth EFT services -->
<div id="coupon" class="monthly">
<div id="oBox" class="monthly1">
<div id="oBtext" class="servtxt">
Month to Month Service(s)
</div>
</div>
<div id="oBox2" class="monthly2">
<table width="100%">
<tr>
<td class="black">
Down Payment:
</td>
<td>
<input name="down_pay" type="text" id="down_pay" value="$down_pay" size="8" maxlength="8" onFocus="return checkMonthlyService();" onKeyUp="return parseDownPay(this.value,this.name);" />
</td>
</tr>
<tr>
<td class="black">
Pro Rated  Fee:
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
<td colspan="2"class="black">
&nbsp;
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
<input type="checkbox" name="open_end" id="open_end" value="1"onClick="setOpenEnd();" />
</td>
</tr>
<tr>
<td class="black">
Initiation Fee:
</td>
<td>
<input name="init_fee" type="text" id="init_fee" value="$init_fee" size="8" maxlength="8" onKeyUp="return parseInitFee(this.value,this.name)"disabled="disabled" />
</td>
</tr>
</table>
</div>
</div>

<!-- This section is for paid in full services -->
<div id="coupon2" class="full">
<div id="oBox" class="full1">
<div id="oBtext" class="servtxt">
Paid in Full  Service(s) 
</div>
</div>
<div id="oBox2" class="full2">
<table width="100%">
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
<b>GRAND TOTAL:</b>
</td>
<td>
<input name="grand_total_pif" type="text" id="grand_total_pif" value="" size="8" maxlength="8" disabled="disabled"/>
</td>
</tr>
<tr>
<td colspan="2"class="black">
&nbsp;
</td>
</tr>
</table>
</div>
</div>

<!-- this section shows the summary -->
<div id="coupon" class="summary">
<div id="oBox" class="summary1">
<div id="oBtext" class="servtxt">
Service and Payment Summary
</div>
</div>
<div id="oBox3" class="oBox3">
<table width="100%" align="left">
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
<b>SERVICES TOTAL:</b>
</td>
<td class="black" id="serve_total" align="right">
0.00
</td>
</tr>
<tr>
<td class="black">
<b>RENEWAL RATE TOTAL:</b>
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
<td class="black">
<b>Down Payment:</b>
</td>
<td class="black" id="serve_down" align="right">
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

      </div> <!-- /#payTerms -->

<div id="todaypay">
<table width="100%">
<tr>
<td class="black" align="left">
<b>Todays Payment:</b>&nbsp;
<input name="today_payment" type="text" id="today_payment" value="" size="8" maxlength="8"  tabindex="4" onKeyUp ="setTodaysPayment(this.value); return checkNan(this.value,this.name);" onFocus="return checkServices(this.name, this.id);"/>
</td>
<td class="black" align="left">
Balance Due:&nbsp;
<input name="balance_due" type="text" id="balance_due" value="" size="8" maxlength="8"  disabled="disabled"/>
</td>
<td class="black" align="left">
Balance Due Date:&nbsp;
              <select name="rem_day" id="rem_day" onFocus="return checkServices(this.name, this.id);" onClick="setBalanceDueDate(this.value);">
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
<input name="due_date" type="text" id="due_date" value="$balance_due_date" size="22" maxlength="22"  disabled="disabled" />
</td>
</tr>
</table>
</div>


      <div id="membersInfoTab" class="tabText2_div">
<span class="tabText2">3. Member Information</span>
      </div>

      <table width="90%">
<tr>
<td>
            <div id="noteCheck"><span class="blackBold">Notes:</span>&nbsp;&nbsp;<a class="notes" href="javascript:void('')" onClick="openNotes(1);">Add/Edit</a></div>
</td>
</tr>
<tr>
          <td>
            <br />
            <span class="blackBold">Liability Host:</span><input type="checkbox" name="liability_host" id="liability_host" value="1"  onClick="setLiabilityHost();" />
          </td>
</tr>
</table>

<div id="groupInfo">
$group_info_form
</div>

<div id="libHost">
</div>

<!-- this is for member contact information -->
<div id="userForm1">
$group_form
</div>


      <div id="paymentInfoTab" class="tabText2_div">
<span class="tabText2">4. Payment Information</span>
      </div>

<div id="todayPayTwo">
Todays Payment: &nbsp;&nbsp;<span id="todayPayTwoTotal">0</span>
</div>


<!-- this is to pay via credit card -->
<div id="creditPay" class="creditPay">
<div id="creditPay1" class="creditPay1">
<div id="oBtext" class="servtxt">
Credit Card Payment
</div>
</div>
<div id="creditPay2" class="creditPay2">
<table id="secTab" align="center" cellpadding="2">
<tr>
<td class="black"  width="30%">
<div id="setMonth1"></div>
</td>
<td>
<div id="setMonthCredit"></div>
</td>
</tr>
<tr>
<td class="black">
Card Type:
</td>
<td>
$type_drop
</td>
</tr>
<tr>
<td class="black">
Name on Card:
</td>
<td>
<input name="card_name" type="text" id="card_name" value="" size="25" maxlength="30" onFocus="return checkServices(this.name,this.id)"$credit_disabled1/>
</td>
</tr>
<tr>
<td class="black">
Card Number:
</td>
<td>
<input name="card_number" type="text" id="card_number" value="" size="25" maxlength="22" onFocus="return checkServices(this.name,this.id)"$credit_disabled1/>
</td>
</tr>
<tr>
<td class="black">
Security Code:
</td>
<td>
<input name="card_cvv" type="text" id="card_cvv" value="" size="25" maxlength="4" onFocus="return checkServices(this.name,this.id)"$credit_disabled1/>
</td>
</tr>
<tr>
<td class="black">
Expiration Date:
</td>
<td>
$month_drop
$year_drop
</td>
</tr>
<tr>
<td class="black">
Credit Payment:
</td>
<td>
<input  name="credit_pay" type="text" id="credit_pay" value="" size="25" maxlength="10" onFocus="return checkServices(this.name,this.id)"$credit_disabled1/>
</td>
</tr>
</table>
</div>


<div id="bankPay1" class="bankPay1">
<div id="oBtext" class="servtxt">
Payment Through Bank
</div>
</div>
<div id="bankPay2" class="bankPay2">
<table id="secTab" align="center" cellpadding="2">
<tr>
<td class="black"  width="30%">
<div id="setMonth2"></div>
</td>
<td>
<div id="setMonthBank"></div>
</td>
</tr>
<tr>
<td class="black">
Bank Name:
</td>
<td>
<input  name="bank_name" type="text" id="bank_name"  value="" size="25" maxlength="40" onClick="return checkServices(this.name,this.id)"$ach_disabled1/>
</td>
</tr>
<tr>
<td class="black">
Account Type:
</td>
<td>
$account_drop
</td>
</tr>
<tr>
<td class="black">
Name on Account:
</td>
<td>
<input name="account_name" type="text" id="account_name" value="" size="25" maxlength="60" onClick="return checkServices(this.name,this.id)"$ach_disabled1/>
</td>
</tr>
<tr>
<td class="black">
Account Number:
</td>
<td>
<input name="account_num" type="text" id="account_num" value="" size="25" maxlength="30" onClick="return checkServices(this.name,this.id)"$ach_disabled1/>
</td>
</tr>
<tr>
<td class="black">
Routing Number:
</td>
<td>
<input name="aba_num" type="text" id="aba_num" value="" size="25" maxlength="9" onClick="return checkServices(this.name,this.id)"$ach_disabled1/>
</td>
</tr>
<tr>
<td class="black">
ACH Payment:
</td>
<td>
<input name="ach_pay" type="text" id="ach_pay" value="" size="25" maxlength="10" onClick="return checkServices(this.name,this.id)"$ach_disabled1/>
</td>
</tr>
</table>
</div>
      </div> <!-- /#creditPay -->

<div id="cashPay" class="cashPay">
<div id="cashPay1" class="cashPay1">
<div id="oBtext" class="servtxt">
Cash Payment
</div>
</div>
<div id="cashtPay2" class="cashPay2">
<table width="100%" align="center" cellpadding="2">
<tr>
<td class="black"  width="30%">
<div id="setMonth3"></div>
</td>
<td>
<div id="setMonthCash"></div>
</td>
</tr>
<tr>
<td class="black" width="30%">
Cash Payment:
</td>
<td>
<input name="cash_pay" type="text" id="cash_pay" value="" size="25" maxlength="10" onClick="return checkServices(this.name,this.id)"$cash_disabled1/>
</td>
</tr>
</table>
</div>


<div id="checkPay1" class="checkPay1">
<div id="oBtext" class="servtxt">
Check Payment
</div>
</div>
<div id="checktPay2" class="checkPay2">
<table width="100%" align="center" cellpadding="2">
<tr>
<td class="black"  width="30%">
<div id="setMonth4"></div>
</td>
<td>
<div id="setMonthCheck"></div>
</td>
</tr>
<tr>
<td class="black" width="30%">
Check Payment / Number:
</td>
<td>
<input name="check_pay" type="text" id="check_pay" value="" size="25" maxlength="10" onClick="return checkServices(this.name,this.id)"$check_disabled1/>
</td>
</tr>
</table>
</div>
      </div> <!-- /#cashPay -->

      <br /> 
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
        <br />


<div id="printCont">
<table align="center" cellpadding="2" class="submitTable">
<tr>
<td align="center" valign="top" style="padding: 10px;">
<input type="button" class="print_button" style="border: 0px;" name="print_contract" id="print_contract"  onClick="return printContract(this.name,this.id);"/>
</td>
<td align="center" valign="top" style="padding: 10px;">
<input type="button" class="submit_button" style="border: 0px;" name="save" id="save" value="" onClick="return checkServices(this.name,this.id);"/>
</td>
<td align="center" valign="top" style="padding: 10px;">
<input type="button"  class="cancel_button" style="float: right; border: 0px;" name="cancel_contract" id="cancel_contract"  onClick="return cancelContract();"/>
</td>
</tr>
</table>
</div>

</div>

$notePopTemplate



<input type="hidden" name="single_rows" id="singe_rows" value="$single_rows"/>
<input type="hidden" name="family_rows" id="family_rows" value="$family_rows"/>
<input type="hidden" name="business_rows" id="business_rows" value="$business_rows"/>
<input type="hidden" name="organization_rows" id="organization_rows" value="$organization_rows"/>
<input type="hidden" name="single_fees" id="singe_fees" value="$single_fees"/>
<input type="hidden" name="family_fees" id="family_fees" value="$family_fees"/>
<input type="hidden" name="business_fees" id="business_fees" value="$business_fees"/>
<input type="hidden" name="organization_fees" id="organization_fees" value="$organization_fees"/>
<input type="hidden" name="month_service"  id="month_service" value="$month_service"/>
<input type="hidden" name="group_type"  id="group_type" value="$group_type"/>
<input type="hidden" name="ren_percent"  id="ren_percent" value="$ren_percent"/>
<input type="hidden" name="current_ren_rate"  id="current_ren_rate" value=""/>
<input type="hidden" name="parse_switch" id="parse_switch" value="$parse_switch"/>
<input type="hidden" name="print_switch"  id="print_switch" value=""/>
<input type="hidden" name="month_bit"  id="month_bit" value="$month_bit"/>
<input type="hidden" name="init_base"  id="init_base" value=""/>
<input type="hidden" name="note_topic"  id="note_topic" value=""/>
<input type="hidden" name="note_body"  id="note_body" value=""/>
<input type="hidden" name="contract_key"  id="contract_key" value=""/>
<input type="hidden" name="monthly_billing_selected"  id="monthly_billing_selected" value=""/>
<input type="hidden" name="member_info_array"  id="member_info_array" value=""/>
<input type="hidden" name="emg_info_array"  id="emg_info_array" value=""/>
<input type="hidden" name="confirmation_message"  id="confirmation_message" value="$confirmation_message"/>
<input type="hidden" name="billing_switch"  id="billing_switch" value="$billing_switch"/>
</form>

    <script>
      $(document).ready(function(){
        /**/
//        $(".tabText2_div").width($(document).width() - 30);
//        $(".tabText2_div").width($(window).width() - 30);
        /**/
      });
    </script>

$javaScript21
$javaScript20
</body>
</html>
SERVICELIST;

echo"$salesServiceListsTemplate";

?>