<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//unset the contract key
if (isset($_SESSION['contract_key']))  {
   unset($_SESSION['contract_key']);
}

//print out the search form
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(31);
$info_text = $getText -> createTextInfo();
$javaScript1="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtCollectible.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/accountsCollectible.js\"></script>";

include "../templates/infoTemplate2.php";
include "../templates/accountsCollectibleTemplate.php";



?>