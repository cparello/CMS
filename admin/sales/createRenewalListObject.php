<?php
session_start();
if ((!isset($_SESSION['admin_access'])) && (!isset($_SESSION['user_id'])))  {
exit;
}
//=======================================================
$contract_key = $_REQUEST['contract_key'];
$service_key = $_REQUEST['service_key'];
$renewal_type = $_REQUEST['renewal_type'];
$sid = $_REQUEST['sid']; 
//==============================================end timeout

$renewal_grace = $_SESSION['earlyRenewalGrace'];
$renewal_percent = $_SESSION['earlyRenewalPercent'];

//create the renewal object
include "accountRenewList.php";
$_SESSION['accountRenewList'] = new accountRenewList();
$accountRenewList = $_SESSION['accountRenewList']; 

//set the initial renewal variables
$accountRenewList-> setContractKey($contract_key);
$accountRenewList-> setSelectedServiceKey($service_key);
$accountRenewList-> setRenewType($renewal_type);
$accountRenewList-> setEarlyRenewalGrace($renewal_grace);
$accountRenewList-> setEarlyRenewalPercent($renewal_percent);


$_SESSION['accountRenewList'] = $accountRenewList;

$value = "1";

echo"$value";
exit;

?>