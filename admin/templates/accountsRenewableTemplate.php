<?php



$renewablesTemplate = <<<RENEWABLES
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/pop_hint.css">
<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/accountsRenewable.css">
<link rel="stylesheet" href="../css/base/jquery.ui.all.css">
$javaScript1
$javaScript2
$javaScript3
$javaScript4
<script type="text/javascript" src="../scripts/jquery.ui.core.js"></script>
<script type="text/javascript" src="../scripts/jquery.ui.widget.js"></script>
<script type="text/javascript" src="../scripts/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../scripts/jquery.tablesorter.js"></script>
<script type="text/javascript" src="../scripts/jquery.tablesorter.scroller.js"></script>


<title>Accounts Renewable</title>
<script>
$(function() {
$( "#datepicker" ).datepicker();
});
</script>
</head>
<body>
$infoTemplate

<div id="userHeader">
Accounts Renewable 
</div>

<div id="userHeader2">
Invoice good until date<a href="javascript: void" id="pos4" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos4', 4);" /><img src="../images/question-mark.png" class="alignMiddle"></a><br><br>
<input id="datepicker" size="10" value="$defaultDate" type="text">
</div>

<div id="innerOne">
<span class="grey">
<u>Early Renewable Accounts</u><a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos1', 1);" /><img src="../images/question-mark.png" class="alignMiddle"></a>
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
Select Start Date
</td>
<td align="center" class="black top2" colspan="2">
<select  name="early_date" id="early_date"/>
$options
</select>
</td>
</tr>


<tr>
<td align="right" class="black top2">
Select Club
</td>
<td align="center" class="black top2" colspan="2">
<select tabindex= "1" name="locationEarly" id="locationEarly">
<option value="" selected>Please Select</option>  
$clubDrop
</select>
</td>
</tr>


<tr>
<td align="center" class="black butPos" colspan="3">
<input type="button" name="early"  id="early" class="button1" value="Processs Early Renewables"/>
</td>
</tr>
</table>
</div>


<div id="innerTwo">
<span class="grey">
<u>Grace Period Renewable Accounts</u><a href="javascript: void" id="pos2" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos2', 2);" /><img src="../images/question-mark.png" class="alignMiddle"></a>
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
<td align="center" class="black"><input type="radio" name="gp" id="gp1" value="phone" checked></td>
<td align="center" class="black"><input type="radio" name="gp" id="gp2" value="email"></td>
<td align="center" class="black"><input type="radio" name="gp" id="gp3" value="mail"></td>
</tr>

<tr>
<td align="right" class="black top2">
Select End Date
</td>
<td align="center" class="black top2" colspan="2">
<select  name="grace_date" id="grace_date"/>
$options2
</select>
</td>
</tr>

<tr>
<td align="right" class="black top2">
Select Club
</td>
<td align="center" class="black top2" colspan="2">
<select tabindex= "1" name="locationGrace" id="locationGrace">
<option value="" selected>Please Select</option>  
$clubDrop
</select>
</td>
</tr>

<tr>
<td align="center" class="black butPos" colspan="3">
<input type="button" name="grace"  id="grace" class="button1" value="Process Grace Period Renewables"/>
</td>
</tr>
</table>
</div>


<div id="innerThree">
<span class="grey">
<u>Standard Renewable Accounts</u><a href="javascript: void" id="pos3" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos3', 3);" /><img src="../images/question-mark.png" class="alignMiddle"></a>
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
<td align="center" class="black"><input type="radio" name="sr" id="sr1" value="phone" checked></td>
<td align="center" class="black"><input type="radio" name="sr" id="sr2" value="email"></td>
<td align="center" class="black"><input type="radio" name="sr" id="sr3" value="mail"></td>
</tr>

<tr>
<td align="right" class="black top2">
Select Start Date
</td>
<td align="center" class="black top2" colspan="2">
<select  name="standard_date" id="standard_date"/>
$options3
</select>
</td>
</tr>

<tr>
<td align="right" class="black top2">
Select Club
</td>
<td align="center" class="black top2" colspan="2">
<select tabindex= "1" name="locationStandard" id="locationStandard">
<option value="" selected>Please Select</option>  
$clubDrop
</select>
</td>
</tr>

<tr>
<td align="center" class="black butPos" colspan="3">
<input type="button" name="standard"  id="standard" class="button1" value="Process Standard Renewables"/>
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
RENEWABLES;


echo"$renewablesTemplate";
?>