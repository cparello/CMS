<?php
//echo"fubar0";
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];
$topLinkBar = $_REQUEST['topLinkBar'];
$topLinkBarText = $_REQUEST['topLinkBarText'];

$middleButtons = $_REQUEST['middleButtons'];
$bottomBar = $_REQUEST['bottomBar'];
$midButBar = $_REQUEST['midButBar'];
$annColor = $_REQUEST['annColor'];
$announcmentOneHead = $_REQUEST['announcmentOneHead'];
$announcmentOneCopy = $_REQUEST['announcmentOneCopy'];
$announcmentTwoHead = $_REQUEST['announcmentTwoHead'];
$announcmentTwoCopy = $_REQUEST['announcmentTwoCopy'];
$announcmentThreeHead = $_REQUEST['announcmentThreeHead'];
$announcmentThreeCopy = $_REQUEST['announcmentThreeCopy'];
$announcmentFourHead = $_REQUEST['announcmentFourHead'];
$announcmentFourCopy = $_REQUEST['announcmentFourCopy'];
$clubInfoOneHead = $_REQUEST['clubInfoOneHead'];
$clubInfoOneCopy = $_REQUEST['clubInfoOneCopy'];
$clubInfoTwoHead = $_REQUEST['clubInfoTwoHead'];
$clubInfoTwoCopy = $_REQUEST['clubInfoTwoCopy'];
$faceBookBusinessName = $_REQUEST['faceBookBusinessName'];
$twitterHandle = $_REQUEST['twitterHandle'];
$youtubeChannel = $_REQUEST['youtubeChannel'];
$email = $_REQUEST['email'];
$photo1 = $_REQUEST['photo1'];
$photo2 = $_REQUEST['photo2'];
$announcementFont = $_REQUEST['announcementFont'];
$announcementFontColor = $_REQUEST['announcementFontColor'];
$clubInfoFont = $_REQUEST['clubInfoFont'];
$clubInfoFontColor = $_REQUEST['clubInfoFontColor'];
$businessFont = $_REQUEST['businessFont'];
$businessFontColor = $_REQUEST['businessFontColor'];
$butColor = $_REQUEST['butColor'];
$bannerBackColor = $_REQUEST['bannerBackColor'];
$bannerTextColor = $_REQUEST['bannerTextColor'];
$yelpPage = $_REQUEST['yelpPage'];
$googlePlus = $_REQUEST['googlePlus'];
$instagram = $_REQUEST['instagram'];
$linkedIn = $_REQUEST['linkedIn'];
$pinterest = $_REQUEST['pinterest'];

$buttonColor =  $_REQUEST['buttonColor'];
$buttonTextColor =  $_REQUEST['buttonTextColor'];
$buttonBorderColor =  $_REQUEST['buttonBorderColor'];
$buttonHoverColor =  $_REQUEST['buttonHoverColor'];
$buttonFocusColor =  $_REQUEST['buttonFocusColor'];
//echo "p $photo1 p $photo2";
//exit;
include "websiteColorSql.php";


//if form is submitted save to database
if ($marker == 1) {

   $updateCycles = new websiteColorSql();
   $updateCycles ->setButtonColor($buttonColor);
   $updateCycles ->setButtonTextColor($buttonTextColor);
   $updateCycles ->setButtonBorderColor($buttonBorderColor);
   $updateCycles ->setButtonHoverColor($buttonHoverColor);
   $updateCycles ->setButtonFocusColor($buttonFocusColor);
   $updateCycles ->setYelpPage($yelpPage);
   $updateCycles ->setGooglePlus($googlePlus);
   $updateCycles ->setInstagram($instagram);
   $updateCycles ->setLinkedIn($linkedIn);
   $updateCycles ->setPinterest($pinterest);
   $updateCycles ->setBannerBackColor($bannerBackColor);
   $updateCycles ->setBannerTextColor($bannerTextColor);
   $updateCycles ->setButColor($butColor);
   $updateCycles ->setAnnouncementFont($announcementFont);
   $updateCycles ->setAnnouncementFontColor($announcementFontColor);
   $updateCycles ->setClubInfoFont($clubInfoFont);
   $updateCycles ->setClubInfoFontColor($clubInfoFontColor);
   $updateCycles ->setBusinessFont($businessFont);
   $updateCycles ->setBusinessFontColor($businessFontColor);
   $updateCycles ->setTopLinkBar($topLinkBar);
   $updateCycles ->setTopLinkBarText($topLinkBarText);
   $updateCycles ->setMiddleButtons($middleButtons);
   $updateCycles ->setBottomBar($bottomBar);
   $updateCycles ->setMidButBar($midButBar);
   $updateCycles ->setAnnColor($annColor);
   $updateCycles ->setAnnouncmentOneHead($announcmentOneHead);
   $updateCycles ->setAnnouncmentOneCopy($announcmentOneCopy);
   $updateCycles ->setAnnouncmentTwoHead($announcmentTwoHead);
   $updateCycles ->setAnnouncmentTwoCopy($announcmentTwoCopy);
   $updateCycles ->setAnnouncmentThreeHead($announcmentThreeHead);
   $updateCycles ->setAnnouncmentThreeCopy($announcmentThreeCopy);
   $updateCycles ->setAnnouncmentFourHead($announcmentFourHead);
   $updateCycles ->setAnnouncmentFourCopy($announcmentFourCopy);
   $updateCycles ->setClubInfoOneHead($clubInfoOneHead);
   $updateCycles ->setClubInfoOneCopy($clubInfoOneCopy);
   $updateCycles ->setClubInfoTwoHead($clubInfoTwoHead);
   $updateCycles ->setClubInfoTwoCopy($clubInfoTwoCopy);
   $updateCycles ->setFaceBookBusinessName($faceBookBusinessName);
   $updateCycles ->setTwitterHandle($twitterHandle);
   $updateCycles ->setYoutubeChannel($youtubeChannel);
   $updateCycles ->setEmail($email);
   $updateCycles ->setPhoto1($photo1);
   $updateCycles ->setPhoto2($photo2);
   $confirmation = $updateCycles -> updateWebsiteColorOptions();
   //echo"fubar222";
  
}



$loadSalesPay = new websiteColorSql();
//echo"fubar 1";
$loadSalesPay -> loadWebsiteColorOptions();


$buttonColor =  $loadSalesPay ->getButtonColor();
$buttonTextColor = $loadSalesPay ->getButtonTextColor();
$buttonBorderColor = $loadSalesPay ->getButtonBorderColor();
$buttonHoverColor  = $loadSalesPay ->getButtonHoverColor();
$buttonFocusColor  = $loadSalesPay ->getButtonFocusColor();
$bannerBackColor = $loadSalesPay -> getBannerBackColor();
$topLinkBar = $loadSalesPay -> getTopLinkBar();
$bannerTextColor = $loadSalesPay -> getBannerTextColor();
$topLinkBarText = $loadSalesPay -> getTopLinkBarText();
$middleButtons = $loadSalesPay -> getMiddleButtons();
$bottomBar = $loadSalesPay -> getBottomBar();
$midButBar = $loadSalesPay -> getMidButBar();
$announcmentOneHead = $loadSalesPay -> getAnnouncmentOneHead();
$announcmentOneCopy = $loadSalesPay -> getAnnouncmentOneCopy();
$announcmentTwoHead = $loadSalesPay -> getAnnouncmentTwoHead();
$announcmentTwoCopy = $loadSalesPay -> getAnnouncmentTwoCopy();
$announcmentThreeHead = $loadSalesPay -> getAnnouncmentThreeHead();
$announcmentThreeCopy = $loadSalesPay -> getAnnouncmentThreeCopy();
$announcmentFourHead = $loadSalesPay -> getAnnouncmentFourHead();
$announcmentFourCopy = $loadSalesPay -> getAnnouncmentFourCopy();
$clubInfoOneHead = $loadSalesPay -> getClubInfoOneHead();
$clubInfoOneCopy = $loadSalesPay -> getClubInfoOneCopy();
$clubInfoTwoHead = $loadSalesPay -> getClubInfoTwoHead();
$clubInfoTwoCopy = $loadSalesPay -> getClubInfoTwoCopy();
$faceBookBusinessName = $loadSalesPay -> getFaceBookBusinessName();
$twitterHandle = $loadSalesPay -> getTwitterHandle();
$youtubeChannel = $loadSalesPay -> getYoutubeChannel();
$email = $loadSalesPay -> getEmail();
$photo1 = $loadSalesPay -> getPhoto1();
$photo2 = $loadSalesPay -> getPhoto2();
$annColor = $loadSalesPay -> getAnnColor();
$announcementFont = $loadSalesPay ->  getAnnouncementFont();
$announcementFontColor = $loadSalesPay -> getAnnouncementFontColor();
$clubInfoFont = $loadSalesPay -> getClubInfoFont();
$clubInfoFontColor = $loadSalesPay -> getClubInfoFontColor();
$businessFont = $loadSalesPay -> getBusinessFont();
$businessFontColor = $loadSalesPay -> getBusinessFontColor();
$butColor = $loadSalesPay -> getButColor();

$yelpPage = $loadSalesPay -> getYelpPage();
$googlePlus =  $loadSalesPay -> getGooglePlus();
$instagram =  $loadSalesPay -> getInstagram();
$linkedIn =  $loadSalesPay -> getLinkedIn();
$pinterest = $loadSalesPay -> getPinterest();



switch($middleButtons){
    case 'Black':
        $middleButtonsText = "Black";
    break;
    case 'Green':
        $middleButtonsText = "Green";
    break;
    case 'Red':
        $middleButtonsText = "Red";
    break;
    case 'Blue':
        $middleButtonsText = "Blue";
    break;
    case 'Gray':
        $middleButtonsText = "Gray";
    break;
    case 'Brown':
        $middleButtonsText = "Brown";
    break;
    case 'Silver':
        $middleButtonsText = "Silver";
    break;
    case 'Purple':
        $middleButtonsText = "Purple";
    break;
    case 'Yellow':
        $middleButtonsText = "Yellow";
    break;
    case 'Orange':
        $middleButtonsText = "Orange";
    break;
    case 'Pink':
        $middleButtonsText = "Pink";
    break;
}



$dir = "pictures/homePageClubPhotos/";

$root = scandir($dir, 1);
    foreach($root as $value) {           
        if($value != "") {
            $dropOptions1 .= "<option value=\"$value\">$value</option>\n";
                           }
                 }
                 
                 
$dir = "pictures/homePageClubPhotos/";

$root = scandir($dir, 1);
    foreach($root as $value) {           
        if($value != "") {
            $dropOptions2 .= "<option value=\"$value\">$value</option>\n";
                           }
                 }


  
 



//sets up the varibles for the form template
$submit_link = 'editWebsiteColors.php';
$submit_name = 'update';
$submit_title = "Update Website Setup Options";
$page_title  = 'Website Setup Options';
$javaScript1 = "<script type=\"text/javascript\" src=\"webScripts/websiteColors.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"webScripts/helpTxtWebsiteColors.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"webScripts/helpPops.js\"></script>";



/*include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(26);
$info_text = $getText -> createTextInfo();

include "../templates/infoTemplate2.php";*/

//echo"fubar 2";
include "webTemplates/websiteColorTemplate.php";

?>