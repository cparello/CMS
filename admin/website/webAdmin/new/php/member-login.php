<?php
session_start();
//$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin'); 	
//if ($dbMain->connect_error) {
//    die('Connect Error: ' . $dbMain->connect_error);
//}
//echo "fubar";
include "../../../../dbConnect.php";
$barcode = $_REQUEST['barcode'];
$password = $_REQUEST['password'];

$stmt = $dbMain ->prepare("SELECT contract_key FROM web_login_info WHERE email = '$barcode' AND password = '$password'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($contractKey); 
$stmt->fetch(); 
$stmt->close(); 

$stmt = $dbMain ->prepare("SELECT first_name, member_id FROM member_info WHERE  contract_key = '$contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($firstName, $code); 
$stmt->fetch(); 
$rows = $stmt->num_rows();
$stmt->close(); 

if($rows > 0){
    $name = '1|' . $contractKey . '|' . $code . '|' . $firstName;
}
$_SESSION['userFirstName'] = $firstName;
$_SESSION['userContractKey'] = $contractKey;
$_SESSION['userBarcode'] = $code;
$_SESSION['userEmail'] = $barcode;

echo $name;
exit;
//echo 'connected';
?>