<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];
$search_type = $_REQUEST['search_type'];
$pos_category = $_REQUEST['pos_category'];
$bar_code = $_REQUEST['bar_code'];
$product_desc = $_REQUEST['product_desc'];
//If the the form has been submitted then do the search
if ($marker == 1)  {
//echo "m $marker st $search_type";
//exit;
switch ($search_type) {
    case "cat":
        $search_string = $pos_category; 
        break;
    case "bar":
        $search_string = $bar_code;
        break;
    case "desc":
        $search_string = $product_desc;
        break;
      }


include "productList.php";
$getLists = new productList();
$getLists -> setSearchString($search_string);
$getLists -> setSearchType($search_type);
$getLists -> loadRecords(); 
$result1 = $getLists -> getList();
//$result2 = $getLists -> getUserForm();


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

}

$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript2 = "<script type=\"text/javascript\" src=\"../scripts/searchInventory.js\"></script>";


include "posCatDrops.php";
$default_select = 4;
$catDrops = new posCatDrops();
$catDrops-> setDefaulSelect($default_select);
$drop_menu_cat = $catDrops-> loadMenu(); 

//print out the search form
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(48);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";
include "../templates/searchInventoryTemplate.php";

?>