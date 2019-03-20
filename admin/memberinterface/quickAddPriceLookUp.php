<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class  priceLookUp{




function setBarCode($barCode) {
        $this->barCode = $barCode;
        }
function setInvMarker($iMarker) {
        $this->iMarker = $iMarker;
        }
        
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}        
//-------------------------------------------------------------------------------------------------
function loadPrice() {

 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT retail_cost, sales_tax FROM club_inventory WHERE inventory_marker = '$this->iMarker' AND bar_code = '$this->barCode' AND inventory != '0'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($retail_cost, $sales_tax);   
 $stmt->fetch();                 
 
 $this->priceListing = "$retail_cost|$sales_tax";
 
 $stmt->close();

}
//-------------------------------------------------------------------------------------------------
function getPriceListing() {
         return($this->priceListing);
         }


}
//========================================================
$barcode = $_REQUEST['barcode'];
$iMarker = $_REQUEST['iMarker'];
$ajax_switch = $_REQUEST['ajax_switch'];

if($ajax_switch == 1) {

   $listing = new priceLookUp();
   $listing-> setBarCode($barcode);
   $listing-> setInvMarker($iMarker);
   $listing-> loadPrice();
   $price_listing = $listing-> getPriceListing();
 //  echo "test $price_listing";
//exit;
   echo"$price_listing";

   exit;
  }


?>