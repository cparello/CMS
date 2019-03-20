<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class  checkOrders{

private  $searchSql = null;
private  $submitButton = null;
private  $resultCount = "3";
private  $sqlWhere = null;
private  $barCode = null;
private  $category = null;
private  $status = null;

 
function setSearchSql($searchSql) {
    $this->searchSql = $searchSql;
    }
function setSubmitButton($submitButton) {
    $this->submitButton = $submitButton; 
    }
function setBarCode($barCode) {
    $this->barCode = $barCode; 
    }
function setCategory($category) {
    $this->category = $category; 
    }
function setStatus($status) {
    $this->status = $status; 
    }
    
 
 //connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//------------------------------------------------------------------------------------------
function cleanVariables($cleanVar) {

$cleanVar = preg_replace( '/\s+/', ' ', $cleanVar);
$cleanVar = trim($cleanVar);

return $cleanVar;

}
//------------------------------------------------------------------------------------------
function parseSearchSql()  {

$this->searchSql = trim($this->searchSql);

switch ($this->submitButton) {
        case "bar":               
               $this->sqlWhere = "bar_code = '$this->searchSql'";
        break;
        case "cat":
                $this->sqlWhere = "category_id = '$this->searchSql'";
        break;
        case "stat":
                if ($this->searchSql == '0')
                  $this->sqlWhere = "((status_id = '$this->searchSql') OR (status_id IS NULL))";
                else
                  $this->sqlWhere = "status_id = '$this->searchSql'";
        break;
        case "desc":
                $this->sqlWhere = "product_desc LIKE '$this->searchSql%'";                
        break;
     }
}
//------------------------------------------------------------------------------------------
function loadOrdersCount() {

$dbMain = $this->dbconnect();
$query = "SELECT COUNT(*) AS orders_count FROM merchant_sales ms"
        ." LEFT JOIN pos_shipping_details psd ON (psd.pos_identifier = ms.purchase_marker)"
        ." WHERE $this->sqlWhere GROUP BY purchase_marker";
$stmt = $dbMain ->prepare($query);
$stmt->execute(); 
$stmt->store_result();      
$stmt->bind_result($orders_count);

/*
$this->resultCount = $orders_count;
*/
$this->resultCount = 0;
while ($stmt->fetch())
 {
  $this->resultCount++;
 }

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
   
$stmt->close();    

 }
//----------------------------------------------------------------------------------------- 
function loadPosInventoryCount() {

if($this->resultCount == 0) {

$dbMain = $this->dbconnect();

//$stmt = $dbMain ->prepare("SELECT  COUNT(*) AS inventory_count  FROM pos_inventory WHERE $this->sqlWhere");   
$query = "SELECT COUNT(*) AS inventory_count FROM pos_inventory pi"
        ." LEFT JOIN merchant_sales ms ON (ms.bar_code = pi.pbar_code)"
        ." LEFT JOIN pos_shipping_details psd ON (psd.pos_identifier = ms.purchase_marker)"
        ." WHERE $this->sqlWhere GROUP BY purchase_marker";
        // ???
$stmt = $dbMain ->prepare($query);

$stmt->execute(); 
$stmt->store_result();      
$stmt->bind_result($inventory_count);
$stmt->fetch();

$this->resultCount = $inventory_count;

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
   
$stmt->close(); 

}

}
//-----------------------------------------------------------------------------------------
function checkDuplicates() {

$dbMain = $this->dbconnect();

if($this->category != "") {

  $this->category = $this->cleanVariables($this->category);
  $stmt = $dbMain ->prepare("SELECT  COUNT(*) AS category_count  FROM pos_category WHERE category_name = '$this->category'");   
  $stmt->execute(); 
  $stmt->store_result();      
  $stmt->bind_result($category_count);
  $stmt->fetch();

   if($category_count > 0) {
     $this->resultCount = 2;
     }
     
   if(!$stmt->execute())  {
	  printf("Error: %s.\n", $stmt->error);
     }
   
     $stmt->close();   
  }


  $this->barCode = $this->cleanVariables($this->barCode);
  $stmt = $dbMain ->prepare("SELECT  COUNT(*) AS orders_count  FROM merchant_sales WHERE bar_code = '$this->barCode'");   
  $stmt->execute(); 
  $stmt->store_result();      
  $stmt->bind_result($orders_count);
  $stmt->fetch();

   if($orders_count > 0) {
     $this->resultCount = 1;
     }

   if(!$stmt->execute())  {
	  printf("Error: %s.\n", $stmt->error);
     }
   
     $stmt->close();


}
//-----------------------------------------------------------------------------------------
function checkDuplicatesStat() {

$dbMain = $this->dbconnect();

if($this->status != "") {

  $this->status = $this->cleanVariables($this->status);
  $stmt = $dbMain ->prepare("SELECT  COUNT(*) AS status_count  FROM pos_shipping_status WHERE status_name = '$this->status'");   
  $stmt->execute(); 
  $stmt->store_result();      
  $stmt->bind_result($status_count);
  $stmt->fetch();

   if($status_count > 0) {
     $this->resultCount = 4;
     }
     
   if(!$stmt->execute())  {
	  printf("Error: %s.\n", $stmt->error);
     }
   
     $stmt->close();   
  }


  $this->barCode = $this->cleanVariables($this->barCode);
  $stmt = $dbMain ->prepare("SELECT  COUNT(*) AS orders_count  FROM merchant_sales WHERE bar_code = '$this->barCode'");   
  $stmt->execute(); 
  $stmt->store_result();      
  $stmt->bind_result($orders_count);
  $stmt->fetch();

   if($orders_count > 0) {
     $this->resultCount = 1;
     }

   if(!$stmt->execute())  {
	  printf("Error: %s.\n", $stmt->error);
     }
   
     $stmt->close();


}
//-----------------------------------------------------------------------------------------
function getResultCount() {
          return($this->resultCount);
          }
        

 }//end of class
//==================================================== 
 $bar_code = $_REQUEST['bar_code'];
 $new_cat_val = $_REQUEST['new_cat_val'];
 $new_stat_val = $_REQUEST['new_stat_val'];
 $ajax_switch = $_REQUEST['ajax_switch'];
 $sub_but = $_REQUEST['sub_but'];
 $search_sql = $_REQUEST['search_sql'];
 
 
if($ajax_switch == 1) {
   
$searchProducts = new checkOrders();
$searchProducts-> setSearchSql($search_sql);
$searchProducts-> setSubmitButton($sub_but);
$searchProducts-> parseSearchSql();
$searchProducts-> loadOrdersCount();
$result_count = $searchProducts-> getResultCount();

echo"$result_count";
exit;
}

if($ajax_switch == 2) {

$searchProducts = new checkOrders();
$searchProducts-> setBarCode($bar_code);
$searchProducts-> setCategory($new_cat_val);
$searchProducts-> checkDuplicates();
$result_count = $searchProducts-> getResultCount();

echo"$result_count";
exit;
}

if($ajax_switch == 3) {

$searchProducts = new checkOrders();
$searchProducts-> setSearchSql($search_sql);
$searchProducts-> setSubmitButton($sub_but);
$searchProducts-> parseSearchSql();
$searchProducts-> loadOrdersCount();
$searchProducts-> loadPosInventoryCount();
$result_count = $searchProducts-> getResultCount();

echo"$result_count";
exit;
}

if($ajax_switch == 4) {

$searchProducts = new checkOrders();
$searchProducts-> setBarCode($bar_code);
$searchProducts-> setStatus($new_stat_val);
$searchProducts-> checkDuplicatesStat();
$result_count = $searchProducts-> getResultCount();

echo"$result_count";
exit;
}

?>