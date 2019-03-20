<?php
//echo "fubar" ;
//exit;
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class sendSms {
    
function setPhone($phone) {
                 $this->phone = $phone;
              }
function setMsg1($msg1) {
                 $this->msg1 = $msg1;
              }
function setMsg2($msg2) {
                 $this->msg2 = $msg2;
              }
function setTitle($title) {
                 $this->title = $title;
              }
//-------------------------------------             
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;              
}

//============================================================
function sendEmail() {
/**
 * 
 *AT&T (SMS)	txt.att.net	United States
Boost Mobile	myboostmobile.com	United States
C Spire	cspire1.com	United States
Cricket	sms.mycricket.com	United States
MetroPCS	mymetropcs.com	United States
Sprint	messaging.sprintpcs.com	United States
T-Mobile	tmomail.net	United States
U.S. Cellular	email.uscc.net	United States
Verizon Wireless (SMS)	vtext.com	United States
Virgin Mobile	vmobl.com	United States 
 * 
 * 
 * @copyright 2014
 */
 $carriers = array('txt.att.net','myboostmobile.com','cspire1.com','sms.mycricket.com','mymetropcs.com','messaging.sprintpcs.com','tmomail.net','email.uscc.net','vtext.com','vmobl.com');
 
 
 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT business_name, business_nick FROM company_names WHERE business_name !=  ''");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($business_name, $business_nick); 
 $stmt->fetch();
 $stmt->close();
 
 $phoneStripped = preg_replace("/[^0-9]/","", $this->phone);
 
 $headers  = "From: $business_name@$business_nick.com\r\n";
$headers .= "Content-type: text/html\r\n"; 

foreach($carriers As $domain){
    //echo "test";
    $address = "$phoneStripped@$domain";
    mail($address, "$this->title", $this->msg1, $headers);   
    mail($address, "$this->title", $this->msg2, $headers);    
}

 
   //mail('8188598103@vtext.com', '', 'This was sent with PHP.' );
$this->result = 1;
}
//===========================================================================================

function getResult() {
          return($this->result);
          }
}
//=============================================================ajaxSwitch: ajaxSwitch, month: month, year: year, response: response, pResponse: pResponse, name: name, price: price, phone: phone, reportType: reportType},               
                              
$ajaxSwitch = $_REQUEST['ajaxSwitch'];

$phone = $_REQUEST['phone'];
$name = $_REQUEST['name'];
$month = $_REQUEST['month'];
$year = $_REQUEST['year'];
$price = $_REQUEST['price'];
$response  = $_REQUEST['response'];
$pResponse  = $_REQUEST['pResponse'];
$reportType  = $_REQUEST['reportType'];

require"../dbConnect.php";

$stmt = $dbMain ->prepare("SELECT business_name, business_nick FROM company_names WHERE business_name !=  ''");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($business_name, $business_nick); 
 $stmt->fetch();
 $stmt->close();
 
 $stmt = $dbMain ->prepare("SELECT business_phone, contact_email FROM business_info WHERE bus_id != ''");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($business_phone, $contact_email); 
    $stmt->fetch();
    $stmt->close();

switch($reportType){
    case 'BX':
            $title = "$business_nick Payment Failed";
            $message1 = "Hi $name! Your payment failed: $pResponse. Your payment due is: $$price";
            $message2 =" Please contact us at $business_phone or $contact_email ASAP."; 
    break;
    case 'BZ':
            $title = "$business_nick Statement";
            $message1 = "Hi $name! Your payment of $$price to $business_name for $month/$year is due.";
            $message2 =" Please contact us at $business_phone or $contact_email ASAP.";
    break;
    
}
 //echo "$phone $name  $date  $service $price $discount $paymentMonth $monthlyPayment  $response $payment $monthsPast $checkNumber $rejectedPayment $reportType" ;
//exit;


$phone = urldecode($phone);
$name = urldecode($name);
$ajaxSwitch = urldecode($ajaxSwitch);
$date = urldecode($date);
if ($ajaxSwitch == '1'){
    $reminder = new sendSms();
    $reminder->setPhone($phone);
    $reminder->setMsg1($message1);
    $reminder->setMsg2($message2);
    $reminder->setTitle($title);
    $reminder->sendEmail();
    $result = $reminder->getResult();
}



echo $result;
exit;
?>