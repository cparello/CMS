<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this class formats the dropdown menu for clubs and facilities
class  clubInventorySql{

private  $category = null;
private  $location = null;
private  $barCode = null;
private  $productDesc = null;
private  $wholeCost = null;
private  $retailCost = null;
private  $inventory = null;
private  $inventoryMarker = null;
private  $salesTax = null;
private  $quantity = null;
private  $fromWhere = null;


function setCategory($category) {
        $this->category = $category;
        }

function setLocation($location) {
        $this->location = $location;
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

function setQuantity($quantity) {
        $this->quantity = $quantity;
        }

function setInventoryMarker($inventoryMarker) {
        $this->inventoryMarker = $inventoryMarker;
        }

function setFromWhere($fromWhere) {
        $this->fromWhere = $fromWhere;
        }



//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//---------------------------------------------------------------------------------------------------------------------------
function updateProduct() {


if($this->salesTax == "") {
  $this->salesTax = 0;
  }

$dbMain = $this->dbconnect();
$sql = "UPDATE pos_inventory SET category_id= ?, bar_code=?, product_desc=?, whole_cost=?, retail_cost=?, sales_tax=? WHERE inventory_marker =?";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iisdddi', $category_id, $bar_code, $product_desc, $whole_cost, $retail_cost, $sales_tax, $inventory_marker);	

$category_id = $this->category;
$bar_code = $this->barCode;
$product_desc = $this->productDesc;
$whole_cost = $this->wholeCost;
$retail_cost = $this->retailCost;
$sales_tax = $this->salesTax;
$inventory_marker = $this->inventoryMarker;

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		


 $stmt->close();  

}
//---------------------------------------------------------------------------------------------------------------------------
function saveProduct() {


if($this->salesTax == "") {
  $this->salesTax = 0;
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
$inventory = $this->inventory;
$inventory_date = date("Y-m-d H:i:s");
$sales_tax = $this->salesTax;

          if(!$stmt->execute())  {
    	     printf("Error: %s.\n", $stmt->error);
            }		


 $stmt->close();  


}
//---------------------------------------------------------------------------------------------------------------------------
function loadWarehouseInventory() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT * FROM pos_inventory WHERE inventory_marker = '$this->inventoryMarker'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($inventoryMarker, $categoryId, $barCode, $productDesc, $wholeCost, $retailCost, $inventory, $inventoryDate, $salesTax);
$stmt->fetch();
$stmt->close();

$this->category = $categoryId;
$this->barCode = $barCode;
$this->productDesc = $productDesc;
$this->wholeCost = $wholeCost;
$this->retailCost = $retailCost;
$this->inventory = $inventory;
$this->salesTax = $salesTax;



//this checks to see if the assignment is coming from the warehouse or the club
if($this->fromWhere == 'W') {

   //subtract the quantity from the inventory then update
   $newInventory = $this->inventory - $this->quantity;

   $sql = "UPDATE pos_inventory SET inventory= ? WHERE inventory_marker =?";
   $stmt = $dbMain->prepare($sql);
   $stmt->bind_param('ii', $newInventory, $this->inventoryMarker);	
   $stmt->execute();	
   $stmt->close();  
   
  }
  
 

}
//---------------------------------------------------------------------------------------------------------------------------
function insertClubInventory() {

$dbMain = $this->dbconnect();

if($this->fromWhere != 'W')  {
  $this->loadWarehouseInventory();
  }


$sql = "INSERT INTO club_inventory VALUES (?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iissiisddid', $club_inventory_marker, $inventory_marker, $inventory_date, $club_id, $category_id, $bar_code, $product_desc, $retail_cost, $sales_tax, $inventory, $whole_cost);

$club_inventory_marker = null;
$inventory_marker = $this->inventoryMarker;
$inventory_date = date("Y-m-d H:i:s");
$club_id = $this->location;
$category_id = $this->category;
$bar_code = $this->barCode;
$product_desc = $this->productDesc;
$retail_cost = $this->retailCost;
$sales_tax = $this->salesTax;
$inventory = $this->quantity;
$whole_cost = $this->wholeCost;

          if(!$stmt->execute())  {
    	     printf("Error: %s.\n", $stmt->error);
            }		


 $stmt->close();  

}
//---------------------------------------------------------------------------------------------------------------------------
function  updateClubInventory() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT inventory FROM club_inventory WHERE inventory_marker = '$this->inventoryMarker' AND club_id='$this->location'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($clubInventory);
$stmt->fetch();
$stmt->close();

$this->inventory = $clubInventory + $this->quantity;

$sql = "UPDATE club_inventory SET inventory= ? WHERE inventory_marker =? AND club_id=?";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iis', $inventory, $inventory_marker, $club_id);	

$inventory = $this->inventory;
$inventory_marker = $this->inventoryMarker;
$club_id = $this->location;

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		


 $stmt->close();  


}
//---------------------------------------------------------------------------------------------------------------------------
function assignToClub() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) AS count  FROM club_inventory WHERE inventory_marker = '$this->inventoryMarker' AND club_id = '$this->location'");   
$stmt->execute(); 
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

if($count == 0) { 
   $this->insertClubInventory();
  }else{
   $this->updateClubInventory();    
  }

}
//---------------------------------------------------------------------------------------------------------------------------
function  assignShrinkage() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO shrinkage VALUES (?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iisiisddisd', $shrinkage_marker, $inventory_marker, $club_id, $category_id, $bar_code, $product_desc, $whole_cost, $retail_cost, $inventory, $shrinkage_date, $sales_tax);

$shrinkage_marker = null;
$inventory_marker = $this->inventoryMarker;
$club_id = $this->fromWhere;
$category_id = $this->category;
$bar_code = $this->barCode;
$product_desc = $this->productDesc;
$whole_cost = $this->wholeCost;
$retail_cost = $this->retailCost;
$inventory = $this->quantity;
$shrinkage_date = date("Y-m-d H:i:s");
$sales_tax = $this->salesTax;

          if(!$stmt->execute())  {
    	     printf("Error: %s.\n", $stmt->error);
            }		


 $stmt->close();  

}
//---------------------------------------------------------------------------------------------------------------------------
function assignToWarehouse() {

$this->loadWarehouseInventory();

$newInventory = $this->inventory + $this->quantity;

   $dbMain = $this->dbconnect();
   $sql = "UPDATE pos_inventory SET inventory= ? WHERE inventory_marker =?";
   $stmt = $dbMain->prepare($sql);
   $stmt->bind_param('ii', $newInventory, $this->inventoryMarker);	
   $stmt->execute();	
   $stmt->close();  


}
//---------------------------------------------------------------------------------------------------------------------------
function loadClubInventory() {

$dbMain = $this->dbconnect();

 //if the location is the same then we only update the retail price and tax fields
if($this->fromWhere == $this->location) {
  
    if($this->retailCost == "") {
       $this->retailCost = 0;
       }
    if($this->salesTax == "") {
       $this->salesTax = 0;
       }
  
    $sql = "UPDATE club_inventory SET retail_cost=?, sales_tax=? WHERE inventory_marker=? AND club_id=?";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('ddii', $this->retailCost, $this->salesTax, $this->inventoryMarker, $this->fromWhere);	
    $stmt->execute();	
    $stmt->close();  
    
    //set the quantity to zero if it exists
    $this->quantity = 0;
    
    
    }else{
    
     $stmt = $dbMain ->prepare("SELECT inventory, whole_cost FROM club_inventory WHERE inventory_marker = '$this->inventoryMarker' AND club_id='$this->fromWhere'");
     $stmt->execute();      
     $stmt->store_result();      
     $stmt->bind_result($inventory, $whole_cost);
     $stmt->fetch();
     $stmt->close();
    
     $this->inventory = $inventory;
     $this->wholeCost = $whole_cost;
  
     //subtract the quantity from the inventory then update
     $newInventory = $this->inventory - $this->quantity;
    
     $sql = "UPDATE club_inventory SET inventory=? WHERE inventory_marker =? AND club_id=?";
     $stmt = $dbMain->prepare($sql);
     $stmt->bind_param('iii', $newInventory, $this->inventoryMarker, $this->fromWhere);	
     $stmt->execute();	
     $stmt->close();      
            
    }
    
 if($this->location == "S") {
 
  $stmt = $dbMain ->prepare("SELECT category_id, bar_code, product_desc, whole_cost FROM pos_inventory WHERE inventory_marker = '$this->inventoryMarker'");
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($categoryId, $barCode, $productDesc, $wholeCost);
  $stmt->fetch();
  $stmt->close();

  $this->category = $categoryId;
  $this->barCode = $barCode;
  $this->productDesc = $productDesc;
  $this->wholeCost = $wholeCost;

 }
 

}
//---------------------------------------------------------------------------------------------------------------------------
function assignWarehouseInventory() {

switch ($this->location) {
    case "S":
        $this->loadWarehouseInventory();
        $this->assignShrinkage();
        break;
    default:
        $this->loadWarehouseInventory();
        $this->assignToClub();
        break;
      }

}
//---------------------------------------------------------------------------------------------------------------------------
function assignClubInventory() {

switch ($this->location) {
    case "W":
        $this->loadClubInventory();
        $this->assignToWarehouse();
        break;
    case "S":
        $this->loadClubInventory();
        $this->assignShrinkage();
        break;
    default:
        $this->loadClubInventory();
        $this->assignToClub();
        break;
      }


}
//--------------------------------------------------------------------------------------------------------------------------


}



?>