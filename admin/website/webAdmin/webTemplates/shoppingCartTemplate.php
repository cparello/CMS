<?php


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
    
    
	
    <!-- should be added conditionally for 2012 slider-->
 
    <link href="webCss/combined.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../../css/signature_pad.css">
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
#main-nav .nav-wrap .nav .nav-title a.hot-spot {
    font-size: 1.2em
}
li a {
    font-size: 1.05em;
}
.buttonSize{
    padding: 2px 4px;
}
.txt-color {
color:#$businessFontColor;
font-family:$businessFont
}
.caption-text3 {
color:#$clubInfoFontColor;
}
#main-nav .nav-wrap .nav .nav-title a.hot-spot {
    color: #$navTextColor;
}
.butColor {
    color: #$butColor;
}
#main {
background-color:#$bannerBackColor;
margin-bottom: 0px;
}
.fontGeorgia {
   font-family: Georgia, serif;
   }
   
.fontSerif {
   font-family: serif, Georgia;
   }
   
.fontArial {
   font-family: Arial, Georgia;
   }
.fontHelvetica {
   font-family: Helvetica, Arial, Georgia;
   }
.fontTimes {
   font-family: Times, Helvetica, Arial, Georgia;
   }
.fontSansSerif {
   font-family: Sans-serif, Times, Helvetica, Arial, Georgia;
   }
.buttonMod{
    padding: 0px 0px;
    font-size: 17px;
    
}
.creditPay2{
    border: 1px solid #000000;
    background: grey;
    width: 400px;
    //margin-right: auto;
    //margin-left: auto;
    padding: 15px;
    height: 275px;
}
.bankPay2{
    border: 1px solid #000000;
    background: grey;
    width: 400px;
    //margin-right: auto;
    //margin-left: auto;
    padding: 15px;
    height: 275px;
    float: right;
}
.servtxt2{
    //float: right;
}
 
</style>
<script type="text/javascript" src="../../scripts/jqueryNew.js"></script>
<script type="text/javascript" src="webScripts/shopCartSaleOrRemove.js"></script>
</head>

<body class=""><script type="text/javascript">
				 var WRInitTime=(new Date()).getTime();
				 </script>
    <img src="pictures/ajax-loader.gif" class="hide" />

    

    <div id="container" class=full-width>
                <header>
                <div class="topRightBuff">                                
                <div class="ShoppingCart float-r">
                $cartLoader
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
  <center>$navBarUls</center>
</div>

                        </div>	
                    </div>
                    
                </header>
        <div id="main">
            






    <span></span>
    

</div>
<!-- ROW: club nearby -->
<div class="midBar">
</div> 





<div class="row float-l padRowBottom">
<div class="inner">
<center><h2>Your Cart</h2></center>
                <br>
<center><h2>$optionalMessage</h2></center>

<table align="left" border="0" cellspacing="0" cellpadding="4" width=100%>

<tr>
<th align="left"  bgcolor="#000000"><font face="Arial" size="1" color="#000000"><u><b>Number of Items</b></u></font></th>
<th align="left"  bgcolor="#000000"><font face="Arial" size="1" color="#000000"><u><b>Item Name</b></u></font></th>
<th align="left"  bgcolor="#000000"><font face="Arial" size="1" color="#000000"><u><b>Description</b></u></font></th>
<th align="left"  bgcolor="#000000"><font face="Arial" size="1" color="#000000"><u><b>Photo</b></u></font></th>
<th align="left"  bgcolor="#000000"><font face="Arial" size="1" color="#000000"><u><b>Item Costs</b></u></font></th>
<th align="left"  bgcolor="#000000"><font face="Arial" size="1" color="#000000"><u><b>Remove Item</b></u></font></th>
</tr>
<br>
<br>
<br>
<br>
$itemCartList


<br>
<br>
<br>
<tr>
<th align="left"  bgcolor="#000000"><font face="Arial" size="1" color="#000000">&nbsp;&nbsp;&nbsp;</font></th>
<th align="left"  bgcolor="#000000"><font face="Arial" size="1" color="#000000">&nbsp;&nbsp;&nbsp;</font></th>
<th align="left"  bgcolor="#000000"><font face="Arial" size="1" color="#000000">&nbsp;&nbsp;&nbsp;</font></th>
<th align="left"  bgcolor="#000000"><font face="Arial" size="1" color="#000000">&nbsp;&nbsp;&nbsp;</font></th>
<th align="left"  bgcolor="#000000"><font face="Arial" size="1" color="#000000">&nbsp;&nbsp;&nbsp;</font></th>
<th align="left"  bgcolor="#000000"><font face="Arial" size="1" color="#000000">&nbsp;&nbsp;&nbsp;</font></th>
</tr>
<tr>
<th align="left"  bgcolor="#000000"><font face="Arial" size="1" color="#000000"></font></th>
<th align="left"  bgcolor="#000000"><font face="Arial" size="1" color="#000000"></font></th>
<th align="left"  bgcolor="#000000"><font face="Arial" size="2" color="#000000">Order Total: &nbsp;&nbsp;$<span id="total">$total</span></font></th>
<th align="left"  bgcolor="#000000"><font face="Arial" size="1" color="#000000"></font></th>
<th align="left"  bgcolor="#000000"><font face="Arial" size="1" color="#000000"><button class="buttonJoin$middleButtons butColor buttonMod" id="purchase" name="purchase" value="purchase" type="buttonJoin$middleButtons">Purchase</button></font></th>
<th align="left"  bgcolor="#000000"><font face="Arial" size="1" color="#000000"></font></th>
</tr>
</table>




<div id="creditPay" class="creditPay">
<div id="creditPay1" class="creditPay1">
<div id="oBtext" class="servtxt">
<b><u>Credit Card Payment</u></b>
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
<select  name="card_type" id="card_type"  />
  <option value>Card Type</option>
  <option value="Visa" >Visa</option>
  <option value="MC" >MasterCard</option>
  <option value="Amex" >American Express</option>
  <option value="Disc" >Discover</option>
</select>
</td>
</tr>
<tr>
<td>
&nbsp;
</td>
</tr>
<tr>
<td class="black">
Name on Card:
</td>
<td>
<input name="card_name" type="text" id="card_name" value="" size="25" maxlength="30" onFocus="return checkServices(this.name,this.id)"/>
</td>
</tr>
<tr>
<td>
&nbsp;
</td>
</tr>
<tr>
<td class="black">
Card Number:
</td>
<td>
<input name="card_number" type="text" id="card_number" value="" size="25" maxlength="22" onFocus="return checkServices(this.name,this.id)"/>
</td>
</tr>
<tr>
<td>
&nbsp;
</td>
</tr>
<tr>
<td class="black">
Security Code:
</td>
<td>
<input name="card_cvv" type="text" id="card_cvv" value="" size="25" maxlength="4" onFocus="return checkServices(this.name,this.id)"/>
</td>
</tr>
<tr>
<td>
&nbsp;
</td>
</tr>
<tr>
<td class="black">
Expiration Date:
</td>
<td>
<select tabindex="" name="card_month" id="card_month" onFocus="return checkServices(this.name,this.id)" />
<option value=""></option>
<option value="01" >January</option>
<option value="02" >February</option>
<option value="03" >March</option>
<option value="04" >April</option>
<option value="05" >May</option>
<option value="06" >June</option>
<option value="07" >July</option>
<option value="08" >August</option>
<option value="09" >September</option>
<option value="10" >October</option>
<option value="11" >November</option>
<option value="12" >December</option>
</select> 
<select tabindex="" name="card_year" id="card_year" onFocus="return checkServices(this.name,this.id)" />
<option value=""></option>
<option value="15" >2015</option>
<option value="16" >2016</option>
<option value="17" >2017</option>
<option value="18" >2018</option>
<option value="19" >2019</option>
<option value="20" >2020</option>
<option value="21" >2021</option>
<option value="22" >2022</option>
<option value="23" >2023</option>
<option value="24" >2024</option>
<option value="25" >2025</option>
<option value="26" >2026</option>
<option value="27" >2027</option>
<option value="28" >2028</option>
</select>
</td>
</tr>
<tr>
<td>
&nbsp;
</td>
</tr>
<tr>
<td class="black">
Credit Payment:
</td>
<td>
<input  name="credit_pay" type="text" id="credit_pay" value="" size="25" maxlength="10" onFocus="return checkServices(this.name,this.id)"/>
</td>
</tr>
</table>
</div>


<div id="bankPay1" class="bankPay1">
<div id="oBtext" class="servtxt2">
<b><u>Payment Through Bank</u></b>
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
<input  name="bank_name" type="text" id="bank_name"  value="" size="25" maxlength="40" onClick="return checkServices(this.name,this.id)"/>
</td>
</tr>
<tr>
<td class="black">
Account Type:
</td>
<td>
<select tabindex=""  name="account_type" id="account_type" onFocus="return checkServices(this.name,this.id)" />
  <option value="">Account Type</option>
  <option value="C" >Personal Checking</option>
  <option value="B" >Business Checking</option>
  <option value="S" >Savings</option>
</select>
</td>
</tr>
<tr>
<td class="black">
Name on Account:
</td>
<td>
<input name="account_name" type="text" id="account_name" value="" size="25" maxlength="60" onClick="return checkServices(this.name,this.id)"/>
</td>
</tr>
<tr>
<td class="black">
Account Number:
</td>
<td>
<input name="account_num" type="text" id="account_num" value="" size="25" maxlength="30" onClick="return checkServices(this.name,this.id)"/>
</td>
</tr>
<tr>
<td class="black">
Routing Number:
</td>
<td>
<input name="aba_num" type="text" id="aba_num" value="" size="25" maxlength="9" onClick="return checkServices(this.name,this.id)"/>
</td>
</tr>
<tr>
<td class="black">
ACH Payment:
</td>
<td>
<input name="ach_pay" type="text" id="ach_pay" value="" size="25" maxlength="10" onClick="return checkServices(this.name,this.id)"/>
</td>
</tr>
</table>
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
      <center><input type='button' value='Submit Information' id='qty' class='buttonSubmit buttonPassesRed buttonSize' field='number_memberships'/></center>
    </div>
  </div>
  <br>
</div>

<script type="text/javascript" src="../../scripts/signature_pad.js"></script>
<script type="text/javascript" src="../../scripts/signaturePad.js"></script>

</div> 
</div> 
$footer
</html>
WEBTEMPLATE;


echo"$webTemplate";
?>