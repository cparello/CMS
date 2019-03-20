<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  websiteStoreOptionsSql{


function setCatArray($catArray){
   $this->catArray = $catArray;
}

//connect to database
function dbconnect()   {
require"../../dbConnect.php";
return $dbMain;
}
//-------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------
function loadWebsiteStoreOptions()  {
//echo "test1";
$dbMain = $this->dbconnect();
$this->catArray = "";
   $stmt = $dbMain ->prepare("SELECT * FROM website_store_categories WHERE cat_id != ''");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($catId, $catName, $show);
   while($stmt->fetch()){
     $this->catArray .= "$catId, $catName, $show|";
   }
   
$stmt->close();
//echo "test2";

}
//----------------------------------------------------------------------------------
function updateWebsiteStoreOptions() {
//echo"$this->currentBonusSetup, $this->currentPaymentSetup, $this->percentage, $this->tier1, $this->hourlyBump1, $this->tier2, $this->hourlyBump2, $this->tier3, $this->hourlyBump3, $this->flat1Hr, $this->flatHalfHour";
//echo"t3";
$dbMain = $this->dbconnect();
$catArray = explode('|',$this->catArray);
foreach($catArray as $catList){
    $catDetails = explode(',',$catList);
    $catId = $catDetails[0];
    $catName = $catDetails[1];
    $catShow = $catDetails[2];
    
    $stmt = $dbMain ->prepare("SELECT count(*) as count FROM website_store_categories WHERE cat_id = '$catId'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($count); 
    $stmt->fetch();
    $stmt->close();
    
    if ($count == 1){
        $sql = "UPDATE website_store_categories SET cat_id = ?, cat_name = ?, show_on_web = ? WHERE cat_id = '$catId'";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('iss', $catId, $catName, $catShow);
        if(!$stmt->execute())  {
            return($this->errorMessage);
            printf("Error: %s.\n", $stmt->error);
        	exit;
       }
        $stmt->close(); 
    }else{
        $sql = "INSERT INTO website_store_categories VALUES (?,?,?)";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('iss', $catId, $catName, $catShow);
        $stmt->execute();
        if(!$stmt->execute())  {
        	printf("Error: %s.\n", $stmt->error);
           }		
        $stmt->close();
    }
    
}

//echo"<br>t4";
$this->confirmation_message = "Options Successfully Updated";
           return($this->confirmation_message);
}
//================================================

function getCatArray(){
    return($this->catArray);
}

}


?>