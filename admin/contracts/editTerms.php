<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];
$terms_conditions = $_REQUEST['terms_conditions'];
$contract_quit = $_REQUEST['contract_quit'];

include "termsSql.php";

$terms_conditions = trim($terms_conditions);


//sets up the varibles for the form template
$submit_link = 'editTerms.php';
$submit_name = 'update';
$submit_title = "Update Terms";
$page_title  = 'Edit Contract Terms';
$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/terms.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtTerms.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";


//if form is submitted save to database
if ($marker == 1) {
$updateTerms = new termsSql();
$updateTerms -> setTermsConditions($terms_conditions);
$updateTerms -> setContractQuit($contract_quit);
$error_message = $updateTerms -> updateTerms();

$errorHtml = "<span class=\"errors\">$error_message</span>";

if($error_messager == null)  {
$errorHtml = null;
$confirmation = $updateTerms->getConfirmation();
}
}


//load the form content
$loadTerms = new TermsSql();
$loadTerms -> loadTerms();
$terms_conditions = $loadTerms -> getTermsConditions();
$contract_quit = $loadTerms -> getContractQuit();


include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(22);
$info_text = $getText -> createTextInfo();

include "../templates/infoTemplate2.php";
include "../templates/termsTemplate.php";




?>
