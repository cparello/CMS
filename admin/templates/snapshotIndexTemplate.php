<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$snapshot = <<<SNAPSHOT
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/snapshot.css">
$javaScript1
$javaScript2
$javaScript3

<title>Member Snapshots</title>
	
</head>
<body>
<input id="goBackAccess" name="goBackAccess" value="Go Back" class="button1" type="submit">
<div id="compHeader">
$header_admin
</div>

<div id="memberHouse">
<table>
<tr>
<td class="blueName" valign="top">
Member Name:
</td>
<td class="blackOne"> 
<span id="memName"></span> 
<br>
<form id="form1">
<input type="text" name="memNum" id="memNum" size="8" maxlength="25"/>
<input type="submit" id="vbut" name="vbut" value="" />
<input type="hidden" id="location_id" name="location_id" value="$location_id"/>
</form>

</td>
<td rowspan="7" valign="top" class="photo" id="memPhoto">
<img src="../memberphotos/no_photo.jpg" width="150" height="175" style="border:5px solid #FFF">
</td>
</tr>

<tr>
<td class="blue">
Member Status:
</td>
<td class="flag" id="memFlag">
</td>
</tr>

<tr>
<td class="blue" valign="top">
Membership Type:
</td>
<td class="status" id="memshipType">
</td>
</tr>

<tr>
<td class="blue">
Associations:
</td>
<td class="status" id="memType">
</td>
</tr>

<tr>
<td class="blue" valign="top">
Attendance History:
</td>
<td class="status" id="memHist">
</td>
</tr>

<tr>
<td class="blue" valign="top">
Upgrades/ Add-Ons:
</td>
<td class="status" id="upAdds">
</td>
</tr>


<tr>
<td class="blue" valign="top">
Emergency Contact:
</td>
<td class="status"  id="emgCont">
</td>
</tr>

<tr>
<td class="blue" valign="top">
Notes:
</td>
<td class="status" id="noteDateOne">
</td>
<td class="status" id="noteTopicOne">
</td>
</tr>

<tr>
<td class="blue" valign="top">
&nbsp;
</td>
<td class="status" id="noteDateTwo">
</td>
<td class="status" id="noteTopicTwo">
</td>
</tr>

<tr>
<td class="blue" valign="top">
&nbsp;
</td>
<td class="status" id="noteDateThree">
</td>
<td class="status" id="noteTopicThree">
</td>
</tr>

<tr>
<td colspan="2">
&nbsp;
</td>
<td class="logo">
<img src="../images/logo.jpg" width="188" height="62">
</td>
</tr>

</table>
</div>

<div id="footer">
$footer_admin
</div> 

</body>
</html>
SNAPSHOT;

echo"$snapshot";
exit;
?>
