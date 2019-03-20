<?php
session_start();

class checkBarcode {


function setBarcode($barcode) {
       $this->barcode = trim($barcode);
       }
function  setName($name){
       $this->name = trim($name);
       }
function  setEmail($email){
       $this->email = trim($email);
       }


 //connect to database
function dbconnect()   {
require"../../../../dbConnect.php";
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

       $card_name_array = preg_split('/[\s]+/', $this->name);
       $array_count1 = count($card_name_array);
    
       switch ($array_count1) {
         case 0:
               $first_name = "";
               $last_name = $this->name;
         break;
         case 1:
               $first_name = "";
               $last_name = $this->name;
         break;
         case 2:
               $first_name = $card_name_array[0];
               $last_name = $card_name_array[1];
         break;
         case 3:
               $first_name = $card_name_array[0];
               $last_name = $card_name_array[2];
         break;
         case 4:
               $first_name = $card_name_array[0];
               $last_name = "$card_name_array[1] $card_name_array[2] $card_name_array[3]";
         break;
         default:
               $first_name = $card_name_array[0];
               $last_name = "$card_name_array[1] $card_name_array[2] $card_name_array[3] $card_name_array[4]";
         break;
         }

$stmt = $dbMain ->prepare("SELECT count(*) FROM member_info WHERE member_id = '$this->barcode' AND email = '$this->email' AND first_name LIKE '%$first_name%' AND last_name LIKE '%$last_name%'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count); 
$stmt->fetch(); 
$stmt->close(); 

if($count > 0){
    $this->name = "1|$this->name";
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
    $this->name = "2|$this->name|$erCode";
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
$name = $_REQUEST['name'];
$email = $_REQUEST['email'];

$process = new checkBarcode();
$process-> setBarcode($barcode);
$process-> setName($name);
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