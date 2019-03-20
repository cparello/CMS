<?php
$indiPayrollResults = <<<INDIPAYROLLRESULTS
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>

<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/indiPayrollResults.css">
$javaScript1
$javaScript2
$javaScript3 
$javaScript4
$javaScript5
<title>Individual Payroll Results</title>
</head>
<body onLoad = "setPreAddSubs();">

$infoTemplate

<div id="userHeader">
Payroll Results(s) for $employee_name  
</div>

<div id="conf" class="conf">
$confirmation &nbsp;
<form name="form1" action="saveIndiPayroll.php" method="post" onSubmit="return checkFields();">
</div>

$indiPayrollRecords

<div id="adjustmentBar">
<span class="cent">Total Amount</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input readonly class="cent2" id="total" name="total" value="$total_amount">
</div>

<div id="primeFunc">
<table>
<tr>
<td class="padL" rowspan="2">
<input type="submit" name="process" id="process" value="Process Payroll" class="button1" onClick="return checkHours();"/>
&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="add_sub" id="add_sub" value="Save Deductions and Additions" class="button2" onClick="return  saveAddSub();"/>
</td>
<td class="padL" rowspan="2">
<input type="button" name="print" value="Print" class="button3" onClick="return printIndiPayroll();"/>
</td>
<td valign="top">
<input type="checkbox" name="book_keeping" value="1"><span class="black1">&nbsp;Export to Quickbooks&#0153;</span>
</td>
</tr>
<tr>
<td>
$consolidate_checkbox
<input name="totalMarker" type="hidden" id="totalMarker" value="$total_amount"/>
<input name="commission_total_array" type="hidden" id="commission_total_array" value="$commission_total_array"/>
<input name="salary_wage_array" type="hidden" id="salary_wage_array" value="$salary_wage_array"/>
<input name="hourly_wages_array" type="hidden" id="hourly_wages_array" value="$hourly_wages_array"/>
<input name="hours_projected_array" type="hidden" id="hours_projected_array" value="$hours_projected_array"/>
<input name="total_hours_array" type="hidden" id="total_hours_array" value="$total_hours_array"/>
<input name="ot_array" type="hidden" id="ot_array" value="$ot_array"/>
<input name="ot_doubtime_array" type="hidden" id="ot_doubtime_array" value="$ot_doubtime_array"/>
<input name="baseProrateAmount_array" type="hidden" id="baseProrateAmount_array" value="$baseProrateAmount_array"/>
<input name="sub_total_array" type="hidden" id="sub_total_array" value="$sub_total_array"/>
<input name="user_id" type="hidden" id="user_id" value="$user_id"/>
<input name="type_key_array" type="hidden" id="type_key_array" value="$type_key_array"/>
<input name="employee_name" type="hidden" id="employee_name" value="$employee_name"/>
<input name="add_deduct_array" type="hidden" id="add_deduct_array" value=""/>
<input name="save_add_sub" type="hidden" id="save_add_sub" value=""/>
<input name="payment_cycle_array" type="hidden" id="payment_cycle_array" value="$payment_cycle_array"/>
<input name="compensation_type_array" type="hidden" id="compensation_type_array" value="$compensation_type_array"/>
<input name="id_card_array" type="hidden" id="id_card_array" value="$id_card_array"/>
<input name="club_id_array" type="hidden" id="club_id_array" value="$club_id_array"/>
<input name="hours_list" type="hidden" id="hours_list" value="$hours_list2"/>
<input name="pt_html" type="hidden" id="pt_html" value="$pt_html"/>
<input name="pt_html_ta" type="hidden" id="pt_html_ta" value="$pt_html_ta"/>
<input name="commission_returns" type="hidden" id="commission_returns" value="$commission_returns"/>
<input name="sales_html" type="hidden" id="sales_html" value="$sales_html"/>

</form>
</td>
</tr>
</table>
</div>

</body>
</html>
INDIPAYROLLRESULTS;

echo"$indiPayrollResults";

?>