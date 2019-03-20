<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  retailProductDrops {

private  $clubId = null;
private  $productDrops = null;
private  $categoryType = null;


function setClubId($clubId) {
       $this->clubId = $clubId;
       }

function setCategoryType($categoryType) {
       $this->categoryType = $categoryType;
       }
       
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//---------------------------------------------------------------------------------
function loadProductDrops() {

if($this->clubId == '0') {
  $sql1 = "club_id != '0' AND";
  $distinct = "DISTINCT";
  }else{
  $sql1 = "club_id = '$this->clubId' AND";
  $distinct = "";
  }

if($this->categoryType == 'ARS') {
   $sql2 = "category_id != '0'";
   }else{
   $sql2 = "category_id = '$this->categoryType'";
   }
   
$sqlWhere =  "$sql1 $sql2";

   
$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT $distinct bar_code, product_desc  FROM club_inventory WHERE $sqlWhere ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($barCode, $productDesc);
   $rowCount = $stmt->num_rows;
  
   while ($stmt->fetch()) {
           
               if($categoryId != "7") {
                  $retailProducts .= "<option value=\"$barCode\">$productDesc</option>\n";
                  }
           }
           
$dropHeader = "<option value>Select Product</option>\n<option value=\"AP\">All Products</option>\n"; 

  

$this->productDrops = "$dropHeader$retailProducts";


}
//---------------------------------------------------------------------------------
function getProductDrops() {
           return($this->productDrops);
           }




}
//---------------------------------------------------------------------------------

$ajax_switch = $_REQUEST['ajax_switch'];
$club_id = $_REQUEST['club_id'];
$category_type = $_REQUEST['category_type'];

if($ajax_switch == 1) {

$products = new retailProductDrops();
$products-> setCategoryType($category_type);
$products-> setClubId($club_id);
$products-> loadProductDrops();
$product_drops = $products-> getProductDrops();

echo"$product_drops";
exit;


}