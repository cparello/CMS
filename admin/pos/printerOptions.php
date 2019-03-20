<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

include"printFormat.php";
$marker = $_REQUEST['marker'];
$receipt_format = $_REQUEST['receipt_format'];

if($marker == 1) {

   $update = new printFormat();
   $update-> setReceiptFormat($receipt_format);
   $update-> updatePrintType();
   $confirmation = $update-> getConfirmation();

  }


//--------------------------------------------------------------
$loadOptions = new printFormat();
$loadOptions->loadPrintOptions();
$receiptSelected = $loadOptions->getReceiptSelected();
$letterSelected = $loadOptions->getLetterSelected();

//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(53);
$info_text = $getText-> createTextInfo();
include "../templates/infoTemplate2.php";

$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/helpTxtPos.js\"></script>";
$javaScript2 = "<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript3 = "<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript4 = "<script type=\"text/javascript\" src=\"../scripts/pullConf.js\"></script>";

//print out  form
include "../templates/printerOptionsTemplate.php";



?>