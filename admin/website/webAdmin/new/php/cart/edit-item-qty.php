<?php

  session_start();

  $ajax_switch = $_REQUEST['ajaxSwitch'];
  $item_id  = $_REQUEST['itemId'];
  $item_qty = $_REQUEST['itemQty'];

  if ($ajax_switch == 1) {
    $cart = $_SESSION['cart'];
    $cart = rtrim($cart, '|'); // remove the closing '|'
    $cartArray = explode('|', $cart);
    $newCart = "";

    foreach ($cartArray as $cartItem) {
      $itemDetails = explode('^', $cartItem);
      
      $itemId		= trim($itemDetails[0]);
      $barcode		= trim($itemDetails[1]);
      $retail_cost	= trim($itemDetails[2]);
      $sales_tax	= trim($itemDetails[3]);
      $product_desc	= trim($itemDetails[4]);
      $itemQty		= trim($itemDetails[5]);
      $itemMaxQty	= trim($itemDetails[6]);
      if ($itemId == $item_id)
        $itemQty = $item_qty;
      $newCart .= "$itemId^$barcode^$retail_cost^$sales_tax^$product_desc^$itemQty^$itemMaxQty|";
    }

    $_SESSION['cart'] = $newCart;
    
    $result1 = 1;
    echo "$result1";
    exit;
  }

?>