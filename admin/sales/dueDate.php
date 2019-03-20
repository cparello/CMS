<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
//=======================================================

//==============================================end timeout
//this will eventully be set to the users local time zone dynamicaly
date_default_timezone_set('America/Los_Angeles');

$term_days = $_REQUEST['term_days'];
$sid = $_REQUEST['sid']; 

if($term_days != null)   {
echo date('D,  F j, Y', strtotime("+$term_days days"));
}

exit;
?>
