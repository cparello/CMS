<?php
$feeTemplate = <<<FEETEMPLATE
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
<u>Overide Pin</u>
</td>
</tr>
<tr>
<td class="black">
 <form id="form2" name="form1" method="post" action="editPins.php" onSubmit="return checkData()">
Set Overide Pin:
</td>
<td>
<input tabindex= "1" name="overide_pin_one" type="text" id="overide_pin_one" value= "$overide_pin_one" size="10" maxlength="4" onBlur="killHeader()"/><a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos1', 1);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>
<tr>
<td>
&nbsp;
</td>
<td>
<input type="submit" name="update_pin" value="Update PIN" />
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
FEETEMPLATE;


echo"$feeTemplate";

?>


