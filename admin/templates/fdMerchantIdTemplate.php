<?php
$idTemplate = <<<IDTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/pins.css">
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
<table border="0" align="center">
<tr>
<td colspan="2" class="grey">
<u>Transaction Processor</u>
</td>
</tr>

<tr>
<td>
<h3>All Clubs</h3>
</td>
</tr>

<tr>
<td class="black">
Set Max Retries/Cycle:
</td>
<td>
<input tabindex= "1" name="max_retry" type="text" id="max_retry" value= "$max_retry" size="25" maxlength="20" onBlur="killHeader()"/><a href="javascript: void" id="pos6" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos6', 6);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>

<tr>
<td class="black">
Send Email for Failed Payments (after max retries):
</td>
<td>
<select  name="email_bool" id="email_bool"/>
$emailSelectList
</select>
<a href="javascript: void" id="pos11" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos11', 11);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>

<tr>
<td class="black">
Set Max Failed-Cycles:
</td>
<td>
<input tabindex= "1" name="max_fail_cycles" type="text" id="max_fail_cycles" value= "$max_fail_cycles" size="25" maxlength="20" onBlur="killHeader()"/><a href="javascript: void" id="pos7" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos7', 7);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>






<tr>
<td>
<h3>$clubName1</h3>
</td>
</tr>


<tr>
<td class="black">
Set Gateway ID:
</td>
<td>
<input tabindex= "1" name="gateway_id1" type="text" id="gateway_id1" value= "$gateway_id1" size="25" maxlength="20" onBlur="killHeader()"/><a href="javascript: void" id="pos3" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos3', 3);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>

<tr>
<td class="black">
Set Gateway Password:
</td>
<td>
<input tabindex= "1" name="gateway_pass1" type="text" id="gateway_pass1" value= "$gateway_pass1" size="25" maxlength="20" onBlur="killHeader()"/><a href="javascript: void" id="pos4" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos4', 4);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>









<tr>
<td>
<h3>$clubName2</h3>
</td>
</tr>

<tr>
<td class="black">
Set Gateway ID:
</td>
<td>
<input tabindex= "1" name="gateway_id2" type="text" id="gateway_id2" value= "$gateway_id2" size="25" maxlength="20" onBlur="killHeader()"/><a href="javascript: void" id="pos3" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos3', 3);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>

<tr>
<td class="black">
Set Gateway Password:
</td>
<td>
<input tabindex= "1" name="gateway_pass2" type="text" id="gateway_pass2" value= "$gateway_pass2" size="25" maxlength="20" onBlur="killHeader()"/><a href="javascript: void" id="pos4" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos4', 4);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>



<tr>
<td colspan="2">
&nbsp;
</td>
</tr>



<tr>
<td colspan="2" class="grey">
<u></u>
</td>
</tr>



<tr>
<td>
&nbsp;
</td>
<td>
<input type="submit" name="edit_id" value="Update Options" />
<input type="hidden" name="marker" value="1" />
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
IDTEMPLATE;


echo"$idTemplate";


/*<tr>
<td class="black">
Send Expired Cards to Processor:
</td>
<td>
<select  name="exp_bool" id="exp_bool"/>
$expSelectList
</select>
<a href="javascript: void" id="pos9" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos9', 9);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>

<tr>
<td class="black">
Month Sent on Expired Cards:
</td>
<td>
<select  name="exp_month" id="exp_month"/>
$expMonthSelectList
</select>
<a href="javascript: void" id="pos12" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos12', 12);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>


<tr>
<td class="black">
Year Sent on Expired Cards:
</td>
<td>
<select  name="exp_year" id="exp_year"/>
$expYearSelectList
</select>
<a href="javascript: void" id="pos13" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos13', 13);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>

<tr>
<td class="black">
Stop Re-Attempts On Non NSF:
</td>
<td>
<select  name="nsf_bool" id="nsf_bool"/>
$nsfSelectList
</select>
<a href="javascript: void" id="pos10" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos10', 10);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>




<tr>
<td class="black">
Set HMAC Key:
</td>
<td>
<input tabindex= "1" name="hmac1" type="text" id="hmac1" value= "$hmac1" size="40" maxlength="40" onBlur="killHeader()"/><a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos1', 1);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>

<tr>
<td class="black">
Set Key ID:
</td>
<td>
<input tabindex= "1" name="key_id1" type="text" id="key_id1" value= "$key_id1" size="25" maxlength="20" onBlur="killHeader()"/><a href="javascript: void" id="pos2" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos2', 2);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>
<tr>
<td class="black">
Set Gateway Language:
</td>
<tr>
<td>
<input tabindex= "1" name="gateway_lang1" type="text" id="gateway_lang1" value= "$gateway_lang1" size="25" maxlength="20" onBlur="killHeader()"/><a href="javascript: void" id="pos5" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos5', 5);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>*/
?>


