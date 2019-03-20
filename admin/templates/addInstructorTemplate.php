<?php
$instructorTemplate = <<<INSTRUCTORTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/scheduleType.css">
<link rel="stylesheet" href="../css/pop_hint.css">
$javaScript1
$javaScript2
$javaScript3
$javaScript4
$javaScript5

<title>$page_title </title>

</head>
<body>
$infoTemplate

<div id="userHeader">
$page_title 
</div>

<div id="conf" class="conf">
&nbsp;
</div>


<div id="userForm">

<form id="form1" name="form1" method="post" action="addInstructor.php" enctype="multipart/form-data"/>

<table border="0" align="center">
<tr>
<td class="black">
1. Instructor Name:
&nbsp;&nbsp;
</td>
<td>
<input tabindex= "1" name="instructor_name" type="text" id="instructor_name" value="" size="30" maxlength="30"/>
<td>
</tr>


<tr>
<td class="black" valign="top">
2. Instructor Description:
&nbsp;&nbsp;&nbsp;&nbsp;
</td>
<td>
<textarea cols="26" rows="5" name="instructor_description" id="instructor_description"></textarea><a href="javascript: void" id="pos3" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -25, -85, 'pos3', 3 );" /><img src="../images/question-mark.png" class="alignTop"></a>    
<td>
</tr>


<tr>
<td class="black">
3. Upload Instructor Photo:
&nbsp;&nbsp;&nbsp;&nbsp;
</td>
<td>
<input tabindex= "1" name="imagefile" type="file" id="imagefile" value= ""/><a href="javascript: void" id="pos4" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos4', 4);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>


<tr>
<td>
</td>
<td id="error1">
</td>
</tr>



<tr>
<td>
</td>
<td class="black termSpace" colspan="2" align="left">
<input type="submit" id="button1" name="button1" class="button1" value="$page_title" />
&nbsp;&nbsp;<input type="reset" class="button1" value="Reset">
<input name="type_id" type="hidden" id="type_id" value="$type_id" />
<input type="hidden" name="type_name" value="$type_name"/>
<input type="hidden" name="schedule_type" value="$schedule_type"/>
<input type="hidden" name="confirmation" id="confirmation" value="$confirmation"/>
<input type="hidden" name="marker" value="1"/>
</form>
<td>
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
INSTRUCTORTEMPLATE;


echo"$instructorTemplate";
?>