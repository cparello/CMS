<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$inventory_salt = $_REQUEST['inventory_salt'];
$quantity = $_REQUEST['quantity']; 
$inventory_marker = $_REQUEST['inventory_marker'];
$search_string = $_REQUEST['search_string'];
$search_type = $_REQUEST['search_type'];

include "inventorySql.php";

if(isset($_POST['edit'])) {

  $editName = "edit_switch$inventory_salt";
  $barCodeName = "bar_code$inventory_salt";
  $productDescName = "product_desc$inventory_salt";
  $posCategoryName = "pos_category$inventory_salt";  
  $wholeCostName = "whole_cost$inventory_salt";
  $retailCostName = "retail_cost$inventory_salt";
  $quantityName = "quantity$inventory_salt";
  $salesTaxName = "sales_tax$inventory_salt";
  
  $edit_switch = $_POST[$editName];
  $bar_code = $_POST[$barCodeName];
  $product_desc = $_POST[$productDescName];
  $pos_category = $_POST[$posCategoryName];
  $whole_cost = $_POST[$wholeCostName];
  $retail_cost = $_POST[$retailCostName];
  $quantity = $_POST[$quantityName];
  $sales_tax = $_POST[$salesTaxName];
  
  $product_desc = str_replace("'", '', $product_desc);
  $product_desc = stripslashes($product_desc);


  $saveInv = new inventorySql();
  $saveInv-> setPosCategory($pos_category);
  $saveInv-> setEditSwitch($edit_switch);
  $saveInv-> setBarCode($bar_code);
  $saveInv-> setProductDescription($product_desc);
  $saveInv-> setWholeCost($whole_cost);
  $saveInv-> setRetailCost($retail_cost);
  $saveInv-> setSalesTax($sales_tax);
  $saveInv-> setQuantity($quantity);
  $saveInv-> setInventoryMarker($inventory_marker);
  $saveInv-> saveEditProduct();
     
  $confirmation = "Inventory Item $product_desc Successfully Saved"; 
  
 }

if(isset($_POST['delete'])) {

  $productDescName = "product_desc$inventory_salt";
  $product_desc = $_POST[$productDescName];
    
  $product_desc = str_replace("'", '', $product_desc);
  $product_desc = stripslashes($product_desc);

  $deleteInv = new inventorySql();
  $deleteInv-> setInventoryMarker($inventory_marker);
  $deleteInv-> deleteProduct();
  
  $confirmation = "Inventory Item $product_desc Successfully Deleted";
  
  }

include "productList.php";
$getLists = new productList();
$getLists -> setSearchString($search_string);
$getLists -> setSearchType($search_type);
$getLists -> loadRecords(); 
$result1 = $getLists -> getList();

//check tp see if there are multi results or not
if($result1 != "") {
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(49);
$info_text = $getText -> createTextInfo();

$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript2 = "<script type=\"text/javascript\" src=\"../scripts/editInventory.js\"></script>";
include "../templates/infoTemplate2.php";
include "../templates/productListTemplate.php";
exit;

}




?>