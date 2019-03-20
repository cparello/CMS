<?php
include_once('php/connection.php');
include_once('php/cart/get-shipping-details.php');
$shipping_details = array();
//print("\$shipping_details="); print_r(getShippingDetails()); // !debug!
$shipping_details = getShippingDetails();
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <?php include_once('inc/meta.php'); ?>
    <script type="text/javascript" src="js/cart.js"></script>
    <script type="text/javascript" src="js/checkWebCartFields.js"></script>
    <script type="text/javascript" src="js/processWebCart.js"></script>
    <link rel="stylesheet" href="css/signature_pad.css">
</head>
<body>
    <?php include_once('inc/header.php'); ?>
    
    <div class="row margin-top-bottom">
    	<div class="small-12 large-12 columns">
            <h3>Your Cart</h3>
            <table class="cart">
                <thead>
                    <tr>
                        <th width="5%">Item&nbsp;#</th>
                        <th width="25%" colspan="2">Item</th>
                        <th>Description</th>
                        <th width="10%">Qty</th>
                        <th width="10%">Price</th>
                        <th width="5%" class="text-center">Remove</th>
                    </tr>
                </thead>
                
                <tbody>
                	<?php
					$subtotal      = 0;
					$totalSalesTax = 0;
					$totalQty      = 0;

					if (!empty($_SESSION['cart'])) { // there is no sense for an empty cart
					  $cart = $_SESSION['cart'];
					  $cart = rtrim($cart, '|'); // remove the closing '|'
					  $cartList = explode('|',$cart);
					  
					  $counter = 1;
					  foreach ($cartList as $item) {
						$itemDetails	= explode('^',$item);
						$itemId		= trim($itemDetails[0]);
						$barcode	= trim($itemDetails[1]);
						$retail_cost	= trim($itemDetails[2]);
						$sales_tax	= trim($itemDetails[3]);
						$product_desc	= trim($itemDetails[4]);
						$itemQty	= trim($itemDetails[5]);
						$itemMaxQty	= trim($itemDetails[6]);

						$taxed_cost     = $retail_cost * (($sales_tax < 1)? $sales_tax : $sales_tax/100); // we have to check the $sales_tax, because in the DB these can be both 0.0925 or 9.25 (for example)
						$subtotal      += $retail_cost * $itemQty;
						$totalSalesTax += $taxed_cost  * $itemQty;
						$totalQty      += $itemQty;
						
						if ($numberOfCartItems == 1 AND ($product_desc == "")){
							$optionalMessage = "Your cart is empty!";
						} else {
							$optionalMessage = "";
							$stmt = $dbMain ->prepare("SELECT description, picture FROM website_product_info WHERE item_marker = '$itemId'");
							$stmt->execute();      
							$stmt->store_result();      
							$stmt->bind_result($description, $pictureMain); 
							$stmt->fetch();   
							$stmt->close(); 
							
							echo '<tr class="item_row item_row_'.$itemId.'">
							<td class="row_num">' . $counter . '</td>
							<td><a href="product.php?itemId='.$itemId.'&fromCart=1"><img src="../pictures/gear/' . $pictureMain . '" /></a></td>
							<td><a href="product.php?itemId='.$itemId.'&fromCart=1">' . $product_desc . '</a><br />[<span title="barcode" class="barcode" data-item_id="'.$itemId.'">' . $barcode . '</span>]</td>
							<td><div class="description" title="'.$description.'">' . $description . '</div></td>
							<td>
							  <div class="button-group round">
							    <button class="secondary tiny item_qty_minus" data-item_id="'.$itemId.'">-</button>
							    <input type="text" class="tiny item_qty" id="item_qty_'.$itemId.'" data-item_id="'.$itemId.'" data-item_max_qty="'.$itemMaxQty.'" data-old_value="'.$itemQty.'" value="' . $itemQty . '" />
							    <button class="secondary tiny item_qty_plus" data-item_id="'.$itemId.'" data-item_max_qty="'.$itemMaxQty.'">+</button>
							  </div>
							</td>
							<td>
							  <input type="hidden" id="retail_cost_'.$itemId.'" value="'.$retail_cost.'" class="retail_cost" data-item_id="'.$itemId.'" />
							  <input type="hidden" id="taxed_cost_'.$itemId.'" value="'.$taxed_cost.'" class="taxed_cost" data-item_id="'.$itemId.'" />
							  $<span class="cost cost_'.$itemId.'" id="cost_'.$itemId.'">' . sprintf("%.2f", ($retail_cost * $itemQty)) . '</span>
							</td>
							<td class="text-center"><i class="fa fa-times alert remove" id="' . $itemId . '"></i></td>
							</tr>';
							$counter++;
						}
					  }
					}
						
					echo '<tr>
					<td></td>
					<td></td>
					<td></td>
					<td class="text-right">Subtotal:</td>
					<td>(<span id="totalQty" title="Total Quantity">' . $totalQty . '</span> pcs)</td>
					<td>$<span id="subtotal" title="SubTotal">' . sprintf("%.2f", $subtotal) . '</span></td>
					<td></td>
					</tr>';

					echo '<tr>
					<td></td>
					<td></td>
					<td></td>
					<td class="text-right">Sales tax:</td>
					<td></td>
					<td>$<span id="totalSalesTax" title="Sales tax">' . sprintf("%.2f", $totalSalesTax) . '</span></td>
					<td></td>
					</tr>';

					$total = $subtotal + $totalSalesTax;

					echo '<tr>
					<td></td>
					<td></td>
					<td></td>
					<td class="text-right"><strong>Total:</strong></td>
					<td></td>
					<td>$<span id="total" title="Total Cost">' . sprintf("%.2f", $total) . '</span></td>
					<td></td>
					</tr>';
			?>
                </tbody>
            </table>

            <div class="text-center">
                <span class="hide_buttons <?php echo (($total==0)?'hide':''); ?>">
                    <a href="#payment" class="button success small">Purchase</a>&nbsp;&nbsp;
                    <!-- (see js/cart.js $("#recalculate_cart").click() ) -->
                    <!-- v1 (working more correctly than v2) -->
                    <a href="javascript:void(0);" class="button secondary small" id="recalculate_cart">Recalculate the Cart</a>&nbsp;&nbsp;
                    <!-- /v1 -->
                    <!-- v2 -->
                    <!--<a href="shopping-cart.php" class="button secondary small" id="recalculate_cart">Recalculate the Cart</a>&nbsp;&nbsp;-->
                    <!-- /v2 -->
                    <!-- /(see js/cart.js $("#recalculate_cart").click() ) -->
                </span>
                <a href="javascript:void(0);" id="continue_shopping" class="button secondary small" onClick="history.go(-1);">Continue Shopping</a>
                <span class="hide_buttons <?php echo (($total==0)?'hide':''); ?>">
                    &nbsp;&nbsp;
                    <a href="javascript:void(0);" class="button alert small" id="empty_cart">Empty the Cart</a>
                </span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="small-12 large-12 columns">
            <h3 id="payment">Payment Information</h3>
        </div>
    </div>
    
    <div class="row">
        <div class="small-12 large-5 columns">
            <p><strong>Credit Card Payment</strong></p>
            <select  name="card_type" id="card_type">
                <option value>Card Type</option>
                <option value="Visa" >Visa</option>
                <option value="MC" >MasterCard</option>
                <option value="Amex" >American Express</option>
                <option value="Disc" >Discover</option>
            </select>
            <input name="card_name" type="text" id="card_name" value="" placeholder="Name on Card" />
            <input name="card_number" type="text" id="card_number" value="" placeholder="Card Number" />
            <input name="card_cvv" type="text" id="card_cvv" value="" placeholder="Security Code" />
            
            <div class="row">
                <div class="small-6 large-6 columns">
                    <label>Exp. Month
                    <select name="card_month" id="card_month">
                        <option value="">Month</option>
                        <option value="01" >January</option>
                        <option value="02" >February</option>
                        <option value="03" >March</option>
                        <option value="04" >April</option>
                        <option value="05" >May</option>
                        <option value="06" >June</option>
                        <option value="07" >July</option>
                        <option value="08" >August</option>
                        <option value="09" >September</option>
                        <option value="10" >October</option>
                        <option value="11" >November</option>
                        <option value="12" >December</option>
                    </select>
                    </label>
                </div>
                
                <div class="small-6 large-6 columns">
                    <label>Exp. Year
                    <select name="card_year" id="card_year">
                        <option value="">Year</option>
                        <option value="15" >2015</option>
                        <option value="16" >2016</option>
                        <option value="17" >2017</option>
                        <option value="18" >2018</option>
                        <option value="19" >2019</option>
                        <option value="20" >2020</option>
                        <option value="21" >2021</option>
                        <option value="22" >2022</option>
                        <option value="23" >2023</option>
                        <option value="24" >2024</option>
                        <option value="25" >2025</option>
                        <option value="26" >2026</option>
                        <option value="27" >2027</option>
                        <option value="28" >2028</option>
                    </select>
                    </label>
                </label>
                </div>
            </div>
            
          	<input  name="credit_pay" type="text" id="credit_pay" value="" placeholder="Credit Payment" onFocus="$(this).val($('#total').text());" onBlur="$(this).val($('#total').text());" />
        </div>
        
        <div class="small-12 large-1 columns">
           - or - 
        </div>
        
        <div class="small-12 large-6 columns">
            <p><strong>Bank Payment</strong></p>
            <input  name="bank_name" type="text" id="bank_name"  value="" placeholder="Bank Name" />
			<select name="account_type" id="account_type">
                <option value="">Account Type</option>
                <option value="C" >Personal Checking</option>
                <option value="B" >Business Checking</option>
                <option value="S" >Savings</option>
            </select>
			<input name="account_name" type="text" id="account_name" value="" placeholder="Account Name" />
			<input name="account_num" type="text" id="account_num" value="" placeholder="Account Number" />
			<input name="aba_num" type="text" id="aba_num" value="" placeholder="Routing Number" />
			<input name="ach_pay" type="text" id="ach_pay" value="" placeholder="ACH Payment" onFocus="$(this).val($('#total').text());" onBlur="$(this).val($('#total').text());" />
        </div>
    </div>
    
    <div class="row">
    	<div class="small-12 large-12 columns">
            <div id="signature-pad" class="m-signature-pad">
                <div class="m-signature-pad--body">
                  <canvas></canvas>
                </div>
            
                <div class="m-signature-pad--footer">
                    <strong>Sign above</strong><br>
                    <a data-action="clear" href="#">Clear</a> &mdash; <a data-action="save" href="#">Save</a>
                    <input type="hidden" id="input_name" name="input_name" value="" />
                </div>
            </div>
        </div>
    </div>

    <!-- Shipping Information -->
    <div class="row">
        <div class="small-12 large-12">
        <h3>Shipping Information</h3>
        <p><strong>Delivery Data</strong></p>
        </div>

        <div class="small-12 large-4 columns">
            <input tabindex="120" name="first_name" type="text" id="first_name" value="<?php echo $shipping_details['first_name']; ?>" onclick="return checkServices(this.name,this.id)" placeholder="First Name (REQUIRED)" required="required" />
            <input tabindex="123" name="street_address" type="text" id="street_address" value="<?php echo $shipping_details['street_address']; ?>" onclick="return checkServices(this.name,this.id)" placeholder="Street Address (REQUIRED)" required="required" />
            <input tabindex="126" name="zip_code" type="text" id="zip_code" value="<?php echo $shipping_details['zip_code']; ?>" placeholder="Zip Code (REQUIRED)" onclick="return checkServices(this.name,this.id)" />
        </div>
        
        <div class="small-12 large-4 columns">
            <input tabindex="121" name="middle_name" type="text" id="middle_name" value="<?php echo $shipping_details['middle_name']; ?>" onclick="return checkServices(this.name,this.id)" placeholder="Middle Name (optional)" />
            <input tabindex="124" name="city" type="text" id="city" value="<?php echo $shipping_details['city']; ?>" onclick="return checkServices(this.name,this.id)" placeholder="City (REQUIRED)" required="required" />
            <input tabindex="127" name="home_phone" type="text" id="home_phone" value="<?php echo $shipping_details['home_phone']; ?>" onclick="return checkServices(this.name,this.id)" placeholder="Phone (REQUIRED)" required="required" />
        </div>
        
        <div class="small-12 large-4 columns">
            <input tabindex="122" name="last_name" type="text" id="last_name" value="<?php echo $shipping_details['last_name']; ?>" onclick="return checkServices(this.name,this.id)" placeholder="Last Name (REQUIRED)" required="required" />
            <select tabindex="125" name="state" id="state" required="required">
                <option value="">Select State (REQUIRED)</option>
                <option value="AL" <?php echo ($shipping_details['state']=='AL'?"selected":""); ?>>Alabama</option>
                <option value="AK" <?php echo ($shipping_details['state']=='AK'?"selected":""); ?>>Alaska</option>
                <option value="AZ" <?php echo ($shipping_details['state']=='AZ'?"selected":""); ?>>Arizona</option>
                <option value="AR" <?php echo ($shipping_details['state']=='AR'?"selected":""); ?>>Arkansas</option>
                <option value="CA" <?php echo ($shipping_details['state']=='CA'?"selected":""); ?>>California</option>
                <option value="CO" <?php echo ($shipping_details['state']=='CO'?"selected":""); ?>>Colorado</option>
                <option value="CT" <?php echo ($shipping_details['state']=='CT'?"selected":""); ?>>Connecticut</option>
                <option value="DE" <?php echo ($shipping_details['state']=='DE'?"selected":""); ?>>Delaware</option>
                <option value="DC" <?php echo ($shipping_details['state']=='DC'?"selected":""); ?>>Wash. D.C.</option>
                <option value="FL" <?php echo ($shipping_details['state']=='FL'?"selected":""); ?>>Florida</option>
                <option value="GA" <?php echo ($shipping_details['state']=='GA'?"selected":""); ?>>Georgia</option>
                <option value="HI" <?php echo ($shipping_details['state']=='HI'?"selected":""); ?>>Hawaii</option>
                <option value="ID" <?php echo ($shipping_details['state']=='ID'?"selected":""); ?>>Idaho</option>
                <option value="IL" <?php echo ($shipping_details['state']=='IL'?"selected":""); ?>>Illinois</option>
                <option value="IN" <?php echo ($shipping_details['state']=='IN'?"selected":""); ?>>Indiana</option>
                <option value="IA" <?php echo ($shipping_details['state']=='IA'?"selected":""); ?>>Iowa</option>
                <option value="KS" <?php echo ($shipping_details['state']=='KS'?"selected":""); ?>>Kansas</option>
                <option value="KY" <?php echo ($shipping_details['state']=='KY'?"selected":""); ?>>Kentucky</option>
                <option value="LA" <?php echo ($shipping_details['state']=='LA'?"selected":""); ?>>Louisiana</option>
                <option value="ME" <?php echo ($shipping_details['state']=='ME'?"selected":""); ?>>Maine</option>
                <option value="MD" <?php echo ($shipping_details['state']=='MD'?"selected":""); ?>>Maryland</option>
                <option value="MA" <?php echo ($shipping_details['state']=='MA'?"selected":""); ?>>Massachusetts</option>
                <option value="MI" <?php echo ($shipping_details['state']=='MI'?"selected":""); ?>>Michigan</option>
                <option value="MN" <?php echo ($shipping_details['state']=='MN'?"selected":""); ?>>Minnesota</option>
                <option value="MS" <?php echo ($shipping_details['state']=='MS'?"selected":""); ?>>Mississippi</option>
                <option value="MO" <?php echo ($shipping_details['state']=='MO'?"selected":""); ?>>Missouri</option>
                <option value="MT" <?php echo ($shipping_details['state']=='MT'?"selected":""); ?>>Montana</option>
                <option value="NE" <?php echo ($shipping_details['state']=='NE'?"selected":""); ?>>Nebraska</option>
                <option value="NV" <?php echo ($shipping_details['state']=='NV'?"selected":""); ?>>Nevada</option>
                <option value="NH" <?php echo ($shipping_details['state']=='NH'?"selected":""); ?>>New Hampshire</option>
                <option value="NJ" <?php echo ($shipping_details['state']=='NJ'?"selected":""); ?>>New Jersey</option>
                <option value="NM" <?php echo ($shipping_details['state']=='NM'?"selected":""); ?>>New Mexico</option>
                <option value="NY" <?php echo ($shipping_details['state']=='NY'?"selected":""); ?>>New York</option>
                <option value="NC" <?php echo ($shipping_details['state']=='NC'?"selected":""); ?>>North Carolina</option>
                <option value="ND" <?php echo ($shipping_details['state']=='ND'?"selected":""); ?>>North Dakota</option>
                <option value="OH" <?php echo ($shipping_details['state']=='OH'?"selected":""); ?>>Ohio</option>
                <option value="OK" <?php echo ($shipping_details['state']=='OK'?"selected":""); ?>>Oklahoma</option>
                <option value="OR" <?php echo ($shipping_details['state']=='OR'?"selected":""); ?>>Oregon</option>
                <option value="PA" <?php echo ($shipping_details['state']=='PA'?"selected":""); ?>>Pennsylvania</option>
                <option value="RI" <?php echo ($shipping_details['state']=='RI'?"selected":""); ?>>Rhode Island</option>
                <option value="SC" <?php echo ($shipping_details['state']=='SC'?"selected":""); ?>>So. Carolina</option>
                <option value="SD" <?php echo ($shipping_details['state']=='SD'?"selected":""); ?>>So. Dakota</option>
                <option value="TN" <?php echo ($shipping_details['state']=='TN'?"selected":""); ?>>Tennessee</option>
                <option value="TX" <?php echo ($shipping_details['state']=='TX'?"selected":""); ?>>Texas</option>
                <option value="UT" <?php echo ($shipping_details['state']=='UT'?"selected":""); ?>>Utah</option>
                <option value="VT" <?php echo ($shipping_details['state']=='VT'?"selected":""); ?>>Vermont</option>
                <option value="VA" <?php echo ($shipping_details['state']=='VA'?"selected":""); ?>>Virginia</option>
                <option value="WA" <?php echo ($shipping_details['state']=='WA'?"selected":""); ?>>Washington</option>
                <option value="WV" <?php echo ($shipping_details['state']=='WV'?"selected":""); ?>>West Virginia</option>
                <option value="WI" <?php echo ($shipping_details['state']=='WI'?"selected":""); ?>>Wisconsin</option>
                <option value="WY" <?php echo ($shipping_details['state']=='WY'?"selected":""); ?>>Wyoming</option>
            </select>
            <input tabindex="128" name="email" type="text" id="email" value="<?php echo $shipping_details['email']; ?>" onclick="return checkServices(this.name,this.id)" placeholder="Email (REQUIRED)" required="required" />
        </div>
    </div>
    <!-- /Shipping Information -->

    <div class="row">
        <div class="text-center small-12 large-12 columns">
            <div id="successBox"></div>
        </div>
    </div>

    <div class="row">
        <div class="text-center small-12 large-12 columns">
            <input type="hidden" id="contract_key" name="contract_key" value="<?php echo $_SESSION['userContractKey'];	 ?>"  />
            <input type="hidden" id="check_pay" name="check_pay" value=""  />			<!-- !!!!! -->
            <input type="hidden" id="check_number" name="check_number" value=""  />		<!-- !!!!! -->
            <input type="hidden" id="cash_pay" name="cash_pay" value=""  />			<!-- !!!!! -->
            <input type="hidden" id="purchase_marker" name="purchase_marker" value=""  />	<!-- !!!!! -->
            <input type="hidden" id="total_due" name="total_due" value=""  />			<!-- !!!!! -->
            <input type="hidden" id="bar_code_array" name="bar_code_array" value=""  />		<!-- !!!!! -->
            <input type="hidden" id="data_bool" name="data_bool" value=""  />			<!-- !!!!! -->

            <input type="button" value="Submit Information" id="purchase_items" class="button buttonSubmit buttonPassesGreen buttonSize" onClick="$('#credit_pay').val($('#total').text()); $('#ach_pay').val($('#total').text());" />
            <a href="#" class="button secondary" onClick="history.go(-1);">Later</a>
        </div>
    </div>
    
    <script type="text/javascript" src="js/signature_pad.js"></script>
	<script type="text/javascript" src="js/signaturePad.js"></script>
    <?php include_once('inc/footer.php'); ?>
</body>
</html>