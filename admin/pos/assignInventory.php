<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$salt = $_REQUEST['salt'];
$inventory_marker = $_REQUEST['inventory_marker'];
$wholeCost = $_REQUEST['wholeCost'];
$search_string = $_REQUEST['search_string'];
$search_type = $_REQUEST['search_type'];

include "clubInventorySql.php";

$submitButtonAssign = "assign$salt";
$quatityName = "quantity$salt";
$locationName = "service_location$salt";
$fromWhereName = "from_where$salt";
$quantity = $_POST[$quatityName];
$location = $_POST[$locationName];
$fromWhere = $_POST[$fromWhereName];

if(isset($_POST[$submitButtonAssign])) {
 
  $assign = new clubInventorySql();
  $assign-> setQuantity($quantity);
  $assign-> setLocation($location);
  $assign-> setFromWhere($fromWhere);
  $assign-> setInventoryMarker($inventory_marker);
  $assign-> assignWarehouseInventory();

  }
//------------------------------------------------------------------
$submitButtonClubAssign = "assignClub$salt";

if(isset($_POST[$submitButtonClubAssign])) {

    $retailCostName = "retail_cost$salt";
    $salesTaxName = "sales_tax$salt";
    $retailCost = $_POST[$retailCostName];
    $salesTax = $_POST[$salesTaxName];
    
    $assign = new clubInventorySql();
    $assign-> setQuantity($quantity);
    $assign-> setLocation($location);
    $assign-> setFromWhere($fromWhere);
    $assign-> setInventoryMarker($inventory_marker);
    $assign-> setRetailCost($retailCost);
    $assign-> setSalesTax($salesTax);
    $assign-> setWholeCost($wholeCost);
    $assign-> assignClubInventory();
  
//  echo"Quantity: $quantity<br>Location: $location<br>From Where: $fromWhere<br>Inv Marker: $inventory_marker<br>Retail Cost: $retailCost<br>Sales Tax: $salesTax";
 //  exit;
  



  }


include "clubInventory.php";
$getLists = new cubInventory();
$getLists-> setSearchString($search_string);
$getLists-> setSearchType($search_type);
$getLists-> loadWarehouseRecords();
$getLists-> loadClubs();
$result1 = $getLists-> getWareHouse();
$result2 = $getLists-> getClubCurtains();

include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(50);
$info_text = $getText -> createTextInfo();

$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript2 = "<script type=\"text/javascript\" src=\"../scripts/showDiv5.js\"></script>";
$javaScript3 = "<script type=\"text/javascript\" src=\"../scripts/checkAssignments.js\"></script>";
include "../templates/infoTemplate2.php";
include "../templates/clubInventoryTemplate.php";
exit;


?>