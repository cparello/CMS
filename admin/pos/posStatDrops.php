<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this class formats the dropdown menu for clubs and facilities
class  posStatDrops{

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

$choose_stat = "<option value>Choose Status</option>\n";

if($this->defaultSelect == 0)  {
  $sqlWhere = "1";
  }
  
if($this->defaultSelect == 1)  {
  $sqlWhere = "status_id != '0'";
  }
  
if($this->defaultSelect == 2)  {
  $sqlWhere = "status_id <= '5'";
  }

if($this->defaultSelect == 3)  {
  $sqlWhere = "status_id > '5'";
  }

if($this->defaultSelect == 4)  {
  $sqlWhere = "status_id != '7'";
  }  
  
if($this->defaultSelect == 5)  {
  $sqlWhere = "status_id > '7'";
  }

$dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT status_id, status_name, status_color FROM pos_shipping_status WHERE $sqlWhere");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($status_id, $status_name, $status_color);   

    while ($stmt->fetch()) {                  
               $order_select .= "<option value=\"$status_id\" style=\"color:$status_color\">$status_name</option>\n";         
            }
            
return "$choose_stat$order_select";            

}





}

?>