<?php
$firstYearName = date("Y");
$firstYearValue = date("y");
$secondYearName = date("Y")+1;
$secondYearValue = date("y")+1;
$thirdYearName = date("Y")+2;
$thirdYearValue = date("y")+2;
$fourthYearName = date("Y")+3;
$fourthYearValue = date("y")+3;
$fifthYearName = date("Y")+4;
$fifthYearValue = date("y")+4;
$sixthYearName = date("Y")+5;
$sixthYearValue = date("y")+5;
$seventhYearName = date("Y")+6;
$seventhYearValue = date("y")+6;
$eightYearName = date("Y")+7;
$eightYearValue = date("y")+7;
$nineYearName = date("Y")+8;
$nineYearValue = date("y")+8;
$tenYearName = date("Y")+9;
$tenYearValue = date("y")+9;
$elevenYearName = date("Y")+10;
$elevenYearValue = date("y")+10;
$twelveYearName = date("Y")+11;
$twelveYearValue = date("y")+11;
$thirteenYearName = date("Y")+12;
$thirteenYearValue = date("y")+12;
$fourteenYearName = date("Y")+13;
$fourteenYearValue = date("y")+13;


$webTemplate = <<<WEBTEMPLATE
<!doctype html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<!--<![endif]-->
<head>
    <meta charset="utf-8">
     
<title>$title</title>
<meta name="description" content="$description" />
    
    
	
<link rel="stylesheet" href="../../css/pop_hint.css">    <!-- should be added conditionally for 2012 slider-->
<link rel="stylesheet" href="../../css/salesForm.css">
<link rel="stylesheet" href="../../css/notes.css">
<link rel="stylesheet" href="../../css/info.css">
<link rel="stylesheet" href="../../css/headerButtons.css">
<link rel="stylesheet" href="../../css/footerButtons.css">
<link rel="stylesheet" href="../../css/pop_hint.css">
<link rel="stylesheet" href="../../css/base/jquery.ui.all.css">
<link rel="stylesheet" href="../../css/signature_pad.css">
<link href="webCss/combined.css" rel="stylesheet" type="text/css" />
<script src="../../scripts/jqueryNew.js" type="text/javascript"></script>
<script type="text/javascript" src="webScripts/checkSalesFields.js"></script>
<script type="text/javascript" src="webScripts/checkUser.js"></script>
<script type="text/javascript" src="webScripts/cardSwipe.js"></script>
<script type="text/javascript" src="webScripts/helpPops.js"></script>
<script type="text/javascript" src="webScripts/helpTxtSales.js"></script>
<script type="text/javascript" src="webScripts/setContactDivs.js"></script>
<script type="text/javascript" src="webScripts/helpTxtWebsiteSales.js"></script>
   

    
<style>
.topLinkBack{
background:#$topLinkBar;
}
.midButtonBack{
background:#$midButBar;
}
.bottomBack{
background:#$bottomBar;
}
.contentFooter  {
top: 4000px;
}
#main-nav .nav-wrap .nav .nav-title a.hot-spot {
    font-size: 1.2em;
}
.buttonSize{
    padding: 2px 4px;
}
.txt-color {
color:#$businessFontColor;
font-family:$businessFont
}
#main-nav .nav-wrap .nav .nav-title a.hot-spot {
    color: #$navTextColor;
}
.butColor {
    color: #$butColor;
}
#todayPayTwo {
    top: 5px;
}
#userForm1 {
    height: 100%;
}
.oBtext {
    font-size: 16pt;
}
.black {
    font-size: 10pt;
}
.container p {
    font-size: 16pt;
}
.sumtext{
    color: #000000;
}
#membersInfoTab {
    left: 0px;
}
.purchaseSummary {
    margin-left: 25px;
    margin-top: 15px;
}
input {
    border: 1px solid #000000;
}
select {
    border: 1px solid #000000;
}
}
.simsWrapper.auiTestWrapper .sim-img-title, .simsWrapper.auiTestWrapper .shoveler-pagination, .simsWrapper.auiTestWrapper .pricetext, .simsWrapper.auiTestWrapper .price {
    font-size: 13px;
    line-height: 1.465;
}
.shoveler li {
    list-style: none outside none;
}
.simsWrapper .shoveler li {
    width: 160px;
    margin: 0px 10px;
    padding: 0px;
    overflow: hidden;
}
.simsWrapper.auiTestWrapper .byline, .simsWrapper.auiTestWrapper .byline a, .simsWrapper.auiTestWrapper .binding-platform, .simsWrapper.auiTestWrapper .pricetext, .simsWrapper.auiTestWrapper .price, .simsWrapper.auiTestWrapper .price-small {
    margin: 0px;
}
.shoveler li {
    float: left;
    margin: 0px;
    padding: 10px 0px 0px;
    width: 180px;
    height: 100%;
    list-style: none outside none;
}


.simsWrapper.auiTestWrapper2 .sim-img-title2, .simsWrapper.auiTestWrapper2 .shoveler-pagination2, .simsWrapper.auiTestWrapper2 .pricetext2, .simsWrapper.auiTestWrapper2 .price2 {
    font-size: 13px;
    line-height: 1.465;
}

element {
    margin-left: 9px;
    margin-right: 9px;
}
.marketingOptions {
    margin-right: 9px;
    margin-left: 15px;
    margin-top: 15px;
    position: relative;
    top: 50px;
    left: 10px;
    width: 1000px;
    height: 250px;
    text-align: center;
    
}

.container {
    position: absolute;
    top: 900px;
    left: 300px;
    width: 1000px;
    margin-left: 0;
    height: 30px;
}
#todaypay {
    left: 150px;
}
ul {
    margin: 40px;
}
.sumtext {
    padding-left: 10px;
}
.sumtextPad {
    padding-left: 30px;
}
.buttonClear {
    border-top: 1px solid #000000;
    background: -moz-linear-gradient(center top , #000000, #000000) repeat scroll 0% 0% transparent;
    padding: 2px 4px;
    border-radius: 0px;
    box-shadow: 0px 1px 0px #000;
    text-shadow: 0px 1px 0px rgba(0, 0, 0, 0.4);
    color: #FFF;
    font-size: 24px;
    font-family: Georgia,serif;
    text-decoration: none;
    vertical-align: middle;
}
#paymentInfoTab {
    left: 1px;
}
#todayPayTwo {
    left: 0px;
    width: 900px;
}
#noteCheck {
    left: 1px;
    width: 900px;
}
.divider {
    background: gray;
    height: 35px;
}
.verifyPay{
    position: relative;
    top: 85px;
}
#paymentInfoTab {
   top: 95px;
    }
    .m-signature-pad {
    top: 145px;
    
}
.creditPay {
    position: relative;
    top:115px;
    left: 0px;
    width: 1000px;
    margin-left: auto;
    margin-right: auto;
    z-index: 3;
}
</style>



</head>
<div id="masking">
</div>
<body class=""><script type="text/javascript">
				 var WRInitTime=(new Date()).getTime();
				 </script>
    <img src="pictures/ajax-loader.gif" class="hide" />

    

    <div id="container" class=full-width>
                <header>
                <div class="topRightBuff">                                
                <div class="ShoppingCart float-r">
                <a href="/website/webAdmin/shoppingCart.php"><img src="pictures/Shopping-Cart-Icon.jpg" width="52" height="52" alt="Shoppin Cart"/></a><b><span id="numCartItems">&nbsp;$numberOfCartItems</span></b>
                </div>
                    <div class="TopRightMain">
                        <div id="loginArea" class="int-nav">
                                   <b>$logHtml</b>
                        </div>	
                        

<div id="global-login" class="mar-t-10">
        <div class="float-r">
            
        </div>
</div>
</div>
</div>
<div class="logo">
<a href="webIndex.php"><img src="/admin/images/contract_logo.png" alt="Logo"/></a>
</div>

<div id="main-nav" class="up topLinkBack">	
<div >
<div id="nav-start">&nbsp;</div>
                            

<div class="nav-wrap">
    $navBarUls
</div>

                        </div>	
                    </div>
                    
                </header>
        <div id="main">
            






    <span></span>    
 



<!-- ROW: club nearby -->
<div class="row float-l">

<div class="inner">
<div id="purchaseSummary" class="purchaseSummary">

<table align="center" border="1" rules="none" frame="box" cellspacing="0" cellpadding="1" width=105% >
$this->summaryHtml
</table>

</div>
<div id="todaypay">
<table width="100%">
<tr>
<td class="black" align="left">
<b>Todays Payment:</b>&nbsp;
<input name="today_payment" type="text" id="today_payment" value="" size="8" maxlength="8"  tabindex="4" onKeyUp ="setTodaysPayment(this.value);" onFocus="return checkServices(this.name, this.id);"/>
</td>
<td class="black" align="left">
<b>Balance Due:<b>&nbsp;
<input name="balance_due" type="text" id="balance_due" value="$this->totalCost" size="8" maxlength="8"  disabled="disabled"/>
</td>
</tr>
</table>
</div>

<div id="marketingOptions" class="marketingOptions">





<div class="shoveler" id="purchaseShvl">
    <div class="shoveler-heading">
        <h2>Customers Who Bought This Item Also Bought</h2>
        
    </div>
    <div class="shoveler-content">
            <ul tabindex="-1">
                <li>
                 $marketingItem1
                </li>
                <li>
                 $marketingItem2
                </li>
                <li>
                 $marketingItem3
                </li>
                <li>
                  $marketingItem4
                </li>
                <li>
                  $marketingItem5
                </li>
            </ul>
            <br>
            <br>
            <ul tabindex="-1">
                <li>
                 $gearItem1
                </li>
                <li>
                 $gearItem2
                </li>
                <li>
                 $gearItem3
                </li>
                <li>
                  $gearItem4
                </li>
                <li>
                  $gearItem5
                </li>
            </ul>
        </div>
    </div>






</div>
</div>

</div>


<div class="container">
<p class="headerTerms">Terms and Conditions<span class="plus">+</span></p>
<tr>
<span class="blackBold">I have read the terms and conditions:&nbsp;</span><input type="checkbox" name="terms_conditions" id="terms_conditions"  value=""/><a href="javascript: void" id="pos2"/><img src="../../images/question-mark.png" class="alignMiddle"></a> 
</tr>
 <div class="contentTerms"><table align="left" border="1" rules="none" frame="box" cellspacing="0" cellpadding="1" width=100% >
<tr>
<b>$this->terms</b>
</tr>
</table></div>




<form name="form1" id="form1" action="saveMember.php" method="post" onSubmit="return checkServices(this.name,this.id)">



<div id="membersInfoTab">
<span class="tabText2">1. Member Information</span>
<tr>
<td>

<div id="noteCheck">
</td>
</tr>
<tr>
<span class="blackBold">Liability Host/Billing Info:&nbsp;</span><input type="checkbox" name="liability_host" id="liability_host"  value="1" onClick="setLiabilityHost();"/><a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos1', 1);" /><img src="../../images/question-mark.png" class="alignMiddle"></a> <label for="infotText" class="label">&nbsp;&nbsp;&nbsp;<u>If you are using a different address for your billing information please click the box above and enter that info here.</u></label>
</tr>
</div>
</div>

<div id="groupInfo">
$this->hostForm
</div>

<div id="libHost">
</div>

<!-- this is for member contact information -->
<div id="userForm1">
$this->memberForm
</div>

<div class="verifyPay">
<span id="verifyEft"></span>
<span id="verifyRate"></span>
<span id="verifyEnhance"></span>
</div>

<div id="paymentInfoTab">
<span class="tabText2">2. Payment Information</span>
<div id="todayPayTwo">
<br>
Todays Payment: &nbsp;&nbsp;<span id="todayPayTwoTotal">0</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="monthlyText"></span><br>

</div>
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
<select $this->typeDropTab name="card_type" id="card_type" $this->typeDropScript $this->typeDropDisable/>
  <option value>Card Type</option>
  <option value="Visa" $visaSelected>Visa</option>
  <option value="MC" $mcSelected>MasterCard</option>
  <option value="Amex" $amxSelected>American Express</option>
  <option value="Disc" $discSelected>Discover</option>
</select>
</td>
</tr>
<tr>
<td class="black">
Name on Card:
</td>
<td>
<input name="card_name" type="text" id="card_name" value="" size="50" maxlength="30" onFocus="return checkServices(this.name,this.id)"$credit_disabled1/>
</td>
</tr>
<tr>
<td class="black">
Card Number:
</td>
<td>
<input name="card_number" type="text" id="card_number" value="" size="50" maxlength="22" onFocus="return checkServices(this.name,this.id)"$credit_disabled1/>
</td>
</tr>
<tr>
<td class="black">
Security Code:
</td>
<td>
<input name="card_cvv" type="text" id="card_cvv" value="" size="50" maxlength="4" onFocus="return checkServices(this.name,this.id)"$credit_disabled1/>
</td>
</tr>
<tr>
<td class="black">
Expiration Date:
</td>
<td>
<select tabindex=\"$monthDropTab\" name="card_month" id="card_month" onFocus="return checkServices(this.name,this.id)" $this->monthDropDisable/>
<option value="">$this->dropMonthHeader</option>
<option value="01" $firstMonthSelected>January</option>
<option value="02" $secondMonthSelected>February</option>
<option value="03" $thirdMonthSelected>March</option>
<option value="04" $fourthMonthSelected>April</option>
<option value="05" $fifthMonthSelected>May</option>
<option value="06" $sixthMonthSelected>June</option>
<option value="07" $seventhMonthSelected>July</option>
<option value="08" $eighthMonthSelected>August</option>
<option value="09" $ninthMonthSelected>September</option>
<option value="10" $tenthMonthSelected>October</option>
<option value="11" $eleventhMonthSelected>November</option>
<option value="12" $twelfthMonthSelected>December</option>
</select> 
<select tabindex=\"$yearDropTab\" name="card_year" id="card_year" onFocus="return checkServices(this.name,this.id)" />
<option value="">$this->dropYearHeader</option>
<option value="$firstYearValue" $firstYearSelected>$firstYearName</option>
<option value="$secondYearValue" $secondYearSelected>$secondYearName</option>
<option value="$thirdYearValue" $thirdYearSelected>$thirdYearName</option>
<option value="$fourthYearValue" $fourthYearSelected>$fourthYearName</option>
<option value="$fifthYearValue" $fifthYearSelected>$fifthYearName</option>
<option value="$sixthYearValue" $sixthYearSelected>$sixthYearName</option>
<option value="$seventhYearValue" $seventhYearSelected>$seventhYearName</option>
<option value="$eightYearValue" $eightYearSelected>$eightYearName</option>
<option value="$nineYearValue" $nineYearSelected>$nineYearName</option>
<option value="$tenYearValue" $tenYearSelected>$tenYearName</option>
<option value="$elevenYearValue" $elevenYearSelected>$elevenYearName</option>
<option value="$twelveYearValue" $twelveYearSelected>$twelveYearName</option>
<option value="$thirteenYearValue" $thirteenYearSelected>$thirteenYearName</option>
<option value="$fourteenYearValue" $fourteenYearSelected>$fourteenYearName</option>
</select>
</td>
</tr>
<tr>
<td class="black">
Credit Payment:
</td>
<td>
<input  name="credit_pay" type="text" id="credit_pay" value="" size="50" maxlength="10" onFocus="return checkServices(this.name,this.id)"$credit_disabled1/>
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
<input  name="bank_name" type="text" id="bank_name"  value="" size="50" maxlength="40" onClick="return checkServices(this.name,this.id)"$ach_disabled1/>
</td>
</tr>
<tr>
<td class="black">
Account Type:
</td>
<td>
<select tabindex=\"$accountDropTab\"  name="account_type" id="account_type" onFocus="return checkServices(this.name,this.id)" />
  <option value="">Account Type</option>
  <option value="C" $personalSelected>Personal Checking</option>
  <option value="B" $businessSelected>Business Checking</option>
  <option value="S" $savingsSelected>Savings</option>
</select>
</td>
</tr>
<tr>
<td class="black">
Name on Account:
</td>
<td>
<input name="account_name" type="text" id="account_name" value="" size="50" maxlength="60" onClick="return checkServices(this.name,this.id)"$ach_disabled1/>
</td>
</tr>
<tr>
<td class="black">
Account Number:
</td>
<td>
<input name="account_num" type="text" id="account_num" value="" size="50" maxlength="30" onClick="return checkServices(this.name,this.id)"$ach_disabled1/>
</td>
</tr>
<tr>
<td class="black">
Routing Number:
</td>
<td>
<input name="aba_num" type="text" id="aba_num" value="" size="50" maxlength="9" onClick="return checkServices(this.name,this.id)"$ach_disabled1/>
</td>
</tr>
<tr>
<td class="black">
ACH Payment:
</td>
<td>
<input name="ach_pay" type="text" id="ach_pay" value="" size="50" maxlength="10" onClick="return checkServices(this.name,this.id)"$ach_disabled1/>
</td>
</tr>
</table>
</div>
</div>

<br>
<div id="signature-pad" class="m-signature-pad">
    <div class="m-signature-pad--body">
      <canvas></canvas>
    </div>
    <div class="m-signature-pad--footer">
      <div class="description"><b>Sign above</b></div>
      <a class="button clear" data-action="clear" href="#">Clear</a>
      <a class="button save" data-action="save" href="#">Save</a>
      <input type="hidden" id="input_name" name="input_name" value="" />
      <br>
      <center><input type='button' value='Submit Information' id='qty' class='buttonSubmit buttonPasses$middleButtons buttonSize' field='number_memberships'/></center>
    </div>
  </div>
  <br>
  




</table>
<input type="hidden" name="clubId" id="clubId" value="$club_id"/>
<input type="hidden" name="monthDues" id="monthDues" value="$this->monthlyDues"/>
<input type="hidden" name="enhanceEftCycle" id="enhanceEftCycle" value="$enhance_eft_cycle"/>
<input type="hidden" name="enhanceEftCycleDate" id="enhanceEftCycleDate" value="$enhance_annual_cycle_date"/>
<input type="hidden" name="rateEftCycle" id="rateEftCycle" value="$rate_eft_cycle"/>
<input type="hidden" name="rateAnnualCycleDate" id="rateAnnualCycleDate" value="$rate_annual_cycle_date"/>
<input type="hidden" name="cycleDay" id="cycleDay" value="$cycle_day"/>
<input type="hidden" name="pastDay" id="pastDay" value="$past_day"/>
<input type="hidden" name="enhanceFee" id="enhanceFee" value="$enhance_fee"/>
<input type="hidden" name="rejectionFee" id="rejectionFee" value="$rejection_fee"/>
<input type="hidden" name="lateFee" id="lateFee" value="$late_fee"/>
<input type="hidden" name="rateFee" id="rateFee" value="$rate_fee"/>
<input type="hidden" name="rateText" id="rateText" value="$rate_text"/>
<input type="hidden" name="enhanceText" id="enhanceText" value="$enhance_text"/>
<input type="hidden" name="markServOption1" id="markServOption1" value=""/>
<input type="hidden" name="markServOption2" id="markServOption2" value=""/>
<input type="hidden" name="markServOption3" id="markServOption3" value=""/>
<input type="hidden" name="markServOption4" id="markServOption4" value=""/>
<input type="hidden" name="markServOption5" id="markServOption5" value=""/>
<input type="hidden" name="markGearOption1" id="markGearOption1" value=""/>
<input type="hidden" name="markGearOption2" id="markGearOption2" value=""/>
<input type="hidden" name="markGearOption3" id="markGearOption3" value=""/>
<input type="hidden" name="markGearOption4" id="markGearOption4" value=""/>
<input type="hidden" name="markGearOption5" id="markGearOption5" value=""/>
<input type="hidden" name="host_info_array" id="host_info_array" value=""/>
<input type="hidden" name="group_type" id="group_type" value="S"/>
<input type="hidden" name="terms_viewed" id="terms_viewed" value=""/>
<input type="hidden" name="sale_array" id="sale_array" value="$this->saleArray"/>
<input type="hidden" name="balance_due_backup" id="balance_due_backup" value="$this->totalCost"/>
<input type="hidden" name="number_new_memberships" id="number_new_memberships" value="$this->numberOfNewMemberships"/>
<input type="hidden" name="month_bit"  id="month_bit" value="1111"/>
<input type="hidden" name="monthly_bool"  id="monthly_bool" value="$this->monthlyBillingBool"/>
<input type="hidden" name="single_rows" id="singe_rows" value="23"/>
<input type="hidden" name="single_fees" id="singe_fees" value="19.00|22.00"/>
<input type="hidden" name="month_service" id="month_service" value=""/>
<input type="hidden" name="ren_percent" id="ren_percent" value=".10"/>
<input type="hidden" name="current_ren_rate" id="current_ren_rate" value=""/>
<input type="hidden" name="parse_switch" id="parse_switch" value="2"/>
<input type="hidden" name="print_switch"  id="print_switch" value=""/>
<input type="hidden" name="init_base"  id="init_base" value=""/>
<input type="hidden" name="note_topic"  id="note_topic" value=""/>
<input type="hidden" name="note_body"  id="note_body" value=""/>
<input type="hidden" name="contract_key"  id="contract_key" value=""/>
<input type="hidden" name="monthly_billing_selected"  id="monthly_billing_selected" value=""/>
<input type="hidden" name="member_info_array"  id="member_info_array" value=""/>
<input type="hidden" name="emg_info_array"  id="emg_info_array" value=""/>
<input type="hidden" name="billing_switch"  id="billing_switch" value="3"/>
<input type="hidden" name="confirmation_message"  id="confirmation_message" value=""/>
</div>

$notePopTemplate

</div>
<input type="hidden" name="single_rows" id="singe_rows" value="$single_rows"/>

</form>

<div class="popHint"   id="popup" style="display: none;">
<div class="menu_form_header" id="popup_drag">
<img class="menu_form_exit"   id="popup_exit" src="../../images/popx.png" alt="" />
<span id= "contHint">
</span>
<script type="text/javascript" src="../../scripts/signature_pad.js"></script>
<script type="text/javascript" src="../../scripts/signaturePad.js"></script>
</div>
       
    </div>
</div>
        </div>

   
    

$footer
</html>
WEBTEMPLATE;


echo"$webTemplate";
?>