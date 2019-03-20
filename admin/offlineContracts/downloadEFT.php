<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

header('Content-disposition: attachment; filename=eft_contract.htm');
header('Content-type: application/contract1');
readfile('eft_contract.htm');
?>