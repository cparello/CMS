<?php
session_start();

class checkBarcode {


function setBarcode($barcode) {
       $this->barcode = $barcode;
       }
function setPassword($ps) {
       $this->password = $ps;
       }
function setEmail($email) {
       $this->email = $email;
       }


 //connect to database
function dbconnect()   {
require"../../../../dbConnect.php";
return $dbMain;
}

//-------------------------------------------------------------------------------------
function saveLogInfo() {
    
$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT contract_key FROM member_info WHERE member_id = '$this->barcode'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($contract_key); 
$stmt->fetch(); 
$stmt->close(); 

$stmt = $dbMain ->prepare("SELECT COUNT(*) as count FROM web_login_info WHERE barcode = '$this->barcode' and contract_key = '$contract_key'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count); 
$stmt->fetch(); 
$stmt->close(); 

if ($count > 0){
        $sql = "UPDATE web_login_info SET password=?, barcode=?, email=?  WHERE contract_key= '$contract_key'";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('sss' , $this->password, $this->barcode, $this->email);              
           if(!$stmt->execute())  {	                  
        	   printf("Error: %s.\n", $stmt->error );
              }         
        $stmt->close(); 
}else{
    $sql = "INSERT INTO web_login_info VALUES (?, ?, ?, ?)";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('ssss', $contract_key, $this->barcode, $this->password, $this->email);    
    if(!$stmt->execute())  {
    	printf("Error: %s.\n", $stmt->error);
       }		   
    $stmt->close(); 
}
$this->status = 1;
}
//=================================================
function getPaymentStatus() {
       return($this->status);
       }



}
//------------------------------------------------------------------------------------
//send to cybersource

$barcode = $_REQUEST['barcode'];
$ps1 = $_REQUEST['ps1'];
$email = $_REQUEST['email'];

$process = new checkBarcode();
$process-> setBarcode($barcode);
$process-> setPassword($ps1);
$process-> setEmail($email);
//echo "fubsr $barcode";
//exit;
$process-> saveLogInfo();
$payment_status = $process-> getPaymentStatus();


//$requestId = $this->transactionId;
//put the CS request id here
//$_SESSION['cc_request_id'] = $requestId;




echo"$payment_status";
exit;




?>