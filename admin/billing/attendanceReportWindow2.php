<?php
include "attendenceListReport2.php";
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


$reportSql = $_SESSION['reportSql'];
$contractHtml = $reportSql-> moveData();
unset($_SESSION['reportSql']);

echo"$contractHtml";
exit;
?>