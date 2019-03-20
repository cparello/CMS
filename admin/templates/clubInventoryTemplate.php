<?php
$clubInventoryTemplate = <<<CLUBINVENTORY
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/clubInventory.css">
<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/pop_hint.css">

$javaScript1
$javaScript2
$javaScript3
$javaScript4

<title>Club Inventory</title>

</head>
<body>
$infoTemplate

<div id="assignHeader">
Assign Inventory 
</div>

<div id="conf" class="conf">
 &nbsp;
</div>

<div id="warehouseForm">
$result1
</div>

<div id="clubForms">
$result2
</div>

</body>
</html>
CLUBINVENTORY;


echo"$clubInventoryTemplate";
?>