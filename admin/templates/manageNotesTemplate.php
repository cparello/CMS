<?php
$notesTemplate = <<<NOTESTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/manageNotes.css">
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


<div id="noteForm">
  <form id="form1" name="form1" method="post" action="manageNotes.php">

<table border="0" align="center">
<tr>
<td colspan="3" class="grey" align="left">
<u>Set Note Duration</u><a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos1', 1);" /><img src="../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>
<tr>
<td class="black">
Low Priority: &nbsp;<input type="text"  name="low_days" id="low_days" value="$low_days" size="3" maxlength="3"/>
</td>
<td class="black">
Medium Priority: &nbsp;<input type="text"  name="medium_days" id="medium_days" value="$medium_days" size="3" maxlength="3"/>   
<td>
<td class="black">
High Priority: &nbsp;<input type="text"  name="high_days" id="high_days" value="$high_days"  size="3" maxlength="3"/>
</td>
</tr>

<tr>
<td colspan="3" class="grey" align="left">
<u>Outgoing Note Assignment</u><a href="javascript: void" id="pos2" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos2', 2);" /><img src="../images/question-mark.png" class="alignMiddle"></a> 
</td>

<tr>
<td class="black">
<p>Sales Interface:</p>
<select multiple="yes" size="5" name="assignment_sales[]" id="assignment_sales" />
$sales_drop
</select>
</td>
<td class="black">
<p>Member Interface:</p>
<select multiple="yes" size="5" name="assignment_member[]" id="assignment_member" />
$member_drop
</select>   
<td>
<td class="black">
<p>Billing Interface:</p> 
<select multiple="yes" size="5" name="assignment_billing[]" id="assignment_billing" />
$billing_drop
</select>
</td>
</tr>

<tr>
<td class="black">
<p>Employee Services:</p>
<select multiple="yes" size="5" name="assignment_emp[]" id="assignment_emp" />
$emp_drop
</select>
</td>
<td class="black" colspan="2" >
<p>Internet Services:</p>
<select multiple="yes" size="5" name="assignment_internet[]" id="assignment_internet" />
$internet_drop
</select>   
<td>
</tr>


<tr>
<td class="black" colspan="3">
<br><br>
<input type="submit" name="name" value="Update Note Assignment / Duration" /></tr>
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
NOTESTEMPLATE;


echo"$notesTemplate";

?>


