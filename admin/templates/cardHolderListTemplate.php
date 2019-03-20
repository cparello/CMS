<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$card_holder_list_template= <<<CARDLIST
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
$javaScript1
$javaScript2

<link rel="stylesheet" href="../css/membersList.css">
<title>Check In History</title>
</head>
<body>
<div id="userHeader">
$form_header
</div>

<div id="userForm1">
$list_results
</div>


</body>
</html>
CARDLIST;
echo"$card_holder_list_template";
?>