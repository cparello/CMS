<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  websitePromoSql{


function setHeaderTxt($headerTxt){
   $this->headerTxt = $headerTxt;
}
function setHeaderTxt2($headerTxt2){
   $this->headerTxt2 = $headerTxt2;
}
function setHeaderTxt3($headerTxt3){
   $this->headerTxt3 = $headerTxt3;
}
function setHeaderTxtSize($headerTxtSize){
   $this->headerTxtSize = $headerTxtSize;
}
function setHeaderTxt2Size($headerTxt2Size){
   $this->headerTxt2Size = $headerTxt2Size;
}
function setHeaderTxt3Size($headerTxt3Size){
   $this->headerTxt3Size = $headerTxt3Size;
}
function setBoxSize($boxSize){
    $this->boxSize = $boxSize;
}
function setTextTrans($textTrans){
    $this->textTrans = $textTrans;
}
function setHeaderColor($headerColor){
   $this->headerColor = $headerColor;
}
function setBackColor($backColor){
   $this->backColor = $backColor;
}
function setPromoLink($promoLink){
   $this->promoLink = $promoLink;
}
function setPhoto1($photo1){
   $this->photo1 = $photo1;
}
function setPhoto2($photo2){
   $this->photo2 = $photo2;
}
function setPhoto3($photo3){
   $this->photo3 = $photo3;
}
function setPhoto4($photo4){
   $this->photo4 = $photo4;
}
function setPhoto5($photo5){
   $this->photo5 = $photo5;
}
function setOpacity($opacity){
   $this->opacity = $opacity;
}
//connect to database
function dbconnect()   {
require"../../dbConnect.php";
return $dbMain;
}
//-------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------
function loadWebsitePromoOptions()  {
//echo "test1";
$dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT header_txt, header_txt2, header_txt3, header_txtSize, header_txt2Size, header_txt3Size, box_width, text_transform, header_color, back_color, promo_link, photo1, photo2, photo3, photo4, photo5, opacity FROM website_promo WHERE web_key = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($this->headerTxt, $this->headerTxt2, $this->headerTxt3, $this->headerTxtSize, $this->headerTxt2Size, $this->headerTxt3Size, $this->boxSize, $this->textTrans, $this->headerColor, $this->backColor , $this->promoLink, $this->photo1, $this->photo2, $this->photo3, $this->photo4, $this->photo5, $this->opacity);
   $stmt->fetch();

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
$stmt->close();
//echo "test2";

}
//----------------------------------------------------------------------------------
function updateWebsitePromoOptions() {
//echo"$this->currentBonusSetup, $this->currentPaymentSetup, $this->percentage, $this->tier1, $this->hourlyBump1, $this->tier2, $this->hourlyBump2, $this->tier3, $this->hourlyBump3, $this->flat1Hr, $this->flatHalfHour";
//echo"t3";
$dbMain = $this->dbconnect();
$sql = "UPDATE website_promo SET header_txt = ?, header_txt2 = ?, header_txt3 = ?,  header_txtSize = ?, header_txt2Size = ?, header_txt3Size = ?, box_width = ?, text_transform = ?, header_color = ?, back_color = ?, promo_link = ?, photo1 = ?, photo2 = ?, photo3 = ?, photo4 = ?, photo5 = ?, opacity = ? WHERE web_key = '1'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('sssiiiisssssssssd', $this->headerTxt, $this->headerTxt2, $this->headerTxt3, $this->headerTxtSize, $this->headerTxt2Size, $this->headerTxt3Size, $this->boxSize, $this->textTrans, $this->headerColor, $this->backColor, $this->promoLink, $this->photo1, $this->photo2, $this->photo3, $this->photo4, $this->photo5, $this->opacity);
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

function getHeaderTxt(){
    return($this->headerTxt);
}
function getHeaderTxt2(){
    return($this->headerTxt2);
}
function getHeaderTxt3(){
    return($this->headerTxt3);
}
function getHeaderTxtSize(){
    return($this->headerTxtSize);
}
function getHeaderTxt2Size(){
    return($this->headerTxt2Size);
}
function getHeaderTxt3Size(){
    return($this->headerTxt3Size);
}
function getBoxSize(){
    return($this->boxSize);
}
function getTextTrans(){
    return($this->textTrans);
}
function getHeaderColor(){
    return($this->headerColor);
}
function getBackColor(){
    return($this->backColor);
}
function  getPromoLink(){
    return($this->promoLink);
}
function  getPhoto1(){
    return($this->photo1);
}
function  getPhoto2(){
    return($this->photo2);
}
function  getPhoto3(){
    return($this->photo3);
}
function  getPhoto4(){
    return($this->photo4);
}
function  getPhoto5(){
    return($this->photo5);
}
function  getOpacity(){
    return($this->opacity);
}

}


?>