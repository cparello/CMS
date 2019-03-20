<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  websiteNewsSql{
    
function  setOwnersLetter($ownersLetter){
   $this->ownersLetter = $ownersLetter;
}
function  setClubNews($clubNews){
   $this->clubNews = $clubNews;
}
function  setSpecialOffer($specialOffer){
   $this->specialOffer = $specialOffer;
}
function  setQNA($qna){
   $this->qna = $qna;
}
function  setTestimonial($testimonials){
   $this->testimonials = $testimonials;
}
function  setUpcomingEvents($upcomingEvents){
   $this->upcomingEvents = $upcomingEvents;
}
function  setPartner($partner){
    $this->partner = $partner;
}
function  setMisc1T($misc1T){
   $this->misc1T = $misc1T;
}
function  setMisc1C($misc1C){
   $this->misc1C = $misc1C;
}
function  setMisc2T($misc2T){
   $this->misc2T = $misc2T;
}
function  setMisc2C($misc2C){
   $this->misc2C = $misc2C;
}

//connect to database
function dbconnect()   {
require"../../dbConnect.php";
return $dbMain;
}
//-------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------
function loadWebsiteNewsOptions()  {
//echo "test1";
$dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT owners_letter, club_news, special_offer, qna, testimonials, upcoming_events, misc1T, misc1C, misc2T, misc2C, partner FROM website_newsletter WHERE web_key = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($this->ownersLetter, $this->clubNews, $this->specialOffer, $this->qna, $this->testimonials, $this->upcomingEvents, $this->misc1T, $this->misc1C, $this->misc2T, $this->misc2C, $this->partner);
   $stmt->fetch();

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
$stmt->close();
//echo "test2";

}
//----------------------------------------------------------------------------------
function updateWebsiteNewsOptions() {
//echo"$this->currentBonusSetup, $this->currentPaymentSetup, $this->percentage, $this->tier1, $this->hourlyBump1, $this->tier2, $this->hourlyBump2, $this->tier3, $this->hourlyBump3, $this->flat1Hr, $this->flatHalfHour";
//echo"t3";
$dbMain = $this->dbconnect();
$sql = "UPDATE website_newsletter SET owners_letter = ?, club_news = ?, special_offer = ?, qna = ?, testimonials = ?, upcoming_events = ?, misc1T = ?, misc1C = ?, misc2T = ?, misc2C = ?, partner = ? WHERE web_key = '1'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('sssssssssss', $this->ownersLetter, $this->clubNews, $this->specialOffer, $this->qna, $this->testimonials, $this->upcomingEvents, $this->misc1T, $this->misc1C, $this->misc2T, $this->misc2C, $this->partner);
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
function  getOwnersLetter(){
   return($this->ownersLetter);
}
function  getClubNews(){
   return($this->clubNews);
}
function  getSpecialOffer(){
   return($this->specialOffer);
}
function  getQNA(){
   return($this->qna);
}
function  getTestimonial(){
   return($this->testimonials);
}
function  getUpcomingEvents(){
   return($this->upcomingEvents);
}
function  getPartner($partner){
   return($this->partner);
}
function  getMisc1T($misc1T){
   return($this->misc1T);
}
function  getMisc1C($misc1C){
   return($this->misc1C);
}
function  getMisc2T($misc2T){
   return($this->misc2T);
}
function  getMisc2C($misc2C){
   return($this->misc2C);
}
}


?>