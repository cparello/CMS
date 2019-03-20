<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];
$gen_bit = $_REQUEST['gen_bit'];
$month_bit = $_REQUEST['month_bit'];

include "paymentOptionsSql.php";
$g = 'G';
$m = 'M';

if($marker == 1)  {
//set the general options
$set_permissions = new paymentOptionsSql();
$set_permissions->setOptionType($g);
$set_permissions->setOptionPerms($gen_bit);
$set_permissions->updateOptionPerms();

//set the monthly options
$set_permissions->setOptionType($m);
$set_permissions->setOptionPerms($month_bit);
$set_permissions->updateOptionPerms();

$confirmation = $set_permissions->getConfirmationMessage();
}


$get_permissions = new paymentOptionsSql();
//first set the pay type first get the general perms
$get_permissions->setOptionType($g);
$get_permissions->loadOptionPerms();
$get_permissions->loadOptionsChecked();
$cash_checked1 = $get_permissions->getCashChecked();
$check_checked1 = $get_permissions->getCheckChecked();
$credit_checked1 = $get_permissions->getCreditChecked();
$ach_checked1 = $get_permissions->getAchChecked();

//now get the monthly options
$get_permissions->setOptionType($m);
$get_permissions->loadOptionPerms();
$get_permissions->loadOptionsChecked();
$cash_checked2 = $get_permissions->getCashChecked();
$check_checked2 = $get_permissions->getCheckChecked();
$credit_checked2 = $get_permissions->getCreditChecked();
$ach_checked2 = $get_permissions->getAchChecked();




//sets up the varibles for the form template
$submit_link = 'editPaymentOptions.php';
$submit_name = 'save';
$page_title  = 'Edit Payment Options';
$file_permissions = "";
$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtPaymentOptions.js\"></script>";
$javaScript3 = "<script type=\"text/javascript\" src=\"../scripts/paymentOptions.js\"></script>";


include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(24);
$info_text = $getText -> createTextInfo();

include "../templates/infoTemplate2.php";
include "../templates/paymentOptionsTemplate.php";
?>