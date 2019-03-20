<?php
session_start();
/*if (!isset($_SESSION['admin_access']))  {
exit;
}*/

class  processPosPurchase{

private $barCode = null;
private $barCodeArray = null;
private $productListing = null;
private $clubId = null;
private $inventoryMarker = null;
private $wholeCost = null;
private $categoryName = null;
private $categoryId = null;
private $clubInvMarker = null;
private $productDesc = null;
private $retailCost = null;
private $salesTax = null;
private $inventory = null;
private $itemCount = null;
private $totalCost = null;
private $processConf = null;
private $posIdentifier = null;
private $transactionId = null;
private $purchaseDate = null;
private $shippingDetails = array();


function setBarCode($barCode) {
        $this->barCode = $barCode;
        }

function setBarCodeArray($barCodeArray) {
        $this->barCodeArray = $barCodeArray;
        }

function setClubId($clubId) {
        $this->clubId = $clubId;
        }

function setTransactionId($transactionId) {
       $this->transactionId = $transactionId;
       }

function setContractKey($contractKey) {
       $this->contractKey = $contractKey;
       }

function setShippingDetails($shippingDetails) {
       foreach ($shippingDetails as $key=>$val)
        {
         $this->shippingDetails[$key] = $val;
        }
//print("1|\$this->shippingDetails="); print_r($this->shippingDetails); exit(); // !debug!
       }
        
//connect to database
function dbconnect()   {
  require "../../../../dbConnect.php";
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
function updateInventory() {

$dbMain = $this->dbconnect();
if (($this->clubId == 0) || ($this->$clubId == "") || ($this->$clubId == "I")) {
//    $sql = "UPDATE pos_inventory SET inventory=? WHERE inventory_marker=?";
    $sql = "UPDATE club_inventory SET inventory=? WHERE inventory_marker=? AND club_id = 'I'";
 } else {
    $sql = "UPDATE club_inventory SET inventory=? WHERE club_inv_marker=?";
 }
        $stmt3 = $dbMain->prepare($sql);
        $stmt3->bind_param('ii' , $inventory, $club_inv_marker); 
             
             $inventory = $this->inventory;
             $club_inv_marker = $this->clubInvMarker;
             
       if(!$stmt3->execute())  {    
	      printf("Error: %s.\n", $stmt3->error );
          }
          
  $stmt3->close();

}
//-------------------------------------------------------------------------------------------------
function insertSalesRecord() 
 {
  $dbMain = $this->dbconnect();

  $item_marker = null;
  $purchase_marker = $this->posIdentifier; 
  $transaction_id = $this->transactionId;
  /*
  // v1 - in the DB there are multiple records for one product in a sale, in the `merchant_sales` table, one row for each piece of the product, and there is "1" in the `number_items` column. 
  // (till ../js/processWebCart.js.7)
  $number_items = 1;
  // /v1
  */
  // v2 - in the DB there is a single record for one product in a sale, in the `merchant_sales` table, one row for each product, and there is the number of the pieces of the product in the `number_items` column. 
  // (since ../js/processWebCart.js.8)
  $number_items = $this->itemCount;
  // /v2
  $category_id = $this->categoryId;
  $category_name = $this->categoryName;
  $bar_code = $this->barCode;
  $product_desc = $this->productDesc;
  $sales_tax = $this->salesTax;
  $whole_cost = $this->wholeCost;
  $retail_cost = $this->retailCost;
  $total_cost = $this->totalCost;
  $purchase_date = $this->purchaseDate;
  if (($this->clubId == 0) || ($this->$clubId == "") || ($this->$clubId == "I")) {
//    $club_id = 0;
    $club_id = 'I';
   } else {
    $club_id = $this->clubId;
   }
  $club_inv_marker = $this->clubInvMarker;
  //$internet = 'N';
  $internet = 'Y';

//echo "1|$item_marker, $purchase_marker, $transaction_id, $number_items, $category_id, $category_name, $bar_code, $product_desc, $sales_tax, $whole_cost, $retail_cost, $total_cost, $purchase_date, $club_id, $club_inv_marker, $internet, $this->contractKey"; // !debug!
//die("insertSalesRecord"); // !debug!

  $sql = "INSERT INTO merchant_sales VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
  $stmt = $dbMain->prepare($sql);
  $stmt->bind_param('iisiisssddddssiss', $item_marker, $purchase_marker, $transaction_id, $number_items, $category_id, $category_name, $bar_code, $product_desc, $sales_tax, $whole_cost, $retail_cost, $total_cost, $purchase_date, $club_id, $club_inv_marker, $internet, $this->contractKey);

  if (!$stmt->execute())  {
    printf("Error: %s.\n", $stmt->error);
   }		

  $stmt->close(); 

  $this->processConf = "1|$this->posIdentifier";
}
//-------------------------------------------------------------------------------------------------
function insertShippingDetailsRecord() {
$dbMain = $this->dbconnect();

$general_id = null;
$pos_identifier = $this->posIdentifier; 
$status_id = 0;

$sql = "INSERT INTO pos_shipping_details VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiissssssissi', $general_id, $this->contractKey, $pos_identifier, $this->shippingDetails['first_name'], $this->shippingDetails['middle_name'], $this->shippingDetails['last_name'], $this->shippingDetails['street'], $this->shippingDetails['city'], $this->shippingDetails['state'], $this->shippingDetails['zip'], $this->shippingDetails['primary_phone'], $this->shippingDetails['email'], $status_id);

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

$stmt->close(); 
}
//-------------------------------------------------------------------------------------------------
function updateProductListing() 
 {
  $dbMain = $this->dbconnect();

  /*
  // v1 - in the DB there are multiple records for one product in a sale, in the `merchant_sales` table, one row for each piece of the product, and there is "1" in the `number_items` column. 
  // (till ../js/processWebCart.js.7)
  if (($this->clubId == 0) || ($this->$clubId == "") || ($this->$clubId == "I")) {
    //$stmt = $dbMain ->prepare("SELECT MIN(whole_cost) AS price_cost  FROM pos_inventory WHERE bar_code='$this->barCode' AND inventory <> '0' ");
    $stmt = $dbMain ->prepare("SELECT MIN(whole_cost) AS price_cost  FROM club_inventory WHERE club_id='I' AND bar_code='$this->barCode' AND inventory <> '0' ");
   } else {
    $stmt = $dbMain ->prepare("SELECT MIN(whole_cost) AS price_cost  FROM club_inventory WHERE club_id ='$this->clubId' AND bar_code='$this->barCode' AND inventory <> '0' ");
   }
  // /v1
  */
  // v2 - in the DB there is a single record for one product in a sale, in the `merchant_sales` table, one row for each product, and there is the number of the pieces of the product in the `number_items` column. 
  // (since ../js/processWebCart.js.8)
  if (($this->clubId == 0) || ($this->$clubId == "") || ($this->$clubId == "I")) {
    //$stmt = $dbMain ->prepare("SELECT MIN(whole_cost) AS price_cost  FROM pos_inventory WHERE bar_code='$this->barCode' AND inventory >= '$this->itemCount' ");
    $stmt = $dbMain ->prepare("SELECT MIN(whole_cost) AS price_cost  FROM club_inventory WHERE club_id='I' AND bar_code='$this->barCode' AND inventory >= '$this->itemCount' ");
   } else {
    $stmt = $dbMain ->prepare("SELECT MIN(whole_cost) AS price_cost  FROM club_inventory WHERE club_id ='$this->clubId' AND bar_code='$this->barCode' AND inventory <> '0' ");
   }
  // /v2

  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($price_cost);         
  $stmt->fetch(); 
  $this->wholeCost = $price_cost;
  $stmt->close();
  //          echo "\$this->clubId=$this->clubId \$this->barCode=$this->barCode"; exit(); // !debug!
  if($this->wholeCost != "")  
   {
    if (($this->clubId == 0) || ($this->$clubId == "") || ($this->$clubId == "I")) {
      //$stmt2 = $dbMain ->prepare("SELECT inventory_marker, product_desc, retail_cost, sales_tax, category_id, inventory  FROM pos_inventory WHERE bar_code='$this->barCode' AND whole_cost= '$this->wholeCost' ");
      $stmt2 = $dbMain ->prepare("SELECT inventory_marker, product_desc, retail_cost, sales_tax, category_id, inventory  FROM club_inventory WHERE club_id='I' AND bar_code='$this->barCode' AND whole_cost= '$this->wholeCost' ");
     } else {
      $stmt2 = $dbMain ->prepare("SELECT club_inv_marker, product_desc, retail_cost, sales_tax, category_id, inventory  FROM club_inventory WHERE club_id ='$this->clubId' AND bar_code='$this->barCode' AND whole_cost= '$this->wholeCost' ");
     }
    $stmt2->execute();      
    $stmt2->store_result();      
    $stmt2->bind_result($club_inv_marker, $product_desc, $retail_cost, $sales_tax, $category_id, $inventory);         
    $stmt2->fetch(); 
    $rowCount2 = $stmt2->num_rows;
    $stmt2->close();
      
    $this->clubInvMarker = $club_inv_marker;
    $this->productDesc = $product_desc;
    $this->retailCost = $retail_cost;
    $this->salesTax = $sales_tax;
    $this->categoryId = $category_id;
    $this->loadCategoryName();
    
    if ($sales_tax < 1) // we have to check it, because in the DB these can be both 0.0925 or 9.25 (for example)
      $tax = $retail_cost * $sales_tax;
    else
      $tax = $retail_cost * $sales_tax/100;
    $totalCost = $retail_cost + $tax;
    $this->totalCost = sprintf("%.2f", $totalCost);
    
    //subtract inventory and update:
    /*
    // v1 - in the DB there are multiple records for one product in a sale, in the `merchant_sales` table, one row for each piece of the product, and there is "1" in the `number_items` column. 
    // (till ../js/processWebCart.js.7)
    $this->itemCount = 1;
    $this->inventory = $inventory - 1;
    $this->updateInventory();
    // /v1
    */
    // v2 - in the DB there is a single record for one product in a sale, in the `merchant_sales` table, one row for each product, and there is the number of the pieces of the product in the `number_items` column. 
    // (since ../js/processWebCart.js.8)
    $this->inventory = ($inventory > $this->itemCount)? ($inventory - $this->itemCount) : 0;
    $this->updateInventory();
    // /v2
    
    //insert sales record:
    $this->insertSalesRecord();
  }
}
//-------------------------------------------------------------------------------------------------
function createIdentifier() {

$dbMain = $this->dbconnect();

$sql = "INSERT INTO pos_identifier VALUES (?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('i', $pos_marker);
$pos_marker = null;
if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

$this->posIdentifier = $stmt->insert_id;


$stmt->close(); 


}
//-------------------------------------------------------------------------------------------------
function processPurchase() 
 {
  $this->createIdentifier();
  $this->purchaseDate = date("Y-m-d H:i:s");

  $barCodeArray = explode('|', $this->barCodeArray);
  $count = count($barCodeArray);
  $count = $count -1;

  /*
  // v1 - in the DB there are multiple records for one product in a sale, in the `merchant_sales` table, one row for each piece of the product, and there is "1" in the `number_items` column. 
  // (till ../js/processWebCart.js.7)
  for ($i=0; $i <= $count; $i++) 
   {
    $this->barCode = $barCodeArray[$i];
    $this->updateProductListing();
   }
  // /v1
  */
  // v2 - in the DB there is a single record for one product in a sale, in the `merchant_sales` table, one row for each product, and there is the number of the pieces of the product in the `number_items` column. 
  // (since ../js/processWebCart.js.8)
  for ($i=0; $i <= $count; $i++) 
   {
    list($this->barCode, $this->itemCount) = explode('^', $barCodeArray[$i]);
    $this->updateProductListing();
   }
  // /v2

  //insert shipping details record
  $this->insertShippingDetailsRecord();
 }
//-------------------------------------------------------------------------------------------------
function getProcessConf() {
         return($this->processConf);
         }
function getPosIdentifier() {
         return($this->posIdentifier);
         }

}
//========================================================

$purchase_cost = $_REQUEST['purchase_cost'];
$ajax_switch = $_REQUEST['ajax_switch'];
$bar_code_array = $_REQUEST['bar_code_array'];
$location_id = $_REQUEST['location_id'];
$transaction_id = $_REQUEST['transaction_id'];
$cardName = $_REQUEST['cardName'];
$cardNumber = $_REQUEST['cardNumber'];
$total = $_REQUEST['total'];
$cardMonth = $_REQUEST['cardMonth'];
$cardYear = $_REQUEST['cardYear'];
$contractKey = $_REQUEST['contractKey'];
$cofBool = $_REQUEST['cofBool'];
$transToken = $_REQUEST['token'];
$card_type = $_REQUEST['card_type'];

$shipping_details = array();
$shipping_details['first_name']		= $_REQUEST['first_name'];
$shipping_details['middle_name']	= $_REQUEST['middle_name'];
$shipping_details['last_name']		= $_REQUEST['last_name'];
$shipping_details['street']		= $_REQUEST['street'];
$shipping_details['city']		= $_REQUEST['city'];
$shipping_details['state']		= $_REQUEST['state'];
$shipping_details['zip']		= $_REQUEST['zip'];
$shipping_details['primary_phone']	= $_REQUEST['primary_phone'];
$shipping_details['email']		= $_REQUEST['email'];

/*
//print("1|55555"); exit(); // !debug!
// !debug!
print("1|\$_REQUEST="); 
foreach($_REQUEST as $key=>$val)
  print("\$_REQUEST['$key']=" . str_replace("|", "^^", $val) . "<br>"); 
exit(); 
// /!debug!
*/

if($ajax_switch == 1) {

   $location_id = $_SESSION['location_id'];

   $process = new processPosPurchase();
   $process-> setBarCodeArray($bar_code_array);
   $process-> setClubId($location_id);
   $process-> setTransactionId($transaction_id);
   $process-> setContractKey($contractKey);
   $process-> setShippingDetails($shipping_details);
   $process-> processPurchase();
   $process_conf = $process-> getProcessConf();
   $pos_ident = $process-> getPosIdentifier();
  // echo "fubar $process_conf $pos_ident";
//exit; 
  
   require "../../../../dbConnect.php";
   
   if ($cofBool == 2){
     $cof = "Yes";
       $ccLen = strlen($cardNumber);
       $ccLen = $ccLen - 4;
       $cardNumber = substr($cardNumber,$ccLen);
       $cardNumber = "************$cardNumber"; 
   }else{
       $cof = "No";
       $ccLen = strlen($cardNumber);
       $ccLen = $ccLen - 4;
       $cardNumber = substr($cardNumber,$ccLen);
       $cardNumber = "************$cardNumber"; 
   }
 
    
  
    $sql = "INSERT INTO merchant_refund_records VALUES (?,?,?,?,?,?,?,?,?,?)";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('isssssssss', $pos_ident, $cardName, $cardNumber, $total, $cardMonth, $cardYear, $transaction_id, $cof, $card_type, $transToken);
    $stmt->execute();
    $stmt->close(); 
 
   echo"$process_conf";

   exit;
  }


?>