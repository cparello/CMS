<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  websiteOwnerInfoSql{

function setOwnerName($ownerName){
   $this->ownerName = $ownerName;
}
function setOwnerMessage($ownerMessage){
   $this->ownerMessage = $ownerMessage;
}
function setOwnerAbout($ownerAbout){
   $this->ownerAbout = $ownerAbout;
}
function setOwnerPhoto($ownerPhoto){
   $this->ownerPhoto = $ownerPhoto;
}


//connect to database
function dbconnect()   {
require"../../dbConnect.php";
return $dbMain;
}
//-------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------
function loadWebsiteOwnerInfoOptions()  {
//echo "test1";
$dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT name, message, description, photo FROM website_owner_info WHERE web_key = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($this->ownerName, $this->ownerMessage, $this->ownerAbout, $this->ownerPhoto);
   $stmt->fetch();

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
$stmt->close();
//echo "test2";

}
//----------------------------------------------------------------------------------
function updateWebsiteOwnerInfoOptions() {
//echo"$this->currentBonusSetup, $this->currentPaymentSetup, $this->percentage, $this->tier1, $this->hourlyBump1, $this->tier2, $this->hourlyBump2, $this->tier3, $this->hourlyBump3, $this->flat1Hr, $this->flatHalfHour";
//echo"t3";
$dbMain = $this->dbconnect();
$sql = "UPDATE website_owner_info SET name = ?, message = ?, description = ?, photo = ? WHERE web_key = '1'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('ssss', $this->ownerName, $this->ownerMessage, $this->ownerAbout, $this->ownerPhoto);
if(!$stmt->execute())  {
    return($this->errorMessage);
    printf("Error: %s.\n", $stmt->error);
	exit;
   }
$stmt->close(); 
//echo"<br>t4";
$this->confirmation_message = "Options Successfully Updated";
           return($this->confirmation_message);
}
//================================================

function getOwnerMessage(){
    return($this->ownerMessage);
}
function getOwnerAbout(){
    return($this->ownerAbout);
}
function getOwnerName(){
    return($this->ownerName);
}
function getOwnerPhoto(){
    return($this->ownerPhoto);
}

}


?>