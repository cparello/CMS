<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

header('Content-disposition: attachment; filename=pif_contract.htm');
header('Content-type: application/contract2');
readfile('pif_contract.htm');
?>