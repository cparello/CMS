<?php
$notesTemplate = <<<GUESTPASSTEMPLATE
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
<form id="form1" name="form1" method="post" action="createGuestPass.php">
<table border="0" align="center">
<tr>
<td colspan="3" class="grey" align="left">
<u>Select Location/ Create Title</u><a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos1', 1);" /><img src="../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>

<tr>
<td class="black">
Select Location:
</td>
<td class="black">
Guest Pass Title:   
<td>
</tr>

<tr>
<td class="black">
<select name="service_location" id="service_location" class="pullConf"/>$drop_menu</select>
</td>
<td class="black">
<input type="text"  name="title" id="title" value="" size="30" maxlength="40" class="pullConf"/>   
<td>
</tr>

<tr>
<td colspan="2" class="greyTwo" align="left">
<u>Set Guest Pass Duration</u><a href="javascript: void" id="pos2" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos2', 2);" /><img src="../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>

<tr>
<td class="black tdPad" colspan="2">
<table>
<tr>
<td class="black tdPad">
Term One
</td>
<td class="black tdPad">
Term Two
</td>
<td class="black tdPad">
Term Three
</td>
<td class="black tdPad">
Term Four
</td>
</tr>

<tr>
<td class="black">
<input type="text" class="terms pullConf" name="term_one" id="term_one" value="" size="2" maxlength="2"/> 
</td>
<td class="black">
<input type="text" class="terms pullConf" name="term_two" id="term_two" value="" size="2" maxlength="2"/> 
</td>
<td class="black">
<input type="text" class="terms pullConf" name="term_three" id="term_three" value="" size="2" maxlength="2"/> 
</td>
<td class="black">
<input type="text" class="terms pullConf" name="term_four" id="term_four" value="" size="2" maxlength="2"/> 
</td>
</tr>
</table>
</td>
</tr>

<tr>
<td colspan="2" class="greyTwo" align="left">
<u>Choose Services</u><a href="javascript: void" id="pos3" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos3', 3);" /><img src="../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>

<tr>
<td colspan="2" class="black" id="servList" align="left">
$services_list
</td>
</tr>

<tr>
<td colspan="2" class="greyTwo" align="left">
<u>Marketing Message</u><a href="javascript: void" id="pos4" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos4', 4);" /><img src="../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>


<tr>
<td class="black" colspan="2">
Topic:
</td>
</tr>

<tr>
<td class="black" colspan="2">
<input type="text"  name="pass_topic" id="topic" value="" size="30" maxlength="40" class="pullConf"/>   
<td>
</tr>


<tr>
<td class="black" colspan="2">
Message:
</td>
</tr>


<tr>
<td colspan="2" class="black" align="left">
<textarea  cols="40" rows="3" name="pass_desc" id="pass_desc" tabindex= "2" class="pullConf"></textarea>
</td>
</tr>


<tr>
<td class="black" colspan="3">
<br><br>
<input type="submit" name="save" value="Save Guest Pass" /></tr>
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
GUESTPASSTEMPLATE;


echo"$notesTemplate";

?>


