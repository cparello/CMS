<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  websiteMiscInfoSql{

function setPrivacy($privacy){
   $this->privacy = $privacy;
}
function setTerms($terms){
   $this->terms = $terms;
}


//connect to database
function dbconnect()   {
require"../../dbConnect.php";
return $dbMain;
}
//-------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------
function loadWebsiteMiscInfoOptions()  {
//echo "test1";
$dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT privacy, terms FROM web_misc WHERE row_key = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($this->privacy, $this->terms);
   $stmt->fetch();
   $stmt->execute();
   $stmt->close();
//echo "test2";

}
//----------------------------------------------------------------------------------
function updateWebsiteMiscInfoOptions() {
//echo"$this->currentBonusSetup, $this->currentPaymentSetup, $this->percentage, $this->tier1, $this->hourlyBump1, $this->tier2, $this->hourlyBump2, $this->tier3, $this->hourlyBump3, $this->flat1Hr, $this->flatHalfHour";
//echo"t3";
$dbMain = $this->dbconnect();
$sql = "UPDATE web_misc SET privacy = ?, terms = ? WHERE row_key = '1'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('ss', $this->privacy, $this->terms);
$stmt->execute();
$stmt->close(); 
//echo"<br>t4";
$this->confirmation_message = "Options Successfully Updated";
           return($this->confirmation_message);
}
//================================================

function getPrivacy(){
    return($this->privacy);
}
function getTerms(){
    return($this->terms);
}

}
?>