<?php
$termsTemplate = <<<TERMSTEMPLATE
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
$confirmation 
</div>


<div id="userForm">
  <form id="form1" name="form1" method="post" action="$submit_link">

<table border="0" align="center">
<tr>
<td colspan="2" class="grey">
<u>Term Types</u>
</td>
</tr>

<tr>
<td class="black">
Legal Term:
</td>
<td>
<input tabindex= "1" name="contract_quit" type="text" id="contract_quit" value= "$contract_quit" size="10" maxlength="2" onFocus="killHeader()"/><a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos1', 1);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>



<tr>
<td class="black" valign="top">
Terms and Conditions:
</td>
<td>
<textarea tabindex= "2" cols="70" rows="20" name="terms_conditions" id="terms_conditions" onFocus="killHeader()"/>$terms_conditions</textarea><a href="javascript: void" id="pos2" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -300, 'pos2', 2 );" /><img src="../images/question-mark.png" class="alignTop"></a>              
</td>
</tr>


<tr>
<td>
&nbsp;
</td>
<td>
<input type="submit" name="$submit_name" value="$submit_title" />
<input type="hidden" name="marker" value="1" />
$hidden
</td>
</tr>

<tr>
<td id="idContent1" colspan="2">
$errorHtml  
</td>              
</tr>


</form>
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
TERMSTEMPLATE;


echo"$termsTemplate";

?>


