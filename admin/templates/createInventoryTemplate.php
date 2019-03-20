<?php
$inventoryTemplate = <<<INVENTORYTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/createGuestPass.css">
<link rel="stylesheet" href="../css/pop_hint.css">
<link rel="stylesheet" href="../css/info.css">
$javaScript1
$javaScript2
$javaScript3
$javaScript4
<title>$page_title</title>

</head>
<body>

$infoTemplate

<div id="userHeader">
$page_title  
</div>

<div id="conf" class="conf">
$confirmation 
</div>


<div id="noteForm">
<form id="form1" name="form1" method="post" action="createInventory.php">
<table border="0" align="center">
<tr>
<td colspan="3" class="grey" align="left">
<u>Select/ Create Category</u><a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos1', 1);" /><img src="../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>

<tr>
<td class="black">
Select Category:
</td>
<td class="black">
Create Category:   
<td>
</tr>

<tr>
<td class="black">
<select name="pos_category" id="pos_category" class="pullConf"/>$drop_menu_cat</select>
</td>
<td class="black">
<input type="text"  name="pos_cat_new" id="pos_cat_new" value="" size="30" maxlength="50" class="pullConf"/>   
<td>
</tr>

<tr>
<td colspan="2" class="greyTwo" align="left">
<u>Product Information</u><a href="javascript: void" id="pos2" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos2', 2);" /><img src="../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>

<tr>
<td class="black">
Bar Code:
</td>
<td class="black">
Product Description:   
<td>
</tr>

<tr>
<td class="black">
<input type="text"  name="bar_code" id="bar_code" value="" size="30" maxlength="40" class="pullConf"/> 
</td>
<td class="black">
<input type="text"  name="product_desc" id="product_desc" value="" size="30" maxlength="50" class="pullConf"/>   
<td>
</tr>



<tr>
<td colspan="2" class="greyTwo" align="left">
<u>Product Cost/ Inventory</u><a href="javascript: void" id="pos3" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -35, 'pos3', 3);" /><img src="../images/question-mark.png" class="alignMiddle"></a> 
</td>
</tr>

<tr>
<td class="black tdPad" colspan="2">
<table>
<tr>
<td class="black tdPad">
Wholesale Cost:
</td>
<td class="black tdPad">
Retail Cost:
</td>
<td class="black tdPad" title="For example, 0.0825 means 8.25%" >
Sales Tax:
</td>
<td class="black tdPad">
Inventory:
</td>
</tr>

<tr>
<td class="black">
<input type="text" class="terms pullConf" name="whole_cost" id="whole_cost" value="" size="10" maxlength="12"/> 
</td>
<td class="black">
<input type="text" class="terms pullConf" name="retail_cost" id="retail_cost" value="" size="10" maxlength="12"/> 
</td>
<td class="black" title="For example, 0.0825 means 8.25%">
<input type="text" class="terms pullConf" name="sales_tax" id="sales_tax" value="" size="10" maxlength="12" placeholder="For example, 0.0825 means 8.25%" /> 
</td>
<td class="black">
<input type="text" class="terms pullConf" name="inventory" id="inventory" value="" size="5" maxlength="10"/> 
</td>
</tr>
</table>
</td>
</tr>


<tr>
<td class="black" colspan="3">
<br><br>
<input type="submit" name="save" value="Save Inventory" /></tr>
<td>
</tr>
</table>
<input type="hidden" name="sub_mark"  id="sub_mark" value=""/>
<input type="hidden" name="marker"  id="marker" value="1"/>
</form>
</div>





<div class="popHint"   id="popup" style="display: none;">
<div class="menu_form_header" id="popup_drag">
<img class="menu_form_exit"   id="popup_exit" src="../images/popx.png" alt="" />
<span id= "contHint">
</span>
</div>
</div>

  
</body>
</html>
INVENTORYTEMPLATE;


echo"$inventoryTemplate";

?>


