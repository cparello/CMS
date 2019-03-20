<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
require"../nmi/nmiGatewayClass.php";


//=======================================================
require"../cybersource/gatewayAuth.php";
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


function setId($id) {
           $this->id = $id;
           }
function setPoskey($pos_key){
        $this->posKey = $pos_key;
}
function setInvoice($invoice) {
    $this->invoice = $invoice;
}         
       

 //connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//---------------------------------------------------------------------------------
function formatLetterReceipt() {
$date = date('F j,Y',strtotime($this->purchaseDate));

$image_name = $this->imageName;
$logo = $headerLogoName;
$bus_name = $this->businessName;
$club_name = $this->clubName;
$club_address = $this->clubAddress;
$club_phone = $this->clubPhone;
$receiptItems = $this->receiptItems;
$retailCost = $this->retailCost;
$salesTax = $this->salesTax;
$totCost =  $this->totalCost;
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
$receiptItems
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
\$$retailCost
</td>
</tr>
<tr><td class=\"totalsSpace\">
&nbsp;
</td>
<td align=\"left\" class=\"totalsName\">
SALES TAX
</td>
<td align=\"right\">
\$$salesTax
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
Invoice #: &nbsp;$this->purchaseMarker
<br>
Payment Type:  $this->cashPayment $this->checkPayment $this->achPayment $this->creditPayment
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
//===========================================================
function deleteSale(){
$dbMain = $this->dbconnect();
if ($this->id == 'void1'){
    $sql2 = "DELETE FROM merchant_sales WHERE item_marker ='$this->posKey' ";
    $stmt2 = $dbMain->prepare($sql2);  
    $stmt2->execute();
    $stmt2->close();
}else{
     $sql2 = "DELETE FROM merchant_sales WHERE purchase_marker = '$this->invoice'";
     $stmt2 = $dbMain->prepare($sql2);  
     $stmt2->execute();
     $stmt2->close();
}    

}
//-------------------------------------------------------------------------------------------------
function loadSalesRecord() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT item_marker, club_inv_marker, purchase_marker, number_items, category_id, category_name, bar_code, product_desc, sales_tax, whole_cost, retail_cost, total_cost, transaction_id, purchase_date, club_id FROM merchant_sales WHERE item_marker ='$this->posKey' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($item_marker, $club_inv_marker, $purchase_marker, $number_items, $category_id, $category_name, $bar_code, $product_desc, $sales_tax, $whole_cost, $retail_cost, $total_cost, $trans_id, $this->purchaseDate, $this->clubId); 
$stmt->fetch();

$this->clubInvMarker = $club_inv_marker;
$this->itemMarker = $item_marker;

$this->loadClubInventory();
$this->clubInventory = $this->inventory + 1;
$this->updateClubInventory();


$this->purchaseMarker = $purchase_marker;
$this->numberItems = $number_items;
$this->categoryId = $category_id;
$this->categoryName = $category_name;
$this->barCode = $bar_code;
$this->productDescription = $product_desc;
$this->salesTax = $sales_tax;
$this->wholeCost = $whole_cost;
$this->retailCost = $retail_cost;
//echo"fu  $this->retailCost  bar";
$this->totalCost = $total_cost;
$this->transId = $trans_id;
$this->loadClubInfo();

$this->insertRefundExchange();

$length = strlen($this->transId);
    $string = substr($this->transId,$length-3,3);
    if ($string == 'CMP'){
        $this->paymentStatus = 1;
        $this->cashPayment = 'Cash/Check';
        $dbMain = $this->dbconnect();
        $ccAuthRequestId = "Cash/Check";
            $sql = "INSERT INTO refunded_transactions VALUES (?,?,?,?)";
            $stmt = $dbMain->prepare($sql);
            $stmt->bind_param('isds', $this->purchaseMarker, $this->refundExchangeDate, $this->totalCost, $ccAuthRequestId);
            if(!$stmt->execute())  {
            	printf("Error: %s.\n", $stmt->error);
               }		
            
            $stmt->close();
    }else{
        
        $this->creditPayment = 'Credit';
        $this->csRefund();  
    }
$this->receiptItems .= "<tr><td class=\"itemName\">$this->productDescription</td><td align=\"left\">\$$this->retailCost<td></tr>"; 
   
$stmt->close();
  if ($this->paymentStatus == 1){
    $this->deleteSale();
    $this->formatLetterReceipt();
  }
 
}
//================================================================================
function csRefund(){
    
    $dbMain = $this->dbconnect();
    
    $day1 = date('d',strtotime($this->purchaseDate));
    $day2 = date('d',strtotime($this->refundExchangeDate));
    $month1 = date('m',strtotime($this->purchaseDate));
    $month2 = date('m',strtotime($this->refundExchangeDate));
    $year1 = date('Y',strtotime($this->purchaseDate));
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
    
    
    $stmt = $dbMain ->prepare("SELECT card_name, card_number, total, month, year, auth_id FROM merchant_refund_records WHERE pos_identifier= '$this->purchaseMarker'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($name, $ccCardNumber, $ccCardPayment, $ccCardMonth, $ccCardYear, $transaction_id);
    $stmt->fetch();
    $stmt->close();
        //echo "test $ccCardNumber  $password";
        //exit;       
    
  /*  if (($day1 == $day2) AND ($month1 == $month2) AND ($year1 == $year2)){
        
                        $gw = new gwapi;
                        $gw->setLogin("$userName", "$password");
                        $r = $gw->doVoid($transaction_id);
                        
                        $ccAuthDecision = $gw->responses['responsetext'];
                        $authCode = $gw->responses['authcode'];    
                        $transactionId = $gw->responses['transactionid'];
                        $ccAuthReasonCode = $gw->responses['response_code'];
                         $this->voidRequestId = $transactionId;
                         $ccAuthRequestId =  $transactionId;
        
     
}else{*/
                        $gw = new gwapi;
                        $gw->setLogin("$userName", "$password");
                        $r = $gw->doRefund($transaction_id, $this->totalCost);
                        
                        $ccAuthDecision = $gw->responses['responsetext'];
                        $authCode = $gw->responses['authcode'];    
                        $transactionId = $gw->responses['transactionid'];
                        $ccAuthReasonCode = $gw->responses['response_code'];
                         $this->voidRequestId = $transactionId;
                         $ccAuthRequestId =  $transactionId;
                         
                       //  }

 if($ccAuthReasonCode != 100) {
           $this->paymentStatus = 2;
           $this->transactionId = $ccAuthRequestId;  
      }else{ 
            $dbMain = $this->dbconnect();
            $sql = "INSERT INTO refunded_transactions VALUES (?,?,?,?)";
            $stmt = $dbMain->prepare($sql);
            $stmt->bind_param('isds', $this->purchaseMarker, $this->refundExchangeDate, $this->totalCost, $ccAuthRequestId);
            if(!$stmt->execute())  {
            	printf("Error: %s.\n", $stmt->error);
               }		
            
            $stmt->close();
        
           $this->paymentStatus = 1;
           $this->transactionId = $ccAuthRequestId;
      }

    
}
//-------------------------------------------------------------------------------------------------
function loadTotalSalesRecord() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT item_marker, club_inv_marker, purchase_marker, number_items, category_id, category_name, bar_code, product_desc, sales_tax, whole_cost, retail_cost, total_cost,transaction_id, purchase_date, club_id  FROM merchant_sales WHERE purchase_marker ='$this->invoice' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($item_marker, $club_inv_marker, $purchase_marker, $number_items, $category_id, $category_name, $bar_code, $product_desc, $sales_tax, $whole_cost, $retail_cost, $total_cost, $trans_id, $this->purchaseDate, $this->clubId); 
while ($stmt->fetch()){
    
    $this->itemMarker = $item_marker;
    $this->clubInvMarker = $club_inv_marker;
    $this->loadClubInventory();
    $this->clubInventory = $this->inventory + 1;
    $this->updateClubInventory();
    
    
    $this->purchaseMarker = $purchase_marker;
    $this->numberItems = $number_items;
    $this->categoryId = $category_id;
    $this->categoryName = $category_name;
    $this->barCode = $bar_code;
    $this->productDescription = $product_desc;
    $this->salesTax = $sales_tax;
    $this->wholeCost = $whole_cost;
    $this->retailCost = $retail_cost;
    $this->totalCost = $total_cost;
    
    $this->totTax += $sales_tax;
    $this->wholeCostTotal += $whole_cost;
    $this->retailCostTotal += $retail_cost;
    $this->totalCostTotal += $total_cost;
    $this->transId = $trans_id;
    $this->loadClubInfo();
    
    $this->insertRefundExchange();
    
    $this->receiptItems .= "<tr><td class=\"itemName\">$this->productDescription</td><td align=\"left\">\$$this->retailCost<td></tr>"; 
}
$length = strlen($this->transId);
    $string = substr($this->transId,$length-3,3);
    if ($string == 'CMP'){
        $this->paymentStatus = 1;
        $this->cashPayment = 'Cash/Check';
        $dbMain = $this->dbconnect();
            $sql = "INSERT INTO refunded_transactions VALUES (?,?,?,?)";
            $stmt = $dbMain->prepare($sql);
            $stmt->bind_param('isds', $this->purchaseMarker, $this->refundExchangeDate, $this->totalCostTotal, $this->cashPayment);
            if(!$stmt->execute())  {
            	printf("Error: %s.\n", $stmt->error);
               }		
            
            $stmt->close();
    }else{
        $this->creditPayment = 'Credit';  
        $this->csRefund();
    }

$this->salesTax = sprintf("%.2f", $this->totTax);;
$this->retailCost = sprintf("%.2f", $this->retailCostTotal);
$this->totalCost = sprintf("%.2f", $this->totalCostTotal);
 if ($this->paymentStatus == 1){
    $this->deleteSale();
    $this->formatLetterReceipt();
  }


$stmt->close();

}
//-------------------------------------------------------------------------------------------------
function insertRefundExchange() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO refund_exchange VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('issiiiisssddddssi', $re_marker, $re_type, $return_reason, $item_marker, $purchase_marker, $number_items, $category_id, $category_name, $bar_code, $product_desc, $sales_tax, $whole_cost, $retail_cost, $total_cost, $re_date, $club_id, $club_inv_marker);

$re_marker = null; 
$re_type = 'R';
$return_reason = 'E';
$item_marker = $this->itemMarker;
$purchase_marker = $this->purchaseMarker;
$number_items = $this->numberItems; 
$category_id = $this->categoryId; 
$category_name = $this->categoryName; 
$bar_code = $this->barCode; 
$product_desc = $this->productDescription; 
$sales_tax = $this->salesTax; 
$whole_cost = $this->wholeCost;
$retail_cost =  $this->retailCost;
$total_cost = $this->totalCost;
$re_date = $this->refundExchangeDate; 
$club_id = $this->clubId;
$club_inv_marker = $this->clubInvMarker;

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

$stmt->close();

}
//-------------------------------------------------------------------------------------------------
function loadClubInventory() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT inventory FROM club_inventory WHERE club_inv_marker ='$this->clubInvMarker' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($inventory); 
$stmt->fetch();

$this->inventory = $inventory;

$stmt->close();

}
//---------------------------------------------------------------------------------------------------
function updateClubInventory() {

$dbMain = $this->dbconnect();
$sql = "UPDATE club_inventory SET inventory=? WHERE club_inv_marker=?";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('ii' , $inventory, $club_inv_marker); 
             
             $inventory = $this->clubInventory;
             $club_inv_marker = $this->clubInvMarker;
             
       if(!$stmt->execute())  {    
	      printf("Error: %s.\n", $stmt->error );
          }
          
 $stmt->close();

}


//-------------------------------------------------------------------------------------------------
function loadRefundExchange() {
//echo "fubar $this->id";
//exit;
$this->refundExchangeDate = date("Y-m-d H:i:s");
if ($this->id == 'void1'){
    $this->loadSalesRecord();
    
}else{
     $this->loadTotalSalesRecord();
}


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





}
//============================================


   
 





?>