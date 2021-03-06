<?php
include_once('php/connection.php');
include_once('php/cart/functions.php');

$cat_id_selected = "";
$cat_id_selected = $_REQUEST['cat_id'];

//$stmt = $dbMain ->prepare("SELECT count(*) as count FROM pos_inventory WHERE category_id = '$cat_id_selected'");
$stmt = $dbMain ->prepare("SELECT count(*) as count FROM club_inventory WHERE category_id = '$cat_id_selected' AND club_id = 'I'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count); 
$stmt->fetch();
$stmt->close();
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
    
    <div id="cover"><h1>Store</h1></div>
    
    <?php
    $cartItemsIds = getCartItemsIds(); // Get the IDs of the products in the cart

    $counter = 0;
    if ($cat_id_selected != "") {
        //$stmt = $dbMain ->prepare("SELECT bar_code, product_desc, retail_cost, inventory_marker, sales_tax, category_id, inventory FROM pos_inventory WHERE category_id = '$cat_id_selected'");
        $stmt = $dbMain ->prepare("SELECT bar_code, product_desc, retail_cost, inventory_marker, sales_tax, category_id, inventory FROM club_inventory WHERE category_id = '$cat_id_selected' AND club_id = 'I'");
        echo($dbMain->error);
        $stmt->execute();      
        $stmt->store_result();
        $stmt->bind_result($barcode, $product_desc, $retail_cost, $inventory_marker, $sales_tax, $category_id, $product_max_qty);

        echo '<div class="store_catalog">';
        echo '  <div class="row">';
        while ($stmt->fetch()) {
            /*
            if (($counter+1 > 1) AND (($counter+1)%4) == 0) { 
                echo '</div><div class="row">';
            }
            */
            $productArray = "$inventory_marker^$barcode^$retail_cost^$sales_tax^$product_desc^1^$product_max_qty|"; // "1" at the end is the quantity of the products in the cart (item_qty), $product_max_qty is the quantity of the inventory in the stock (item_max_qty)

            $stmt99 = $dbMain ->prepare("SELECT description, picture FROM website_product_info WHERE item_marker = '$inventory_marker'");
            echo($dbMain->error);
            $stmt99->execute();      
            $stmt99->store_result();      
            $stmt99->bind_result($description, $pictureMain); 
            $stmt99->fetch();   
            $stmt99->close();
            
            echo '<div class="small-12 large-3 columns">
            <ul class="pricing-table">
                <li class="bullet-item"><a href="product.php?itemId=' . $inventory_marker . '"><img src="../pictures/gear/' . $pictureMain . '" alt="'.$description.'" title="'.$description.'"></a>
                <li class="title" title="'.$product_desc.'">' . $product_desc . '</li>
                <li class="price">$' . $retail_cost . '<br />
                    <a href="javascript:void(0);" class="button tiny ' . (in_array($inventory_marker, $cartItemsIds)? "secondary":"success") . ' add2cart" id="'.$inventory_marker.'">Add to Cart</a>
                    <input type="hidden" name="product_array" id="product_array_'.$inventory_marker.'" value="'.htmlentities($productArray).'"/>
                </li>
            </ul>
            </div>';

            if (($counter+1 > 1) AND (($counter+1)%4) == 0) { 
                echo '</div><div class="row">';
            }
            $counter++;
        }
        echo '  </div>';
        echo '</div>';
    }
    ?>
    
    <?php include_once('inc/footer.php'); ?>
</body>
</html>