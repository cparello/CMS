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
<script type="text/javascript" src="../scripts/openReport.js"></script>
<title>$page_title</title>

</head>
<body>

$infoTemplate

<div id="userHeader">Reports</div>
<tr>
<p class=\"bbackheader\"><Center><H3><strong>Recursive Billing Response Reports</strong></Center></H3></p>
<td align="top" width="100">
<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Select Date:</strong> 
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
<option value="bad">Bad Cards</option>
<option value="reason">CC Reason Code Report</option>
<option value="missing">Missing Credit Cards</option>
<option value="owed">Outstanding Balances</option>
</select>
</td>
<td align="left">
<input type="button" id="pop_window1" name="pop_window" value="View" onClick="openContract(this.id);"/>
</td>
</tr>
<p class=\"bbackheader\"><Center><H3><strong>Sales/EFT Reports</strong></Center></H3></p>
<td align="top" width="100">
<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Select Date:</strong> 
</td>
<td>
<select name="cexp_date2" id="cexp_date2">
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
<select  name="year2" id="year2"/>
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
<select  name="report2" id="report2"/>
<option value="">Report Name</option>
<option value="batch">Batch Report</option>
<option value="dashboard">Dashboard</option>
<option value="sales">Daily Sales Report</option>
</select>
</td>
<td align="left">
<input type="button" id="pop_window2" name="pop_window" value="View" onClick="openContract(this.id);"/>
</td>
</tr>

<tr>
<td id="idContent1" colspan="2">   
</td>              
</tr>
</table>
</div>

<p class=\"bbackheader\"><Center><H3><strong>Monhtly Billing Preview</strong></Center></H3></p>
<td align="top" width="100">
<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Select Date:</strong> 
</td>
<td>
<select name="cexp_date3" id="cexp_date3">
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
<select  name="year3" id="year3"/>
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
<select  name="report3" id="report3"/>
<option value="">Report Name</option>
<option value="preview">Monthly Billing Preview</option>
</select>
</td>
<td align="left">
<input type="button" id="pop_window3" name="pop_window3" value="View" onClick="openContract(this.id);"/>
</td>
</tr>

<tr>
<td id="idContent1" colspan="2">   
</td>              
</tr>
</table>
</div>

<p class=\"bbackheader\"><Center><H3><strong>Collections Report</strong></Center></H3></p>
<td align="top" width="100">
<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Select Report:</strong> 
</td>
<td>
<select name="collect_month" id="collect_month">
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
<select  name="collect_year" id="collect_year"/>
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
<td align="left">
<input type="button" id="pop_window4" name="pop_window4" value="View" onClick="openContract(this.id);"/>
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


