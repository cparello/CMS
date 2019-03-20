<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  posPageSql{


function setPos1($pos1){
   $this->pos1 = $pos1;
}
function setPos2($pos2){
   $this->pos2 = $pos2;
}
function setPos3($pos3){
   $this->pos3 = $pos3;
}
function setPos4($pos4){
   $this->pos4 = $pos4;
}
function setPos5($pos5){
   $this->pos5 = $pos5;
}
function setPos6($pos6){
   $this->pos6 = $pos6;
}
function setPos7($pos7){
   $this->pos7 = $pos7;
}
function setPos8($pos8){
   $this->pos8 = $pos8;
}
function setPos9($pos9){
   $this->pos9 = $pos9;
}
function setPos10($pos10){
   $this->pos10 = $pos10;
}

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//-------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------
function loadPosOptions()  {
//echo "test1";
//echo "test2";
$dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT pos1, pos2, pos3, pos4, pos5, pos6, pos7, pos8, pos9, pos10 FROM pos_setup_options WHERE pos_key = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($this->pos1, $this->pos2, $this->pos3, $this->pos4, $this->pos5, $this->pos6, $this->pos7, $this->pos8, $this->pos9, $this->pos10);
   $stmt->fetch();
$stmt->close();


}
//----------------------------------------------------------------------------------
function updatePosOptions() {
//echo"$this->currentBonusSetup, $this->currentPaymentSetup, $this->percentage, $this->tier1, $this->hourlyBump1, $this->tier2, $this->hourlyBump2, $this->tier3, $this->hourlyBump3, $this->flat1Hr, $this->flatHalfHour";
//echo"t3";
$dbMain = $this->dbconnect();
$sql = "UPDATE pos_setup_options SET pos1=?, pos2=?, pos3=?, pos4=?, pos5=?, pos6=?, pos7=?, pos8=?, pos9=?, pos10=? WHERE pos_key = '1'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('ssssssssss', $this->pos1, $this->pos2, $this->pos3, $this->pos4, $this->pos5, $this->pos6, $this->pos7, $this->pos8, $this->pos9, $this->pos10);
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

function getPos1(){
   return($this->pos1);
}
function getPos2(){
   return($this->pos2);
}
function getPos3(){
   return($this->pos3);
}
function getPos4(){
   return($this->pos4);
}
function getPos5(){
   return($this->pos5);
}
function getPos6(){
   return($this->pos6);
}
function getPos7(){
   return($this->pos7);
}
function getPos8(){
   return($this->pos8);
}
function getPos9(){
   return($this->pos9);
}
function getPos10(){
   return($this->pos10);
}
}


?>