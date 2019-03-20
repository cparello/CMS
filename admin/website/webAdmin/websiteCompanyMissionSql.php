<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  websiteCompanyMissionSql{


function setMissionStatement($missionStatement){
   $this->missionStatement = $missionStatement;
}
function setMotto($motto){
   $this->motto = $motto;
}

//connect to database
function dbconnect()   {
require"../../dbConnect.php";
return $dbMain;
}
//-------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------
function loadWebsiteCompanyMissionOptions()  {
//echo "test1";
$dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT mission_statement, motto FROM website_company_mission WHERE web_key = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($this->missionStatement, $this->motto);
   $stmt->fetch();

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
$stmt->close();
//echo "test2";

}
//----------------------------------------------------------------------------------
function updateWebsiteCompanyMissionOptions() {
//echo"$this->currentBonusSetup, $this->currentPaymentSetup, $this->percentage, $this->tier1, $this->hourlyBump1, $this->tier2, $this->hourlyBump2, $this->tier3, $this->hourlyBump3, $this->flat1Hr, $this->flatHalfHour";
//echo"t3";
$dbMain = $this->dbconnect();
$sql = "UPDATE website_company_mission SET mission_statement = ?, motto = ? WHERE web_key = '1'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('ss', $this->missionStatement, $this->motto);
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

function getMissionStatement(){
    return($this->missionStatement);
}
function getMotto(){
    return($this->motto);
}


}


?>