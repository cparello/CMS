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
<link rel="stylesheet" href="../css/base/jquery.ui.all.css">
<script type="text/javascript" src="../scripts/jqueryNew.js"></script>
<script type="text/javascript" src="../scripts/jquery.ui.core.js"></script>
<script type="text/javascript" src="../scripts/jquery.ui.widget.js"></script>
<script type="text/javascript" src="../scripts/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../scripts/jquery.tablesorter.js"></script>
<script type="text/javascript" src="../scripts/jquery.tablesorter.scroller.js"></script>
$javaScript1
$javaScript2
$javaScript3


	<title>Search Edit Accounts</title>
<script>
$(function() {
$( "#datepicker1" ).datepicker();
});
</script>
<script>
$(function() {
$( "#datepicker2" ).datepicker();
});
</script>
<script>
$(function() {
$( "#datepicker3" ).datepicker();
});
</script>
</head>
<body>

$infoTemplate

<div id="userHeader">
Search Point of Sale History  
</div>

<div id="idContent1">   
&nbsp;
</div>

<div id="userForm1">
<table border="0" align="center">
<tr>
<td  class="grey">
<u>Search by Invoice</u>
</td>
</tr>
<tr>
<td>
<input  name="search_invoice" type="text" id="search_invoice" size="25" maxlength="30"/><a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos1', 1);" /><img src="../images/question-mark.png" class="alignMiddle"></a>

</td>
</tr>
<tr>
<td>
<input type="button" name="invoice"  id="invoice" value="Search by Invoice Number" onClick="return searchMembers(this.id);"/>
</td>
</tr>
</table>
</div>

<div id="userForm2">
<table border="0" align="center">
<tr>
<td  class="grey">
<u>Search by Transaction Date</u>
</td>
</tr>
<tr>
<td>
<input type="text" id="datepicker1" name="datepicker1" size="10" value="" /><a href="javascript: void" id="pos2" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos2', 2);" /><img src="../images/question-mark.png" class="alignMiddle"></a>
</td>
</tr>
<tr>
<td>
<input type="button" name="date"  id="date" value="Search by Date"  onClick="return searchMembers(this.id);"/>
</td>
</tr>
</table>
</div>

<div id="userForm3">
<table border="0" align="center">
<tr>
<td  class="grey">
<u>Search by Barcode</u>
</td>
</tr>
<tr>
<td>
<input  name="search_barcode" type="text" id="search_barcode" size="25" maxlength="30"/><a href="javascript: void" id="pos3" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos3', 3);" /><img src="../images/question-mark.png" class="alignMiddle"></a>
</td>
</tr>
<tr>
<td>
<input type="button" name="barcode"  id="barcode" value="Search by Barcode" onClick="return searchMembers(this.id);"/>
</td>
</tr>
</table>
</div>

<div id="userForm4">
<table border="0" align="center">
<tr>
<td  class="grey">
<u>Search by Category</u>
</td>
</tr>
<tr>
<td>
<input  name="search_cat" type="text" id="search_cat" size="25" maxlength="30"/><a href="javascript: void" id="pos4" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos4', 4);" /><img src="../images/question-mark.png" class="alignMiddle"></a>
</td>
</tr>
<tr>
<td>
<input type="button" name="cat"  id="cat" value="Search by Category" onClick="return searchMembers(this.id);"/>
</td>
</tr>
</table>
</div>

<br>
<br>
<br>
<br>
<br>
<br>
<div id="userForm5">
<table border="0" align="center">
<tr>
<td  class="grey">
<u>Search by Date Range</u>
</td>
</tr>
<tr>
<td>
<input type="text" id="datepicker2" name="datepicker2" size="10" value="" /><input type="text" id="datepicker3" name="datepicker3" size="10" value="" /><a href="javascript: void" id="pos5" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos5', 5);" /><img src="../images/question-mark.png" class="alignMiddle"></a>
</td>
</tr>
<tr>
<td>
<input type="button" name="range"  id="range" value="Search by Date Range" onClick="return searchMembers(this.id);"/>
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