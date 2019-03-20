<?php
$processExpiredEnrollTemplate = <<<PROCESSEXPIRED
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/pop_hint.css">
<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/accountsRenewable.css">
$javaScript1
$javaScript2
$javaScript3
$javaScript4
$javaScript5


<title>Process Expired Re-enrollment</title>

</head>
<body>
$infoTemplate

<div id="userHeader">
Process Expired/ Re-enrollment Accounts
</div>


<div id="innerOne">
<span class="grey">
<u>Expired/ Re-enrollment Accounts</u><a href="javascript: void" id="pos9" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos9', 9);" /><img src="../images/question-mark.png" class="alignMiddle"></a>
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
<td align="center" class="black"><input type="radio" name="er" id="er1" value="phone" checked></td>
<td align="center" class="black"><input type="radio" name="er" id="er2" value="email"></td>
<td align="center" class="black"><input type="radio" name="er" id="er3" value="mail"></td>
</tr>

<tr>
<td align="right" class="black top2">
Select Date Range
</td>
<td align="center" class="black top2" colspan="2">
<select  name="er_range" id="er_range"/>
<option value="30" selected>30 Days</option>
<option value="60">60 Days</option>
<option value="90">90 Days</option>
</select>
</td>
</tr>

<tr>
<td align="center" class="black butPos" colspan="3">
<input type="button" name="per"  id="per" class="button1" value="Process Expired Re-enrollments"/>
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
PROCESSEXPIRED;


echo"$processExpiredEnrollTemplate";
?>