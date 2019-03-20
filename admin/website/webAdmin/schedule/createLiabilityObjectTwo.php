<?php
session_start();

$lib_address_array = $_REQUEST['lib_address_array'];
$contract_key = $_REQUEST['contract_key'];
$attendee_bit = $_REQUEST['attendee_bit'];

$lib_address_array = urldecode($lib_address_array);

$_SESSION['lib_address_array'] = $lib_address_array;
$_SESSION['contract_key'] = $contract_key;
$_SESSION['attendee_bit'] = $attendee_bit;

$liability_key =1;
echo"$liability_key";
exit;

?>