<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
include "../../dbConnect.php";

$marker = $_REQUEST['marker'];
$itemId = $_REQUEST['itemId'];
$itemDescription = $_REQUEST['itemDescription'];
$itemPicture = $_REQUEST['itemPicture'];

include "websiteProductOptionsSql.php";

//echo "marker $marker<br>";
//if form is submitted save to database
if ($marker == 1) {

   $updateCycles = new websiteProductOptionsSql();
   $updateCycles ->setItemId($itemId);
   $updateCycles ->setItemDescription($itemDescription);
   $updateCycles ->setItemPicture($itemPicture);
   $confirmation = $updateCycles -> updateWebsiteProductOptions();

}
$marker = 1;
/**/
//echo "p tee p ee";
//echo "item id $itemId<br>";
$itemDescription = "";
$itemPicture = "";
if ($itemId == "") // If there was no $_REQUEST['itemId']
  $itemId = "1";   //  show it the first product.
$loadSalesPay = new websiteProductOptionsSql();
$loadSalesPay ->setItemId($itemId);
$loadSalesPay -> loadWebsiteProductOptions();
$itemId = $loadSalesPay -> getItemId();
$itemDescription = $loadSalesPay -> getItemDescription();
$itemPicture = $loadSalesPay -> getItemPicture();
//echo "\$itemId=$itemId \$itemDescription=$itemDescription \$itemPicture=$itemPicture<br />"; // !debug!
//$catArray = trim($catArray);
//sets up the varibles for the form template
$submit_link = 'editStoreProductsInfoPage.php';
$submit_name = 'update';
$submit_title = "Save Product Details";
$page_title  = 'Website Product Options';
$javaScript2 ="<script type=\"text/javascript\" src=\"webScripts/helpTxtWebsiteStoreOptions.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"webScripts/helpPops.js\"></script>";


$dir = "pictures/gear/";

$root = scandir($dir, 1);
    foreach($root as $value) {           
        if ($value != "" && $value != "." && $value != "..") {
            $dropOptions .= "<option value=\"$value\">$value</option>\n";
                           }
                 }

$stmt = $dbMain ->prepare("SELECT inventory_marker, product_desc FROM pos_inventory WHERE inventory_marker != ''");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($inventory_marker, $product_desc); 
while($stmt->fetch()){
    $type_select .= "<option value=\"$inventory_marker\">$product_desc</option>\n";  
}
$stmt->close();

$stmt = $dbMain ->prepare("SELECT product_desc FROM pos_inventory WHERE inventory_marker = '$itemId'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($product_desc); 
$stmt->fetch();
$stmt->close();


include "webTemplates/websiteProductOptionsTemplate.php";

?>