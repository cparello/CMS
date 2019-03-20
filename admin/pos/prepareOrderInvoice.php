<?php
  
  /* Address From. */
  $stmt = $dbMain->prepare("SELECT MAX(bus_id) FROM business_info WHERE business_name != ''");//>=
  $stmt->execute();  
  $stmt->store_result();      
  $stmt->bind_result($businessId); 
  $stmt->fetch();
  $stmt->close();

  $query = "SELECT business_name, business_street, business_city, business_state, business_zip, contact_email FROM business_info"
          ." WHERE bus_id='$businessId'";
  $stmt = $dbMain ->prepare($query); 
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($businessName, $businessStreet, $businessCity, $businessState, $businessZip, $businessEmail);
  $stmt->fetch();
  $stmt->close();
  $addressFrom = "$businessName<br />$businessStreet<br />$businessCity, $businessState $businessZip";
  /* /Address From. */

  /* Address To. */
  $query = "SELECT first_name, middle_name, last_name, street, city, state, zip, email FROM pos_shipping_details"
          ." WHERE pos_identifier='$purchaseMarker'";
  $stmt = $dbMain ->prepare($query); 
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($firstName, $middleName, $lastName, $shippingStreet, $shippingCity, $shippingState, $shippingZip, $shippingEmail);
  $stmt->fetch();
  $stmt->close();
  $addressTo = "$firstName $middleName $lastName<br />$shippingStreet<br />$shippingCity, $shippingState $shippingZip";
  /* /Address To. */

  /* Products details. */
  $productsDetails = "<table border=\"0\" cellspacing=\"0\" cellpadding=\"2\" width=\"100%\" class=\"product_details\">
                        <tr>
                          <th>#</th>
                          <!--<th>Inventory Marker</th>-->
                          <th>Barcode</th>
                          <th>Product</th>
                          <th>Description</th>
                          <th>Category</th>
                          <!--<th>Whole Cost</th>-->
                          <th>Retail Cost</th>
                          <!--<th>Sales Tax</th>-->
                          <!--<th>Total Cost</th>-->
                          <th>Items Number</th>
                          <th>Price</th>
                        </tr>";
  $query = "SELECT ms.number_items, ms.category_name, ms.bar_code, ms.product_desc, ms.sales_tax, ms.whole_cost, ms.retail_cost, ms.total_cost, ms.club_inv_marker, wpi.description FROM merchant_sales ms"
          ." LEFT JOIN website_product_info wpi ON (wpi.item_marker = ms.club_inv_marker)"
          ." WHERE purchase_marker='$purchaseMarker' ORDER BY product_desc ASC";
  $stmt = $dbMain ->prepare($query); 
  $stmt->execute();      
  $stmt->store_result();      
  $stmt->bind_result($numberItems, $categoryName, $barCode, $productDesc, $salesTax, $wholeCost, $retailCost, $totalCost, $inventoryMarker, $description);
  $i = 1;
  $items         = 0;
  $subtotal      = 0.0;
  $totalSalesTax = 0.0;
  while ($stmt->fetch()) 
   {
    $price = sprintf("%.2f", $retailCost * $numberItems);
    $productsDetails .= "\n<tr>
                             <td>$i</td>
                             <!--<td>$inventoryMarker</td>-->
                             <td>[$barCode]</td>
                             <td>$productDesc</td>
                             <td>$description</td>
                             <td>$categoryName</td>
                             <!--<td>\$$wholeCost</td>-->
                             <td>\$$retailCost</td>
                             <!--<td>$salesTax</td>-->
                             <!--<td>\$$totalCost</td>-->
                             <td>$numberItems</td>
                             <td>\$$price</td>
                           </tr>\n";
    $i++;
    $items         += $numberItems;
    $subtotal      += $retailCost * $numberItems;
    $taxedCost      = $retailCost * (($salesTax < 1)? $salesTax : $salesTax/100); // we have to check the $salesTax, because in the DB these can be both 0.0925 or 9.25 (for example)
    $totalSalesTax += $taxedCost  * $numberItems;
   }
  $stmt->close();
  $total         = sprintf("%.2f", ($subtotal + $totalSalesTax));
  $subtotal      = sprintf("%.2f", $subtotal);
  $totalSalesTax = sprintf("%.2f", $totalSalesTax);
  $productsDetails .= "<tr><td colspan=\"6\" style=\"text-align:right;\">Subtotal: </td><td>($items pcs.)</td><td>\$$subtotal</td></tr>";
  $productsDetails .= "<tr><td colspan=\"6\" style=\"text-align:right;\">Sales Tax: </td><td></td><td>\$$totalSalesTax</td></tr>";
  $productsDetails .= "<tr><td colspan=\"6\" style=\"text-align:right;\">Total: </td><td></td><td>\$$total</td></tr>";
  $productsDetails .= "</table>";
  /* /Products details. */

?>
