<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
require"../nmiGatewayClass.php";

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


function setItemMarkerArray($itemMarkerArray) {
           $this->itemMarkerArray = $itemMarkerArray;
           }

function setTypeList($typeList) {
           $this->typeList = $typeList;
           }

function setReturnReason($returnReason) {
          $this->returnReason = $returnReason;
          }

function setClubId($clubId) {
          $this->clubId = $clubId;
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
//-------------------------------------------------------------------------------------------------
function loadSalesRecord() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT club_inv_marker, purchase_marker, number_items, category_id, category_name, bar_code, product_desc, sales_tax, whole_cost, retail_cost, total_cost, transaction_id FROM merchant_sales WHERE item_marker ='$this->itemMarker' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($club_inv_marker, $purchase_marker, $number_items, $category_id, $category_name, $bar_code, $product_desc, $sales_tax, $whole_cost, $retail_cost, $total_cost, $transaction_id); 
$stmt->fetch();

$this->clubInvMarker = $club_inv_marker;
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

if(!preg_match('/CMP/',$transaction_id)){
   $this->refundTotal += $this->totalCost;
   $this->transId = $transaction_id;
}else{
    $this->refundTotal += 0;
    $this->transId = "";
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
$re_type = $this->typeList;
$return_reason = $this->returnReason;
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


$this->wholeCost = 0;
$this->retailCost = 0;
$this->totalCost = 0;


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
function createSessionVariables() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT retail_cost, total_cost, club_id, re_date FROM refund_exchange WHERE purchase_marker ='$this->purchaseMarker' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($retail_cost, $total_cost, $club_id, $re_date);     


while($stmt->fetch()) {

         $this->retailCost = $this->retailCost + $retail_cost;
         $this->totalCost = $this->totalCost + $total_cost;  
         $this->clubId = $club_id;
         $this->purchaseDate = date("m/d/Y H:i", strtotime($re_date));
         
        }
        
$stmt->close();

$this->salesTax = $this->totalCost - $this->retailCost;
$this->salesTax = sprintf("%.2f", $this->salesTax);
$this->retailCost = sprintf("%.2f", $this->retailCost);
$this->totalCost = sprintf("%.2f", $this->totalCost);
$this->loadBusinessInfo();
$this->loadClubInfo();

$stmt2 = $dbMain ->prepare("SELECT product_desc, retail_cost  FROM refund_exchange WHERE purchase_marker ='$this->purchaseMarker' ");
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
//-------------------------------------------------------------------------------------------------
function parseRefundExchange() {

$this->loadSalesRecord();
$this->insertRefundExchange();
        
switch ($this->typeList) {
        case "E":
               
          if($this->returnReason == 'D') {          
             $this->loadClubInventory();
             $this->clubInventory = $this->inventory - 1;             
             $this->updateClubInventory();
             }
                                        
        break;
        case "R":
        
          if($this->returnReason == 'O') {
             $this->loadClubInventory();
             $this->clubInventory = $this->inventory + 1;
             $this->updateClubInventory();
             }    
             
        break;        
    }




}
//-------------------------------------------------------------------------------------------------
function loadRefundExchange() {

$this->refundExchangeDate = date("Y-m-d H:i:s");

$itemMarkerArray = explode('^', $this->itemMarkerArray);
$arrayCount = count($itemMarkerArray);
$count = $arrayCount;

for ($i=0; $i <= $count; $i++) {
      
      $items = $itemMarkerArray[$i];
      $itemsArray = explode('|', $items);
      $this->itemMarker = $itemsArray[0]; 
      
      if($this->itemMarker != "") {
         $this->parseRefundExchange();
         }
      
     }
     if($this->transId != ""){
        $clubId = $_SESSION['location_id'];
        $dbMain = $this->dbconnect();
       
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
        
        $gw = new gwapi;
        $gw->setLogin("$userName", "$password");
        $r = $gw->doRefund($this->transId, $this->refundTotal);
    
        $ccAuthReasonCode = $gw->responses['response_code'];
        if($ccAuthReasonCode == 100){
            $this->refundExchangeStatus = "$this->purchaseMarker|1|2";
        }else{
            $this->refundExchangeStatus = "$this->purchaseMarker|2|3";
        }
     }else{
        $this->refundExchangeStatus = "$this->purchaseMarker|1|1";
     }
        
   
$this->createSessionVariables();

}
//-------------------------------------------------------------------------------------------------
function getRefundExchangeStatus() {
            return($this->refundExchangeStatus);
            }


}
//============================================
$item_array = $_REQUEST['item_array'];
$type_list = $_REQUEST['type_list'];
$return_reason = $_REQUEST['return_reason'];
$ajax_switch = $_REQUEST['ajax_switch'];



if($ajax_switch == 1) {

   $location_id = $_SESSION['location_id'];
   
   $refundEx = new refundExchange();
   $refundEx-> setItemMarkerArray($item_array);
   $refundEx-> setTypeList($type_list);
   $refundEx-> setReturnReason($return_reason); 
   $refundEx-> setClubId($location_id);
   $refundEx-> loadRefundExchange();
   $refund_exchange_status = $refundEx-> getRefundExchangeStatus();
   
   echo"$refund_exchange_status";
   exit;


  }



?>