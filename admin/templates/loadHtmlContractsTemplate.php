<?php
$loadQwcTemplate = <<<LOADQWCTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/loadQwc.css">
<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/pop_hint.css">
$javaScript1
$javaScript2
$javaScript3
$javaScript4

	<title>Download Contract Templates</title>

</head>
<body>
$infoTemplate

<div id="userHeader">
Create PIF and Monthly EFT Contract Files
</div>

<div id="idContent1">   
&nbsp;
</div>



<div id="userForm2">
<table border="0" align="center">
<tr>
<td>
<h3> PIF Contracts </h3>
</td>
</tr>
<tr>
<td>
<input type="button" name="create2" id="create2" value="Create PIF Contract"/>
</td>
</tr>
<tr>
<td  class="grey">
<u>Download EFT Contract</u><a href="javascript: void" id="pos2" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos2', 2 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>
</td>
</tr>
<tr>
<td>
<input type="button" name="download2" id="download2" value="Download PIF File"/>
</form>
</td>
</tr>
</table>
</div>






<div id="userForm3">
<table border="0" align="center">
<tr>
<td>
<h3> EFT Contracts </h3>
</td>
</tr>
<tr>
<td>
<input type="button" name="create1" id="create1" value="Create EFT Contract"/>
</td>
</tr>
<tr>
<td  class="grey">
<u>Download PIF Contract</u><a href="javascript: void" id="pos2" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos2', 2 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>
</td>
</tr>
<tr>
<td>
<input type="button" name="download1" id="download1" value="Download EFT File"/>
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
LOADQWCTEMPLATE;


echo"$loadQwcTemplate";
?>