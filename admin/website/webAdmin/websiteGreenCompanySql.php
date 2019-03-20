<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  websiteGreenCompanySql{


function setGreen1($green1){
   $this->green1 = $green1;
}
function setGreen2($green2){
   $this->green2 = $green2;
}
function setGreen3($green3){
   $this->green3 = $green3;
}


//connect to database
function dbconnect()   {
require"../../dbConnect.php";
return $dbMain;
}
//-------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------
function loadWebsiteGreenCompanyOptions()  {
//echo "test1";
$dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT green1, green2, green3 FROM website_green_info WHERE web_key = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($this->green1, $this->green2, $this->green3);
   $stmt->fetch();

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
$stmt->close();
//echo "test2";

}
//----------------------------------------------------------------------------------
function updateWebsiteGreenCompanyOptions() {
//echo"$this->currentBonusSetup, $this->currentPaymentSetup, $this->percentage, $this->tier1, $this->hourlyBump1, $this->tier2, $this->hourlyBump2, $this->tier3, $this->hourlyBump3, $this->flat1Hr, $this->flatHalfHour";
//echo"t3";
$dbMain = $this->dbconnect();
$sql = "UPDATE website_green_info SET green1 = ?, green2 = ?, green3 = ? WHERE web_key = '1'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('sss', $this->green1, $this->green2, $this->green3);
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

function getGreen1(){
    return($this->green1);
}
function getGreen2(){
    return($this->green2);
}
function getGreen3(){
    return($this->green3);
}

}


?>