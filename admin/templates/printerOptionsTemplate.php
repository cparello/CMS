<?php
$printerOptionsTemplate = <<<PRINTEROPTIONSTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/printerOptions.css">
<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/pop_hint.css">
$javaScript1
$javaScript2
$javaScript3
$javaScript4

	<title>Printer Options</title>

</head>
<body>
$infoTemplate

<div id="userHeader">
Printer Options
</div>

<div id="conf">   
$confirmation
</div>

<div id="userForm1">
<form id="form1" name="form1" method="post" action="printerOptions.php" >
<table border="0" align="center">
<tr>
<td  class="grey">
<u>Choose Print Format</u><a href="javascript: void" id="pos4" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos4', 4 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>
</td>
</tr>
<tr>
<td>
<select name="receipt_format" id="receipt_format" class="pullConf"/>
<option value="R" $receiptSelected>Receipt Format</option>
<option value="L" $letterSelected>Letter Format</option>
</select> 
</td>
</tr>
<tr>
<td class="padTopTwo">
<input type="submit" name="create" id="create" value="Save Print Format"/>
<input type="hidden" name="marker" value="1"/>
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
PRINTEROPTIONSTEMPLATE;


echo"$printerOptionsTemplate";
?>