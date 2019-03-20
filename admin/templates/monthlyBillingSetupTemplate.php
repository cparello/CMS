<?php
$idTemplate = <<<IDTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/pins.css">
<link rel="stylesheet" href="../css/pop_hint.css">
<link rel="stylesheet" href="../css/info.css">
<title></title>

</head>
<body>

$infoTemplate

<div id="userHeader">
Edit Monthly Billing Initial Payment Opitons
</div>



<div id="userForm">

<table border="0" align="center">
<tr>
<td colspan="2" class="grey">
<u>Billing Options</u>
</td>
</tr>

<tr>
<td class="black">
<form id="form1" name="form1" method="post" action="$submit_link" onSubmit="return checkData()">
Setup Mode:
</td>
<td class="black">
<select  name="billing_setup" id="billing_setup" />
<option value="$current_setup" selected>$text</option>    
<option value="1">Initially Process (Prorate + Proccessing Fee)</option>
<option value="2">Initially Process (First Month + Prorate + Proccessing Fee)</option>
<option value="3">Initially Process (First Month + Proccessing Fee)</option>
<option value="4">Initially Process (First Month + Last Month)</option>
<option value="5">Initially Process (Prorate)</option>
</select>
<td>
</tr>

<tr>
<td>
&nbsp;
</td>
<td>
<input type="submit" name="edit_id" value="Submit Selection" />
<input type="hidden" name="marker" value="1" />
</form>
</td>
</tr>







</table>

</div>

  
</body>
</html>
IDTEMPLATE;


echo"$idTemplate";

?>


