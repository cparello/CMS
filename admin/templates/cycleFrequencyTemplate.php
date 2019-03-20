<?php

$firstYearName = date("Y");
$firstYearValue = date("y");
$secondYearName = date("Y")-1;
$secondYearValue = date("y")-1;
$thirdYearName = date("Y")-2;
$thirdYearValue = date("y")-2;
$fourthYearName = date("Y")-3;
$fourthYearValue = date("y")-3;
$fifthYearName = date("Y")-4;
$fifthYearValue = date("y")-4;
$sixthYearName = date("Y")-5;
$sixthYearValue = date("y")-5;
$seventhYearName = date("Y")-6;
$seventhYearValue = date("y")-6;

$cycleFrequencyTemplate = <<<CYCLEFREQUENCYTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/fees.css">
<link rel="stylesheet" href="../css/pop_hint.css">
<link rel="stylesheet" href="../css/info.css">
$javaScript1
$javaScript2
$javaScript3
<title>$page_title</title>

</head>
<body>

$infoTemplate

<p class=\"bbackheader\"><Center><H3><strong>Reports</strong></Center></H3></p>
<tr>
<td align="top" width="100">
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<strong>Select Date:</strong> 
</td>
<td>
<select name="cexp_date1" id="cexp_date1">
<option value="01">January</option>
<option value="02">February</option>
<option value="03">March</option>
<option value="04">April</option>
<option value="05">May</option>
<option value="06">June</option>
<option value="07">July</option>
<option value="08">August</option>
<option value="09">September</option>
<option value="10">October</option>
<option value="11">November</option>
<option value="12">December</option>
</select> 
</td>

<td>
<select  name="year" id="year"/>
<option value="">Year</option>
<option value="$firstYearValue">$firstYearName</option>
<option value="$secondYearValue">$secondYearName</option>
<option value="$thirdYearValue">$thirdYearName</option>
<option value="$fourthYearValue">$fourthYearName</option>
<option value="$fifthYearValue">$fifthYearName</option>
<option value="$sixthYearValue">$sixthYearName</option>
<option value="$seventhYearValue">$seventhYearName</option>
</select>
</td>
<td>
<select  name="report" id="report"/>
<option value="">Report Name</option>
<option value="batch">Batch Report</option>
<option value="bad">Bad Cards</option>
<option value="accepted">Accepted Cards</option>
<option value="good">Good Cards</option>
<option value="approval">Cards Needing Approval</option>
<option value="dashboard">Dashboard</option>
<option value="sales">Daily Sales Report</option>
</select>
</td>
<td align="left">
<input type="button" id="pop_window" name="pop_window" value="Load Attendance" onClick="openContract();"/>
</td>
</tr>


<tr>
<td id="idContent1" colspan="2">   
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
CYCLEFREQUENCYTEMPLATE;


echo"$cycleFrequencyTemplate";

?>


