<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class loadPromoEnroll {

private $contractKey = null;
private $serviceName = null;
private $serviceKey = null;
private $settledCount = 0;
private $todaysDate = null;
private $dateRange = null;
private $listType = null;
private $counter = 1;
private $color = null;
private $firstName = null;
private $middleName = null;
private $lastName = null;
private $primaryPhone = null;
private $cellPhone = null;
private $emailAddress = null;
private $clientStreet = null;
private $clientCity = null;
private $clientState = null;
private $clientZip = null;
private $billingTotal = null;
private $invoiceHeader = null;
private $businessName = null;
private $businessStreet = null;
private $businessCity = null;
private $businessState = null;
private $businessZip = null;
private $parseLength = 0;
private $invoice = null;
private $mailHeader = null;
private $mailFooter = null;
private $printableInvoice = null;
private $imageName = null;
private $erHeader = null;
private $erTextOne = null;
private $erTextTwo = null;
private $expDate = null;



function setContractKey($contractKey) {
              $this->contractKey = $contractKey;
              }

function setDateRangeStart($dateRangeStart) {
              $this->dateRangeStart = $dateRangeStart;
              }
              
function setDateRangeEnd($dateRangeEnd) {
              $this->dateRangeEnd = $dateRangeEnd;
              }

function setListType($listType) {
              $this->listType = $listType;
              }

function setTermType($termType) {
              $this->termType = $termType;
              }

function setImageName($imageName) {
              $this->imageName = $imageName;
              }
                         
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;              
}
//--------------------------------------------------------------------------------------------------------------------
function loadPdf() {

//load the directory path since this is subject to change with each client
$directoryPath = $_SERVER['DOCUMENT_ROOT'];
$directoryArray = explode("/",$directoryPath);
$domainDir = $directoryArray[6];


$fileName = "PromoRenew$this->dateRangeStart.pdf";
$invoiceSalt = rand(1000, 9000);
$tempFile = "testFile$invoiceSalt.html";
$contentFile = "/var/www/vhosts/ems/$domainDir/admin/promo/$tempFile";

file_put_contents($contentFile, $this->printableInvoice);

exec("/usr/local/bin/wkhtmltopdf  -s Letter --outline -T 0 -B 0 -R 0 -L 0 $contentFile /var/www/vhosts/ems/$domainDir/admin/promo/$fileName");

unlink("$contentFile");

//rename the file so it is more legible for download
$fileDate = date("m_d_Y", $this->dateStart);
$newFileName = "Promo_Re_Enroll_$this->dateRangeStart.pdf";

rename("/var/www/vhosts/ems/$domainDir/admin/promo/$fileName", "/var/www/vhosts/ems/$domainDir/admin/promo/$newFileName");


}
//--------------------------------------------------------------------------------------------------------------------
function loadBusinessInfo() {

$dbMain = $this->dbconnect();

$stmt = $dbMain->prepare("SELECT DATABASE() AS database_name");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($database_name); 
$stmt->fetch();
$stmt->close();

$dbNumber = explode('_',$database_name);


$stmt = $dbMain ->prepare("SELECT business_nick, mailing_street, mailing_city, mailing_state, mailing_zip FROM business_info WHERE bus_id = '$dbNumber[1]'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($businessName, $mailingStreet, $mailingCity, $mailingState, $mailingZip);
$stmt->fetch();

$this->businessName = $businessName;
$this->businessStreet = $mailingStreet;
$this->businessCity = $mailingCity;
$this->businessState = $mailingState;
$this->businessZip = $mailingZip;

$stmt->close();

}
//==============================================================================
    function checkAccountStatus()  {

        $dbMain = $this->dbconnect();
        $stmt = $dbMain ->prepare("SELECT account_status FROM account_status WHERE contract_key = '$this->contractKey' AND service_key='$this->serviceKey' ORDER BY status_date DESC LIMIT 1");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($this->accountStatus);
        $stmt->fetch();
        $stmt->close();

    }
//--------------------------------------------------------------------------------------------------------------------
function loadPromoEnrollParameters() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT msg_header, email_text, sms_text FROM club_promo WHERE promo_key = '1'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($this->erHeader, $this->emailText, $this->smsText);
$stmt->fetch();

$this->invoiceHeader = 'New Membership Promotion';
$stmt->close();  


}
//------------------------------------------------------------------------------------------------------------------
function loadContactInfo() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT first_name, middle_name, last_name, primary_phone, cell_phone, email, street, city, state, zip FROM contract_info WHERE contract_key = '$this->contractKey' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($first_name, $middle_name, $last_name, $primary_phone, $cell_phone, $email, $street, $city, $state, $zip);
$stmt->fetch();

$this->firstName = $first_name;
$this->middleName = $middle_name;
$this->lastName = $last_name;
$this->primaryPhone = $primary_phone;
$this->cellPhone = $cell_phone;
$this->emailAddress = $email;
$this->clientStreet = $street;
$this->clientCity = $city;
$this->clientState = $state;
$this->clientZip = $zip;

$stmt->close();

}
//------------------------------------------------------------------------------------------------------------------
function loadPifRecordCount() {

$dateBetweenStart = date("Y-m-d"  ,mktime(0, 0, 0, date("m")  , date("d")- $this->dateRangeStart, date("Y")));
$dateBetweenEnd = date("Y-m-d"  ,mktime(0, 0, 0, date("m")  , date("d")+ $this->dateRangeEnd, date("Y")));
$this->todaysDate = date("M j, Y");
echo "$dateBetweenStart  $dateBetweenEnd";

  $dbMain = $this->dbconnect();
  $stmt = $dbMain ->prepare("SELECT DISTINCT contract_key, service_key, service_name, end_date FROM paid_full_services WHERE end_date BETWEEN '$dateBetweenStart' AND  '$dateBetweenEnd' ORDER BY end_date DESC");
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($contract_key, $service_key , $service_name, $end_date);

 
  
  while ($stmt->fetch()) {        
    
            $stmt99 = $dbMain ->prepare("SELECT end_date FROM paid_full_services WHERE contract_key = '$contract_key' AND service_key = '$service_key' ORDER BY end_date DESC LIMIT 1");
            $stmt99->execute();      
            $stmt99->store_result();      
            $stmt99->bind_result($end_dateMax);
            $stmt99->fetch();
            $stmt99->close();
            
            $this->month =  date("m");
            $this->year = date("Y");
            $this->reportType = "PE";
            $this->contractKey  = $contract_key;
            $stmt99 = $dbMain ->prepare("SELECT num_text_primary, num_calls_primary, num_text_cell, num_calls_cell, num_emails FROM account_phone_spam_check WHERE contract_key = '$contract_key' AND report_type = 'PE' AND month = '$this->month' AND year = '$this->year'");
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

      $this->contractKey = $contract_key;
      $this->serviceKey = $service_key;
      $this->checkAccountStatus();
      if (strtotime($end_dateMax) == strtotime($end_date) AND $this->accountStatus == 'CU'){
    
            //$this->contractKey = $contract_key;
            $this->serviceName = $service_name;
           // $this->serviceKey = $sevice_key;
             
            //put the expiration date into English
            $endDate = strtotime($end_date);
            $this->expDate = date("M j, Y" ,$endDate);
            
            $this->loadContactInfo();
            
           //create color rows
            static $cell_count = 1;
                  if($cell_count == 2) {
                      $this->color = "#D8D8D8";
                      $cell_count = "";
                      }else{
                      $this->color = "#FFFFFF";
                                   }
                      $cell_count = $cell_count + 1;
                      
           switch($this->listType) {          
                      case"phone":
                      $this->createPhoneList();
                      break;
                      case"email":
                      $this->sendEmail();
                      break;
                      case"mail": 
                       if($this->doNotMail != 'Y'){           
                            $this->parseInvoices();
                            }
                      break;
                      case"sms": 
                      if($this->doNotText != 'N'){
                        $this->sendSms();
                      }           
                      
                      break;
                     }                      
                  
      $this->counter++;                      
                }  
                   $this->pSmsAtt =0;
                  $this->pCallAtt =0;
                  $this->cSmsAtt=0;  
                  $this->cCallAtt=0;
                  $this->emailAtt=0;
                  $this->doNotCallCell = ""; 
                  $this->doNotCallHome = ""; 
                  $this->doNotEmail = ""; 
                  $this->doNotText = ""; 
                  $this->doNotMail = "";
                  $this->preferedContactMethod = "";
                  $service_key = "";
                  $contract_key = "";
                  $service_name = "";
                  $end_date = "";
           }
                       
  $stmt->close();  
  
if($this->listType != "mail") {
   echo"</div>\n</body>\n</html>";
   }else{   
   $this->mailFooter = "</body>\n</html>"; 
   $this->printableInvoice = "$this->mailHeader \n $this->invoice \n $this->mailFooter";
   }
  
    
  
}
//=================================================================================================================
function sendSms() {

$smsSuccess = 0;
if($this->cellPhone != "" AND $this->cellPhone != "(000) 000-0000") {

$carriers = array('txt.att.net','myboostmobile.com','cspire1.com','sms.mycricket.com','mymetropcs.com','messaging.sprintpcs.com','tmomail.net','email.uscc.net','vtext.com','vmobl.com');
 
$phoneStripped = preg_replace("/[^0-9]/","", $this->cellPhone);
 
$headers  = "From: $business_name@$business_nick.com\r\n";
$headers .= "Content-type: text/html\r\n"; 

$fname = strtolower($this->firstName);
$fname = ucfirst($fname);
$lname = strtolower($this->lastName);
$lname = ucfirst($lname);
        
$message = "Hi $fname $lname! $this->smsText.";
 
$message = wordwrap($message, 70, "\r\n");
foreach($carriers As $domain){
    $address = "$phoneStripped@$domain";
    mail($address, $this->erHeader, $message, $headers);    
}

$smsStatus = "SMS SUCCESSFUL";
$successColor = '#006633';
$smsSuccess = 1;
}elseif ($this->primaryPhone != ""  AND $this->primaryPhone != "(000) 000-0000" AND $smsSuccess == 0){

        $carriers = array('txt.att.net','myboostmobile.com','cspire1.com','sms.mycricket.com','mymetropcs.com','messaging.sprintpcs.com','tmomail.net','email.uscc.net','vtext.com','vmobl.com');
         
        $phoneStripped = preg_replace("/[^0-9]/","", $this->primaryPhone);
         
        $headers  = "From: $business_name@$business_nick.com\r\n";
        $headers .= "Content-type: text/html\r\n"; 
        
        $fname = strtolower($this->firstName);
        $fname = ucfirst($fname);
        $lname = strtolower($this->lastName);
        $lname = ucfirst($lname);
                
        $message = "Hi $fname $lname! $this->smsText.";
         
        $message = wordwrap($message, 70, "\r\n");
        foreach($carriers As $domain){
            $address = "$phoneStripped@$domain";
            mail($address, $this->erHeader, $message, $headers);    
        }
        
        $smsStatus = "SMS SUCCESSFUL";
        $successColor = '#006633';
}else{
    $smsStatus = "SMS UNSUCCESSFUL";
    $successColor = "#990000";
}



 echo"<tr>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->counter</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->contractKey</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->firstName $this->middleName $this->lastName</b></font>  
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->emailAddress</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->serviceName</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->expDate</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->invoiceHeader</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"$successColor\"><b>$smsStatus</b></font>
</td>
</tr>\n";

}
//------------------------------------------------------------------------------------------------------------------
function sendEmail() {

if($this->emailAddress != "" AND $this->doNotEmail != 'Y') {

mail("$this->emailAddress", "$this->erHeader",

"Hello, $this->firstName $this->middleName $this->lastName

Your current $this->serviceName is eligable for our new promotion.

Current Expiration Date: &nbsp;  $this->expDate  

$this->emailText

Thank you,
$this->businessName

(c)$this->businessName.",
"From: $this->businessName<info@burbankathleticclub.com>","-finfo@burbankathleticclub.com"); 

$emailStatus = "EMAIL SUCCESSFUL";
$successColor = '#006633';

}else{

$emailStatus = "EMAIL UNSUCCESSFUL";
$successColor = "#990000";
}



 echo"<tr>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->counter</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->contractKey</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->firstName $this->middleName $this->lastName</b></font>  
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->emailAddress</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->serviceName</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->expDate</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->invoiceHeader</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"$successColor\"><b>$emailStatus</b></font>
</td>
</tr>\n";

}
//------------------------------------------------------------------------------------------------------------------
function createPhoneList() {
    
    if($this->doNotCallCell == "Y"){
        $color = "red";
        $disabledCell = "<span class=\"c_call colorChange\">$this->cellPhone</span>";
    }else{
        $color = "black";
        $disabledCell = "<a class=\"c_call\" href=\"tel:$this->cellPhone\"><span id=\"c_phone\">$this->cellPhone</span></a>";
    }
    if($this->doNotCallHome == "Y"){
        $color = "red";
        $disabledHome = "<span class=\"p_call colorChange\">$this->primaryPhone</span>";
    }else{
        $color = "black";
        $disabledHome = "<a class=\"p_call\" href=\"tel:$this->primaryPhone\"><span id=\"p_phone\">$this->primaryPhone</span></a>";
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
        $disabledEmail = "<span class=\"email colorChange\">$this->emailAddress</span>";
    }else{
        $color = "black";
        $disabledEmail = "<a class=\"email\" href=\"mailto:$this->emailAddress\">$this->emailAddress</a>";
    }

 echo"<tr>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"2\" color=\"black\"><b><b>$this->counter</b></b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"2\" color=\"black\"><b><b><span id=\"contract_key\">$this->contractKey</span></b></b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"2\" color=\"black\"><b><b><span id=\"name\">$this->firstName $this->middleName $this->lastName</span></b></b></font>
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
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"2\" color=\"black\"><b><span id=\"service\">$this->serviceName</span></b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"2\" color=\"black\"><b><span id=\"date\">$this->endDate</span></b></font>
</td>
<input type=\"hidden\" id=\"report_type\" value=\"$this->reportType\"/>
<input type=\"hidden\" id=\"month\" value=\"$this->month\"/>
<input type=\"hidden\" id=\"year\" value=\"$this->year\"/>
</tr>\n";



}
//------------------------------------------------------------------------------------------------------------------
function parseInvoices() {

if($this->counter == 1) {
   $this->parseLength = 0;
   }else{
   $this->parseLength = 11;
   }

//creates the invoice number
$invoiceSalt = rand(1000, 9000);
$sep = '-';
$invoiceNumber = "$this->contractKey$sep$invoiceSalt";

$in = in;

$this->invoice .= <<<PARSEINVOICES
<div class="printBreak">
<table align="center" width="76%" cellpadding="2" cellspacing="2" border="0">
<tr>
<td colspan="2" class="threeEight">
<div id="fromWindow$this->parseLength" class="fromWindow">
$this->businessName
<br>
$this->businessStreet
<br>
$this->businessCity $this->businessState $this->businessZip
</div>
</td>
<td class="threeEight">
<div id="logoInfo$this->parseLength" class="logoInfo">
<a href="javascript: void(0)" onClick="printPage()"><img class="displayed" src="../images/$this->imageName" width="118" height="46"></a>
<br>
Ref Number: &nbsp; $invoiceNumber
<br>
Notice Date:  &nbsp; $this->todaysDate
<br>
Contract Number: &nbsp; $this->contractKey
</div>
</td>
</tr>

<tr>
<td class="toSpacer">
<div id="toWindow$this->parseLength" class="toWindow">
$this->firstName $this->middleName $this->lastName
<br>
$this->clientStreet
<br>
$this->clientCity $this->clientState $this->clientZip
</div>
</td>
<td class="threeEightTwo">
<div id="noteLable$this->parseLength" class="noteLable">
Note:
</div>
</td>
<td class="threeEightThree">
<div id="noteText$this->parseLength" class="noteText">
$this->invoiceHeader
</div>
</td>
</tr>

<tr>
<td align="left" colspan="2" class="threeEightFour">
<span class="left">
Current Expiration Date: &nbsp;  $this->expDate  
</span>
</td>
<td align="right" class="threeEightFour">
<span class="right">
$this->erHeader
</span>
</div>
</td>
</tr>

<tr>
<td align="center" colspan="3">
<br><br>
<div id="bodyTable$this->parseLength" class="bodyTable">
<table id="tHead0" width="100%">
<tr>
<td align="left" class="innerTwo">
Hello,  $this->firstName $this->middleName $this->lastName
</td>
</tr>

<tr>
<td align="left" class="innerTwo">
Your current $this->serviceName is eligable for our new promotion.
<br><br>
$this->emailText

<br><br><br>
Thank you,
<br>
$this->businessName
<br><br>
&copy; $this->businessName
</td>
</tr>

</table>
</div>
</td>
</tr>
</table>
</div>\n\n
PARSEINVOICES;

 echo"<tr>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->counter</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->contractKey</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->firstName $this->middleName $this->lastName</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->primaryPhone</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->cellPhone</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b><a href=\"mailto:$this->emailAddress\">$this->emailAddress</a></b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->serviceName</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->expDate</b></font>
</td>
</tr>\n";

}
//------------------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------------------
function loadHeader() {

if($this->listType == "phone") {
  $titleDiv = "
  <div id=\"userHeader\">
   Promotion Phone List 
  </div>";
  $cssFIle = 'phoneEmail.css';
  $tableHeadTag = "<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>\n";
  $tabHead = "<style>
  a:hover{
    cursor: pointer;
    cursor: hand;
    }
  .p_sms{
        color: black;
        font-weight: 900;
        font-size: 16px;
    }
    #p_sms_attempts{
        color: black;
        font-weight: 900;
        font-size: 16px;
    }
    .c_sms{
        color: black;
        font-weight: 900;
        font-size: 16px;
    }
    #c_sms_attempts{
        color: black;
        font-weight: 900;
        font-size: 16px;
    }
    #p_call_attempts{
        color: black;
        font-weight: 900;
        font-size: 16px;
    }
    #c_call_attempts{
        color: black;
        font-weight: 900;
        font-size: 16px;
    }
    #email_attempts{
        color: black;
        font-weight: 900;
        font-size: 16px;
    }
    .colorChange{
        color: red;
        
    }
  </style>
  <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Name</font></th>
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
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Exp Date</font></th>
  </tr>\n";     
  $javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/setContractRecord.js\"></script>";
  
  
  }
  
if($this->listType == "email") {
  $titleDiv = "
  <div id=\"userHeader\">
   Promotion Email List 
  </div>";
  $cssFIle = 'phoneEmail.css';
  $tableHeadTag = "<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>\n";
  $tabHead = "
  <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Name</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Email Address</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Exp Date</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Invoice Type</font></th> 
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Email Status</font></th>
  </tr>\n";       
  }  

if($this->listType == "mail") {
  $titleDiv = "";
  $cssFIle = 'mail5.css';
 // $printFile ="<link rel=\"stylesheet\"  media=\"print\" href=\"../css/printInvoice.css\">";
  $javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/printPage.js\"></script>";
  }  

if($this->listType != "mail") {

$listingsHeader = <<<LISTINGS
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" href="../css/$cssFIle">
$javaScript1
$javaScript2
$javaScript3
$javaScript4
$javaScript5
<script type="text/javascript" src="../scripts/jqueryNew.js"></script>
<script type="text/javascript" src="../scripts/spamContactGuard3.js"></script>

<title>Promotion $this->dateRange Days</title>

</head>
<body>

$titleDiv

<div id="listings">
$tableHeadTag
$tabHead
LISTINGS;

echo"$listingsHeader";

}else{

$this->mailHeader = <<<LISTINGS
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" href="../css/$cssFIle">
$printFile
$javaScript1
$javaScript2

<title>Past Due $this->currentStatementDate</title>

</head>
<body>
LISTINGS;


//this spits out the list of members while the pdf is being generated
$titleDiv = "
<div id=\"userHeader\">
 Promotion List
</div>";


$cssFIle = 'mailList.css';
$tableHeadTag = "<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>\n";
$tabHead = "
  <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Name</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Primary Phone</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Cell Phone</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Email Address</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Exp Date</font></th>
  </tr>\n";     
$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript2 = "<script type=\"text/javascript\" src=\"../scripts/downLoadPdf.js\"></script>";



$listingsHeaderMail = <<<LISTINGSLIST
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" href="../css/$cssFIle">
$javaScript1
$javaScript2
$javaScript3
$javaScript4
$javaScript5


<title>Promotion List $this->currentStatementDate</title>

</head>
<body>

$titleDiv

<div id="listings">
$tableHeadTag
$tabHead
LISTINGSLIST;

echo"$listingsHeaderMail";


}

}
//-------------------------------------------------------------------------------------------------------------------
function loadListType() {
               
  switch($this->listType) {          
               case"phone":
               $this->loadHeader();
               if($this->termType == 'T') {
                  $this->loadPifRecordCount();
                  }
               break;
               case"email":
               $this->loadHeader();
               if($this->termType == 'T') {
                  $this->loadPifRecordCount();
                  }               
               break;
               case"mail":
               $this->loadHeader();
               if($this->termType == 'T') {
                  $this->loadPifRecordCount();
                  }               
               break;
                case"sms":
               $this->loadHeader();
               if($this->termType == 'T') {
                  $this->loadPifRecordCount();
                  }               
               break;
             }
}
//-------------------------------------------------------------------------------------------------------------------
function getPrintableInvoice() {
             return($this->printableInvoice);
             }


}//end class
//----------------------------------------------------------------------
/*
$todays_date = date("Y-m-d");

if($ajax_switch == 1) {
  $checkPast = new checkPastDue();
  $checkPast-> setTodaysDate($todays_date);
  $checkPast-> loadCycleDate();
  $record_count = $checkPast-> loadRecordCount();
  echo"$record_count";
  exit;
  }

*/









?>
