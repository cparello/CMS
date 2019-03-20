<?php
$salesReportsTemplate = <<<SALESREPORTSTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/createReports.css">
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

<script>

$(function() {
      $.datepicker.setDefaults({changeMonth: true, numberOfMonths: 1});
            
      $('#from').datepicker({onSelect: function() {
            var date = $(this).datepicker('getDate');
            if (date) {
                  date.setDate(date.getDate() + 1);
            }
            $('#to').datepicker('option', 'minDate', date);
      }});
      $('#to').datepicker({onSelect: function() {
            var date = $(this).datepicker('getDate');
            if (date) {
                  date.setDate(date.getDate() - 1);
            }
            $('#from').datepicker('option', 'maxDate', date);
      }});
});
</script>

<title>$page_title</title>

</head>
<body>

$infoTemplate

<div id="userHeader">
$page_title  
</div>

<div id="savedDrop">
<img style="vertical-align:middle" src="../images/star.png"border="0"\> <span class="black">My Saved Sales Reports</span>
&nbsp;
<select  name="savedDropSales" id="savedDropSales" class="black3"/>
<option value>Select Sales Report</option>
$report_drops
</select>
</div>

<div class="reportSection" id="sectionOne">
<p class="header2">New Report Query<span class="plus">-</span></p>
<div class="sectionContent">
<table align="left" cellpadding="2" border="0"> 
<tr>
<td class="lPad cSpace">
<span class="black">1. Club Location</span>
&nbsp;
<select name="service_location" id="service_location" class="black3"/>
$location_drop
</select>
</td> 
<td class="cSpace">
<span class="black">2. Group Type</span>
&nbsp;
<select name="group_type" id="group_type" class="black3"/>
<option value>Select Group Type</option>
</select>
</td> 
<td class="cSpace">
<span class="black">3. Service Type</span>
&nbsp;
<select name="service_type" id="service_type" class="black3"/>
<option value>Select Service Type</option>
</select>
</td> 
</tr>
<tr>
<td class="lPad cSpace tPad">
<span class="black">4. Service Options</span>
&nbsp;
<select name="service_type_options" id="service_type_options" class="black3"/>
<option value>Select Service Options</option>
</select>
</td> 
<td class="cSpace tPad">
<span class="black">5. Sales Type</span>
&nbsp;
<select name="sales_type" id="sales_type" class="black3" />
<option value>Select Sales Type</option>
</select>
</td> 
<td class="cSpace tPad">
<span class="black">6. Sales Name</span>
&nbsp;
<select name="sales_name" id="sales_name" class="black3"/>
<option value>Select Sales Name</option>
</select>
</td> 
</tr>
<tr>
<td colspan="3" class="lPad cSpace tPad">
<span class="black">7. Date Range (Optional)</span>
&nbsp;
<input type="text" id="from" name="from" size="10"/>
&nbsp;
<span class="black">To</span>
&nbsp;
<input type="text" id="to" name="to" size="10"/><a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos1', 1);" /><img src="../images/question-mark.png" class="alignMiddle"></a> 
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
Period
</td>
<td class="projHeader pSpace2">
Total Transactions
</td>
<td class="projHeader pSpace4">
Gross Sales
</td>
<td class="projHeader">
Gross Projected
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

<input type="hidden" id="bar_charts" value=""/>
<input type="hidden" id="line_charts" value=""/>
<input type="hidden" id="bar_print" value=""/>
<input type="hidden" id="line_print" value=""/>
<input type="hidden" id="switch_bit" value="1"/>
<input type="hidden" id="summary_rows" value=""/>
<input type="hidden" id="report_type" value="$report_type"/>

</body>
</html>
SALESREPORTSTEMPLATE;


echo"$salesReportsTemplate";

?>


