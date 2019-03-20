<?php
$userTemplate = <<<PAYOPSTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/payment_options.css">
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
  <form id="form1" name="form1" method="post" action="$submit_link" onSubmit="return setBitMaps();">

<table border="0" width="65%" align="center">
<tr>
<td colspan="4" class="grey" align="left">
<u>General Payment Options</u><a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos1', 1);" /><img src="../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>
<tr>
<td class="black">
Cash: &nbsp;<input type="checkbox" name="gen_pay" value="1" onClick="killHeader()" $cash_checked1/>
</td>
<td class="black">
Check: &nbsp;<input type="checkbox" name="gen_pay" value="2" onClick="killHeader()" $check_checked1/>   
<td>
<td class="black">
ACH: &nbsp;<input type="checkbox" name="gen_pay" value="3" onClick="killHeader()" $ach_checked1/>
</td>
<td class="black">
Credit: &nbsp;<input type="checkbox" name="gen_pay" value="4" onClick="killHeader()" $credit_checked1/>   
<td>
</tr>


<tr>
<td colspan="4" class="grey" align="left">
<u>Monthly Payment Options</u><a href="javascript: void" id="pos2" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos2', 2 );" /><img src="../images/question-mark.png" class="alignTop"></a>
</td>
</tr>
<tr>
<td class="black">
Cash: &nbsp;<input type="checkbox" name="month_pay" value="1" onClick="killHeader()" $cash_checked2/>
</td>
<td class="black">
Check: &nbsp;<input type="checkbox" name="month_pay" value="2" onClick="killHeader()" $check_checked2/>   
<td>
<td class="black">
ACH: &nbsp;<input type="checkbox" name="month_pay" value="3" onClick="killHeader()" $ach_checked2/>
</td>
<td class="black">
Credit: &nbsp;<input type="checkbox" name="month_pay" value="4" onClick="killHeader()" $credit_checked2/>   
<td>
</tr>


<tr>
<td colspan="4" align="left" class="subPad">
<input type="submit" name="$submit_name" value="$page_title" />
<input type="hidden" name="marker" value="1" />
$hidden
<input type="hidden" name="gen_bit"  id="gen_bit" value=""/>
<input type="hidden" name="month_bit"  id="month_bit" value=""/>

</form>
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
PAYOPSTEMPLATE;


echo"$userTemplate";

?>
