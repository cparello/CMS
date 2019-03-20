<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class receiptWindowOwed {

private $titleText = null;
private $itemText = null;
private $itemAmount = null;
private $feeText = null;
private $feeAmount = null;
private $totalAmount = null;
private $businessName = null;
private $clubName = null;
private $clubAddress = null;
private $clubPhone = null;
private $cashPayment = null;
private $checkPayment = null;
private $achPayment = null;
private $creditPayment = null;
private $printFormat = null;
private $receiptFormat = null;
private $paymentDate = null;
private $paymentType = null;
private $contractKey = null;
private $imageName = null;


function setImageName($imageName) {
         $this->imageName = $imageName;
         }

function setPrintFormat($printFormat) {
         $this->printFormat = $printFormat;
         }

 //connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//---------------------------------------------------------------------------------
function formatReceipt() {

$receiptHeader = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" href="../css/receiptPrint.css">
<script type="text/javascript" src="../scripts/printPage.js"></script>
<title>Sales Receipt</title>
</head>
<body>';
$header = "<table align=\"center\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\" width=100%>
<tr><td colspan=\"2\" align=\"center\"><a href=\"javascript: void(0)\" onClick=\"printPage()\"><img src=\"../images/$this->imageName\" width=\"69\" height=\"27\"/></a></td></tr>
<tr><td colspan=\"2\" align=\"center\">$this->businessName</td></tr>
<tr><td colspan=\"2\" align=\"center\">$this->clubName</td></tr>
<tr><td colspan=\"2\" align=\"center\">$this->clubAddress</td></tr>
<tr><td colspan=\"2\" align=\"center\">$this->clubPhone<br></td></tr>
<tr><td colspan=\"2\" align=\"center\"></td></tr>
<tr><td colspan=\"2\" align=\"center\">$this->titleText<br><br></td></tr>";

$receiptItem = "<tr><td>$this->itemText</td><td>$this->itemAmount<td></tr>";
$fees =  "<tr><td>$this->feeText</td><td>$this->feeAmount<td></tr>";
$buffer = "<tr><td colspan=\"2\" align=\"center\">&nbsp;</td></tr>";
$totalAmount = "<tr><td>TOTAL:</td><td>$this->totalAmount<td></tr>";

$paymentDate = "<tr><td colspan=\"2\">Transaction Date: &nbsp;$this->paymentDate</td></tr>";
$contractKey = "<tr><td colspan=\"2\">Contract Key: &nbsp;$this->contractKey</td></tr>";
$paymentType = "<tr><td colspan=\"2\">Payment Type:  $this->paymentType</td></tr>";
$footer = "</table></body></html>";


$this->receiptFormat = "$receiptHeader $header $receiptItem $fees $buffer $totalAmount $paymentDate $contractKey  $footer";//$paymentType

}
//---------------------------------------------------------------------------------
function formatLetterReceipt() {

$headerLogoName = strtoupper($this->businessName);

$receiptHeader = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" href="../css/letterReceipt.css">
<script type="text/javascript" src="../scripts/printPage.js"></script>
<title>Sales Receipt</title>
</head>
<body>';

$headerLogo = "<div id=\"header\" class=\"header\">
<a href=\"javascript: void(0)\" onClick=\"printPage()\"><img src=\"../images/$this->imageName\" width=\"138\" height=\"54\"/></a>
<br>
<span class=\"logoTxt\">$this->businessName</span>
</div>";

$headerInfo = "<div id=\"headerInfo\" class=\"headerInfo\">
$this->businessName
<br>
$this->clubName
<br>
$this->clubAddress
<br>
$this->clubPhone
</div>";

$itemWindow ="<div id=\"itemContent\">
<table align=\"center\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\" width=95%>

<tr>
<td class=\"itemName\" colspan=\"2\">$this->titleText <br><br></td>
</tr>

<tr>
<td class=\"itemName\">$this->itemText</td>
<td align=\"left\">\$$this->itemAmount<td>
</tr>

<tr>
<td class=\"itemName\">$this->feeText</td>
<td align=\"left\">\$$this->feeAmount<td>
</tr>

</table>
</div>";

$totalsWindow = "<div id=\"totals\">
<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=95%>
<tr><td class=\"totalsSpace\">
&nbsp;
</td>
<td align=\"left\" class=\"totalsName\">
<span class=\"blackHard\">TOTAL</span>
</td>
<td align=\"right\">
<span class=\"blackHard\">\$$this->totalAmount</span>
</td>
</tr>
</table>
</div>";

$receiptFooter = "<div id=\"infoFooter\" class=\"infoFooter\">
Transaction Date: &nbsp;$this->paymentDate
<br>
Contract #: &nbsp;$this->contractKey
<br>
Payment Type:  $this->paymentType
<br>
&nbsp;
</div>";

$footer = "</body></html>";

$this->receiptFormat = "$receiptHeader $headerLogo $headerInfo $itemWindow $totalsWindow $receiptFooter $footer";

}
//---------------------------------------------------------------------------------
function parseSessionVariables() {
$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT card_fee FROM fees WHERE fee_num ='1' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($card_fee);         
$stmt->fetch(); 
$stmt->close();    
    
$purchaseTotal =  sprintf("%01.2f", $_SESSION['purchaseTotal']);    
        
$this->titleText = $_SESSION['title_text'];
$this->itemText = $_SESSION['item_text'];
$this->itemAmount = $purchaseTotal;
$this->feeText = $_SESSION['fee_text'];
$this->feeAmount = $card_fee;
$this->totalAmount = $purchaseTotal;
$this->contractKey = $_SESSION['contract_key_receipt'];
$this->paymentDate = date('F j Y');
$this->paymentType = $_SESSION['payment_type'];

$this->businessName = $_SESSION['business_name'];
$this->clubName = $_SESSION['club_name'];
$this->clubAddress = $_SESSION['club_address'];
$this->clubPhone = $_SESSION['club_phone'];

     
}
//---------------------------------------------------------------------------------
function loadInvoice() {

 switch ($this->printFormat) {
        case "L":
               $this->parseSessionVariables();
               $this->formatLetterReceipt();
        break;
        case "R":
               $this->parseSessionVariables();
               $this->formatReceipt();
        break;        
       }

}
//---------------------------------------------------------------------------------
function getReceiptFormat() {
      return($this->receiptFormat);
      }



}
//==============================================
include "../contracts/logoSql.php";
$logoSql = new logoSql();
$logoSql->loadLogo();
$image_name = $logoSql-> getImageName();

$print_format = $_SESSION['print_format'];

$loadReceipt = new receiptWindowOwed();
$loadReceipt-> setPrintFormat($print_format); 
$loadReceipt-> setImageName($image_name);
$loadReceipt-> loadInvoice();
$receiptFormat = $loadReceipt-> getReceiptFormat();


echo"$receiptFormat";
exit;

?>












