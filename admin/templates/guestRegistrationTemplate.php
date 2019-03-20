<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$guest_registration_template= <<<GUESTREGTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/guestRegistration_v1.css">
$javaScript1
$javaScript2
$javaScript3
$javaScript4

<title>Guest Services</title>

</head>
<body>
<div class="topArea">
<div id="userForm" class="left">

<table border="0" align="center" cellpadding="5">
<tr><td><h3><u>Guest Registration</u></h3></td></tr>
<tr>
<td class="black tdHead">
Guest Name
</td>
<td>

<input  type="text" name="guest_name" id="guest_name" size="20" maxlength="30" value=""/>
</td>
</tr>

<tr>
<td class="black tdHead">
Guest Phone
</td>
<td>
<input type="text" name="guest_phone"  id="guest_phone" size="20" maxlength="30" value=""/>
</td>
</tr>

<tr>
<td class="black tdHead">
Guest Email
</td>
<td>
<input type="text" name="guest_email"  id="guest_email" size="20" maxlength="30" value=""/>
</td>
</tr>

<tr>
<td class="black tdHead">
Guest Interests One
</td>
<td>
<input type="text" name="guest_interest_one"  id="guest_interest_one" size="20" maxlength="30" value=""/>
</td>
</tr>

<tr>
<td class="black tdHead">
Guest Interests Two
</td>
<td>
<input type="text" name="guest_interest_two"  id="guest_interest_two" size="20" maxlength="30" value=""/>
</td>
</tr>

<tr>
<td class="black tdHead">
Membership Quote
</td>
<td>
<input type="text" name="quoted_price"  id="quoted_price" size="20" maxlength="30" value=""/>
</td>
</tr>

<tr>
<td class="black tdHead">
Select Location:   
</td>
<td>
<select name="service_location" id="service_location"/>$drop_menu</select>
</td>
</tr>



</table>
</div>

<div id="searchForm" class="right">

<table border="0" align="center">
<tr>
<td class="grey">
<u><h3>Guest Search</h3></u>
</td>
</tr>

<tr>
<td>
<select name="search_type" id="search_type"/>
<option value="X">Choose Search Type</option>
<option value="N">Guest Name</option>
<option value="P">Guest Phone Number</option>
<option value="E">Guest Email</option>
</select>      
</td>
</tr>

<tr>
<td>
<input  name="search_string" type="text" id="search_string" size="25" maxlength="30"/>
</td>
</tr>

<tr>
<td class="termSpace">
<input type="submit" name="guest_list" id="guest_list" class="button99" value="Conduct  Search"/>
</td>
</tr>

</table>
<div class="spacer">
</div>
<span id="guestResult"></span>
</div>
</div>


<div id="contentWindow">
<table align="left" border="0" cellspacing="0" cellpadding="4" width=100%>
<tr>
<th align="left" class="white">#</th>
<th align="left" class="white">Guest Pass Title</th>
<th align="left" class="white">Services</th>
<th align="left" class="white">Term One</th>
<th align="left" class="white">Term Two</th>
<th align="left" class="white">Term Three</th>
<th align="left" class="white">Term Four</th>
<th align="left" class="white">Service Location</th>
<th align="left" class="white">Select Pass</th>
</tr> 
</table>
</div>

</body>
</html>
GUESTREGTEMPLATE;
echo"$guest_registration_template";
?>