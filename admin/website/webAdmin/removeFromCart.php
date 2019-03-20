<?php
session_start();


class  removeCartItem{

function setItemId($item) {
          $this->itemId = $item;
          }
//connect to database
function dbconnect()   {
require"../../dbConnect.php";
return $dbMain;
}

//-------------------------------------------------------------------------------------------------------------------
function removeItem() {
    
$cart = $_SESSION['cart'];

$cartList = explode('|',$cart);

foreach($cartList as $cartItem){
    $itemDetails = explode(',',$cartItem);
    
    $itemId = trim($itemDetails[0]);
    $retail_cost = trim($itemDetails[1]);
    $sales_tax = trim($itemDetails[2]);
    $product_desc = trim($itemDetails[3]);
    
    if($this->itemId != $itemId){
        $newCart .= "$itemId,$retail_cost,$sales_tax,$product_desc|";
    }
}

$_SESSION['cart'] = $newCart;

}
//======================================================================================
}
//--------------------------------------------------------------------------------------
$ajax_switch = $_REQUEST['ajaxSwitch'];
$item_id = $_REQUEST['itemId'];

if($ajax_switch == 1) {

    $loadPricing = new removeCartItem();
    $loadPricing-> setItemId($item_id);
    $loadPricing-> removeItem();
    echo"1";
    exit;
}
?>