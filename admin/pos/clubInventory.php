<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class  cubInventory{

 private  $searchString = null;
 private  $searchType = null;
 private  $categoryId = null;
 private  $categoryName = null;
 private  $dropList = null;
 private  $dropOptions = null;
 private  $clubId = null;
 private  $clubIdDrop = null;
 private  $allSelect = null;
 private  $locationDrop = null;
 private  $wareHouseList = null;
 private  $wareHouse = null;
 private  $serviceLocation = null;
 private  $clubList = null;
 private  $clubSections = null;
 private  $clubCurtains = null;

function setSearchString($searchString) {
                 $this->searchString = $searchString;
              }

function setSearchType($searchType) {
                 $this->searchType = $searchType;
              }


//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//======================================================================
function loadClubMenu() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT club_id, club_name FROM club_info WHERE club_id != ''");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($club_id, $club_name);   

    while ($stmt->fetch()) {   
              
              if($this->clubIdDrop == $club_id) {
                  $selected = 'selected';                 
                 }else{
                  $selected = "";
                 }
    
                 $product_select .= "<option value=\"$club_id\"$selected>$club_name</option>\n";         
            }
            
if($this->clubId == null)  {
$choose_loc = "<option value>Choose Location</option>\n";
}else{
//$choose_loc = "<option value=\"$this->clubIdDrop\" selected>$this->serviceLocation</option>\n";  
$choose_loc = "";
$warehouse = "<option value=\"W\">Warehouse</option>\n"; 
}

if($this->allSelect != null) {
$all_select = "<option value=\"0\">All</option>\n"; 
}

$shrinkage = "<option value=\"S\">Shrinkage</option>\n";   
$internet = "<option value=\"I\">Internet</option>\n"; 
            
                               
$this->locationDrop = "$choose_loc$all_select$internet$product_select$shrinkage$warehouse";            

}
//---------------------------------------------------------------------------------------------------------------------------
function loadDropMenu() {

$dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT category_id, category_name FROM pos_category WHERE category_id != '7'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($category_id, $category_name);   
 
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
function loadWarehouseRecords()   {

$this->loadClubMenu();

$dbMain = $this->dbconnect();

$searchType = $this->searchType; 
$searchString = $this->searchString; 

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
      
 
$table_header = "
<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" width=98%>
<tr>
<td align=\"right\" colspan=\"11\" class=\"invList\">
</td>
</tr>

<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">&nbsp;</th>
<th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Date Added</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Barcode</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Product Description</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Category</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Price</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Tax</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Inventory</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Quantity</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Location</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Assign</font>
<form id=\"form1\" name=\"form1\" method=\"post\" action=\"assignInventory.php\">
</th>
</tr>\n";                   
                                    

       $i = 1;
                      while ($stmt->fetch()) {                            
                               
                               $this->categoryId = $categoryId;
                               $this->loadCategoryName();
                               //$this->loadDropMenu();
                               $inventoryDate = date("m/d/Y", strtotime($inventoryDate));
                                                                                             
                                 //create color rows
                                 static $cell_count = 1;
                                 if($cell_count == 2) {
                                           $color = "#D8D8D8";
                                           $cell_count = "";
                                   }else{
                                           $color = "#FFFFFF";
                                   }
                                            $cell_count = $cell_count + 1;
                               
                                            $counter = $i++;
  

      
 $records .="<tr>
<td align=\"left\" valign =\"middle\" bgcolor=\"$color\"><input type=\"checkbox\" name=\"productMarker[]\" id=\"productMarker$counter\" value=\"$inventoryMarker\"></td>
<td align=\"left\" valign =\"middle\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$inventoryDate</b></font></td>
<td align=\"left\" valign =\"middle\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$barCode</b></font></td>
<td align=\"left\" valign =\"middle\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$productDesc</b></font></td>
<td align=\"left\" valign =\"middle\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->categoryName</b></font></td>
<td align=\"left\" valign =\"middle\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$retailCost</b></font></td>
<td align=\"left\" valign =\"middle\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$salesTax</b></font></td>
<td align=\"left\" valign =\"middle\" bgcolor=\"$color\" id=\"inventory$counter\" class=\"black\">$inventory</td>

<td align=\"left\" valign =\"middle\" bgcolor=\"$color\">
<input type=\"text\" name=\"quantity$counter\" id=\"quantity$counter\" value=\"\" size=\"5\" maxlength=\"6\" style=\"font-size:7pt;font-weight: 700;font-style: normal;font-family: \"Arial\",\"Helvetica\",\"Times\",serif;\"/>
</td>

<td align=\"left\" valign =\"middle\" bgcolor=\"$color\">
<select name=\"service_location$counter\" id=\"service_location$counter\" style=\"font-size:7pt;font-weight: 700;font-style: normal;font-family: \"Arial\",\"Helvetica\",\"Times\",serif;\"/>
$this->locationDrop
</select>
<input type=\"hidden\" name=\"from_where$counter\" id=\"from_where$counter\" value=\"W\" />
</td>

<td align=\"left\"  valign =\"top\" bgcolor=\"$color\">
<input type=\"submit\" name=\"assign$counter\" id=\"assign$counter\" value=\"Assign\">
</td>
</tr>\n";
                                                          
}
                          
  //here is the object for multiple records
$footerButtons ="  
<tr>
<td align=\"right\" colspan=\"11\" class=\"divButtons\">
<input type=\"button\" class=\"divideBut listBar\" name=\"printList\" id=\"printList\"  value=\"Print Inventory List\"/>&nbsp;
<input type=\"button\" class=\"divideBut listBar\" name=\"printBar\" id=\"printBar\"  value=\"Print Bar Codes\"/>
<input type=\"hidden\" name=\"salt\" id=\"salt\" value=\"\" />
<input type=\"hidden\" name=\"inventory_marker\" id=\"inventory_marker\" value=\"\" />
<input type=\"hidden\" name=\"search_string\" value=\"$this->searchString\" />
<input type=\"hidden\" name=\"search_type\" value=\"$this->searchType\" />
</form>
</td>
</tr>
</table>";

 $this->wareHouseList = "$table_header  $records $footerButtons";
 
 $this->wareHouse = "
<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" class=\"tabBoard1\">
<tr class=\"tabHead2\">
<td align=\"left\" valign =\"middle\" colspan=\"10\" class=\"invList2 header\">
Warehouse
<span class=\"plusMin\">+</span>
</td>
</tr>
<tr class=\"content\">
<td colspan=\"11\">
 $this->wareHouseList
</td>
</tr>
</table>
 ";
 
$stmt->close();  
 
 $this->dropOptions = "";
 
}     
//--------------------------------------------------------------------------------------------------------------------------------
function loadClubRecords()   {

$dbMain = $this->dbconnect();

$searchType = $this->searchType; 
$searchString = $this->searchString; 

switch ($searchType) {
    case "cat":
        $stmt = $dbMain ->prepare("SELECT * FROM club_inventory WHERE category_id = '$searchString' AND club_id='$this->clubId' ORDER BY bar_code DESC"); 
        break;
    case "bar":
        $stmt = $dbMain ->prepare("SELECT * FROM club_inventory WHERE bar_code = '$searchString' AND club_id='$this->clubId' ORDER BY bar_code DESC");
        break;
    case "desc":
        $stmt = $dbMain ->prepare("SELECT * FROM club_inventory WHERE product_desc LIKE '$searchString%' club_id='$this->clubId' ORDER BY bar_code DESC");
        break;
      }

      $stmt->execute();      
      $stmt->store_result();      
      $stmt->bind_result($clubInventoryMarker, $wareInventoryMarker, $inventoryDate, $clubId, $categoryId, $barCode, $productDesc, $retailCost, $salesTax, $inventory, $whole_cost);   
            
 
$table_header = "
<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" width=98%>
<tr>
<td align=\"right\" colspan=\"11\" class=\"invList\">
</td>
</tr>

<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">&nbsp;</th>
<th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Date Added</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Barcode</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Product Description</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Category</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Price</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Tax</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Inventory</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Quantity</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Location</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Assign</font>
<form id=\"form$this->clubId\" name=\"form$this->clubId\" method=\"post\" action=\"assignInventory.php\" class=\"question_form\"></th>
</tr>\n";                   
                                    

       $i = 1;
                      while ($stmt->fetch()) {                            
                               
                               $this->categoryId = $categoryId;                               
                               $this->loadCategoryName();
                               $this->clubIdDrop = $clubId;
                               $this->loadClubMenu();
                               //$this->loadDropMenu();
                               $inventoryDate = date("m/d/Y", strtotime($inventoryDate));
                                                                                             
                                 //create color rows
                                 static $cell_count = 1;
                                 if($cell_count == 2) {
                                           $color = "#D8D8D8";
                                           $cell_count = "";
                                   }else{
                                           $color = "#FFFFFF";
                                   }
                                            $cell_count = $cell_count + 1;
                               
                                            $counter = $i++;
  

      
 $records .="<tr>
<td align=\"left\" valign =\"middle\" bgcolor=\"$color\"><input type=\"checkbox\" name=\"productMarker$this->clubId[]\" id=\"productMarker$this->clubId\" value=\"$clubInventoryMarker\"></td>
<td align=\"left\" valign =\"middle\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$inventoryDate</b></font></td>
<td align=\"left\" valign =\"middle\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$barCode</b></font></td>
<td align=\"left\" valign =\"middle\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$productDesc</b></font></td>
<td align=\"left\" valign =\"middle\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->categoryName</b></font></td>

<td align=\"left\" valign =\"middle\" bgcolor=\"$color\">
<input type=\"text\" name=\"retail_cost$counter\" id=\"retail_cost$counter\" value=\"$retailCost\" size=\"5\" maxlength=\"6\" style=\"font-size:7pt;font-weight: 700;font-style: normal;font-family: \"Arial\",\"Helvetica\",\"Times\",serif;\"/>
</td>

<td align=\"left\" valign =\"middle\" bgcolor=\"$color\">
<input type=\"text\" name=\"sales_tax$counter\" id=\"sales_tax$counter\" value=\"$salesTax\" size=\"5\" maxlength=\"6\" style=\"font-size:7pt;font-weight: 700;font-style: normal;font-family: \"Arial\",\"Helvetica\",\"Times\",serif;\"/>
</td>

<td align=\"left\" valign =\"middle\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$inventory</b></font></td>

<td align=\"left\" valign =\"middle\" bgcolor=\"$color\">
<input type=\"text\" name=\"quantity$counter\" id=\"quantity$counter\" value=\"\" size=\"5\" maxlength=\"6\" style=\"font-size:7pt;font-weight: 700;font-style: normal;font-family: \"Arial\",\"Helvetica\",\"Times\",serif;\"/>
</td>

<td align=\"left\" valign =\"middle\" bgcolor=\"$color\">
<select name=\"service_location$counter\" id=\"service_location$counter\" style=\"font-size:7pt;font-weight: 700;font-style: normal;font-family: \"Arial\",\"Helvetica\",\"Times\",serif;\"/>
$this->locationDrop
</select>
<input type=\"hidden\" name=\"from_where$counter\" id=\"from_where$counter\" value=\"$this->clubId\"/>
<input type=\"hidden\" name=\"inventory$counter\" id=\"inventory$counter\" value=\"$inventory\"/>
<input type=\"hidden\" name=\"product_marker$counter\" id=\"product_marker$counter\" value=\"$wareInventoryMarker\"/>
</td>

<td align=\"left\"  valign =\"top\" bgcolor=\"$color\">
<input type=\"submit\" name=\"assignClub$counter\" id=\"assignClub$counter\" value=\"Assign\">
</td>
</tr>\n";
                                                          
                          }
                          
  //here is the object for multiple records
$footerButtons ="  
<tr>
<td align=\"right\" colspan=\"11\" class=\"divButtons\">


<input type=\"button\" class=\"divideBut listBarTwo\" name=\"printList$this->clubId\" id=\"printList_$this->clubId\"  value=\"Print Inventory List\"/>&nbsp;
<input type=\"button\" class=\"divideBut listBarTwo\" name=\"printBar$this->clubId\" id=\"printBar_$this->clubId\"  value=\"Print Bar Codes\"/>


<input type=\"hidden\" name=\"salt\" id=\"salt\" value=\"\" />
<input type=\"hidden\" name=\"inventory_marker\" id=\"inventory_marker\" value=\"\" />
<input type=\"hidden\" name=\"search_string\" value=\"$this->searchString\" />
<input type=\"hidden\" name=\"search_type\" value=\"$this->searchType\" />
</form>
</td>
</tr>
</table>";

 if($records != "") {
   $this->clubList = "$table_header  $records $footerButtons";
   }else{
   $this->clubList = "<span class=\"grey\"><p>There is currently no inventory assigned to this location</span>";
   }
 
 $this->clubSections .= "
<tr class=\"tabHead2\">
<td align=\"left\" valign =\"middle\" colspan=\"10\" class=\"invList2 header\">
$this->serviceLocation
<span class=\"plusMin\">+</span>
</td>
</tr>
<tr class=\"content\">
<td colspan=\"11\">
 $this->clubList
</td>
</tr>";
 
 
 
 $this->dropOptions = "";
 
}     
//--------------------------------------------------------------------------------------------------------------------------------
function loadClubs() {

$this->clubId = 'I'; 
$this->serviceLocation = 'Internet';
$this->loadClubRecords();


 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT club_id, club_name FROM club_info WHERE club_id != ''");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($club_id, $club_name);   

    while ($stmt->fetch()) {   
             $this->clubId = $club_id;
             $this->serviceLocation = $club_name;
             $this->loadClubRecords();
             }
             


$this->clubCurtains =  "
<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" class=\"tabBoard1\">
$this->clubSections
</table>";

}
//--------------------------------------------------------------------------------------------------------------------------------
//these are the links for the table list that are more than one item
   function getWareHouseList()  {
		return($this->warehouseList);
    	} 
   function getWareHouse()  {
		return($this->wareHouse);
    	} 
   function getClubCurtains()  {
        return($this->clubCurtains);
        }




}