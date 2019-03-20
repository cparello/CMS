<?php
session_start();

$location = $_REQUEST['location'];


include"../../dbConnect.php";
include"loadStuff.php";
include"loadWebsitePreferences.php";
include "loadCart.php";

include "webLogCheck.php";
$logCheck = new loginCheck();
$logCheck-> setButtonColor($middleButtons);
$logCheck-> checkLogin();
$logHtml = $logCheck-> getLogHtml();

$stmt = $dbMain ->prepare("SELECT box_color, text_color FROM website_membership_options WHERE web_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($boxColor, $textColor);
$stmt->fetch();
$stmt->close();


$stmt = $dbMain ->prepare("SELECT mission_statement, motto FROM website_company_mission WHERE web_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($mission_statement, $motto);
$stmt->fetch();
$stmt->close();

        $html = "<div id=\"classDescription\" class=\"classDescription gymBox\">
                    <div class=\"empPhoto float-r\">
                         <img src=\"/admin/images/contract_logo.png\" alt=\"Smiley face\" height=\"125\" width=\"200\"> 
                    </div>
                    <center><p class=\"className\">Mission</p></center>
                    <br>
                    <p class=\"classText\">$mission_statement</p>
                    </div><br>";
   



    



include "webTemplates/companyMissionPageTemplate.php";
?>