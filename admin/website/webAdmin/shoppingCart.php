<?php
session_start();
include"../../dbConnect.php";

include"loadWebsitePreferences.php";
include "loadStuff.php"; 
include "loadCart.php";

include "webLogCheck.php";
$logCheck = new loginCheck();
$logCheck-> setButtonColor($middleButtons);
$logCheck-> checkLogin();
$logHtml = $logCheck-> getLogHtml();

$cart = $_SESSION['cart'];

$cartList = explode('|',$cart);

$total = 0;
$itemCartList = "<tr>
            <td align=\"left\" valign =\"top\" bgcolor=\"grey\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>&nbsp;&nbsp;&nbsp;</b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"grey\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>&nbsp;&nbsp;&nbsp;</b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"grey\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>&nbsp;&nbsp;&nbsp;</b></font>
            </td>  
            <td align=\"left\" valign =\"top\" bgcolor=\"grey\">
            <font face=\"Arial\" size=\"1\" color=\"black\">&nbsp;&nbsp;&nbsp;</font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"grey\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>&nbsp;&nbsp;&nbsp;</b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"grey\">
            <font face=\"Arial\" size=\"1\" color=\"black\">&nbsp;&nbsp;&nbsp;</font>
            </td>
            </tr>";

$counter = 1;
foreach($cartList as $item){
    $itemDetails = explode(',',$item);
    $itemId = trim($itemDetails[0]);
    $retail_cost = trim($itemDetails[1]);
    $sales_tax = trim($itemDetails[2]);
    $product_desc = trim($itemDetails[3]);
    
    $total += $retail_cost;
    
    $total = sprintf("%.2f", $total);
    
    if($numberOfCartItems == 1 AND ($product_desc == "")){
        $optionalMessage = "Your cart is empty!";
        
    }else{
        $optionalMessage = "";
        if($product_desc != ""){
            $stmt = $dbMain ->prepare("SELECT description, picture FROM website_product_info WHERE item_marker = '$itemId'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($description, $pictureMain); 
            $stmt->fetch();   
            $stmt->close(); 
            
            $itemCartList .= "<tr>
            <td align=\"left\" valign =\"top\" bgcolor=\"grey\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$counter</b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"grey\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$product_desc</b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"grey\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$description</b></font>
            </td>  
            <td align=\"left\" valign =\"top\" bgcolor=\"grey\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b><img src=\"pictures/gear/$pictureMain\" alt=\"Smiley face\" height=\"25\" width=\"25\"></b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"grey\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$$retail_cost</b></font>
            </td>
            <td align=\"left\" valign =\"top\" bgcolor=\"grey\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b><button class=\"buttonJoin$middleButtons butColor buttonMod\" id=\"remove\" name=\"remove\" value=\"remove\" itemId=\"$itemId\" type=\"buttonJoin$middleButtons\">Remove</button></b></font>
            </td>
            </tr>";
            $counter++;
        }
        
    }
    
    
    
    
}
   

include "webTemplates/shoppingCartTemplate.php";

?>