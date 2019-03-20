<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$search_member_card_template= <<<SEARCHMEMBERS
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/searchMemberCard.css">
$javaScript1
$javaScript2

<title>Search Member</title>

</head>
<body>


<div id="userHeader">
Reassign Card
</div>

<div id="conf" class="conf">
&nbsp;
</div>


<div id="userForm">

<table border="0" align="center">
<tr>
<td class="grey spacePadOne">
<u>Search by Full or Partial Name</u>
</td>
</tr>

<tr>
<td>
<form id="form1" name="form1" method="post" action="">
<input  name="search_name" type="text" id="search_name" size="25" maxlength="30"/>
</td>
</tr>


<tr>
<td class="black">
OR
</td>
</tr>

<tr>
<td id="conMem" class="grey spacePadTwo">
<u>Member ID Number</u>
</td>
</tr>

<tr>
<td>
<input  name="id_number" type="text" id="id_number" size="25" maxlength="30"/>
</td>
</tr>


<tr>
<td class="termSpace">
<input type="submit" name="set_amlist" id="set_amlist" class="button" value="Conduct  Search"/>
<input type="hidden" name="marker" id="marker" value="1"/>
<input type="hidden" name="mem_holder" id="mem_holder" value="M"/>
</form>
</td>
</tr>

</table>
</div>

</body>
</html>
SEARCHMEMBERS;
echo"$search_member_card_template";
?>