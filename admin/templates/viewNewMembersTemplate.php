<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$view_new_members_template= <<<VIEWNEWMEMBERS
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>


<link rel="stylesheet" href="../css/membersList.css">
<title>New Members List</title>
</head>
<body>
<div id="userHeader">
New Members List
</div>

<div id="userForm1">
$new_members_list
</div>


</body>
</html>
VIEWNEWMEMBERS;
echo"$view_new_members_template";
?>