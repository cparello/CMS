<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];
$early_header = $_REQUEST['early_header'];
$early_txt = $_REQUEST['early_txt'];
$grace_header = $_REQUEST['grace_header'];
$grace_txt = $_REQUEST['grace_txt'];
$general_header = $_REQUEST['general_header '];
$general_txt = $_REQUEST['general_txt'];


include "invoiceRenewalSql.php";

if($marker == 1) {

$updateInvoice = new invoiceRenewalSql();
$updateInvoice-> setEarlyHeader($early_header);
$updateInvoice-> setEarlyTxt($early_txt);
$updateInvoice-> setGraceHeader($grace_header);
$updateInvoice-> setGraceTxt($grace_txt);
$updateInvoice-> setGeneralHeader($general_header);
$updateInvoice-> setGeneralTxt($general_txt);
$updateInvoice-> updateInvoiceOptions();

$confirmation = 'onLoad="confirmUpdate();"';

}


$loadInvoice = new invoiceRenewalSql();
$loadInvoice-> loadInvoiceRenewalOptions();
$early_header = $loadInvoice-> getEarlyHeader();
$early_txt = $loadInvoice-> getEarlyTxt();
$grace_header = $loadInvoice-> getGraceHeader();
$grace_txt = $loadInvoice-> getGraceTxt();
$general_header = $loadInvoice-> getGeneralHeader();
$general_txt = $loadInvoice-> getGeneralTxt();

$early_txt = trim($early_txt);
$grace_txt = trim($grace_txt);
$general_txt = trim($general_txt);


//print out the search form
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(54);
$info_text = $getText -> createTextInfo();
$javaScript1="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtInvoices.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/editInvoiceRenewal.js\"></script>";


include "../templates/infoTemplate2.php";
include "../templates/editInvoiceRenewalTemplate.php";



?>