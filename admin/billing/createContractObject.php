<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$contract_date = $_REQUEST['contract_date'];
$contract_key = $_REQUEST['contract_key'];
$contract_date = urldecode($contract_date);
$contract_key = urldecode($contract_key);
$bool = $_REQUEST['bool'];
$bool = urldecode($bool);

//create the sales sql object to store the sales info for the contract forms
include "contractSql.php";
$_SESSION['contractSql'] = new contractSql();
$contractSql = $_SESSION['contractSql']; 

$contractSql-> setContractDate($contract_date);
$contractSql-> setContractKey($contract_key);
$contractSql-> setBool($bool);

$_SESSION['contractSql'] = $contractSql;

$value = "1";

echo"$value";
exit;

?>