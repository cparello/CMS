<?php
session_start();
class emailReport {

function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//==============================================================================================
function moveData(){

$dbMain = $this->dbconnect();

 $year[1] = date("Y");//'2013';
 $month[1] = date("m");//'12';
 $day[1] = date("j");//'10';
 if ($day[1] == '1'){
        $day[1] = date('d', strtotime('last day of previous month'));
        if ($month[1] == '1'){
            $month[1] = '12';
        }else{
            $month[1]--;
        }
    }else{
        $day[1] -= 1;
    }
    
 if ($day[1] < '10'){
        $day[1] = "0$day[1]";
    }



//$message = "Contract_key  <>    Credit_card   <>  Exp   <>    Name   <>    Amount   <>  Card_type    <>   Reason_code  <>   Reason_descrip   <>   Fail_date   <>     Trans_title <> Phone \r\n";

// In case any of our lines are larger than 70 characters, we should use wordwrap()
//$message = wordwrap($message, 70, "\r\n");

// Send

$message = "<!DOCTYPE html PUBLIC \"\-//W3C//DTD XHTML 1.0 Transitional//EN\"\ \"\http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"\>
<html xmlns=\"\http://www.w3.org/1999/xhtml\"\>
 <head>
  <meta http-equiv=\"\\Content-Type\"\ content=\"\text/html; charset=UTF-8\"\ />";
//echo "Contract_key  <>    Credit_card   <>  Exp   <>    Name   <>    Amount   <>  Card_type    <>   Reason_code  <>   Reason_descrip   <>   Fail_date   <>     Trans_title<br>";
$message .= "<p class=\"bbackheader\"><Center><H1><strong>Club Manager Pro</strong></Center></H1></p>";
$message .= "<p class=\"bbackheader\"><Center><H1><strong>Collections: Accepted Cards</strong></Center></H1></p><br><br>";
$message .=" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract Key</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Name</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Phone</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">CC Num</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">CC Exp</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Card Type</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Amount</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Reason Code</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Reason Description</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Transaction Title</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Fail Date</font></th>
  </tr>\n"; 

$counter = 1;
$total = 0;
$stmt = $dbMain->prepare("SELECT contract_key, credit_card_num, card_exp, card_name, amount_owed, card_type, reason_code, reason_descrip, fail_date, trans_title, phone FROM collections_accepted_cards WHERE contract_key != '' AND fail_date = '$year[1]-$month[1]-$day[1]'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($contract_key,$credit_card_num,$card_exp,$card_name,$amount_owed,$card_type,$reason_code,$reason_descrip,$fail_date,$trans_title,$phone);   
while($stmt->fetch()){
    $total += $amount_owed;
    //echo "$contract_key  <>   $credit_card_num   <>     $card_exp   <>    $card_name   <>   $amount_owed    <>    $card_type   <>   $reason_code   <>     $reason_descrip  <>   $fail_date   <>   $trans_title <> $phone<br><br>";
    
$message .=    "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$counter</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$contract_key</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$card_name</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$phone</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$credit_card_num</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$card_exp</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$card_type</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$amount_owed</b></font>
</td>
<td align=\"right\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$reason_code</b></font>
</td>
<td align=\"right\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$reason_descrip</b></font>
</td>
<td align=\"right\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$trans_title</b></font>
</td>
<td align=\"right\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$fail_date</b></font>
</td>
</tr>\n";
    
  /*  
    $message .= "<tr><td> <Center><strong> Contract Key:    </strong> " .  $contract_key ."</td></tr>";
    $message .= "<tr><td> <Center><strong> Name:    </strong> " .  $card_name ."</td></tr>";
    
    $message .= "<tr><td> <Center><strong> Credit Card:    </strong> " .  $credit_card_num ."</td></tr>";
    $message .= "<tr><td> <Center><strong> Card Exp:    </strong> " .  $card_exp ."</td></tr>";
    
    $message .= "<tr><td> <Center><strong> Amount Declined:    </strong> " .  $amount_owed ."</td></tr>";
    $message .= "<tr><td> <Center><strong> Card Type:    </strong> " .  $card_type ."</td></tr>";
    $message .= "<tr><td> <Center><strong> Reason Code:    </strong> " .  $reason_code ."</td></tr>";
    $message .= "<tr><td> <Center><strong> Reason:    </strong> " .  $reason_descrip ."</td></tr>";
    $message .= "<tr><td> <Center><strong> Date:    </strong> " .  $fail_date ."</td></tr>";
    $message .= "<tr><td> <Center><strong> Payment Description:    </strong> " .  $trans_title ."</td></tr>";
    $message .= "<tr><td> <Center><strong> Phone Number:    </strong> " .  $phone ."</td></tr>";
    */
    
$counter++;
}
$message .= "<br><p class=\"bbackheader\"><Center><H1><strong>Total Accepted: </strong> $" .  $total ."</Center></H1></p>";
$message .=  "</table>
</head>
</html>";

$headers  = "From: ClubManagerPro@bac.com\r\n";
$headers .= "Content-type: text/html\r\n";   
$message = wordwrap($message, 70, "\r\n");
mail('christopherparello@gmail.com', 'Collections Accepted', $message,$headers);
mail('sandi@burbankathleticclub.com', 'Collections Accepted', $message,$headers);
mail('greg@burbankathleticclub.com', 'Collections Accepted', $message,$headers);



$message = "<!DOCTYPE html PUBLIC \"\-//W3C//DTD XHTML 1.0 Transitional//EN\"\ \"\http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"\>
<html xmlns=\"\http://www.w3.org/1999/xhtml\"\>
 <head>
  <meta http-equiv=\"\\Content-Type\"\ content=\"\text/html; charset=UTF-8\"\ />";
//echo "Contract_key  <>    Credit_card   <>  Exp   <>    Name   <>    Amount   <>  Card_type    <>   Reason_code  <>   Reason_descrip   <>   Fail_date   <>     Trans_title<br>";
$message .= "<p class=\"bbackheader\"><Center><H1><strong>Club Manager Pro</strong></Center></H1></p>";
$message .= "<p class=\"bbackheader\"><Center><H1><strong>Collections: Good Cards that Declined</strong></Center></H1></p><br><br>";
$message .=" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract Key</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Name</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Phone</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">CC Num</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">CC Exp</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Card Type</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Amount</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Reason Code</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Reason Description</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Transaction Title</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Fail Date</font></th>
  </tr>\n"; 

$counter = 1;
$total = 0;
$stmt = $dbMain->prepare("SELECT contract_key, credit_card_num, card_exp, card_name, amount_owed, card_type, reason_code, reason_descrip, fail_date, trans_title, phone FROM collections_good_cards WHERE contract_key != '' AND fail_date = '$year[1]-$month[1]-$day[1]'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($contract_key,$credit_card_num,$card_exp,$card_name,$amount_owed,$card_type,$reason_code,$reason_descrip,$fail_date,$trans_title,$phone);   
while($stmt->fetch()){
    $total += $amount_owed;
    //echo "$contract_key  <>   $credit_card_num   <>     $card_exp   <>    $card_name   <>   $amount_owed    <>    $card_type   <>   $reason_code   <>     $reason_descrip  <>   $fail_date   <>   $trans_title <> $phone<br><br>";
    
$message .=    "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$counter</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$contract_key</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$card_name</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$phone</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$credit_card_num</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$card_exp</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$card_type</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$amount_owed</b></font>
</td>
<td align=\"right\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$reason_code</b></font>
</td>
<td align=\"right\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$reason_descrip</b></font>
</td>
<td align=\"right\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$trans_title</b></font>
</td>
<td align=\"right\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$fail_date</b></font>
</td>
</tr>\n";
    
  /*  
    $message .= "<tr><td> <Center><strong> Contract Key:    </strong> " .  $contract_key ."</td></tr>";
    $message .= "<tr><td> <Center><strong> Name:    </strong> " .  $card_name ."</td></tr>";
    
    $message .= "<tr><td> <Center><strong> Credit Card:    </strong> " .  $credit_card_num ."</td></tr>";
    $message .= "<tr><td> <Center><strong> Card Exp:    </strong> " .  $card_exp ."</td></tr>";
    
    $message .= "<tr><td> <Center><strong> Amount Declined:    </strong> " .  $amount_owed ."</td></tr>";
    $message .= "<tr><td> <Center><strong> Card Type:    </strong> " .  $card_type ."</td></tr>";
    $message .= "<tr><td> <Center><strong> Reason Code:    </strong> " .  $reason_code ."</td></tr>";
    $message .= "<tr><td> <Center><strong> Reason:    </strong> " .  $reason_descrip ."</td></tr>";
    $message .= "<tr><td> <Center><strong> Date:    </strong> " .  $fail_date ."</td></tr>";
    $message .= "<tr><td> <Center><strong> Payment Description:    </strong> " .  $trans_title ."</td></tr>";
    $message .= "<tr><td> <Center><strong> Phone Number:    </strong> " .  $phone ."</td></tr>";
    */
    
$counter++;
}
$message .= "<br><p class=\"bbackheader\"><Center><H1><strong>Total Declined: </strong> $" .  $total ."</Center></H1></p>";
$message .=  "</table>
</head>
</html>";

$headers  = "From: ClubManagerPro@bac.com\r\n";
$headers .= "Content-type: text/html\r\n";   
$message = wordwrap($message, 70, "\r\n");
mail('christopherparello@gmail.com', 'Collections Good Cards', $message,$headers);
mail('sandi@burbankathleticclub.com', 'Collections Good Cards', $message,$headers);
mail('greg@burbankathleticclub.com', 'Collections Good Cards', $message,$headers);




$message = "<!DOCTYPE html PUBLIC \"\-//W3C//DTD XHTML 1.0 Transitional//EN\"\ \"\http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"\>
<html xmlns=\"\http://www.w3.org/1999/xhtml\"\>
 <head>
  <meta http-equiv=\"\\Content-Type\"\ content=\"\text/html; charset=UTF-8\"\ />";
//echo "Contract_key  <>    Credit_card   <>  Exp   <>    Name   <>    Amount   <>  Card_type    <>   Reason_code  <>   Reason_descrip   <>   Fail_date   <>     Trans_title<br>";
$message .= "<p class=\"bbackheader\"><Center><H1><strong>Club Manager Pro</strong></Center></H1></p>";
$message .= "<p class=\"bbackheader\"><Center><H1><strong>Collections: Bad Cards that Declined</strong></Center></H1></p><br><br>";
$message .= "<p class=\"bbackheader\"><Center><H3><strong>These subscriptions have been canceled to cut down on rebilling charges.</strong></Center></H3></p><br><br>";
$message .=" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract Key</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Name</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Phone</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">CC Num</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">CC Exp</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Card Type</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Amount</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Reason Code</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Reason Description</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Transaction Title</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Fail Date</font></th>
  </tr>\n"; 

$counter = 1;
$total = 0;
$stmt = $dbMain->prepare("SELECT contract_key, credit_card_num, card_exp, card_name, amount_owed, card_type, reason_code, reason_descrip, fail_date, trans_title, phone FROM collections_bad_cards WHERE contract_key != '' AND fail_date = '$year[1]-$month[1]-$day[1]'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($contract_key,$credit_card_num,$card_exp,$card_name,$amount_owed,$card_type,$reason_code,$reason_descrip,$fail_date,$trans_title,$phone);   
while($stmt->fetch()){
    $total += $amount_owed;
    //echo "$contract_key  <>   $credit_card_num   <>     $card_exp   <>    $card_name   <>   $amount_owed    <>    $card_type   <>   $reason_code   <>     $reason_descrip  <>   $fail_date   <>   $trans_title <> $phone<br><br>";
    
$message .=    "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$counter</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$contract_key</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$card_name</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$phone</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$credit_card_num</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$card_exp</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$card_type</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$amount_owed</b></font>
</td>
<td align=\"right\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$reason_code</b></font>
</td>
<td align=\"right\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$reason_descrip</b></font>
</td>
<td align=\"right\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$trans_title</b></font>
</td>
<td align=\"right\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$fail_date</b></font>
</td>
</tr>\n";
    
 
$counter++;
}
$message .= "<br><p class=\"bbackheader\"><Center><H1><strong>Total Declined: </strong> $" .  $total ."</Center></H1></p>";
$message .=  "</table>
</head>
</html>";

$headers  = "From: ClubManagerPro@bac.com\r\n";
$headers .= "Content-type: text/html\r\n";   
$message = wordwrap($message, 70, "\r\n");
mail('christopherparello@gmail.com', 'Collections Bad Cards', $message,$headers);
mail('sandi@burbankathleticclub.com', 'Collections Bad Cards', $message,$headers);
mail('greg@burbankathleticclub.com', 'Collections Bad Cards', $message,$headers);


$message = "<!DOCTYPE html PUBLIC \"\-//W3C//DTD XHTML 1.0 Transitional//EN\"\ \"\http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"\>
<html xmlns=\"\http://www.w3.org/1999/xhtml\"\>
 <head>
  <meta http-equiv=\"\\Content-Type\"\ content=\"\text/html; charset=UTF-8\"\ />";

$text = "Declines

You have the option of settling all transactions that fail. You can call the bank and receive a verbal authorization from the bank.

You can:

    capture it by clicking on the specific transaction.
    settle it by entering the authorization code.

NOTE: If you do not have your Merchant ID# or your Amex/Discover MID# (supplied on your bank statements), please contact chargemit-help@mit.edu.

To retrieve a verbal authorization, you will need to contact the Verbal authorization line for Visa and Mastercard or Amex, Discover; and you must have the following information available.

MasterCard and Visa
800-944-1111
Bank#: 036600
Merchant ID#:
Customer's Credit Card #:

American Express
800-528-2121
American Express SE(MID)#:
Merchant ID#:
Customer's Credit Card #:

Discover
800-347-1111
Discover SE (MID)#:
Merchant ID#:
Customer's Credit Card #: ";   

$message .= "$text";

// In case any of our lines are larger than 70 characters, we should use wordwrap()
//$message = wordwrap($message, 70, "\r\n");

// Send



//echo "Contract_key  <>    Credit_card   <>  Exp   <>    Name   <>    Amount   <>  Card_type    <>   Reason_code  <>   Reason_descrip   <>   Fail_date   <>     Trans_title<br>";
$message .= "<p class=\"bbackheader\"><Center><H1><strong>Club Manager Pro</strong></Center></H1></p>";
$message .= "<p class=\"bbackheader\"><Center><H1><strong>Collections: Cards that Need Approval</strong></Center></H1></p><br><br>";
$message .= "<p class=\"bbackheader\"><Center><H3><strong>These subscriptions have been canceled to cut down on rebilling charges.</strong></Center></H3></p><br><br>";
$message .=" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract Key</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Name</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Phone</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">CC Num</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">CC Exp</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Card Type</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Amount</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Reason Code</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Reason Description</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Transaction Title</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Fail Date</font></th>
  </tr>\n"; 

$counter = 1;
$total = 0;
$stmt = $dbMain->prepare("SELECT contract_key, credit_card_num, card_exp, card_name, amount_owed, card_type, reason_code, reason_descrip, fail_date, trans_title, phone FROM collections_cards_need_approval WHERE contract_key != '' AND fail_date = '$year[1]-$month[1]-$day[1]'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($contract_key,$credit_card_num,$card_exp,$card_name,$amount_owed,$card_type,$reason_code,$reason_descrip,$fail_date,$trans_title,$phone);   
while($stmt->fetch()){
    $total += $amount_owed;
    //echo "$contract_key  <>   $credit_card_num   <>     $card_exp   <>    $card_name   <>   $amount_owed    <>    $card_type   <>   $reason_code   <>     $reason_descrip  <>   $fail_date   <>   $trans_title <> $phone<br><br>";
    
$message .=    "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$counter</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$contract_key</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$card_name</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$phone</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$credit_card_num</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$card_exp</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$card_type</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$amount_owed</b></font>
</td>
<td align=\"right\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$reason_code</b></font>
</td>
<td align=\"right\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$reason_descrip</b></font>
</td>
<td align=\"right\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$trans_title</b></font>
</td>
<td align=\"right\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$fail_date</b></font>
</td>
</tr>\n";
    
 
    
$counter++;
}
$message .= "<br><p class=\"bbackheader\"><Center><H1><strong>Total Declined: </strong> $" .  $total ."</Center></H1></p>";
$message .=  "</table>
</head>
</html>";

$headers  = "From: ClubManagerPro@bac.com\r\n";
$headers .= "Content-type: text/html\r\n";   
$message = wordwrap($message, 70, "\r\n");
mail('christopherparello@gmail.com', 'Collections Cards Needing Approval', $message,$headers);
mail('sandi@burbankathleticclub.com', 'Collections Cards Needing Approval', $message,$headers);
mail('greg@burbankathleticclub.com', 'Collections Cards Needing Approval', $message,$headers);
}

//===========================================================================================================
}
//$update = new emailReport();
//$update->moveData();


?>