<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$view_check_in_template= <<<VIEWCHECKINHISTORY
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>


<link rel="stylesheet" href="../css/membersList.css">
<title>Check In History</title>
</head>
<body>
<div id="userHeader">
Check In History
</div>

<div id="userForm1">
$history_list
</div>


</body>
</html>
VIEWCHECKINHISTORY;
echo"$view_check_in_template";
?>