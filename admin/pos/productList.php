<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class  productList {

 private  $searchString = null;
 private  $searchType = null;
 private  $categoryId = null;
 private  $categoryName = null;
 private  $dropList = null;
 private  $dropOptions = null;

function setSearchString($searchString) {
                 $this->search_string = $searchString;
              }

function setSearchType($searchType) {
                 $this->search_type = $searchType;
              }


//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//======================================================================
function loadDropMenu() {

$dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT category_id, category_name FROM pos_category WHERE category_id != '7'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($category_id, $category_name);   
 
 $this->dropOptions = "";
 while ($stmt->fetch()) {  
    
             if($this->categoryId == $category_id) {
                $selected = "selected";
                }else{
                $selected = "";
                }
                
             $this->dropOptions .= "<option value=\"$category_id\" $selected>$category_name</option>\n";         
            }
                      
}
//---------------------------------------------------------------------------------------------------------------------------
function loadCategoryName() {

  $dbMain = $this->dbconnect();
  $stmt = $dbMain ->prepare("SELECT category_name  FROM pos_category WHERE category_id = '$this->categoryId'");   
  $stmt->execute(); 
  $stmt->store_result();      
  $stmt->bind_result($categoryName);
  $stmt->fetch();

  $this->categoryName = $categoryName;

    if(!$stmt->execute())  {
	  printf("Error: %s.\n", $stmt->error);
     }
   
     $stmt->close(); 

}
//----------------------------------------------------------------------------------------------
function loadRecords()   {

$dbMain = $this->dbconnect();

$searchType = $this->search_type; 
$searchString = $this->search_string; 

switch ($searchType) {
    case "cat":
        $stmt = $dbMain ->prepare("SELECT * FROM pos_inventory WHERE category_id = '$searchString' ORDER BY bar_code DESC"); 
        break;
    case "bar":
        $stmt = $dbMain ->prepare("SELECT * FROM pos_inventory WHERE bar_code = '$searchString' ORDER BY bar_code DESC");
        break;
    case "desc":
        $stmt = $dbMain ->prepare("SELECT * FROM pos_inventory WHERE product_desc LIKE '$searchString%' ORDER BY bar_code DESC");
        break;
      }

      $stmt->execute();      
      $stmt->store_result();      
      $stmt->bind_result($inventoryMarker, $categoryId, $barCode, $productDesc, $wholeCost, $retailCost, $inventory, $inventoryDate, $salesTax);   
      
 
      $table_header = "<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" width=\"100%\" class=\"product_details\">
<tr>
<th>#</th>
<th>Date</th>
<th>Barcode</th>
<th>Product Description</th>
<th>Category</th>
<th>Cost</th>
<th>Price</th>
<th>Tax</th>
<th>Quantity</th>
<th>Inventory</th>
<th>Edit</th>
<th>Delete</th>
</tr>\n";                   
                                    

       $i = 1;
       while ($stmt->fetch()) {                            
                               
                               $this->categoryId = $categoryId;
                               $this->loadCategoryName();
                               $this->loadDropMenu();
                               $inventoryDate = date("m/d/Y", strtotime($inventoryDate));
                                                                                             
                               
                               $counter = $i++;
                                
      
                               $records .="<tr>
<td>$counter</td>
<td>$inventoryDate</td>

<td>
<form style=\"display:inline;\" method=\"post\" action=\"editDeleteInventory.php\">
<input type=\"text\"  name=\"bar_code$counter\" id=\"bar_code$counter\" value=\"$barCode\" size=\"15\" maxlength=\"40\" style=\"font-size:7pt;font-weight: 700;font-style: normal;font-family: 'Arial','Helvetica','Times',serif;\" />
</td>

<td>
<input type=\"text\"  name=\"product_desc$counter\" id=\"product_desc$counter\" value=\"$productDesc\" size=\"30\" maxlength=\"50\" style=\"font-size:7pt;font-weight: 700;font-style: normal;font-family: 'Arial','Helvetica','Times',serif;\" />
</td>

<td>
<select name=\"pos_category$counter\" id=\"pos_category$counter\" style=\"font-size:7pt;font-style: normal;font-family: \'Arial\',\'Helvetica\',\'Times\',serif;\" />
$this->dropOptions
</select>
</td>

<td>
<input type=\"text\"  name=\"whole_cost$counter\" id=\"whole_cost$counter\" value=\"$wholeCost\" size=\"6\" maxlength=\"12\" style=\"font-size:7pt;font-weight: 700;font-style: normal;font-family: 'Arial','Helvetica','Times',serif;\" />
</td>

<td>
<input type=\"text\" name=\"retail_cost$counter\" id=\"retail_cost$counter\" value=\"$retailCost\" size=\"6\" maxlength=\"12\" style=\"font-size:7pt;font-weight: 700;font-style: normal;font-family: 'Arial','Helvetica','Times',serif;\" />
</td>

<td>
<input type=\"text\" name=\"sales_tax$counter\" id=\"sales_tax$counter\" value=\"$salesTax\" size=\"4\" maxlength=\"6\" title=\"For example, 0.0825 means 8.25%\" placeholder=\"For example, 0.0825 means 8.25%\" style=\"font-size:7pt;font-weight: 700;font-style: normal;font-family: 'Arial','Helvetica','Times',serif;\" />
</td>

<td>
<input type=\"text\" name=\"quantity$counter\" id=\"quantity$counter\" value=\"\" size=\"5\" maxlength=\"10\" style=\"font-size:7pt;font-weight: 700;font-style: normal;font-family: 'Arial','Helvetica','Times',serif;\" />
</td>

<td>$inventory</td>

<td>

<a href=\"../website/webAdmin/editStoreProductsInfoPage.php?itemId=$inventoryMarker&$searchType=$searchString&categoryName=$this->categoryName\" target=\"content\" title=\"Store Products Options Setup\" class=\"product_details\">...</a>

<input type=\"hidden\" name=\"inventory_marker\" value=\"$inventoryMarker\" />
<input type=\"hidden\" name=\"inventory_salt\" value=\"$counter\" />
<input type=\"hidden\" name=\"search_type\" id=\"search_type\" value=\"$searchType\" />
<input type=\"hidden\" name=\"search_string\" id=\"search_string\" value=\"$searchString\" />
<input type=\"hidden\" name=\"edit_switch$counter\" id=\"edit_switch$counter\" value=\"\" />
<input type=\"hidden\" name=\"original_cost$counter\" id=\"original_cost$counter\" value=\"$wholeCost\" />
<input type=\"submit\" name=\"edit\" id=\"$counter\" value=\"Save\" />
</form>
</td>
<td>
<form style=\"display:inline;\" action=\"editDeleteInventory.php\" method=\"post\" />
<input type=\"hidden\" name=\"inventory_marker\" value=\"$inventoryMarker\" />
<input type=\"hidden\" name=\"search_type\" id=\"search_type\" value=\"$searchType\" />
<input type=\"hidden\" name=\"search_string\" id=\"search_string\" value=\"$searchString\" />
<input type=\"submit\" name=\"delete\" value=\"Delete\" id=\"delete\" onClick=\"return confirmDelete();\" />
</form>
</td>
</tr>\n";
                                                          
                          }
                               //hear is the object for multiple records
                                $drop_table = "$table_header  $records";
                                $this->dropList = $drop_table;
                                $this->dropOptions = "";
        }     

//--------------------------------------------------------------------------------------------------------------------------------
//these are the links for the table list that are more than one item
   function getList()   {
		return($this->dropList);
    	} 


}