<?php
//echo"fubar0";
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];

$ownersLetter = $_REQUEST['ownersLetter'];
$clubNews = $_REQUEST['clubNews'];
$specialOffer = $_REQUEST['specialOffer'];
$qna = $_REQUEST['qna'];
$testimonials = $_REQUEST['testimonials'];
$upcomingEvents = $_REQUEST['upcomingEvents'];
$partner =  $_REQUEST['partner'];
$misc1T = $_REQUEST['misc1T'];
$misc1C = $_REQUEST['misc1C'];
$misc2T = $_REQUEST['misc2T'];
$misc2C = $_REQUEST['misc2C'];

//echo "p $misc2C p $photo2";
//exit;
include "websiteNewsSql.php";


//if form is submitted save to database
if ($marker == 1) {

   $updateNews = new websiteNewsSql();
   $updateNews ->setOwnersLetter($ownersLetter);
   $updateNews ->setClubNews($clubNews);
   $updateNews ->setSpecialOffer($specialOffer);
   $updateNews ->setQNA($qna);
   $updateNews ->setTestimonial($testimonials);
   $updateNews ->setUpcomingEvents($upcomingEvents);
   $updateNews ->setPartner($partner);
   $updateNews ->setMisc1T($misc1T);
   $updateNews ->setMisc1C($misc1C);
   $updateNews ->setMisc2T($misc2T);
   $updateNews ->setMisc2C($misc2C);
   $confirmation = $updateNews -> updateWebsiteNewsOptions();
   //echo"fubar222";
  
}

$loadNews = new websiteNewsSql();
$loadNews -> loadWebsiteNewsOptions();


$ownersLetter =  $loadNews ->getOwnersLetter();
$clubNews = $loadNews ->getClubNews();
$specialOffer = $loadNews ->getSpecialOffer();
$qna  = $loadNews ->getQNA();
$testimonials  = $loadNews ->getTestimonial();
$upcomingEvents = $loadNews -> getUpcomingEvents();
$partner = $loadNews -> getPartner();
$misc1T = $loadNews -> getMisc1T();
$misc1C = $loadNews -> getMisc1C();
$misc2T = $loadNews -> getMisc2T();
$misc2C = $loadNews -> getMisc2C();

//sets up the varibles for the form template
$submit_link = 'editWebsiteNews.php';
$submit_name = 'update';
$submit_title = "Update Website News Options";
$page_title  = 'Website News Options';

//echo "hshshsh";
include "webTemplates/websiteNewsTemplate.php";

?>