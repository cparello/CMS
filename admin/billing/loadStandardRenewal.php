<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class loadStandardRenewal {

private $contractKey = null;
private $serviceId = null;
private $serviceName = null;
private $serviceKey = null;
private $groupPrice = null;
private $groupRenewRate = null;
private $groupType = null;
private $renewalFee = null;
private $settledCount = 0;
private $todaysDate = null;
private $dateStart = null;
private $statementRangeEndDate = null;
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
private $amendKey = null;
private $imageName = null;
private $standardHeader = null;
private $standardText = null;
private $standardRenewalGrace = null;
private $expDate = null;


function setAmendKey($amendKey) {
              $this->amendKey = $amendKey;
              }

function setContractKey($contractKey) {
              $this->contractKey = $contractKey;
              }

function setDateStart($dateStart) {
              $this->dateStart = $dateStart;
              }

function setListType($listType) {
              $this->listType = $listType;
              }

function setImageName($imageName) {
              $this->imageName = $imageName;
              }
function setClub($club) {
              $this->club = $club;
              }
function setInvoiceDate($invoiceDate) {
              $this->invoiceDate = $invoiceDate;
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

array_map('unlink', glob("/var/www/vhosts/ems/$domainDir/admin/standardrenewals/*.pdf"));

$fileName = "StandardRenewal$this->dateStart.pdf";
$invoiceSalt = rand(1000, 9000);
$tempFile = "testFile$invoiceSalt.html";
$contentFile = "/var/www/vhosts/ems/$domainDir/admin/standardrenewals/$tempFile";

file_put_contents($contentFile, $this->printableInvoice);

exec("/usr/local/bin/wkhtmltopdf  -s Letter --outline -T 0 -B 0 -R 0 -L 0 $contentFile /var/www/vhosts/ems/$domainDir/admin/standardrenewals/$fileName");

unlink("$contentFile");

//rename the file so it is more legible for download
$fileDate = date("m_d_Y", $this->dateStart);
$newFileName = "Standard_Renewal_$fileDate.pdf";

rename("/var/www/vhosts/ems/$domainDir/admin/standardrenewals/$fileName", "/var/www/vhosts/ems/$domainDir/admin/standardrenewals/$newFileName");


}
//--------------------------------------------------------------------------------------------------------------------
function loadRenewalFee() {

   switch($this->groupType) {          
              case"S":
              $feeColum = 'renewal_fee_single_two';
              break;
              case"F":
              $feeColum = 'renewal_fee_family_two';
              break;
              case"B":            
              $feeColum = 'renewal_fee_business_two';
              break;
              case"0":            
              $feeColum = 'renewal_fee_organization_two';
              break;              
              }   

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT $feeColum FROM fees WHERE fee_num ='1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($renewalFee);
$stmt->fetch();

$this->renewalFee = $renewalFee;

$stmt->close();


}
//--------------------------------------------------------------------------------------------------------------------
function loadBusinessInfo() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT business_nick, mailing_street, mailing_city, mailing_state, mailing_zip FROM business_info WHERE bus_id = '1000'");
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
//--------------------------------------------------------------------------------------------------------------------
function loadStandardParameters() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT general_header, general_txt FROM renewal_invoice_options WHERE invoice_key = '1'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($general_header, $general_txt);
$stmt->fetch();

$this->standardHeader = $general_header;
$this->standardText = $general_txt;
$this->invoiceHeader = 'STANDARD RENEWAL';
$this->standardRenewalGrace = "30";


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
function loadRecordCount() {
    $this->todaysDate = date("M j, Y");
    $this->thirtyFromToday = strtotime("+30 day");
    $this->thirtyFromToday = date("M j, Y",$this->thirtyFromToday);
           
  $daysOutSecs = $this->standardRenewalGrace * 86400;
  $endDateSeconds = $daysOutSecs + $this->dateStart; 
  $renewalEndDate = date("Y-m-d H:i:s" ,$endDateSeconds);
  //$this->dateStart =   $endDateSeconds;
  //$this->expDate = date("M j, Y" ,$endDateSeconds);
  $this->statementDate = date("M j, Y" ,$endDateSeconds);
  $year = date('Y',$this->dateStart);
  $month = date('m',$this->dateStart);
  $day = date('d',$this->dateStart);
      
  $rangeEnd = date("Y-m-d H:i:s" ,mktime(23,59,59,$month,date('t'),$year));
  $rangeStart = date("Y-m-d H:i:s" ,mktime(0,0,0,$month,$day,$year));
//echo "$rangeStart $rangeEnd";
  $dbMain = $this->dbconnect();
  $stmt = $dbMain ->prepare("SELECT service_id, contract_key, service_name, service_key, group_price, group_renew_rate, group_type, end_date FROM paid_full_services WHERE (end_date BETWEEN '$rangeStart' AND '$rangeEnd') ORDER BY end_date ASC");
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($service_id, $contract_key, $service_name, $sevice_key, $group_price, $group_renew_rate, $group_type, $end_date);
  
  while ($stmt->fetch()) { 
            $club_id = "";
            $stmt99 = $dbMain ->prepare("SELECT contract_id, club_id FROM contract_info WHERE contract_key = '$contract_key' ORDER BY contract_id DESC LIMIT 1");
            $stmt99->execute();      
            $stmt99->store_result();      
            $stmt99->bind_result($cid, $club_id);
            $stmt99->fetch();
            $stmt99->close();
            
            $stmt99 = $dbMain ->prepare("SELECT MAX(end_date) FROM paid_full_services WHERE contract_key = '$contract_key' AND service_key = '$sevice_key'");
            $stmt99->execute();      
            $stmt99->store_result();      
            $stmt99->bind_result($end_dateMax);
            $stmt99->fetch();
            $stmt99->close();
            
             $this->month = $month;
            $this->year = $year;
            $this->reportType = "SR";
            $this->contractKey  = $contract_key;
            $stmt99 = $dbMain ->prepare("SELECT num_text_primary, num_calls_primary, num_text_cell, num_calls_cell, num_emails FROM account_phone_spam_check WHERE contract_key = '$contract_key' AND report_type = 'SR' AND month = '$month' AND year = '$year'");
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
            
            $maxSecs = strtotime($end_dateMax);
            $endSecs = strtotime($end_date);
            
            if ($maxSecs <= $endSecs AND $this->club == $club_id){
    
            $this->endDate = date('m-d-Y', strtotime($end_date));
            $this->serviceId = $service_id;
            $this->contractKey = $contract_key;
            $this->serviceName = $service_name;
            $this->serviceKey = $sevice_key;
            $this->groupPrice = $group_price;
            $this->groupRenewRate = $group_renew_rate;
            $this->groupType = $group_type;
            $this->loadRenewalFee();
            $this->billingTotal = $group_renew_rate + $this->renewalFee;
            $this->billingTotal = number_format("$this->billingTotal",2);
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
                       if($this->doNotMail != 'N'){       
                          $this->parseInvoices();
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
                  $contract_key = 0;   
                  $this->doNotCallCell = ""; 
                  $this->doNotCallHome = ""; 
                  $this->doNotEmail = ""; 
                  $this->doNotText = ""; 
                  $this->doNotMail = "";
                  $this->preferedContactMethod = "";                                 
           }           
  $stmt->close();  
  
  $reportType = 'SR';
    $sql = "INSERT INTO accounts_renewable_spam_check VALUES (?, ?, ?, ?, ?)";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('issss', $key, $reportType, $rangeStart, $this->listType, $this->club);  
    if(!$stmt->execute())  {
    	printf("Error: %s.Insert SR renewable\n", $stmt->error);
       }		
    $stmt->close(); 
  
if($this->listType != "mail") {
   echo"</div>\n</body>\n</html>";
   }else{   
   $this->mailFooter = "</body>\n</html>"; 
   $this->printableInvoice = "$this->mailHeader \n $this->invoice \n $this->mailFooter";
   }
  
    
  
}
//------------------------------------------------------------------------------------------------------------------
function sendEmail() {

if($this->emailAddress != "" AND $this->doNotEmail != 'Y') {

mail("$this->emailAddress", "$this->standardHeader",

"Hello, $this->firstName $this->middleName $this->lastName

Your current $this->serviceName service is due to expire within the next $this->standardRenewalGrace day(s).

$this->standardText

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
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->endDate</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->groupPrice</b></font>
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
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"2\" color=\"black\"><b><span id=\"price\">$this->groupPrice</span></b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"2\" color=\"black\"><b><span id=\"discount\">$this->standardRenewalGrace</span></b></font>
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
Invoice Number: &nbsp; $invoiceNumber
<br>
Statement Date:  &nbsp; $this->todaysDate
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
$this->standardText
</div>
</td>
</tr>

<tr>
<td align="left" class="threeEightFour">
<span class="left">
Statement Due:  &nbsp; $this->todaysDate  
</span>
</td>
<td colspan="2" align="right" class="threeEightFour">
<span class="right">
$this->invoiceHeader
</span>
</div>
</td>
</tr>

<tr>
<td align="center" colspan="3">
<div id="bodyTable$this->parseLength" class="bodyTable">
<div id="bodyTableHeader$this->parseLength" class="bodyTableHeader">
<table id="tHead0" width="100%">
<tr>
<th align="left" class="innerOne">
DATE
</th>
<th align="left" class="innerOne">
CHECK #
</th>
<th align="left" class="innerOne">
DESCRIPTION
</th>
<th align="left" class="innerOne">
CHARGES
</th>
<th align="left" class="innerOne">
CREDITS
</th>
<th align="left" class="innerOne">
BALANCE
</th>
</tr>
</div>

<tr>
<td align="left" class="innerTwo">
$this->todaysDate
</td>
<td align="left" class="innerTwo">
&nbsp;
</td>
<td align="left" class="innerTwo">
$this->serviceName
</td>
<td align="left" class="innerTwo">
$this->groupPrice
</td>
<td align="left" class="innerTwo">
0.00
</td>
<td align="left" class="innerTwo">
$this->groupRenewRate
</td>
</tr>

<tr>
<td align="left" class="innerTwo">
$this->todaysDate
</td>
<td align="left" class="innerTwo">
&nbsp;
</td>
<td align="left" class="innerTwo">
Renewal Fee
</td>
<td align="left" class="innerTwo">
$this->renewalFee
</td>
<td align="left" class="innerTwo">
0.00
</td>
<td align="left" class="innerTwo">
$this->billingTotal
</td>
</tr>

</table>
</div>
</td>
</tr>

<tr>
<td colspan="3" align="center" class="threeEightFive">
<div id="dueSum$this->parseLength" class="dueSum">
Total Due on Receipt: &nbsp; $this->billingTotal
</div>
</td>
</tr>

<tr>
<td align="left" class="threeEightFive">
<div id="makePayment$this->parseLength" class="makePayment">
<span class="blackBold">MAKE PAYMENT</span>
<br>
<span class="lightItalic">If mailing a check or money order please include your member number</span>
<p>
<span class="lightItalic">Make checks payable to: &nbsp; $this->businessName</span>
<br>
<span class="lightItalic">Mail payments to: &nbsp; $this->businessStreet $this->businessCity $this->businessState $this->businessZip</span>
</p>
<p>
<span class="lightNormal">$this->firstName $this->middleName $this->lastName</span>
<br>
<span class="lightNormalTwo">Offer Valid Until: &nbsp; $this->invoiceDate</span>
<br>
<span class="lightNormalTwo">Invoice Number: &nbsp; $invoiceNumber</span>
<br>
<span class="lightNormalTwo">Member Number: &nbsp; $this->contractKey</span>
<br><br>
<span class="lightNormalThree">Please fill in Total Amount Paid ________________</span>
</p>
</div>
</td>

<td align="right" colspan="2">
<div id="makePaymentTwo$this->parseLength" class="makePaymentTwo">
<div id="keyContent$this->parseLength" class="keyContent">

<div id="whiteOne$this->parseLength" class="whiteOne">
</div>
<div id="checkTextOne$this->parseLength" class="checkTextOne">
<span class="keyText">Credit Card</span>
</div>
<div id="whiteTwo$this->parseLength" class="whiteTwo">
</div>
<div id="checkTextTwo$this->parseLength" class="checkTextTwo">
<span class="keyText">Check</span>
</div>
<div id="whiteThree$this->parseLength" class="whiteThree">
</div>
<div id="checkTextThree$this->parseLength" class="checkTextThree">
<span class="keyText">Money Order</span>
</div>

<div id="makePayTwoB$this->parseLength" class="makePayTwoB">
<span class="lightNormalThree">Card Number _______________________________</span>
</div>

<div class="spacer">
<div id="whiteOneB$this->parseLength" class="whiteOneB">
</div>
<div id="checkTextOneB$this->parseLength" class="checkTextOneB">
<span class="keyText">Mastercard&nbsp;</span>
</div>
<div id="whiteTwoB$this->parseLength" class="whiteTwoB">
</div>
<div id="checkTextTwoB$this->parseLength" class="checkTextTwoB">
<span class="keyText">Visa&nbsp;</span>
</div>
<div id="whiteThreeB$this->parseLength" class="whiteThreeB">
</div>
<div id="checkTextThreeB$this->parseLength" class="checkTextThreeB">
<span class="keyText">AMEX</span>
</div>
<div id="whiteFourB$this->parseLength" class="whiteFourB">
</div>
<div id="checkTextFourB$this->parseLength" class="checkTextFourB">
<span class="keyText">Disc</span>
</div>

<div id="makePayTwoC$this->parseLength" class="makePayTwoC">
<span class="lightNormalThree">Name On Card _______________________________</span>
<p>
<span class="lightNormalThree">Expiration Date (Month/ Year) _____________</span>
</p>
<p>
<span class="lightNormalThree">Security Code _____________</span>
</p>
<p>
<span class="lightNormalThree">Signature _______________________________</span>
</p>
</div>

</div>
</div>
</div>

</td>
</tr>
</table>
</div>\n\n
PARSEINVOICES;


//echos out the list of standard renewal clients
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
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->endDate</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->groupPrice</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->standardRenewalGrace</b></font>
</td>
</tr>\n";



}
//------------------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------------------
function loadHeader() {

if($this->listType == "phone") {
  $titleDiv = "
  <div id=\"userHeader\">
   Standard Renewal Phone List 
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
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Rate</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Grace Day(s)</font></th>
  </tr>\n";     
  $javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/setContractRecord.js\"></script>";
  }
  
if($this->listType == "email") {
  $titleDiv = "
  <div id=\"userHeader\">
   Standard Renewal Email List 
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
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Rate</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Invoice Type</font></th> 
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Email Status</font></th>
  </tr>\n";       
  }  

if($this->listType == "mail") {
  $titleDiv = "";
  $cssFIle = 'mail4.css';
  //$printFile ="<link rel=\"stylesheet\"  media=\"print\" href=\"../css/printInvoice.css\">";
  $javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/printPage.js\"></script>";
  }  

if($this->listType != "mail") {

$listingsHeader = <<<LISTINGS
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" href="../css/printReport.css">
<script type="text/javascript" src="../scripts/printPage.js"></script>
<script type="text/javascript" src="../scripts/jqueryNew.js"></script>
<script type="text/javascript" src="../scripts/spamContactGuard.js"></script>
<link rel="stylesheet" href="../css/$cssFIle">
$javaScript1
$javaScript2
$javaScript3
$javaScript4
$javaScript5


<title>Standard Renewal $this->todaysDate</title>

</head>
<body>
<div id="logoDiv">
<a href="javascript: void(0)" onClick="printPage()"><img src="../images/contract_logo.png"  /></a>
</div>
<br>
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

<title>Standard Renewal $this->todaysDate</title>

</head>
<body>
LISTINGS;


//this spits out the list of members while the pdf is being generated
$titleDiv = "
<div id=\"userHeader\">
 Standard Renewal Invoiced 
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
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Rate</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Grace Day(s)</font></th>
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


<title>Standard Renewal $this->todaysDate</title>

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
               $this->loadRecordCount();
               break;
               case"email":
               $this->loadHeader();
               $this->loadRecordCount();
               break;
               case"mail":
               $this->loadHeader();
               $this->loadRecordCount();
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