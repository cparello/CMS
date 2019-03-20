<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  websiteJoinPageSql{


function setNumberMemberships($numberMemberships){
   $this->numberMemberships = $numberMemberships;
}
function setMembership1($membership1){
   $this->membership1 = $membership1;
}
function setMembership2($membership2){
   $this->membership2 = $membership2;
}
function setMembership3($membership3){
   $this->membership3 = $membership3;
}
function setMembership4($membership4){
   $this->membership4 = $membership4;
}
function setMembership5($membership5){
   $this->membership5 = $membership5;
}
function setMembership6($membership6){
   $this->membership6 = $membership6;
}

function setMem1($mem1){
   $this->mem1 = $mem1;
}
function setMem2($mem2){
   $this->mem2 = $mem2;
}
function setMem3($mem3){
   $this->mem3 = $mem3;
}
function setMem4($mem4){
   $this->mem4 = $mem4;
}
function setMem5($mem5){
   $this->mem5 = $mem5;
}
function setMem6($mem6){
   $this->mem6 = $mem6;
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
function  setBoxColorPromo($boxColorPromo){
   $this->boxColorPromo = $boxColorPromo;
}
function  setTextColorPromo($textColorPromo){
   $this->textColorPromo = $textColorPromo;
}
function   setService1($service1){
   $this->service1 = $service1;
}
function   setService2($service2){
   $this->service2 = $service2;
}
function   setService3($service3){
   $this->service3 = $service3;
}
function   setService4($service4){
   $this->service4 = $service4;
}
function   setService5($service5){
   $this->service5 = $service5;
}
function   setServicePhoto1($servicePhoto1){
   $this->servicePhoto1 = $servicePhoto1;
}
function   setServicePhoto2($servicePhoto2){
   $this->servicePhoto2 = $servicePhoto2;
}
function   setServicePhoto3($servicePhoto3){
   $this->servicePhoto3 = $servicePhoto3;
}
function   setServicePhoto4($servicePhoto4){
   $this->servicePhoto4 = $servicePhoto4;
}
function   setServicePhoto5($servicePhoto5){
   $this->servicePhoto5 = $servicePhoto5;
}
function   setGear1($gear1){
   $this->gear1 = $gear1;
}
function   setGear2($gear2){
   $this->gear2 = $gear2;
}
function   setGear3($gear3){
   $this->gear3 = $gear3;
}
function   setGear4($gear4){
   $this->gear4 = $gear4;
}
function   setGear5($gear5){
   $this->gear5 = $gear5;
}
function   setGearPhoto1($gearPhoto1){
   $this->gearPhoto1 = $gearPhoto1;
}
function   setGearPhoto2($gearPhoto2){
   $this->gearPhoto2 = $gearPhoto2;
}
function   setGearPhoto3($gearPhoto3){
   $this->gearPhoto3 = $gearPhoto3;
}
function   setGearPhoto4($gearPhoto4){
   $this->gearPhoto4 = $gearPhoto4;
}
function   setGearPhoto5($gearPhoto5){
   $this->gearPhoto5 = $gearPhoto5;
}
//connect to database
function dbconnect()   {
require"../../dbConnect.php";
return $dbMain;
}
//-------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------
function loadWebsiteMembershipOptions()  {
   // echo "test";
//echo "test1";
$dbMain = $this->dbconnect();
//echo "test";
   $stmt = $dbMain ->prepare("SELECT number_memberships, membership1, membership2, membership3, membership4, membership5, membership6, mem1, mem2, mem3, mem4, mem5, mem6, descrip1, descrip2, descrip3, descrip4, descrip5, descrip6, box_color, text_color, box_color_promo, text_color_promo, service1, service2, service3, service4, service5, servicePhoto1, servicePhoto2, servicePhoto3, servicePhoto4, servicePhoto5, gear1, gear2, gear3, gear4, gear5, gearPhoto1, gearPhoto2, gearPhoto3, gearPhoto4, gearPhoto5 FROM website_membership_options WHERE web_key = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($this->numberMemberships, $this->membership1, $this->membership2, $this->membership3, $this->membership4, $this->membership5, $this->membership6, $this->mem1, $this->mem2, $this->mem3, $this->mem4, $this->mem5, $this->mem6, $this->descrip1, $this->descrip2, $this->descrip3, $this->descrip4, $this->descrip5, $this->descrip6, $this->boxColor, $this->textColor, $this->boxColorPromo, $this->textColorPromo, $this->service1, $this->service2, $this->service3, $this->service4, $this->service5 , $this->servicePhoto1, $this->servicePhoto2, $this->servicePhoto3, $this->servicePhoto4, $this->servicePhoto5,  $this->gear1,  $this->gear2,  $this->gear3,  $this->gear4,  $this->gear5,  $this->gearPhoto1,  $this->gearPhoto2,  $this->gearPhoto3,  $this->gearPhoto4,  $this->gearPhoto5);
   $stmt->fetch();
$stmt->close();
//echo "test2";

}
//----------------------------------------------------------------------------------
function updateWebsiteMembershipOptions() {
//echo"$this->currentBonusSetup, $this->currentPaymentSetup, $this->percentage, $this->tier1, $this->hourlyBump1, $this->tier2, $this->hourlyBump2, $this->tier3, $this->hourlyBump3, $this->flat1Hr, $this->flatHalfHour";
//echo"t3";
$dbMain = $this->dbconnect();
$sql = "UPDATE website_membership_options SET number_memberships=?, membership1=?, membership2=?, membership3=?, membership4=?, membership5=?, membership6=?, mem1=?, mem2=?, mem3=?, mem4=?, mem5=?, mem6=?, descrip1=?, descrip2=?, descrip3=?, descrip4=?, descrip5=?, descrip6=?, box_color=?, text_color=?, box_color_promo=?, text_color_promo=?, service1=?, service2=?, service3=?, service4=?, service5=?, servicePhoto1=?, servicePhoto2=?, servicePhoto3=?, servicePhoto4=?, servicePhoto5=? , gear1=?, gear2=?, gear3=?, gear4=?, gear5=?, gearPhoto1=?, gearPhoto2=?, gearPhoto3=?, gearPhoto4=?, gearPhoto5=? WHERE web_key = '1'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('sssssssssssssssssssssssssssssssssssssssssss', $this->numberMemberships, $this->membership1, $this->membership2, $this->membership3, $this->membership4, $this->membership5, $this->membership6, $this->mem1, $this->mem2, $this->mem3, $this->mem4, $this->mem5, $this->mem6,$this->descrip1, $this->descrip2, $this->descrip3, $this->descrip4, $this->descrip5, $this->descrip6, $this->boxColor, $this->textColor, $this->boxColorPromo, $this->textColorPromo, $this->service1, $this->service2, $this->service3, $this->service4, $this->service5 , $this->servicePhoto1, $this->servicePhoto2, $this->servicePhoto3, $this->servicePhoto4, $this->servicePhoto5,  $this->gear1,  $this->gear2,  $this->gear3,  $this->gear4,  $this->gear5,  $this->gearPhoto1,  $this->gearPhoto2,  $this->gearPhoto3,  $this->gearPhoto4,  $this->gearPhoto5);
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

function getNumberMemberships(){
   return($this->numberMemberships);
}
function getMembership1(){
   return($this->membership1);
}
function getMembership2(){
   return($this->membership2);
}
function getMembership3(){
   return($this->membership3);
}
function getMembership4(){
   return($this->membership4);
}
function getMembership5(){
   return($this->membership5);
}
function getMembership6(){
   return($this->membership6);
}
function getMem1(){
   return($this->mem1);
}
function getMem2(){
   return($this->mem2);
}
function getMem3(){
   return($this->mem3);
}
function getMem4(){
   return($this->mem4);
}
function getMem5(){
   return($this->mem5);
}
function getMem6(){
   return($this->mem6);
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
function  getBoxColorPromo(){
   return($this->boxColorPromo);
}
function  getTextColorPromo(){
   return($this->textColorPromo);
}
function   getService1(){
   return($this->service1);
}
function   getService2(){
   return($this->service2);
}
function   getService3(){
   return($this->service3);
}
function   getService4(){
   return($this->service4);
}
function   getService5(){
   return($this->service5);
}
function   getServicePhoto1(){
   return($this->servicePhoto1);
}
function   getServicePhoto2(){
   return($this->servicePhoto2);
}
function   getServicePhoto3(){
   return($this->servicePhoto3);
}
function   getServicePhoto4(){
   return($this->servicePhoto4);
}
function   getServicePhoto5(){
   return($this->servicePhoto5);
}
function   getGear1(){
   return($this->gear1);
}
function   getGear2(){
   return($this->gear2);
}
function   getGear3(){
   return($this->gear3);
}
function   getGear4(){
   return($this->gear4);
}
function   getGear5(){
   return($this->gear5);
}
function   getGearPhoto1(){
   return($this->gearPhoto1);
}
function   getGearPhoto2(){
   return($this->gearPhoto2);
}
function   getGearPhoto3(){
   return($this->gearPhoto3);
}
function   getGearPhoto4(){
   return($this->gearPhoto4);
}
function   getGearPhoto5(){
   return($this->gearPhoto5);
}
}


?>