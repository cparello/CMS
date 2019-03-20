<?php
$salesPayrollTemplate = <<<CYCLETEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/fees.css">
<link rel="stylesheet" href="../css/pop_hint.css">
<link rel="stylesheet" href="../css/info.css">
$javaScript1
$javaScript2
$javaScript3
<title>$page_title</title>

</head>
<body>

$infoTemplate

<div id="userHeader">
$page_title  
</div>

<div id="conf" class="conf">
$confirmation &nbsp;
</div>


<div id="userForm">
  <form id="form1" name="form1" method="post" action="$submit_link" onSubmit="return checkData()">

<table border="0" align="center" cellspacing="0" cellpadding="0">
<tr>
<td align="left" colspan="2" class="grey">
<u>Sales Commission Payout Setup</u>    
</td>
</tr>


<tr>
<td class="black" width="225">
Payout Type:
</td>
<td>
<select tabindex= "1" name="sales_pay_type" id="sales_pay_type">
<option value="$current_payment_setup" selected>$text</option>  
<option value="D">Delayed</option>
<option value="I">Instant</option>
</select><a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos1', 1 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black">
Number of Days Delayed:
</td>
<td>
<input tabindex= "2" name="delay" type="text" id="delay" value= "$delay" size="10" maxlength="10" onFocus="killHeader()"/><a href="javascript: void" id="pos2" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos2', 2 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>


<tr>
<td align="left" colspan="2" class="grey">
<u>Sales Performance Pay</u>    
</td>
</tr>


<tr>
<td class="black">
Turn on Sales Performance Bonus:
</td>
<td>
<select tabindex= "3" name="performance_switch" id="performance_switch">
<option value="$currentBonusSetup" selected>$bonusText</option>  
<option value="1">On</option>
<option value="0">Off</option>
</select><a href="javascript: void" id="pos3" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos3', 3 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black">
Select Sales Performance Bonus Type:
</td>
<td>
<select tabindex= "4" name="bonus_switch" id="bonus_switch">
<option value="$bonus_threshold_type" selected>$bonusTextType</option>  
<option value="S">Sales Total</option>
<option value="N">Number of Sales</option>
</select><a href="javascript: void" id="pos4" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos4', 4 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black" id="enhance_text">
Number of Sales Threshold 1
</td>
<td>
<input tabindex= "5" name="num_sales_tier_1" type="text" id="num_sales_tier_1" value= "$numSalesTier1" size="10" maxlength="8"/></select><a href="javascript: void" id="pos5" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos5', 5 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black" id="enhance_text">
Number of Sales Threshold 2
</td>
<td>
<input tabindex= "6" name="num_sales_tier_2" type="text" id="num_sales_tier_2" value= "$numSalesTier2" size="10" maxlength="8"/></select><a href="javascript: void" id="pos6" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos6', 6 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black" id="enhance_text">
Sales Bonus Threshold 1:
</td>
<td>
<input tabindex= "7" name="sales_tot_tier_1" type="text" id="sales_tot_tier_1" value= "$salesTotTier1" size="10" maxlength="8" /></select><a href="javascript: void" id="pos7" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos7', 7 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black" id="enhance_text">
Sales Bonus Threshold 2:
</td>
<td>
<input tabindex= "8" name="sales_tot_tier_2" type="text" id="sales_tot_tier_2" value= "$salesTotTier2" size="10" maxlength="8" /></select><a href="javascript: void" id="pos8" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos8', 8 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black" id="enhance_text">
Sales Bonus Payout Tier 1
</td>
<td>
<input tabindex= "9" name="payout_tier_1" type="text" id="payout_tier_1" value= "$payoutTier1" size="10" maxlength="8" /></select><a href="javascript: void" id="pos9" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos9', 9 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black" id="enhance_text">
Sales Bonus Payout Tier 2
</td>
<td>
<input tabindex= "10" name="payout_tier_2" type="text" id="payout_tier_2" value= "$payoutTier2" size="10" maxlength="8" /></select><a href="javascript: void" id="pos10" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos10', 10 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td  colspan="2" align="left">
<br>
<input type="submit" name="$submit_name" value="$submit_title" />
<input type="hidden" name="marker" value="1" />
</form>
</td>
</tr>



<tr>
<td id="idContent1" colspan="2">   
</td>              
</tr>
</table>
</div>

<div class="popHint"   id="popup" style="display: none;">
<div class="menu_form_header" id="popup_drag">
<img class="menu_form_exit"   id="popup_exit" src="../images/popx.png" alt="" />
<span id= "contHint">
</span>
</div>
</div>

  
</body>
</html>
CYCLETEMPLATE;


echo"$salesPayrollTemplate";

?>


