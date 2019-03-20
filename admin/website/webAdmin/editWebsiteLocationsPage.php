<?php
//echo"fubar0";
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];

//$longitude = $_REQUEST['long1'];
//$lattitude = $_REQUEST['lat1'];
//echo "test lo $longitude la $lattitude";
//exit;
include "websiteLocationsSql.php";

//if form is submitted save to database
if ($marker == 1) {
    
    include"../../dbConnect.php";


    $counter = 1;
    $stmt = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id != '' ORDER BY club_name ASC");
               echo($dbMain->error);
               $stmt->execute();      
               $stmt->store_result();      
               $stmt->bind_result($clubName); 
               while($stmt->fetch()){
                $longBuff = "long$counter";
                $latBuff = "lat$counter";
                $zipBuff = "zip$counter";
                $amensBuff1 = "ammensOne$counter";
                $amensBuff2 = "ammensTwo$counter";
                $amensBuff3 = "ammensThree$counter";
                $amensBuff4 = "ammensFour$counter";
                $amensBuff5 = "ammensFive$counter";
                $amensBuff6 = "ammensSix$counter";
                $amensBuff7 = "ammensSeven$counter";
                $amensBuff8 = "ammensEight$counter";
                $hourTxt1Buff = "hourTxtOne$counter";
                $hourTxt2Buff = "hourTxtTwo$counter";
                $clubnameBuff = "clubName$counter";
                $clubTextBuff = "clubText$counter";
                $guestPassBuff = "guestPassLength$counter";
                
                $longitude = $_REQUEST[$longBuff];
                $lattitude = $_REQUEST[$latBuff];
                $zip = $_REQUEST[$zipBuff];
                //echo "test lo $longitude la $lattitude  cn $clubName";
                $ammenities1 = $_REQUEST[$amensBuff1];
                $ammenities2 = $_REQUEST[$amensBuff2];
                $ammenities3 = $_REQUEST[$amensBuff3];
                $ammenities4 = $_REQUEST[$amensBuff4];
                $ammenities5  = $_REQUEST[$amensBuff5];
                $ammenities6 = $_REQUEST[$amensBuff6];
                $ammenities7  = $_REQUEST[$amensBuff7];
                $ammenities8 = $_REQUEST[$amensBuff8];
                $hourTxt1  = $_REQUEST[$hourTxt1Buff];
                $hourTxt2 = $_REQUEST[$hourTxt2Buff];
                //echo "h1 $hourTxt1 h2 $hourTxt2";
                $clubName = $_REQUEST[$clubnameBuff];
                $clubText = $_REQUEST[$clubTextBuff];
                $guestPassLength = $_REQUEST[$guestPassBuff];
                
               $updateCycles = new websiteLocationsSql();
               $updateCycles ->setLongitude($longitude);
               $updateCycles ->setLattitude($lattitude);
               $updateCycles ->setZip($zip);
               $updateCycles ->setAmenities1($ammenities1);
               $updateCycles ->setAmenities2($ammenities2);
               $updateCycles ->setAmenities3($ammenities3);
               $updateCycles ->setAmenities4($ammenities4);
               $updateCycles ->setAmenities5($ammenities5);
               $updateCycles ->setAmenities6($ammenities6);
               $updateCycles ->setAmenities7($ammenities7);
               $updateCycles ->setAmenities8($ammenities8);
               $updateCycles ->setHoursTxt1($hourTxt1);
               $updateCycles ->setHoursTxt2($hourTxt2);
               $updateCycles ->setClubName($clubName);
               $updateCycles ->setClubText($clubText);
               $updateCycles ->setGuestPassLength($guestPassLength);
               $confirmation = $updateCycles -> updateWebsiteLocationOptions();
               //echo"fubar222";
               $counter++;
              }
              
            }


//echo "p tee p ee";
$loadSalesPay = new websiteLocationsSql();
//echo"fubar 1";
$loadSalesPay -> loadWebsiteLocationOptions();


/*$headerTxt = $loadSalesPay -> getHeaderTxt();
$headerTxt2 = $loadSalesPay -> getHeaderTxt2();
$bodyTxt = $loadSalesPay -> getBodyTxt();
$headerSize = $loadSalesPay -> getHeaderSize();
$headerColor = $loadSalesPay -> getHeaderColor();
$bodySize = $loadSalesPay -> getBodySize();
$bodyColor = $loadSalesPay -> getBodyColor();
$promoLink = $loadSalesPay -> getPromoLink();*/

//sets up the varibles for the form template
$submit_link = 'editWebsiteLocationsPage.php';
$submit_name = 'update';
$submit_title = "Update Website Locations Options";
$page_title  = 'Website Locations Options';
$javaScript1 = "<script type=\"text/javascript\" src=\"webScripts/websiteLocationsPageSetup.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"webScripts/helpTxtLocationsPageSetup.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"webScripts/helpPops.js\"></script>";


/*include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(26);
$info_text = $getText -> createTextInfo();

include "../templates/infoTemplate2.php";*/

//echo"fubar 2";
include "webTemplates/websiteLocationsPageTemplate.php";

?>