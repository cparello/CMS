<?php

$url = 'https://api.demo.globalgatewaye4.firstdata.com/transaction/v12';

$data = array(“gateway_id” => "AF7527-01", “password” => "x6q4m77o", “transaction_type” => "00", “amount” => "11", “cardholder_name” => "Test", “cc_number” => "411111111111111", “cc_expiry” => "0314"); 
$data_string= json_encode($data);

// Initializing curl
$ch = curl_init( $url );
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, “POST”);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=UTF-8;’,’Accept: application/json"));

// Getting results
$result = curl_exec($ch);
echo"test";
// Getting jSON result string
$data_string = json_decode($result);


if($data_string){
if($data_string->bank_resp_code=="100"){
print("Approved!");
} else {
print($data_string->bank_message);
}
} else {
print($result);
}
?>