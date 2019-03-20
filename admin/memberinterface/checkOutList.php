<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class  checkOutList{

private $barCode = null;
private $productListing = null;
private $clubId = null;
private $inventoryMarker = null;
private $wholeCost = null;
private $categoryName = null;
private $categoryId = null;


function setBarCode($barCode) {
        $this->barCode = $barCode;
        }
function setName($name) {
        $this->name = $name;
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
function loadProductListing() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT MIN(whole_cost) AS price_cost  FROM club_inventory WHERE club_id ='$this->clubId' AND bar_code='$this->barCode' AND inventory != '0' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($price_cost);         
$stmt->fetch(); 
$this->wholeCost = $price_cost;
$stmt->close();
           
if($this->wholeCost != "")  {

   $stmt2 = $dbMain ->prepare("SELECT club_inv_marker, product_desc, retail_cost, sales_tax, category_id  FROM club_inventory WHERE club_id ='$this->clubId' AND bar_code='$this->barCode' AND whole_cost= '$this->wholeCost' ");
             $stmt2->execute();      
             $stmt2->store_result();      
             $stmt2->bind_result($club_inv_marker, $product_desc, $retail_cost, $sales_tax, $category_id);         
             $stmt2->fetch(); 
             $rowCount2 = $stmt2->num_rows;
             $stmt2->close();
   
   $this->categoryId = $category_id;
   $this->loadCategoryName();
   
   $tax = $retail_cost * $sales_tax;
   $totalCost = $retail_cost + $tax;
   $totalCost = sprintf("%.2f", $totalCost);
   
   $this->productListing="3@<tr class=\"item\"><td class=\"black\">1</td><td class=\"black\">$this->barCode</td><td class=\"black\">$product_desc</td><td class=\"black\">$this->categoryName</td><td class=\"black\">$retail_cost</td><td class=\"black\">$totalCost</td><td align=\"right\"><input type=\"button\" name=\"delete\" value=\"Remove\" class=\"removeIt\"></td></tr>|$totalCost";
   
   }else{
   
   $this->productListing = "1@";
   
   }
                        


}
//-------------------------------------------------------------------------------------------------
function loadProductListingTwo() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT MIN(whole_cost) AS price_cost  FROM club_inventory WHERE club_id ='$this->clubId' AND product_desc = '$this->name' AND inventory != '0' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($price_cost);         
$stmt->fetch(); 
$this->wholeCost = $price_cost;
$stmt->close();
           
if($this->wholeCost != "")  {

   $stmt2 = $dbMain ->prepare("SELECT club_inv_marker, product_desc, retail_cost, sales_tax, category_id, bar_code  FROM club_inventory WHERE club_id ='$this->clubId' AND product_desc = '$this->name' AND whole_cost= '$this->wholeCost' LIMIT 1");
             $stmt2->execute();      
             $stmt2->store_result();      
             $stmt2->bind_result($club_inv_marker, $product_desc, $retail_cost, $sales_tax, $category_id, $barcode);         
             $stmt2->fetch(); 
             $rowCount2 = $stmt2->num_rows;
             $stmt2->close();
   
   $this->categoryId = $category_id;
   $this->loadCategoryName();
   
   $tax = $retail_cost * $sales_tax;
   $totalCost = $retail_cost + $tax;
   $totalCost = sprintf("%.2f", $totalCost);
   
   $this->productListingTwo="3@<tr class=\"item\"><td class=\"black\">1</td><td class=\"black\">$barcode</td><td class=\"black\">$product_desc</td><td class=\"black\">$this->categoryName</td><td class=\"black\">$retail_cost</td><td class=\"black\">$totalCost</td><td align=\"right\"><input type=\"button\" name=\"delete\" value=\"Remove\" class=\"removeIt\"></td></tr>|$totalCost";
   
   }else{
    $nameArr = explode(' ',$this->name);
    $partialName = $nameArr[0];
    $stmt = $dbMain ->prepare("SELECT product_desc, bar_code  FROM club_inventory WHERE club_id ='$this->clubId' AND product_desc LIKE '%$partialName%' AND inventory != '0' ");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($product_desc, $bar_code); 
    $rowCount =  $stmt->num_rows();        
    while($stmt->fetch()){
        $similarProds .="Barcode: $bar_code Name: $product_desc \n";
    }
    $stmt->close();
    
    if($rowCount == 0){
        $partialName = $nameArr[1];
        $stmt = $dbMain ->prepare("SELECT product_desc, bar_code  FROM club_inventory WHERE club_id ='$this->clubId' AND product_desc LIKE '%$partialName%' AND inventory != '0' ");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($product_desc, $bar_code); 
        $rowCount =  $stmt->num_rows();        
        while($stmt->fetch()){
            $similarProds .="Barcode: $bar_code Name: $product_desc \n";
        }
        $stmt->close();
    }
    if($rowCount == 0){
        $this->productListingTwo = "1@";
    }else{
        $this->productListingTwo = "2@$similarProds";
    }
           
   
   
   }
                        


}
//-------------------------------------------------------------------------------------------------
function getProductListing() {
         return($this->productListing);
         }
function getProductListingTwo() {
         return($this->productListingTwo);
         }

}
//========================================================
$upc_number = $_REQUEST['upc_number'];
$ajax_switch = $_REQUEST['ajax_switch'];

if($ajax_switch == 1) {

   $location_id = $_SESSION['location_id'];

   $listing = new checkOutList();
   $listing-> setBarCode($upc_number);
   $listing-> setClubId($location_id);
   $listing-> loadProductListing();
   $product_listing = $listing-> getProductListing();
   echo"$product_listing";

   exit;
  }

$name = $_REQUEST['upc_number'];
$ajax_switch = $_REQUEST['ajax_switch'];

if($ajax_switch == 2) {

   $location_id = $_SESSION['location_id'];

   $listing = new checkOutList();
   $listing-> setName($upc_number);
   $listing-> setClubId($location_id);
   $listing-> loadProductListingTwo();
   $product_listing = $listing-> getProductListingTwo();
   echo"$product_listing";

   exit;
  }

?>