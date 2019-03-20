<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  websiteLocationsSql{


function setLongitude($longitude){
   $this->longitude = $longitude;
}
function setLattitude($lattitude){
   $this->lattitude = $lattitude;
}
function setZip($zip){
   $this->zip = $zip;
}
function setAmenities1($ammenities1){
   $this->ammenities1 = $ammenities1;
}
function setAmenities2($ammenities2){
   $this->ammenities2 = $ammenities2;
}
function setAmenities3($ammenities3){
   $this->ammenities3 = $ammenities3;
}
function setAmenities4($ammenities4){
   $this->ammenities4 = $ammenities4;
}
function setAmenities5($ammenities5){
   $this->ammenities5 = $ammenities5;
}
function setAmenities6($ammenities6){
   $this->ammenities6 = $ammenities6;
}
function setAmenities7($ammenities7){
   $this->ammenities7 = $ammenities7;
}
function setAmenities8($ammenities8){
   $this->ammenities8 = $ammenities8;
}
function setHoursTxt1($hourTxt1){
   $this->hourTxt1 = $hourTxt1;
}
function setHoursTxt2($hourTxt2){
   $this->hourTxt2 = $hourTxt2;
}
function setClubName($clubName){
   $this->clubName = $clubName;
}
function setClubText($clubText){
   $this->clubText = $clubText;
}
function setGuestPassLength($guestPassLength){
   $this->guestPassLength = $guestPassLength;
}
//connect to database
function dbconnect()   {
require"../../dbConnect.php";
return $dbMain;
}
//-------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------
function loadWebsiteLocationOptions()  {
//echo "test1";
$dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT Lattitude, longitude, club_zip, amenities1, amenities2, amenities3, amenities4, amenities5, amenities6, amenities7, amenities8, hoursText1, hoursText2, clubText, guestPassLength FROM website_locations_setup WHERE club_name != ''");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($this->longitude, $this->lattitude, $this->zip, $this->ammenities1, $this->ammenities2, $this->ammenities3, $this->ammenities4, $this->ammenities5, $this->ammenities6, $this->ammenities7, $this->ammenities8, $this->hourTxt1, $this->hourTxt2, $this->clubText, $this->guestPassLength);
   $stmt->fetch();

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
$stmt->close();
//echo "test2";

}
//----------------------------------------------------------------------------------
function updateWebsiteLocationOptions() {
//echo"$this->currentBonusSetup, $this->currentPaymentSetup, $this->percentage, $this->tier1, $this->hourlyBump1, $this->tier2, $this->hourlyBump2, $this->tier3, $this->hourlyBump3, $this->flat1Hr, $this->flatHalfHour";
//echo"t3";
$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT COUNT(*) as count FROM website_locations_setup WHERE club_name = '$this->clubName'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();
//echo "count $count test";
//echo " $this->longitude, $this->lattitude, $this->zip, $this->ammenities1, $this->ammenities2, $this->ammenities3, $this->ammenities4, $this->ammenities5, $this->ammenities6, $this->ammenities7, $this->ammenities8, $this->hourTxt1, $this->hourTxt2, $this->clubText, $this->guestPassLength";
if($count > 0){
    $sql = "UPDATE website_locations_setup SET Lattitude = ?, longitude = ?, club_zip = ?, amenities1 = ?, amenities2 = ?, amenities3 = ?, amenities4 = ?, amenities5 = ?, amenities6 = ?, amenities7 = ?, amenities8 = ?, hoursText1 = ?, hoursText2 = ?, clubText = ?, guestPassLength = ? WHERE club_name LIKE '%$this->clubName%'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('ssssssssssssssi', $this->longitude, $this->lattitude, $this->zip, $this->ammenities1, $this->ammenities2, $this->ammenities3, $this->ammenities4, $this->ammenities5, $this->ammenities6, $this->ammenities7, $this->ammenities8, $this->hourTxt1, $this->hourTxt2, $this->clubText, $this->guestPassLength);
if(!$stmt->execute())  {
    return($this->errorMessage);
    printf("Error: %s.\n", $stmt->error);
	exit;
   }
$stmt->close(); 
}else{
    
    //echo "$this->clubName, $this->lattitude, $this->longitude, $this->ammenities1, $this->ammenities2, $this->ammenities3, $this->ammenities4, $this->ammenities5, $this->ammenities6, $this->ammenities7, $this->ammenities8, $this->hourTxt1, $this->hourTxt2";
    $sql = "INSERT INTO website_locations_setup VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('sssssssssssssssi', $this->clubName, $this->zip, $this->lattitude, $this->longitude, $this->ammenities1, $this->ammenities2, $this->ammenities3, $this->ammenities4, $this->ammenities5, $this->ammenities6, $this->ammenities7, $this->ammenities8, $this->hourTxt1, $this->hourTxt2, $this->clubText , $this->guestPassLength);
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

/*function getHeaderTxt(){
    return($this->headerTxt);
}
function getHeaderTxt2(){
    return($this->headerTxt2);
}
function getBodyTxt(){
    return($this->bodyTxt);
}
function getHeaderSize(){
    return($this->headerSize);
}
function getHeaderColor(){
    return($this->headerColor);
}
function  getBodySize(){
    return($this->bodySize);
}
function  getBodyColor(){
    return($this->bodyColor);
}
function  getPromoLink(){
    return($this->promoLink);
}*/

}


?>