<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}



$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/helpTxtCycles.js\"></script>";
$javaScript2 = "<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javascript3 = "";


include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(84);
$info_text = $getText -> createTextInfo();

include "../templates/infoTemplate2.php";
include "../templates/reportsBillingTemplate.php";

?>