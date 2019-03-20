<?php


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
<script type="text/javascript" src="../scripts/runManualBilling.js"></script>
<title>$page_title</title>

</head>
<body>

$infoTemplate

<tr>
<p class=\"bbackheader\"><Center><H3><strong>Manual Billing</strong></Center></H3></p>
<p class=\"bbackheader\"><Center><H5><strong>This will process the monthly transaction batch for all of your clubs. The billing process is automated, howeveor this can be used as a fail safe in case of automation errors.</strong></Center></H5></p>
<td align="left">
<center><input type="button" id="monthly_billing" name="monthly_billing" value="Run Manual Billing" onClick="openContract(this.id);"/></center>
</td>
</tr>
<br>
<br>
<br>
<tr>
<p class=\"bbackheader\"><Center><H3><strong>Past Due Billing</strong></Center></H3></p>
<p class=\"bbackheader\"><Center><H5><strong>This will process the past due balances for failed monthly transactions for all of your clubs. This should be used maybe once a month to attempt to collect on unsuccesful transactions from previous billing cycles.</strong></Center></H5></p>
<td align="left">
<center><input type="button" id="past_billing" name="past_billing" value="Run Past Due Transactions" onClick="openContract(this.id);"/></center>
</td>
</tr>





</span>
</div>
</div>

  
</body>
</html>
CYCLEFREQUENCYTEMPLATE;


echo"$cycleFrequencyTemplate";

?>


