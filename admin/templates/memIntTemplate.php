<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$memint = <<<MEMINT
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/memInt.css">
$javaScript1
$javaScript2
$javaScript3

<title>Member Interface</title>
	
</head>
<body>
<input id="goBackAccess" name="goBackAccess" value="Go Back" class="button1" type="submit">
<div id="compHeader">
$header_admin $club_name
</div>

<div id="buttonHouse">

<div id="newMem" class="buttonText">
New Members
</div>

<div id="searchMem" class="buttonText">
Search Member
</div>

<div id="reCard" class="buttonText">
Buy New Barcode
</div>

<div id="checkIn" class="buttonText">
Check-In History
</div>

<div id="guestReg" class="buttonText">
Guest Registration
</div>

<div id="pointSale" class="buttonText">
Point-Of-Sale
</div>

<div id="scheduler" class="buttonText">
Scheduler
</div>

<div id="clockIn" class="buttonText">
Clock In/Out
</div>

</div>


<div id="contentFrame" class="contentFrame">
<iframe src="back_screen.html" width="905" height="540" frameborder="0" name="content" id="content" scrolling="auto">
</iframe>
</div>

<div id="footer">
$footer_admin
</div> 

</body>
</html>
MEMINT;

echo"$memint";
exit;
?>
