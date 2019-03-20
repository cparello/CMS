<?php
session_start();

$location = $_REQUEST['location'];


include"../../dbConnect.php";
include"loadStuff.php";
include"loadWebsitePreferences.php";

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


$stmt = $dbMain ->prepare("SELECT name, message, description, photo FROM website_owner_info WHERE web_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($name, $message, $description, $photo);
$stmt->fetch();
$stmt->close();

        $html = "<div id=\"classDescription\" class=\"classDescription gymBox\">
                    <div class=\"empPhoto float-r\">
                         <img src=\"pictures/$photo\" alt=\"Smiley face\" height=\"125\" width=\"125\"> 
                    </div>
                    <p class=\"className\">Owners Message to the Members</p>
                    <br>
                    <p class=\"classText\">$message</p>
                    <br>
                    <p class=\"className\">About The Owner</p>
                    <br>
                    <p class=\"classText\">$description</p>
                    </div><br>";
  



    



include "webTemplates/ownerInfoPageTemplate.php";
?>