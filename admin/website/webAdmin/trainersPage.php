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

$stmt = $dbMain ->prepare("SELECT bundle_id, type_id FROM bundle_type WHERE location_id = '$location' AND bundle_name LIKE '%Train%'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($bundle_id, $type_id);
$stmt->fetch();
$stmt->close();

//echo "l $location  b $bundle_id  t $type_id";
//exit;

$stmt = $dbMain ->prepare("SELECT instructor_id, instructor_name, instructor_description, instructor_photo FROM instructor_info WHERE type_id = '$type_id'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($instructor_id, $instructor_name, $instructor_description, $instructor_photo);
while($stmt->fetch()){
    if($instructor_name != ""){
        $html .= "<div id=\"classDescription\" class=\"classDescription gymBox\">
                    <div class=\"empPhoto float-r\">
                         <img src=\"../../instructorphotos/$instructor_photo\" alt=\"Smiley face\" height=\"125\" width=\"125\"> 
                    </div>
                    <p class=\"className\">$instructor_name</p>
                    <p class=\"classText\">$instructor_description</p>
                    </div><br>";
    }
}
$stmt->close();


    



include "webTemplates/trainersPageTemplate.php";
?>