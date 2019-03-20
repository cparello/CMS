<?php
$accountListTemplate = <<<ACCOUNTLIST
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/$account_list_css">
<link rel="stylesheet" href="../css/headerButtons.css">
$javaScript1
$javaScript2
$javaScript3
$javaScript4
$javaScript5

<title>Account Lists</title>
</head>
<body onLoad="confirmRenew();">

$searchButtonTemplate

<!--
<div id="contractTypeHeader">
$form_header
</div>
-->
<br /><br /><br />
<div id="userHeader">
$form_header
</div>
<br />


<div id="colorKeyTab" class="tabText1_div">
<span class="tabText1">Status Keys</span>
</div>

<div id="keyContent">
<div id="white">
</div>
<div id="current">
<span class="keyText">= Current</span>
</div>
<div id="green">
</div>
<div id="expired">
<span class="keyText">= Expired</span>
</div>
<div id="blue">
</div>
<div id="canceled">
<span class="keyText">= Canceled</span>
</div>
<div id="red">
</div>
<div id="hold">
<span class="keyText">= Flagged</span>
</div>
</div>

<div id="resultKeyTab" class="tabText1_div">
<span class="tabText1">Account Result(s)</span>
</div>


<div id="accountResults">
$account_list
</div>

<form name="form1">
<input type="hidden" name="confirmation_message"  id="confirmation_message" value="$confirmation_message"/>
</form>


</body>
</html>
ACCOUNTLIST;

echo"$accountListTemplate";
?>