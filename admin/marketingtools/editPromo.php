<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];
$header = $_REQUEST['header'];
$emailTxt = $_REQUEST['emailTxt'];
$smsTxt = $_REQUEST['smsTxt'];

include "promoSql.php";
//echo "marker $marker";
if($marker == 1) {

$updatePromo = new promoSql();
$updatePromo-> setHeader($header);
$updatePromo-> setEmailTxt($emailTxt);
$updatePromo-> setSmsText($smsTxt);
$updatePromo-> updatePromoOptions();

$confirmation = 'onLoad="confirmUpdate();"';

}


$promo = new promoSql();
$promo-> loadPromoOptions();
$header = $promo-> getHeader();
$emailTxt = $promo-> getEmailTxt();
$smsTxt = $promo-> getSmsTxt();

//print out the search form
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(56);
$info_text = $getText -> createTextInfo();
$javaScript1="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtPromo.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/editPromo.js\"></script>";


include "../templates/infoTemplate2.php";
include "../templates/editPromoTemplate.php";



?>