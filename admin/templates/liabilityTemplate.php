<?php
$liabilityTemplate = <<<LIABILITYTEMPLATE
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
        "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/contract.css"/>
$javaScript1
	<title>Untitled</title>
</head>
<body>
<div id="pageWrap">
<div id="contractHeaders">
<div id="logoDiv">
$logo_image
</div>
<div id="contractType">
<span class="typeName">$waiver_header</span>
<span class="pipe">|</span>
<span class="contractNumber">Contract #$contract_key</span>
</div>
</div>

<div id="hostHeader">
<span class="subHeader">$info_header</span>
</div>
<div id="underline"></div>

<div id="memberInfo">
<table>
<tr>
<td class="nameTitles">
$name_header:
</td>
<td class="nameSakes">
$first_name $middle_name $last_name
</td>
</tr>
<tr>
<td class="nameTitles">
Address:
</td>
<td class="nameSakes">
$street_address
</td>
</tr>
<tr>
<td class="nameTitles">
Primary Phone:
</td>
<td class="nameSakes">
$primary_phone
</td>
</tr>
<tr>
<td class="nameTitles">
Cell Phone:
</td>
<td class="nameSakes">
$cell_phone
</td>
</tr>
<tr>
<td class="nameTitles">
Email Address:
</td>
<td class="nameSakes">
$email_address
</td>
</tr>
</table>
</div>

<div id="liabilityTerms">
<p>
$liability_terms
</p>
</div>

<div id="dateSign">
$contract_location
</div>

<div id="signLine">
<div id="signLine1"><span class="signatures">$sig_blurb</span></div>
</div>

</div>
</body>
</html>
LIABILITYTEMPLATE;


echo"$liabilityTemplate";

?>
