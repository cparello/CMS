<?php
$searchTemplate = <<<SEARCHTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/pop_hint.css">
<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/search_services.css">
$javaScript1
$javaScript2
$javaScript3


	<title>Search Edit Accounts</title>

</head>
<body>

$infoTemplate

<div id="userHeader">
Search Deleted Notes
</div>

<div id="idContent1">   
&nbsp;
</div>

<div id="userForm1">
<table border="0" align="center">
<tr>
<td  class="grey">
<u>Search by Contract Key</u>
</td>
</tr>
<tr>
<td>
<input  name="search_invoice" type="text" id="search_key" size="25" maxlength="30"/><a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos1', 1);" /><img src="../images/question-mark.png" class="alignMiddle"></a>

</td>
</tr>
<tr>
<td>
<input type="button" name="contract_key"  id="contract_key" value="Search by Contract Key" onClick="return searchMembers(this.id);"/>
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
SEARCHTEMPLATE;


echo"$searchTemplate";
?>