<?php
$productListTemplate = <<<PRODUCTLIST
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<script type="text/javascript">

function confirmDelete()  {
var answer = confirm("This will delete all records asscociated with this product. Are you sure that you want to delete this product?");
if (!answer) {
return false;
}
}
</script> 

<link rel="stylesheet" href="../css/user_lists.css">
<link rel="stylesheet" href="../css/info.css">
$javaScript1
$javaScript2

<title>Edit Inventory</title>
</head>
<body>

$infoTemplate

<div id="userHeader">
Edit Inventory  
</div>

<div id="conf" class="conf">
$confirmation &nbsp;
</div>

<div id="userForm1">
$result1 
</table>
</div>


</body>
</html>
PRODUCTLIST;

echo"$productListTemplate";

?>