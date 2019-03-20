<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


include "nonMemberClassOptions.php";
$overtime = new classOptions();
$overtime-> loadNonMemOptions();
$quan1 = $overtime-> getQuan1();
$price1 = $overtime-> getPrice1();
$quan2 = $overtime-> getQuan2();
$price2 = $overtime-> getPrice2();
$quan3 = $overtime-> getQuan3();
$price3 = $overtime-> getPrice3();
$quan4 = $overtime-> getQuan4();
$price4 = $overtime-> getPrice4();
    

//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(59);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";


$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtOtOptions.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/saveNonMemberClassOptions.js\"></script>";

//print out the search form
include "../templates/nonMemberOptionsTemplate.php";

?>