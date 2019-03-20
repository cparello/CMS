<?php
$guestPassEmailTemplate = <<<GUESTPASSEMAILTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/createGuestPass.css">
<link rel="stylesheet" href="../css/pop_hint.css">
<link rel="stylesheet" href="../css/info.css">
$javaScript1
$javaScript2
$javaScript3
$javaScript4
<title>$page_title</title>

</head>
<body>

$infoTemplate

<div id="userHeader">
$page_title  
</div>

<div id="conf" class="conf">
$confirmation 
</div>


<div id="noteForm">
<form id="form1" name="form1" method="post" action="editGuestPassEmail.php">
<table border="0" align="center">
<tr>
<td colspan="3" class="grey" align="left">
<u>Set Sender/ Reply To Email Addresses</u><a href="javascript: void" id="pos7" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos7', 7);" /><img src="../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>

<tr>
<td class="black">
Sender Email:
</td>
</tr>

<tr>
<td class="black">
<input type="text"  name="from_address" id="from_address" value="$from_address" size="30" maxlength="40" class="pullConf"/>   
<td>
</tr>

<tr>
<td class="black">
Reply To Email:
</td>
</tr>

<tr>
<td class="black">
<input type="text"  name="reply_address" id="reply_address" value="$reply_address" size="30" maxlength="40" class="pullConf"/>   
<td>
</tr>



<tr>
<td colspan="2" class="greyTwo" align="left">
<u>Set From Name/ Intro Message</u><a href="javascript: void" id="pos8" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos8', 8);" /><img src="../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>


<tr>
<td class="black">
From Name:
</td>
</tr>

<tr>
<td class="black">
<input type="text"  name="from_name" id="from_name" value="$from_name" size="30" maxlength="40" class="pullConf"/>   
<td>
</tr>



<tr>
<td class="black">
Intro Message:
</td>
</tr>


<tr>
<td class="black" align="left">
<textarea  cols="40" rows="3" name="intro_message" id="intro_message" tabindex= "2" class="pullConf">$intro_message</textarea>
</td>
</tr>


<tr>
<td class="black">
<br><br>
<input type="submit" name="save" value="Edit Guest Pass Email" /></tr>
<td>
</tr>
</table>

<input type="hidden" name="marker"  id="marker" value="1"/>
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
GUESTPASSEMAILTEMPLATE;


echo"$guestPassEmailTemplate";

?>


