<?php
$searchOrdersTemplate = <<<SEARCHORDERS
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/search_users.css">
<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/pop_hint.css">

$javaScript1
$javaScript2
$javaScript3
$javaScript4

	<title>Search Edit Orders</title>

</head>
<body>
$infoTemplate

<div id="userHeader">
Search Orders 
</div>

<div id="idContent1">  
&nbsp;
</div>

<form id="form1" name="form1" method="post" action="searchOrders.php" >

<div id="userForm1">
<table border="0" align="center">
<tr>
<td  class="grey">
<u>Search by Bar Code</u>
</td>
</tr>
<tr>
<td>
<input tabindex= "1" name="bar_code[]" type="text" id="bar_code" value="" size="30" maxlength="40"/>
</td>
</tr>
<tr>
<td>
<input type="submit" name="bar" id="bar" value="Search Barcode"/>
</td>
</tr>
</table>
</div>

<div id="userForm2">
<table border="0" align="center">
<tr>
<td  class="grey">
<u>Search by Product Description</u>
</td>
</tr>
<tr>
<td>
<input tabindex= "3" name="product_desc[]" id="product_desc" value="" size="30" maxlength="50"/>
</td>
</tr>
<tr>
<td>
<input type="submit" name="desc" id="desc" value="Search Product Description"/>
</td>
</tr>
</table>
</div>

<div id="userForm3">
<table border="0" align="center">
<tr>
<td  class="grey">
<u>Search by Category</u>
</td>
</tr>
<tr>
<td>
<select name="category_id" id="category_id">$drop_menu_cat</select>
</td>
</tr>
<tr>
<td>
<input type="submit" name="cat" id="cat" value="Search Category"/>
</td>
</tr>
</table>
</div>

<div id="userForm4">
<table border="0" align="center">
<tr>
<td  class="grey">
<u>Search by Status</u>
</td>
</tr>
<tr>
<td>
<select name="status_id" id="status_id">$drop_menu_stat</select>
</td>
</tr>
<tr>
<td>
<input type="submit" name="stat" id="stat" value="Search Status"/>
</td>
</tr>
</table>
</div>

<input type="hidden" name="marker" id="marker" value="1" />
<input type="hidden" name="search_type" id="search_type" value="" />
</form>


</body>
</html>
SEARCHORDERS;


echo"$searchOrdersTemplate";
?>