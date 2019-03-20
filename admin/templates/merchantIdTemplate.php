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

<table border="0" align="center">
<tr>
<td colspan="2" class="grey">
<u>Transaction Processor</u>
</td>
</tr>

<tr>
<td class="black">
 <form id="form1" name="form1" method="post" action="$submit_link" onSubmit="return checkData()">
Set Merchant ID:
</td>
<td>
<input tabindex= "1" name="merchant_id" type="text" id="merchant_id" value= "$merchant_id" size="25" maxlength="20" onBlur="killHeader()"/><a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos1', 2);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>

<tr>
<td class="black">
Processor Mode:
</td>
<td class="black">
<select  name="account_mode" id="account_mode" onClick="killHeader()"/>
<option value>Select Mode</option>
<option value="1" $testSelect >Test Mode</option>
<option value="2" $liveSelect >Live Mode</option>
</select>
<a href="javascript: void" id="pos2" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos2', 3);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>

<tr>
<td>
&nbsp;
</td>
<td>
<input type="submit" name="edit_id" value="Edit Options" />
<input type="hidden" name="marker" value="1" />
</form>
</td>
</tr>



<tr>
<td colspan="2">
&nbsp;
</td>
</tr>



<tr>
<td colspan="2" class="grey">
<u>Transaction Settlement</u>
</td>
</tr>

<tr>
<td class="black">
 <form id="form2" name="form2" method="post" action="$submit_link" onSubmit="return checkDataTwo()">
Set User Name:
</td>
<td>
<input tabindex= "1" name="cs_user_name" type="text" id="cs_user_name" value= "$cs_user_name" size="25" maxlength="20" onBlur="killHeader()"/><a href="javascript: void" id="pos4" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos4', 4);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>

<tr>
<td class="black">
Set Password:
</td>
<td>
<input tabindex= "1" name="cs_password" type="text" id="cs_password" value= "$cs_password" size="25" maxlength="20" onBlur="killHeader()"/><a href="javascript: void" id="pos5" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos5', 5);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr> 

<tr>
<td class="black">
Settlement Mode:
</td>
<td class="black">
<select  name="settle_mode" id="settle_mode" onClick="killHeader()"/>
<option value>Select Mode</option>
<option value="1" $testSelectTwo >Test Mode</option>
<option value="2" $liveSelectTwo >Live Mode</option>
</select>
<a href="javascript: void" id="pos6" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos6', 6);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>

<tr>
<td>
&nbsp;
</td>
<td>
<input type="submit" name="edit_id" value="Edit Options" />
<input type="hidden" name="marker" value="2" />
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

?>


