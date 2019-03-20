<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(52);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";


$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtContractHtml.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/createHtmlContracts.js\"></script>";

//print out the search form
include "../templates/loadHtmlContractsTemplate.php";

?>