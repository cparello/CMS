<?php
$resultTemplate = <<<RESULTTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/payrollClubResults.css">

$javaScript1
$javaScript2
$javaScript3

<title>Process Club Payroll</title>

</head>
<body>



<div id="headerFunctions">
<form name="form1" action="saveClubPayroll.php" method="post" onSubmit="return checkData()" >
<table>
<tr>
<td class="padL" rowspan="2">
<input type="submit" name="save" id="save" value="Process $cycleDescription Payroll" class="button1" onClick="return checkHours();"/>
</td>
<td class="padL" rowspan="2">
<input type="button" name="print" value="Print Record" class="button2" onClick="printRecords();"/>
</td>
<td valign="top">
<input type="checkbox" name="book_keeping" value="1"><span class="black1">&nbsp;Export to Quickbooks&#0153;</span>
</td>
</tr>
<tr>
<td valign="top">
<input type="checkbox" name="consol" value="1"><span class="black1">&nbsp;Consolidate Payroll</span>
</td>
</tr>
</table>
</div>


<div id="employeeList">
$tableHeader 
$recordList

<input type="hidden" id="club_id" name="club_id" value="$club_location" />
<input type="hidden" id="date_start" name="date_start" value="$dateStart" />
<input type="hidden" id="date_end" name="date_end" value="$dateEnd" />
</div>
</form>

</body>
</html>
RESULTTEMPLATE;


echo"$resultTemplate";
?>