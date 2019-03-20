<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}



//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(33);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";

$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTextTimeClock.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";



//print out the search form
include "../templates/salespersonListTemplate2.php";

?>