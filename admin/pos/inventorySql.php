<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this class formats the dropdown menu for clubs and facilities
class  inventorySql{

private  $posCategory = null;
private  $posCatNew = null;
private  $barCode = null;
private  $productDesc = null;
private  $wholeCost = null;
private  $retailCost = null;
private  $inventory = null;
private  $quantity = null;
private  $category = null;
private  $editSwitch = null;
private  $inventoryMarker = null;
private  $salesTax = null;
private  $newPosInventory = null;
private  $categoryName = null;


function setPosCategory($posCategory) {
        $this->posCategory = $posCategory;
        }

function setPosCategoryNew($posCatNew) {
        $this->posCatNew = $posCatNew;
        }

function setBarCode($barCode) {
        $this->barCode = $barCode;
        }

function setProductDescription($productDesc) {
        $this->productDesc = $productDesc;
        }

function setWholeCost($wholeCost) {
        $this->wholeCost = $wholeCost;
        }

function setRetailCost($retailCost) {
        $this->retailCost = $retailCost;
        }
        
function setSalesTax($salesTax) {
        $this->salesTax = $salesTax;
        }        

function setInventory($inventory) {
        $this->inventory = $inventory;
        }
        
function setQuantity($quantity) {
        $this->quantity = $quantity;
        }
        
function setEditSwitch($editSwitch) {
        $this->editSwitch = $editSwitch;
        }

function setInventoryMarker($inventoryMarker) {
       $this->inventoryMarker = $inventoryMarker;
       }


//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//---------------------------------------------------------------------------------------------------------------------------
function parseCategory() {

    if($this->posCategory != "") {
    
       $this->category = $this->posCategory;
       
      }else{
      
         $this->posCatNew = preg_replace( '/\s+/', ' ', $this->posCatNew);
       
         $dbMain = $this->dbconnect();
         $sql = "INSERT INTO pos_category VALUES (?,?)";
         $stmt = $dbMain->prepare($sql);
         $stmt->bind_param('is', $category_marker, $category_description);
         $category_marker = null;
         $category_description = $this->posCatNew;
       
          if(!$stmt->execute())  {
    	     printf("Error: %s.\n", $stmt->error);
            }		

         $this->category = $stmt->insert_id; 
         $stmt->close();           
             
      }

}
//---------------------------------------------------------------------------------------------------------------------------
function updateProduct() {

$this->parseCategory();

$dbMain = $this->dbconnect();

$this->productDesc = preg_replace( '/\s+/', ' ', $this->productDesc);
$this->productDesc = trim($this->productDesc);
$this->barCode = preg_replace( '/\s+/', ' ', $this->barCode);
$this->barCode = trim($this->barCode);


if($this->quantity != null) {
    
   $this->quantity = trim($this->quantity);   
   $stmt = $dbMain ->prepare("SELECT inventory FROM pos_inventory WHERE inventory_marker = '$this->inventoryMarker'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($posInventory);
   $stmt->fetch();
   $stmt->close();
  

   
   $this->newPosInventory = $posInventory + $this->quantity;   
   }else{   
   $this->newPosInventory = $posInventory;
   }

if($this->salesTax == "") {
  $this->salesTax = 0;
  }

$sql = "UPDATE pos_inventory SET category_id= ?, bar_code=?, product_desc=?, whole_cost=?, retail_cost=?, sales_tax=?, inventory=?  WHERE inventory_marker =?";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iisdddii', $category_id, $bar_code, $product_desc, $whole_cost, $retail_cost, $sales_tax, $newPosInventory, $inventory_marker);	

$category_id = $this->category;
$bar_code = $this->barCode;
$product_desc = $this->productDesc;
$product_desc = str_replace( '^', '&#094;', $product_desc);
$product_desc = str_replace( '|', '&#124;', $product_desc);
$whole_cost = $this->wholeCost;
$retail_cost = $this->retailCost;
$sales_tax = $this->salesTax;
$newPosInventory = $this->newPosInventory;
$inventory_marker = $this->inventoryMarker;

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		

 $stmt->close();  
 
 

}
//---------------------------------------------------------------------------------------------------------------------------
function saveProduct() {

$this->parseCategory();

$this->productDesc = preg_replace( '/\s+/', ' ', $this->productDesc);
$this->productDesc = trim($this->productDesc);
$this->barCode = preg_replace( '/\s+/', ' ', $this->barCode);
$this->barCode = trim($this->barCode);

if($this->salesTax == "") {
  $this->salesTax = 0;
  }
  
if($this->quantity == "") {
  $this->quantity= 0;
  }  
  

$dbMain = $this->dbconnect();
$sql = "INSERT INTO pos_inventory VALUES (?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iiisddisd', $inventory_marker, $category_id, $bar_code, $product_desc, $whole_cost, $retail_cost, $inventory, $inventory_date, $sales_tax);

$inventory_marker = null;
$category_id = $this->category;
$bar_code = $this->barCode;
$product_desc = $this->productDesc;
$whole_cost = $this->wholeCost;
$retail_cost = $this->retailCost;
$inventory = $this->quantity;
$inventory_date = date("Y-m-d H:i:s");
$sales_tax = $this->salesTax;

          if(!$stmt->execute())  {
    	     printf("Error: %s.\n", $stmt->error);
            }		


 $stmt->close();  


}
//---------------------------------------------------------------------------------------------------------------------------
function saveEditProduct() {

if($this->editSwitch == 'new') {
   $this->saveProduct();
  }
if($this->editSwitch == 'update') {
   $this->updateProduct();
  }

}
//---------------------------------------------------------------------------------------------------------------------------
function deleteProduct() {

$dbMain = $this->dbconnect();

$sql1 = "DELETE FROM pos_inventory WHERE inventory_marker = '$this->inventoryMarker'";
$stmt1 = $dbMain->prepare($sql1);  
$stmt1->execute();
$stmt1->close();

$sql2 = "DELETE FROM website_product_info WHERE item_marker = '$this->inventoryMarker'";
$stmt2 = $dbMain->prepare($sql2);  
$stmt2->execute();
$stmt2->close();

}
//---------------------------------------------------------------------------------------------------------------------------
function loadCategoryName() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT category_name FROM pos_category WHERE category_id = '$this->posCategory'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($category_name);   
 $stmt->fetch();                 
 
 $this->categoryName = $category_name;
 
 $stmt->close();

}
//---------------------------------------------------------------------------------------------------------------------------
function deleteCategory() {

$this->loadCategoryName();

$dbMain = $this->dbconnect();

$sql1 = "DELETE FROM pos_category WHERE category_id = '$this->posCategory'";
$stmt1 = $dbMain->prepare($sql1);  
$stmt1->execute();
$stmt1->close();


$sql2 = "DELETE FROM club_inventory WHERE category_id = '$this->posCategory'";
$stmt2 = $dbMain->prepare($sql2);  
$stmt2->execute();
$stmt2->close();

$sql3 = "DELETE FROM pos_inventory WHERE category_id = '$this->posCategory'";
$stmt3 = $dbMain->prepare($sql3);  
$stmt3->execute();
$stmt3->close();

}
//---------------------------------------------------------------------------------------------------------------------------
function getCategoryName() {
       return($this->categoryName);
       }

}



?>