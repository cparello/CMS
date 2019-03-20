<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$user  =  $_SESSION['user_name'];



$logout_page = <<<LOGOUT
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<style type="text/css" media="all">

body {
background-color:#FFFFFFF;
background-image:url('images/carbon_fibre.png');
margin: 0;
}


p {
text-align: left;
padding-left: 30px;
font-size: 14pt;
font-weight: 700;
font-style: normal;
font-family: "Arial","Helvetica","Times",serif;
color: #fff;
z-index: 1
}

.logOut:Link {
text-decoration:none;
color: #FCB040;
}

.logOut:visited{
text-decoration:none;
color: #FCB040;
}
.logOut:active{
text-decoration:none;
color: #FCB040;
}
a.logOut:hover { 
text-decoration:none;
color: 	#810541; 
}
</style>
<head>

	<title>Logout</title>
	<meta name="generator" content="BBEdit 8.2">
</head>
<body>
<p>$user  Logged Out</p>
<p>
<a class="logOut" href ="login.php">Login</a>
</p>
</body>
</html>
LOGOUT;


session_destroy();

echo"$logout_page";
exit;
?>