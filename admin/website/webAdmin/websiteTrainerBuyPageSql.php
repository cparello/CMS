<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  websiteTrainerBuyPageSql{


function setNumberPackages($numberPackage){
   $this->numberPackage = $numberPackage;
}
function setPackage1($package1){
   $this->package1 = $package1;
}
function setPackage2($package2){
   $this->package2 = $package2;
}
function setPackage3($package3){
   $this->package3 = $package3;
}
function setPackage4($package4){
   $this->package4 = $package4;
}
function setPackage5($package5){
   $this->package5 = $package5;
}
function setPackage6($package6){
   $this->package6 = $package6;
}

function  setDescrip1($descrip1){
   $this->descrip1 = $descrip1;
}
function  setDescrip2($descrip2){
   $this->descrip2 = $descrip2;
}
function  setDescrip3($descrip3){
   $this->descrip3 = $descrip3;
}
function  setDescrip4($descrip4){
   $this->descrip4 = $descrip4;
}
function  setDescrip5($descrip5){
   $this->descrip5 = $descrip5;
}
function  setDescrip6($descrip6){
   $this->descrip6 = $descrip6;
}
function  setBoxColor($boxColor){
   $this->boxColor = $boxColor;
}
function  setTextColor($textColor){
   $this->textColor = $textColor;
}
function  setLiability($liability){
   $this->liability = $liability;
}
//connect to database
function dbconnect()   {
require"../../dbConnect.php";
return $dbMain;
}
//-------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------
function loadWebsiteTrainerPackageOptions()  {
//echo "test1";
$dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT number_packages, package1, package2, package3, package4, package5, package6, descrip1, descrip2, descrip3, descrip4, descrip5, descrip6, box_color, text_color, pt_liability_waiver FROM website_training_options WHERE web_key = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($this->numberPackage, $this->package1, $this->package2, $this->package3, $this->package4, $this->package5, $this->package6, $this->descrip1, $this->descrip2, $this->descrip3, $this->descrip4, $this->descrip5, $this->descrip6, $this->boxColor, $this->textColor, $this->liability);
   $stmt->fetch();
$stmt->close();
//echo "test2";

}
//----------------------------------------------------------------------------------
function updateWebsiteTrainerPackageOptions() {
//echo"$this->currentBonusSetup, $this->currentPaymentSetup, $this->percentage, $this->tier1, $this->hourlyBump1, $this->tier2, $this->hourlyBump2, $this->tier3, $this->hourlyBump3, $this->flat1Hr, $this->flatHalfHour";
//echo"t3";
$dbMain = $this->dbconnect();
$sql = "UPDATE website_training_options SET number_packages=?, package1=?, package2=?, package3=?, package4=?, package5=?, package6=?, descrip1=?, descrip2=?, descrip3=?, descrip4=?, descrip5=?, descrip6=?, box_color=?, text_color=?, pt_liability_waiver=? WHERE web_key = '1'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('ssssssssssssssss', $this->numberPackage, $this->package1, $this->package2, $this->package3, $this->package4, $this->package5, $this->package6, $this->descrip1, $this->descrip2, $this->descrip3, $this->descrip4, $this->descrip5, $this->descrip6, $this->boxColor, $this->textColor, $this->liability);
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

function getNumberPackages(){
   return($this->numberPackage);
}
function getPackage1(){
   return($this->package1);
}
function getPackage2(){
   return($this->package2);
}
function getPackage3(){
   return($this->package3);
}
function getPackage4(){
   return($this->package4);
}
function getPackage5(){
   return($this->package5);
}
function getPackage6(){
   return($this->package6);
}
function  getDescrip1(){
   return($this->descrip1);
}
function  getDescrip2(){
   return($this->descrip2);
}
function  getDescrip3(){
   return($this->descrip3);
}
function  getDescrip4(){
   return($this->descrip4);
}
function  getDescrip5(){
   return($this->descrip5);
}
function  getDescrip6(){
   return($this->descrip6);
}
function  getBoxColor(){
   return($this->boxColor);
}
function  getTextColor(){
   return($this->textColor);
}
function  getLiability(){
   return($this->liability);
}
}


?>