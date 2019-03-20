<?php
$roomListTemplate = <<<ROOMLIST

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>

<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/scheduleType.css">

$javaScript1
$javaScript2
$javaScript3
$javaScript4
$javaScript5


<title>Edit Rooms</title>
</head>
<body>

$infoTemplate

<div id="userHeader">
$page_title 
</div>

<div id="conf" class="conf">
&nbsp;
</div>

<div id="userForm">
$drop_list
</div>

<input type="hidden" name="confirmation" id="confirmation" value="$confirmation"/>
</body>
</html>
ROOMLIST;

echo"$roomListTemplate";

?>