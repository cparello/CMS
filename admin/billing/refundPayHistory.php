<?php
require"../nmi/nmiGatewayClass.php";
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


//=======================================================
//require"../cybersource/gatewayAuth.php";
//require"../cybersource/cybersourceSoapClient.php";

class  refundExchange{

private $purchaseType= null;
private $refundExchangeDate = null;
private $clubId = null;
private $busnessName = null;
private $clubName = null;
private $clubAddress = null;
private $clubPhone = null;
private $receiptItems = null;
private $receiptFormat = null;
private $inventory = null;
private $clubInventory = null;
private $inventoryMarker = null;
private $itemMarkerArray = null;
private $itemMarker = null;
private $transactionId = null;
private $refundStatus = null;
private $typeList = null;
private $returnReason = null;
private $refundExchangeStatus = null;

private $clubInvMarker = null;
private $purchaseMarker = null;
private $numberItems = null;
private $categoryId = null;
private $categoryName =  null;
private $barCode = null;
private $productDescription = null;
private $salesTax = null;
private $wholeCost = null;
private $retailCost = null;
private $totalCost =  null;


function setRequestId($request_id) {
           $this->requestId = $request_id;
           }
function setCkey($c_key){
        $this->cKey = $c_key;
}
function setBillType($bill_type){
        $this->billType = $bill_type;
}  
function setAmount($amount){
        $this->amount = $amount;
}       
function  setPayDate($date){
        $this->paydate = $date;
}
function  setDescrip($descrip){
        $this->descrip = $descrip;
}

 //connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//---------------------------------------------------------------------------------
function formatLetterReceipt() {
$date = date('F j,Y');

$image_name = $this->imageName;
$logo = $headerLogoName;
$bus_name = $this->businessName;
$club_name = $this->clubName;
$club_address = $this->clubAddress;
$club_phone = $this->clubPhone;
$receiptItems = $this->receiptItems;
$retailCost = $this->retailCost;
$salesTax = $this->salesTax;
$totCost =  $this->amount;
$invType =  $invoiceType;

//checks to see if this is a refund
$this->invoiceType = "Invoice Type: RETURN";   


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
<a href=\"javascript: void(0)\" onClick=\"printPage()\"><img src=\"../images/contract_logo.png\" width=\"138\" height=\"54\"/></a>
<br>
<span class=\"logoTxt\">$logo</span>
</div>";
$this->logo = $headerLogoName;
$headerInfo = "<div id=\"headerInfo\" class=\"headerInfo\">
$bus_name
<br>
$club_name
<br>
$club_address
<br>
$club_phone
</div>";

//$this->receiptItems .= "<tr><td class=\"itemName\">$this->productDescription</td><td align=\"left\">\$$this->itemCost<td></tr>";

$itemWindow ="<div id=\"itemContent\">
<table align=\"center\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\" width=95%>
<tr><td class=\"itemName\">$this->descrip</td><td align=\"left\">\$$totCost<td></tr>
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
\$$totCost
</td>
</tr>
<tr><td class=\"totalsSpace\">
&nbsp;
</td>
<td align=\"left\" class=\"totalsName\">
SALES TAX
</td>
<td align=\"right\">
\$0.00
</td>
</tr>
<tr><td class=\"totalsSpace\">
&nbsp;
</td>
<td align=\"left\" class=\"totalsName\">
<span class=\"blackHard\">TOTAL</span>
</td>
<td align=\"right\">
<span class=\"blackHard\">\$$totCost</span>
</td>
</tr>
</table>
</div>";

$receiptFooter = "<div id=\"infoFooter\" class=\"infoFooter\">
Transaction Date: &nbsp;$date
<br>
Invoice #: &nbsp;$this->voidRequestId
<br>
Payment Type:  $this->billType
<br>
Invoice Type: RETURN
<br>
&nbsp;
</div>";

$footer = "</body></html>";
$this->invoiceType = $invoiceType;
$this->html = "$receiptHeader $headerLogo $headerInfo $itemWindow $totalsWindow $receiptFooter $footer";

//echo "$this->receiptFormat";

}
//=======================================================
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
$this-> loadBusinessInfo();
$dbMain = $this->dbconnect();
if ($this->clubId == 0){
        $stmt = $dbMain->prepare("SELECT MIN(club_id) FROM club_info  WHERE club_name != ''");//>=
        $stmt->execute();  
        $stmt->store_result();      
        $stmt->bind_result($clubId); 
        $stmt->fetch();
        $stmt->close();
    }else{
        $clubId = $this->clubId;
    }
    

   $stmt = $dbMain ->prepare("SELECT club_name, club_address, club_phone FROM club_info WHERE club_id ='$clubId'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($this->clubName, $this->clubAddress, $this->clubPhone);
   $stmt->fetch();
$stmt->close();

}
//================================================================================
function csRefund(){
    $this->loadClubInfo();
    
     $dbMain = $this->dbconnect();
     
    $day1 = date('d',strtotime($this->paydate));
    $day2 = date('d',strtotime($this->refundExchangeDate));
    $month1 = date('m',strtotime($this->paydate));
    $month2 = date('m',strtotime($this->refundExchangeDate));
    $year1 = date('Y',strtotime($this->paydate));
    $year2 = date('Y',strtotime($this->refundExchangeDate));
    
     
  
  $stmt = $dbMain->prepare("SELECT MIN(club_id) FROM club_info  WHERE club_name != ''");//>=
  $stmt->execute();  
  $stmt->store_result();      
  $stmt->bind_result($this->clubId); 
  $stmt->fetch();
  $stmt->close();
  
    $stmt = $dbMain ->prepare("SELECT gateway_id, passwordfd FROM billing_gateway_fields WHERE club_id= '$this->clubId'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($userName, $password);
    $stmt->fetch();
    $stmt->close();
    
    $stmt = $dbMain ->prepare("SELECT card_number, card_exp_date, card_fname, card_lname FROM credit_info WHERE contract_key= '$this->cKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($card_number, $card_exp_date, $card_fname, $card_lname);
    $stmt->fetch();
    $stmt->close();
    $name = "$card_fname $card_lname";
    
    $cardMonth = date('m',strtotime($card_exp_date));
    $cardYear = date('y',strtotime($card_exp_date));
    
   


if (($day1 == $day2) AND ($month1 == $month2) AND ($year1 == $year2)){ 

                        $gw = new gwapi;
                        $gw->setLogin("$userName", "$password");
                        $r = $gw->doVoid($this->requestId);
                        
                        $ccAuthDecision = $gw->responses['responsetext'];
                        $authCode = $gw->responses['authcode'];    
                        $transactionId = $gw->responses['transactionid'];
                        $ccAuthReasonCode = $gw->responses['response_code'];
                         $this->voidRequestId = $transactionId;
                         $ccAuthRequestId =  $transactionId;
                 }else{
   
                          $gw = new gwapi;
                        $gw->setLogin("$userName", "$password");
                        $r = $gw->doRefund($this->requestId, $this->amount);
                        
                        $ccAuthDecision = $gw->responses['responsetext'];
                        $authCode = $gw->responses['authcode'];    
                        $transactionId = $gw->responses['transactionid'];
                        $ccAuthReasonCode = $gw->responses['response_code'];
                         $this->voidRequestId = $transactionId;
                         $ccAuthRequestId =  $transactionId;
  

    //$purchaseTotals = new stdClass();
    //$purchaseTotals->currency = "USD";
    //$purchaseTotals->grandTotalAmount = $this->amount;
	//$request->purchaseTotals = $purchaseTotals;
}
    
    ////////////////////////////////////////////////////////////////////////////////////////////////
    
    

	
	

 if($ccAuthReasonCode != 100) {
           $this->paymentStatus = 2;
           $this->transactionId = $ccAuthRequestId;  
      }else{ 
           
            $sql = "INSERT INTO refunded_pay_history VALUES (?,?,?,?,?)";
            $stmt = $dbMain->prepare($sql);
            $stmt->bind_param('idsss', $this->cKey, $this->amount, $this->requestId, $this->voidRequestId, $this->billType);
            if(!$stmt->execute())  {
            	printf("Error: %s.\n", $stmt->error);
               }		
            
            $stmt->close();
        
           $this->paymentStatus = 1;
           $this->transactionId = $ccAuthRequestId;
           $this->formatLetterReceipt();
      }

    
}

//-------------------------------------------------------------------------------------------------
function loadRefundExchange() {
//echo "fubar $this->id";
//exit;
$this->refundExchangeDate = date("Y-m-d H:i:s");
$this->csRefund();

$this->refundExchangeStatus = "$this->purchaseMarker|1";
}
//-------------------------------------------------------------------------------------------------
function getHtml() {
            return($this->html);
            }
function getPaymentStatus() {
            return($this->paymentStatus);
            }
function getImageName(){
            return($this->imageName);
}
function getLogo() {
            return($this->logo);
            }
function getBusinessName() {
            return($this->businessName);
            }
function getClubName(){
            return($this->clubName);
}
function getClubAddress() {
            return($this->clubAddress);
            }
function getClubPhone() {
            return($this->clubPhone);
            } 
function getReceiptItems(){
            return($this->receiptItems);
}
function getRetailCost(){
            return($this->retailCost);
}
function getSalesTax() {
            return($this->salesTax);
            }
function getTotalCost() {
            return($this->totalCost);
            }         
function getInvoiceType(){
            return($this->invoiceType);
}
function getAuthDecision(){
            return($this->ccAuthDecision);
}





}
//============================================


   
 





?>