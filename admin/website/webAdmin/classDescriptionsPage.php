<?php
session_start();

$name = $_REQUEST['name'];
$description = $_REQUEST['description'];
$descriptionList = $_REQUEST['descriptionList'];
$catName = $_REQUEST['catName'];

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

if(!isset($descriptionList)){
    $html = " <center><h2>$catName</h2></center>
              <div id=\"classDescription\" class=\"classDescription gymBox\">
              <p class=\"className\">$name</p>
              <p class=\"classText\">$description</p>
              </div><br>";
}else{
    $descripArray = explode('@',$descriptionList);
    $html .= "<center><h2>$catName</h2></center>";
    foreach($descripArray as $descripList){
        $detailsArray = explode(',',$descripList);
        $name = $detailsArray[0];
        $descrip = $detailsArray[1];
        $bunId = $detailsArray[2];
        
        if($name != ""){
            $html .= "<div id=\"classDescription\" class=\"classDescription gymBox\">
                <p class=\"className\">$name</p>
                <p class=\"classText\">$descrip</p>
                </div><br>";
        }
        
    }
}


include "webTemplates/classDescriptionsPageTemplate.php";
?>