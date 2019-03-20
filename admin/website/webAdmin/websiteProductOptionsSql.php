<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  websiteProductOptionsSql{


function setItemId($itemId){
   $this->itemId = $itemId;
}
function setItemDescription($itemDescription){
   $this->itemDescription = $itemDescription;
}
function setItemPicture($itemPicture){
   $this->itemPicture = $itemPicture;
}

//connect to database
function dbconnect()   {
require"../../dbConnect.php";
return $dbMain;
}
//-------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------
function loadWebsiteProductOptions()  {

$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT item_marker, description, picture FROM website_product_info WHERE item_marker = '$this->itemId'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->itemId, $this->itemDescription, $this->itemPicture);
$stmt->fetch();
$stmt->close();
//echo "test2";

}
//----------------------------------------------------------------------------------
function updateWebsiteProductOptions() {
//echo"$this->currentBonusSetup, $this->currentPaymentSetup, $this->percentage, $this->tier1, $this->hourlyBump1, $this->tier2, $this->hourlyBump2, $this->tier3, $this->hourlyBump3, $this->flat1Hr, $this->flatHalfHour";
$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT count(*) as count FROM website_product_info WHERE item_marker = '$this->itemId'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count); 
$stmt->fetch();
$stmt->close();

    
    if ($count == 1){
        $sql = "UPDATE website_product_info SET description = ?, picture = ? WHERE item_marker = '$this->itemId'";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('ss', $this->itemDescription, $this->itemPicture);
        if(!$stmt->execute())  {
            return($this->errorMessage);
            printf("Error: %s.\n", $stmt->error);
        	exit;
       }
        $stmt->close(); 
    }else{
        $sql = "INSERT INTO website_product_info VALUES (?,?,?)";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('iss', $this->itemId, $this->itemDescription, $this->itemPicture);
        if(!$stmt->execute())  {
        	printf("Error: %s.\n", $stmt->error);
           }		
        $stmt->close();
    }
    


//echo"<br>t4";
$this->confirmation_message = "Options Successfully Updated";
           return($this->confirmation_message);
}
//================================================

function getItemId(){
    return($this->itemId);
}
function getItemDescription(){
    return($this->itemDescription);
}
function getItemPicture(){
    return($this->itemPicture);
}

}


?>