<?php
$activeInactiveReportsTemplate = <<<AIREPORTSTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/renewReports.css">
<link rel="stylesheet" href="../css/pop_hint2.css">
<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/base/jquery.ui.all.css">
<link rel="stylesheet" href="../css/demos.css">

$javaScript1
$javaScript2
$javaScript3
$javaScript4
$javaScript5
$javaScript6
$javaScript7
$javaScript8
$javaScript9
$javaScript10
$javaScript11
$javaScript12
$javaScript13
$javaScript14
$javaScript15
$javaScript16



<title>$page_title</title>

</head>
<body>

$infoTemplate

<div id="userHeader">
$page_title  
</div>

<div id="savedDrop">
<img style="vertical-align:middle" src="../images/star.png"border="0"\> <span class="black">My Saved Active Inactive Reports</span>
&nbsp;
<select  name="savedDropSales" id="savedDropSales" class="black3"/>
<option value>Select Active Inactive Report</option>
$report_drops
</select>
</div>

<div class="reportSection" id="sectionOne">
<p class="header2">New Report Query<span class="plus">-</span></p>
<div class="sectionContent">
<table align="left" cellpadding="2" border="0"> 
<tr>
<td class="lPad cSpace2">
<span class="black">1. Category Type</span>
&nbsp;
<select name="category_type" id="category_type" class="black3"/>
<option value>Select Category</option>
<option value="AA">Active Accounts</option>
<option value="IA">Inactive Accounts</option>
<option value="AC">Attrition Comparison</option>
</select>
</td> 
<td class="cSpace">
<span class="black">2. Club Location</span>
&nbsp;
<select name="service_location" id="service_location" class="black3"/>
$location_drop
</select>
</td> 
</tr>

<tr>
<td class="lPad cSpace tPad">
</td> 
<td class="cSpace tPad">
</td> 
<td class="cSpace tPad">
</td> 
</tr>

<tr>
<td colspan="3" class="lPad cSpace tPad">
<span class="black">3. Date Range </span>
&nbsp;
<select name="date_range" id="date_range" class="black3"/>
<option value>Select Range</option>
<option value="CY">Current Year</option>
<option value="AY">All Years</option>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input  type="button" class="button1" id="button1" name="run" value="Run Report"/>
</td> 
</tr>
</table>
</div>
</div>

<div class="reportSection" id="sectionTwo">
&nbsp;
<p class="header2">Graphs <span class="plus">-</span></p>
<div class="sectionContent" id="twoContent">
<div id="secButtons">
<input  type="image" src="../images/save-off.png" id="saveBut" />
<input  type="image" src="../images/print-off.png" id="printBut" />
<input  type="image" src="../images/print-list-off.png" id="printListBut" />
&nbsp;&nbsp;
<input  type="image" src="../images/bar-off.png" id="barBut" />
<input  type="image" src="../images/line-off.png" id="lineBut" />
</span>
&nbsp;&nbsp;
</div>
<div id="chart_one"></div>
<div id="chart_two"></div>
<div id="chart_three"></div>
<div id="chart_four"></div>

<div class="chartSave"  id="chartSave">
<img class="menu_exit"   id="menu_exit" src="../images/popx.png" alt="" />
<div id="saveForm">
<table cellpadding="2" border="0">
<tr>
<td>
Report Name  
</td>
<td>
<input type="text" id="report_name" name="report_name" size="30" maxlength="80"/>
</td>
</tr>
<tr>
<td>
&nbsp;
</td>
<td class="tPad" align="right">
<input  type="button" class="button1" id="button2" name="save" value="Save Report"/>
</td>
</tr>
</table>
</div>
</div>

</div>
</div>


<div class="reportSection" id="sectionThree">
<p class="header2">Summary<span class="plus">-</span></p>
<div class="sectionContent">
<table id="projTable" align="left" cellpadding="2" cellspacing="0" border="0" width="100%"> 
<tr>
<td class="projHeader pSpace1">
&nbsp;
</td>
<td class="projHeader pSpace2" id="pHeader1">
&nbsp;
</td>
<td class="projHeader pSpace4" id="pHeader2">
&nbsp;
</td>
<td class="projHeader" id="pHeader3">
&nbsp;
</td>
</tr>
</table>
</div>
</div>




<div class="popHint"   id="popup" style="display: none;">
<div class="menu_form_header" id="popup_drag">
<img class="menu_form_exit"   id="popup_exit" src="../images/popx.png" alt="" />
<span id= "contHint">
</span>
</div>
</div>

<input type="hidden" id="attempt_bit" value=""/>
<input type="hidden" id="bar_charts" value=""/>
<input type="hidden" id="line_charts" value=""/>
<input type="hidden" id="bar_print" value=""/>
<input type="hidden" id="line_print" value=""/>
<input type="hidden" id="switch_bit" value="1"/>
<input type="hidden" id="summary_rows" value=""/>
<input type="hidden" id="report_type" value="$report_type"/>

</body>
</html>
AIREPORTSTEMPLATE;


echo"$activeInactiveReportsTemplate";

?>


