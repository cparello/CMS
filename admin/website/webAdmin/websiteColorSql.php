<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  websiteColorSql{
    
function  setButtonColor($buttonColor){
   $this->buttonColor = $buttonColor;
}
function setButtonTextColor($buttonTextColor){
   $this->buttonTextColor = $buttonTextColor;
}
function setButtonBorderColor($buttonBorderColor){
   $this->buttonBorderColor = $buttonBorderColor;
}
function setButtonHoverColor($buttonHoverColor){
   $this->buttonHoverColor = $buttonHoverColor;
}
function setButtonFocusColor($buttonFocusColor){
   $this->buttonFocusColor = $buttonFocusColor;
}
function setBannerTextColor($bannerTextColor){
   $this->bannerTextColor = $bannerTextColor;
}
function setBannerBackColor($bannerBackColor){
   $this->bannerBackColor = $bannerBackColor;
}
function setButColor($butColor){
   $this->butColor = $butColor;
}
function setTopLinkBarText($topLinkBarText){
   $this->topLinkBarText = $topLinkBarText;
}
function setTopLinkBar($topLinkBar){
   $this->topLinkBar = $topLinkBar;
}
function setMiddleButtons($middleButtons){
    $this->middleButtons = $middleButtons;
}
function setBottomBar($bottomBar){
    $this->bottomBar = $bottomBar;
}
function setAnnouncmentOneHead($announcmentOneHead){
   $this->announcmentOneHead = $announcmentOneHead;
}
function setAnnouncmentOneCopy($announcmentOneCopy){
   $this->announcmentOneCopy = $announcmentOneCopy;
}
function setAnnouncmentTwoHead($announcmentTwoHead){
   $this->announcmentTwoHead = $announcmentTwoHead;
}
function setAnnouncmentTwoCopy($announcmentTwoCopy){
   $this->announcmentTwoCopy = $announcmentTwoCopy;
}
function setAnnouncmentThreeHead($announcmentThreeHead){
   $this->announcmentThreeHead = $announcmentThreeHead;
}
function setAnnouncmentThreeCopy($announcmentThreeCopy){
   $this->announcmentThreeCopy = $announcmentThreeCopy;
}
function setAnnouncmentFourHead($announcmentFourHead){
   $this->announcmentFourHead = $announcmentFourHead;
}
function setAnnouncmentFourCopy($announcmentFourCopy){
   $this->announcmentFourCopy = $announcmentFourCopy;
}
function setClubInfoOneHead($clubInfoOneHead){
   $this->clubInfoOneHead = $clubInfoOneHead;
}
function setClubInfoOneCopy($clubInfoOneCopy){
   $this->clubInfoOneCopy = $clubInfoOneCopy;
}
function setClubInfoTwoHead($clubInfoTwoHead){
   $this->clubInfoTwoHead = $clubInfoTwoHead;
}
function setClubInfoTwoCopy($clubInfoTwoCopy){
   $this->clubInfoTwoCopy = $clubInfoTwoCopy;
}
function setFaceBookBusinessName($faceBookBusinessName){
   $this->faceBookBusinessName = $faceBookBusinessName;
}
function setTwitterHandle($twitterHandle){
   $this->twitterHandle = $twitterHandle;
}
function setYoutubeChannel($youtubeChannel){
   $this->youtubeChannel = $youtubeChannel;
}
function setEmail($email){
   $this->email = $email;
}  
function setPhoto1($photo1){
   $this->photo1 = $photo1;
}   
function setPhoto2($photo2){
   $this->photo2 = $photo2;
}      
function setMidButBar($midButBar){
   $this->midButBar = $midButBar;
}      
function setAnnColor($annColor){
   $this->annColor = $annColor;
}    
function setAnnouncementFont($announcementFont){
   $this->announcementFont = $announcementFont;
}    
function setAnnouncementFontColor($announcementFontColor){
   $this->announcementFontColor = $announcementFontColor;
}    
function setClubInfoFont($clubInfoFont){
   $this->clubInfoFont = $clubInfoFont;
}    
function setClubInfoFontColor($clubInfoFontColor){
   $this->clubInfoFontColor = $clubInfoFontColor;
}    
function setBusinessFont($businessFont){
   $this->businessFont = $businessFont;
}    
function setBusinessFontColor($businessFontColor){
   $this->businessFontColor = $businessFontColor;
}    

function setYelpPage($yelpPage){
   $this->yelpPage = $yelpPage;
}    
function setGooglePlus($googlePlus){
   $this->googlePlus = $googlePlus;
}    
function setInstagram($instagram){
   $this->instagram = $instagram;
}    
function setLinkedIn($linkedIn){
   $this->linkedIn = $linkedIn;
}    
function setPinterest($pinterest){
   $this->pinterest = $pinterest;
}    


//connect to database
function dbconnect()   {
require"../../dbConnect.php";
return $dbMain;
}
//-------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------
function loadWebsiteColorOptions()  {
//echo "test1";
$dbMain = $this->dbconnect();

   $stmt = $dbMain ->prepare("SELECT banner_text_color, top_link_bar_text, banner_back_color, top_link_bar, ann_color, mid_but_bar, middle_buttons_color, bottom_bar_color, announcment_1_headline, announcment_1_copy, announcment_2_headline, announcment_2_copy, announcment_3_headline, announcment_3_copy,announcment_4_headline, announcment_4_copy, club_info_headline1, club_info_copy1, club_info_headline2, club_info_copy2, facebook_business_page_name, twitter_handle, youtube_chanel_name, email, photo1, photo2, announcement_font, announcement_font_color, club_info_font, club_info_font_color, business_font, business_font_color, but_color, yelp_page, google_plus, instagram, linked_in, pinterest, buttonColor, buttonTextColor, buttonBorderColor, buttonHoverColor, buttonFocusColor FROM website_colors WHERE web_key = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($this->bannerTextColor, $this->topLinkBarText, $this->bannerBackColor, $this->topLinkBar, $this->annColor, $this->midButBar, $this->middleButtons, $this->bottomBar, $this->announcmentOneHead, $this->announcmentOneCopy, $this->announcmentTwoHead ,$this->announcmentTwoCopy ,$this->announcmentThreeHead, $this->announcmentThreeCopy, $this->announcmentFourHead, $this->announcmentFourCopy, $this->clubInfoOneHead, $this->clubInfoOneCopy, $this->clubInfoTwoHead, $this->clubInfoTwoCopy, $this->faceBookBusinessName, $this->twitterHandle, $this->youtubeChannel, $this->email , $this->photo1, $this->photo2, $this->announcementFont, $this->announcementFontColor, $this->clubInfoFont, $this->clubInfoFontColor, $this->businessFont, $this->businessFontColor, $this->butColor, $this->yelpPage , $this->googlePlus, $this->instagram, $this->linkedIn, $this->pinterest, $this->buttonColor, $this->buttonTextColor, $this->buttonBorderColor, $this->buttonHoverColor, $this->buttonFocusColor);
   $stmt->fetch();

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
$stmt->close();
//echo "test2";

}
//----------------------------------------------------------------------------------
function updateWebsiteColorOptions() {
//echo"$this->currentBonusSetup, $this->currentPaymentSetup, $this->percentage, $this->tier1, $this->hourlyBump1, $this->tier2, $this->hourlyBump2, $this->tier3, $this->hourlyBump3, $this->flat1Hr, $this->flatHalfHour";
//echo"t3";
$dbMain = $this->dbconnect();
$sql = "UPDATE website_colors SET banner_text_color = ?, top_link_bar_text = ?,banner_back_color = ?, top_link_bar = ?, ann_color = ?, mid_but_bar = ?, middle_buttons_color = ?, bottom_bar_color = ?, announcment_1_headline = ?, announcment_1_copy = ?, announcment_2_headline = ?, announcment_2_copy = ?, announcment_3_headline = ?, announcment_3_copy = ?, announcment_4_headline = ? , announcment_4_copy = ?, club_info_headline1 = ?, club_info_copy1 = ?, club_info_headline2 = ?, club_info_copy2 = ?, facebook_business_page_name = ?, twitter_handle = ?, youtube_chanel_name = ?, email = ?, photo1 = ?, photo2 = ?,  announcement_font = ?, announcement_font_color = ?, club_info_font = ?, club_info_font_color = ?, business_font = ?, business_font_color = ?, but_color = ?, yelp_page = ?, google_plus = ?, instagram = ?, linked_in = ?, pinterest = ?, buttonColor = ?, buttonTextColor = ?, buttonBorderColor = ?, buttonHoverColor = ?, buttonFocusColor  = ? WHERE web_key = '1'";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('sssssssssssssssssssssssssssssssssssssssssss', $this->bannerTextColor, $this->topLinkBarText, $this->bannerBackColor, $this->topLinkBar, $this->annColor, $this->midButBar, $this->middleButtons, $this->bottomBar, $this->announcmentOneHead, $this->announcmentOneCopy, $this->announcmentTwoHead ,$this->announcmentTwoCopy ,$this->announcmentThreeHead, $this->announcmentThreeCopy, $this->announcmentFourHead, $this->announcmentFourCopy, $this->clubInfoOneHead, $this->clubInfoOneCopy, $this->clubInfoTwoHead, $this->clubInfoTwoCopy, $this->faceBookBusinessName, $this->twitterHandle, $this->youtubeChannel, $this->email, $this->photo1, $this->photo2,  $this->announcementFont, $this->announcementFontColor, $this->clubInfoFont, $this->clubInfoFontColor, $this->businessFont, $this->businessFontColor, $this->butColor, $this->yelpPage , $this->googlePlus, $this->instagram, $this->linkedIn, $this->pinterest, $this->buttonColor, $this->buttonTextColor, $this->buttonBorderColor, $this->buttonHoverColor, $this->buttonFocusColor);
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


function getTopLinkBar(){
    return($this->topLinkBar);
}
function getTopLinkBarText(){
    return($this->topLinkBarText);
}
function getMiddleButtons(){
    return($this->middleButtons);
}
function getBottomBar(){
    return($this->bottomBar);
}
function getAnnouncmentOneHead(){
    return($this->announcmentOneHead);
}
function  getAnnouncmentOneCopy(){
    return($this->announcmentOneCopy);
}
function  getAnnouncmentTwoHead(){
    return($this->announcmentTwoHead);
}
function  getAnnouncmentTwoCopy(){
    return($this->announcmentTwoCopy);
}
function getAnnouncmentThreeHead(){
    return($this->announcmentThreeHead);
}
function  getAnnouncmentThreeCopy(){
    return($this->announcmentThreeCopy);
}
function  getAnnouncmentFourCopy(){
    return($this->announcmentFourCopy);
}
function  getAnnouncmentFourHead(){
    return($this->announcmentFourHead);
}

function  getClubInfoOneHead(){
    return($this->clubInfoOneHead);
}
function  getClubInfoOneCopy(){
    return($this->clubInfoOneCopy);
}
function  getClubInfoTwoHead(){
    return($this->clubInfoTwoHead);
}
function  getClubInfoTwoCopy(){
    return($this->clubInfoTwoCopy);
}
function  getFaceBookBusinessName(){
    return($this->faceBookBusinessName);
}
function  getTwitterHandle(){
    return($this->twitterHandle);
}
function  getYoutubeChannel(){
    return($this->youtubeChannel);
}
function  getEmail(){
    return($this->email);
}
function  getPhoto1(){
    return($this->photo1);
}
function  getPhoto2(){
    return($this->photo2);
}
function  getMidButBar(){
    return($this->midButBar);
}
function  getAnnColor(){
    return($this->annColor);
}
function   getAnnouncementFont(){
    return($this->announcementFont);
}
function   getAnnouncementFontColor(){
    return($this->announcementFontColor);
}
function   getClubInfoFont(){
    return($this->clubInfoFont);
}
function   getClubInfoFontColor(){
    return($this->clubInfoFontColor);
}
function   getBusinessFont(){
    return($this->businessFont);
}
function   getBusinessFontColor(){
    return($this->businessFontColor);
}
function   getButColor(){
    return($this->butColor);
}
function   getBannerBackColor(){
    return($this->bannerBackColor);
}
function   getBannerTextColor(){
    return($this->bannerTextColor);
}
function   getYelpPage(){
    return($this->yelpPage);
}
function   getGooglePlus(){
    return($this->googlePlus);
}
function   getInstagram(){
    return($this->instagram);
}
function   getLinkedIn(){
    return($this->linkedIn);
}
function   getPinterest(){
    return($this->pinterest);
}
function   getButtonColor(){
    return($this->buttonColor);
}
function   getButtonTextColor(){
    return($this->buttonTextColor);
}
function   getButtonBorderColor(){
    return($this->buttonBorderColor);
}
function   getButtonHoverColor(){
    return($this->buttonHoverColor);
}
function   getButtonFocusColor(){
    return($this->buttonFocusColor);
}
}


?>