<?php
$editExpiredEnrollTemplate = <<<EDITEXPIREDENROLL
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/pop_hint2.css">
<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/editExpiredEnroll.css">
$javaScript1
$javaScript2
$javaScript3
$javaScript4
$javaScript5


<title>Edit Expired Re-enrollment Options</title>

</head>
<body $confirmation >
$infoTemplate

<div id="userHeader">
Edit Expired Re-enrollment Options 
</div>


<div id="innerOne">
<span class="grey">
<u>Expired Re-enrollment Parameters</u><a href="javascript: void" id="pos8" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos8', 8);" /><img src="../images/question-mark.png" class="alignMiddle"></a>
</span>
</div>

<div id="monthParams">
<form name="form1" method="post" action="" onSubmit="return checkData();">
<table align="left">
<tr>
<th align="left" class="black padOne">
Invoice Header:
</th>
<td align="left" class="padFour">
<input name="er_header" type="text" id="er_header" value="$er_header" size="40" maxlength="200"/>
</td>
</tr>
<tr>
<th align="left" valign="top" class="black padThree">
Body Text 1:
</th>
<td align="left" class="padSix">
<textarea name="er_txt_one" rows="4" cols="34" wrap="hard">
$er_txt_one
</textarea>
</td>
</tr>

<tr>
<th align="left" valign="top" class="black padThree">
Body Text 2:
</th>
<td align="left" class="padSix">
<textarea name="er_txt_two" rows="4" cols="34" wrap="hard">
$er_txt_two
</textarea>
</td>
</tr>


<tr>
<th align="left" valign="top" class="black padThree">
&nbsp;
</th>
<td align="left" class="padSix">
$er_term_types
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
EDITEXPIREDENROLL;


echo"$editExpiredEnrollTemplate";
?>