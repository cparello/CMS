<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

include "expiredEnrollSql.php";

if($marker == 1) {

$updateER = new expiredEnrollSql();
$updateER-> setERHeader($er_header);
$updateER-> setERTxtOne($er_txt_one);
$updateER-> setERTxtTwo($er_txt_two);
$updateER-> setTermType($st);
$updateER-> updateEROptions();

$confirmation = 'onLoad="confirmUpdate();"';

}


$expiredEnroll = new expiredEnrollSql();
$expiredEnroll-> loadExpiredEnrollOptions();
$er_header = $expiredEnroll-> getERHeader();
$er_txt_one = $expiredEnroll-> getERTxtOne();
$er_txt_two = $expiredEnroll-> getERTxtTwo();
$er_term_types = $expiredEnroll-> getTermTypeHtml();

$er_txt_one = trim($er_txt_one);
$er_txt_one = trim($er_txt_one);



//print out the search form
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(56);
$info_text = $getText -> createTextInfo();
$javaScript1="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtInvoices.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/editExpiredEnroll.js\"></script>";


include "../templates/infoTemplate2.php";
include "../templates/editExpiredEnrollTemplate.php";



?>