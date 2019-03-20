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



$stmt = $dbMain ->prepare("SELECT green1, green2, green3 FROM website_green_info WHERE web_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($green1, $green2, $green3);
$stmt->fetch();
$stmt->close();

        $html = "<div id=\"classDescription\" class=\"classDescription gymBox\">
                    <p class=\"className\">Contracts</p>
                    <p class=\"classText\">$green1</p>
                    <br>
                    <p class=\"className\">Attendance</p>
                    <p class=\"classText\">$green2</p>
                    <br>
                    <p class=\"className\">Guest Passes</p>
                    <p class=\"classText\">$green3</p>
                    </div><br>";




    



include "webTemplates/greenCompanyPageTemplate.php";
?>