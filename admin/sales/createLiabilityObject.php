<?php
session_start();
if ((!isset($_SESSION['admin_access'])) && (!isset($_SESSION['user_id'])))  {
exit;
}
//=======================================================

//==============================================end timeout
$lib_address_array  = $_GET['lib_address_array'];
$lib_emg_contact_array  = $_GET['lib_emg_contact_array'];
$contract_key = $_REQUEST['contract_key'];


$lib_address_array = urldecode($lib_address_array);
$lib_emg_contact_array = urldecode($lib_emg_contact_array);

$_SESSION['lib_emg_contact_array'] = $lib_emg_contact_array;
$_SESSION['lib_address_array'] = $lib_address_array;
$_SESSION['contract_key'] = $contract_key;

$liability_key =1;
echo"$liability_key";
exit;

?>