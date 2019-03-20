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
        
//$message1 = "Hi $this->name! This is a message that your $this->service to $business_name will expire on $this->date.";
//$message2 =" You can renew this membership for $$this->price with a $this->discount% discount;"; 
 
$message = wordwrap($message, 70, "\r\n");
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
//=============================================================
$ajaxSwitch = $_REQUEST['ajaxSwitch'];

$phone = $_REQUEST['phone'];
$name = $_REQUEST['name'];
$date = $_REQUEST['date'];
$service = $_REQUEST['service'];
$price = $_REQUEST['price'];
$discount = $_REQUEST['discount'];
$paymentMonth = $_REQUEST['paymentMonth'];
$monthlyPayment  = $_REQUEST['monthlyPayment'];
$response  = $_REQUEST['response'];
$payment = $_REQUEST['payment'];
$monthsPast  = $_REQUEST['monthsPast'];
$checkNumber = $_REQUEST['checkNumber'];
$rejectedPayment = $_REQUEST['rejectedPayment'];
$reportType = $_REQUEST['reportType'];

$cardNum = $_REQUEST['cardNum'];
$cardExp = $_REQUEST['cardExp'];
$amountOwed = $_REQUEST['amountOwed'];
$reasonDescrip = $_REQUEST['reasonDescrip'];
$transTitle = $_REQUEST['transTitle'];

$amount_owed = $_REQUEST['amount_owed'];
$months_past_due = $_REQUEST['months_past_due'];
$month_left = $_REQUEST['month_left'];
                                     

require"../dbConnect.php";

$stmt = $dbMain ->prepare("SELECT business_name, business_nick FROM company_names WHERE business_name !=  ''");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($business_name, $business_nick); 
 $stmt->fetch();
 $stmt->close();

switch($reportType){
    case 'MS':
            $title = "$business_nick Monthly Statement Due";
            $message1 = "Hi $name! This is a message that your Monthly Statement to $business_name is due for $paymentMonth.";
            $message2 =" Your  payment due is: $$monthlyPayment"; 
    break;
    case 'PD':
            $title = "$business_nick Account Past Due";
            $message1 = "Hi $name! This is a message that your $business_name is Past Due $monthsPast months.";
            $message2 =" You currently owe: $$payment"; 
    break;
    case 'DR':
            $title = "$business_nick Account Payment Declined";
            $message1 = "Hi $name! This is a message that payments to your $business_name have declined.";
            $message2 =" You owe: $$rejectedPayment."; 
    break;
    case 'BL':
            $cardExp = date('m/y',strtotime($cardExp));
            $title = "$business_nick New Payment Method Required";
            $message1 = "Hi $name! Your card on file($cardNum    $cardExp) at $business_name has declined due to $reasonDescrip.";
            $message2 ="You now owe: $amountOwed for your $transTitle payments."; 
    break;
    case 'GP':
            $title = "$business_nick Renewal Notice";
            $message1 = "Hi $name! This is a message that your $service to $business_name will expire on $date.";
            $message2 =" You can renew for: $$price."; 
    break;
    case 'CO':
            $title = "$business_nick Collections Notice";
            $message1 = "Hi $name! This is a message that your $business_name account has been put into collections.";
            $message2 =" You are $months_past_due months past due and owe $amount_owed."; 
    break;
     case 'SR':
            $title = "$business_nick Renewal Notice";
            $message1 = "Hi $name! This is a message that your $service to $business_name will expire on $date.";
            $message2 =" You can renew for: $$price within $discount days."; 
    break;
     case 'EE':
            $title = "$business_nick Re-Enroll Notice";
            $message1 = "Hi $name! We want you to come back to $business_name.";
            $message2 ="Call now for a special offer."; 
    break;
     case 'PE':
            $title = "$business_nick Promo Notice";
            $message1 = "Hi $name! This is a notice that we have a promotion for your $service to $business_name.";
            $message2 ="Call now for a special offer."; 
    break;
    default:
            $title = "$business_nick Renewal Notice";
            $message1 = "Hi $name! This is a message that your $service to $business_name will expire on $date.";
            $message2 =" You can renew for: $$price with a $discount% discount."; 
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