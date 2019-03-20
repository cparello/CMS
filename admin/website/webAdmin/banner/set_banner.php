<?php
require_once("../../../dbConnect.php");
require_once("getBannerList.php");
if (!isset($_SESSION)) {
  session_start();
}


$getList = new getBannerList();
$listings = $getList-> getBannerDrop();

$marker = $_REQUEST['marker'];
$banner_id = $_REQUEST['banner_id'];

if($marker == 1)  {
$getList ->setLive($banner_id);

$banner_name = $getList -> getBannerName();
$banner_blurb = "<p><font size=\"2\" color=\"#336633\" face=\"arial\"><b>$banner_name Is now set to Live</b></p>";
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Set Banner Live</title>
</head>
<body>
<center>
<font size="4" color="#333333" face="arial"><b>Set Banner Live</br></font>
<?php echo"$banner_blurb";?>
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
<form action="set_banner.php" method="post">
<?php echo"$listings";?>
</td>
</tr>

<tr>
<td align="center">
<br><br>
<input type="submit" id="submit" value="Set Banner Live" >
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
