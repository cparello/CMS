<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class loadDeclinedRejections {

private $contractKey = null;
private $amendKey = null;
private $lateFee = null;
private $nsfFee = null;
private $rejectionFee = null;
private $feeName = null;
private $feeValue = null;
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
private $listType = null;
private $mailHeader = null;
private $counter = 1;
private $rejectedPayment = null;
private $checkNumber = null;
private $rejectedDeclinedHeader = null;
private $rejectedDeclinedText = null;
private $defaultAttempts = null;
private $rejectedDeclinedFreq = null;
private $finalHeader = null;
private $finalText = null;
private $declinedRejectedDate = null;
private $attemptDate = null;
private $attemptNum = null;
private $invoiceHeader = null;
private $printableInvoice = null;
private $invoice = null;
private $billingTotal = null;
private $imageName = null;



function setListType($listType) {
              $this->listType = $listType;
              }
              
function setAmendKey($amendKey) {
              $this->amendKey = $amendKey;
              }              
              
function setImageName($imageName) {
              $this->imageName = $imageName;
              }
              
//---------------------------------------------------------------------------------------------------------------------              
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;              
}
//---------------------------------------------------------------------------------------------------------------------
function loadPdf() {

$declinedRejectDate = strtotime($this->currentStatementDate);

//load the directory path since this is subject to change with each client
$directoryPath = $_SERVER['DOCUMENT_ROOT'];
$directoryArray = explode("/",$directoryPath);
$domainDir = $directoryArray[6];

array_map('unlink', glob("/var/www/vhosts/ems/$domainDir/admin/declinedrejected/*.pdf"));

$fileName = "DeclinedRejected$declinedRejectDate.pdf";
$invoiceSalt = rand(1000, 9000);
$tempFile = "testFile$invoiceSalt.html";
$contentFile = "/var/www/vhosts/ems/$domainDir/admin/declinedrejected/$tempFile";

file_put_contents($contentFile, $this->printableInvoice);

exec("/usr/local/bin/wkhtmltopdf  -s Letter --outline -T 0 -B 0 -R 0 -L 0 $contentFile /var/www/vhosts/ems/$domainDir/admin/declinedrejected/$fileName");

unlink("$contentFile");

//rename the file so it is more legible for download
$fileDate = date("m_d_Y", $declinedRejectDate);
$newFileName = "Declined_Rejected_$fileDate.pdf";

rename("/var/www/vhosts/ems/$domainDir/admin/declinedrejected/$fileName", "/var/www/vhosts/ems/$domainDir/admin/declinedrejected/$newFileName");


}
//---------------------------------------------------------------------------------------------------------------------
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

$this->currentStatementDate =  date("m/d/Y"  ,mktime(0, 0, 0, date("m")  , date("d"), date("Y")));

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
Statement Date:  &nbsp; $this->currentStatementDate
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
$this->rejectedDeclinedText
</div>
</td>
</tr>

<tr>
<td align="left" colspan="2" class="threeEightFour">
<span class="left">
Statement Date:  $this->currentStatementDate  
</span>
</td>
<td align="right" class="threeEightFour">
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
$this->currentStatementDate
</td>
<td align="left" class="innerTwo">
&nbsp;
</td>
<td align="left" class="innerTwo">
Monthly Dues
</td>
<td align="left" class="innerTwo">
$this->monthlyPayment
</td>
<td align="left" class="innerTwo">
0.00
</td>
<td align="left" class="innerTwo">
$this->monthlyPayment
</td>
</tr>

<tr>
<td align="left">
$this->currentStatementDate
</td>
<td align="left">
&nbsp;
</td>
<td align="left">
$this->feeName
</td>
<td align="left">
$this->feeValue
</td>
<td align="left">
0.00
</td>
<td align="left">
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
<span class="lightNormalTwo">Statement Date: &nbsp; $this->currentStatementDate</span>
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
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->checkNumber</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->rejectedPayment</b></font>
</td>
</tr>\n";


}
//---------------------------------------------------------------------------------------------------------------------
function sendEmail() {

if($this->emailAddress != "" AND $this->doNotEmail != 'Y') {

if($this->checkNumber != null) {
   $checkNumberText = "Check Number: $this->checkNumber";
  }


mail("$this->emailAddress", "$this->rejectedDeclinedHeader",

"Hello, $this->firstName $this->middleName $this->lastName

$this->rejectedDeclinedText
 
Declined Amount:  $this->rejectedPayment
$checkNumberText 

Thank you,
$this->businessName

(c)$this->businessName.",
"From: $this->businessName<info@burbankathleticclub.com>","-finfo@burbankathleticclub.com"); 

}

if($this->counter & 1) {
  $this->color = "#D8D8D8";
  }else{
  $this->color = "#FFFFFF";
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
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->checkNumber</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->rejectedPayment</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->invoiceHeader</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"#006633\"><b>INVOICE EMAIL SUCCESSFUL </b></font>
</td>
</tr>\n";

}
//---------------------------------------------------------------------------------------------------------------------
function createPhoneList() {

if($this->counter & 1) {
  $this->color = "#D8D8D8";
  }else{
  $this->color = "#FFFFFF";
  }
  
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
<font face=\"Arial\" size=\"2\" color=\"black\"><b><span id=\"checkNumner\">$this->checkNumber</span></b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"2\" color=\"black\"><b><span id=\"rejectedPayment\">$this->rejectedPayment</span></b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<input type=\"button\" name=\"past\"  id=\"past\" class=\"button1\" value=\"View\" onClick=\"return setContractRecord('$this->contractKey');\"/>
</td>
<input type=\"hidden\" id=\"report_type\" value=\"$this->reportType\"/>
<input type=\"hidden\" id=\"month\" value=\"$this->month\"/>
<input type=\"hidden\" id=\"year\" value=\"$this->year\"/>
</tr>\n";


}
//--------------------------------------------------------------------------------------------------------------------
function loadHeader() {

if($this->listType == "phone") {
  $titleDiv = "
  <div id=\"userHeader\">
   Rejected Transaction List 
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
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Check Number</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Rejected Payment</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">View Account</font></th>
  </tr>\n";     
  $javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/setContractRecord.js\"></script>";
  }
  
if($this->listType == "email") {
  $titleDiv = "
  <div id=\"userHeader\">
   Rejected Transaction(s) Email List 
  </div>";
  $cssFIle = 'phoneEmail.css';
  $tableHeadTag = "<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>\n";
  $tabHead = "
  <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract Key</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Client Name</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Email Address</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Check Number</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Rejected Payment</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Invoice Status</font></th> 
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Email Status</font></th>
  </tr>\n";       
  }  

if($this->listType == "mail") {
  $titleDiv = "";
  $cssFIle = 'mail4.css';
//  $printFile ="<link rel=\"stylesheet\"  media=\"print\" href=\"../css/printInvoice.css\">";
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


<title>Declined Rejections $this->currentStatementDate</title>

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

<title>Declined Rejections $this->currentStatementDate</title>

</head>
<body>
LISTINGS;


//this spits out the list of members while the pdf is being generated
$titleDiv = "
<div id=\"userHeader\">
 Declined Rejected Transaction(s)
</div>";

$cssFIle = 'mailList.css';
$tableHeadTag = "<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>\n";
$tabHead = "
  <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract Key</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Client Name</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Primary Phone</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Cell Phone</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Email Address</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Check Number</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Rejected Payment</font></th>
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


<title>Declined Rejected $this->currentStatementDate</title>

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
//---------------------------------------------------------------------------------------------------------------------
function loadBusinessInfo() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT business_nick, mailing_street, mailing_city, mailing_state, mailing_zip FROM business_info WHERE bus_id = '1'");
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
//---------------------------------------------------------------------------------------------------------------------
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

//---------------------------------------------------------------------------------------------------------------------
function loadDeclinedParameters() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT rd_header, rd_txt, rd_attempts, rd_freq, final_header, final_txt FROM invoice_options WHERE invoice_key = '1'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($rd_header, $rd_txt, $rd_attempts, $rd_freq, $final_header, $final_txt);
$stmt->fetch();

$this->rejectedDeclinedHeader = $rd_header;
$this->rejectedDeclinedText = $rd_txt;
$this->defaultAttempts = $rd_attempts;
$this->rejectedDeclinedFreq = $rd_freq;
$this->finalHeader = $final_header;
$this->finalText = $final_txt;

$stmt->close();  

}
//---------------------------------------------------------------------------------------------------------------------
function updateDeclinedRejectedAttempts() {

  //check to see if the amendKey is set by the user. If so then we do an update if there is a record
  if($this->amendKey != null)  {

     $dbMain = $this->dbconnect();
     $sql = "UPDATE rejected_declined_attempts SET num_attempts= ?, attempt_date= ? WHERE contract_key = '$this->contractKey'";
     $stmt = $dbMain->prepare($sql);
     $stmt->bind_param('is', $numAttempts, $attemptDate);
     
     $attemptDate = date("Y-m-d");
     $numAttempts = $this->attemptNum;

      if(!$stmt->execute())  {
	    printf("Error: %s.\n", $stmt->error);
        }		

     $stmt->close(); 

    }
}

//---------------------------------------------------------------------------------------------------------------------
function insertDeclinedRejectedAttempts() {

  //check to see if the amendKey is set by the user. If so then we do an insert if there is no record
  if($this->amendKey != null)  {

       $dbMain = $this->dbconnect();
       $sql = "INSERT INTO rejected_declined_attempts VALUES (?, ?, ?)";
       $stmt = $dbMain->prepare($sql);
       $stmt->bind_param('isi', $contractKey, $attemptDate, $numAttempts);

       $contractKey = $this->contractKey; 
       $attemptDate = date("Y-m-d");
       $numAttempts = $this->attemptNum;
       
       if(!$stmt->execute())  {
	      printf("Error: %s.\n", $stmt->error);
          }		

          $stmt->close(); 
    }
}
//---------------------------------------------------------------------------------------------------------------------
function loadDeclinedRejectedAttempts() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT attempt_date, num_attempts FROM rejected_declined_attempts WHERE contract_key = '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();   
$rowCount = $stmt->num_rows;
$stmt->bind_result($attempt_date, $num_attempts);
$stmt->fetch();

$this->attemptDate = $attempt_date;
$this->attemptNum = $num_attempts;

$stmt->close(); 


if($rowCount > 0) {
          //creates the attmpt date ratio. if the date is greater than the interval then we process the query
         if($this->attemptDate != "") {
            $declinedRejectedDateSecs = strtotime($this->declinedRejectedDate);
            $attemptDateSecs = strtotime($this->attemptDate);
            $attemptDaysSecs = $this->rejectedDeclinedFreq * 86400;
            $nextAttemptDateSecs = $attemptDateSecs + $attemptDaysSecs;   
            }

                  if($declinedRejectedDateSecs >= $nextAttemptDateSecs) {

                         If($this->attemptNum == $this->defaultAttempts) { 

                                 switch($this->attemptNum) {          
                                          case"1":
                                          $this->invoiceHeader = 'FINAL NOTICE';
                                          break;
                                          case"2":
                                          $this->invoiceHeader = 'FINAL NOTICE';
                                          break;
                                          case"3":
                                          $this->invoiceHeader = 'FINAL NOTICE';
                                          break;
                                          case"4":
                                          $this->invoiceHeader = 'FINAL NOTICE';
                                          break;
                                        }      
                                        
                            }elseif($this->attemptNum <  $this->defaultAttempts) {
                            
                                 switch($this->attemptNum) {          
                                          case"1":
                                          $this->invoiceHeader = 'SECOND NOTICE';
                                          $this->attemptNum = $this->attemptNum + 1;
                                          $this->updateDeclinedRejectedAttempts();
                                          break;
                                          case"2":
                                          $this->invoiceHeader = 'THIRD NOTICE';
                                          $this->attemptNum = $this->attemptNum + 1;
                                          $this->updateDeclinedRejectedAttempts();
                                          break;
                                          case"3":
                                          $this->invoiceHeader = 'FOURTH NOTICE';
                                          $this->attemptNum = $this->attemptNum + 1;
                                          $this->updateDeclinedRejectedAttempts();
                                          break;
                                          case"4":
                                          $this->invoiceHeader = 'FINAL NOTICE'; 
                                          $this->updateDeclinedRejectedAttempts();
                                          break;
                                        }                                  
                            }
                                                        
                     }

  }else{
                     
  $this->invoiceHeader = 'FIRST NOTICE';
  $this->attemptNum = 1;
  $this->insertDeclinedRejectedAttempts();
                     
                     
 }
//end rowcount

}
//---------------------------------------------------------------------------------------------------------------------
function loadFees() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT late_fee, nsf_fee, rejection_fee FROM fees WHERE fee_num = '1'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($late_fee, $nsf_fee, $rejection_fee);
$stmt->fetch();

$this->lateFee = $late_fee;
$this->nsfFee = $nsf_fee;
$this->rejectionFee = $rejection_fee;

$stmt->close();  
}
//--------------------------------------------------------------------------------------------------------------------
function loadDeclinedDetails() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT SUM(payment_amount), transaction_type,  last_attempt_date FROM rejected_payments WHERE reject_bit = '0' AND contract_key='$this->contractKey' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($payment_amount, $transaction_type, $last_attempt_date);
$stmt->fetch();

if($transaction_type == 'A') {
   $this->feeName = 'NSF Fee';
   $this->feeValue = $this->nsfFee;
  }

if($transaction_type == 'C') {
   $this->feeName = 'CC Rejection Fee';
   $this->feeValue = $this->rejectionFee;
  }

$this->rejectedPayment = $payment_amount;
$this->declinedRejectedDate = $last_attempt_date;
$this->checkNumber = null;

$this->billingTotal = $this->rejectedPayment + $this->feeValue;
$this->billingTotal = number_format("$this->billingTotal",2);

$stmt->close();
}
//--------------------------------------------------------------------------------------------------------------------
function loadRejectedDetails() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT check_number, SUM(check_payment), nsf_date FROM nsf_checks WHERE check_bit = '0' AND contract_key='$this->contractKey' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($check_number, $check_payment, $nsfDate);
$stmt->fetch();

   $this->checkNumber = $check_number;
   $this->feeName = 'NSF Fee';
   $this->feeValue = $this->nsfFee;
   $this->rejectedPayment = $check_payment;
   $this->declinedRejectedDate = $nsfDate;
   
   $this->billingTotal = $this->rejectedPayment + $this->feeValue;
   $this->billingTotal = number_format("$this->billingTotal",2);

$stmt->close();

}
//--------------------------------------------------------------------------------------------------------------------
function loadDeclined() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT  DISTINCT contract_key FROM rejected_payments WHERE reject_bit = '0' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($contract_key);

$this->loadHeader();

while ($stmt->fetch()) { 
    $rowCount = $stmt->num_rows;
    if($rowCount > 0){
          $this->contractKey = $contract_key;
           $this->month = $month;
            $this->year = $year;
            $this->reportType = "ER";
            $this->contractKey  = $contract_key;
            $stmt99 = $dbMain ->prepare("SELECT num_text_primary, num_calls_primary, num_text_cell, num_calls_cell, num_emails FROM account_phone_spam_check WHERE contract_key = '$contract_key' AND report_type = 'ER' AND month = '$month' AND year = '$year'");
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
          $this->loadDeclinedDetails();
          $this->loadContactInfo();
          
switch($this->listType) {          
               case"phone":               
               $this->createPhoneList();
               break;
               case"email":  
               $this->loadDeclinedRejectedAttempts();
               $this->sendEmail();
               break;
               case"mail":
               if($this->doNotMail != 'N'){
                $this->loadDeclinedRejectedAttempts();              
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

$this-> loadRejected();

if($this->listType != "mail") {
   echo"</div>\n</body>\n</html>";
   }else{
   $this->mailFooter = "</table>\n</body>\n</html>";   
   
   $this->printableInvoice = "$this->mailHeader $this->invoice $this->mailFooter";
   }


}
//--------------------------------------------------------------------------------------------------------------------
function loadRejected() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT DISTINCT contract_key FROM nsf_checks WHERE check_bit = '0' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($contract_key);

while ($stmt->fetch()) { 
     $rowCount = $stmt->num_rows;
    if($rowCount > 0){
          $this->contractKey = $contract_key;
          $this->loadRejectedDetails();
          $this->loadContactInfo();
          
switch($this->listType) {          
               case"phone":               
               $this->createPhoneList();
               break;
               case"email":  
               $this->loadDeclinedRejectedAttempts();
               $this->sendEmail();
               break;
               case"mail":
               $this->loadDeclinedRejectedAttempts();              
               $this->parseInvoices();
               break;
             }                      
                      
          $this->counter++;
          }
           }
  
$stmt->close();
  
}
//--------------------------------------------------------------------------------------------------------------------
function getPrintableInvoice() {
             return($this->printableInvoice);
             }



}






?>