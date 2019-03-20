<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$check_box_array=$_REQUEST['check_box_array'];
$type_list=$_REQUEST['type_list'];
$from_where=$_REQUEST['from_where'];

$_SESSION['check_box_array'] = $check_box_array;
$_SESSION['type_list'] = $type_list;
$_SESSION['from_where'] = $from_where;

$success = 1;
echo"$success";
exit;
?>