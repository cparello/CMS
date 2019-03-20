<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this class formats the dropdown menu for clubs and facilities
class  posCatDrops{

private  $defaultSelect = null;

function setDefaulSelect($defaultSelect) {
        $this->defaultSelect = $defaultSelect;
         }



//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//---------------------------------------------------------------------------------------------------------------------------
function loadMenu() {

$choose_cat = "<option value>Choose Category</option>\n";

if($this->defaultSelect == 1)  {
  $sqlWhere = "category_id != '0'";
  }
  
if($this->defaultSelect == 2)  {
  $sqlWhere = "category_id <= '5'";
  }

if($this->defaultSelect == 3)  {
  $sqlWhere = "category_id > '5'";
  }

if($this->defaultSelect == 4)  {
  $sqlWhere = "category_id != '7'";
  }  
  
if($this->defaultSelect == 5)  {
  $sqlWhere = "category_id > '7'";
  }

$dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT category_id, category_name FROM pos_category WHERE $sqlWhere");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($category_id, $category_name);   

    while ($stmt->fetch()) {                  
               $product_select .= "<option value=\"$category_id\">$category_name</option>\n";         
            }
            
return "$choose_cat$product_select";            

}





}

?>