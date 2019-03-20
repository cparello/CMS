<?php
session_start();
$itemId = "";
$itemId = $_REQUEST['itemId'];

include"../../dbConnect.php";
include"loadWebsitePreferences.php";
include "loadStuff.php"; 
include "loadCart.php";

include "webLogCheck.php";
$logCheck = new loginCheck();
$logCheck-> setButtonColor($middleButtons);
$logCheck-> checkLogin();
$logHtml = $logCheck-> getLogHtml();

$buttonsHtmlMiddle = "";
$stmt = $dbMain ->prepare("SELECT cat_id, cat_name FROM website_store_categories WHERE show_on_web = 'Y'");
echo($dbMain->error);
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($cat_id, $cat_name); 
while($stmt->fetch()){    
    $buttonsHtmlMiddle .= "<button class=\"buttonLocation$middleButtons butColor buttonSize2\" name=\"$cat_id\" value=\"$cat_id\" type=\"buttonLocation$middleButtons\">$cat_name</button>";
   }
$stmt->close(); 

$stmt = $dbMain ->prepare("SELECT product_desc, retail_cost, sales_tax, category_id FROM pos_inventory WHERE inventory_marker = '$itemId'");
echo($dbMain->error);
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($product_desc, $retail_cost, $sales_tax, $category_id); 
$stmt->fetch();   
$stmt->close(); 

$productArray = "$itemId,$retail_cost,$sales_tax,$product_desc|";

$stmt = $dbMain ->prepare("SELECT description, picture FROM website_product_info WHERE item_marker = '$itemId'");
echo($dbMain->error);
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($description, $pictureMain); 
$stmt->fetch();   
$stmt->close(); 

$stmt = $dbMain ->prepare("SELECT picture, inventory_marker FROM website_product_info JOIN pos_inventory ON website_product_info.item_marker = pos_inventory.inventory_marker WHERE category_id = '$category_id' LIMIT 4");
echo($dbMain->error);
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($picture, $inventory_marker); 
while($stmt->fetch()){
    $upsellLike .= "<td align=\"left\" valign=\"middle\" width=\"24%\"><a href=\"itemDescriptionPage.php?itemId=$inventory_marker\"><img src=\"pictures/gear/$picture\" border=\"0\" width=\"211\"></a></td>";
}   
$stmt->close(); 
include "webTemplates/itemDescriptionPageTemplate.php";

?>