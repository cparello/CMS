<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


require"../nmiGatewayClass.php";
//=======================================================
//require"../cybersource/gatewayAuth.php";
//require"../cybersource/cybersourceSoapClient.php";


class  refundPosPurchase{

private $purchaseMarker = null;
private $deleteMarker = null;
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
private $inventory = null;
private $inventoryMarker = null;
private $transactionId = null;
private $refundStatus = null;


function setPurchaseMarker($purchaseMarker) {
           $this->purchaseMarker = $purchaseMarker;
           }

 //connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
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
//-------------------------------------------------------------------------------------------------
function createSessionVariables() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT retail_cost, total_cost, club_id, purchase_date FROM merchant_sales WHERE purchase_marker ='$this->purchaseMarker' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($retail_cost, $total_cost, $club_id, $purchase_date);     
$numRows = $stmt->num_rows;

//if the number of rows is zero then we create a maker so the inventory will not be deleted 
$this->deleteMarker = $numRows;

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
         
         $productArray .= "$this->productDescription|$this->itemCost^";
         
        }

$stmt2->close();

//if re submit then do not asign variables
if($this->productDescription != "") {

  $_SESSION['product_array'] = $productArray;
  $_SESSION['business_name'] = $this->businessName;
  $_SESSION['club_name'] = $this->clubName;
  $_SESSION['club_address'] = $this->clubAddress;
  $_SESSION['club_phone'] = $this->clubPhone;
  $_SESSION['sales_tax'] = $this->salesTax;
  $_SESSION['retail_cost'] = $this->retailCost;
  $_SESSION['total_cost'] = $this->totalCost;
  $_SESSION['purchase_date'] = $this->purchaseDate;
  }


}
//------------------------------------------------------------------------------------------------
function updateInventory() {

$dbMain = $this->dbconnect();
$sql = "UPDATE club_inventory SET inventory=? WHERE inventory_marker='$this->inventoryMarker' ";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('i' , $inventory); 
             
$inventory = $this->inventory + 1;
             
if(!$stmt->execute())  {    
  printf("Error: %s.\n", $stmt->error );
  }
          
$stmt->close();



}
//------------------------------------------------------------------------------------------------
function deleteMerchantSales() {

$dbMain = $this->dbconnect();
$sql = "DELETE FROM merchant_sales WHERE purchase_marker = ? ";
		if ($stmt = $dbMain->prepare($sql))   {
			$stmt->bind_param("i", $this->purchaseMarker);
			$stmt->execute();
			$stmt->close();
           }else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql");
		   }
   
}
//------------------------------------------------------------------------------------------------
function resetInventory() {

if($this->deleteMarker != 0) {

$dbMain = $this->dbconnect();
$stmt1 = $dbMain ->prepare("SELECT whole_cost, bar_code, club_id, transaction_id  FROM merchant_sales WHERE purchase_marker ='$this->purchaseMarker' ");
$stmt1->execute();      
$stmt1->store_result();      
$stmt1->bind_result($whole_cost, $bar_code, $club_id, $transaction_id);     


while($stmt1->fetch()) {
        
       $this->transactionId = $transaction_id;

       $stmt2 = $dbMain ->prepare("SELECT inventory, inventory_marker  FROM club_inventory WHERE whole_cost ='$whole_cost' AND bar_code = '$bar_code' AND club_id = '$club_id' ");
       $stmt2->execute();      
       $stmt2->store_result();      
       $stmt2->bind_result($inventory, $inventory_marker);
       $stmt2->fetch();

       $this->inventory = $inventory;
       $this->inventoryMarker = $inventory_marker;
       $this->updateInventory();

      }

$this->deleteMerchantSales();


$stmt1->close();
$stmt2->close();

}

}
//------------------------------------------------------------------------------------------------
function checkGatewayRefund() {

    if(preg_match('/CMP/',$this->transactionId)) {
       $this->transactionId = null;
     }
}
//------------------------------------------------------------------------------------------------
function parseRefund() {

if(!isset($_SESSION['product_array'])) {

  $this->createSessionVariables();
  $this->resetInventory();
  $this->checkGatewayRefund();
  
 
  
  $this->refundStatus = 1;
  
  }else{
  
   $this->refundStatus = 1;
  
  }


}
//------------------------------------------------------------------------------------------------
function getRefundStatus() {
        return($this->refundStatus);
        }
function getTransactionId() {
        return($this->transactionId);
        }


}
//=======================================================
$purchase_marker = $_REQUEST['purchase_marker'];
$ajax_switch = $_REQUEST['ajax_switch'];

if($ajax_switch == 1) {
   
   $refundPurchase = new refundPosPurchase();
   $refundPurchase-> setPurchaseMarker($purchase_marker);
   $refundPurchase-> parseRefund();
   $refund_status = $refundPurchase-> getRefundStatus();   
   $transaction_id = $refundPurchase-> getTransactionId();
 
    
    $clubId = $_SESSION['location_id'];
    require"../dbConnect.php";
    
    $stmt = $dbMain->prepare("SELECT MIN(club_id) FROM club_info  WHERE club_name != ''");//>=
    $stmt->execute();  
    $stmt->store_result();      
    $stmt->bind_result($clubId); 
    $stmt->fetch();
    $stmt->close();
    
    $stmt = $dbMain ->prepare("SELECT gateway_id, passwordfd FROM billing_gateway_fields WHERE club_id= '$clubId'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($userName, $password);
    $stmt->fetch();
    $stmt->close();
    
    $stmt = $dbMain ->prepare("SELECT card_name, card_number, total, month, year, auth_id, card_type, trans_token FROM merchant_refund_records WHERE pos_identifier= '$purchase_marker'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($name, $ccCardNumber, $ccCardPayment, $ccCardMonth, $ccCardYear, $transaction_id, $card_type, $transToken);
    $stmt->fetch();
    $stmt->close();
    //echo "tid $transaction_id";
    //exit;
    
     if(preg_match('/CMP/',$transaction_id)) {
       $transaction_id = null;
     }
    
   if($transaction_id != null)  {
            
        $gw = new gwapi;
        $gw->setLogin("$userName", "$password");
        $r = $gw->doVoid($transaction_id);
    
    
       
        $ccAuthDecision = $gw->responses['responsetext'];
        $vaultId = $gw->responses['customer_vault_id'];
        $authCode = $gw->responses['authcode'];    
        $transaction_id = $gw->responses['transactionid'];
        $ccAuthReasonCode = $gw->responses['response_code'];
    
      if ($ccAuthReasonCode == '100') {
          $refund_status = 1;
          }elseif ($ccAuthReasonCode != '100'){
          $refund_status = 2;
          }
        
     
       }
   
   echo"$refund_status";
   exit;


  }










?>