<?php
$editInvoicesTemplate = <<<EDITINVOICES
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/pop_hint2.css">
<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/editInvoices.css">
$javaScript1
$javaScript2
$javaScript3
$javaScript4
$javaScript5


<title>Edit Invoice Options</title>

</head>
<body $confirmation >
$infoTemplate

<div id="userHeader">
Edit Invoice Options 
</div>


<div id="innerOne">
<span class="grey">
<u>Monthly Invoice Parameters</u><a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos1', 1);" /><img src="../images/question-mark.png" class="alignMiddle"></a>
</span>
</div>

<div id="monthParams">
<form name="form1" method="post" action="editInvoices.php" onSubmit="return checkData();">
<table align="left">
<tr>
<th align="left" class="black padOne">
Invoice Header:
</th>
<td align="left" class="padFour">
<input name="monthly_header" type="text" id="monthly_header" value="$monthly_header" size="40" maxlength="200"/>
</td>
</tr>
<tr>
<th align="left" valign="top" class="black padThree">
Body Text:
</th>
<td align="left" class="padSix">
<textarea name="monthly_txt" rows="4" cols="34" wrap="hard">
$monthly_txt
</textarea>
</td>
</tr>
</table>
</div>

<div id="innerTwo">
<span class="grey">
<u>Past Due Invoice Parameters</u><a href="javascript: void" id="pos2" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos2', 2);" /><img src="../images/question-mark.png" class="alignMiddle"></a>
</span>
</div>

<div id="pastParams">
<table align="left">
<tr>
<th align="left" class="black padOne">
Invoice Header:
</th>
<td class="padFour">
<input name="past_due_header" type="text" id="past_due_header" value="$past_due_header" size="40" maxlength="200"/>
</td>
</tr>
<tr>
<th align="left" valign="top" class="black padTwo">
Body Text:
</th>
<td class="padFive">
<textarea name="past_due_txt" rows="4" cols="34" wrap="hard">
$past_due_txt
</textarea>
</td>
</tr>
<tr>
<th align="left"  class="black padTwo">
Invoice Attempts:
</th>
<td class="padFive">
$past_due_radios
</td>
</tr>
<tr>
<th align="left"  class="black padThree">
Invoice Frequency:
</th>
<td class="padSix">
<select name="pd_frequency" id="pd_frequency">
$past_drop_menu
</select>
</td>
</tr>
</table>
</div>


<div id="innerThree">
<span class="grey">
<u>Declined/Rejected Invoice Parameters</u><a href="javascript: void" id="pos3" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos3', 3);" /><img src="../images/question-mark.png" class="alignMiddle"></a>
</span>
</div>

<div id="rejectParams">
<table align="left">
<tr>
<th align="left" class="black padOne">
Invoice Header:
</th>
<td class="padFour">
<input name="rejected_declined_header" type="text" id="rejected_declined_header" value="$rejected_declined_header"size="40" maxlength="200"/>
</td>
</tr>
<tr>
<th align="left" valign="top" class="black padTwo">
Body Text:
</th>
<td class="padFive">
<textarea name="rejected_declined_txt" rows="4" cols="34" wrap="hard">
$rejected_declined_txt
</textarea>
</td>
</tr>
<tr>
<th align="left"  class="black padTwo">
Invoice Attempts:
</th>
<td class="padFive">
$rejected_declined_radios
</td>
</tr>
<tr>
<th align="left"  class="black padThree">
Invoice Frequency:
</th>
<td class="padSix">
<select name="rj_frequency" id="rj_frequency">
$reject_declined_drop_menu
</select>
</td>
</tr>
</table>
</div>

<div id="innerFour">
<span class="grey">
<u>Final Notice Parameters</u><a href="javascript: void" id="pos4" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos4', 4);" /><img src="../images/question-mark.png" class="alignMiddle"></a>
</span>
</div>

<div id="finalParams">
<table align="left">
<tr>
<th align="left" class="black padOne">
Invoice Header:
</th>
<td align="left" class="padFour">
<input name="final_header" type="text" id="final_header" value="$final_header"size="40" maxlength="200"/>
</td>
</tr>
<tr>
<th align="left" valign="top" class="black padThree">
Body Text:
</th>
<td align="left" class="padSix">
<textarea name="final_txt" rows="4" cols="34" wrap="hard">
$final_txt
</textarea>
</td>
</tr>
</table>
</div>

<div id="innerFive">
<input type="submit" name="submit"  id="submit" class="button1" value="Update Invoice Options"/>
<input type="hidden" name="marker" value="1" />
</form>
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
EDITINVOICES;


echo"$editInvoicesTemplate";
?>