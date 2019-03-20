<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class  refundList{

private $barCode = null;
private $productListing = null;
private $clubId = null;
private $inventoryMarker = null;
private $retailCost = null;
private $totalCost = null;
private $categoryName = null;
private $categoryId = null;
private $purchaseMarker = null;
private $itemMarker = null;
private $purchaseDate = null;
private $productDescription = null;


function setPurchaseMarker($purchaseMarker) {
        $this->purchaseMarker = $purchaseMarker;
        }

function setClubId($clubId) {
        $this->clubId = $clubId;
        }
        
        
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}        
//-------------------------------------------------------------------------------------------------
function loadCategoryName() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT category_name FROM pos_category WHERE category_id = '$this->categoryId'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($category_name);   
 $stmt->fetch();                 
 
 $this->categoryName = $category_name;
 
 $stmt->close();

}
//-------------------------------------------------------------------------------------------------
function loadRefundExchange() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) AS item_count FROM refund_exchange WHERE item_marker ='$this->itemMarker' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($item_count);
$stmt->fetch();

if($item_count == 0) {
   return false;
   }else{
   return true;   
   }

 $stmt->close();

}
//-------------------------------------------------------------------------------------------------
function loadProductListing() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT * FROM merchant_sales WHERE purchase_marker ='$this->purchaseMarker' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($item_marker, $purchase_marker, $transaction_id, $number_items, $category_id, $category_name, $bar_code, $product_desc, $sales_tax, $whole_cost, $retail_cost, $total_cost, $purchase_date, $club_id, $club_inv_marker, $internet, $contract_key); 
$rowCount = $stmt->num_rows;

 if($rowCount != 0) {

     while($stmt->fetch()) {
      
             $this->itemMarker = $item_marker;
             $refundExchangeBool = $this->loadRefundExchange();
          
                if($refundExchangeBool == false) {
          
                     $this->purchaseDate = date("m/d/Y H:i", strtotime($purchase_date));
                     $this->barCode = $bar_code;
                     $this->productDescription = $product_desc;          
                     $this->categoryId = $category_id;
                     $this->loadCategoryName();
                     $this->retailCost = sprintf("%.2f", $retail_cost);       
                     $this->totalCost = sprintf("%.2f", $total_cost);
   
                     $this->productListing .="<tr class=\"item\">
                     <td class=\"black\"><input type=\"checkbox\" name=\"item[]\" class=\"item\" value=\"$this->itemMarker|$this->totalCost\"/></td>
                     <td class=\"black\">$this->purchaseDate</td>
                     <td class=\"black\">$this->barCode</td>
                     <td class=\"black\">$this->productDescription</td>
                     <td class=\"black\">$this->categoryName</td>
                     <td class=\"black\">$this->retailCost</td>
                     <td class=\"black\">$this->totalCost</td>
                     </tr>";
                   }
              
              }//end while
                        
     }else{
     $this->productListing = 1;
     }
     
     //takes care if there is already a refund
     if($this->productListing == "") {
        $this->productListing = 2;
       }
         
     
$stmt->close();
}
//-------------------------------------------------------------------------------------------------
function getProductListing() {
         return($this->productListing);
         }

}
//========================================================
$invoice_number = $_REQUEST['invoice_number'];
$ajax_switch = $_REQUEST['ajax_switch'];

if($ajax_switch == 1) {

   $listing = new refundList();
   $listing-> setPurchaseMarker($invoice_number);
   $listing-> loadProductListing();
   $product_listing = $listing-> getProductListing();
   echo"$product_listing";

   exit;
  }


?>