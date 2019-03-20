<?php
$orderListTemplate = <<<ORDERLIST
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<script type="text/javascript">

function confirmDelete()  {
var answer = confirm("This will delete all records asscociated with this order. Are you sure that you want to delete this order?");
if (!answer) {
return false;
}
}
</script> 

<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/user_lists.css">
<link rel="stylesheet" href="../css/info.css">
$javaScript1
$javaScript2
$javaScript3

<title>Edit Orders</title>
</head>
<body>

$infoTemplate

<div class="userHeader">
Search Orders
</div>

<div class="userForm1">
$searchForm
</div>

<div id="userHeader">
Process Orders
</div>

<div id="conf" class="conf">
$confirmation &nbsp;
</div>

<div id="userForm1">
$paginationForm
$result1 
</table>
</div>


</body>
</html>
ORDERLIST;

echo"$orderListTemplate";

?>