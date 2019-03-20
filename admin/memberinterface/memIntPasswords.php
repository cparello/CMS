<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


$all_select =1;
include "../clubs/clubDrops.php";
$clubDrops = new clubDrops();
$clubDrops -> setAllSelect($all_select);
$drop_menu = $clubDrops -> loadMenu(); 

 //this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(40);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";

$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript2 = "<script type=\"text/javascript\" src=\"../scripts/parseMemIntPasswords.js\"></script>";



include "../templates/memIntPasswordsTemplate.php";































?>