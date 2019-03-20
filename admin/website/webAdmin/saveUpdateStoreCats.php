<?php
session_start();


class  saveUpdateCatsWeb{

function setCatId($catId) {
          $this->catId = $catId;
          }
function setCatName($catName) {
          $this->catName = $catName;
          }
function  setCatShow($catShow) {
          $this->catShow = $catShow;
          }
//connect to database
function dbconnect()   {
require"../../dbConnect.php";
return $dbMain;
}

//-------------------------------------------------------------------------------------------------------------------
function loadSaveWebCats() {
$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT count(*) as count FROM website_store_categories WHERE cat_id = '$this->catId'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($count); 
    $stmt->fetch();
    $stmt->close();
    
    if ($count == 1){
        $sql = "UPDATE website_store_categories SET cat_id = ?, cat_name = ?, show_on_web = ? WHERE cat_id = '$this->catId'";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('iss', $this->catId, $this->catName, $this->catShow);
        if(!$stmt->execute())  {
            return($this->errorMessage);
            printf("Error: %s.\n", $stmt->error);
        	exit;
       }
        $stmt->close(); 
    }else{
        $sql = "INSERT INTO website_store_categories VALUES (?,?,?)";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('iss', $this->catId, $this->catName, $this->catShow);
        if(!$stmt->execute())  {
        	printf("Error: %s.\n", $stmt->error);
           }		
        $stmt->close();
    }

$bit = 1;
$passBack = "$bit";
return $passBack;

}
//======================================================================================


    
}
//--------------------------------------------------------------------------------------
$ajax_switch = $_REQUEST['ajax_switch'];
$catId = $_REQUEST['catId'];
$catName = $_REQUEST['catName'];
$catShow = $_REQUEST['catShow'];

//echo "$service_name hhh $service_quantity club $clubName";
//exit;
if($ajax_switch == 1) {

$loadPricing = new saveUpdateCatsWeb();
$loadPricing-> setCatId($catId);
$loadPricing-> setCatName($catName);
$loadPricing-> setCatShow($catShow);
$result1 = $loadPricing-> loadSaveWebCats();

echo"$result1";
exit;
}





?>