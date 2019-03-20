<?php
/*
<div id="innerTwo">
<span class="grey">
<u>Declined/Rejected Transactions</u><a href="javascript: void" id="pos2" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos2', 2);" /><img src="../images/question-mark.png" class="alignMiddle"></a>
</span>
</div>

<div id="decRej">
<table align="center">
<tr>
<th align="center" class="black pTop">Phone List</th>
<th align="center" class="black pTop">Email</th>
<th align="center" class="black pTop">Mail</th>
</tr>
<tr>
<td align="center" class="black"><input type="radio" name="dr" id="dr1" value="phone" checked></td>
<td align="center" class="black"><input type="radio" name="dr" id="dr2" value="email"></td>
<td align="center" class="black"><input type="radio" name="dr" id="dr3" value="mail"></td>
</tr>
<tr>
<td align="center" class="black butPos" colspan="3">
<input type="button" name="declined"  id="declined" class="button1" value="Process Declined/Rejected"/>
</td>
</tr>
</table>
</div>
*/

$year1 = date("Y"  ,mktime(0, 0, 0, date("m"), 1, date("Y")-6));
$year2 = date("Y"  ,mktime(0, 0, 0, date("m"), 1, date("Y")-5));
$year3 = date("Y"  ,mktime(0, 0, 0, date("m"), 1, date("Y")-4));
$year4 = date("Y"  ,mktime(0, 0, 0, date("m"), 1, date("Y")-3));
$year5 = date("Y"  ,mktime(0, 0, 0, date("m"), 1, date("Y")-2));
$year6 = date("Y"  ,mktime(0, 0, 0, date("m"), 1, date("Y")-1));
$year7 = date("Y"  ,mktime(0, 0, 0, date("m"), 1, date("Y")));


$collectionsTemplate = <<<COLLECTIONS
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/pop_hint.css">
<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/accountsCollectible.css">
$javaScript1
$javaScript2
$javaScript3
$javaScript4
$javaScript5


<title>Accounts Collectible</title>

</head>
<body>
$infoTemplate

<div id="userHeader">
Accounts Collectible 
</div>


<div id="innerOne">
<span class="grey">
<u>Past Due Accounts</u><a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos1', 1);" /><img src="../images/question-mark.png" class="alignMiddle"></a>
</span>
</div>


<div id="pastDue">
<table align="center">
<tr>
<th align="center" class="black pTop">Phone List</th>
<th align="center" class="black pTop">Email</th>
<th align="center" class="black pTop">Mail</th>
</tr>
<tr>
<td align="center" class="black"><input type="radio" name="pd" id="pd1" value="phone" checked></td>
<td align="center" class="black"><input type="radio" name="pd" id="pd2" value="email"></td>
<td align="center" class="black"><input type="radio" name="pd" id="pd3" value="mail"></td>
</tr>
<tr>
<td align="center" class="black butPos" colspan="3">
<select name="past_month" id="past_month">
<option value="1">January</option>
<option value="2">February</option>
<option value="3">March</option>
<option value="4">April</option>
<option value="5">May</option>
<option value="6">June</option>
<option value="7">July</option>
<option value="8">August</option>
<option value="9">September</option>
<option value="10">October</option>
<option value="11">November</option>
<option value="12">December</option>
</select>
<select name="past_year" id="past_year">
<option value="$year1">$year1</option>
<option value="$year2">$year2</option>
<option value="$year3">$year3</option>
<option value="$year4">$year4</option>
<option value="$year5">$year5</option>
<option value="$year6">$year6</option>
<option value="$year7">$year7</option>
</select>
</td>
</tr>
<tr>
<td align="center" class="black butPos" colspan="3">
<input type="button" name="past"  id="past" class="button1" value="Process Past Due"/>
</td>
</tr>
<tr>
<td align="center" class="black butPos" colspan="3">
<input type="button" name="reset"  id="reset" class="button1" value="Reset Invoice"/><a href="javascript: void" id="pos4" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos4', 4);" /><img src="../images/question-mark.png" class="alignMiddle"></a>
</td>
</tr>
</table>
</div>





<div id="innerThree">
<span class="grey">
<u>Monthly Invoiced Accounts</u><a href="javascript: void" id="pos3" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos3', 3);" /><img src="../images/question-mark.png" class="alignMiddle"></a>
</span>
</div>


<div id="monInv">
<table align="center">
<tr>
<th align="center" class="black pTop">Phone List</th>
<th align="center" class="black pTop">Email</th>
<th align="center" class="black pTop">Mail</th>
</tr>
<tr>
<td align="center" class="black"><input type="radio" name="mi" id="mi1" value="phone" checked></td>
<td align="center" class="black"><input type="radio" name="mi" id="mi2" value="email"></td>
<td align="center" class="black"><input type="radio" name="mi" id="mi3" value="mail"></td>
</tr>
<tr>
<td align="center" class="black butPos" colspan="3">
<input type="button" name="monthly"  id="monthly" class="button1" value="Process Monthly Invoiced"/>
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
COLLECTIONS;


echo"$collectionsTemplate";
?>