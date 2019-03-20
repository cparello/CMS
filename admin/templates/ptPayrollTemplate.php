<?php
$ptPayrollTemplate = <<<CYCLETEMPLATE
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
<u>Personal Training Payout Setup</u>    
</td>
</tr>


<tr>
<td class="black" width="225">
Payment Type:
</td>
<td>
<select tabindex= "1" name="pt_pay_type" id="pt_pay_type">
<option value="$current_payment_setup" selected>$text</option>  
<option value=\"P\" $T>Percentage</option>
<option value=\"F\" $O>Flat Rate</option>
</select><a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos1', 1 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black">
Percentage:
</td>
<td>
<input tabindex= "2" name="percentage" type="text" id="percentage" value= "$percentage" size="10" maxlength="10" onFocus="killHeader()"/><a href="javascript: void" id="pos2" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos2', 2 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black">
Flat Rate 1 Hr:
</td>
<td>
<input tabindex= "3" name="flat_rate_1_hr" type="text" id="flat_rate_1_hr" value= "$flat_rate_1_hr" size="10" maxlength="10" onFocus="killHeader()"/><a href="javascript: void" id="pos3" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos3', 3 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black">
Flat Rate 1/2 Hr:
</td>
<td>
<input tabindex= "4" name="flat_rate_half_hour" type="text" id="flat_rate_half_hour" value= "$flat_rate_half_hour" size="10" maxlength="10" onFocus="killHeader()"/><a href="javascript: void" id="pos4" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos4', 4 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>


<tr>
<td align="left" colspan="2" class="grey">
<u>PT Performance Pay</u>    
</td>
</tr>


<tr>
<td class="black">
Turn on Trainer Performance Bonus:
</td>
<td>
<select tabindex= "5" name="performance_switch" id="performance_switch">
<option value="$current_bonus_setup" selected>$bonusText</option>  
<option value=\"1\">On</option>
<option value=\"0\">Off</option>
</select><a href="javascript: void" id="pos5" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos5', 5 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black" id="enhance_text">
Session Total Tier 1
</td>
<td>
<input tabindex= "6" name="tier_1" type="text" id="tier_1" value= "$tier_1" size="10" maxlength="8"/></select><a href="javascript: void" id="pos6" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos6', 6 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black" id="enhance_text">
Hourly Bump Tier 1:
</td>
<td>
<input tabindex= "7" name="hourly_bump_1" type="text" id="hourly_bump_1" value= "$hourly_bump_1" size="10" maxlength="8" /></select><a href="javascript: void" id="pos7" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos7', 7 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black" id="enhance_text">
Session Total Tier 2
</td>
<td>
<input tabindex= "8" name="tier_2" type="text" id="tier_2" value= "$tier_2" size="10" maxlength="8" /></select><a href="javascript: void" id="pos8" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos8', 8 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black" id="enhance_text">
Hourly Bump Tier 2:
</td>
<td>
<input tabindex= "9" name="hourly_bump_2" type="text" id="hourly_bump_2" value= "$hourly_bump_2" size="10" maxlength="8" /></select><a href="javascript: void" id="pos9" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos9', 9 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black" id="enhance_text">
Session Total Tier 3
</td>
<td>
<input tabindex= "10" name="tier_3" type="text" id="tier_3" value= "$tier_3" size="10" maxlength="8" /></select><a href="javascript: void" id="pos10" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos10', 10 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black" id="enhance_text">
Hourly Bump Tier 3:
</td>
<td>
<input tabindex= "11" name="hourly_bump_3" type="text" id="hourly_bump_3" value= "$hourly_bump_3" size="10" maxlength="8" /></select><a href="javascript: void" id="pos11" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos11', 11 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td align="left" colspan="2" class="grey">
<u>PT Assesments</u>    
</td>
</tr>


<tr>
<td class="black">
Number of assesments given:
</td>
<td>
<select tabindex= "12" name="num_assesments" id="num_assesments">
<option value="$num_assesments" selected>$num_assesments</option>  
<option value=\"1\">1</option>
<option value=\"2\">2</option>
<option value=\"3\">3</option>
<option value=\"4\">4</option>
<option value=\"5\">5</option>
<option value=\"6\">6</option>
</select><a href="javascript: void" id="pos12" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos12', 12 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black">
Paid Assesments:
</td>
<td>
<select tabindex= "5" name="paid_assesments" id="paid_assesments">
<option value="$paid_assesments" selected>$paidText</option>  
<option value=\"Y\">Yes</option>
<option value=\"N\">No</option>
</select><a href="javascript: void" id="pos13" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos13', 13 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black">
Paid Assesments Amount:
</td>
<td>
<input tabindex= "13" name="paid_assesment_amount" type="text" id="paid_assesment_amount" value= "$paid_assesment_amount" size="10" maxlength="8" /></select><a href="javascript: void" id="pos14" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos14', 14 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td align="left" colspan="2" class="grey">
<u>PT Reminders</u>    
</td>
</tr>


<tr>
<td class="black">
Turn on Reminders:
</td>
<td>
<select tabindex= "12" name="reminders_on" id="reminders_on">
<option value="$reminders_on" selected>$reminders_on_text</option>  
<option value=\"Y\">Yes</option>
<option value=\"N\">No</option>
</select><a href="javascript: void" id="pos15" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos15', 15 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black">
Reminder Time in Hours:
</td>
<td>
<input tabindex= "13" name="reminder_hours" type="text" id="reminder_hours" value= "$reminder_hours" size="10" maxlength="8" /></select><a href="javascript: void" id="pos16" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos16', 16 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td  colspan="2" align="left">
<br>
<input type="submit" name="$submit_name" value="$submit_title" />
<input type="hidden" name="marker" value="1" />
<input type="hidden" name="enhance_fee_total" id="enhance_fee_total" value= "$enhance_fee_total"/>
<input type="hidden" name="guarantee_fee_total" id="guarantee_fee_total" value= "$guarantee_fee_total"/>
$hidden
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


echo"$ptPayrollTemplate";

?>


