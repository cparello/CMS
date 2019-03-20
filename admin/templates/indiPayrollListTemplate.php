<?php
$indiPayrollListTemplate = <<<INDIPAYROLLLIST
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>

<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/service_lists.css">
$javaScript1
<title>View Employee Payroll</title>
</head>
<body>

$infoTemplate

<div id="userHeader">
View Individual Employee Payroll  
</div>

<div id="conf" class="conf">
$confirmation &nbsp;
</div>

<div id="userForm1">
<form name="form1" action="indiPayrollResults.php" method="post" onSubmit="return checkData()" >
$result1 

<tr>
<td align="left" id="edPos" colspan="9">
<input  type="submit" name="edit" value="Edit Selected Records"/>
</td>
</tr>
<tr>
<td colspan="9">
&nbsp;
</td>
</tr>

</form>
</table>
</div>


</body>
</html>
INDIPAYROLLLIST;

echo"$indiPayrollListTemplate";

?>