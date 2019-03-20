<?php

require_once("../../../dbConnect.php");
require_once("getBannerList.php");

$getList = new getBannerList();
$listings = $getList-> getBannerDrop();


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Edit Banners</title>
</head>
<body>
<center>
<font size="4" color="#333333" face="arial"><b>Edit Banners</br></font>
<p align="center">
<hr align="center" size="3" width="20%">
</p>

<table align="center" cellspacing="4" width = "20%">
<tr>
<th align="center">
<font size="2" color="#000000" face="Arial">Banner List</font>
</th>
</tr>

<tr>
<td align="center">
<form action="create_banners.php" method="post">
<?php echo"$listings";?>
</td>
</tr>

<tr>
<td align="center">
<br><br>
<input type="submit" id="submit" value="Edit" >
<input type="hidden" name="marker" value="1">
</form>
</td>
</tr>
</table>
</p>

<p align="center">
<hr align="center" size="3" width="20%">
</p>

<p>

</center>
</body>
</html>
