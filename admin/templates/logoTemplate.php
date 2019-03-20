<?php
$logoTemplate = <<<LOGOTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/logo.css">
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
  <form id="form1" name="form1" method="post" action="$submit_link" enctype="multipart/form-data" onSubmit="return checkData()">

<table border="0" align="center">
<tr>
<td colspan="2" class="grey">
<u>Logo Uploads</u>
</td>
</tr>

<tr>
<td class="black">
Current Logo:
</td>
<td>
<img src="$file_path$image_name" $width_height class="alignMiddle">
<td>
</tr>


<tr>
<td class="black">
Upload Photo:
</td>
<td>
<input tabindex= "1" name="imagefile" type="file" id="imagefile" value= "" onFocus="killHeader()"/><a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos1', 1);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>



<tr>
<td>
&nbsp;
</td>
<td>
<input name="submit" type="submit" value="Upload" />&nbsp;&nbsp;<input name="reset" type="reset" class="form" value="Clear"/>
<input type="hidden" name="marker" value="1" />
</td>
</tr>

<tr>
<td>
&nbsp;
</td>
<td id="idContent1" align="left">  
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
LOGOTEMPLATE;


echo"$logoTemplate";

?>


