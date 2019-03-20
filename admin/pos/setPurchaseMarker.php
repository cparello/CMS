<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$purchase_marker = $_REQUEST['purchase_marker'];

$_SESSION['purchase_marker'] = $purchase_marker;


$success = 1;
echo"$success";
exit;
?>