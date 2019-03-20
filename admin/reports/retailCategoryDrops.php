<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  retailCategoryDrops {

private  $clubId = null;
private  $categoryDrops = null;
private  $flowType = null;


function setClubId($clubId) {
       $this->clubId = $clubId;
       }

function setFlowType($flowType) {
       $this->flowType = $flowType;
       }
       
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//---------------------------------------------------------------------------------
function loadCategoryDrops() {

$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT category_id, category_name  FROM pos_category WHERE category_id !='0' ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($categoryId, $category_name);
   $rowCount = $stmt->num_rows;
  
   while ($stmt->fetch()) {
           
               if($categoryId != "7") {
                  $retailCategories .= "<option value=\"$categoryId\">$category_name</option>\n";
                  }
           }
           
$dropHeader = "<option value>Select Retail Category</option>\n<option value=\"ARS\">All Categories</option>\n"; 

  

$this->categoryDrops = "$dropHeader$retailCategories";


}
//---------------------------------------------------------------------------------
function getCategoryDrops() {
           return($this->categoryDrops);
           }




}
//---------------------------------------------------------------------------------
$ajax_switch = $_REQUEST['ajax_switch'];
$club_id = $_REQUEST['club_id'];
$flow_type = $_REQUEST['flow_type'];

if($ajax_switch == 1) {

$category = new retailCategoryDrops();
$category-> loadCategoryDrops();
$category_drops = $category-> getCategoryDrops();

echo"$category_drops";
exit;


}