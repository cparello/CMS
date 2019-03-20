<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class inventoryList {

private $checkBoxArray = null;
private $arrayCount = null;
private $checkBoxList = null;
private $fromWhere = null;
private $typeList = null;
private $categoryName = null;
private $categoryId = null;
private $clubName = null;
private $inventory = null;
private $productDesc = null;
private $barcode = null;


function setCheckBoxList($checkBoxList) {
           $this->checkBoxList = $checkBoxList;
           }

function setTypeList($typeList) {
           $this->typeList = $typeList;
           }
           
function setFromWhere($fromWhere) {
           $this->fromWhere = $fromWhere;
           }


//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//---------------------------------------------------------------------------------------------------------------------------
function loadClubName() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id = '$this->fromWhere'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($club_name);   
 $stmt->fetch();
 
 $this->clubName = $club_name;
 
 if($this->fromWhere == 'I') {
    $this->clubName = 'Internet';
    }
   
 
 $stmt->close(); 

}
//---------------------------------------------------------------------------------------------------------------------------
function loadHeader() {

$header = <<<HEADER
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" href="../css/inventoryList.css">
<script type="text/javascript" src="../scripts/printPage.js"></script>

<title>Inventory Bar List</title>

</head>
<body>
<table align="center" border="0" cellspacing="0" cellpadding="2" width=98%>

HEADER;

echo"$header";

}
//---------------------------------------------------------------------------------------------------------------------------
function parseArrayElements() {

$this->checkBoxList = trim($this->checkBoxList);
$this->checkBoxArray = explode('|', $this->checkBoxList);
$this->arrayCount = count($checkBoxArray);

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
//---------------------------------------------------------------------------------------------------------------------------
function loadWareListInv() {

$tableHeader = "<tr>
<td align=\"left\" colspan=\"9\" class=\"titleHeader\">
Warehouse Product List &nbsp;&nbsp; <a href=\"javascript: void(0)\" onClick=\"printPage()\" class=\"printInv\"><span class=\"invList\">Print</span></a>
</td>
</tr>

<tr bgcolor=\"#F2F2F2\">
<th align=\"left\" class=\"headerFont\">#</th>
<th align=\"left\" class=\"headerFont\">Date Added</th>
<th align=\"left\" class=\"headerFont\">Barcode</th>
<th align=\"left\" class=\"headerFont\">Product Description</th>
<th align=\"left\" class=\"headerFont\">Category</th>
<th align=\"left\" class=\"headerFont\">Whole Cost</th>
<th align=\"left\" class=\"headerFont\">Retail Price</th>
<th align=\"left\" class=\"headerFont\">Tax</th>
<th align=\"left\" class=\"headerFont\">Inventory</th>
</tr>";

echo"$tableHeader";

$dbMain = $this->dbconnect();
$counter = 1;

 foreach($this->checkBoxArray as $val) {
          
          if($val != "") {
             $stmt = $dbMain ->prepare("SELECT * FROM pos_inventory WHERE inventory_marker = '$val'");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($inventoryMarker, $categoryId, $barCode, $productDesc, $wholeCost, $retailCost, $inventory, $inventoryDate, $salesTax);          
             $stmt->fetch(); 
             
             $this->categoryId = $categoryId;
             $this->loadCategoryName();
             $inventoryDate = date("m/d/Y", strtotime($inventoryDate));
             
              echo"<tr>
              <td align=\"left\" class=\"black\">$counter</td>
              <td align=\"left\" class=\"black\">$inventoryDate</td>
              <td align=\"left\" class=\"black\">$barCode</td>
              <td align=\"left\" class=\"black\">$productDesc</td>
              <td align=\"left\" class=\"black\">$this->categoryName</td>
              <td align=\"left\" class=\"black\">$wholeCost</td>
              <td align=\"left\" class=\"black\">$retailCost</td>
              <td align=\"left\" class=\"black\">$salesTax</td>
              <td align=\"left\" class=\"black\">$inventory</td>
              </tr>";
              
              
              $counter++;
              }
              } 
              
$stmt->close();       
       
echo"</table>
</body>
</html>";
       
exit;
}
//---------------------------------------------------------------------------------------------------------------------------
function loadClubListInv() {

$tableHeader = "<tr>
<td align=\"left\" colspan=\"9\" class=\"titleHeader\">
$this->clubName Product List &nbsp;&nbsp; <a href=\"javascript: void(0)\" onClick=\"printPage()\" class=\"printInv\"><span class=\"invList\">Print</span></a>
</td>
</tr>

<tr bgcolor=\"#F2F2F2\">
<th align=\"left\" class=\"headerFont\">#</th>
<th align=\"left\" class=\"headerFont\">Date Added</th>
<th align=\"left\" class=\"headerFont\">Barcode</th>
<th align=\"left\" class=\"headerFont\">Product Description</th>
<th align=\"left\" class=\"headerFont\">Category</th>
<th align=\"left\" class=\"headerFont\">Whole Cost</th>
<th align=\"left\" class=\"headerFont\">Retail Price</th>
<th align=\"left\" class=\"headerFont\">Tax</th>
<th align=\"left\" class=\"headerFont\">Inventory</th>
</tr>";

echo"$tableHeader";

$dbMain = $this->dbconnect();
$counter = 1;

 foreach($this->checkBoxArray as $val) {

          if($val != "") {
             $stmt = $dbMain ->prepare("SELECT * FROM club_inventory WHERE club_inv_marker = '$val'");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($clubInventoryMarker, $wareInventoryMarker, $inventoryDate, $clubId, $categoryId, $barCode, $productDesc, $retailCost, $salesTax, $inventory, $wholeCost);          
             $stmt->fetch(); 
             
             $this->categoryId = $categoryId;
             $this->loadCategoryName();
             $inventoryDate = date("m/d/Y", strtotime($inventoryDate));
             
              echo"<tr>
              <td align=\"left\" class=\"black\">$counter</td>
              <td align=\"left\" class=\"black\">$inventoryDate</td>
              <td align=\"left\" class=\"black\">$barCode</td>
              <td align=\"left\" class=\"black\">$productDesc</td>
              <td align=\"left\" class=\"black\">$this->categoryName</td>
              <td align=\"left\" class=\"black\">$wholeCost</td>
              <td align=\"left\" class=\"black\">$retailCost</td>
              <td align=\"left\" class=\"black\">$salesTax</td>
              <td align=\"left\" class=\"black\">$inventory</td>
              </tr>";
              
              
              $counter++;
              }
              } 
              
$stmt->close();       
       
echo"</table>
</body>
</html>";
       
exit;

}
//---------------------------------------------------------------------------------------------------------------------------
function parseBar() {

for($i=1; $i <= $this->inventory; $i++) {
     $inventory .= $i;
     }
     
$inventoryArray = str_split($inventory);

//echo"$inventoryArray";

$chunks = array_chunk($inventoryArray, 3);

foreach($chunks as $chunk) {

             echo "<tr>";
             foreach($chunk as $chunker) {
                          echo"
                           <td class=\"barPad\"><img src=\"../memberinterface/barCode.php?barcode=$this->barcode&width=220&height=60&quality=100&format=png&stream_type=1\">
                          <br>
                          <span class=\"blackTwo\">$this->productDesc</span>
                          </td>";                               
                          }
             echo "</tr>";

}

/*
//save this for future reference

for($i=1; $i <= $this->inventory; $i++) {

   if($i % 3 == 0) {
     echo "<tr>";
     }
     
     echo"
     <td class=\"barPad\"><img src=\"../memberinterface/barCode.php?barcode=$this->barcode&width=220&height=60&quality=100&format=jpeg&stream_type=1\">
     <br>
     <span class=\"blackTwo\">$this->productDesc</span>
     </td>";     
     
     
   if($i % 3 == 2) {
     echo "</tr>";
     }     
         }
*/


}
//---------------------------------------------------------------------------------------------------------------------------
function loadWareBar() {

$tableHeader = "<tr>
<td align=\"left\" colspan=\"4\" class=\"titleHeader\">
Warehouse Barcodes &nbsp;&nbsp; <a href=\"javascript: void(0)\" onClick=\"printPage()\" class=\"printInv\"><span class=\"invList\">Print</span></a>
</td>
</tr>";

echo"$tableHeader";

$dbMain = $this->dbconnect();

 foreach($this->checkBoxArray as $val) {

          if($val != "") {
             $stmt = $dbMain ->prepare("SELECT bar_code, product_desc, inventory FROM pos_inventory WHERE inventory_marker = '$val'");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($barcode, $productDesc, $inventory);          
             $stmt->fetch();
             
             $this->barcode = $barcode;
             $this->productDesc = $productDesc;
             $this->inventory = $inventory;
             $this->parseBar();
              }
          }
          
    $stmt->close();       
}
//---------------------------------------------------------------------------------------------------------------------------
function loadClubBar() {

$tableHeader = "<tr>
<td align=\"left\" colspan=\"4\" class=\"titleHeader\">
$this->clubName Barcodes &nbsp;&nbsp; <a href=\"javascript: void(0)\" onClick=\"printPage()\" class=\"printInv\"><span class=\"invList\">Print</span></a>
</td>
</tr>";

echo"$tableHeader";

$dbMain = $this->dbconnect();

 foreach($this->checkBoxArray as $val) {

          if($val != "") {
             $stmt = $dbMain ->prepare("SELECT bar_code, product_desc, inventory FROM club_inventory WHERE club_inv_marker = '$val'");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($barcode, $productDesc, $inventory);          
             $stmt->fetch();
             
             $this->barcode = $barcode;
             $this->productDesc = $productDesc;
             $this->inventory = $inventory;
             $this->parseBar();
              }
          }
          
    $stmt->close();       

}
//---------------------------------------------------------------------------------------------------------------------------
function createList() {

$this->parseArrayElements();

switch ($this->fromWhere) {
    case "W":
          if($this->typeList == 'I') {            
            $this->loadWareListInv();
            }elseif($this->typeList == 'B') {
            $this->loadWareBar();
            }

        break;
    default:
        $this->loadClubName();
          if($this->typeList == 'I') {
            $this->loadClubListInv();
            }elseif($this->typeList == 'B') {
            $this->loadClubBar();
            }
        break;
      }

}
//---------------------------------------------------------------------------------------------------------------------------




}
//=======================================================================
   $check_box_array = $_SESSION['check_box_array'];
   $type_list = $_SESSION['type_list'];
   $from_where = $_SESSION['from_where'];

   unset($_SESSION['check_box_array']);
   unset($_SESSION['type_list']);
   unset($_SESSION['from_where']);

   $lists = new inventoryList();
   $lists-> setCheckBoxList($check_box_array);
   $lists-> setTypeList($type_list);
   $lists-> setFromWhere($from_where);
   $lists-> loadHeader();
   $lists-> createList();
   

?>