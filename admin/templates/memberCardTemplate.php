<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$member_card_template= <<<MEMBERCARDTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/memberCardInfo.css">
$javaScript1
$javaScript2
$javaScript3
$javaScript4
$javaScript5

<title>Reassign ID Card</title>

</head>
<body>


<div id="userHeader">
Reassign ID Card
</div>


<div id="userForm">
$card_holder_form
</div>

<div id="contentWindow">
$payment_form
</div>

</body>
</html>
MEMBERCARDTEMPLATE;
echo"$member_card_template";
?>