<?php
session_start();
//error_reporting(E_ALL);


//===============================================================================

class generateReport {
    
private $counter = 0;
private $month = null;
private $report = null;

function setMonth($month){
    $this->month = $month;
}
function setYear($year){
    $this->year = "20$year";
}
function setReport($report){
    $this->report = $report;
}                  
//connect to database
function dbConnect()   {
require"../dbConnect.php";
return $dbMain;
}
//=========================================================================================
function generateDates(){
    
    
    switch($this->month){
        case '01':
             $this->monthStart = date('Y-m-d H:i:s',mktime(0,0,0,01,01,$this->year));
             $this->monthEnd = date('Y-m-d H:i:s',mktime(23,59,59,01,31,$this->year));
        break;
        case '02':
             $this->monthStart = date('Y-m-d H:i:s',mktime(0,0,0,02,01,$this->year));
             $this->monthEnd = date('Y-m-d H:i:s',mktime(23,59,59,02,28,$this->year));
        break;
        case '03':
             $this->monthStart = date('Y-m-d H:i:s',mktime(0,0,0,03,01,$this->year));
             $this->monthEnd = date('Y-m-d H:i:s',mktime(23,59,59,03,31,$this->year));
        break;
        case '04':
             $this->monthStart = date('Y-m-d H:i:s',mktime(0,0,0,04,01,$this->year));
             $this->monthEnd = date('Y-m-d H:i:s',mktime(23,59,59,04,30,$this->year));
        break;
        case '05':
             $this->monthStart = date('Y-m-d H:i:s',mktime(0,0,0,05,01,$this->year));
             $this->monthEnd = date('Y-m-d H:i:s',mktime(23,59,59,05,31,$this->year));
        break;
        case '06':
             $this->monthStart = date('Y-m-d H:i:s',mktime(0,0,0,06,01,$this->year));
             $this->monthEnd = date('Y-m-d H:i:s',mktime(23,59,59,06,30,$this->year));
        break;
        case '07':
             $this->monthStart = date('Y-m-d H:i:s',mktime(0,0,0,07,01,$this->year));
             $this->monthEnd = date('Y-m-d H:i:s',mktime(23,59,59,07,31,$this->year));
        break;
        case '08':
             $this->monthStart = date('Y-m-d H:i:s',mktime(0,0,0,08,01,$this->year));
             $this->monthEnd = date('Y-m-d H:i:s',mktime(23,59,59,08,31,$this->year));
        break;
        case '09':
             $this->monthStart = date('Y-m-d H:i:s',mktime(0,0,0,09,01,$this->year));
             $this->monthEnd = date('Y-m-d H:i:s',mktime(23,59,59,09,30,$this->year));
        break;
        case '10':
             $this->monthStart = date('Y-m-d H:i:s',mktime(0,0,0,10,01,$this->year));
             $this->monthEnd = date('Y-m-d H:i:s',mktime(23,59,59,10,31,$this->year));
        break;
        case '11':
             $this->monthStart = date('Y-m-d H:i:s',mktime(0,0,0,11,01,$this->year));
             $this->monthEnd = date('Y-m-d H:i:s',mktime(23,59,59,11,30,$this->year));
        break;
        case '12':
             $this->monthStart = date('Y-m-d H:i:s',mktime(0,0,0,12,01,$this->year));
             $this->monthEnd = date('Y-m-d H:i:s',mktime(23,59,59,12,31,$this->year));
        break;
    }
}

//------------------------------------------------------------------------------------------
function loadBadListings() {
    
$reportDate = date('F',strtotime("$this->month/1/2014"));

$reportHeader = <<<REPORTHEADER
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<link rel="stylesheet" href="../css/printReport.css">
<script type="text/javascript" src="../scripts/printPage.js"></script>
<script type="text/javascript" src="../scripts/jqueryNew.js"></script>
<script type="text/javascript" src="../scripts/spamContactGuard2.js"></script>

<title>Bad Card Report</title>

</head>
<body>

<div id="logoDiv">
<a href="javascript: void(0)" onClick="printPage()"><img src="../images/contract_logo.png"  /></a>
</div>



<Center><H1><strong>Club Manager Pro</strong></Center></H1></Center>
<Center><H1><strong>Collections: Cards that Declined</strong></H1></Center>
<Center><H1><strong>Month: $reportDate</strong></H1></Center>



<div id="listings">
<table align="left" border="0" cellspacing="0" cellpadding="4" width=100%>


REPORTHEADER;

echo"$reportHeader";

 $dbMain = $this->dbconnect();
    
 

echo" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract Key</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Member Name</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Card Name</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Send SMS</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># SMS</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Primary Phone</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># Calls</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Send SMS</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># SMS</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Cell Phone</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># Calls</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Email Address</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># Emails</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">CC Num</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">CC Exp</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Amount</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Reason Code</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Reason Description</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Exact Code</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Exact Response</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Transaction Title</font></th>
  </tr>\n"; 

$counter = 1;
$total = 0;
$stmt = $dbMain->prepare("SELECT contract_key, response, response_message, exact_reponse, exact_code, billing_amount, payment_type FROM billing_scheduled_recuring_payments WHERE contract_key != '' AND cycle_start_month = '$this->month' AND cycle_start_year = '$this->year' AND (response != '302' AND response != '521' AND response != '000' AND response != '301' AND response != '902'  AND response != '100')");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($contract_key,$reason_code,$reason_descrip,$exact_response,$exact_code,$amount_owed, $payment_type);   
while($stmt->fetch()){
    
    $stmt99 = $dbMain->prepare("SELECT card_fname, card_lname, card_number, card_exp_date FROM credit_info WHERE contract_key = '$contract_key'");
    $stmt99->execute();      
    $stmt99->store_result();      
    $stmt99->bind_result($card_fname, $card_lname, $credit_card_num, $card_exp);   
    $stmt99->fetch();
    $stmt99->close();
    
    if ($card_fname == ""){
        $card_fname = "<font face=\"Arial\" size=\"1\" color=\"red\"><b>Need New CC #</b></font>";
    }
    
    $stmt99 = $dbMain->prepare("SELECT primary_phone, cell_phone, email, first_name, last_name FROM contract_info WHERE contract_key = '$contract_key'");
    $stmt99->execute();      
    $stmt99->store_result();      
    $stmt99->bind_result($primary_phone, $cell_phone, $email, $first_name, $last_name);   
    $stmt99->fetch();
    $stmt99->close();
    
    
            $this->reportType = "BL";
            $this->contractKey  = $contract_key;
            $stmt99 = $dbMain ->prepare("SELECT num_text_primary, num_calls_primary, num_text_cell, num_calls_cell, num_emails FROM account_phone_spam_check WHERE contract_key = '$contract_key' AND report_type = 'BL' AND month = '$this->month' AND year = '$this->year'");
            $stmt99->execute();      
            $stmt99->store_result();                       
            $stmt99->bind_result($this->pSmsAtt , $this->pCallAtt ,$this->cSmsAtt,  $this->cCallAtt  ,$this->emailAtt);
            $stmt99->fetch();
            $stmt99->close();   
            
            $stmt99 = $dbMain ->prepare("SELECT do_not_call_cell, do_not_call_home, do_not_email, do_not_text, do_not_mail, prefered_contact_method FROM contact_preferences WHERE contract_key = '$contract_key'");
             $stmt99->execute();      
             $stmt99->store_result();      
             $stmt99->bind_result($this->doNotCallCell, $this->doNotCallHome, $this->doNotEmail, $this->doNotText, $this->doNotMail, $this->preferedContactMethod);
             $stmt99->fetch();
             $stmt99->close();  
            
           
           if($this->pSmsAtt == ""){
                $this->pSmsAtt = 0;
            }
            if($this->pCallAtt == ""){
                $this->pCallAtt = 0;
            }
            if($this->cSmsAtt == ""){
                $this->cSmsAtt = 0;
            }
            if($this->cCallAtt == ""){
                $this->cCallAtt = 0;
            }
            if($this->emailAtt == ""){
                $this->emailAtt = 0;
                }                 
    
    switch($payment_type){
        case 'MS':
            $paymentText = "Monthly Payment";
        break;
        case 'EF':
            $paymentText = "Enhance Fee";
        break;
        case 'RF':
            $paymentText = "Guarantee Fee";
        break;
        case 'PD':
            $paymentText = "Past Due Payment";
        break;
    }
    
   
    
    $first_name = trim($first_name);
    
    if ($first_name != ""){ 
        
        $total += $amount_owed;
        //echo "$contract_key  <>   $credit_card_num   <>     $card_exp   <>    $card_name   <>   $amount_owed    <>    $card_type   <>   $reason_code   <>     $reason_descrip  <>   $fail_date   <>   $trans_title <> $phone<br><br>";
        $last4 = substr($credit_card_num,12,4);  
        $credit_card_num = "****-****-****-$last4";
        
          if($this->doNotCallCell == "Y"){
        $color = "red";
        $disabledCell = "<span class=\"c_call colorChange\">$cell_phone</span>";
    }else{
        $color = "black";
        $disabledCell = "<a class=\"c_call\" href=\"tel:$cell_phone\"><span id=\"c_phone\">$cell_phone</span></a>";
    }
    if($this->doNotCallHome == "Y"){
        $color = "red";
        $disabledHome = "<span class=\"p_call colorChange\">$primary_phone</span>";
    }else{
        $color = "black";
        $disabledHome = "<a class=\"p_call\" href=\"tel:$primary_phone\"><span id=\"p_phone\">$primary_phone</span></a>";
    }
    if($this->doNotText == "Y"){
        $color = "red";
        $disabledText1 = "<span class=\"p_sms colorChange\">SMS</span>";
        $disabledText2 = "<span class=\"c_sms colorChange\">SMS</span>";
    }else{
        $color = "black";
        $disabledText1 = "<a class=\"p_sms\">SMS</a>";
        $disabledText2 = "<a class=\"c_sms\">SMS</a>";
    }
    if($this->doNotEmail == "Y"){
        $color = "red";
        $disabledEmail = "<span class=\"email colorChange\">$email</span>";
    }else{
        $color = "black";
        $disabledEmail = "<a class=\"email\" href=\"mailto:$email\">$email</a>";
    }
  
        echo    "<tr>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b><b>$counter</b></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b><b><span id=\"contract_key\">$contract_key</span></b></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b><b><span id=\"name\">$first_name $last_Name</span></b></b></font>
            </td> 
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b>$card_fname&nbsp;$card_lname</b></font>
            </td>  
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"$color\"><b><b>$disabledText1</b></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b><b><span id=\"p_sms_attempts\">$this->pSmsAtt</span></b></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"$color\"><b><b>$disabledHome</b></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b><b><span id=\"p_call_attempts\">$this->pCallAtt</span></b></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"$color\"><b><b>$disabledText2</b></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b><b><span id=\"c_sms_attempts\">$this->cSmsAtt</span></b></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"$color\"><b><b>$disabledCell</b></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b><b><span id=\"c_call_attempts\">$this->cCallAtt</span></b></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"$color\"><b><b>$disabledEmail</b></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b><b><span id=\"email_attempts\">$this->emailAtt</span></b></b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b><span id=\"cardNum\">$credit_card_num</span></b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b><span id=\"cardExp\">$card_exp</span></b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"2\" color=\"red\"><b><span id=\"amountOwed\">$$amount_owed</span></b></font>
            </td>
            <td align=\"right\" valign =\"top\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b>$reason_code</b></font>
            </td>
            <td align=\"right\" valign =\"top\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b><span id=\"reasonDescrip\">$reason_descrip</span></b></font>
            </td>
            <td align=\"right\" valign =\"top\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b>$exact_code</b></font>
            </td>
            <td align=\"right\" valign =\"top\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b>$exact_response</b></font>
            </td>
            <td align=\"right\" valign =\"top\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b><span id=\"transTitle\">$paymentText</span></b></font>
            </td>
            <input type=\"hidden\" id=\"report_type\" value=\"$this->reportType\"/>
            <input type=\"hidden\" id=\"month\" value=\"$this->month\"/>
            <input type=\"hidden\" id=\"year\" value=\"$this->year\"/>
            </tr>\n";
    }

    
 
$counter++;
$primary_phone = "";
$cell_phone = "";
$email = "";
$contract_key = "";
$reason_code = "";
$reason_descrip = "";
$exact_response = "";
$exact_code = "";
$amount_owed = "";
$payment_type = "";
$card_fname = "";
$card_lname = "";
$credit_card_num = "";
$card_exp = "";
$first_name = ""; 
$last_name = "";
$this->pSmsAtt =0;
                  $this->pCallAtt =0;
                  $this->cSmsAtt=0;  
                  $this->cCallAtt=0;
                  $this->emailAtt=0;  
                  $contract_key = 0;   
                  $this->doNotCallCell = ""; 
                  $this->doNotCallHome = ""; 
                  $this->doNotEmail = ""; 
                  $this->doNotText = ""; 
                  $this->doNotMail = "";
                  $this->preferedContactMethod = "";    
}
$total = sprintf("%01.2f", $total);

echo "<tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total Declined:</font></th>
  </tr>";
echo "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$total</b></font>
</td>
</tr>";

echo  "</table>
</div>
</head>
</html>";


}
//------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------
function loadMissingListings() {
    
$reportDate = date('F',strtotime("$this->month/1/2014"));

$reportHeader = <<<REPORTHEADER
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<link rel="stylesheet" href="../css/printReport.css">
<script type="text/javascript" src="../scripts/printPage.js"></script>
<script type="text/javascript" src="../scripts/jqueryNew.js"></script>
<script type="text/javascript" src="../scripts/spamContactGuard2.js"></script>


<title>Bad Card Report</title>

</head>
<body>

<div id="logoDiv">
<a href="javascript: void(0)" onClick="printPage()"><img src="../images/contract_logo.png"  /></a>
</div>



<Center><H1><strong>Club Manager Pro</strong></Center></H1></Center>
<Center><H1><strong>Collections: Missing Cards</strong></H1></Center>
<Center><H1><strong>Month: $reportDate</strong></H1></Center>



<div id="listings">
<table align="left" border="0" cellspacing="0" cellpadding="4" width=100%>


REPORTHEADER;

echo"$reportHeader";

 $dbMain = $this->dbconnect();
    
 

echo" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract Key</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Member Name</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Send SMS</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># SMS</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Primary Phone</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># Calls</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Send SMS</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># SMS</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Cell Phone</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># Calls</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Email Address</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># Emails</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Amount</font></th>
  </tr>\n"; 

$counter = 1;
$total = 0;
$stmt = $dbMain->prepare("SELECT DISTINCT contract_key FROM billing_scheduled_recuring_payments WHERE exact_code = '22' AND cycle_start_month = '$this->month' AND cycle_start_year = '$this->year'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($contract_key);   
while($stmt->fetch()){
    
    $stmt99 = $dbMain->prepare("SELECT MAX(billing_amount) FROM billing_scheduled_recuring_payments WHERE contract_key = '$contract_key'");
    $stmt99->execute();      
    $stmt99->store_result();      
    $stmt99->bind_result($amount_owed);   
    $stmt99->fetch();
    $stmt99->close();
      
    $stmt99 = $dbMain->prepare("SELECT primary_phone, cell_phone, email, first_name, last_name FROM contract_info WHERE contract_key = '$contract_key'");
    $stmt99->execute();      
    $stmt99->store_result();      
    $stmt99->bind_result($primary_phone, $cell_phone, $email, $first_name, $last_name);   
    $stmt99->fetch();
    $stmt99->close();
    
    $this->reportType = "ML";
            $this->contractKey  = $contract_key;
            $stmt99 = $dbMain ->prepare("SELECT num_text_primary, num_calls_primary, num_text_cell, num_calls_cell, num_emails FROM account_phone_spam_check WHERE contract_key = '$contract_key' AND report_type = 'ML' AND month = '$this->month' AND year = '$this->year'");
            $stmt99->execute();      
            $stmt99->store_result();                       
            $stmt99->bind_result($this->pSmsAtt , $this->pCallAtt ,$this->cSmsAtt,  $this->cCallAtt  ,$this->emailAtt);
            $stmt99->fetch();
            $stmt99->close();   
            
            $stmt99 = $dbMain ->prepare("SELECT do_not_call_cell, do_not_call_home, do_not_email, do_not_text, do_not_mail, prefered_contact_method FROM contact_preferences WHERE contract_key = '$contract_key'");
             $stmt99->execute();      
             $stmt99->store_result();      
             $stmt99->bind_result($this->doNotCallCell, $this->doNotCallHome, $this->doNotEmail, $this->doNotText, $this->doNotMail, $this->preferedContactMethod);
             $stmt99->fetch();
             $stmt99->close();  
            
           
           if($this->pSmsAtt == ""){
                $this->pSmsAtt = 0;
            }
            if($this->pCallAtt == ""){
                $this->pCallAtt = 0;
            }
            if($this->cSmsAtt == ""){
                $this->cSmsAtt = 0;
            }
            if($this->cCallAtt == ""){
                $this->cCallAtt = 0;
            }
            if($this->emailAtt == ""){
                $this->emailAtt = 0;
                }                 
    
    switch($payment_type){
        case 'MS':
            $paymentText = "Monthly Payment";
        break;
        case 'EF':
            $paymentText = "Enhance Fee";
        break;
        case 'RF':
            $paymentText = "Guarantee Fee";
        break;
        case 'PD':
            $paymentText = "Past Due Payment";
        break;
    }
    
   
    
    $first_name = trim($first_name);
    
    if ($first_name != ""){ 
        
        $total += $amount_owed;
        //echo "$contract_key  <>   $credit_card_num   <>     $card_exp   <>    $card_name   <>   $amount_owed    <>    $card_type   <>   $reason_code   <>     $reason_descrip  <>   $fail_date   <>   $trans_title <> $phone<br><br>";
        $last4 = substr($credit_card_num,12,4);  
        $credit_card_num = "****-****-****-$last4";
        
        
           if($this->doNotCallCell == "Y"){
        $color = "red";
        $disabledCell = "<span class=\"c_call colorChange\">$cell_phone</span>";
    }else{
        $color = "black";
        $disabledCell = "<a class=\"c_call\" href=\"tel:$cell_phone\"><span id=\"c_phone\">$cell_phone</span></a>";
    }
    if($this->doNotCallHome == "Y"){
        $color = "red";
        $disabledHome = "<span class=\"p_call colorChange\">$primary_phone</span>";
    }else{
        $color = "black";
        $disabledHome = "<a class=\"p_call\" href=\"tel:$primary_phone\"><span id=\"p_phone\">$primary_phone</span></a>";
    }
    if($this->doNotText == "Y"){
        $color = "red";
        $disabledText1 = "<span class=\"p_sms colorChange\">SMS</span>";
        $disabledText2 = "<span class=\"c_sms colorChange\">SMS</span>";
    }else{
        $color = "black";
        $disabledText1 = "<a class=\"p_sms\">SMS</a>";
        $disabledText2 = "<a class=\"c_sms\">SMS</a>";
    }
    if($this->doNotEmail == "Y"){
        $color = "red";
        $disabledEmail = "<span class=\"email colorChange\">$email</span>";
    }else{
        $color = "black";
        $disabledEmail = "<a class=\"email\" href=\"mailto:$email\">$email</a>";
    }
  
       
            
            
        echo    "<tr>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b><b>$counter</b></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b><b><span id=\"contract_key\">$contract_key</span></b></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b><b><span id=\"name\">$first_name $last_Name</span></b></b></font>
            </td> 
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"$color\"><b><b>$disabledText1</b></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b><b><span id=\"p_sms_attempts\">$this->pSmsAtt</span></b></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"$color\"><b><b>$disabledHome</b></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b><b><span id=\"p_call_attempts\">$this->pCallAtt</span></b></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"$color\"><b><b>$disabledText2</b></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b><b><span id=\"c_sms_attempts\">$this->cSmsAtt</span></b></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"$color\"><b><b>$disabledCell</b></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b><b><span id=\"c_call_attempts\">$this->cCallAtt</span></b></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"$color\"><b><b>$disabledEmail</b></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
            <font face=\"Arial\" size=\"2\" color=\"black\"><b><b><span id=\"email_attempts\">$this->emailAtt</span></b></b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"2\" color=\"red\"><b>$<span id=\"amount_owed\">$amount_owed</span></b></font>
            </td>
            <input type=\"hidden\" id=\"report_type\" value=\"$this->reportType\"/>
            <input type=\"hidden\" id=\"month\" value=\"$this->month\"/>
            <input type=\"hidden\" id=\"year\" value=\"$this->year\"/>
            </tr>\n";
    }

    
 
$counter++;
$primary_phone = "";
$cell_phone = "";
$email = "";
$contract_key = "";
$reason_code = "";
$reason_descrip = "";
$exact_response = "";
$exact_code = "";
$amount_owed = "";
$payment_type = "";
$card_fname = "";
$card_lname = "";
$credit_card_num = "";
$card_exp = "";
$first_name = ""; 
$last_name = "";
$this->pSmsAtt =0;
                  $this->pCallAtt =0;
                  $this->cSmsAtt=0;  
                  $this->cCallAtt=0;
                  $this->emailAtt=0;  
                  $contract_key = 0;   
                  $this->doNotCallCell = ""; 
                  $this->doNotCallHome = ""; 
                  $this->doNotEmail = ""; 
                  $this->doNotText = ""; 
                  $this->doNotMail = "";
                  $this->preferedContactMethod = "";    
}
$total = sprintf("%01.2f", $total);

echo "<tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total Declined:</font></th>
  </tr>";
echo "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$total</b></font>
</td>
</tr>";

echo  "</table>
</div>
</head>
</html>";


}
//------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------
function loadCollectionsStillOwed() {
    
$reportDate = date('F',strtotime("$this->month/1/2014"));

$reportHeader = <<<REPORTHEADER
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<link rel="stylesheet" href="../css/printReport.css">
<script type="text/javascript" src="../scripts/printPage.js"></script>
<script type="text/javascript" src="../scripts/jqueryNew.js"></script>
<script type="text/javascript" src="../scripts/spamContactGuard2.js"></script>


<title>Bad Card Report</title>

</head>
<body>

<div id="logoDiv">
<a href="javascript: void(0)" onClick="printPage()"><img src="../images/contract_logo.png"  /></a>
</div>



<Center><H1><strong>Club Manager Pro</strong></Center></H1></Center>
<Center><H1><strong>Collections: Outstanding Balances</strong></H1></Center>
<Center><H1><strong>Month: $reportDate</strong></H1></Center>



<div id="listings">
<table align="left" border="0" cellspacing="0" cellpadding="4" width=100%>


REPORTHEADER;

echo"$reportHeader";

 $dbMain = $this->dbconnect();
    
 

echo" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract Key</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Member Name</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Send SMS</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># SMS</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Primary Phone</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># Calls</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Send SMS</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># SMS</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Cell Phone</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># Calls</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Email Address</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># Emails</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Card Name</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">CC Num</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">CC Exp</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Amount</font></th>
  </tr>\n"; 

$counter = 1;
$total = 0;
$stmt = $dbMain->prepare("SELECT DISTINCT contract_key FROM billing_scheduled_recuring_payments WHERE outstanding_balance = 'Y' AND cycle_start_month = '$this->month' AND cycle_start_year = '$this->year' AND exact_code != '22'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($contract_key);   
while($stmt->fetch()){
    
    $stmt99 = $dbMain->prepare("SELECT MAX(billing_amount) FROM billing_scheduled_recuring_payments WHERE contract_key = '$contract_key'");
    $stmt99->execute();      
    $stmt99->store_result();      
    $stmt99->bind_result($amount_owed);   
    $stmt99->fetch();
    $stmt99->close();
    
    $stmt99 = $dbMain->prepare("SELECT card_fname, card_lname, card_number, card_exp_date FROM credit_info WHERE contract_key = '$contract_key'");
    $stmt99->execute();      
    $stmt99->store_result();      
    $stmt99->bind_result($card_fname, $card_lname, $credit_card_num, $card_exp);   
    $stmt99->fetch();
    $stmt99->close();
      
    $stmt99 = $dbMain->prepare("SELECT primary_phone, cell_phone, email, first_name, last_name FROM contract_info WHERE contract_key = '$contract_key'");
    $stmt99->execute();      
    $stmt99->store_result();      
    $stmt99->bind_result($primary_phone, $cell_phone, $email, $first_name, $last_name);   
    $stmt99->fetch();
    $stmt99->close();
    
   $this->reportType = "OC";
            $this->contractKey  = $contract_key;
            $stmt99 = $dbMain ->prepare("SELECT num_text_primary, num_calls_primary, num_text_cell, num_calls_cell, num_emails FROM account_phone_spam_check WHERE contract_key = '$contract_key' AND report_type = 'OC' AND month = '$this->month' AND year = '$this->year'");
            $stmt99->execute();      
            $stmt99->store_result();                       
            $stmt99->bind_result($this->pSmsAtt , $this->pCallAtt ,$this->cSmsAtt,  $this->cCallAtt  ,$this->emailAtt);
            $stmt99->fetch();
            $stmt99->close();   
            
            $stmt99 = $dbMain ->prepare("SELECT do_not_call_cell, do_not_call_home, do_not_email, do_not_text, do_not_mail, prefered_contact_method FROM contact_preferences WHERE contract_key = '$contract_key'");
             $stmt99->execute();      
             $stmt99->store_result();      
             $stmt99->bind_result($this->doNotCallCell, $this->doNotCallHome, $this->doNotEmail, $this->doNotText, $this->doNotMail, $this->preferedContactMethod);
             $stmt99->fetch();
             $stmt99->close();  
            
           
           if($this->pSmsAtt == ""){
                $this->pSmsAtt = 0;
            }
            if($this->pCallAtt == ""){
                $this->pCallAtt = 0;
            }
            if($this->cSmsAtt == ""){
                $this->cSmsAtt = 0;
            }
            if($this->cCallAtt == ""){
                $this->cCallAtt = 0;
            }
            if($this->emailAtt == ""){
                $this->emailAtt = 0;
                }                 
                
   $card_exp = date('m-y',strtotime($card_exp));
    
    $first_name = trim($first_name);
    
    if ($first_name != ""){ 
        
        $total += $amount_owed;
        //echo "$contract_key  <>   $credit_card_num   <>     $card_exp   <>    $card_name   <>   $amount_owed    <>    $card_type   <>   $reason_code   <>     $reason_descrip  <>   $fail_date   <>   $trans_title <> $phone<br><br>";
        //$last4 = substr($credit_card_num,12,4);  
        //$credit_card_num = "****-****-****-$last4";
        
        echo    "<tr>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$counter</b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$contract_key</b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$first_name&nbsp; $last_name</b></font>
            </td> 
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b><a href=\"tel:$primary_phone\">$primary_phone</a></b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b><a href=\"tel:$cell_phone\">$cell_phone</a></b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b><a href=\"mailto:$email\">$email</a></b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$card_fname&nbsp;$card_lname</b></font>
            </td>  
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$credit_card_num</b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$card_exp</b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"red\"><b>$$amount_owed</b></font>
            </td>
            </tr>\n";
    }

    
 
$counter++;
$primary_phone = "";
$cell_phone = "";
$email = "";
$contract_key = "";
$reason_code = "";
$reason_descrip = "";
$exact_response = "";
$exact_code = "";
$amount_owed = "";
$payment_type = "";
$card_fname = "";
$card_lname = "";
$credit_card_num = "";
$card_exp = "";
$first_name = ""; 
$last_name = "";
$this->pSmsAtt =0;
                  $this->pCallAtt =0;
                  $this->cSmsAtt=0;  
                  $this->cCallAtt=0;
                  $this->emailAtt=0;  
                  $contract_key = 0;   
                  $this->doNotCallCell = ""; 
                  $this->doNotCallHome = ""; 
                  $this->doNotEmail = ""; 
                  $this->doNotText = ""; 
                  $this->doNotMail = "";
                  $this->preferedContactMethod = "";    
}
$total = sprintf("%01.2f", $total);

echo "<tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total Declined:</font></th>
  </tr>";
echo "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$total</b></font>
</td>
</tr>";

echo  "</table>
</div>
</head>
</html>";


}
//------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------
function loadBatchListings() {
    
    $dbMain = $this->dbconnect();
$reportDate = date('F',strtotime($this->monthStart));

$reportHeader = <<<REPORTHEADER
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" href="../css/printReport.css">
<script type="text/javascript" src="../scripts/printPage.js"></script>
</head>
<body>

<div id="logoDiv">
<a href="javascript: void(0)" onClick="printPage()"><img src="../images/contract_logo.png"  /></a>
</div>


<div id="reportName"> 
<span class="black5"><strong><H4><strong>Name of Report: Batch Reports  &nbsp; &nbsp;Club Manager Pro</strong></Center></H4></strong></span>
<span class="black6"><Center><H1><strong>Month: $reportDate</strong></Center></H1></span>
</div>


<div id="listings">
<table align="left" border="0" cellspacing="0" cellpadding="4" width=100%>



REPORTHEADER;

echo"$reportHeader";

 $dbMain = $this->dbconnect();
    
echo" <tr>
    <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Club</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Day</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Batch Type</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># Records</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># Success</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"># failed</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Percentage Collected</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Projected</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Projected CC</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Projected ACH</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Amount Colected</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Amount Colected CC</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Amount Colected ACH</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Failed Amount</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Failed Amount CC</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Failed Amount ACH</font></th>
  
  </tr>"; 
  
$dbMain = $this->dbconnect();
 $counter = 1;
$total = 0;
$stmt = $dbMain->prepare("SELECT club_id, number_attempted, number_success, number_failed, percentage_collected, projected, credit_total_projected, ach_total_projected, failed_amount, failed_amount_cc, failed_amount_ach, collected, collected_cc, collected_ach, batch_type, day FROM billing_monthly_batch_totals WHERE month = '$this->month' AND year = '$this->year' ORDER BY day ASC"); 
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($club_id, $number_attempted, $number_success, $number_failed, $percentage_collected, $projected, $credit_total_projected, $ach_total_projected, $failed_amount, $failed_amount_cc, $failed_amount_ach, $collected, $collected_cc, $collected_ach, $batch_type, $day);   
while($stmt->fetch()){ 
    
    $stmt11 = $dbMain->prepare("SELECT club_name FROM club_info  WHERE club_id = '$club_id'");//>=
    $stmt11->execute();  
    $stmt11->store_result();      
    $stmt11->bind_result($club_name); 
    $stmt11->fetch();
    $stmt11->close();
    
    switch($day){
        case'1':
            $numEnd = "st";
        break;
        case'2':
            $numEnd = "nd";
        break;
        case'3':
            $numEnd = "rd";
        break;
        default:
            $numEnd = "th";
        break;
    }
    $percentage_collected = $percentage_collected*100;
 
 switch($batch_type){
        case'EF':
            $batchText = "Enhance Fee";
        break;
        case'RF':
            $batchText = "Rate Gaurantee Fee";
        break;
        case'MS':
            $batchText = "Monthly Service";
        break;
        case'PD':
            $batchText = "Past Due Monthly Service";
        break;
    }
             echo    "<tr>
             <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$club_name</b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$day$numEnd</b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$batchText</b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$number_attempted</b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$number_success</b></font>
            </td>  
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$number_failed</b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$percentage_collected%</b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$$projected</b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$$credit_total_projected</b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$$ach_total_projected</b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"green\"><b>$$collected</b></font>
            </td>
            <td align=\"right\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"green\"><b>$$collected_cc</b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"green\"><b>$$collected_ach</b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"red\"><b>$$failed_amount</b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"red\"><b>$$failed_amount_cc</b></font>
            </td>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"red\"><b>$$failed_amount_ach</b></font>
            </td>
            </tr>";
            }
            
echo  "</table>
  </div>
</head>
</html>";


}
//------------------------------------------------------------------------------------------
function loadDashboardListings() {
    
  $reportDate = date('F',strtotime($this->monthStart));  

$reportHeader = <<<REPORTHEADER
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<link rel="stylesheet" href="../css/printReport.css">
<script type="text/javascript" src="../scripts/printPage.js"></script>

<title>Attendence Report</title>

</head>
<body>

<div id="logoDiv">
<a href="javascript: void(0)" onClick="printPage()"><img src="../images/contract_logo.png"  /></a>
</div>


<div id="reportName"> 
<span class="black5">Name of Report:</span>
&nbsp;
<span class="black6"><strong>Dashboard</strong></span>
<span class="black6"><Center><H1><strong>Month: $reportDate</strong></Center></H1></span>
</div>


<div id="listings">
<table align="left" border="0" cellspacing="0" cellpadding="4" width=100%>


REPORTHEADER;

echo"$reportHeader";

$spinMonthlyCount = 0;
$yogaMonthlyCount = 0;
$spinClassCount = 0;
$yogaClassCount = 0;
$newServiceCount = 0;
$renewalServiceCount = 0;
$upgradeServiceCount = 0;
$pastDueCcCount = 0;
$pastDueAchCount = 0;
$pastDueCashCount = 0;
$pastDueCheckCount = 0;
$monthlyServicePrePayCount = 0;
$serviceCancelFeeCount = 0;
$guarenteeFeeCCCount = 0;
$guarenteeFeeACHCount = 0;
$guarenteeFeeCashCount = 0;
$guarenteeFeeCheckCount = 0;
$monthlyDuesCashCount = 0;
$monthlyDuesCcCount = 0;
$monthlyDuesCheckCount = 0;
$monthlyDuesAchCount = 0;
$declinedRejectionFeeCount = 0;
$giftCertCount = 0;
$declinedSettledCashCount = 0;
$declinedSettledCheckCount = 0;
$declinedSettledAchCount = 0;
$declinedSettledCcCount = 0;
$pastDueSettledCount = 0;
$memberHoldFeeCount = 0;
$achRejectionFeeCount = 0;
$ccRejectionFeeCount = 0;
$checkRejectionFeeCount = 0;
$cashRejectionFeeCount = 0;
$monthlyDuesCcSettledCount = 0;
$monthlyDuesCashSettledCount = 0;
$monthlyDuesCheckSettledCount = 0;
$monthlyDuesAchSettledCount = 0;
$monthlyPaymentCount = 0;


$spinMonthlyTot = 0;
$yogaMonthlyTot = 0;
$spinClassTot = 0;
$yogaClassTot = 0;
$newServiceTot = 0;
$renewalServiceTot = 0;
$upgradeServiceTot = 0;
$pastDueCcTot = 0;
$pastDueAchTot = 0;
$pastDueCashTot = 0;
$pastDueCheckTot = 0;
$monthlyServicePrePayTot = 0;
$serviceCancelFeeTot = 0;
$guarenteeFeeCCTot = 0;
$guarenteeFeeACHTot = 0;
$guarenteeFeeCashTot = 0;
$guarenteeFeeCheckTot = 0;
$monthlyDuesCashTot = 0;
$monthlyDuesCcTot = 0;
$monthlyDuesCheckTot = 0;
$monthlyDuesAchTot = 0;
$declinedRejectionFeeTot = 0;
$giftCertTot = 0;
$declinedSettledCashTot = 0;
$declinedSettledCheckTot = 0;
$declinedSettledAchTot = 0;
$declinedSettledCcTot = 0;
$pastDueSettledTot = 0;
$memberHoldFeeTot = 0;
$achRejectionFeeTot = 0;
$ccRejectionFeeTot = 0;
$checkRejectionFeeTot = 0;
$cashRejectionFeeTot = 0;
$monthlyDuesCcSettledTot = 0;
$monthlyDuesCashSettledTot = 0;
$monthlyDuesCheckSettledTot = 0;
$monthlyDuesAchSettledTot = 0;
$monthlyPaymentTot = 0;


//echo "$monthStart $monthEnd";
$dbMain = $this->dbconnect();
$stmt = $dbMain->prepare("SELECT payment_amount, payment_description  FROM payment_history WHERE (payment_date BETWEEN '$this->monthStart' AND '$this->monthEnd') AND (payment_flag = 'PF' OR payment_flag = 'BD')");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($payment_amount, $payment_description);
while($stmt->fetch()){
    //echo"$payment_description $payment_amount<br>";
    switch($payment_description){
        case 'Spin Monthly Payment':
            $spinMonthlyCount++;
            $spinMonthlyTot += $payment_amount;
        break;
        case 'Yoga Monthly Payment':
            $yogaMonthlyCount++;
            $yogaMonthlyTot += $payment_amount;
        break;
        case 'Spin Class':
            $spinClassCount++;
            $spinClassTot += $payment_amount;
        break;
        case 'Yoga Class':
            $yogaClassCount++;
            $yogaClassTot += $payment_amount;
        break;
        case 'New Service':
            $newServiceCount++;
            $newServiceTot += $payment_amount;
        break;
        case 'PIF Membership'://
            $newServiceCount++;
            $newServiceTot += $payment_amount;
        break;
        case 'Service Renewal':
            $renewalServiceCount++;
            $renewalServiceTot += $payment_amount;
        break;
        case 'Service Upgrade':
            $upgradeServiceCount++;
            $upgradeServiceTot += $payment_amount;
                
        break;
        case 'Past Due CC':
            $pastDueCcCount++;
            $pastDueCcTot += $payment_amount;
        break;
        case 'Past Due Cash':
            
            $pastDueCashCount++;
            $pastDueCashTot += $payment_amount;
        break;
        case 'Past Due Check':
            $pastDueCheckCount++;
            $pastDueCheckTot += $payment_amount;
        break;
        case 'Past Due ACH':
            $pastDueAchCount++;
            $pastDueAchTot += $payment_amount;
        break;
        case 'Monthly Service Prepaid':
            $monthlyServicePrePayCount++;
            $monthlyServicePrePayTot += $payment_amount;
        break;
        case 'Service Cancel Fee':
            $serviceCancelFeeCount++;
            $serviceCancelFeeTot += $payment_amount;
        break;
        case 'Guarantee Fee CC':
            $guarenteeFeeCCCount++;
            $guarenteeFeeCCTot += $payment_amount;
        break;
        case 'Guarantee Fee ACH':
            $guarenteeFeeACHCount++;
            $guarenteeFeeACHTot += $payment_amount;
        break;
        case 'Guarantee Fee Cash':
            $guarenteeFeeCashCount++;
            $guarenteeFeeCashTot += $payment_amount;
        break;
        case 'Guarantee Fee Check':
            $guarenteeFeeCheckCount++;
            $monthlyDuesCheckTot += $payment_amount;
        break;
        case 'Monthly Dues Cash':
            $monthlyDuesCashCount++;
            $monthlyDuesCashTot += $payment_amount;
        break;
        case 'Monthly Dues CC'://
            $monthlyDuesCcCount++;
            $monthlyDuesCcTot += $payment_amount;
        break;
        case 'EFT Credit'://
            $monthlyDuesCcCount++;
            $monthlyDuesCcTot += $payment_amount;
        break;
        case 'Monthly Dues Check':
            $monthlyDuesCheckCount++;
            $monthlyDuesCheckTot += $payment_amount;
        break;
        case 'Monthly Dues ACH':
            $monthlyDuesAchCount++;
            $monthlyDuesAchTot += $payment_amount;
        break;
        case 'Monthly Payment':
            $monthlyPaymentCount++;
            $monthlyPaymentTot += $payment_amount;
        break;
        case 'Declined Rejection Fee':
            $declinedRejectionFeeCount++;
            $declinedRejectionFeeTot += $payment_amount;
        break;
        case 'Gift Certificate':
            $giftCertCount++;
            $giftCertTot += $payment_amount;
        break;
        case 'Declined Settled Cash':
            $declinedSettledCashCount++;
            $declinedSettledCashTot += $payment_amount;
        break;
         case 'Declined Settled Check':
            $declinedSettledCheckCount++;
            $declinedSettledCheckTot += $payment_amount;
        break;
         case 'Declined Settled CC':
            $declinedSettledCcCount++;
            $declinedSettledCcTot += $payment_amount;
        break;
         case 'Declined Settled ACH':
            $declinedSettledAchCount++;
            $declinedSettledAchTot += $payment_amount;
        break;
        case 'Past Due Settled':
            $pastDueSettledCount++;
            $pastDueSettledTot += $payment_amount;
        break;
        case 'Member Hold Fee':
            $memberHoldFeeCount++;
            $memberHoldFeeTot += $payment_amount;
        break;
        case 'Monthly Dues CC Settled':
            $declinedSettledCcCount++;
            $declinedSettledCcTot += $payment_amount;
        break;
        case 'Monthly Dues ACH Settled':
            $declinedSettledAchCount++;
            $declinedSettledAchTot += $payment_amount;
        break;
        case 'Monthly Dues Cash Settled':
            $declinedSettledCashCount++;
            $declinedSettledCashTot += $payment_amount;
        break;
        case 'Monthly Dues Check Settled':
            $declinedSettledCheckCount++;
            $declinedSettledCheckTot += $payment_amount;
        break;
        case 'CC Rejection Fee':
            $ccRejectionFeeCount++;
            $ccRejectionFeeTot += $payment_amount;
        break;
        case 'ACH Rejection Fee':
            $achRejectionFeeCount++;
            $achRejectionFeeTot += $payment_amount;
        break;
        case 'Check Rejection Fee':
            $checkRejectionFeeCount++;
            $checkRejectionFeeTot  += $payment_amount;
        break;
        case 'Cash Rejection Fee':
            $cashRejectionFeeCountt++;
            $cashRejectionFeeTot += $payment_amount;
        break;
    }
    
}
$stmt->close();
//$weekStart = date('m-d-Y',strtotime("last saturday"));
//$todaysDate = date('m-d-Y',strtotime('yesterday'));


$totalSales = $newServiceTot + $renewalServiceTot + $upgradeServiceTot;
$totalCount = $newServiceCount + $renewalServiceCount + $upgradeServiceCount;

$start = date('F d Y',strtotime($this->monthStart));
$end = date('F d Y',strtotime($this->monthEnd));

echo "<tr><Center><H1><strong>Club Manager Pro</strong></Center></H1></tr>";
echo "<tr><Center><H1><strong>Monthly Dashboard Report:</strong></Center></H1></tr>";
echo "<tr> <Center><strong>Date:</strong>  $start <strong>   to   </strong>  $end </Center></tr>";
echo "";
   
   
   echo" <tr>
        <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Sales Numbers:</font></th>
  </tr>";
   
    echo" <tr>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total Sales Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total Sales</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">New Services Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">New Services</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Renewals Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Renewals</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Upgrades Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Upgrades</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Cancellations Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Cancellations</font></th>
  </tr>";
  
  
    
    echo    "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"green\"><b>$totalCount</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"green\"><b>$$totalSales</b></font>
</td>  
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"green\"><b>$newServiceCount</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"green\"><b>$$newServiceTot</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"green\"><b>$renewalServiceCount</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"green\"><b>$$renewalServiceTot</b></font>
</td>  
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$upgradeServiceCount</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"green\"><b>$$upgradeServiceTot</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"red\"><b>$serviceCancelFeeCount</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"red\"><b>$$serviceCancelFeeTot</b></font>
</td>
</tr>";

echo" <tr>
  
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Gift Certificates Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Gift Certificates</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Spinning Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Spinning</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Yoga Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Yoga</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Spin Class Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Spin Class</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Yoga Class Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Yoga Class</font></th>
  </tr>"; 

echo    "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"green\"><b>$giftCertCount</b></font>
</td>  
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"green\"><b>$$giftCertTot</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"green\"><b>$spinMonthlyCount</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"green\"><b>$$spinMonthlyTot</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"green\"><b>$yogaMonthlyCount</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"green\"><b>$$yogaMonthlyTot</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"green\"><b>$spinClassCount</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"green\"><b>$$spinClassTot</b></font>
</td>  
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"green\"><b>$yogaClassCount</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"green\"><b>$$yogaClassTot</b></font>
</td>
</tr>";


    echo" <tr>
        <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Fees Collected:</font></th>
  </tr>";
   
    echo" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Rejection Fee Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Rejection Fee</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Member Hold Fee Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Member Hold Fee</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">ACH Rejection Fee Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">ACH Rejection Fee</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">CC Rejection Fee Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">CC Rejection Fee</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Check Rejection Fee Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Check Rejection Fee</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Cash Rejection Fee Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Cash Rejection Fee</font></th>
  
  </tr>"; 
    
    echo    "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$declinedRejectionFeeCount</b></font>
</td> 
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$declinedRejectionFeeTot</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$memberHoldFeeCount</b></font>
</td> 
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$memberHoldFeeTot</b></font>
</td>  
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$achRejectionFeeCount</b></font>
</td> 
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$achRejectionFeeTot</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$ccRejectionFeeCount</b></font>
</td> 
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$ccRejectionFeeTot</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$checkRejectionFeeCount</b></font>
</td> 
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$checkRejectionFeeTot</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$cashRejectionFeeCount</b></font>
</td> 
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$cashRejectionFeeTot</b></font>
</td>  
</tr>";


 echo" <tr>
        <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Recurring Billing:</font></th>
  </tr>";
  
   echo" <tr>
        <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Rate Fee:</font></th>
  </tr>";
  

 echo" <tr>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Guarentee Fee CC Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Guarentee Fee CC</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Guarentee Fee ACH Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Guarentee Fee ACH</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Guarentee Fee Check Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Guarentee Fee Check</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Guarentee Fee Cash Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Guarentee Fee Cash</font></th>
  </tr>"; 
    
    echo    "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$guarenteeFeeCCCount</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$guarenteeFeeCCTot</b></font>
</td>  
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$guarenteeFeeACHCount</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$guarenteeFeeACHTot</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$guarenteeFeeCheckCount</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$monthlyDuesCheckTot</b></font>
</td>  
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$guarenteeFeeCashCount</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$monthlyDuesCashTot</b></font>
</td>
</tr>";

 echo" <tr>
        <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\"> Monthly Dues: </font></th>
  </tr>";


echo" <tr>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Dues CC Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Dues CC</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Dues ACH Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Dues ACH</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Dues Check Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Dues Check</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Dues Cash Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Dues Cash</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Prepaid Dues Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Prepaid Dues</font></th>
  </tr>"; 
    
    echo    "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$guarenteeFeeCCCount</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$monthlyDuesCcTot</b></font>
</td>  
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$monthlyDuesAchCount</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$monthlyDuesAchTot</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$monthlyDuesCheckCount</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$monthlyDuesCheckTot</b></font>
</td>  
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$monthlyDuesCashCount</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$monthlyDuesCashTot</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$monthlyServicePrePayCount</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$monthlyServicePrePayTot</b></font>
</td>
</tr>";

echo" <tr>
        <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Collections:</font></th>
  </tr>";


echo" <tr>
  
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Payment Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Payment</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due CC Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due CC</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due Ach Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due Ach</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due Cash Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due Cash</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due Check Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due Check</font></th>
  </tr>"; 
 
 
    
    echo    "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$monthlyPaymentCount</b></font>
</td> 
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$monthlyPaymentTot</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$pastDueCcCount</b></font>
</td> 
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$pastDueCcTot</b></font>
</td>  
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$pastDueAchCount</b></font>
</td> 
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$pastDueAchTot</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$pastDueCashCount</b></font>
</td> 
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$pastDueCashTot</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$pastDueCheckCount</b></font>
</td> 
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$pastDueCheckTot</b></font>
</td>

</tr>";

echo" <tr> 
   <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Settled Cash Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Settled Cash</font></th> 
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Settled Check Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Settled Check</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Settled ACH Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Settled ACH</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Settled CC Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Settled CC</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due Settled Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due Settled</font></th>
  </tr>"; 

 echo    "<tr>
 <td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$declinedSettledCashCount</b></font>
</td> 
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$declinedSettledCashTot</b></font>
</td>  
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$declinedSettledCheckCount</b></font>
</td> 
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$declinedSettledCheckTot</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$declinedSettledAchCount</b></font>
</td> 
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$declinedSettledAchTot</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$declinedSettledCcCount</b></font>
</td> 
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$declinedSettledCcTot</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$pastDueSettledCount</b></font>
</td> 
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$pastDueSettledTot</b></font>
</td>  
</tr>";


  echo  "</table>
  </div>
</head>
</html>";

 


}
//------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------
function loadSalesListings() {
    
  $reportDate = date('F',strtotime($this->monthStart));  

$reportHeader = <<<REPORTHEADER
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<link rel="stylesheet" href="../css/printReport.css">
<script type="text/javascript" src="../scripts/printPage.js"></script>
</head>
<body>

<div id="logoDiv">
<a href="javascript: void(0)" onClick="printPage()"><img src="../images/contract_logo.png"  /></a>
</div>


<span class="black5"><Center><H1><strong>Club Manager Pro  -  Sales Report</strong></Center></H1></span>
<span class="black6"><Center><H1><strong>Month: $reportDate</strong></Center></H1></span>


<div id="listings">
<table align="left" border="0" cellspacing="0" cellpadding="4" width=100%>


REPORTHEADER;

echo"$reportHeader";

  $dbMain = $this->dbconnect();
  $stmt99 = $dbMain->prepare("SELECT club_name, club_contact, club_id FROM club_info WHERE club_id != ''");
  $stmt99->execute();
  $stmt99->store_result();
  $stmt99->bind_result($club_name, $club_contact, $club_id);
  while($stmt99->fetch()){
    
      $total = 0;
      $cc = 0;
      $ca = 0;
      $ch = 0;
      $ach = 0;
      $count = 0;
      $newCount = 0;
      $renewCount = 0;
    $counter = 1;
    $eft = 0;
  
  $date = date('F d Y',strtotime($this->monthStart));
  
   $mStart = date('Y-m-d H:i:s', mktime(0,0,0,date('m'),1,date('Y')));
  $mEnd = date('Y-m-d H:i:s', mktime(0,0,0,date('m'),date('t'),date('Y')));
    $stmt = $dbMain->prepare("SELECT SUM(unit_price) FROM sales_info WHERE (sale_date_time BETWEEN '$mStart' AND '$mEnd') AND (contract_location LIKE '%$club_name%') AND location_id != '0'");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($currentTot);
    $stmt->fetch();
    $stmt->close();
    
    $stmt = $dbMain->prepare("SELECT quota FROM sales_quotas WHERE club_id = '$club_id'");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($quota);
    $stmt->fetch();
    $stmt->close();
    
    $salesLeft = sprintf("%01.2f", $quota - $currentTot);
    
    $now = time();
    $mStartecs = strtotime($mStart);
    $diff = $now - $mStartecs;
    $daysLeft = round($diff/30);
    $dailyGoal = sprintf("%01.2f", $salesLeft/$daysLeft);
    $dailyGoal = $dailyGoal * 1000;
  
  
  echo " <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Club:</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Date:</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Manager:</font></th>
  </tr>"; 
  
   echo         "<tr>
                <td align=\"left\" valign =\"top\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$club_name</b></font>
                </td>
                <td align=\"left\" valign =\"top\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$date</b></font>
                </td>
                <td align=\"left\" valign =\"top\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$club_contact</b></font>
                </td>  
                </tr>";
                
   echo " <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Quota: $quota</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Total: $currentTot</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Sales Left: $salesLeft</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Daily Goal: $dailyGoal</font></th>
  </tr>\n"; 
  
  echo " <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Services Sold:</font></th>
  </tr>"; 
  
  echo " <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract Key</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Member Name</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Transaction Type</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Name</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Price</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Employee Name</font></th>
  </tr>"; 
  
    $stmt3 = $dbMain->prepare("SELECT contract_key, service_name, unit_price, user_id, new_sale FROM sales_info WHERE (sale_date_time BETWEEN '$this->monthStart' AND '$this->monthEnd') AND (contract_location LIKE '%$club_name%') AND location_id != '0'");
    $stmt3->execute();
    $stmt3->store_result();
    $stmt3->bind_result($contract_key, $service_name, $unit_price, $user_id, $new_sale);
    while($stmt3->fetch()){
        $stmt = $dbMain->prepare("SELECT emp_fname, emp_lname FROM employee_info WHERE user_id = '$user_id'");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($emp_fname, $emp_lname);
        $stmt->fetch();
        $stmt->close();
        
        $stmt = $dbMain->prepare("SELECT first_name, last_name FROM member_info WHERE contract_key = '$contract_key'");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($mem_fname, $mem_lname);
        $stmt->fetch();
        $stmt->close();
        
        $stmt = $dbMain->prepare("SELECT credit_payment, cash_payment, ach_payment, check_payment  FROM payment_history WHERE contract_key = '$contract_key' AND (payment_date BETWEEN '$this->monthStart' AND '$this->monthEnd') AND (payment_description LIKE '%New Service%' OR payment_description LIKE '%Service Renewal%'  OR payment_description LIKE '%Service Upgrade%')");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($credit_payment, $cash_payment, $ach_payment, $check_payment);
        $stmt->fetch();
        $stmt->close();
        
        $transType = '';
        
        if ($new_sale == 'Y'){
            $newCount++;
        }else{
            $renewCount++;
        }
        
        if ($credit_payment != '0.00'){
            $cc += $credit_payment;
            $transType = 'CC';
            $payment = $credit_payment;
        }elseif ($cash_payment != '0.00'){
            $ca += $cash_payment;
            $transType = 'CA';
            $payment = $cash_payment;
        }elseif ($ach_payment != '0.00'){
            $ach += $ach_payment;
            $transType = 'ACH';
            $payment = $ach_payment;
        }elseif ($check_payment != '0.00'){
            $ch += $check_payment;
            $transType = 'CH';
            $payment = $check_payment;
        }
        
        if (preg_match('/Monthly/i',$service_name)){
            $eft += $payment;
        }
        
        $total += $unit_price;
        //echo \"<tr><td><Center> <strong>Type:</strong> \" . $transType . \" <strong> Service: </strong> \" . $service_name . \" <strong> Cost:  </strong> \" . $unit_price . \" <strong>  Salesperson: </strong> \" . $emp_fname .\" \" . $emp_lname . \"</Center></td></tr>\";
        echo    "<tr>
                <td align=\"left\" valign =\"top\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$counter</b></font>
                </td>
                <td align=\"left\" valign =\"top\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$contract_key</b></font>
                </td>
                <td align=\"left\" valign =\"top\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$mem_fname $mem_lname</b></font>
                </td>
                <td align=\"left\" valign =\"top\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$transType</b></font>
                </td>
                <td align=\"left\" valign =\"top\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$service_name</b></font>
                </td>  
                <td align=\"left\" valign =\"top\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$$payment</b></font>
                </td>
                <td align=\"left\" valign =\"top\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$emp_fname  $emp_lname</b></font>
                </td>
                </tr>";
                        
        
        $count++;
        $counter++;
    }
    $stmt3->close();
    
    $total = sprintf("%01.2f", $total);
    $total2 = sprintf("%01.2f", $cc+$ca+$ach+$ch);
    $cc = sprintf("%01.2f", $cc);
    $ca = sprintf("%01.2f", $ca);
    $ach = sprintf("%01.2f", $ach);
    $ch = sprintf("%01.2f", $ch);
    
   
    
     echo " <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Totals:</font></th>
  </tr>";
    
    echo" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total Sales</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Credit Cards</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Cash</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">ACH</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Checks</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Number of Sales</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">New</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Renewals</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">New EFT</font></th>
  </tr>"; 
    
    echo    "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>1</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$total2</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$cc</b></font>
</td>  
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$ca</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$ach</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$ch</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$count</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$newCount</b></font>
</td>
<td align=\"right\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$renewCount</b></font>
</td>
<td align=\"right\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$eft</b></font>
</td>
</tr>";
    
   
    
    echo"<tr><td> <Center><strong><br><br><br><br><br><br><br><br><br><br><br><br></strong></Center></td></tr>";
    
        }
  $stmt99->close();
  

  
   $total = 0;
      $cc = 0;
      $ca = 0;
      $ch = 0;
      $ach = 0;
      $count = 0;
      $newCount = 0;
      $renewCount = 0;
      
      
      echo" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Website:</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Date:</font></th>
  
  </tr>"; 
  
   echo    "<tr>
                <td align=\"left\" valign =\"top\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b></b></font>
                </td>
                <td align=\"left\" valign =\"top\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$date</b></font>
                </td>
                </tr>";
                
  echo "<tr>
        <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Services Sold:</font></th>
        </tr> ";            
  
  echo" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract Key</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Transaction Type</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Name</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Price</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Member Contract Key</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Member Name</font></th>
  </tr>"; 
  
  $counter = 1;
    $stmt3 = $dbMain->prepare("SELECT contract_key, service_name, unit_price, user_id, new_sale, service_quantity FROM sales_info WHERE (sale_date_time BETWEEN '$this->monthStart' AND '$this->monthEnd') AND location_id = '0'");
    $stmt3->execute();
    $stmt3->store_result();
    $stmt3->bind_result($contract_key, $service_name, $unit_price, $user_id, $new_sale, $service_quantity);
    while($stmt3->fetch()){
        
        $stmt = $dbMain->prepare("SELECT first_name, last_name FROM member_info WHERE contract_key = '$contract_key'");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($mem_fname, $mem_lname);
        $stmt->fetch();
        $stmt->close();
        
        
        $transType = 'CC';
        
        if ($new_sale == 'Y'){
            $newCount++;
        }else{
            $renewCount++;
        }
        
        if (preg_match('/Monthly/i',$service_name)){
            $unit_price = $unit_price/$service_quantity;
            $eftWeb += $unit_price;
            
        }

        
        $total += $unit_price;
        //echo \" <tr><td><Center> <strong>Type:</strong> \" . $transType . \" <strong> Service: </strong> \" . $service_name . \" <strong> Cost:  </strong> \" . $unit_price . \" <strong> </Center></td></tr>\";
        echo    "<tr>
                <td align=\"left\" valign =\"top\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$counter</b></font>
                </td>
                <td align=\"left\" valign =\"top\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$contract_key</b></font>
                </td>
                <td align=\"left\" valign =\"top\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$transType</b></font>
                </td>
                <td align=\"left\" valign =\"top\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$service_name</b></font>
                </td>  
                <td align=\"left\" valign =\"top\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$$unit_price</b></font>
                </td>
                 <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$contract_key</b></font>
                </td>  
                <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$mem_fname $mem_lname</b></font>
                </td>
                </tr>";
        $count++;
        $counter++;
    }
    $stmt3->close();
    
    $total = sprintf("%01.2f", $total);
    
    echo "<tr>
        <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Totals:</font></th>
        </tr> "; 
    
    echo" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total Sales</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Number of Sales</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">New Sales</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Renewal Sales</font></th>
   <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">New EFT</font></th>
  </tr>"; 
    
    echo    "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>1</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$total</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$count</b></font>
</td>  
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$newCount</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$renewCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$eftWeb</b></font>
</td>
</tr>";

 echo "<tr><td> <Center><strong><br><br><br><br><br><br><br><br><br><br><br><br></strong></Center></td></tr>";

   $total = 0;
   $count = 0; 
  
     echo" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">POS:</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Date:</font></th>
  
  </tr>"; 
  
   echo    "<tr>
                <td align=\"left\" valign =\"top\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b></b></font>
                </td>
                <td align=\"left\" valign =\"top\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$date</b></font>
                </td>
                </tr>";
                
  echo "<tr>
        <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Items Sold:</font></th>
        </tr> ";            
   echo" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Product Description</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Sale Price</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Club Name</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Member Name</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract Key</font></th>
  </tr>\n"; 
  
  $counter = 1;
    $stmt3 = $dbMain->prepare("SELECT product_desc, total_cost, club_id, contract_key  FROM merchant_sales WHERE (purchase_date BETWEEN '$this->monthStart' AND '$this->monthEnd')");
    $stmt3->execute();
    $stmt3->store_result();
    $stmt3->bind_result($product_desc, $total_cost, $club_id, $contract_key);
    while($stmt3->fetch()){
          $stmt99 = $dbMain->prepare("SELECT club_name FROM club_info WHERE club_id = '$club_id'");
          $stmt99->execute();
          $stmt99->store_result();
          $stmt99->bind_result($club_name);
          $stmt99->fetch();
          $stmt99->fetch();
          
          $stmt99 = $dbMain->prepare("SELECT first_name, last_name  FROM member_info WHERE contract_key = '$contract_key'");
          $stmt99->execute();
          $stmt99->store_result();
          $stmt99->bind_result($first_name, $last_name);
          $stmt99->fetch();
          $stmt99->fetch();
          
        $total += $total_cost;
        //$message .= " <tr><td><Center> <strong>Type:</strong> " . $transType . " <strong> Service: </strong> " . $service_name . " <strong> Cost:  </strong> " . $unit_price . " <strong> </Center></td></tr>";
         echo   "<tr>
                <td align=\"left\" valign =\"top\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$counter</b></font>
                </td>
                <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$product_desc</b></font>
                </td>
                <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$total_cost</b></font>
                </td>  
                <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$club_name</b></font>
                </td>
                <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$first_name&nbsp;$last_name</b></font>
                </td>
                <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$contract_key</b></font>
                </td>
                </tr>\n";
        $count++;
        $counter++;
    }
    $stmt3->close();
    
    $total = sprintf("%01.2f", $total);
    
     echo "<br><p class=\"bbackheader\"><Center><H3><strong>Totals:</strong></Center></H3></p>";
     echo" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total Sales</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Number of Sales</font></th>
  </tr>\n"; 
    
     echo    "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>1</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$total</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$count</b></font>
</td>  
</tr>\n";  
    
    
 echo  "</table>
  </div>
</head>
</html>";

}
//==============================================================================================
function moveData(){
  
   $dbMain = $this->dbconnect();
   
   $this->generateDates();
   switch($this->report){
    case 'missing':
        $this->loadMissingListings();
    break; 
    case 'owed':
        $this->loadCollectionsStillOwed();
    break; 
    case 'bad':
        $this->loadBadListings();
    break; 
    case 'batch':
        $this->loadBatchListings();
    break;
    case 'sales':
        $this->loadSalesListings();
    break;
    case 'dashboard':
        $this->loadDashboardListings();
    break;
    case 'reason':
        include"monthlyBillingPreview.php";
        $upload = new monthlyBillingPreview();
        $bool = 'R';
        $upload->setBool($bool);
        $upload->setMonth($this->month);
        $upload->setYear($this->year);
        $upload->fileMaker();
    break;
    case 'preview':
        include"monthlyBillingPreview.php";
        $upload = new monthlyBillingPreview();
        $bool = 'Q';
        $upload->setBool($bool);
        $upload->setMonth($this->month);
        $upload->setYear($this->year);
        $upload->fileMaker();
    break;        
    case 'collect':
        include"monthlyBillingPreview.php";
        $upload = new monthlyBillingPreview();
        $bool = 'C';
        $upload->setBool($bool);
        $upload->setMonth($this->month);
        $upload->setYear($this->year);
        $upload->fileMaker();
    break;        
  }
  
  
  
}
//===============================================

}

$report = $_SESSION['report'];
$month = $_SESSION['month'];
$year = $_SESSION['year'];
//echo "fubar $report";
unset($_SESSION['year']);
unset($_SESSION['month']);
unset($_SESSION['report']);
//echo "$month $barCode";
$csUpdate = new generateReport();
//$month = 'January';
//$barcode = '127985';
$csUpdate-> setMonth($month);
$csUpdate-> setYear($year);
$csUpdate-> setReport($report);
$csUpdate->moveData();




?>