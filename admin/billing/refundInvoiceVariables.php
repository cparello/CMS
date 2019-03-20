<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$ajax_switch = $_REQUEST['ajax_switch'];
$contract_key_invoice = $_REQUEST['contract_key_invoice'];
$refund_balance = $_REQUEST['refund_balance'];
$refund_array = $_REQUEST['refund_array'];
$first_name = $_REQUEST['first_name'];
$middle_name = $_REQUEST['middle_name'];
$last_name = $_REQUEST['last_name'];
$street_address = $_REQUEST[''];
$city_name = $_REQUEST['street_address'];
$state_name = $_REQUEST['state_name'];
$zip_code = $_REQUEST['zip_code'];
         
                 


if($ajax_switch == 1) {

$contract_key_invoice = urldecode($contract_key_invoice);
$refund_balance = urldecode($refund_balance);
$refund_array = urldecode($refund_array);
$first_name = urldecode($first_name);
$middle_name = urldecode($middle_name);
$last_name = urldecode($last_name);
$street_address = urldecode($street_address);
$city_name = urldecode($city_name);
$state_name = urldecode($state_name);
$zip_code = urldecode($zip_code);

$_SESSION['contract_key_invoice'] = $contract_key_invoice;
$_SESSION['refund_balance'] = $refund_balance;
$_SESSION['refund_array'] = $refund_array;
$_SESSION['first_name'] = $first_name;
$_SESSION['middle_name'] = $middle_name;
$_SESSION['last_name'] = $last_name;
$_SESSION['street_address'] = $street_address;
$_SESSION['city_name'] = $city_name;
$_SESSION['state_name'] = $state_name;
$_SESSION['zip_code'] = $zip_code;

$refund_key =1;

}else{
$refund_key =2;
}

echo"$refund_key";
exit;
?>

