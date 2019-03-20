<?php
session_start();

class checkBarcode {


function setBarcode($barcode) {
       $this->barcode = $barcode;
       }
function  setZipcode($zipcode){
       $this->zipcode = $zipcode;
       }
function  setEmail($email){
       $this->email = $email;
       }


 //connect to database
function dbconnect()   {
require"../../dbConnect.php";
return $dbMain;
}


//-------------------------------------------------------------------------------------
function loadName() {
$dbMain = $this->dbconnect();   
 
$stmt = $dbMain ->prepare("SELECT business_name FROM company_names WHERE business_name != ''");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->businessName); 
$stmt->fetch(); 
$stmt->close(); 

$stmt22 = $dbMain->prepare("SELECT contact_email FROM business_info WHERE bus_id = '1000'");
$stmt22->execute();
$stmt22->store_result();
$stmt22->bind_result($contact_email);
$stmt22->fetch();
$stmt22->close();
    
function random_string($length) {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return $key;
}

    


$stmt = $dbMain ->prepare("SELECT first_name, last_name, member_id, email, zip FROM member_info WHERE member_id = '$this->barcode' AND email = '$this->email' AND zip = '$this->zipcode'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->firstName, $this->lastName, $member_id, $email, $zip); 
$stmt->fetch(); 
$rows = $stmt->num_rows();
$stmt->close(); 

if($rows > 0){
    $this->name = "1|$this->firstName $this->lastName";
    $key = random_string(50);
    $headers  = "From: $contact_email\r\n";
    $headers .= "Content-type: text/html\r\n";
    $message = "$this->businessName authoriazation code: $key";
    mail($this->email, "$this->businessName Authorization", $message, $headers);
    
    $stmt = $dbMain ->prepare("SELECT count(*) FROM website_member_access WHERE barcode = '$this->barcode'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();  
    
    if($count == 0){
                               
        $sql = "INSERT INTO website_member_access VALUES (?,?)";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('is',$this->barcode, $key);                                          
        if(!$stmt->execute())  {
            printf("Error:insertPaymentHistory1 %s.\n", $stmt->error);
                                              }	
        $stmt->close();
    
    }else{
       $sql = "UPDATE website_member_access SET auth_code = ?  WHERE barcode = '$this->barcode'";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('s', $key);
        if(!$stmt->execute())  {
                    	printf("Error:updateAuthKey %s.\n", $stmt->error);
                          }	
        
        $stmt->close(); 
    }
}else{
    $erCode = "Barcode, Email and/or Zipcode";
    $this->name = "2|$this->firstName $this->lastName|$erCode";
}

}
//=================================================
function getPaymentStatus() {
       return($this->name);
       }



}
//------------------------------------------------------------------------------------
//send to cybersource

$barcode = $_REQUEST['barcode'];
$zipcode = $_REQUEST['zipcode'];
$email = $_REQUEST['email'];

$process = new checkBarcode();
$process-> setBarcode($barcode);
$process-> setZipcode($zipcode);
$process-> setEmail($email);
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