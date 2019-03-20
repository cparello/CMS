<?php

  session_start();

  $ajax_switch = $_REQUEST['ajaxSwitch'];
  $productArray = $_REQUEST['productArray'];

  if ($ajax_switch == 1) {
    $cart  = $_SESSION['cart'];
    $cart .= $productArray;
    $cart = rtrim($cart, '|'); // remove the closing '|'
    $cartArray = explode('|', $cart);
    $count = count($cartArray);

    $productArrayExploded = explode('|', $productArray);
    $count2 = count($productArrayExploded);

    foreach ($cartArray as $cartItem) {
      $itemDetails = explode('^', $cartItem);
      
      $currItemId		= trim($itemDetails[0]);
      $itemId[$currItemId]	= $currItemId;
      $itemId[$currItemId]	= trim($itemDetails[0]);
      $barcode[$currItemId]	= trim($itemDetails[1]);
      $retail_cost[$currItemId]	= trim($itemDetails[2]);
      $sales_tax[$currItemId]	= trim($itemDetails[3]);
      $product_desc[$currItemId]= trim($itemDetails[4]);
      $itemQty[$currItemId] += trim($itemDetails[5]);
      $itemMaxQty[$currItemId]	= trim($itemDetails[6]);
    }
      
    $totalCount = 0;
    $newCart = "";
    foreach ($itemId as $value) {
      $newCart .= "$itemId[$value]^$barcode[$value]^$retail_cost[$value]^$sales_tax[$value]^$product_desc[$value]^$itemQty[$value]^$itemMaxQty[$value]|";
      $totalCount++;
    }
    $_SESSION['cart'] = $newCart;

    $result1 = 1;
    echo"$result1|$totalCount";
    exit;
  }

?>