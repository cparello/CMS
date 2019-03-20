<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$pos_template= <<<POINTOFSALE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/pointOfSale.css">
<link rel="stylesheet" href="../css/paymentFormOne.css">
<style>
.topArea{
    height: 220px;
    posistion: relative;
    width: 750px;
    margin-left: auto;
    margin-right: auto;
}
.right{
    float: right;
    width: 40%;
    height: 100px;
    posistion: relative;
    text-align: center;
}
.left{
    float: left;
    width: 50%;
    height: 100px;
     posistion: relative;
     text-align: center;
}


.button9 {
    width: 15em;
    text-decoration: none;
    font: bold 12px/1em "Droid Sans",sans-serif;
    text-shadow: 0px 1px 0px #030303;
    -moz-user-select: none;
    padding: 0.5em 0.6em 0.4em;
   // margin: 0.5em;
    display: inline-block;
    position: relative;
    border-top: 1px solid rgba(61, 76, 158, 0.8);
    border-bottom: 1px solid #4251A1;
    background-image: radial-gradient(ellipse farthest-corner at center top , #0B05FF 0%, #300495 100%), url("https://lh4.googleusercontent.com/-Qs9-Ohgo6sk/UY11O1WoMQI/AAAAAAAACME/nUID7awcMow/s50-no/noise.png");
    background-color: #FCF9F9;
    box-shadow: 0px 0.3em 0.3em rgba(255, 255, 255, 0.6) inset, 0px -0.1em 0.3em rgba(5, 5, 5, 0) inset, 0px 0.1em 3px #999, 0px 0.3em 1px #727272, 0px 0.5em 5px rgba(61, 50, 137, 0.42);
    color: #FFF !important;
}
.button99 {
    text-decoration: none;
    font: bold 12px/1em "Droid Sans",sans-serif;
    text-shadow: 0px 1px 0px #030303;
    -moz-user-select: none;
    padding: 0.5em 0.6em 0.4em;
   // margin: 0.5em;
    display: inline-block;
    position: relative;
    border-top: 1px solid rgba(61, 76, 158, 0.8);
    border-bottom: 1px solid #4251A1;
    background-image: radial-gradient(ellipse farthest-corner at center top , #0B05FF 0%, #300495 100%), url("https://lh4.googleusercontent.com/-Qs9-Ohgo6sk/UY11O1WoMQI/AAAAAAAACME/nUID7awcMow/s50-no/noise.png");
    background-color: #FCF9F9;
    box-shadow: 0px 0.3em 0.3em rgba(255, 255, 255, 0.6) inset, 0px -0.1em 0.3em rgba(5, 5, 5, 0) inset, 0px 0.1em 3px #999, 0px 0.3em 1px #727272, 0px 0.5em 5px rgba(61, 50, 137, 0.42);
    color: #FFF !important;
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

<title>Shopping List</title>

</head>
<body>
<div id="masking">
</div>

<div id="userHeader">
Point of Sale
</div>

<div id="conf" class="conf">
&nbsp;$dateMonth
</div>
<div class="topArea">
<div class="left">
<h3>Quick Add</h3>
$but1$but2$but3$but4$but5$but6$but7$but8$but9$but10
</div>
<div class="right">
<h3>Product Search</h3>
<table border="0" align="right" cellspacing="4">
<tr>
<form id="form1">
<td  class="black thHead" valign="bottom">
<input name="search_type" value="1" class="option" style="margin-left:5px;" checked="checked" type="radio">Product UPC
</td>
<td>
<input  name="upc_number" type="text" id="upc_number" size="20" maxlength="40"/>
</td>
</tr>
<tr>
<td class="black thHead" valign="bottom">
<input name="search_type" value="2" class="option" style="margin-left:5px;" type="radio">Product Name
</td>
<td>
<input type="submit" name="set_list" id="set_list" class="button99" value="Enter"/>
</td>
</tr>

</form>


</table>


<table border="0" align="right" cellspacing="4">
<h3>Link Account</h3>
<tr> 
<td  class="black thHead" valign="bottom">
ID Type
<input type="radio" name="id_type" value="B">Barcode</input>
<input type="radio" name="id_type" value="C">Contract Key</input>
</td>
</tr>
<tr>
<td>
<input  name="id_number" type="text" id="id_number" size="20" maxlength="40"/>
<button class="button99" id="set_id" name="set_id">Link</button>
</td>
</tr>
<tr>
<td>
<span id="radBox" class="black thHead"></span>
</td>
</tr>
</table>
</div>
</div>
<div id="contentWindow" class="contentWindow">
<table align="center" border="0" cellspacing="0" cellpadding="4" width=100%>
<tbody>
<tr>
<th align="left" class="white">Items</th>
<th align="left" class="white">Bar Code</th>
<th align="left" class="white">Product Description</th>
<th align="left" class="white">Category</th>
<th align="left" class="white">Unit Cost</th>
<th align="left" class="white">Sub Total</th>
<th align="right" class="white">Remove Item</th>
</tr> 
</tbody>
</table>
</div>

<div id="totalBar"> 
<span class="blackTwo">Total Due:</span>&nbsp;&nbsp<span class="greenOne" id="total">0.00</span>
</div>


<div id="paymentWindow">
<table id="secTab" align="center" cellspacing="3" cellpadding="3" width="650" >
<form id="form2">

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
<td class="tabPad3" align="center" colspan= "4">
<input type="button" name="purchase_items" id="purchase_items" value="Process Purchase" class="button99" />
&nbsp;&nbsp;<input type="button" name="print_receipt" id="print_receipt" value="Print Receipt" class="button99" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="refund_purchase" id="refund_purchase" value="Void Purchase" class="button99" />&nbsp;&nbsp;&nbsp;<input type="button" name="refund_exchange" id="refund_exchange" value="Refund Exchange" class="button99" />
<input type="hidden" id="bar_code_array" name="bar_code_array" value=""/>
<input type="hidden" id="total_due" name="total_due" value=""/>
<input type="hidden" id="data_bool" name="data_bool" value=""/>
<input type="hidden" id="purchase_marker" name="purchase_marker" value=""/>
<input type="hidden" id="delete_bool" name="delete_bool" value=""/>
<input type="hidden" id="contract_key" name="contract_key" value=""/>
<input type="hidden" id="cof_name" name="cof_name" value=""/>
</form>
</td>
</tr>
</table>

</div>

<div id="refundWindow">
<form id="form3">
<div id="innerOne">
<span class="closeTwo">X</span>
</div>

<div id="userHeaderTwo">
Refund Exchange
</div>

<div id="conf" class="conf">
&nbsp;
</div>

<div id="userFormTwo">
<table border="0" align="center" cellspacing="4">
<tr>
<form id="form3">
<td  class="black thHead" valign="bottom">
Invoice Number
</td>
<td>
<input  name="invoice_number" type="text" id="invoice_number" size="15" maxlength="20"/>
<input type="submit" name="set_list_two" id="set_list_two" class="button99" value="Enter"/>
<input type="hidden" id="display_bool_two" name="display_bool_two" value=""/>
</form>
</td>
</tr>
</table>
</div>


<div id="contentWindowTwo" class="contentWindowTwo">

<table align="center" border="0" cellspacing="0" cellpadding="4" width=100%>
<tbody>
<tr>
<th align="left" class="white">Items</th>
<th align="left" class="white">Purchase Date</th>
<th align="left" class="white">Bar Code</th>
<th align="left" class="white">Product Description</th>
<th align="left" class="white">Category</th>
<th align="left" class="white">Unit Cost</th>
<th align="left" class="white">Product Value</th>
</tr> 
</tbody>
</table>
</div>

<div id="totalBarTwo"> 
<span class="blackTwo">Product(s) Value:</span>&nbsp;&nbsp<span class="greenOne" id="totalTwo">0.00</span>
</div>


<div id="totalBarThree"> 
<span class="black">Refund</span>
<input type="radio" name="return_type" value="R" checked/>
&nbsp;&nbsp
<span class="black">Exchange</span>
<input type="radio" name="return_type" value="E"/>
&nbsp;&nbsp&nbsp;&nbsp
<select  name="return_reason" id="return_reason"/>
  <option value="n">Refund Reason</option>
  <option value="D">Defective Product</option>
  <option value="O">Overstock Purchase</option>
</select>
</div>



<div id="reButtons"> 
<input type="button" name="process_type" id="process_type" value="Refund Product(s)" class="button99 re" />
&nbsp;&nbsp&nbsp;&nbsp
<input type="button" name="return_receipt" id="return_receipt" value="Refund Receipt" class="button99" />
</div>


</div>




</body>
</html>
POINTOFSALE;
echo"$pos_template";
?>