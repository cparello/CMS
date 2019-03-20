<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class salesTextReminders {

function setPhone($phone) {
                 $this->phone = $phone;
              }
function setName($name) {
                 $this->name = $name;
              }
function setDate($date) {
                 $this->date = $date;
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
 $stmt->bind_result(  $business_name, $business_nick); 
 $stmt->fetch();
 $stmt->close();
 
 $phoneStripped = preg_replace("/[^0-9]/","", $this->phone);
 
 $headers  = "From: $business_name@$business_nick.com\r\n";
$headers .= "Content-type: text/html\r\n"; 

$nameArray = explode(' ',$this->name);

$date1 = date('F j Y ',strtotime($this->date));
$date2 = date('g:i A',strtotime($this->date));
$fname = strtolower($nameArray[0]);
$fname = ucfirst($fname);
$lname = strtolower($nameArray[1]);
$lname = ucfirst($lname);
        
$message = "Hi $fname $lname! This is a reminder that you have an appointment at $business_name on $date1 at $date2.";
 
$message = wordwrap($message, 70, "\r\n");
foreach($carriers As $domain){
    $address = "$phoneStripped@$domain";
    mail($address, 'Appointment reminder', $message, $headers);    
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

$phone = $_REQUEST['phone'];
$name = $_REQUEST['name'];
$ajaxSwitch = $_REQUEST['ajaxSwitch'];
$date = $_REQUEST['classdate'];
 
$phone = urldecode($phone);
$name = urldecode($name);
$ajaxSwitch = urldecode($ajaxSwitch);
$date = urldecode($date);
if ($ajaxSwitch == '1'){
    $reminder = new salesTextReminders();
    $reminder->setPhone($phone);
    $reminder->setName($name);
    $reminder->setDate($date);
    $reminder->sendEmail();
    $result = $reminder->getResult();
}



echo $result;
exit;
?>