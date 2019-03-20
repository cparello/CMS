<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$product_desc = $_REQUEST['product_desc'];
$pos_category = $_REQUEST['pos_category'];
$pos_cat_new = $_REQUEST['pos_cat_new'];
$bar_code = $_REQUEST['bar_code'];
$product_desc = $_REQUEST['product_desc'];
$whole_cost = $_REQUEST['whole_cost'];
$retail_cost = $_REQUEST['retail_cost'];
$sales_tax = $_REQUEST['sales_tax'];
$inventory = $_REQUEST['inventory'];


if (isset($_POST['save']))       {

include "inventorySql.php";

$product_desc = str_replace("'", '', $product_desc);
$product_desc = stripslashes($product_desc);

$saveInv = new inventorySql();
$saveInv-> setPosCategory($pos_category);
$saveInv-> setPosCategoryNew($pos_cat_new);
$saveInv-> setBarCode($bar_code);
$saveInv-> setProductDescription($product_desc);
$saveInv-> setWholeCost($whole_cost);
$saveInv-> setRetailCost($retail_cost);
$saveInv-> setSalesTax($sales_tax);
$saveInv-> setQuantity($inventory);
$saveInv-> saveProduct();
     
$confirmation = "Inventory Item $product_desc Successfully Saved";   

}

/*
$all_select =0;
include "../clubs/clubDrops.php";
$club_id = '0';
$service_location = 'All';
$clubDrops = new clubDrops();
$clubDrops-> setClubId($club_id);
$clubDrops-> setAllSelect($all_select);
$clubDrops-> setServiceLocation($service_location);
$drop_menu_clubs = $clubDrops -> loadMenu(); 
*/

include "posCatDrops.php";
$default_select = 4;
$catDrops = new posCatDrops();
$catDrops-> setDefaulSelect($default_select);
$drop_menu_cat = $catDrops-> loadMenu(); 


$page_title = 'Create Inventory';
$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtPos.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/createInventory.js\"></script>";


include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(47);
$info_text = $getText -> createTextInfo();


include "../templates/infoTemplate2.php";
include "../templates/createInventoryTemplate.php";


?>