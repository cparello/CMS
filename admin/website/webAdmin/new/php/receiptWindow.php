<?php
session_start();


class receiptWindow {

private $purchaseMarker = null;
private $purchaseType= null;
private $purchaseDate = null;
private $clubId = null;
private $printFormat = null;
private $retailCost = null;
private $totalCost =  null;
private $itemCost = null;
private $salesTax = null;
private $busnessName = null;
private $clubName = null;
private $clubAddress = null;
private $clubPhone = null;
private $productDescription = null;
private $receiptItems = null;
private $receiptFormat = null;
private $invoiceType = null;
private $cashPayment = null;
private $checkPayment = null;
private $achPayment = null;
private $creditPayment = null;
private $imageName = null;


function setPurchaseMarker($purchaseMarker) {
         $this->purchaseMarker = $purchaseMarker;
         }

function setPurchaseType($purchaseType) {
         $this->purchaseType = $purchaseType;
         }

function setPrintFormat($printFormat) {
         $this->printFormat = $printFormat;
         }
         
function setImageName($imageName) {
         $this->imageName = $imageName;
         }

 //connect to database
function dbconnect()   {
require"../../../../dbConnect.php";
return $dbMain;
}
//---------------------------------------------------------------------------------
function  loadBusinessInfo() {

$dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT  business_name FROM company_names WHERE business_name !='' "); 
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($business_name);      
 $stmt->fetch();
 
$this->businessName = $business_name;


$stmt->close();
}
//---------------------------------------------------------------------------------
function loadClubInfo() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT club_name, club_address, club_phone  FROM club_info WHERE club_id ='$this->clubId' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($club_name, $club_address, $club_phone); 
$stmt->fetch();

$this->clubName = $club_name;
$this->clubAddress = $club_address;
$this->clubPhone = $club_phone;


$stmt->close();

}
//---------------------------------------------------------------------------------
function formatReceipt() {

if(isset($_SESSION['credit_payment'])) {
   $this->creditPayment = 'Credit';       
  }    

//checks to see if this is a refund
if($this->invoiceType != null) {
   $invoiceType = "<tr><td colspan=\"2\">$this->invoiceType</td></tr>";
  }else{
   $invoiceType = "<tr><td colspan=\"2\">Invoice Type: PURCHASE</td></tr>";   
  }


$receiptHeader = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" href="../../../../css/receiptPrint.css">
<script type="text/javascript" src="../../../../scripts/printPage.js"></script>
<title>Sales Receipt</title>
</head>
<body>';
$header = "<table align=\"center\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\" width=100%>
<tr><td colspan=\"2\" align=\"center\"><a href=\"javascript: void(0)\" onClick=\"printPage()\"><img src=\"../img/$this->imageName\" width=\"69\" height=\"27\"/></a></td></tr>
<tr><td colspan=\"2\" align=\"center\">$this->businessName</td></tr>
<tr><td colspan=\"2\" align=\"center\">$this->clubName</td></tr>
<tr><td colspan=\"2\" align=\"center\">$this->clubAddress</td></tr>
<tr><td colspan=\"2\" align=\"center\">$this->clubPhone<br><br></td></tr>";

$this->receiptItems .= "<tr><td>$this->productDescription</td><td>$this->itemCost<td></tr>";

$buffer = "<tr><td colspan=\"2\" align=\"center\">&nbsp;</td></tr>";
$subTotal = "<tr><td>SUB TOTAL:</td><td>$this->retailCost<td></tr>";
$salesTax = "<tr><td>SALES TAX:</td><td>$this->salesTax<td></tr>";
$totalDue= "<tr><td>TOTAL:</td><td>$this->totalCost<td></tr>";
$purchaseDate = "<tr><td colspan=\"2\">Transaction Date: &nbsp;$this->purchaseDate</td></tr>";
$invoiceNumber = "<tr><td colspan=\"2\">Invoice #: &nbsp;$this->purchaseMarker</td></tr>";
$paymentType = "<tr><td colspan=\"2\">Payment Type:  Credit</td></tr>";
$footer = "</table></body></html>";


$this->receiptFormat = "$receiptHeader $header $this->receiptItems $buffer $subTotal $salesTax $totalDue $buffer $purchaseDate $invoiceNumber $paymentType $invoiceType $footer";

}
//---------------------------------------------------------------------------------
function formatLetterReceipt() {

if(isset($_SESSION['credit_payment'])) {
   $this->creditPayment = 'Credit';       
  }    

//checks to see if this is a refund
if($this->invoiceType != null) {
   $invoiceType = "$this->invoiceType";
  }else{
   $invoiceType = "Invoice Type: PURCHASE";   
  }


$headerLogoName = strtoupper($this->businessName);

$receiptHeader = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" href="../../../../css/letterReceipt.css">
<script type="text/javascript" src="../../../../scripts/printPage.js"></script>
<title>Sales Receipt</title>
</head>
<body>';

$headerLogo = "<div id=\"header\" class=\"header\">
<a href=\"javascript: void(0)\" onClick=\"printPage()\"><img src=\"img/$this->imageName\" width=\"138\" height=\"54\"/></a>
<br>
<span class=\"logoTxt\">$headerLogoName</span>
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

$this->receiptItems .= "<tr><td class=\"itemName\">$this->productDescription</td><td align=\"left\">\$$this->itemCost<td></tr>";

$itemWindow ="<div id=\"itemContent\">
<table align=\"center\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\" width=95%>
$this->receiptItems
</table>
</div>";

$totalsWindow = "<div id=\"totals\">
<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=95%>
<tr><td class=\"totalsSpace\">
&nbsp;
</td>
<td align=\"left\" class=\"totalsName\">
SUBTOTAL
</td>
<td align=\"right\">
\$$this->retailCost
</td>
</tr>
<tr><td class=\"totalsSpace\">
&nbsp;
</td>
<td align=\"left\" class=\"totalsName\">
SALES TAX
</td>
<td align=\"right\">
\$$this->salesTax
</td>
</tr>
<tr><td class=\"totalsSpace\">
&nbsp;
</td>
<td align=\"left\" class=\"totalsName\">
<span class=\"blackHard\">TOTAL</span>
</td>
<td align=\"right\">
<span class=\"blackHard\">\$$this->totalCost</span>
</td>
</tr>
</table>
</div>";

$receiptFooter = "<div id=\"infoFooter\" class=\"infoFooter\">
Transaction Date: &nbsp;$this->purchaseDate
<br>
Invoice #: &nbsp;$this->purchaseMarker
<br>
Payment Type:  $this->creditPayment
<br>
$invoiceType
<br>
&nbsp;
</div>";

$footer = "</body></html>";

$this->receiptFormat = "$receiptHeader $headerLogo $headerInfo $itemWindow $totalsWindow $receiptFooter $footer";

}
//---------------------------------------------------------------------------------
function createPosInvoice() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT retail_cost, total_cost, club_id, purchase_date FROM merchant_sales WHERE purchase_marker ='$this->purchaseMarker' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($retail_cost, $total_cost, $club_id, $purchase_date);     


while($stmt->fetch()) {

         $this->retailCost = $this->retailCost + $retail_cost;
         $this->totalCost = $this->totalCost + $total_cost;  
         $this->clubId = $club_id;
         $this->purchaseDate = date("m/d/Y H:i", strtotime($purchase_date));
         
        }
        
$stmt->close();

$this->salesTax = $this->totalCost - $this->retailCost;
$this->salesTax = sprintf("%.2f", $this->salesTax);
$this->retailCost = sprintf("%.2f", $this->retailCost);
$this->totalCost = sprintf("%.2f", $this->totalCost);
$this->loadBusinessInfo();
$this->loadClubInfo();

$stmt2 = $dbMain ->prepare("SELECT product_desc, retail_cost  FROM merchant_sales WHERE purchase_marker ='$this->purchaseMarker' ");
$stmt2->execute();      
$stmt2->store_result();      
$stmt2->bind_result($product_desc, $retail_cost);    

while($stmt2->fetch()) {

         $this->productDescription = $product_desc;
         $this->itemCost = $retail_cost;
         
            if($this->printFormat == 'L') {
                $this->formatLetterReceipt();
               }elseif($this->printFormat == 'R') {
                 $this->formatReceipt();               
               }
         
        }

$stmt2->close();

           
}
//---------------------------------------------------------------------------------
function createScheduleClassInvoice() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT sm_club_id, sm_service_quantity, sm_service_name, sm_service_price, sm_purchase_date  FROM schedular_member_sales WHERE sm_sales_key ='$this->purchaseMarker' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($clubId, $serviceQuantity, $serviceName, $servicePrice, $purchaseDate);  
$stmt->fetch();


$this->retailCost = $servicePrice;
$this->totalCost = $servicePrice;  
$this->clubId = $clubId;
$this->purchaseDate = date("m/d/Y H:i", strtotime($purchaseDate));

$this->salesTax = 0;
$this->salesTax = sprintf("%.2f", $this->salesTax);
$this->retailCost = sprintf("%.2f", $this->retailCost);
$this->totalCost = sprintf("%.2f", $this->totalCost);
$this->loadBusinessInfo();
$this->loadClubInfo();

$this->productDescription = "$serviceQuantity $serviceName Class(s)";
$this->itemCost = $servicePrice;

            if($this->printFormat == 'L') {
                $this->formatLetterReceipt();
               }elseif($this->printFormat == 'R') {
                 $this->formatReceipt();               
               }

$stmt->close();

}
//---------------------------------------------------------------------------------
function parseSessionVariables() {

$productArray = $_SESSION['product_array'];
$this->businessName = $_SESSION['business_name'];
$this->clubName  = $_SESSION['club_name'];
$this->clubAddress =  $_SESSION['club_address'];
$this->clubPhone = $_SESSION['club_phone'];
$this->salesTax = $_SESSION['sales_tax'];
$this->retailCost =  $_SESSION['retail_cost'];
$this->totalCost =  $_SESSION['total_cost'];
$this->purchaseDate =  $_SESSION['purchase_date'];


$productArrayParent = explode("^", $productArray);
$productArrayCount = count($productArrayParent);

for($i = 0; $i <= $productArrayCount; $i++) {
      
          $productArrayChild = $productArrayParent[$i];
      
      if($productArrayChild != "") {
          
          $priceDescArray = explode("|", $productArrayChild);
          $this->productDescription = $priceDescArray[0];
          $this->itemCost = $priceDescArray[1];
         
            if($this->printFormat == 'L') {
                $this->formatLetterReceipt();
               }elseif($this->printFormat == 'R') {
                 $this->formatReceipt();               
               }

         }
        
        
     }
     
     
        
     
}
//---------------------------------------------------------------------------------
function loadPurchaseInfo() {

 switch ($this->purchaseType) {
        case "pos":
               $this->createPosInvoice();
        break;
        case "ref":
               $this->invoiceType = 'Invoice Type:  REFUND';
               $this->parseSessionVariables();
        break;        
        case "sale":
               //will insert later
        break;
        case "due":
              //wil insert later
        break;
        case "R":
               $this->invoiceType = 'Invoice Type:  REFUND';
               $this->cashPayment = 'Cash';
               $this->parseSessionVariables();
        break; 
        case "E":
               $this->invoiceType = 'Invoice Type:  EXCHANGE';
               $this->cashPayment = 'NA';
               $this->parseSessionVariables();
        break;     
        case "C":
              $this->createScheduleClassInvoice();
        break;                
    }

}
//---------------------------------------------------------------------------------
function getReceiptFormat() {
      return($this->receiptFormat);
      }



}
//==============================================

include "webLogoSql.php";
$logoSql = new logoSql();
$logoSql->loadLogo();
$image_name = $logoSql-> getImageName();

$purchase_marker = $_SESSION['purchase_marker'];
$purchase_type = $_SESSION['purchase_type'];
$print_format = $_SESSION['print_format'];

$loadReceipt = new receiptWindow();
$loadReceipt-> setPurchaseMarker($purchase_marker);
$loadReceipt-> setPurchaseType($purchase_type);
$loadReceipt-> setPrintFormat($print_format);
$loadReceipt-> setImageName($image_name);
$loadReceipt-> loadPurchaseInfo();
$receiptFormat = $loadReceipt-> getReceiptFormat();

unset($_SESSION['purchase_marker']);
unset($_SESSION['purchase_type']);
unset($_SESSION['print_format']);

echo"$receiptFormat";
exit;

?>












