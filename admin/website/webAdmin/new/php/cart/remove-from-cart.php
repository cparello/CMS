<?php

  session_start();

  class removeCartItem {
    
    var $totalCount;

    function setItemId($item) {
      $this->itemId = $item;
    }
    
    // connect to database
    function dbconnect() {
      require"../../../dbConnect.php";
      return $dbMain;
    }

    //--------------------------------------------------------------------------------------
    function removeItem() {
        
      $cart = $_SESSION['cart'];
      $cart = rtrim($cart, '|'); // remove the closing '|'
      $cartList = explode('|', $cart);
      $newCart = "";
      $this->totalCount = 0;

      foreach ($cartList as $cartItem) {
        $itemDetails = explode('^', $cartItem);
        
        $itemId		= trim($itemDetails[0]);
        $barcode	= trim($itemDetails[1]);
        $retail_cost	= trim($itemDetails[2]);
        $sales_tax	= trim($itemDetails[3]);
        $product_desc	= trim($itemDetails[4]);
        $itemQty	= trim($itemDetails[5]);
        $itemMaxQty	= trim($itemDetails[6]);
        
        if ($this->itemId != $itemId) {
          $newCart .= "$itemId^$barcode^$retail_cost^$sales_tax^$product_desc^$itemQty^$itemMaxQty|";
          $this->totalCount++;
        }
      }

      $_SESSION['cart'] = $newCart;
//echo '<br />new $_SESSION[cart]='.$_SESSION['cart']; // !debug!
    }
  }
 
  //======================================================================================
  $ajax_switch = $_REQUEST['ajaxSwitch'];
  $item_id = $_REQUEST['itemId'];

  if ($ajax_switch == 1) {
    $loadPricing = new removeCartItem();
    $loadPricing->setItemId($item_id);
    $loadPricing->removeItem();
//    $numberOfCartItems = $loadPricing->totalCount; // should be here to change the effective cart products counter (?) (but it works without this)
    $result1 = 1;
    echo "$result1|$loadPricing->totalCount";
    exit;
  }

?>