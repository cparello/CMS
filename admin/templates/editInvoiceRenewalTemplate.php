<?php
$editInvoiceRenewalTemplate = <<<EDITINVOICERENEWAL
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/pop_hint2.css">
<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/editInvoiceRenewal.css">
$javaScript1
$javaScript2
$javaScript3
$javaScript4
$javaScript5


<title>Edit Invoice Renewal Options</title>

</head>
<body $confirmation >
$infoTemplate

<div id="userHeader">
Edit Renewal Invoice Options 
</div>


<div id="innerOne">
<span class="grey">
<u>Early Renewal Invoice Parameters</u><a href="javascript: void" id="pos5" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos5', 5);" /><img src="../images/question-mark.png" class="alignMiddle"></a>
</span>
</div>

<div id="monthParams">
<form name="form1" method="post" action="editRenewalInvoices.php" onSubmit="return checkData();">
<table align="left">
<tr>
<th align="left" class="black padOne">
Invoice Header:
</th>
<td align="left" class="padFour">
<input name="early_header" type="text" id="early_header" value="$early_header" size="40" maxlength="200"/>
</td>
</tr>
<tr>
<th align="left" valign="top" class="black padThree">
Body Text:
</th>
<td align="left" class="padSix">
<textarea name="early_txt" rows="4" cols="34" wrap="hard">
$early_txt
</textarea>
</td>
</tr>
</table>
</div>

<div id="innerTwo">
<span class="grey">
<u>Grace Period Invoice Parameters</u><a href="javascript: void" id="pos6" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos6', 6);" /><img src="../images/question-mark.png" class="alignMiddle"></a>
</span>
</div>

<div id="pastParams">
<table align="left">
<tr>
<th align="left" class="black padOne">
Invoice Header:
</th>
<td class="padFour">
<input name="grace_header" type="text" id="grace_header" value="$grace_header" size="40" maxlength="200"/>
</td>
</tr>
<tr>
<th align="left" valign="top" class="black padTwo">
Body Text:
</th>
<td class="padSix">
<textarea name="grace_txt" rows="4" cols="34" wrap="hard">
$grace_txt
</textarea>

</td>
</tr>
</table>
</div>


<div id="innerThree">
<span class="grey">
<u>General Invoice Parameters</u><a href="javascript: void" id="pos7" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos7', 7);" /><img src="../images/question-mark.png" class="alignMiddle"></a>
</span>
</div>

<div id="rejectParams">
<table align="left">
<tr>
<th align="left" class="black padOne">
Invoice Header:
</th>
<td class="padFour">
<input name="general_header" type="text" id="general_header" value="$general_header" size="40" maxlength="200"/>
</td>
</tr>
<tr>
<th align="left" valign="top" class="black padTwo">
Body Text:
</th>
<td class="padSix">
<textarea name="general_txt" rows="4" cols="34" wrap="hard">
$general_txt
</textarea>

</td>
</tr>
</table>
</div>



<div id="innerFive">
<input type="submit" name="submit"  id="submit" class="button1" value="Update Renewal Invoice Options"/>
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
EDITINVOICERENEWAL;


echo"$editInvoiceRenewalTemplate";
?>