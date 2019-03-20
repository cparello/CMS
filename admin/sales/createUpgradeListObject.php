<?php
session_start();
if ((!isset($_SESSION['admin_access'])) && (!isset($_SESSION['user_id'])))  {
exit;
}
//=======================================================
$contract_key = $_REQUEST['contract_key'];
$service_key = $_REQUEST['service_key'];
$sid = $_REQUEST['sid']; 
//==============================================end timeout
//create the upgrade object
include "accountUpgradeList.php";
$_SESSION['accountUpgradeList'] = new accountUpgradeList();
$accountUpgradeList = $_SESSION['accountUpgradeList']; 

//set the initial variables
$accountUpgradeList-> setContractKey($contract_key);
$accountUpgradeList-> setSelectedServiceKey($service_key);

$_SESSION['accountUpgradeList'] = $accountUpgradeList;

$value = "1";

echo"$value";
exit;

?>