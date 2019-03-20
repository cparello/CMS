<?php
session_start();
include"../../dbConnect.php";
include"loadWebsitePreferences.php";
include "loadStuff.php"; 

include "webLogCheck.php";
$logCheck = new loginCheck();
$logCheck-> setButtonColor($middleButtons);
$logCheck-> checkLogin();
$logHtml = $logCheck-> getLogHtml();


$html = "<table  align=\"center\" border=\"0\" width=\"403\" cellspacing=\"0\">
            <tbody>
            <tr class=\"tabHead\">
            <td colspan=\"3\" class=\"textTop\">
            <b>Item</b>
            </td>
            <td colspan=\"3\" class=\"textTop\">
            Cost
            </td>
            <td colspan=\"3\" class=\"textTop\">
            Tax
            </td>
            <td colspan=\"3\" class=\"textTop\">
            Quantity
            </td>
            </tr><br>";

$counter = 1;
$cart = $_SESSION['cart'];
$cartArray = explode('|',$cart);
foreach($cartArray as $cart){
    
    $itemDetails = explode(',',$cart);
    $itemId = $itemDetails[0];
    $cost = $itemDetails[1];
    $taxRate = $itemDetails[2];
    $productDescription = $itemDetails[3];
    
    $tax = sprintf("%.2f", $cost*($taxRate/100));
    
    $html .= "
            <tr>
            <td colspan=\"3\" class=\"textItem\">
            $counter.&nbsp;&nbsp;$productDescription
            </td>
            <td colspan=\"3\" class=\"textItem\">
            $cost
            </td>
            <td colspan=\"3\" class=\"textItem\">
            $tax
            </td>
            <td colspan=\"3\" class=\"textItem\">
            quantity
            </td>
            </tr><br>";
            $counter++;
}
$html .= "</tbody></table>";

include "webTemplates/cartPageTemplate.php";
?>