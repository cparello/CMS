<?php
$accountListTemplate = <<<ACCOUNTLIST
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/$account_list_css"/>
$javaScript1
$javaScript2
$javaScript3
$javaScript4
$javaScript5

<title>Account Lists</title>
</head>
<body>


<div id="contractTypeHeader">
$form_header
</div>


<div id="accountResults">
$account_list
</div>




</body>
</html>
ACCOUNTLIST;

echo"$accountListTemplate";
?>