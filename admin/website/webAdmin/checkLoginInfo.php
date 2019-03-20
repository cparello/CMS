<?php
session_start();

class checkBarcode {


function setBarcode($barcode) {
       $this->barcode = $barcode;
       }
function  setPassword($password){
       $this->password = $password;
       }

 //connect to database
function dbconnect()   {
require"../../dbConnect.php";
return $dbMain;
}

//-------------------------------------------------------------------------------------
function loadName() {
    
$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT contract_key FROM web_login_info WHERE barcode = '$this->barcode' AND password = '$this->password'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->contractKey); 
$stmt->fetch(); 
$rows = $stmt->num_rows();
$stmt->close(); 

$stmt = $dbMain ->prepare("SELECT first_name FROM member_info WHERE member_id = '$this->barcode'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->firstName); 
$stmt->fetch(); 
$rows = $stmt->num_rows();
$stmt->close(); 

if($rows > 0){
    $this->name = "1|$this->contractKey|$this->barcode|$this->firstName";
}else{
    $this->name = "2|$this->contractKey|$this->barcode|$this->firstName";
}
$_SESSION['userFirstName'] = $this->firstName;
$_SESSION['userContractKey'] = $this->contractKey;
$_SESSION['userBarcode'] = $this->barcode;
}
//=================================================
function getPaymentStatus() {
       return($this->name);
       }



}
//------------------------------------------------------------------------------------
//send to cybersource

$barcode = $_REQUEST['barcode'];
$password = $_REQUEST['password'];
//echo "fubar";
//exit;

$process = new checkBarcode();
$process-> setBarcode($barcode);
$process-> setpassword($password);
//echo "fubsr $barcode";
//exit;
$process-> loadName();
$payment_status = $process-> getPaymentStatus();


//$requestId = $this->transactionId;
//put the CS request id here
//$_SESSION['cc_request_id'] = $requestId;




echo"$payment_status";
exit;




?>