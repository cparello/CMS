<?php

  /* Get the IDs of the products in the cart */
  function getCartItemsIds() {
    $cartItemsIds = array();
    $cartArray = explode('|', rtrim($_SESSION['cart'], '|'));

    foreach ($cartArray as $cartItem) {
      $itemDetails = explode('^', $cartItem);
      $currItemId		 = trim($itemDetails[0]);
      $cartItemsIds[$currItemId] = $currItemId;
    }
    return $cartItemsIds;
  }

?>