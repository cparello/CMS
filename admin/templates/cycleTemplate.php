<?php
$cycleTemplate = <<<CYCLETEMPLATE
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
<u>Monthly Billing Cycle</u>    
</td>
</tr>


<tr>
<td class="black" width="225">
Billing Day:
</td>
<td>
<input tabindex= "1" name="billing_day" type="text" id="billing_day" value= "$billing_day" size="10" maxlength="2" onFocus="killHeader()"/><a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos1', 1 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>


<tr>
<td align="left" colspan="2" class="grey">
<u>Enhancement Fee Cycle Dates</u>    
</td>
</tr>


<tr>
<td class="black">
Cycle Date:
</td>
<td>
<input tabindex= "1" name="pif_enhance_date" type="text" id="pif_enhance_date" value= "$pif_enhance_date" size="10" maxlength="10" onFocus="killHeader()"/><a href="javascript: void" id="pos2" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos2', 2 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black">
Term Type:
</td>
<td>
<select tabindex= "3" name="enh_term_switch" id="enh_term_switch">
$e_term_select_list
</select><a href="javascript: void" id="pos7" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos7', 7 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>


<tr>
<td class="black">
Cycle Frequency:
</td>
<td>
<select tabindex= "3" name="eft_enhancement_cycle" id="eft_enhancement_cycle" onChange="parsePaymentValues(this.value, this.name); killHeader();">
$enhance_select_list
</select><a href="javascript: void" id="pos3" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos3', 3 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black" id="enhance_text">
$enhance_summary_text
</td>
<td>
<input tabindex= "2" name="enhance_fee_value" type="text" id="enhance_fee_payment" value= "$enhance_fee_payment" size="10" maxlength="8" disabled="disabled"/>
</td>
</tr>


<tr>
<td align="left" colspan="2" class="grey">
<u>Guarantee Fee Cycle Dates</u>    
</td>
</tr>


<tr>
<td class="black">
Cycle Date:
</td>
<td>
<input tabindex= "1" name="guarantee_annual_date" type="text" id="guarantee_annual_date" value= "$guarantee_annual_date" size="10" maxlength="10" onFocus="killHeader()"/><a href="javascript: void" id="pos4" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos4', 4 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black">
Term Type:
</td>
<td>
<select tabindex= "3" name="eft_term_switch" id="eft_term_switch">
$g_term_select_list
</select><a href="javascript: void" id="pos6" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos6', 6 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>




<tr>
<td class="black">
Cycle Frequency:
</td>
<td>
<select tabindex= "3" name="eft_guarantee_cycle" id="eft_guarantee_cycle" onChange="parsePaymentValues(this.value, this.name); killHeader();">
$guarantee_select_list
</select><a href="javascript: void" id="pos5" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos5', 5 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>


<tr>
<td class="black" id="guarantee_text">
$guarantee_summary_text
</td>
<td>
<input tabindex= "2" name="guarantee_fee_payment" type="text" id="guarantee_fee_payment" value= "$guarantee_fee_payment" size="10" maxlength="8" disabled="disabled"/>
</td>
</tr>

<tr>
<td align="left" colspan="2" class="grey">
<u>Maintnence Fee Cycle Dates</u>    
</td>
</tr>

<tr>
<td class="black">
Term Type:
</td>
<td>
<select tabindex= "3" name="m_term_switch" id="m_term_switch">
$m_term_select_list
</select><a href="javascript: void" id="pos15" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos15', 15 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black">
Cycle Frequency:
</td>
<td>
<select tabindex= "3" name="m_cycle" id="m_cycle" onChange="parsePaymentValues(this.value, this.name); killHeader();">
$maintnence_select_list
</select><a href="javascript: void" id="pos16" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos16', 16 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>


<tr>
<td class="black" id="guarantee_text">
$maintnence_summary_text
</td>
<td>
<input tabindex= "2" name="maintnence_fee_payment" type="text" id="maintnence_fee_payment" value= "$maintnence_fee_payment" size="10" maxlength="8" disabled="disabled"/>
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


echo"$cycleTemplate";

?>


