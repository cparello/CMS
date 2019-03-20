<?php
session_start();

class checkBarcode {


function setBarcode($barcode) {
       $this->barcode = $barcode;
       }
function  setCode($code){
       $this->code = $code;
       }


 //connect to database
function dbconnect()   {
require"../../dbConnect.php";
return $dbMain;
}


//-------------------------------------------------------------------------------------
function loadName() {
$dbMain = $this->dbconnect();   
 
$stmt = $dbMain ->prepare("SELECT auth_code FROM website_member_access WHERE barcode = '$this->barcode'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($auth_code); 
$stmt->fetch(); 
$stmt->close(); 

if($this->code == $auth_code){
    $this->verfied = 1;
}else{
    $this->verfied = 0;
}



}
//=================================================
function getPaymentStatus() {
       return($this->verfied);
       }



}
//------------------------------------------------------------------------------------
//send to cybersource

$barcode = $_REQUEST['barcode'];
$code = $_REQUEST['code'];
$code = trim($code);
$process = new checkBarcode();
$process-> setBarcode($barcode);
$process-> setCode($code);
$process-> loadName();
$payment_status = $process-> getPaymentStatus();


//$requestId = $this->transactionId;
//put the CS request id here
//$_SESSION['cc_request_id'] = $requestId;




echo"$payment_status";
exit;




?>