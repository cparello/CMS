<?php
$memIntPasswordsTemplate = <<<MEMINTPASSWORDSTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/memIntPasswords.css">
$javaScript1
$javaScript2

<title>Set Member Interface Passwords</title>

</head>
<body>
$infoTemplate


<div id="userHeader">
Set Member Interface Passwords
</div>

<div id="conf" class="conf">
&nbsp;
</div>


<div id="userForm">

<table border="0" align="center">
<tr>
<td class="grey">
<u>Interface Location</u>
</td>
</tr>

<tr>
<td>
<select name="service_location" id="service_location"/>
 $drop_menu
</select>      
</td>
</tr>

<tr>
<td class="grey spacePad">
<u>Interface User Name</u>
</td>
</tr>

<tr>
<td>
<input name="usr_name" type="text" id="usr_name" size="25" maxlength="25"/>
</td>
</tr>

<tr>
<td class="grey spacePad">
<u>Interface Password</u>
</td>
</tr>

<tr>
<td>
<input name="pass_word" type="text" id="pass_word" size="25" maxlength="15"/>
</td>
</tr>

<tr>
<td class="termSpace">
<input type="button" name="set_passwords" id="set_passwords" value="Set Interface Passwords"/>
</td>
</tr>

</table>
</div>

 

</body>
</html>
MEMINTPASSWORDSTEMPLATE;


echo"$memIntPasswordsTemplate";
?>