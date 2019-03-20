<?php
include "contractSql.php";
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


$contractSql = $_SESSION['contractSql'];
$contractHtml = $contractSql-> loadContract();
unset($_SESSION['contractSql']);

echo"$contractHtml";
exit;
?>