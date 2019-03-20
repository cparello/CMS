<?php
session_start();

$ajax_switch = $_REQUEST['ajax_switch'];
$productArray = $_REQUEST['productArray'];

if($ajax_switch == 1) {
$cart = $_SESSION['cart'];
$cartArray = explode('|',$cart);
$count = count($cartArray);

$productArrayExploded = explode('|',$productArray);
$count2 = count($productArrayExploded);

$_SESSION['cart'] .= $productArray;
$totalCount = $count + $count2;
$result1 = 1;
echo"$result1|$totalCount";
exit;
}





?>