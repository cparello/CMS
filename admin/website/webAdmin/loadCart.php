<?php
$cart = $_SESSION['cart'];
$cartArray = explode('|',$cart);
$numberOfCartItems = count($cartArray);

$numberOfCartItems--;
//echo "$numberOfCartItems";

$cartLoader = "<a href=\"shoppingCart.php\"><img src=\"pictures/Shopping-Cart-Icon.jpg\" width=\"45\" height=\"45\" alt=\"Shoppin Cart\"/></a><b><span id=\"numCartItems\">&nbsp;$numberOfCartItems</span></b>";

?>