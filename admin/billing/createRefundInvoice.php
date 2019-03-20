<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class createRefundInvoice {

private $contractKeyInvoice = null;
private $refundBalance = null;
private $refundArray = null;
private $firstName = null;
private $middleName = null;
private $lastName = null;
private $streetAddress = null;
private $cityName = null;
private $stateName = null;
private $zipCode = null;
private $imageName = null;
private $businessName = null;
private $businessStreet = null;
private $businessCity = null;
private $businessState = null;
private $businessZip = null;
private $invoice = null;
private $statementDate = null;
private $refundRow = null;


function setContractKeyInvoice($contractKeyInvoice) {
                  $this->contractKeyInvoice = $contractKeyInvoice;
              }

function setRefundBalance($refundBalance) {
                  $this->refundBalance = $refundBalance;
              }

function setRefundArray($refundArray) {
                  $this->refundArray = $refundArray;
              }

function setFirstName($firstName) {
                  $this->firstName = $firstName;
              }

function setMiddleName($middleName) {
                  $this->middleName = $middleName;
              }

function setLastName($lastName) {
                  $this->lastName = $lastName;
              }

function setStreetAddress($streetAddress) {
                  $this->streetAddress = $streetAddress;
              }

function setCityName($cityName) {
                  $this->cityName = $cityName;
              }

function setStateName($stateName) {
                  $this->stateName = $stateName;
              }

function setZipCode($zipCode) {
                  $this->zipCode = $zipCode;
             }

function setImageName($imageName) {
                  $this->imageName = $imageName;
            }
            


//-------------------------------------------------------------------------------------------------------------------             
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;              
}
//-----------------------------------------------------------------------------------------------------------------
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
//-----------------------------------------------------------------------------------------------------------------
function parseRefundRecords() {

$this->statementDate = date("F j, Y");
$refundArray = explode("|", $this->refundArray);
$arrayCountOne = count($refundArray);

for($i=0; $i < $arrayCountOne; $i++)  {

           $refundRecord = $refundArray[$i];

         if($refundRecord != "") {
    
            $dataArray = explode(",", $refundRecord);
            $refundType = $dataArray[0];
            $serviceName = $dataArray[1];
            $refundAmount = $dataArray[2];
            
            $this->refundRow .= "
            <tr>
            <td align=\"left\" class=\"innerTwo\">
            $this->statementDate
            </td>
            <td align=\"left\" class=\"innerTwo\">
            $refundType $serviceName
            </td>
            <td align=\"left\" class=\"innerTwo\">
            &nbsp;
            </td>
            <td align=\"left\" class=\"innerTwo\">
            $refundAmount 
            </td>
            <td align=\"left\" class=\"innerTwo\">
            0.00 
           </td>
           </tr>";
      
           }
    }

}
//-----------------------------------------------------------------------------------------------------------------
function parseInvoice() {

$invoiceSalt = rand(1000, 9000);
$sep = '-';
$invoiceNumber = "$this->contractKeyInvoice$sep$invoiceSalt";

$in = in;

$titleDiv = "";
$cssFIle = 'mail4.css'; 
$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/printPage.js\"></script>";

$this->invoice = <<<PARSEINVOICES

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" href="../css/$cssFIle">
$printFile
$javaScript1
$javaScript2

<title>Refund Statement</title>

</head>
<body>

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

Contract Number: &nbsp; $this->contractKeyInvoice
</div>
</td>
</tr>

<tr>
<td class="toSpacer">
<div id="toWindow$this->parseLength" class="toWindow">
$this->firstName $this->middleName $this->lastName
<br>
$this->streetAddress
<br>
$this->cityName $this->stateName $this->zipCode
</div>
</td>
<td class="threeEightTwo">
<div id="noteLable$this->parseLength" class="noteLable">
Note:
</div>
</td>
<td class="threeEightThree">
<div id="noteText$this->parseLength" class="noteText">
Refund for services purchased
</div>
</td>
</tr>

<tr>
<td align="left"  class="threeEightFour">
<span class="left">
Statement Date:  &nbsp; $this->statementDate  
</span>
</td>
<td align="right" colspan="2" class="threeEightFour">
<span class="right">
SERVICE REFUND
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

$this->refundRow


</table>
</div>
</td>
</tr>

<tr>
<td colspan="3" align="center" class="threeEightFive">
<div id="dueSum$this->parseLength" class="dueSum">
Total Credits: &nbsp; $this->refundBalance
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
<span class="lightNormalTwo">Statement Date: &nbsp; $statementDate</span>
<br>
<span class="lightNormalTwo">Invoice Number: &nbsp; $invoiceNumber</span>
<br>
<span class="lightNormalTwo">Member Number: &nbsp; $this->contractKeyInvoice</span>
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

</body>
</html>
PARSEINVOICES;


echo"$this->invoice";


}
//-----------------------------------------------------------------------------------------------------------------
function loadInvoice() {

$this->loadBusinessInfo();
$this->parseRefundRecords();
$this->parseInvoice();

}
//-----------------------------------------------------------------------------------------------------------------



}
//=================================================================

$contract_key_invoice = $_SESSION['contract_key_invoice'];
$refund_balance = $_SESSION['refund_balance'];
$refund_array = $_SESSION['refund_array'];
$first_name = $_SESSION['first_name'];
$middle_name = $_SESSION['middle_name'];
$last_name = $_SESSION['last_name'];
$street_address = $_SESSION['street_address'];
$city_name = $_SESSION['city_name'];
$state_name = $_SESSION['state_name'];
$zip_code = $_SESSION['zip_code'];


include "../contracts/logoSql.php";
$logoSql = new logoSql();
$logoSql->loadLogo();
$image_name = $logoSql-> getImageName();


$createInvoice = new createRefundInvoice();
$createInvoice-> setContractKeyInvoice($contract_key_invoice);
$createInvoice-> setRefundBalance($refund_balance);
$createInvoice-> setRefundArray($refund_array);
$createInvoice-> setFirstName($first_name);
$createInvoice-> setMiddleName($middle_name);
$createInvoice-> setLastName($last_name);
$createInvoice-> setStreetAddress($street_address);
$createInvoice-> setCityName($city_name);
$createInvoice-> setStateName($state_name);
$createInvoice-> setZipCode($zip_code);
$createInvoice-> setImageName($image_name);
$createInvoice-> loadInvoice();

unset($_SESSION['contract_key_invoice']);
unset($_SESSION['refund_balance']);
unset($_SESSION['refund_array']);
unset($_SESSION['first_name']);
unset($_SESSION['middle_name']);
unset($_SESSION['last_name']);
unset($_SESSION['street_address']);
unset($_SESSION['city_name']);
unset($_SESSION['state_name']);
unset($_SESSION['zip_code']);

?>