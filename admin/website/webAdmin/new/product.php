<?php
include_once('php/connection.php');
include_once('php/cart/functions.php');

$itemId = "";
$itemId = $_REQUEST['itemId'];

//$stmt = $dbMain ->prepare("SELECT bar_code, product_desc, retail_cost, sales_tax, category_id, inventory FROM pos_inventory WHERE inventory_marker = '$itemId'");
//$stmt = $dbMain ->prepare("SELECT bar_code, product_desc, retail_cost, sales_tax, category_id, inventory FROM club_inventory WHERE club_inv_marker = '$itemId'");
$stmt = $dbMain ->prepare("SELECT bar_code, product_desc, retail_cost, sales_tax, category_id, inventory FROM club_inventory WHERE inventory_marker = '$itemId' AND club_id = 'I'");
echo($dbMain->error);
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($barcode, $product_desc, $retail_cost, $sales_tax, $category_id, $product_max_qty); 
$stmt->fetch();   
$stmt->close(); 

$productArray = "$itemId^$barcode^$retail_cost^$sales_tax^$product_desc^1^$product_max_qty|"; // "1" at the end is the quantity of the products (item_qty) in the cart, $product_max_qty is the quantity of the inventory in the stock (item_max_qty)

$stmt = $dbMain ->prepare("SELECT description, picture FROM website_product_info WHERE item_marker = '$itemId'");
echo($dbMain->error);
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($description, $pictureMain); 
$stmt->fetch();   
$stmt->close();

$cartItemsIds = getCartItemsIds(); // Get the IDs of the products in the cart
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <?php include_once('inc/meta.php'); ?>
    <script type="text/javascript" src="js/cart.js"></script>
</head>
<body>
    <?php include_once('inc/header.php'); ?>
    
    <div id="subnav" style="background:#e9e9e9;">
        <div class="row">
            <dl class="sub-nav">
                <dt>Category:</dt>
                <?php
                $stmt = $dbMain ->prepare("SELECT cat_id, cat_name FROM website_store_categories WHERE show_on_web = 'Y'");
                echo($dbMain->error);
                $stmt->execute();      
                $stmt->store_result();      
                $stmt->bind_result($cat_id, $cat_name); 
                while ($stmt->fetch()) {
                    if ($cat_id == $cat_id_selected) {
                        echo '<dd class="active">';
                    } else {
                        echo '<dd>';
                    }
                    echo '<a href="store.php?cat_id=' . $cat_id . '">' . $cat_name . '</a></dd>';
                }
                ?>
            </dl>
        </div>
    </div>
    
    <div class="row margin-top-bottom">
        <div class="small-12 large-8 columns"><img src="../pictures/gear/<?php echo $pictureMain ?>" width="100%"></div>
        
        <div class="small-12 large-4 columns">
            <h2><?php echo $product_desc ?></h2>
            <p><?php echo '<strong>$' . $retail_cost . '</strong>' ?></p>
            <p><?php echo $description ?></p>
            <p>
                <a href="javascript:void(0);" class="button small <?php echo  (in_array($itemId, $cartItemsIds)? "secondary":"success");  ?> add2cart" id="<?php echo $itemId ?>">Add to Cart</a>
                <a <?php echo (($_REQUEST['fromCart']=='1')? 'href="store.php?cat_id='.$category_id.'"' : 'href="#" onClick="history.go(-1);"'); ?> class="button small secondary">Continue Shopping</a>
            </p>
            <input type="hidden" name="product_array" id="product_array_<?php echo $itemId ?>" value="<?php echo htmlentities($productArray) ?>"/>
        </div>
    </div>
    
    <?php include_once('inc/footer.php'); ?>
</body>
</html>