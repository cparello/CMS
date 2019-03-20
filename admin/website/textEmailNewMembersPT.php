<?php
session_start();
//error_reporting(E_ALL);
class emailNewMemberReports {

private $contractKey = null;
private $barCode = null;
private $firstName = null;
private $midName = null;
private $lastName = null;
private $phone = null;
private $email = null;
private $street = null;
private $color = null;


function setMonth($month){
    $this->month = $month;
}
function setDay($day){
    $this->day = $day;
}
function setYear($year){
    $this->year = $year;
}
function setClubName($club){
    $this->clubName = $club;
}
   
          
          
//connect to database
function dbConnect()   {
require"dbConnect.php";
return $dbMain;
}


//==============================================================================================
function moveData(){
  
$dbMain = $this->dbconnect();

$carriers = array('txt.att.net','myboostmobile.com','cspire1.com','sms.mycricket.com','mymetropcs.com','messaging.sprintpcs.com','tmomail.net','email.uscc.net','vtext.com','vmobl.com');
 
$stmt = $dbMain ->prepare("SELECT business_name, business_nick FROM company_names WHERE business_name !=  ''");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($business_name, $business_nick); 
$stmt->fetch();
$stmt->close();
 
$headers  = "From: $business_name@$business_nick.com\r\n";
$headers .= "Content-type: text/html\r\n"; 

$counter = 1;
$message = "<!DOCTYPE html PUBLIC \"\-//W3C//DTD XHTML 1.0 Transitional//EN\"\ \"\http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"\>
<html xmlns=\"\http://www.w3.org/1999/xhtml\"\>
 <head>
  <meta http-equiv=\"\\Content-Type\"\ content=\"\text/html; charset=UTF-8\"\ />";

$message = "<p class=\"bbackheader\"><Center><H1><strong>Club Manager Pro  -  New Member Report</strong></Center></H1></p><br>";

  $dayStart = date('Y-m-d H:i:s', mktime(0,0,0,$this->month,$this->day,$this->year));
  $dayEnd = date('Y-m-d H:i:s', mktime(23,59,59,$this->month,$this->day,$this->year));
  
  $date = date('F d Y',strtotime($dayStart));
  
  $message .= "<p class=\"bbackheader\"><Center><H1><strong>Club:</strong> " . $this->clubName . "  </Center></H1></p>";
  
  $message .= "<tr><td><Center><strong>Date:</strong>    " . $date . " </Center></td></tr>";
  
  
  
  $message .= "<p class=\"bbackheader\"><Center><H3><strong>New Members:</strong></Center></H3></p>";
  $message .=" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Member Contract Key</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Member Name</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Phone</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Cell Phone</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Email</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">New/Renewal</font></th>
  </tr>\n"; 
  
    $stmt3 = $dbMain->prepare("SELECT contract_key, service_name, unit_price, user_id, new_sale FROM sales_info WHERE (sale_date_time BETWEEN '$dayStart' AND '$dayEnd') AND (contract_location LIKE '%$this->clubName%')");
    $stmt3->execute();
    $stmt3->store_result();
    $stmt3->bind_result($contract_key, $service_name, $unit_price, $user_id, $new_sale);
    while($stmt3->fetch()){
        
        
                $stmt = $dbMain->prepare("SELECT first_name, last_name, primary_phone, cell_phone, email FROM member_info WHERE contract_key = '$contract_key'");
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($mem_fname, $mem_lname, $primary_phone, $cell_phone, $email);
                $stmt->fetch();
                $stmt->close();
                
        
                
                $transType = '';
                
                if ($new_sale == 'Y'){
                    $jointText = 'New';
                    $newRenew = "purchased a";
                }else{
                    $jointText = 'Renewal';
                    $newRenew = "renewed your";
                }
                
                $cellPhoneStripped = preg_replace("/[^0-9]/","", $cell_phone);
                $homePhoneStripped = preg_replace("/[^0-9]/","", $primary_phone);
                
                
                if (!preg_match('/000/',$cellPhoneStripped)){
                    $phone = $cellPhoneStripped;
                }elseif(!preg_match('/000/',$homePhoneStripped)){
                    $phone = $homePhoneStripped;
                }
                
                $fname = strtolower($mem_fname);
                $fname = ucfirst($mem_fname);
                $lname = strtolower($mem_lname);
                $lname = ucfirst($mem_lname);
                        
                $message = "Hi $fname $lname! We see that you have recently $newRenew membership at $business_name. We would like to offer you a complimentary Personal Training Assesment. During this assesment we will go over nutriton, answer all the questions you may have and get you started with a workout customized to your current fitness level, plus more! Please call us at (818)-859-8103 to setup a time now!";
                 
                $message = wordwrap($message, 70, "\r\n");
                foreach($carriers As $domain){
                    $address = "$phone@$domain";
                    mail($address, 'Training Assesment', $message, $headers);    
                }
                mail($email, 'Training Assesment', $message, $headers);   
                
                //$message .= "<tr><td><Center> <strong>Type:</strong> " . $transType . " <strong> Service: </strong> " . $service_name . " <strong> Cost:  </strong> " . $unit_price . " <strong>  Salesperson: </strong> " . $emp_fname ." " . $emp_lname . "</Center></td></tr>";
                $message .=    "<tr>
                        <td align=\"left\" valign =\"top\">
                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$counter</b></font>
                        </td>
                        <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$contract_key</b></font>
                        </td>
                        <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$mem_fname  $mem_lname</b></font>
                        </td>  
                        <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$primary_phone</b></font>
                        </td>
                        <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$cell_phone</b></font>
                        </td>
                        <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$email</b></font>
                        </td>
                        <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
                        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$jointText</b></font>
                        </td>
                        </tr>\n";
                                
                $count++;
                $counter++;
            }
            $stmt3->close();
  
    $message .=  "</table>
</head>
</html>";
  
    //$message = wordwrap($message, 70, "\r\n"); 
$headers  = "From: ClubManagerPro@bac.com\r\n";
$headers .= "Content-type: text/html\r\n";  
$message = wordwrap($message, 70, "\r\n");
//mail($contact_email, 'Daily Sales Report', $message, $headers);   
mail('christopherparello@gmail.com', 'New Member Report', $message, $headers);
//mail('christopherderg@gmail.com', 'New Member Report', $message, $headers);

echo "Email sent!";

}
//===============================================

}
$month = $_REQUEST['month'];
$day = $_REQUEST['day'];
$year = $_REQUEST['year'];
$club = $_REQUEST['club'];

$report = new emailNewMemberReports();
$report->setMonth($month);
$report->setDay($day);
$report->setYear($year);
$report->setClubName($club);
$report->moveData();







?>